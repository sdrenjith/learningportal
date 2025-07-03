<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Question</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
@php
    $type = $question->question_type_id ? ($question->questionType->name ?? null) : null;
    $qdata = is_array($question->question_data) ? $question->question_data : (json_decode($question->question_data, true) ?? []);
    $answer = (isset($studentAnswer) && $studentAnswer && $studentAnswer->answer_data) ? json_decode($studentAnswer->answer_data, true) : null;
    $isReadOnly = $studentAnswer && !$editMode;
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-8 text-center animate-fade-in flex flex-col items-center">
                <svg class="w-16 h-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <h2 class="text-2xl font-bold mb-2 text-green-700">Success!</h2>
                <p class="mb-6 text-gray-700 text-lg">{{ session('success') }}</p>
                <button onclick="window.location.href='{{ route('filament.student.pages.courses') }}'" class="px-8 py-2 bg-green-500 text-white rounded-lg font-semibold shadow hover:bg-green-600 transition text-lg">OK</button>
            </div>
        </div>
    @endif
    <div class="modern-answer-form">
        <!-- Modern Answer Card -->
        <div class="modern-answer-card">
            <div class="card-content">
                <!-- Question Header Section -->
                <div class="question-header-section">
                    <div class="question-meta">
                        <span class="question-type-badge">{{ ucfirst(str_replace('_', ' ', $type ?? 'Question')) }}</span>
                        @if($question->points)
                            <span class="points-badge">{{ $question->points }} {{ $question->points == 1 ? 'Point' : 'Points' }}</span>
                        @endif
                    </div>
                    <h1 class="question-title">{{ $question->instruction ?? 'No question text available' }}</h1>
                    
                    @if($question->explanation_file)
                        <div class="explanation-file-section">
                            <div class="file-download-card">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <p class="file-title">Additional Reference</p>
                                    <a href="{{ asset('storage/' . $question->explanation_file) }}" target="_blank" class="file-link">
                                        View Explanation File
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Answer Form -->
                <form method="POST" action="{{ route('student.questions.answer.submit', $question->id) }}" class="answer-form">
                    @csrf
                    
                    <!-- MCQ Single Answer -->
                    @if($type === 'mcq_single')
                        <div class="answer-section">
                            <h3 class="section-title">Choose One Option</h3>
                            <div class="mcq-options-grid">
                                @foreach(($qdata['options'] ?? []) as $i => $option)
                                    <label class="mcq-option-item">
                                        <input type="radio" name="answer" value="{{ $i }}" class="mcq-radio"
                                            @if(isset($answer) && $answer == $i) checked @endif
                                            @if($isReadOnly) disabled @endif>
                                        <div class="option-card">
                                            <div class="option-indicator">{{ chr(65 + $i) }}</div>
                                            <span class="option-text">{{ $option }}</span>
                                            <div class="selection-mark">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- MCQ Multiple Answers -->
                    @if($type === 'mcq_multiple')
                        <div class="answer-section">
                            <h3 class="section-title">Multiple Choice Questions</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Select all correct options for each sub-question below.
                            </div>
                            
                            @foreach(($qdata['sub_questions'] ?? []) as $subIdx => $sub)
                                <div class="sub-question-item">
                                    <h4 class="sub-question-title">{{ chr(97+$subIdx) }}) {{ $sub['question'] ?? '' }}</h4>
                                    <div class="checkbox-options-grid">
                                        @foreach(($sub['options'] ?? []) as $optIdx => $opt)
                                            <label class="checkbox-option-item">
                                                <input type="checkbox" name="answer[{{ $subIdx }}][]" value="{{ $optIdx }}" class="checkbox-input"
                                                    @if(isset($answer[$subIdx]) && is_array($answer[$subIdx]) && in_array((string)$optIdx, $answer[$subIdx])) checked @endif
                                                    @if($isReadOnly) disabled @endif>
                                                <div class="checkbox-card">
                                                    <div class="checkbox-indicator">
                                                        <svg class="w-3 h-3 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="option-text">{{ $opt }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- True/False Single -->
                    @if($type === 'true_false')
                        <div class="answer-section">
                            <h3 class="section-title">True or False</h3>
                            <div class="true-false-grid">
                                <label class="tf-option-item true-option">
                                    <input type="radio" name="answer" value="true" class="tf-radio"
                                        @if(isset($studentAnswer) && $studentAnswer->answer_data && json_decode($studentAnswer->answer_data, true) === 'true') checked @endif
                                        @if($studentAnswer) disabled @endif>
                                    <div class="tf-card">
                                        <div class="tf-indicator">
                                            <svg class="w-4 h-4 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="tf-text">TRUE</span>
                                    </div>
                                </label>
                                
                                <label class="tf-option-item false-option">
                                    <input type="radio" name="answer" value="false" class="tf-radio"
                                        @if(isset($studentAnswer) && $studentAnswer->answer_data && json_decode($studentAnswer->answer_data, true) === 'false') checked @endif
                                        @if($studentAnswer) disabled @endif>
                                    <div class="tf-card">
                                        <div class="tf-indicator">
                                            <svg class="w-4 h-4 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="tf-text">FALSE</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- True/False Multiple -->
                    @if($type === 'true_false_multiple')
                        <div class="answer-section">
                            <h3 class="section-title">True or False Questions</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Answer each statement as True or False.
                            </div>
                            
                            @foreach(($question->true_false_questions ?? $qdata['questions'] ?? []) as $i => $tf)
                                <div class="sub-question-item">
                                    <h4 class="sub-question-title">{{ chr(97+$i) }}) {{ $tf['statement'] ?? '' }}</h4>
                                    <div class="true-false-grid">
                                        <label class="tf-option-item true-option">
                                            <input type="radio" name="answer[{{ $i }}]" value="true" class="tf-radio">
                                            <div class="tf-card">
                                                <div class="tf-indicator">
                                                    <svg class="w-4 h-4 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <span class="tf-text">TRUE</span>
                                            </div>
                                        </label>
                                        
                                        <label class="tf-option-item false-option">
                                            <input type="radio" name="answer[{{ $i }}]" value="false" class="tf-radio">
                                            <div class="tf-card">
                                                <div class="tf-indicator">
                                                    <svg class="w-4 h-4 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <span class="tf-text">FALSE</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Fill in the Blanks -->
                    @if($type === 'form_fill')
                        <div class="answer-section">
                            <h3 class="section-title">Fill in the Blanks</h3>
                            @php
                                $paragraph = $question->form_fill_paragraph ?? $qdata['paragraph'] ?? '';
                                $blanks = preg_match_all('/___/', $paragraph, $matches);
                                $options = $qdata['options'] ?? [];
                            @endphp
                            
                            <div class="paragraph-display-card">
                                <h4 class="paragraph-title">Complete the passage below:</h4>
                                <div class="paragraph-content">{{ $paragraph }}</div>
                            </div>
                            
                            @if($blanks)
                                <div class="blanks-grid">
                                    @for($i=0; $i<$blanks; $i++)
                                        <div class="blank-input-item">
                                            <label class="blank-label">Blank {{ $i+1 }}</label>
                                            <input type="text" name="answer[{{ $i }}]" class="blank-input" placeholder="Your answer..."
                                                @if(isset($answer[$i])) value="{{ $answer[$i] }}" @endif
                                                @if($isReadOnly) disabled @endif>
                                        </div>
                                    @endfor
                                </div>
                            @endif
                            
                            @if($options)
                                <div class="options-reference-card">
                                    <h4 class="options-title">Available Options:</h4>
                                    <div class="options-tags">
                                        @foreach($options as $option)
                                            <span class="option-tag">{{ $option }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Reorder/Rearrange -->
                    @if($type === 'reorder')
                        <div class="answer-section">
                            <h3 class="section-title">Sentence Reordering</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Arrange the fragments below to form the correct sentence.
                            </div>
                            @php $fragments = $question->reorder_fragments ?? $qdata['fragments'] ?? []; @endphp
                            <div class="fragments-display-card">
                                <h4 class="fragments-title">Fragments to arrange:</h4>
                                <div class="fragments-grid">
                                    @foreach($fragments as $index => $frag)
                                        <div class="fragment-item">
                                            <span class="fragment-number">{{ $index + 1 }}</span>
                                            <span class="fragment-text">{{ $frag }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="reorder-input-item">
                                <label class="reorder-label">Enter the correct order:</label>
                                <input type="text" name="answer" class="reorder-input" placeholder="e.g., 2,1,3,4"
                                    @if(isset($answer) && is_string($answer)) value="{{ $answer }}" @endif
                                    @if($isReadOnly) disabled @endif>
                                <div class="input-hint">Separate numbers with commas</div>
                            </div>
                        </div>
                    @endif

                    <!-- Statement Match -->
                    @if($type === 'statement_match')
                        <div class="answer-section">
                            <h3 class="section-title">Match the Following</h3>
                            @php
                                $left = $question->left_options ?? $qdata['left_options'] ?? [];
                                $right = $question->right_options ?? $qdata['right_options'] ?? [];
                            @endphp
                            <div class="matching-layout">
                                <div class="left-column">
                                    <h4 class="column-title">Items to Match</h4>
                                    <div class="left-items">
                                        @foreach($left as $i => $l)
                                            <div class="left-item-card">
                                                <span class="item-number">{{ $i + 1 }}</span>
                                                <span class="item-text">{{ $l }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="right-column">
                                    <h4 class="column-title">Your Answers</h4>
                                    <div class="matching-inputs">
                                        @foreach($left as $i => $l)
                                            <div class="match-input-item">
                                                <label class="match-label">Item {{ $i + 1 }} matches with:</label>
                                                <input type="number" name="answer[{{ $i }}]" min="1" max="{{ count($right) }}" class="match-input" placeholder="Enter number"
                                                    @if(isset($answer[$i])) value="{{ $answer[$i] }}" @endif
                                                    @if($isReadOnly) disabled @endif>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="reference-card">
                                <h4 class="reference-title">Answer Options:</h4>
                                <div class="reference-grid">
                                    @foreach($right as $j => $r)
                                        <div class="reference-item">
                                            <span class="ref-number">{{ $j+1 }}</span>
                                            <span class="ref-text">{{ $r }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Opinion/Essay -->
                    @if($type === 'opinion')
                        <div class="answer-section">
                            <h3 class="section-title">Essay Response</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Write your detailed response below. Express your thoughts clearly and completely.
                            </div>
                            
                            <div class="essay-input-item">
                                <label class="essay-label">Your Response:</label>
                                <textarea name="answer" rows="6" class="essay-textarea" placeholder="Write your detailed response here..."></textarea>
                                <div class="character-info">
                                    <span class="char-count">0 characters</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Picture MCQ -->
                    @if($type === 'picture_mcq')
                        <div class="answer-section">
                            <h3 class="section-title">Image to Text Matching</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Match each image to the correct text option.
                            </div>
                            
                            @php
                                $images = $question->picture_mcq_images ?? $qdata['images'] ?? [];
                                $right = $question->picture_mcq_right_options ?? $qdata['right_options'] ?? [];
                            @endphp
                            
                            <div class="image-matching-grid">
                                @foreach($images as $i => $img)
                                    <div class="image-match-item">
                                        <div class="image-container">
                                            <img src="{{ asset('storage/'.$img) }}" alt="Image {{ $i+1 }}" class="match-image">
                                            <div class="image-badge">Image {{ $i+1 }}</div>
                                        </div>
                                        
                                        <div class="select-area">
                                            <label class="select-label">Select answer:</label>
                                            <select name="answer[{{ $i }}]" class="image-select">
                                                <option value="">Choose option...</option>
                                                @foreach($right as $j => $opt)
                                                    <option value="{{ $j }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Audio MCQ Single -->
                    @if($type === 'audio_mcq_single')
                        <div class="answer-section">
                            <h3 class="section-title">Audio Questions</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Listen to the audio carefully and answer the questions below.
                            </div>
                            
                            @if(!empty($qdata['audio_file']))
                                <div class="audio-player-item">
                                    <div class="audio-header">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                        <span class="audio-title">Listen to Audio</span>
                                    </div>
                                    <audio controls class="audio-player">
                                        <source src="{{ asset('storage/'.$qdata['audio_file']) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endif
                            
                            @foreach(($qdata['sub_questions'] ?? []) as $subIdx => $sub)
                                <div class="sub-question-item">
                                    <h4 class="sub-question-title">{{ chr(97+$subIdx) }}) {{ $sub['question'] ?? '' }}</h4>
                                    <div class="mcq-options-grid">
                                        @foreach(($sub['options'] ?? []) as $optIdx => $opt)
                                            <label class="mcq-option-item">
                                                <input type="radio" name="answer[{{ $subIdx }}]" value="{{ $optIdx }}" class="mcq-radio">
                                                <div class="option-card">
                                                    <div class="option-indicator">{{ chr(65 + $optIdx) }}</div>
                                                    <span class="option-text">{{ $opt }}</span>
                                                    <div class="selection-mark">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Audio Image Text Single -->
                    @if($type === 'audio_image_text_single')
                        <div class="answer-section">
                            <h3 class="section-title">Audio with Image Matching</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Listen to the audio and match each image to the correct text.
                            </div>
                            
                            @if(!empty($qdata['audio_file']))
                                <div class="audio-player-item">
                                    <div class="audio-header">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                        <span class="audio-title">Listen to Audio</span>
                                    </div>
                                    <audio controls class="audio-player">
                                        <source src="{{ asset('storage/'.$qdata['audio_file']) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @endif
                            
                            @php
                                $images = $qdata['images'] ?? [];
                                $right = $qdata['right_options'] ?? [];
                            @endphp
                            
                            <div class="image-matching-grid">
                                @foreach($images as $i => $img)
                                    <div class="image-match-item">
                                        <div class="image-container">
                                            <img src="{{ asset('storage/'.$img) }}" alt="Image {{ $i+1 }}" class="match-image">
                                            <div class="image-badge">Image {{ $i+1 }}</div>
                                        </div>
                                        
                                        <div class="select-area">
                                            <label class="select-label">Select answer:</label>
                                            <select name="answer[{{ $i }}]" class="image-select">
                                                <option value="">Choose option...</option>
                                                @foreach($right as $j => $opt)
                                                    <option value="{{ $j }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Audio Image Text Multiple -->
                    @if($type === 'audio_image_text_multiple')
                        <div class="answer-section">
                            <h3 class="section-title">Audio/Image to Text Matching</h3>
                            <div class="info-banner">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                For each audio/image pair, select the correct text option.
                            </div>
                            
                            @php
                                $pairs = $qdata['pairs'] ?? [];
                                $right = $qdata['right_options'] ?? [];
                            @endphp
                            
                            <div class="pairs-grid">
                                @foreach($pairs as $i => $pair)
                                    <div class="pair-item">
                                        <div class="pair-header">
                                            <h4 class="pair-title">Pair {{ $i + 1 }}</h4>
                                        </div>
                                        
                                        <div class="pair-media">
                                            @if(!empty($pair['audio']))
                                                <div class="audio-section">
                                                    <div class="audio-header">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                        </svg>
                                                        <span class="audio-title">Listen to Audio</span>
                                                    </div>
                                                    <audio controls class="audio-player-small">
                                                        <source src="{{ asset('storage/'.$pair['audio']) }}" type="audio/mpeg">
                                                    </audio>
                                                </div>
                                            @endif
                                            
                                            @if(!empty($pair['image']))
                                                <div class="image-section">
                                                    <img src="{{ asset('storage/'.$pair['image']) }}" alt="Image {{ $i+1 }}" class="pair-image">
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="select-area">
                                            <label class="select-label">Select answer:</label>
                                            <select name="answer[{{ $i }}]" class="pair-select">
                                                <option value="">Choose option...</option>
                                                @foreach($right as $j => $opt)
                                                    <option value="{{ $j }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Audio/Picture/Video Fill Blank -->
                    @if($type === 'audio_fill_blank' || $type === 'picture_fill_blank' || $type === 'video_fill_blank')
                        <div class="answer-section">
                            <h3 class="section-title">
                                @if($type === 'audio_fill_blank') Audio @elseif($type === 'picture_fill_blank') Picture @else Video @endif
                                Fill in the Blanks
                            </h3>
                            
                            <!-- Media Display -->
                            @if($type === 'audio_fill_blank' && !empty($qdata['audio_file']))
                                <div class="audio-player-item">
                                    <div class="audio-header">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                        <span class="audio-title">Listen to Audio</span>
                                    </div>
                                    <audio controls class="audio-player">
                                        <source src="{{ asset('storage/'.$qdata['audio_file']) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @elseif($type === 'picture_fill_blank' && !empty($qdata['image_file']))
                                <div class="image-display-item">
                                    <div class="image-header">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="image-title">Reference Image</span>
                                    </div>
                                    <img src="{{ asset('storage/'.$qdata['image_file']) }}" alt="Reference Image" class="reference-image">
                                </div>
                            @elseif($type === 'video_fill_blank' && !empty($qdata['video_file']))
                                <div class="video-player-item">
                                    <div class="video-header">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="video-title">Watch Video</span>
                                    </div>
                                    <video controls class="video-player">
                                        <source src="{{ asset('storage/'.$qdata['video_file']) }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                            
                            @php
                                $paragraph = $question->audio_fill_paragraph ?? $question->picture_fill_paragraph ?? $question->video_fill_paragraph ?? $qdata['paragraph'] ?? '';
                                $blanks = preg_match_all('/___/', $paragraph, $matches);
                            @endphp
                            
                            <div class="paragraph-display-card">
                                <h4 class="paragraph-title">Fill in the blanks:</h4>
                                <div class="paragraph-content">{{ $paragraph }}</div>
                            </div>
                            
                            @if($blanks)
                                <div class="blanks-grid">
                                    @for($i=0; $i<$blanks; $i++)
                                        <div class="blank-input-item">
                                            <label class="blank-label">Blank {{ $i+1 }}</label>
                                            <input type="text" name="answer[{{ $i }}]" class="blank-input" placeholder="Your answer..."
                                                @if(isset($answer[$i])) value="{{ $answer[$i] }}" @endif
                                                @if($isReadOnly) disabled @endif>
                                        </div>
                                    @endfor
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="submit-section">
                        @if($isReadOnly)
                            <button type="button" onclick="window.location.href='{{ route('filament.student.pages.courses') }}'" class="submit-btn mx-auto" style="max-width:300px;">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                Go Back
                            </button>
                        @else
                            <button type="submit" class="submit-btn mx-auto" style="max-width:300px;">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ $editMode ? 'Update Answer' : 'Submit Answer' }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Answer Form Base Styles */
.modern-answer-form {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1.5rem;
}

.modern-answer-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    border: 1px solid #e5e7eb;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-answer-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.card-content {
    padding: 2rem;
}

/* Question Header Styles */
.question-header-section {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
}

.question-meta {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.question-type-badge {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    color: white;
    padding: 0.375rem 0.875rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.points-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 0.375rem 0.875rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.question-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    line-height: 1.4;
}

/* Explanation File */
.explanation-file-section {
    margin-top: 1rem;
}

.file-download-card {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: 1px solid #3b82f6;
    transition: all 0.3s ease;
}

.file-download-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px -4px rgba(59, 130, 246, 0.3);
}

.file-title {
    font-weight: 600;
    color: #1e40af;
    margin: 0;
    font-size: 0.875rem;
}

.file-link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Answer Sections */
.answer-section {
    margin-bottom: 2rem;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 16px;
    padding: 1.5rem;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.answer-section:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px -4px rgba(59, 130, 246, 0.15);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title::before {
    content: '';
    width: 3px;
    height: 1.5rem;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 2px;
}

/* Info Banner */
.info-banner {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: 1px solid #f59e0b;
    margin-bottom: 1.25rem;
    font-weight: 500;
    color: #92400e;
    font-size: 0.875rem;
}

/* MCQ Styles */
.mcq-options-grid {
    display: grid;
    gap: 0.75rem;
}

.mcq-option-item {
    cursor: pointer;
}

.mcq-radio {
    display: none;
}

.option-card {
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.option-card:hover {
    border-color: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px -4px rgba(59, 130, 246, 0.2);
}

.mcq-option-item:has(.mcq-radio:checked) .option-card {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.option-indicator {
    width: 2rem;
    height: 2rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    margin-right: 0.75rem;
    flex-shrink: 0;
}

.option-text {
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    flex: 1;
}

.selection-mark {
    width: 1.5rem;
    height: 1.5rem;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.mcq-option-item:has(.mcq-radio:checked) .selection-mark {
    background: #10b981;
    border-color: #10b981;
    color: white;
}

/* Checkbox Styles */
.checkbox-options-grid {
    display: grid;
    gap: 0.5rem;
}

.checkbox-option-item {
    cursor: pointer;
}

.checkbox-input {
    display: none;
}

.checkbox-card {
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.checkbox-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 2px 8px -2px rgba(59, 130, 246, 0.2);
}

.checkbox-option-item:has(.checkbox-input:checked) .checkbox-card {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-color: #3b82f6;
}

.checkbox-indicator {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.5rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.checkbox-option-item:has(.checkbox-input:checked) .checkbox-indicator {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.checkmark {
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s ease;
}

.checkbox-option-item:has(.checkbox-input:checked) .checkmark {
    opacity: 1;
    transform: scale(1);
}

/* True/False Styles */
.true-false-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.tf-option-item {
    cursor: pointer;
}

.tf-radio {
    display: none;
}

.tf-card {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.tf-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.15);
}

.tf-option-item:has(.tf-radio:checked).true-option .tf-card {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border-color: #10b981;
}

.tf-option-item:has(.tf-radio:checked).false-option .tf-card {
    background: linear-gradient(135deg, #fee2e2, #fca5a5);
    border-color: #ef4444;
}

.tf-indicator {
    width: 2rem;
    height: 2rem;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    transition: all 0.3s ease;
}

.tf-option-item:has(.tf-radio:checked) .tf-indicator {
    border-color: #10b981;
    color: white;
}

.true-option:has(.tf-radio:checked) .tf-indicator {
    background: #10b981;
}

.false-option:has(.tf-radio:checked) .tf-indicator {
    background: #ef4444;
    border-color: #ef4444;
}

.tf-text {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
}

/* Sub Question Items */
.sub-question-item {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.sub-question-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 2px 8px -2px rgba(59, 130, 246, 0.15);
}

.sub-question-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.75rem;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Fill in Blanks */
.paragraph-display-card {
    background: linear-gradient(135deg, #fef7ff, #f3e8ff);
    border: 2px solid #a855f7;
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
}

.paragraph-title {
    font-size: 1rem;
    font-weight: 700;
    color: #7c2d92;
    margin-bottom: 0.75rem;
}

.paragraph-content {
    font-size: 1rem;
    line-height: 1.6;
    color: #1f2937;
    white-space: pre-wrap;
}

.blanks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.blank-input-item {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.blank-input-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 2px 8px -2px rgba(59, 130, 246, 0.15);
}

.blank-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.blank-input {
    width: 100%;
    padding: 0.625rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.blank-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Options Reference */
.options-reference-card {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 1px solid #0ea5e9;
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
}

.options-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #0c4a6e;
    margin-bottom: 0.75rem;
}

.options-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.option-tag {
    background: white;
    border: 1px solid #0ea5e9;
    color: #0c4a6e;
    padding: 0.375rem 0.625rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Reorder Styles */
.fragments-display-card {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border: 2px solid #f59e0b;
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
}

.fragments-title {
    font-size: 1rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 0.75rem;
}

.fragments-grid {
    display: grid;
    gap: 0.75rem;
}

.fragment-item {
    display: flex;
    align-items: center;
    background: white;
    border: 1px solid #f59e0b;
    border-radius: 8px;
    padding: 0.75rem;
    gap: 0.75rem;
}

.fragment-number {
    width: 1.5rem;
    height: 1.5rem;
    background: #f59e0b;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.fragment-text {
    font-size: 0.875rem;
    color: #374151;
    font-weight: 500;
}

.reorder-input-item {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
}

.reorder-label {
    display: block;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.reorder-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.reorder-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.input-hint {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: #6b7280;
    font-style: italic;
}

/* Statement Match */
.matching-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.column-title {
    font-size: 1rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.75rem;
}

.left-items {
    display: grid;
    gap: 0.75rem;
}

.left-item-card {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border: 1px solid #3b82f6;
    border-radius: 8px;
    padding: 0.75rem;
    gap: 0.75rem;
}

.item-number {
    width: 1.5rem;
    height: 1.5rem;
    background: #3b82f6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.item-text {
    font-size: 0.875rem;
    color: #374151;
    font-weight: 500;
}

.matching-inputs {
    display: grid;
    gap: 0.75rem;
}

.match-input-item {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
}

.match-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.75rem;
}

.match-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.match-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.reference-card {
    background: linear-gradient(135deg, #fef7ff, #f3e8ff);
    border: 1px solid #a855f7;
    border-radius: 12px;
    padding: 1rem;
}

.reference-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #7c2d92;
    margin-bottom: 0.75rem;
}

.reference-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 0.5rem;
}

.reference-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.ref-number {
    background: #a855f7;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 700;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.ref-text {
    color: #374151;
    font-weight: 500;
    font-size: 0.875rem;
}

/* Essay Styles */
.essay-input-item {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.essay-input-item:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.essay-label {
    display: block;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}

.essay-textarea {
    width: 100%;
    border: none;
    outline: none;
    font-size: 0.875rem;
    line-height: 1.6;
    color: #374151;
    resize: vertical;
    min-height: 120px;
}

.character-info {
    display: flex;
    justify-content: flex-end;
    margin-top: 0.5rem;
}

.char-count {
    font-size: 0.75rem;
    color: #6b7280;
}

/* Image Matching */
.image-matching-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.image-match-item {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.image-match-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px -4px rgba(59, 130, 246, 0.15);
}

.image-container {
    text-align: center;
    margin-bottom: 1rem;
}

.match-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
}

.image-badge {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
}

.select-area {
    display: grid;
    gap: 0.5rem;
}

.select-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.75rem;
}

.image-select, .pair-select {
    padding: 0.5rem;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    background: white;
    transition: all 0.3s ease;
}

.image-select:focus, .pair-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Audio/Video Players */
.audio-player-item, .video-player-item, .image-display-item {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 2px solid #0ea5e9;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    max-height: unset;
}
.audio-header, .video-header, .image-header {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    margin-bottom: 0;
    min-width: 120px;
}
.audio-title, .video-title, .image-title {
    font-weight: 600;
    color: #0c4a6e;
    font-size: 0.85rem;
    margin-left: 0.25rem;
}
.audio-player {
    width: 100%;
    height: 36px;
    border-radius: 4px;
    margin-left: 0.5rem;
}
.audio-player-small {
    width: 100%;
    height: 28px;
    border-radius: 4px;
    margin-left: 0.5rem;
}
@media (max-width: 768px) {
    .audio-player-item, .video-player-item, .image-display-item {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
        padding: 0.5rem 0.5rem;
    }
    .audio-header, .video-header, .image-header {
        min-width: 0;
        margin-bottom: 0.25rem;
    }
    .audio-player, .audio-player-small {
        margin-left: 0;
    }
}
.submit-section {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e5e7eb;
}
.submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 1.1rem 0;
    border: none;
    border-radius: 12px;
    font-size: 1.15rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px -4px rgba(16, 185, 129, 0.4);
    margin: 0 auto;
    max-width: 400px;
}
.submit-btn svg {
    width: 1.5rem;
    height: 1.5rem;
    margin-right: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modern-answer-form {
        padding: 1rem;
    }
    
    .card-content {
        padding: 1.5rem;
    }
    
    .question-title {
        font-size: 1.25rem;
    }
    
    .true-false-grid {
        grid-template-columns: 1fr;
    }
    
    .matching-layout {
        grid-template-columns: 1fr;
    }
    
    .image-matching-grid {
        grid-template-columns: 1fr;
    }
    
    .pair-media {
        grid-template-columns: 1fr;
    }
    
    .blanks-grid {
        grid-template-columns: 1fr;
    }
    
    .match-image, .pair-image {
        width: 100px;
        height: 100px;
    }
    
    .reference-grid {
        grid-template-columns: 1fr;
    }
    
    .audio-player-item, .video-player-item, .image-display-item {
        max-height: 70px;
        padding: 0.625rem;
    }
    
    .audio-player {
        height: 28px;
    }
    
    .reference-image {
        max-height: 150px;
    }
}

@media (max-width: 480px) {
    .card-content {
        padding: 1rem;
    }
    
    .question-meta {
        flex-direction: column;
        align-items: center;
    }
    
    .option-card {
        padding: 0.75rem;
    }
    
    .match-image, .pair-image {
        width: 80px;
        height: 80px;
    }
    
    .fragments-grid {
        gap: 0.5rem;
    }
    
    .fragment-item {
        padding: 0.5rem;
    }
    
    .audio-player-item, .video-player-item, .image-display-item {
        max-height: 60px;
        padding: 0.5rem;
    }
    
    .audio-header, .video-header, .image-header {
        margin-bottom: 0.25rem;
        gap: 0.25rem;
    }
    
    .audio-title, .video-title, .image-title {
        font-size: 0.625rem;
    }
    
    .audio-player {
        height: 24px;
    }
    
    .audio-section {
        max-height: 50px;
        padding: 0.375rem;
    }
    
    .reference-image {
        max-height: 120px;
    }
}

/* Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.answer-section {
    animation: slideInUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Focus and Accessibility */
.mcq-option-item:focus-within,
.checkbox-option-item:focus-within,
.tf-option-item:focus-within {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
    border-radius: 12px;
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .modern-answer-card {
        border: 2px solid #000;
    }
    
    .option-card,
    .checkbox-card,
    .tf-card {
        border: 2px solid #000;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

@keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fade-in 0.4s ease; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for essay textarea
    const essayTextarea = document.querySelector('.essay-textarea');
    if (essayTextarea) {
        const charCount = document.querySelector('.char-count');
        essayTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = `${count} characters`;
            
            // Visual feedback for length
            if (count > 500) {
                charCount.style.color = '#059669'; // green
            } else if (count > 200) {
                charCount.style.color = '#d97706'; // orange  
            } else {
                charCount.style.color = '#6b7280'; // gray
            }
        });
    }
    
    // Auto-save functionality
    const form = document.querySelector('.answer-form');
    const inputs = form.querySelectorAll('input, textarea, select');
    
    // Save answers to localStorage as backup
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            saveAnswersToLocalStorage();
        });
    });
    
    function saveAnswersToLocalStorage() {
        const formData = new FormData(form);
        const answers = {};
        for (let [key, value] of formData.entries()) {
            if (answers[key]) {
                if (Array.isArray(answers[key])) {
                    answers[key].push(value);
                } else {
                    answers[key] = [answers[key], value];
                }
            } else {
                answers[key] = value;
            }
        }
        localStorage.setItem('temp_answers', JSON.stringify(answers));
    }
    
    // Form validation before submit
    form.addEventListener('submit', function(e) {
        let hasErrors = false;
        const errorElements = document.querySelectorAll('.error-highlight');
        errorElements.forEach(el => el.classList.remove('error-highlight'));
        
        // Check for required fields based on question type
        const questionType = document.querySelector('.question-type-badge').textContent.toLowerCase();
        
        if (questionType.includes('mcq') || questionType.includes('true') || questionType.includes('audio')) {
            const radioGroups = {};
            form.querySelectorAll('input[type="radio"]').forEach(radio => {
                if (!radioGroups[radio.name]) {
                    radioGroups[radio.name] = false;
                }
                if (radio.checked) {
                    radioGroups[radio.name] = true;
                }
            });
            
            Object.keys(radioGroups).forEach(groupName => {
                if (!radioGroups[groupName]) {
                    hasErrors = true;
                    const radioGroup = form.querySelector(`input[name="${groupName}"]`).closest('.sub-question-item, .answer-section');
                    if (radioGroup) {
                        radioGroup.style.border = '2px solid #ef4444';
                        radioGroup.classList.add('error-highlight');
                    }
                }
            });
        }
        
        // Check text inputs
        form.querySelectorAll('input[type="text"], textarea').forEach(input => {
            if (input.hasAttribute('required') || input.closest('.blank-input-item, .match-input-item')) {
                if (!input.value.trim()) {
                    hasErrors = true;
                    input.style.borderColor = '#ef4444';
                    input.classList.add('error-highlight');
                }
            }
        });
        
        // Check selects
        form.querySelectorAll('select').forEach(select => {
            if (!select.value) {
                hasErrors = true;
                select.style.borderColor = '#ef4444';
                select.classList.add('error-highlight');
            }
        });
        
        if (hasErrors) {
            e.preventDefault();
            
            // Scroll to first error
            const firstError = document.querySelector('.error-highlight');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            // Show error message
            showMessage('Please complete all required fields before submitting.', 'error');
        } else {
            // Clear localStorage backup on successful submit
            localStorage.removeItem('temp_answers');
            
            // Add loading state to submit button
            const submitBtn = document.querySelector('.submit-btn');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Submitting...';
            submitBtn.disabled = true;
            
            // Restore button after 5 seconds (in case of network issues)
            setTimeout(() => {
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
            }, 5000);
        }
    });
    
    // Message system
    function showMessage(text, type = 'info') {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-alert ${type}`;
        messageDiv.innerHTML = `
            <div class="message-content">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'error' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    }
                </svg>
                <span>${text}</span>
            </div>
        `;
        
        // Style the message
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            padding: 12px 16px;
            border-radius: 8px;
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            font-weight: 500;
            max-width: 300px;
            animation: slideInRight 0.3s ease;
            ${type === 'error' ? 
                'background: linear-gradient(135deg, #fee2e2, #fca5a5); border: 1px solid #ef4444; color: #7f1d1d;' :
                'background: linear-gradient(135deg, #dbeafe, #bfdbfe); border: 1px solid #3b82f6; color: #1e3a8a;'
            }
        `;
        
        messageDiv.querySelector('.message-content').style.cssText = 'display: flex; align-items: center;';
        
        document.body.appendChild(messageDiv);
        
        // Remove message after 5 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
    
    // Clear error highlighting on input
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.style.borderColor = '';
            this.classList.remove('error-highlight');
            const container = this.closest('.sub-question-item, .answer-section');
            if (container) {
                container.style.border = '';
                container.classList.remove('error-highlight');
            }
        });
    });
    
    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Submit with Ctrl+Enter
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit', { cancelable: true }));
        }
        
        // Clear all answers with Ctrl+R (prevent page refresh)
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (confirm('Clear all answers?')) {
                form.reset();
                localStorage.removeItem('temp_answers');
                // Silent clear - no message shown
            }
        }
    });
    
    // Add visual feedback for interactions
    const interactiveElements = document.querySelectorAll('.mcq-option-item, .checkbox-option-item, .tf-option-item');
    interactiveElements.forEach(element => {
        element.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
    
    // Auto-resize textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
});

// Add CSS animation for message alerts
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);

@keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.animate-fade-in { animation: fade-in 0.3s ease; }
</script>
</body>
</html>