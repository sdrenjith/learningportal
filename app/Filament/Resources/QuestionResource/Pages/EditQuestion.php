<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Day;
use App\Models\Level;
use App\Models\Subject;
use App\Models\QuestionType;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class EditQuestion extends Page
{
    protected static string $resource = QuestionResource::class;
    protected static string $view = 'filament.resources.question-resource.pages.edit-custom';

    public $record;
    public $day_id = '';
    public $course_id = '';
    public $subject_id = '';
    public $question_type_id = '';
    public $points = 1;
    public $is_active = true;
    public $instruction = '';
    public $explanation = '';
    public $options = [''];
    public $answer_indices = [0];
    public $day_number_input = 1;
    public $explanation_file;
    public $left_options = [''];
    public $right_options = [''];
    public $correct_pairs = [
        ['left' => '', 'right' => ''],
        ['left' => '', 'right' => ''],
    ];
    public $opinion_answer = '';
    
    // Properties for MCQ Multiple
    public $sub_questions = [
        [
            'question' => '',
            'options' => ['', ''],
            'correct_indices' => [0]
        ]
    ];

    // Properties for True/False Multiple
    public $true_false_questions = [
        [
            'statement' => '',
            'correct_answer' => ''
        ]
    ];

    // Properties for Simple True/False
    public $true_false_statement = '';
    public $true_false_answer = '';

    // Properties for Reorder
    public $reorder_fragments = ['', ''];
    public $reorder_answer_key = '';

    // Properties for Form Fill
    public $form_fill_paragraph = '';
    public $form_fill_options = ['', ''];
    public $form_fill_answer_key = [''];

    public $rules = [
        'left_options' => 'array',
        'left_options.*' => 'string|nullable',
        'right_options' => 'array',
        'right_options.*' => 'string|nullable',
        'correct_pairs' => 'array',
        'correct_pairs.*.left' => 'nullable',
        'correct_pairs.*.right' => 'nullable',
        'opinion_answer' => 'string|nullable',
        // MCQ Multiple validation rules
        'sub_questions' => 'array',
        'sub_questions.*.question' => 'string|nullable',
        'sub_questions.*.options' => 'array',
        'sub_questions.*.options.*' => 'string|nullable',
        'sub_questions.*.correct_indices' => 'array',
        'sub_questions.*.correct_indices.*' => 'integer|nullable',
        // True/False Multiple validation rules
        'true_false_questions' => 'array',
        'true_false_questions.*.statement' => 'string|nullable',
        'true_false_questions.*.correct_answer' => 'string|nullable',
        // Simple True/False validation rules
        'true_false_statement' => 'string|nullable',
        'true_false_answer' => 'string|nullable',
        // Reorder validation rules
        'reorder_fragments' => 'array',
        'reorder_fragments.*' => 'string|nullable',
        'reorder_answer_key' => 'string|nullable',
        // Form Fill validation rules
        'form_fill_paragraph' => 'string|nullable',
        'form_fill_options' => 'array',
        'form_fill_options.*' => 'string|nullable',
        'form_fill_answer_key' => 'array',
        'form_fill_answer_key.*' => 'string|nullable',
    ];

    public function mount($record)
    {
        if (is_string($record)) {
            $record = \App\Models\Question::findOrFail($record);
        }
        $this->record = $record;
        
        // Load basic data
        $this->day_id = $record->day_id;
        $this->course_id = $record->course_id;
        $this->subject_id = $record->subject_id;
        $this->points = $record->points;
        $this->is_active = $record->is_active;
        $this->instruction = $record->instruction;
        $this->explanation = $record->explanation;
        $this->day_number_input = $record->day->day_number ?? 1;

        // Determine question type and set question_type_id
        $questionTypeName = $record->questionType->name ?? '';
        if (in_array($questionTypeName, ['statement_match', 'opinion', 'mcq_multiple', 'true_false_multiple', 'true_false', 'reorder', 'form_fill'])) {
            $this->question_type_id = $questionTypeName;
        } else {
            $this->question_type_id = $record->question_type_id;
        }

        // Load data based on question type
        $this->loadQuestionTypeData($record, $questionTypeName);
    }

    private function loadQuestionTypeData($record, $questionTypeName)
    {
        switch ($questionTypeName) {
            case 'statement_match':
                $this->left_options = $record->left_options ?? [''];
                $this->right_options = $record->right_options ?? [''];
                $this->correct_pairs = $record->correct_pairs ?? [
                    ['left' => '', 'right' => ''],
                    ['left' => '', 'right' => ''],
                ];
                break;

            case 'opinion':
                $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                $this->opinion_answer = $questionData['opinion_answer'] ?? '';
                break;

            case 'mcq_multiple':
                $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                $this->sub_questions = $questionData['sub_questions'] ?? [
                    [
                        'question' => '',
                        'options' => ['', ''],
                        'correct_indices' => [0]
                    ]
                ];
                break;

            case 'true_false_multiple':
                $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                $this->true_false_questions = $questionData['questions'] ?? [
                    [
                        'statement' => '',
                        'correct_answer' => ''
                    ]
                ];
                break;

            case 'true_false':
                $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                $this->true_false_statement = $questionData['statement'] ?? '';
                $answerData = is_string($record->answer_data) ? json_decode($record->answer_data, true) : $record->answer_data;
                $this->true_false_answer = $answerData['correct_answer'] ?? '';
                break;

            case 'reorder':
                // Try direct properties first, then fallback to question_data/answer_data
                $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                $answerData = is_string($record->answer_data) ? json_decode($record->answer_data, true) : $record->answer_data;
                $this->reorder_fragments = $record->reorder_fragments ?? ($questionData['fragments'] ?? ['', '']);
                $this->reorder_answer_key = $record->reorder_answer_key ?? ($answerData['answer_key'] ?? '');
                break;

            case 'form_fill':
                $this->form_fill_paragraph = $record->form_fill_paragraph ?? '';
                $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                $this->form_fill_options = $questionData['options'] ?? ['', ''];
                $answerData = is_string($record->answer_data) ? json_decode($record->answer_data, true) : $record->answer_data;
                $this->form_fill_answer_key = $answerData['answer_keys'] ?? [''];
                break;

            default:
                // Regular MCQ or other types
                if ($record->question_data) {
                    $data = json_decode($record->question_data, true);
                    $this->options = $data['options'] ?? [''];
                }
                if ($record->answer_data) {
                    $data = json_decode($record->answer_data, true);
                    $this->answer_indices = $data['correct_indices'] ?? [0];
                }
                break;
        }
    }

    // File management methods
    public function removeExplanationFile()
    {
        $this->explanation = null;
        $this->record->update(['explanation' => null]);
        
        Notification::make()
            ->title('File removed')
            ->body('Explanation file has been removed.')
            ->success()
            ->send();
    }

    // Basic option methods
    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function addAnswerIndex()
    {
        $this->answer_indices[] = 0;
    }

    public function removeAnswerIndex($index)
    {
        unset($this->answer_indices[$index]);
        $this->answer_indices = array_values($this->answer_indices);
    }

    // Statement match methods
    public function addLeftOption()
    {
        $this->left_options[] = '';
    }

    public function removeLeftOption($index)
    {
        unset($this->left_options[$index]);
        $this->left_options = array_values($this->left_options);
        foreach ($this->correct_pairs as &$pair) {
            if (isset($pair['left']) && $pair['left'] >= $index) {
                $pair['left'] = '';
            }
        }
    }

    public function addRightOption()
    {
        $this->right_options[] = '';
    }

    public function removeRightOption($index)
    {
        unset($this->right_options[$index]);
        $this->right_options = array_values($this->right_options);
        foreach ($this->correct_pairs as &$pair) {
            if (isset($pair['right']) && $pair['right'] >= $index) {
                $pair['right'] = '';
            }
        }
    }

    public function getFilteredLeftOptions()
    {
        return array_filter($this->left_options, function($option) {
            return trim($option) !== '';
        });
    }

    public function getFilteredRightOptions()
    {
        return array_filter($this->right_options, function($option) {
            return trim($option) !== '';
        });
    }

    // MCQ Multiple methods
    public function addSubQuestion()
    {
        $this->sub_questions[] = [
            'question' => '',
            'options' => ['', ''],
            'correct_indices' => [0]
        ];
    }

    public function removeSubQuestion($index)
    {
        unset($this->sub_questions[$index]);
        $this->sub_questions = array_values($this->sub_questions);
    }

    public function addSubQuestionOption($subIndex)
    {
        if (count($this->sub_questions[$subIndex]['options']) < 6) {
            $this->sub_questions[$subIndex]['options'][] = '';
        }
    }

    public function removeSubQuestionOption($subIndex, $optIndex)
    {
        if (count($this->sub_questions[$subIndex]['options']) > 2) {
            unset($this->sub_questions[$subIndex]['options'][$optIndex]);
            $this->sub_questions[$subIndex]['options'] = array_values($this->sub_questions[$subIndex]['options']);
            
            $maxIndex = count($this->sub_questions[$subIndex]['options']) - 1;
            $this->sub_questions[$subIndex]['correct_indices'] = array_filter(
                $this->sub_questions[$subIndex]['correct_indices'],
                function($index) use ($maxIndex) {
                    return $index <= $maxIndex;
                }
            );
            
            $this->sub_questions[$subIndex]['correct_indices'] = array_values($this->sub_questions[$subIndex]['correct_indices']);
            
            if (empty($this->sub_questions[$subIndex]['correct_indices'])) {
                $this->sub_questions[$subIndex]['correct_indices'] = [0];
            }
        }
    }

    public function addSubQuestionAnswerIndex($subIndex)
    {
        $this->sub_questions[$subIndex]['correct_indices'][] = 0;
    }

    public function removeSubQuestionAnswerIndex($subIndex, $ansIndex)
    {
        if (count($this->sub_questions[$subIndex]['correct_indices']) > 1) {
            unset($this->sub_questions[$subIndex]['correct_indices'][$ansIndex]);
            $this->sub_questions[$subIndex]['correct_indices'] = array_values($this->sub_questions[$subIndex]['correct_indices']);
        }
    }

    // True/False Multiple methods
    public function addTrueFalseQuestion()
    {
        $this->true_false_questions[] = [
            'statement' => '',
            'correct_answer' => ''
        ];
    }

    public function removeTrueFalseQuestion($index)
    {
        unset($this->true_false_questions[$index]);
        $this->true_false_questions = array_values($this->true_false_questions);
    }

    public function setTrueFalseAnswer($index, $answer)
    {
        $this->true_false_questions[$index]['correct_answer'] = $answer;
    }

    // Reorder methods
    public function addReorderFragment()
    {
        $this->reorder_fragments[] = '';
    }

    public function removeReorderFragment($index)
    {
        if (count($this->reorder_fragments) > 2) {
            unset($this->reorder_fragments[$index]);
            $this->reorder_fragments = array_values($this->reorder_fragments);
        }
    }

    // Form Fill methods
    public function addFormFillOption()
    {
        $this->form_fill_options[] = '';
    }

    public function removeFormFillOption($index)
    {
        if (count($this->form_fill_options) > 2) {
            unset($this->form_fill_options[$index]);
            $this->form_fill_options = array_values($this->form_fill_options);
        }
    }

    public function addFormFillAnswerKey()
    {
        $this->form_fill_answer_key[] = '';
    }

    public function removeFormFillAnswerKey($index)
    {
        if (count($this->form_fill_answer_key) > 1) {
            unset($this->form_fill_answer_key[$index]);
            $this->form_fill_answer_key = array_values($this->form_fill_answer_key);
        }
    }

    public function adjustAnswerKeysToBlankCount()
    {
        if (!empty($this->form_fill_paragraph)) {
            $blankCount = substr_count($this->form_fill_paragraph, '___');
            $currentAnswerKeyCount = count($this->form_fill_answer_key);
            
            if ($blankCount > $currentAnswerKeyCount) {
                for ($i = $currentAnswerKeyCount; $i < $blankCount; $i++) {
                    $this->form_fill_answer_key[] = '';
                }
            } elseif ($blankCount < $currentAnswerKeyCount && $blankCount > 0) {
                $this->form_fill_answer_key = array_slice($this->form_fill_answer_key, 0, $blankCount);
            }
            
            if (empty($this->form_fill_answer_key) || $blankCount === 0) {
                $this->form_fill_answer_key = [''];
            }
        }
    }

    // Validation methods
    public function updatedLeftOptions()
    {
        $this->validateOnly('left_options');
    }

    public function updatedRightOptions()
    {
        $this->validateOnly('right_options');
    }

    public function updatedOpinionAnswer()
    {
        $this->validateOnly('opinion_answer');
    }

    public function updatedSubQuestions()
    {
        $this->validateOnly('sub_questions');
    }

    public function updatedTrueFalseQuestions()
    {
        $this->validateOnly('true_false_questions');
    }

    public function updatedTrueFalseStatement()
    {
        $this->validateOnly('true_false_statement');
    }

    public function updatedTrueFalseAnswer()
    {
        $this->validateOnly('true_false_answer');
    }

    public function updatedReorderFragments()
    {
        $this->validateOnly('reorder_fragments');
    }

    public function updatedReorderAnswerKey()
    {
        $this->validateOnly('reorder_answer_key');
    }

    public function updatedFormFillParagraph()
    {
        $this->adjustAnswerKeysToBlankCount();
        $this->validateOnly('form_fill_paragraph');
    }

    public function updatedFormFillOptions()
    {
        $this->validateOnly('form_fill_options');
    }

    public function updatedFormFillAnswerKey()
    {
        $this->validateOnly('form_fill_answer_key');
    }

    public function update()
    {
        // Find or create the Day by day_number and course_id
        $day = \App\Models\Day::firstOrCreate(
            [
                'day_number' => $this->day_number_input,
                'course_id' => $this->course_id,
            ],
            [
                'title' => 'Day ' . $this->day_number_input,
            ]
        );
        $this->day_id = $day->id;

        // Validate required fields
        if (empty($this->day_id) || empty($this->course_id) || empty($this->subject_id) || 
            empty($this->question_type_id) || empty($this->instruction)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please fill in all required fields.')
                ->danger()
                ->send();
            return;
        }

        // Check question types
        $isStatementMatch = ($this->question_type_id === 'statement_match');
        $isOpinion = ($this->question_type_id === 'opinion');
        $isMcqMultiple = ($this->question_type_id === 'mcq_multiple');
        $isTrueFalseMultiple = ($this->question_type_id === 'true_false_multiple');
        $isTrueFalse = ($this->question_type_id === 'true_false');
        $isReorder = ($this->question_type_id === 'reorder');
        $isFormFill = ($this->question_type_id === 'form_fill');

        if ($isTrueFalse) {
            return $this->updateTrueFalse();
        } elseif ($isFormFill) {
            return $this->updateFormFill();
        } elseif ($isReorder) {
            return $this->updateReorder();
        } elseif ($isTrueFalseMultiple) {
            return $this->updateTrueFalseMultiple();
        } elseif ($isMcqMultiple) {
            return $this->updateMcqMultiple();
        } elseif ($isOpinion) {
            return $this->updateOpinion();
        } elseif ($isStatementMatch) {
            return $this->updateStatementMatch();
        } else {
            return $this->updateRegularMcq();
        }
    }

    private function updateTrueFalse()
    {
        $statement = trim($this->true_false_statement);
        $answer = $this->true_false_answer;
        
        if (empty($statement)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please provide the true/false statement.')
                ->danger()
                ->send();
            return;
        }
        
        if (empty($answer) || !in_array($answer, ['true', 'false'])) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please select the correct answer (True or False).')
                ->danger()
                ->send();
            return;
        }
        
        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }
        
        $questionType = QuestionType::firstOrCreate(['name' => 'true_false']);
        
        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'main_instruction' => $this->instruction,
                'statement' => $statement,
                'options' => ['True', 'False']
            ]),
            'answer_data' => json_encode([
                'correct_answer' => $answer,
                'correct_indices' => $answer === 'true' ? [0] : [1]
            ]),
            'left_options' => null,
            'right_options' => null,
            'correct_pairs' => null,
        ]);
        
        $this->showSuccessAndRedirect('True/False question');
    }

    private function updateFormFill()
    {
        $paragraph = trim($this->form_fill_paragraph);
        $options = array_filter($this->form_fill_options, fn($v) => trim($v) !== '');
        $answerKeys = array_filter($this->form_fill_answer_key, fn($v) => trim($v) !== '');
        
        if (empty($paragraph)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please provide the paragraph with blanks marked as ___ (three underscores).')
                ->danger()
                ->send();
            return;
        }
        
        $blankCount = substr_count($paragraph, '___');
        
        if ($blankCount === 0) {
            Notification::make()
                ->title('Validation Error')
                ->body('Paragraph must contain at least one blank marked as ___ (three underscores).')
                ->danger()
                ->send();
            return;
        }
        
        if (count($options) < 2) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least 2 options for the form fill question.')
                ->danger()
                ->send();
            return;
        }
        
        if (count($answerKeys) !== $blankCount) {
            Notification::make()
                ->title('Validation Error')
                ->body("Please provide exactly {$blankCount} answer key(s) to match the number of blanks in the paragraph.")
                ->danger()
                ->send();
            return;
        }
        
        foreach ($answerKeys as $index => $answerKey) {
            if (!in_array(trim($answerKey), $options)) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Answer key " . ($index + 1) . " ('{$answerKey}') does not match any of the provided options.")
                    ->danger()
                    ->send();
                return;
            }
        }
        
        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }
        
        $questionType = QuestionType::firstOrCreate(['name' => 'form_fill']);
        
        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'main_instruction' => $this->instruction,
                'paragraph' => $paragraph,
                'options' => array_values($options),
                'blank_count' => $blankCount
            ]),
            'answer_data' => json_encode([
                'answer_keys' => array_values($answerKeys),
                'blank_count' => $blankCount
            ]),
            'form_fill_paragraph' => $paragraph,
            'left_options' => null,
            'right_options' => null,
            'correct_pairs' => null,
        ]);
        
        $this->showSuccessAndRedirect('form fill question');
    }

    // Add other update methods for different question types...
    private function updateReorder()
    {
        $fragments = array_filter($this->reorder_fragments, fn($v) => trim($v) !== '');
        $answerKey = trim($this->reorder_answer_key);
        
        if (count($fragments) < 2) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least 2 sentence fragments for reordering.')
                ->danger()
                ->send();
            return;
        }
        
        if (empty($answerKey)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please provide the answer key (correct sentence).')
                ->danger()
                ->send();
            return;
        }
        
        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }
        
        $questionType = QuestionType::firstOrCreate(['name' => 'reorder']);
        
        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'main_instruction' => $this->instruction,
                'fragments' => array_values($fragments)
            ]),
            'answer_data' => json_encode([
                'answer_key' => $answerKey,
                'fragments_count' => count($fragments)
            ]),
            'reorder_fragments' => array_values($fragments),
            'reorder_answer_key' => $answerKey,
            'left_options' => null,
            'right_options' => null,
            'correct_pairs' => null,
        ]);
        
        $this->showSuccessAndRedirect('sentence reordering question');
    }

    private function updateTrueFalseMultiple()
    {
        $validatedTrueFalseQuestions = [];
        
        foreach ($this->true_false_questions as $index => $tfQuestion) {
            if (empty(trim($tfQuestion['statement'] ?? ''))) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Statement " . chr(97 + $index) . ") text is required.")
                    ->danger()
                    ->send();
                return;
            }
            
            if (empty($tfQuestion['correct_answer']) || !in_array($tfQuestion['correct_answer'], ['true', 'false'])) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Statement " . chr(97 + $index) . ") must have a correct answer selected (True or False).")
                    ->danger()
                    ->send();
                return;
            }
            
            $validatedTrueFalseQuestions[] = [
                'statement' => trim($tfQuestion['statement']),
                'text' => trim($tfQuestion['statement']),
                'options' => ['True', 'False'],
                'correct_answer' => $tfQuestion['correct_answer'],
                'correct_indices' => $tfQuestion['correct_answer'] === 'true' ? [0] : [1]
            ];
        }
        
        if (empty($validatedTrueFalseQuestions)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least one True/False statement.')
                ->danger()
                ->send();
            return;
        }
        
        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }
        
        $questionType = QuestionType::firstOrCreate(['name' => 'true_false_multiple']);
        
        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'main_instruction' => $this->instruction,
                'questions' => $validatedTrueFalseQuestions
            ]),
            'answer_data' => json_encode([
                'true_false_answers' => array_map(function($tfQ) {
                    return [
                        'correct_answer' => $tfQ['correct_answer'],
                        'correct_indices' => $tfQ['correct_indices']
                    ];
                }, $validatedTrueFalseQuestions)
            ]),
            'true_false_questions' => $validatedTrueFalseQuestions,
            'left_options' => null,
            'right_options' => null,
            'correct_pairs' => null,
        ]);
        
        $this->showSuccessAndRedirect('True/False Multiple question');
    }

    private function updateMcqMultiple()
    {
        $validatedSubQuestions = [];
        
        foreach ($this->sub_questions as $index => $subQuestion) {
            if (empty(trim($subQuestion['question'] ?? ''))) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Sub-question " . chr(97 + $index) . ") text is required.")
                    ->danger()
                    ->send();
                return;
            }
            
            $options = array_filter($subQuestion['options'] ?? [], fn($v) => trim($v) !== '');
            if (count($options) < 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Sub-question " . chr(97 + $index) . ") must have at least 2 options.")
                    ->danger()
                    ->send();
                return;
            }
            
            $correctIndices = array_filter($subQuestion['correct_indices'] ?? [], function($value) {
                return $value !== '' && $value !== null && is_numeric($value);
            });
            
            if (empty($correctIndices)) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Sub-question " . chr(97 + $index) . ") must have at least one correct answer.")
                    ->danger()
                    ->send();
                return;
            }
            
            foreach ($correctIndices as $correctIndex) {
                if ($correctIndex >= count($options)) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Sub-question " . chr(97 + $index) . "): Answer index {$correctIndex} exceeds available options count.")
                        ->danger()
                        ->send();
                    return;
                }
            }
            
            $validatedSubQuestions[] = [
                'question' => trim($subQuestion['question']),
                'options' => array_values($options),
                'correct_indices' => array_map('intval', array_values($correctIndices))
            ];
        }
        
        if (empty($validatedSubQuestions)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least one sub-question.')
                ->danger()
                ->send();
            return;
        }
        
        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }
        
        $questionType = QuestionType::where('name', 'mcq_multiple')->first();
        if (!$questionType) {
            Notification::make()
                ->title('Validation Error')
                ->body('MCQ Multiple question type not found in database.')
                ->danger()
                ->send();
            return;
        }
        
        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'main_instruction' => $this->instruction,
                'sub_questions' => $validatedSubQuestions
            ]),
            'answer_data' => json_encode([
                'sub_questions_answers' => array_map(function($subQ) {
                    return $subQ['correct_indices'];
                }, $validatedSubQuestions)
            ]),
            'left_options' => null,
            'right_options' => null,
            'correct_pairs' => null,
        ]);
        
        $this->showSuccessAndRedirect('MCQ Multiple question');
    }

    private function updateOpinion()
    {
        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }
        
        $questionType = QuestionType::where('name', 'opinion')->first();
        if (!$questionType) {
            Notification::make()
                ->title('Validation Error')
                ->body('Opinion question type not found in database.')
                ->danger()
                ->send();
            return;
        }
        
        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'main_instruction' => $this->instruction,
                'opinion_answer' => $this->opinion_answer ?? ''
            ]),
            'answer_data' => json_encode([
                'opinion_answer' => $this->opinion_answer ?? ''
            ]),
            'left_options' => null,
            'right_options' => null,
            'correct_pairs' => null,
        ]);
        
        $this->showSuccessAndRedirect('opinion question');
    }

    private function updateStatementMatch()
    {
        $leftOptions = array_filter($this->left_options, fn($v) => trim($v) !== '');
        $rightOptions = array_filter($this->right_options, fn($v) => trim($v) !== '');
        $pairs = array_filter($this->correct_pairs, function($pair) {
            return isset($pair['left'], $pair['right']) && 
                   $pair['left'] !== '' && $pair['right'] !== '' &&
                   $pair['left'] !== null && $pair['right'] !== null;
        });
        
        $pairs = array_map(function($pair) {
            $pair['left'] = (int) $pair['left'];
            $pair['right'] = (int) $pair['right'];
            return $pair;
        }, $pairs);

        if (count($leftOptions) < 2 || count($rightOptions) < 2) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least 2 left and 2 right options for statement match.')
                ->danger()
                ->send();
            return;
        }

        if (count($pairs) !== 2) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please select exactly 2 correct pairs.')
                ->danger()
                ->send();
            return;
        }

        $leftCount = count($leftOptions);
        $rightCount = count($rightOptions);
        
        foreach ($pairs as $index => $pair) {
            if ($pair['left'] >= $leftCount) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Pair " . ($index + 1) . ": Left index {$pair['left']} is out of bounds (max: " . ($leftCount - 1) . ")")
                    ->danger()
                    ->send();
                return;
            }
            if ($pair['right'] >= $rightCount) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Pair " . ($index + 1) . ": Right index {$pair['right']} is out of bounds (max: " . ($rightCount - 1) . ")")
                    ->danger()
                    ->send();
                return;
            }
        }

        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }

        $questionType = QuestionType::where('name', 'statement_match')->first();
        if (!$questionType) {
            Notification::make()
                ->title('Validation Error')
                ->body('Statement match question type not found in database.')
                ->danger()
                ->send();
            return;
        }

        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $questionType->id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'left_options' => array_values($leftOptions),
            'right_options' => array_values($rightOptions),
            'correct_pairs' => array_values($pairs),
            'question_data' => null,
            'answer_data' => null,
        ]);

        $this->showSuccessAndRedirect('statement match question');
    }

    private function updateRegularMcq()
    {
        $options = array_filter($this->options, fn($v) => trim($v) !== '');
        $answerIndices = array_filter($this->answer_indices, function($value) {
            return $value !== '' && $value !== null;
        });

        if (empty($options)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least one option.')
                ->danger()
                ->send();
            return;
        }

        if (empty($answerIndices)) {
            Notification::make()
                ->title('Validation Error')
                ->body('Please add at least one answer index.')
                ->danger()
                ->send();
            return;
        }

        foreach ($answerIndices as $index) {
            if ($index >= count($options)) {
                Notification::make()
                    ->title('Validation Error')
                    ->body("Answer index {$index} exceeds available options count.")
                    ->danger()
                    ->send();
                return;
            }
        }

        $explanationFilePath = $this->explanation;
        if ($this->explanation_file) {
            $explanationFilePath = $this->explanation_file->store('explanations', 'public');
        }

        $this->record->update([
            'day_id' => $this->day_id,
            'course_id' => $this->course_id,
            'subject_id' => $this->subject_id,
            'question_type_id' => $this->question_type_id,
            'instruction' => $this->instruction,
            'explanation' => $explanationFilePath,
            'points' => $this->points ?: 1,
            'is_active' => $this->is_active,
            'question_data' => json_encode([
                'question' => $this->instruction,
                'options' => $options,
            ]),
            'answer_data' => json_encode([
                'correct_indices' => array_map('intval', $answerIndices),
            ]),
        ]);

        $this->showSuccessAndRedirect('question');
    }

    private function showSuccessAndRedirect($questionType)
    {
        Notification::make()
            ->title('Question updated successfully!')
            ->body("The {$questionType} has been updated.")
            ->success()
            ->send();
            
        return redirect()->to(QuestionResource::getUrl('index'));
    }

    protected function getViewData(): array
    {
        return [
            'record' => $this->record,
            'courses' => \App\Models\Course::all(),
            'subjects' => Subject::all(),
            'questionTypes' => QuestionType::all(),
        ];
    }

    public function getTitle(): string
    {
        return 'Edit Question';
    }

    public function getHeading(): string
    {
        return 'Question Editor';
    }

    public function getSubheading(): ?string
    {
        return 'Modify and update existing questions in your assessment bank.';
    }

    protected function hasLogo(): bool
    {
        return false;
    }

    public function getBreadcrumbs(): array
    {
        return [
            url('/admin/questions') => 'Questions',
            '' => 'Edit Question',
        ];
    }
}