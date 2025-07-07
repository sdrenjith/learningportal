<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class StudentQuestionController extends Controller
{
    public function answer($id, Request $request)
    {
        $question = Question::findOrFail($id);
        
        // Check if student has access to this course through their batch
        $user = auth()->user();
        $assignedCourseIds = $user->assignedCourses()->pluck('id')->toArray();
        $assignedDayIds = $user->assignedDays()->pluck('id')->toArray();
        
        if (!in_array($question->course_id, $assignedCourseIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this course. Please contact your administrator.');
        }
        
        if (!in_array($question->day_id, $assignedDayIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this day. Please contact your administrator.');
        }
        
        // Always show fresh form for re-attempts - don't load previous answers
        $studentAnswer = null;
        $editMode = false;
        return view('filament.student.pages.answer-question', compact('question', 'studentAnswer', 'editMode'));
    }

    public function submitAnswer(Request $request, $id)
    {
        $question = \App\Models\Question::with('questionType')->findOrFail($id);
        
        // Check if student has access to this course and day through their batch
        $user = auth()->user();
        $assignedCourseIds = $user->assignedCourses()->pluck('id')->toArray();
        $assignedDayIds = $user->assignedDays()->pluck('id')->toArray();
        
        if (!in_array($question->course_id, $assignedCourseIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this course. Please contact your administrator.');
        }
        
        if (!in_array($question->day_id, $assignedDayIds)) {
            return redirect()->route('filament.student.pages.courses')
                ->with('error', 'You do not have access to this day. Please contact your administrator.');
        }
        
        $data = $request->except(['_token']);
        $studentAnswer = $data['answer'] ?? $data;
        

        
        // Evaluate the answer
        $isCorrect = $this->evaluateAnswer($question, $studentAnswer);
        $result = $this->getAnswerResult($question, $studentAnswer, $isCorrect);
        
        // Save answer
        $wasUpdated = \DB::table('student_answers')->where('user_id', $user->id)->where('question_id', $question->id)->exists();
        \DB::table('student_answers')->updateOrInsert(
            [
                'user_id' => $user->id,
                'question_id' => $question->id,
            ],
            [
                'answer_data' => json_encode($studentAnswer),
                'is_correct' => $isCorrect,
                'submitted_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Return back to the answer page with result data for modal
        return redirect()->back()->with([
            'answer_result' => $result,
            'question_id' => $question->id,
            'course_id' => $question->course_id,
            'subject_id' => $question->subject_id,
            'day_id' => $question->day_id,
        ]);
    }

    private function evaluateAnswer($question, $studentAnswer)
    {
        $correctAnswer = is_string($question->answer_data) ? json_decode($question->answer_data, true) : $question->answer_data;
        $questionType = $question->questionType->name ?? '';

        switch ($questionType) {
            case 'mcq_single':
                $correctIndices = $correctAnswer['correct_indices'] ?? [];
                $studentIndex = is_array($studentAnswer) ? (int)($studentAnswer[0] ?? -1) : (int)$studentAnswer;
                return in_array($studentIndex, $correctIndices);
                
            case 'true_false':
                $correctAnswer_tf = $correctAnswer['correct_answer'] ?? '';
                $studentAnswer_tf = is_array($studentAnswer) ? ($studentAnswer[0] ?? '') : $studentAnswer;
                return strtolower(trim($correctAnswer_tf)) === strtolower(trim($studentAnswer_tf));

            case 'mcq_multiple':
                $questionData = is_string($question->question_data) ? json_decode($question->question_data, true) : ($question->question_data ?? []);
                $subQuestions = $questionData['sub_questions'] ?? [];
                $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                
                $allCorrect = true;
                foreach ($subQuestions as $subIndex => $subQuestion) {
                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                    $studentIndices = isset($studentAnswers[$subIndex]) ? array_map('intval', $studentAnswers[$subIndex]) : [];
                    
                    sort($correctIndices);
                    sort($studentIndices);
                    
                    if ($correctIndices !== $studentIndices) {
                        $allCorrect = false;
                        break;
                    }
                }
                
                return $allCorrect;

            case 'form_fill':
            case 'audio_fill_blank':
            case 'picture_fill_blank':
            case 'video_fill_blank':
                $correctAnswers = $correctAnswer['answer_keys'] ?? [];
                $studentAnswers = is_array($studentAnswer) ? array_values($studentAnswer) : [$studentAnswer];
                
                if (count($correctAnswers) !== count($studentAnswers)) {
                    return false;
                }
                
                for ($i = 0; $i < count($correctAnswers); $i++) {
                    if (strtolower(trim($correctAnswers[$i])) !== strtolower(trim($studentAnswers[$i] ?? ''))) {
                        return false;
                    }
                }
                return true;

            case 'reorder':
                $questionData = is_string($question->question_data) ? json_decode($question->question_data, true) : ($question->question_data ?? []);
                $fragments = $question->reorder_fragments ?? $questionData['fragments'] ?? [];
                $correctSentence = $question->reorder_answer_key ?? '';
                
                // Parse student answer (numeric indices like "1,2,3,4")
                $studentOrder = is_array($studentAnswer) ? implode('', $studentAnswer) : $studentAnswer;
                $studentOrder = str_replace([',', ' '], '', trim($studentOrder));
                
                // Convert student's numeric order to actual text sequence
                $studentSequence = '';
                if (!empty($fragments)) {
                    $studentFragments = [];
                    for ($i = 0; $i < strlen($studentOrder); $i++) {
                        $index = (int)$studentOrder[$i] - 1; // Convert to 0-based
                        if (isset($fragments[$index])) {
                            $studentFragments[] = $fragments[$index];
                        }
                    }
                    $studentSequence = implode(' ', $studentFragments);
                }
                
                // Compare the student's reconstructed sentence with the correct sentence
                // Normalize by removing extra spaces, punctuation differences, and converting to lowercase
                $studentNormalized = preg_replace('/[^\w\s]/u', '', preg_replace('/\s+/', ' ', strtolower(trim($studentSequence))));
                $correctNormalized = preg_replace('/[^\w\s]/u', '', preg_replace('/\s+/', ' ', strtolower(trim($correctSentence))));
                
                return $studentNormalized === $correctNormalized;

            case 'statement_match':
                $correctPairs = $question->correct_pairs ?? [];
                $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                

                
                // Convert student answers to pairs format for comparison  
                $studentPairs = [];
                foreach ($studentAnswers as $leftIndex => $rightIndex) {
                    if (!empty($rightIndex) && is_numeric($rightIndex)) {
                        $studentPairs[] = [
                            'left' => (int)$leftIndex,
                            'right' => (int)$rightIndex - 1 // Convert 1-based to 0-based
                        ];
                    }
                }
                

                
                // Check if all correct pairs match student pairs
                $allCorrect = true;
                foreach ($correctPairs as $correctPair) {
                    $found = false;
                    foreach ($studentPairs as $studentPair) {
                        if ($studentPair['left'] === $correctPair['left'] && 
                            $studentPair['right'] === $correctPair['right']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $allCorrect = false;
                    }
                }
                
                // Also check if student made extra incorrect matches
                if (count($studentPairs) !== count($correctPairs)) {
                    $allCorrect = false;
                }
                
                return $allCorrect;

            case 'audio_picture_match':
                $correctPairs = $correctAnswer['correct_pairs'] ?? [];
                $studentPairs = is_array($studentAnswer) ? $studentAnswer : [];
                
                // Check if all required matches are made
                $allMatched = true;
                foreach ($correctPairs as $correctPair) {
                    $leftIndex = $correctPair['left'] ?? '';
                    $rightIndex = $correctPair['right'] ?? '';
                    
                    if (!isset($studentPairs[$leftIndex]) || $studentPairs[$leftIndex] != $rightIndex) {
                        $allMatched = false;
                        break;
                    }
                }
                
                return $allMatched;

            case 'picture_mcq':
            case 'audio_image_text_single':
            case 'audio_image_text_multiple':
                $correctPairs = $correctAnswer['correct_pairs'] ?? [];
                $studentPairs = is_array($studentAnswer) ? $studentAnswer : [];
                
                // Check if all required matches are made
                $allMatched = true;
                foreach ($correctPairs as $correctPair) {
                    $leftIndex = $correctPair['left'] ?? '';
                    $rightIndex = $correctPair['right'] ?? '';
                    
                    if (!isset($studentPairs[$leftIndex]) || $studentPairs[$leftIndex] != $rightIndex) {
                        $allMatched = false;
                        break;
                    }
                }
                
                return $allMatched;

            case 'audio_mcq_single':
                // Audio MCQ works like mcq_multiple with sub-questions
                $questionData = is_string($question->question_data) ? json_decode($question->question_data, true) : ($question->question_data ?? []);
                $subQuestions = $questionData['sub_questions'] ?? $correctAnswer['sub_questions'] ?? [];
                $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                
                $allCorrect = true;
                foreach ($subQuestions as $subIndex => $subQuestion) {
                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                    $studentIndex = isset($studentAnswers[$subIndex]) ? (int)$studentAnswers[$subIndex] : -1;
                    
                    if (!in_array($studentIndex, $correctIndices)) {
                        $allCorrect = false;
                        break;
                    }
                }
                
                return $allCorrect;

            case 'true_false_multiple':
                // Get correct answers from the answer_data structure
                $correctAnswerData = is_string($question->answer_data) ? json_decode($question->answer_data, true) : ($question->answer_data ?? []);
                $questionData = is_string($question->question_data) ? json_decode($question->question_data, true) : ($question->question_data ?? []);
                
                // The correct answers are stored in answer_data as 'true_false_answers', not 'questions'
                $correctAnswers = $correctAnswerData['true_false_answers'] ?? 
                                $question->true_false_questions ?? 
                                $questionData['questions'] ?? 
                                [];
                
                $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                

                
                // Check if we have correct answers and student answers
                if (empty($correctAnswers) || empty($studentAnswers)) {
                    return false;
                }
                
                // Check if we have answers for all questions
                if (count($correctAnswers) !== count($studentAnswers)) {
                    return false;
                }
                
                $allCorrect = true;
                foreach ($correctAnswers as $qIndex => $correctAnswerItem) {
                    // Handle correct answer - check different possible structures
                    $correctAnswer_tf = '';
                    if (is_array($correctAnswerItem)) {
                        $correctAnswer_tf = $correctAnswerItem['correct_answer'] ?? 
                                          $correctAnswerItem['answer'] ?? 
                                          '';
                    } else {
                        $correctAnswer_tf = $correctAnswerItem;
                    }
                    
                    $studentAnswer_tf = $studentAnswers[$qIndex] ?? '';
                    
                    // If student answer is empty/null, it's incorrect
                    if (empty($studentAnswer_tf)) {
                        $allCorrect = false;
                        break;
                    }
                    
                    if (strtolower(trim($correctAnswer_tf)) !== strtolower(trim($studentAnswer_tf))) {
                        $allCorrect = false;
                        break;
                    }
                }
                
                return $allCorrect;

            case 'opinion':
                // Opinion questions are always correct (subjective)
                return true;

            default:
                return false;
        }
    }

    private function getAnswerResult($question, $studentAnswer, $isCorrect)
    {
        $result = [
            'is_correct' => $isCorrect,
            'message' => $isCorrect ? 'Correct Answer!' : 'Wrong Answer!',
            'student_answer' => $studentAnswer,
            'correct_answer' => null,
            'student_answer_text' => null,
            'correct_answer_text' => null,
        ];

        $questionType = $question->questionType->name ?? '';
        $questionData = is_string($question->question_data) ? json_decode($question->question_data, true) : ($question->question_data ?? []);
        $correctAnswerData = is_string($question->answer_data) ? json_decode($question->answer_data, true) : ($question->answer_data ?? []);

        switch ($questionType) {
            case 'mcq_single':
                $options = $questionData['options'] ?? [];
                $correctIndices = $correctAnswerData['correct_indices'] ?? [];
                $studentIndices = is_array($studentAnswer) ? array_map('intval', $studentAnswer) : [(int)$studentAnswer];
                
                $result['correct_answer'] = $correctIndices;
                $result['student_answer_text'] = array_map(function($index) use ($options) {
                    return $options[$index] ?? '';
                }, $studentIndices);
                $result['correct_answer_text'] = array_map(function($index) use ($options) {
                    return $options[$index] ?? '';
                }, $correctIndices);
                break;
                
            case 'mcq_multiple':
                $subQuestions = $questionData['sub_questions'] ?? [];
                $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                
                $result['correct_answer'] = [];
                $result['student_answer_text'] = [];
                $result['correct_answer_text'] = [];
                
                foreach ($subQuestions as $subIndex => $subQuestion) {
                    $options = $subQuestion['options'] ?? [];
                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                    $studentIndices = isset($studentAnswers[$subIndex]) ? array_map('intval', $studentAnswers[$subIndex]) : [];
                    
                    $result['correct_answer'][] = $correctIndices;
                    
                    // Student answers for this sub-question
                    $studentTexts = array_map(function($index) use ($options) {
                        return $options[$index] ?? '';
                    }, $studentIndices);
                    $result['student_answer_text'][] = !empty($studentTexts) ? implode(', ', $studentTexts) : '(No answer provided)';
                    
                    // Correct answers for this sub-question
                    $correctTexts = array_map(function($index) use ($options) {
                        return $options[$index] ?? '';
                    }, $correctIndices);
                    $result['correct_answer_text'][] = !empty($correctTexts) ? implode(', ', $correctTexts) : '';
                }
                break;
                
            case 'true_false':
                $correctAnswer_tf = $correctAnswerData['correct_answer'] ?? '';
                $studentAnswer_tf = is_array($studentAnswer) ? ($studentAnswer[0] ?? '') : $studentAnswer;
                
                $result['correct_answer'] = $correctAnswer_tf;
                $result['student_answer_text'] = ucfirst(strtolower($studentAnswer_tf));
                $result['correct_answer_text'] = ucfirst(strtolower($correctAnswer_tf));
                break;

            case 'form_fill':
            case 'audio_fill_blank':
            case 'picture_fill_blank':
            case 'video_fill_blank':
                $result['correct_answer'] = $correctAnswerData['answer_keys'] ?? [];
                $result['student_answer_text'] = is_array($studentAnswer) ? array_values($studentAnswer) : [$studentAnswer];
                $result['correct_answer_text'] = $correctAnswerData['answer_keys'] ?? [];
                break;

            case 'reorder':
                $fragments = $question->reorder_fragments ?? $questionData['fragments'] ?? [];
                $correctSentence = $question->reorder_answer_key ?? '';
                
                // Parse student order (numeric indices like "1,2,3,4")
                $studentOrder = is_array($studentAnswer) ? implode('', $studentAnswer) : $studentAnswer;
                $studentOrder = str_replace([',', ' '], '', trim($studentOrder));
                
                // Convert student's numeric order to actual text sequence
                $studentSequence = '';
                if (!empty($fragments)) {
                    $studentFragments = [];
                    for ($i = 0; $i < strlen($studentOrder); $i++) {
                        $index = (int)$studentOrder[$i] - 1; // Convert to 0-based
                        if (isset($fragments[$index])) {
                            $studentFragments[] = $fragments[$index];
                        }
                    }
                    $studentSequence = implode(' ', $studentFragments);
                }
                
                // The correct answer is already stored as the complete sentence
                $result['correct_answer'] = $correctSentence;
                $result['student_answer_text'] = $studentSequence ?: $studentOrder;
                $result['correct_answer_text'] = $correctSentence;
                break;

            case 'statement_match':
                $leftOptions = $question->left_options ?? $questionData['left_options'] ?? [];
                $rightOptions = $question->right_options ?? $questionData['right_options'] ?? [];
                $correctPairs = $question->correct_pairs ?? [];
                $studentPairs = is_array($studentAnswer) ? $studentAnswer : [];
                
                $result['correct_answer'] = $correctPairs;
                

                
                // Format student answers - FIXED logic
                $studentAnswerText = [];
                if (!empty($studentPairs)) {
                    // Ensure all left options are represented
                    for ($i = 0; $i < count($leftOptions); $i++) {
                        $leftText = $leftOptions[$i] ?? "Item " . ($i + 1);
                        $rightIndex = $studentPairs[$i] ?? null;
                        
                        if (!empty($rightIndex) && $rightIndex !== '' && is_numeric($rightIndex)) {
                            // Convert 1-based student input to 0-based array index
                            $rightOptionIndex = (int)$rightIndex - 1;
                            $rightText = $rightOptions[$rightOptionIndex] ?? "Option " . $rightIndex;
                            $studentAnswerText[] = "$leftText → $rightText";
                        } else {
                            $studentAnswerText[] = "$leftText → (No selection)";
                        }
                    }
                }
                
                // If no student answers, show empty state
                if (empty($studentAnswerText)) {
                    $studentAnswerText = ['(No answers provided)'];
                }
                
                $result['student_answer_text'] = $studentAnswerText;
                
                // Format correct answers with improved structure
                $correctAnswerText = [];
                foreach ($correctPairs as $pair) {
                    $leftIndex = $pair['left'] ?? 0;
                    $rightIndex = $pair['right'] ?? 0;
                    $leftText = $leftOptions[$leftIndex] ?? "Item " . ($leftIndex + 1);
                    $rightText = $rightOptions[$rightIndex] ?? "Option " . ($rightIndex + 1);
                    $correctAnswerText[] = "$leftText → $rightText";
                }
                $result['correct_answer_text'] = $correctAnswerText;
                break;

                case 'true_false_multiple':
                    // Get correct answers from the answer_data structure (same as evaluation logic)
                    $correctAnswers = $correctAnswerData['true_false_answers'] ?? 
                                    $question->true_false_questions ?? 
                                    $questionData['questions'] ?? 
                                    [];
                    
                    $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                    
                    $result['correct_answer'] = $correctAnswers;
                    

                    
                    // Format student answers and correct answers
                    $studentAnswerText = [];
                    $correctAnswerText = [];
                    
                    if (!empty($correctAnswers)) {
                        foreach ($correctAnswers as $index => $correctAnswerItem) {
                            // Handle student answer
                            $studentAns = '';
                            if (isset($studentAnswers[$index])) {
                                $studentAns = $studentAnswers[$index];
                            }
                            
                            if (empty($studentAns)) {
                                $studentAnswerText[] = '(No answer provided)';
                            } else {
                                $studentAnswerText[] = ucfirst(strtolower(trim($studentAns)));
                            }
                            
                            // Handle correct answer - check different possible structures
                            $correctAns = '';
                            if (is_array($correctAnswerItem)) {
                                $correctAns = $correctAnswerItem['correct_answer'] ?? 
                                            $correctAnswerItem['answer'] ?? 
                                            '';
                            } else {
                                $correctAns = $correctAnswerItem;
                            }
                            
                            $correctAnswerText[] = ucfirst(strtolower(trim($correctAns)));
                        }
                    } else {
                        // Fallback if no correct answers found
                        $studentAnswerText[] = 'No correct answers found in database';
                        $correctAnswerText[] = 'Data structure issue - check database';
                    }
                    
                    $result['student_answer_text'] = $studentAnswerText;
                    $result['correct_answer_text'] = $correctAnswerText;
                    break;

            case 'audio_picture_match':
                $result['correct_answer'] = $correctAnswerData['correct_pairs'] ?? [];
                $result['student_answer_text'] = is_array($studentAnswer) ? $studentAnswer : [];
                $result['correct_answer_text'] = $correctAnswerData['correct_pairs'] ?? [];
                break;

            case 'picture_mcq':
            case 'audio_image_text_single':
            case 'audio_image_text_multiple':
                $result['correct_answer'] = $correctAnswerData['correct_pairs'] ?? [];
                $result['student_answer_text'] = is_array($studentAnswer) ? $studentAnswer : [];
                $result['correct_answer_text'] = $correctAnswerData['correct_pairs'] ?? [];
                break;

            case 'audio_mcq_single':
                $subQuestions = $questionData['sub_questions'] ?? [];
                $result['correct_answer'] = [];
                $result['student_answer_text'] = [];
                $result['correct_answer_text'] = [];
                
                foreach ($subQuestions as $subIndex => $subQuestion) {
                    $options = $subQuestion['options'] ?? [];
                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                    $studentIndex = isset($studentAnswer[$subIndex]) ? (int)$studentAnswer[$subIndex] : -1;
                    
                    $result['correct_answer'][] = $correctIndices;
                    $result['student_answer_text'][] = $studentIndex >= 0 && isset($options[$studentIndex]) ? $options[$studentIndex] : '';
                    $result['correct_answer_text'][] = !empty($correctIndices) && isset($options[$correctIndices[0]]) ? $options[$correctIndices[0]] : '';
                }
                break;

            case 'opinion':
                $result['correct_answer'] = 'Subjective Answer';
                $result['student_answer_text'] = is_array($studentAnswer) ? implode(' ', $studentAnswer) : $studentAnswer;
                $result['correct_answer_text'] = 'Your opinion has been recorded';
                break;
        }

        return $result;
    }
}