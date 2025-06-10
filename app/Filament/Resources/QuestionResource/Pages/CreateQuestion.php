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

class CreateQuestion extends Page
{
    protected static string $resource = QuestionResource::class;
    protected static string $view = 'filament.resources.question-resource.pages.create-custom';

    public $day_id = '';
    public $course_id = '';
    public $subject_id = '';
    public $question_type_id = '';
    public $points = 1;
    public $is_active = true;
    public $instruction = '';
    public $explanation = '';
    public $options = [''];
    public $answer_indices = [0]; // Add this property to handle answer indices
    public $day_number_input = 1;
    public $explanation_file;
    public $left_options = [''];
    public $right_options = [''];
    public $correct_pairs = [
        ['left' => '', 'right' => ''],
        ['left' => '', 'right' => ''],
    ];
    public $opinion_answer = ''; // Add this property for opinion type
    
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
            'correct_answer' => '' // 'true' or 'false'
        ]
    ];

    // Properties for Simple True/False
    public $true_false_statement = ''; // The statement text
    public $true_false_answer = ''; // 'true' or 'false'

    // Properties for Reorder
    public $reorder_fragments = ['', '']; // Sentence fragments to be reordered
    public $reorder_answer_key = ''; // The correct sentence

    // Properties for Form Fill
    public $form_fill_paragraph = ''; // The paragraph with blanks marked as ___
    public $form_fill_options = ['', '']; // Options to fill in the blanks
    public $form_fill_answer_key = ['']; // Answer key indicating which options go in which blanks

    // Properties for Picture MCQ
    public $picture_mcq_images = []; // Array to store uploaded images
    public $picture_mcq_right_options = ['', '']; // Text options on right side
    public $picture_mcq_correct_pairs = [
        ['left' => '', 'right' => ''],
        ['left' => '', 'right' => ''],
    ];
    public $picture_mcq_image_uploads = []; // Temporary storage for file uploads

    // Properties for Audio MCQ Single
    public $audio_mcq_file = null; // Single audio file upload
    public $audio_mcq_sub_questions = [
        [
            'question' => '',
            'options' => ['', ''],
            'correct_indices' => [0]
        ]
    ];

    // Properties for Audio Image Text Single
    public $audio_image_text_audio_file = null; // Single audio file for context/hint
    public $audio_image_text_image_uploads = []; // Array of image uploads
    public $audio_image_text_right_options = ['', '']; // Text options on right side
    public $audio_image_text_correct_pairs = [
        ['left' => '', 'right' => ''],
        ['left' => '', 'right' => ''],
    ];

    // Properties for Audio Image Text Multiple (LHS: Image + Audio pairs, RHS: Text options)
    public $audio_image_text_multiple_pairs = []; // Array of {image: file, audio: file} pairs
    public $audio_image_text_multiple_right_options = ['', '']; // Text options on right side
    public $audio_image_text_multiple_correct_pairs = [
        ['left' => '', 'right' => ''],
        ['left' => '', 'right' => ''],
    ];

    public $rules = [
        'left_options' => 'array',
        'left_options.*' => 'string|nullable',
        'right_options' => 'array',
        'right_options.*' => 'string|nullable',
        'correct_pairs' => 'array',
        'correct_pairs.*.left' => 'nullable',
        'correct_pairs.*.right' => 'nullable',
        'opinion_answer' => 'string|nullable', // Add validation rule for opinion answer
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
        // Picture MCQ validation rules
        'picture_mcq_right_options' => 'array',
        'picture_mcq_right_options.*' => 'string|nullable',
        'picture_mcq_correct_pairs' => 'array',
        'picture_mcq_correct_pairs.*.left' => 'nullable',
        'picture_mcq_correct_pairs.*.right' => 'nullable',
        'picture_mcq_image_uploads.*' => 'nullable|image|max:2048', // 2MB max per image
        // Audio MCQ validation rules
        'audio_mcq_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:10240', // 10MB max for audio
        'audio_mcq_sub_questions' => 'array',
        'audio_mcq_sub_questions.*.question' => 'string|nullable',
        'audio_mcq_sub_questions.*.options' => 'array',
        'audio_mcq_sub_questions.*.options.*' => 'string|nullable',
        'audio_mcq_sub_questions.*.correct_indices' => 'array',
        'audio_mcq_sub_questions.*.correct_indices.*' => 'integer|nullable',
        // Audio Image Text validation rules
        'audio_image_text_audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:10240', // 10MB max for audio
        'audio_image_text_image_uploads.*' => 'nullable|image|max:2048', // 2MB max per image
        'audio_image_text_right_options' => 'array',
        'audio_image_text_right_options.*' => 'string|nullable',
        'audio_image_text_correct_pairs' => 'array',
        'audio_image_text_correct_pairs.*.left' => 'nullable',
        'audio_image_text_correct_pairs.*.right' => 'nullable',
        // Audio Image Text Multiple validation rules
        'audio_image_text_multiple_pairs.*.image' => 'nullable|image|max:2048', // 2MB max per image
        'audio_image_text_multiple_pairs.*.audio' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:10240', // 10MB max per audio
        'audio_image_text_multiple_right_options' => 'array',
        'audio_image_text_multiple_right_options.*' => 'string|nullable',
        'audio_image_text_multiple_correct_pairs' => 'array',
        'audio_image_text_multiple_correct_pairs.*.left' => 'nullable',
        'audio_image_text_multiple_correct_pairs.*.right' => 'nullable',
    ];

    public function mount(): void
    {
        $this->is_active = true;
        $this->points = 1;
        $this->answer_indices = [0]; // Initialize with first index
        $this->opinion_answer = ''; // Initialize opinion answer
        // Initialize MCQ Multiple with one sub-question
        $this->sub_questions = [
            [
                'question' => '',
                'options' => ['', ''],
                'correct_indices' => [0]
            ]
        ];
        // Initialize True/False Multiple with one question
        $this->true_false_questions = [
            [
                'statement' => '',
                'correct_answer' => ''
            ]
        ];
        // Initialize Simple True/False
        $this->true_false_statement = '';
        $this->true_false_answer = '';
        // Initialize Reorder with two fragments
        $this->reorder_fragments = ['', ''];
        $this->reorder_answer_key = '';
        // Initialize Form Fill
        $this->form_fill_paragraph = '';
        $this->form_fill_options = ['', ''];
        $this->form_fill_answer_key = [''];
        // Initialize Picture MCQ
        $this->picture_mcq_images = [];
        $this->picture_mcq_right_options = ['', ''];
        $this->picture_mcq_correct_pairs = [
            ['left' => '', 'right' => ''],
            ['left' => '', 'right' => ''],
        ];
        $this->picture_mcq_image_uploads = [null]; // Start with one empty slot
        // Initialize Audio MCQ Single
        $this->audio_mcq_file = null;
        $this->audio_mcq_sub_questions = [
            [
                'question' => '',
                'options' => ['', ''],
                'correct_indices' => [0]
            ]
        ];
        // Initialize Audio Image Text Single
        $this->audio_image_text_audio_file = null;
        $this->audio_image_text_image_uploads = [null]; // Start with one empty slot
        $this->audio_image_text_right_options = ['', ''];
        $this->audio_image_text_correct_pairs = [
            ['left' => '', 'right' => ''],
            ['left' => '', 'right' => ''],
        ];
        // Initialize Audio Image Text Multiple
        $this->audio_image_text_multiple_pairs = [
            ['image' => null, 'audio' => null]
        ];
        $this->audio_image_text_multiple_right_options = ['', ''];
        $this->audio_image_text_multiple_correct_pairs = [
            ['left' => '', 'right' => ''],
            ['left' => '', 'right' => ''],
        ];
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    // Add methods to handle answer indices
    public function addAnswerIndex()
    {
        $this->answer_indices[] = 0;
    }

    public function removeAnswerIndex($index)
    {
        unset($this->answer_indices[$index]);
        $this->answer_indices = array_values($this->answer_indices);
    }

    // Picture MCQ methods
    public function addPictureMcqImage()
    {
        $this->picture_mcq_image_uploads[] = null;
        $this->picture_mcq_images[] = '';
    }

    public function removePictureMcqImage($index)
    {
        if (count($this->picture_mcq_images) > 1) {
            unset($this->picture_mcq_images[$index]);
            unset($this->picture_mcq_image_uploads[$index]);
            $this->picture_mcq_images = array_values($this->picture_mcq_images);
            $this->picture_mcq_image_uploads = array_values($this->picture_mcq_image_uploads);
            
            // Reset any correct pairs that reference this index or higher
            foreach ($this->picture_mcq_correct_pairs as &$pair) {
                if (isset($pair['left']) && $pair['left'] >= $index) {
                    $pair['left'] = '';
                }
            }
        }
    }

    public function addPictureMcqRightOption()
    {
        $this->picture_mcq_right_options[] = '';
    }

    public function removePictureMcqRightOption($index)
    {
        if (count($this->picture_mcq_right_options) > 1) {
            unset($this->picture_mcq_right_options[$index]);
            $this->picture_mcq_right_options = array_values($this->picture_mcq_right_options);
            
            // Reset any correct pairs that reference this index or higher
            foreach ($this->picture_mcq_correct_pairs as &$pair) {
                if (isset($pair['right']) && $pair['right'] >= $index) {
                    $pair['right'] = '';
                }
            }
        }
    }

    public function clearPictureMcqPair($pairIndex)
    {
        if (isset($this->picture_mcq_correct_pairs[$pairIndex])) {
            $this->picture_mcq_correct_pairs[$pairIndex]['left'] = '';
            $this->picture_mcq_correct_pairs[$pairIndex]['right'] = '';
        }
    }

    public function clearAllPictureMcqPairs()
    {
        foreach ($this->picture_mcq_correct_pairs as &$pair) {
            $pair['left'] = '';
            $pair['right'] = '';
        }
    }

    // Audio Image Text Single methods
    public function addAudioImageTextImage()
    {
        $this->audio_image_text_image_uploads[] = null;
    }

    public function removeAudioImageTextImage($index)
    {
        if (count($this->audio_image_text_image_uploads) > 1) {
            unset($this->audio_image_text_image_uploads[$index]);
            $this->audio_image_text_image_uploads = array_values($this->audio_image_text_image_uploads);
            
            // Reset any correct pairs that reference this index or higher
            foreach ($this->audio_image_text_correct_pairs as &$pair) {
                if (isset($pair['left']) && $pair['left'] >= $index) {
                    $pair['left'] = '';
                }
            }
        }
    }

    public function addAudioImageTextRightOption()
    {
        $this->audio_image_text_right_options[] = '';
    }

    public function removeAudioImageTextRightOption($index)
    {
        if (count($this->audio_image_text_right_options) > 1) {
            unset($this->audio_image_text_right_options[$index]);
            $this->audio_image_text_right_options = array_values($this->audio_image_text_right_options);
            
            // Reset any correct pairs that reference this index or higher
            foreach ($this->audio_image_text_correct_pairs as &$pair) {
                if (isset($pair['right']) && $pair['right'] >= $index) {
                    $pair['right'] = '';
                }
            }
        }
    }

    public function getFilteredAudioImageTextImages()
    {
        return array_filter($this->audio_image_text_image_uploads, function($image, $index) {
            return !empty($image);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function getFilteredAudioImageTextRightOptions()
    {
        return array_filter($this->audio_image_text_right_options, function($option) {
            return trim($option) !== '';
        });
    }

    // Audio Image Text Multiple methods (Image + Audio pairs on left, Text on right)
    public function addAudioImageTextMultiplePair()
    {
        $this->audio_image_text_multiple_pairs[] = [
            'image' => null,
            'audio' => null
        ];
    }

    public function removeAudioImageTextMultiplePair($index)
    {
        if (count($this->audio_image_text_multiple_pairs) > 1) {
            unset($this->audio_image_text_multiple_pairs[$index]);
            $this->audio_image_text_multiple_pairs = array_values($this->audio_image_text_multiple_pairs);
            
            // Reset any correct pairs that reference this index or higher
            foreach ($this->audio_image_text_multiple_correct_pairs as &$pair) {
                if (isset($pair['left']) && $pair['left'] >= $index) {
                    $pair['left'] = '';
                }
            }
        }
    }

    public function addAudioImageTextMultipleRightOption()
    {
        $this->audio_image_text_multiple_right_options[] = '';
    }

    public function removeAudioImageTextMultipleRightOption($index)
    {
        if (count($this->audio_image_text_multiple_right_options) > 1) {
            unset($this->audio_image_text_multiple_right_options[$index]);
            $this->audio_image_text_multiple_right_options = array_values($this->audio_image_text_multiple_right_options);
            
            // Reset any correct pairs that reference this index or higher
            foreach ($this->audio_image_text_multiple_correct_pairs as &$pair) {
                if (isset($pair['right']) && $pair['right'] >= $index) {
                    $pair['right'] = '';
                }
            }
        }
    }

    public function getFilteredAudioImageTextMultiplePairs()
    {
        return array_filter($this->audio_image_text_multiple_pairs, function($pair) {
            return !empty($pair['image']) || !empty($pair['audio']);
        });
    }

    public function getFilteredAudioImageTextMultipleRightOptions()
    {
        return array_filter($this->audio_image_text_multiple_right_options, function($option) {
            return trim($option) !== '';
        });
    }

    // Audio MCQ Single methods
    public function addAudioMcqSubQuestion()
    {
        $this->audio_mcq_sub_questions[] = [
            'question' => '',
            'options' => ['', ''],
            'correct_indices' => [0]
        ];
    }

    public function removeAudioMcqSubQuestion($index)
    {
        if (count($this->audio_mcq_sub_questions) > 1) {
            unset($this->audio_mcq_sub_questions[$index]);
            $this->audio_mcq_sub_questions = array_values($this->audio_mcq_sub_questions);
        }
    }

    public function addAudioMcqSubQuestionOption($subIndex)
    {
        if (count($this->audio_mcq_sub_questions[$subIndex]['options']) < 6) {
            $this->audio_mcq_sub_questions[$subIndex]['options'][] = '';
        }
    }

    public function removeAudioMcqSubQuestionOption($subIndex, $optIndex)
    {
        if (count($this->audio_mcq_sub_questions[$subIndex]['options']) > 2) {
            unset($this->audio_mcq_sub_questions[$subIndex]['options'][$optIndex]);
            $this->audio_mcq_sub_questions[$subIndex]['options'] = array_values($this->audio_mcq_sub_questions[$subIndex]['options']);
            
            // Update answer indices if they reference removed options
            $maxIndex = count($this->audio_mcq_sub_questions[$subIndex]['options']) - 1;
            $this->audio_mcq_sub_questions[$subIndex]['correct_indices'] = array_filter(
                $this->audio_mcq_sub_questions[$subIndex]['correct_indices'],
                function($index) use ($maxIndex) {
                    return $index <= $maxIndex;
                }
            );
            
            // Re-index the array
            $this->audio_mcq_sub_questions[$subIndex]['correct_indices'] = array_values($this->audio_mcq_sub_questions[$subIndex]['correct_indices']);
            
            // Ensure at least one correct index exists
            if (empty($this->audio_mcq_sub_questions[$subIndex]['correct_indices'])) {
                $this->audio_mcq_sub_questions[$subIndex]['correct_indices'] = [0];
            }
        }
    }

    public function addAudioMcqSubQuestionAnswerIndex($subIndex)
    {
        $this->audio_mcq_sub_questions[$subIndex]['correct_indices'][] = 0;
    }

    public function removeAudioMcqSubQuestionAnswerIndex($subIndex, $ansIndex)
    {
        if (count($this->audio_mcq_sub_questions[$subIndex]['correct_indices']) > 1) {
            unset($this->audio_mcq_sub_questions[$subIndex]['correct_indices'][$ansIndex]);
            $this->audio_mcq_sub_questions[$subIndex]['correct_indices'] = array_values($this->audio_mcq_sub_questions[$subIndex]['correct_indices']);
        }
    }

    public function clearAudioMcqFile()
    {
        $this->audio_mcq_file = null;
    }

    public function resetAudioMcqSubQuestions()
    {
        $this->audio_mcq_sub_questions = [
            [
                'question' => '',
                'options' => ['', ''],
                'correct_indices' => [0]
            ]
        ];
    }

    public function getFilteredPictureMcqImages()
    {
        return array_filter($this->picture_mcq_images, function($image, $index) {
            return !empty($image) || !empty($this->picture_mcq_image_uploads[$index]);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function getFilteredPictureMcqRightOptions()
    {
        return array_filter($this->picture_mcq_right_options, function($option) {
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
            
            // Update answer indices if they reference removed options
            $maxIndex = count($this->sub_questions[$subIndex]['options']) - 1;
            $this->sub_questions[$subIndex]['correct_indices'] = array_filter(
                $this->sub_questions[$subIndex]['correct_indices'],
                function($index) use ($maxIndex) {
                    return $index <= $maxIndex;
                }
            );
            
            // Re-index the array
            $this->sub_questions[$subIndex]['correct_indices'] = array_values($this->sub_questions[$subIndex]['correct_indices']);
            
            // Ensure at least one correct index exists
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

    public function create()
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
        $isPictureMcq = ($this->question_type_id === 'picture_mcq');
        $isAudioMcqSingle = ($this->question_type_id === 'audio_mcq_single');
        $isAudioImageTextSingle = ($this->question_type_id === 'audio_image_text_single');
        $isAudioImageTextMultiple = ($this->question_type_id === 'audio_image_text_multiple');

        if ($isAudioImageTextSingle) {
            // Audio Image Text Single validation and processing
            $rightOptions = array_filter($this->audio_image_text_right_options, fn($v) => trim($v) !== '');
            $pairs = array_filter($this->audio_image_text_correct_pairs, function($pair) {
                return isset($pair['left'], $pair['right']) && 
                       $pair['left'] !== '' && $pair['right'] !== '' &&
                       $pair['left'] !== null && $pair['right'] !== null;
            });
            
            // Cast indices to int to avoid string/integer comparison issues
            $pairs = array_map(function($pair) {
                $pair['left'] = (int) $pair['left'];
                $pair['right'] = (int) $pair['right'];
                return $pair;
            }, $pairs);

            // Validate audio file upload
            if (!$this->audio_image_text_audio_file) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please upload an audio file for the audio image text question.')
                    ->danger()
                    ->send();
                return;
            }

            // Validate uploaded images
            $uploadedImages = [];
            $validImageCount = 0;
            
            foreach ($this->audio_image_text_image_uploads as $index => $imageFile) {
                if ($imageFile) {
                    $validImageCount++;
                    $imagePath = $imageFile->store('question-images', 'public');
                    $uploadedImages[$index] = $imagePath;
                }
            }

            if ($validImageCount < 2 || count($rightOptions) < 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please add at least 2 images and 2 text options for audio image text question.')
                    ->danger()
                    ->send();
                return;
            }

            if (count($pairs) !== 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please select exactly 2 correct pairs for audio image text question.')
                    ->danger()
                    ->send();
                return;
            }

            // Validate that the indices are within bounds
            $imageCount = $validImageCount;
            $rightCount = count($rightOptions);
            
            foreach ($pairs as $index => $pair) {
                if ($pair['left'] >= $imageCount) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Pair " . ($index + 1) . ": Image index {$pair['left']} is out of bounds (max: " . ($imageCount - 1) . ")")
                        ->danger()
                        ->send();
                    return;
                }
                if ($pair['right'] >= $rightCount) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Pair " . ($index + 1) . ": Text option index {$pair['right']} is out of bounds (max: " . ($rightCount - 1) . ")")
                        ->danger()
                        ->send();
                    return;
                }
            }

            // Store audio file
            $audioFilePath = $this->audio_image_text_audio_file->store('question-audio', 'public');

            // Save audio image text question
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }

            // Find or create the audio_image_text_single question type
            $questionType = QuestionType::firstOrCreate(['name' => 'audio_image_text_single']);
            $questionTypeId = $questionType->id;

            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
                'instruction' => $this->instruction,
                'explanation' => $explanationFilePath,
                'points' => $this->points ?: 1,
                'is_active' => $this->is_active,
                'question_data' => json_encode([
                    'main_instruction' => $this->instruction,
                    'audio_file' => $audioFilePath,
                    'images' => array_values($uploadedImages),
                    'right_options' => array_values($rightOptions)
                ]),
                'answer_data' => json_encode([
                    'correct_pairs' => array_values($pairs)
                ]),
                'left_options' => null, // Not used for audio image text
                'right_options' => array_values($rightOptions),
                'correct_pairs' => array_values($pairs),
                'audio_image_text_images' => array_values($uploadedImages),
                'audio_image_text_audio_file' => $audioFilePath,
            ]);

            Notification::make()
                ->title('Question created successfully!')
                ->body('The audio image text question with ' . $validImageCount . ' images and ' . count($rightOptions) . ' text options has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isAudioImageTextMultiple) {
            // Audio Image Text Multiple validation and processing
            $rightOptions = array_filter($this->audio_image_text_multiple_right_options, fn($v) => trim($v) !== '');
            $pairs = array_filter($this->audio_image_text_multiple_correct_pairs, function($pair) {
                return isset($pair['left'], $pair['right']) && 
                       $pair['left'] !== '' && $pair['right'] !== '' &&
                       $pair['left'] !== null && $pair['right'] !== null;
            });
            
            // Cast indices to int to avoid string/integer comparison issues
            $pairs = array_map(function($pair) {
                $pair['left'] = (int) $pair['left'];
                $pair['right'] = (int) $pair['right'];
                return $pair;
            }, $pairs);

            // Validate uploaded image-audio pairs
            $uploadedPairs = [];
            $validPairCount = 0;
            
            foreach ($this->audio_image_text_multiple_pairs as $index => $pair) {
                if (!empty($pair['image']) && !empty($pair['audio'])) {
                    $validPairCount++;
                    $imagePath = $pair['image']->store('question-images', 'public');
                    $audioPath = $pair['audio']->store('question-audio', 'public');
                    $uploadedPairs[$index] = [
                        'image' => $imagePath,
                        'audio' => $audioPath
                    ];
                }
            }

            if ($validPairCount < 2 || count($rightOptions) < 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please add at least 2 image-audio pairs and 2 text options for audio image text multiple question.')
                    ->danger()
                    ->send();
                return;
            }

            if (count($pairs) !== 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please select exactly 2 correct pairs for audio image text multiple question.')
                    ->danger()
                    ->send();
                return;
            }

            // Validate that the indices are within bounds
            $pairCount = $validPairCount;
            $rightCount = count($rightOptions);
            
            foreach ($pairs as $index => $pair) {
                if ($pair['left'] >= $pairCount) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Pair " . ($index + 1) . ": Image-Audio pair index {$pair['left']} is out of bounds (max: " . ($pairCount - 1) . ")")
                        ->danger()
                        ->send();
                    return;
                }
                if ($pair['right'] >= $rightCount) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Pair " . ($index + 1) . ": Text option index {$pair['right']} is out of bounds (max: " . ($rightCount - 1) . ")")
                        ->danger()
                        ->send();
                    return;
                }
            }

            // Save audio image text multiple question
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }

            // Find or create the audio_image_text_multiple question type
            $questionType = QuestionType::firstOrCreate(['name' => 'audio_image_text_multiple']);
            $questionTypeId = $questionType->id;

            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
                'instruction' => $this->instruction,
                'explanation' => $explanationFilePath,
                'points' => $this->points ?: 1,
                'is_active' => $this->is_active,
                'question_data' => json_encode([
                    'main_instruction' => $this->instruction,
                    'image_audio_pairs' => array_values($uploadedPairs),
                    'right_options' => array_values($rightOptions)
                ]),
                'answer_data' => json_encode([
                    'correct_pairs' => array_values($pairs)
                ]),
                'left_options' => null, // Not used for audio image text multiple
                'right_options' => array_values($rightOptions),
                'correct_pairs' => array_values($pairs),
                'audio_image_text_multiple_pairs' => array_values($uploadedPairs),
            ]);

            Notification::make()
                ->title('Question created successfully!')
                ->body('The audio image text multiple question with ' . $validPairCount . ' image-audio pairs and ' . count($rightOptions) . ' text options has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isAudioMcqSingle) {
            // Audio MCQ Single validation and processing
            $validatedAudioSubQuestions = [];
            
            // Validate audio file upload
            if (!$this->audio_mcq_file) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please upload an audio file for the audio MCQ question.')
                    ->danger()
                    ->send();
                return;
            }
            
            foreach ($this->audio_mcq_sub_questions as $index => $subQuestion) {
                // Validate sub-question text
                if (empty(trim($subQuestion['question'] ?? ''))) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Sub-question " . chr(97 + $index) . ") text is required.")
                        ->danger()
                        ->send();
                    return;
                }
                
                // Filter and validate options
                $options = array_filter($subQuestion['options'] ?? [], fn($v) => trim($v) !== '');
                if (count($options) < 2) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Sub-question " . chr(97 + $index) . ") must have at least 2 options.")
                        ->danger()
                        ->send();
                    return;
                }
                
                // Validate correct indices
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
                
                // Validate indices are within bounds
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
                
                $validatedAudioSubQuestions[] = [
                    'question' => trim($subQuestion['question']),
                    'options' => array_values($options),
                    'correct_indices' => array_map('intval', array_values($correctIndices))
                ];
            }
            
            if (empty($validatedAudioSubQuestions)) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please add at least one sub-question.')
                    ->danger()
                    ->send();
                return;
            }
            
            // Store audio file
            $audioFilePath = $this->audio_mcq_file->store('question-audio', 'public');
            
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            // Find or create the audio_mcq_single question type
            $questionType = QuestionType::firstOrCreate(['name' => 'audio_mcq_single']);
            $questionTypeId = $questionType->id;
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
                'instruction' => $this->instruction,
                'explanation' => $explanationFilePath,
                'points' => $this->points ?: 1,
                'is_active' => $this->is_active,
                'question_data' => json_encode([
                    'main_instruction' => $this->instruction,
                    'audio_file' => $audioFilePath,
                    'sub_questions' => $validatedAudioSubQuestions
                ]),
                'answer_data' => json_encode([
                    'sub_questions_answers' => array_map(function($subQ) {
                        return $subQ['correct_indices'];
                    }, $validatedAudioSubQuestions)
                ]),
                'left_options' => null,
                'right_options' => null,
                'correct_pairs' => null,
            ]);
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The Audio MCQ question with ' . count($validatedAudioSubQuestions) . ' sub-questions has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isPictureMcq) {
            // Picture MCQ validation and processing
            $rightOptions = array_filter($this->picture_mcq_right_options, fn($v) => trim($v) !== '');
            $pairs = array_filter($this->picture_mcq_correct_pairs, function($pair) {
                return isset($pair['left'], $pair['right']) && 
                       $pair['left'] !== '' && $pair['right'] !== '' &&
                       $pair['left'] !== null && $pair['right'] !== null;
            });
            
            // Cast indices to int to avoid string/integer comparison issues
            $pairs = array_map(function($pair) {
                $pair['left'] = (int) $pair['left'];
                $pair['right'] = (int) $pair['right'];
                return $pair;
            }, $pairs);

            // Validate uploaded images
            $uploadedImages = [];
            $validImageCount = 0;
            
            foreach ($this->picture_mcq_image_uploads as $index => $imageFile) {
                if ($imageFile) {
                    $validImageCount++;
                    $imagePath = $imageFile->store('question-images', 'public');
                    $uploadedImages[$index] = $imagePath;
                }
            }

            if ($validImageCount < 2 || count($rightOptions) < 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please add at least 2 images and 2 text options for picture MCQ.')
                    ->danger()
                    ->send();
                return;
            }

            if (count($pairs) !== 2) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Please select exactly 2 correct pairs for picture MCQ.')
                    ->danger()
                    ->send();
                return;
            }

            // Validate that the indices are within bounds
            $imageCount = $validImageCount;
            $rightCount = count($rightOptions);
            
            foreach ($pairs as $index => $pair) {
                if ($pair['left'] >= $imageCount) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Pair " . ($index + 1) . ": Image index {$pair['left']} is out of bounds (max: " . ($imageCount - 1) . ")")
                        ->danger()
                        ->send();
                    return;
                }
                if ($pair['right'] >= $rightCount) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Pair " . ($index + 1) . ": Text option index {$pair['right']} is out of bounds (max: " . ($rightCount - 1) . ")")
                        ->danger()
                        ->send();
                    return;
                }
            }

            // Save picture_mcq question
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }

            // Find or create the picture_mcq question type
            $questionType = QuestionType::firstOrCreate(['name' => 'picture_mcq']);
            $questionTypeId = $questionType->id;

            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
                'instruction' => $this->instruction,
                'explanation' => $explanationFilePath,
                'points' => $this->points ?: 1,
                'is_active' => $this->is_active,
                'question_data' => json_encode([
                    'main_instruction' => $this->instruction,
                    'images' => array_values($uploadedImages),
                    'right_options' => array_values($rightOptions)
                ]),
                'answer_data' => json_encode([
                    'correct_pairs' => array_values($pairs)
                ]),
                'left_options' => null, // Not used for picture mcq
                'right_options' => array_values($rightOptions),
                'correct_pairs' => array_values($pairs),
                'picture_mcq_images' => array_values($uploadedImages),
            ]);

            Notification::make()
                ->title('Question created successfully!')
                ->body('The picture MCQ question with ' . $validImageCount . ' images and ' . count($rightOptions) . ' text options has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isTrueFalse) {
            // Simple True/False validation and processing
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
            
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            // Find or create the true_false question type
            $questionType = QuestionType::firstOrCreate(['name' => 'true_false']);
            $questionTypeId = $questionType->id;
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
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
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The True/False question has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isFormFill) {
            // Form Fill validation and processing
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
            
            // Count the number of blanks in the paragraph
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
            
            // Validate that all answer keys refer to valid options
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
            
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            // Find or create the form_fill question type
            $questionType = QuestionType::firstOrCreate(['name' => 'form_fill']);
            $questionTypeId = $questionType->id;
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
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
                // Store in individual fields for easier access
                'form_fill_paragraph' => $paragraph,
                'left_options' => null,
                'right_options' => null,
                'correct_pairs' => null,
            ]);
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The form fill question with ' . $blankCount . ' blank(s) and ' . count($options) . ' options has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isStatementMatch) {
            // Statement Match validation
            $leftOptions = array_filter($this->left_options, fn($v) => trim($v) !== '');
            $rightOptions = array_filter($this->right_options, fn($v) => trim($v) !== '');
            $pairs = array_filter($this->correct_pairs, function($pair) {
                return isset($pair['left'], $pair['right']) && 
                       $pair['left'] !== '' && $pair['right'] !== '' &&
                       $pair['left'] !== null && $pair['right'] !== null;
            });
            // Cast indices to int to avoid string/integer comparison issues
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

            // Validate that the indices are within bounds
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

            // Save statement_match question
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }

            // Find the actual question type ID for statement_match
            $questionType = QuestionType::where('name', 'statement_match')->first();
            $questionTypeId = $questionType ? $questionType->id : null;

            if (!$questionTypeId) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Statement match question type not found in database.')
                    ->danger()
                    ->send();
                return;
            }

            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
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

            Notification::make()
                ->title('Question created successfully!')
                ->body('The statement match question has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isOpinion) {
            // Opinion question handling
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            $questionType = QuestionType::where('name', 'opinion')->first();
            $questionTypeId = $questionType ? $questionType->id : null;
            
            if (!$questionTypeId) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('Opinion question type not found in database.')
                    ->danger()
                    ->send();
                return;
            }
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
                'instruction' => $this->instruction,
                'explanation' => $explanationFilePath,
                'points' => $this->points ?: 1,
                'is_active' => $this->is_active,
                'question_data' => json_encode([
                    'main_instruction' => $this->instruction,
                    'opinion_answer' => $this->opinion_answer ?? '' // Handle null values safely
                ]),
                'answer_data' => json_encode([
                    'opinion_answer' => $this->opinion_answer ?? ''
                ]),
                'left_options' => null,
                'right_options' => null,
                'correct_pairs' => null,
            ]);
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The opinion question has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isReorder) {
            // Reorder validation and processing
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
            
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            // Find or create the reorder question type
            $questionType = QuestionType::firstOrCreate(['name' => 'reorder']);
            $questionTypeId = $questionType->id;
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
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
                // Store in individual fields for easier access
                'reorder_fragments' => array_values($fragments),
                'reorder_answer_key' => $answerKey,
                'left_options' => null,
                'right_options' => null,
                'correct_pairs' => null,
            ]);
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The sentence reordering question with ' . count($fragments) . ' fragments has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isTrueFalseMultiple) {
            // True/False Multiple validation and processing
            $validatedTrueFalseQuestions = [];
            
            foreach ($this->true_false_questions as $index => $tfQuestion) {
                // Validate statement text
                if (empty(trim($tfQuestion['statement'] ?? ''))) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Statement " . chr(97 + $index) . ") text is required.")
                        ->danger()
                        ->send();
                    return;
                }
                
                // Validate correct answer is selected
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
                    'text' => trim($tfQuestion['statement']), // Store as both 'statement' and 'text' for compatibility
                    'options' => ['True', 'False'], // Fixed options
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
            
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            // Find or create the true_false_multiple question type
            $questionType = QuestionType::firstOrCreate(['name' => 'true_false_multiple']);
            $questionTypeId = $questionType->id;
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
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
                // Store in individual field for easier access
                'true_false_questions' => $validatedTrueFalseQuestions,
                'left_options' => null,
                'right_options' => null,
                'correct_pairs' => null,
            ]);
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The True/False Multiple question with ' . count($validatedTrueFalseQuestions) . ' statements has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else if ($isMcqMultiple) {
            // MCQ Multiple validation and processing
            $validatedSubQuestions = [];
            
            foreach ($this->sub_questions as $index => $subQuestion) {
                // Validate sub-question text
                if (empty(trim($subQuestion['question'] ?? ''))) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Sub-question " . chr(97 + $index) . ") text is required.")
                        ->danger()
                        ->send();
                    return;
                }
                
                // Filter and validate options
                $options = array_filter($subQuestion['options'] ?? [], fn($v) => trim($v) !== '');
                if (count($options) < 2) {
                    Notification::make()
                        ->title('Validation Error')
                        ->body("Sub-question " . chr(97 + $index) . ") must have at least 2 options.")
                        ->danger()
                        ->send();
                    return;
                }
                
                // Validate correct indices
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
                
                // Validate indices are within bounds
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
            
            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }
            
            // Find the actual question type ID for mcq_multiple
            $questionType = QuestionType::where('name', 'mcq_multiple')->first();
            $questionTypeId = $questionType ? $questionType->id : null;
            
            if (!$questionTypeId) {
                Notification::make()
                    ->title('Validation Error')
                    ->body('MCQ Multiple question type not found in database.')
                    ->danger()
                    ->send();
                return;
            }
            
            $question = Question::create([
                'day_id' => $this->day_id,
                'course_id' => $this->course_id,
                'subject_id' => $this->subject_id,
                'question_type_id' => $questionTypeId,
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
            
            Notification::make()
                ->title('Question created successfully!')
                ->body('The MCQ Multiple question with ' . count($validatedSubQuestions) . ' sub-questions has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        } else {
            // Default: MCQ/other types
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

            $explanationFilePath = null;
            if ($this->explanation_file) {
                $explanationFilePath = $this->explanation_file->store('explanations', 'public');
            }

            $question = Question::create([
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

            Notification::make()
                ->title('Question created successfully!')
                ->body('The question has been created and added to your question bank.')
                ->success()
                ->send();
            
            return redirect()->to(QuestionResource::getUrl('index'));
        }
    }

    protected function getViewData(): array
    {
        return [
            'days' => Day::all(),
            'courses' => \App\Models\Course::all(),
            'subjects' => Subject::all(),
            'questionTypes' => QuestionType::all(),
        ];
    }

    // Custom page title (appears in browser tab)
    public function getTitle(): string
    {
        return 'New Question';
    }

    // Custom page heading (main title on page)
    public function getHeading(): string
    {
        return 'Question Builder';
    }

    // Custom subheading (description below title)
    public function getSubheading(): ?string
    {
        return 'Create and configure new questions for your assessment bank.';
    }

    // Hide the back button if you want
    protected function hasLogo(): bool
    {
        return false;
    }

    // Custom breadcrumbs (optional)
    public function getBreadcrumbs(): array
    {
        return [
            url('/admin/questions') => 'Questions',
            '' => 'New Question',
        ];
    }

    // Add methods for statement match left/right options
    public function addLeftOption()
    {
        $this->left_options[] = '';
    }

    public function removeLeftOption($index)
    {
        unset($this->left_options[$index]);
        $this->left_options = array_values($this->left_options);
        // Reset any correct pairs that reference this index or higher
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
        // Reset any correct pairs that reference this index or higher
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

    public function updatedLeftOptions()
    {
        // This will trigger when left_options array changes
        $this->validateOnly('left_options');
    }

    public function updatedRightOptions()
    {
        // This will trigger when right_options array changes
        $this->validateOnly('right_options');
    }

    // Add this method to handle validation when opinion_answer changes (optional)
    public function updatedOpinionAnswer()
    {
        $this->validateOnly('opinion_answer');
    }

    // Validation methods for MCQ Multiple
    public function updatedSubQuestions()
    {
        $this->validateOnly('sub_questions');
    }

    // Validation methods for True/False Multiple
    public function updatedTrueFalseQuestions()
    {
        $this->validateOnly('true_false_questions');
    }

    // Validation methods for Simple True/False
    public function updatedTrueFalseStatement()
    {
        $this->validateOnly('true_false_statement');
    }

    public function updatedTrueFalseAnswer()
    {
        $this->validateOnly('true_false_answer');
    }

    // Validation methods for Reorder
    public function updatedReorderFragments()
    {
        $this->validateOnly('reorder_fragments');
    }

    public function updatedReorderAnswerKey()
    {
        $this->validateOnly('reorder_answer_key');
    }

    // Validation methods for Form Fill
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

    // Validation methods for Picture MCQ
    public function updatedPictureMcqRightOptions()
    {
        $this->validateOnly('picture_mcq_right_options');
    }

    public function updatedPictureMcqImageUploads()
    {
        $this->validateOnly('picture_mcq_image_uploads');
    }

    // Validation methods for Audio MCQ Single
    public function updatedAudioMcqSubQuestions()
    {
        $this->validateOnly('audio_mcq_sub_questions');
    }

    public function updatedAudioMcqFile()
    {
        $this->validateOnly('audio_mcq_file');
    }

    // Validation methods for Audio Image Text Single
    public function updatedAudioImageTextRightOptions()
    {
        $this->validateOnly('audio_image_text_right_options');
    }

    public function updatedAudioImageTextImageUploads()
    {
        $this->validateOnly('audio_image_text_image_uploads');
    }

    public function updatedAudioImageTextAudioFile()
    {
        $this->validateOnly('audio_image_text_audio_file');
    }

    // Validation methods for Audio Image Text Multiple
    public function updatedAudioImageTextMultipleRightOptions()
    {
        $this->validateOnly('audio_image_text_multiple_right_options');
    }

    public function updatedAudioImageTextMultiplePairs()
    {
        $this->validateOnly('audio_image_text_multiple_pairs');
    }

    // Method to automatically adjust answer keys based on blank count
    public function adjustAnswerKeysToBlankCount()
    {
        if (!empty($this->form_fill_paragraph)) {
            $blankCount = substr_count($this->form_fill_paragraph, '___');
            $currentAnswerKeyCount = count($this->form_fill_answer_key);
            
            if ($blankCount > $currentAnswerKeyCount) {
                // Add more answer keys
                for ($i = $currentAnswerKeyCount; $i < $blankCount; $i++) {
                    $this->form_fill_answer_key[] = '';
                }
            } elseif ($blankCount < $currentAnswerKeyCount && $blankCount > 0) {
                // Remove excess answer keys
                $this->form_fill_answer_key = array_slice($this->form_fill_answer_key, 0, $blankCount);
            }
            
            // Ensure at least one answer key exists
            if (empty($this->form_fill_answer_key) || $blankCount === 0) {
                $this->form_fill_answer_key = [''];
            }
        }
    }
}