<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class StudentQuestionController extends Controller
{
    public function answer($id, Request $request)
    {
        $question = \App\Models\Question::with('questionType', 'subject')->findOrFail($id);
        
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
        
        // Determine if this is a test or course question
        $isTest = $request->input('is_test', false);
        
        // Always allow re-attempt, reset all previous answer checks
        $editMode = true;
        $studentAnswer = null;
        $isReAttempt = true;
        
        return view('filament.student.pages.answer-question', compact(
            'question', 
            'studentAnswer', 
            'editMode', 
            'isReAttempt'
        ));
    }

    public function submitAnswer(Request $request, $id)
    {
        // Extensive logging for debugging
        \Log::info('Submit Answer Request', [
            'route_name' => $request->route()->getName(),
            'route_parameters' => $request->route()->parameters(),
            'all_input' => $request->all(),
            'id' => $id
        ]);
        
        $question = \App\Models\Question::with('questionType', 'subject')->findOrFail($id);
        
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
        
        // Normalize re-attempt flag
        $isReAttempt = filter_var($request->input('is_reattempt', false), FILTER_VALIDATE_BOOLEAN);
        
        // Identify question type
        $questionType = $question->questionType->name ?? '';
        $isSpeakingSubject = $question->subject && strtolower($question->subject->name) === 'speaking';
        $isOpinionQuestion = $questionType === 'opinion';
        
        // Validation rules
        $validationRules = $this->getValidationRules($questionType, $isSpeakingSubject);
        
        // Validate the request
        $data = $request->validate($validationRules, $this->getValidationMessages());
        
        // Normalize answer data
        $studentAnswer = $this->normalizeAnswer($questionType, $data['answer'] ?? null);
        
        // Handle file upload for speaking/opinion questions
        $fileUploadPath = $this->handleFileUpload($request, $isOpinionQuestion, $isSpeakingSubject);
        
        // Evaluate the answer
        $isCorrect = $this->evaluateAnswer($question, $studentAnswer);
        $result = $this->getAnswerResult($question, $studentAnswer, $isCorrect);
        
        // Prepare answer data for storage
        $answerData = [
            'answer_data' => json_encode($studentAnswer),
            'is_correct' => $isCorrect,
            'submitted_at' => now(),
            'updated_at' => now(),
            'created_at' => now(),
            'is_reattempt' => $isReAttempt,
        ];

        // Add file upload path if exists
        if ($fileUploadPath) {
            $answerData['file_upload'] = $fileUploadPath;
        }

        // For opinion questions, set verification status to pending
        if ($isOpinionQuestion) {
            $answerData['verification_status'] = 'pending';
        }

        // Save or update the answer
        \DB::table('student_answers')->updateOrInsert(
            [
                'user_id' => $user->id,
                'question_id' => $question->id,
            ],
            $answerData
        );

        // For opinion questions, redirect to questions page
        if ($isOpinionQuestion) {
            return redirect()->route('filament.student.pages.questions', [
                'course_id' => $question->course_id,
                'subject_id' => $question->subject_id,
                'day_id' => $question->day_id,
            ])->with([
                'success' => $result['message'],
                'info' => 'Your opinion has been submitted and is awaiting verification by your teacher.',
            ]);
        }
        
        // For other question types, return back with result data
        return redirect()->back()->with([
            'answer_result' => $result,
            'question_id' => $question->id,
            'course_id' => $question->course_id,
            'subject_id' => $question->subject_id,
            'day_id' => $question->day_id,
            'is_reattempt' => $isReAttempt,
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
                $result['student_answer_text'] = $studentIndices[0] !== -1 ? 
                    (isset($options[$studentIndices[0]]) ? $options[$studentIndices[0]] : '(No answer provided)') : 
                    '(No answer provided)';
                $result['correct_answer_text'] = array_map(function($index) use ($options) {
                    return $options[$index] ?? '';
                }, $correctIndices);
                break;
                
            case 'true_false':
                $correctAnswer_tf = $correctAnswerData['correct_answer'] ?? '';
                $studentAnswer_tf = is_array($studentAnswer) ? ($studentAnswer[0] ?? '') : $studentAnswer;
                
                $result['correct_answer'] = $correctAnswer_tf;
                $result['student_answer_text'] = $studentAnswer_tf ?: '(No answer provided)';
                $result['correct_answer_text'] = $correctAnswer_tf;
                break;

            case 'mcq_multiple':
                $subQuestions = $questionData['sub_questions'] ?? [];
                $studentAnswers = is_array($studentAnswer) ? $studentAnswer : [];
                
                $result['correct_answer'] = $correctAnswerData;
                
                // Format student answers with text
                $studentAnswerText = [];
                foreach ($subQuestions as $subIndex => $subQuestion) {
                    $options = $subQuestion['options'] ?? [];
                    $studentSubAnswers = $studentAnswers[$subIndex] ?? [];
                    
                    $subAnswerText = array_map(function($optIndex) use ($options) {
                        return $options[$optIndex] ?? "Option $optIndex";
                    }, $studentSubAnswers);
                    
                    $studentAnswerText[] = $subAnswerText ? implode(', ', $subAnswerText) : '(No answer)';
                }
                
                $result['student_answer_text'] = $studentAnswerText;
                
                // Format correct answers with text
                $correctAnswerText = [];
                foreach ($subQuestions as $subIndex => $subQuestion) {
                    $options = $subQuestion['options'] ?? [];
                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                    
                    $correctSubAnswerText = array_map(function($optIndex) use ($options) {
                        return $options[$optIndex] ?? "Option $optIndex";
                    }, $correctIndices);
                    
                    $correctAnswerText[] = $correctSubAnswerText ? implode(', ', $correctSubAnswerText) : '(No correct answer)';
                }
                
                $result['correct_answer_text'] = $correctAnswerText;
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
                $result['student_answer_text'] = $studentSequence ?: '(No answer provided)';
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
                    $leftText = $leftOptions[$pair['left']] ?? "Item " . ($pair['left'] + 1);
                    $rightText = $rightOptions[$pair['right']] ?? "Option " . ($pair['right'] + 1);
                    $correctAnswerText[] = "$leftText → $rightText";
                }
                
                $result['correct_answer_text'] = $correctAnswerText;
                break;
        }

        return $result;
    }

    // Helper method to get validation rules
    private function getValidationRules($questionType, $isSpeakingSubject)
    {
        $rules = [];
        
        switch ($questionType) {
            case 'mcq_single':
                $rules = ['answer' => 'required|numeric'];
                break;
            case 'true_false':
                $rules = ['answer' => 'required|in:true,false'];
                break;
            case 'mcq_multiple':
                $rules = ['answer' => 'required|array'];
                break;
            case 'true_false_multiple':
                $rules = ['answer' => 'required|array'];
                break;
            case 'form_fill':
                $rules = ['answer' => 'required|array'];
                break;
            case 'opinion':
                $rules = [
                    'answer' => $isSpeakingSubject ? 'nullable' : 'required_without:audio_video_file',
                    'audio_video_file' => $isSpeakingSubject 
                        ? 'nullable|file|mimes:mp3,wav,mp4,webm,ogg,m4a|max:51200' 
                        : 'nullable'
                ];
                break;
            default:
                $rules = ['answer' => 'required'];
        }
        
        return $rules;
    }

    // Helper method to get validation error messages
    private function getValidationMessages()
    {
        return [
            'answer.required' => 'Please select an answer.',
            'answer.numeric' => 'Please select a valid option.',
            'answer.in' => 'Please select either True or False.',
            'answer.array' => 'Please provide a valid answer.',
            'audio_video_file.max' => 'The file must not exceed 50MB.',
            'audio_video_file.mimes' => 'The file must be an audio or video file.',
            'answer.required_without' => 'Please provide either a written or audio/video response.'
        ];
    }

    // Normalize answer data based on question type
    private function normalizeAnswer($questionType, $answer)
    {
        if ($answer === null) {
            return null;
        }
        
        // Ensure array for multi-answer types
        $multiTypes = ['mcq_multiple', 'true_false_multiple', 'form_fill', 'reorder', 'statement_match'];
        
        if (in_array($questionType, $multiTypes)) {
            return is_array($answer) ? $answer : [$answer];
        }
        
        // Single answer types
        return is_array($answer) ? (count($answer) === 1 ? $answer[0] : $answer) : $answer;
    }

    // Handle file upload for speaking/opinion questions
    private function handleFileUpload($request, $isOpinionQuestion, $isSpeakingSubject)
    {
        $fileUploadPath = null;
        
        if ($isOpinionQuestion && $isSpeakingSubject) {
            // For speaking questions, require either file upload or written answer (or both)
            if (!$request->hasFile('audio_video_file') && empty($request->input('answer'))) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'answer' => 'For speaking questions, please provide either an audio/video response or a written answer (or both).'
                ]);
            }
            
            if ($request->hasFile('audio_video_file')) {
                $file = $request->file('audio_video_file');
                $fileUploadPath = $file->store('speaking_responses', 'public');
            }
        }
        
        return $fileUploadPath;
    }
}