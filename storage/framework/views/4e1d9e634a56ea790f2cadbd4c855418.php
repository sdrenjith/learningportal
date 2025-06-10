<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $courses = $courses ?? \App\Models\Course::all();
        $subjects = $subjects ?? \App\Models\Subject::all();
        $levels = $levels ?? \App\Models\Level::all();
        $questionTypes = $questionTypes ?? \App\Models\QuestionType::all();
    ?>
    <div class="modern-question-form">
        <form wire:submit="update">
            <?php echo csrf_field(); ?>
            
            <!-- Single Full-Width Card -->
            <div class="modern-card">
                <div class="card-content">
                    <!-- Question Details Section -->
                    <div class="section-block">
                        <h3 class="section-title">Question Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Day Number *</label>
                                <input type="number" wire:model="day_number_input" min="1" placeholder="1" class="modern-input">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['day_number_input'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="modern-label">Course *</label>
                                <select wire:model="course_id" class="modern-select" required>
                                    <option value="" disabled>Select course</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($course->id); ?>"><?php echo e($course->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="modern-label">Subject *</label>
                                <select wire:model="subject_id" class="modern-select">
                                    <option value="">Select subject</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subject_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="modern-label">Question Type *</label>
                                <select wire:model="question_type_id" class="modern-select" id="question_type_id">
                                    <option value="">Select type</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $questionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->name === 'statement_match' ? 'statement_match' : ($type->name === 'opinion' ? 'opinion' : ($type->name === 'mcq_multiple' ? 'mcq_multiple' : ($type->name === 'reorder' ? 'reorder' : ($type->name === 'form_fill' ? 'form_fill' : $type->id))))); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $type->name))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['question_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="modern-label">Marks</label>
                                <input type="number" wire:model="points" min="1" placeholder="1" class="modern-input">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['points'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div class="flex items-center pt-6">
                                <label class="modern-checkbox-label">
                                    <input type="checkbox" wire:model="is_active" class="modern-checkbox">
                                    <span class="ml-2">Active Question</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Question Content Section -->
                    <div class="section-block">
                        <h3 class="section-title">Question Content</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Question Instruction *</label>
                                <textarea wire:model="instruction" rows="4" placeholder="Enter the question instruction..."
                                          class="modern-textarea"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['instruction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="modern-label">Explanation File (Optional)</label>
                                <!--[if BLOCK]><![endif]--><?php if($explanation): ?>
                                    <div class="mb-2 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                                        <span class="text-sm text-blue-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Current: <?php echo e(basename($explanation)); ?>

                                        </span>
                                        <button type="button" wire:click="removeExplanationFile" class="text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <input type="file" wire:model="explanation_file" class="modern-input" accept="*/*">
                                <small class="text-gray-500"><?php echo e($explanation ? 'Upload new file to replace current one' : 'Upload an explanation file'); ?></small>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['explanation_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>

                    <div x-data="{ type: $wire.entangle('question_type_id') }">
                        <!-- Form Fill Section -->
                        <div class="section-block" id="form-fill-section" x-show="type === 'form_fill'">
                            <h3 class="section-title">Form Fill (Fill in the Blanks)</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                This is a fill-in-the-blanks question where students select from available options to complete the paragraph.
                            </div>
                            
                            <!-- Paragraph with Blanks -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Paragraph with Blanks</h4>
                                <div class="form-fill-paragraph-section">
                                    <label class="modern-label">Paragraph Text (use ___ for blanks) *</label>
                                    <textarea wire:model.live.debounce.100ms="form_fill_paragraph" rows="6" 
                                              placeholder="Enter your paragraph here. Use ___ (three underscores) to mark blanks where students should fill in answers. For example: The capital of France is ___. It is located in the ___ of the country."
                                              class="modern-textarea"><?php echo e($record->form_fill_paragraph); ?></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form_fill_paragraph'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(trim($form_fill_paragraph ?? '')): ?>
                                        <div class="paragraph-info">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Contains <?php echo e(substr_count($form_fill_paragraph, '___')); ?> blank(s) to fill.</span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Options -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Answer Options</h4>
                                <div class="space-y-4">
                                    <?php
                                        $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                                        $options = $questionData['options'] ?? [];
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-fill-option-item" wire:key="form_fill_option_<?php echo e($index); ?>">
                                            <div class="flex items-center space-x-3">
                                                <div class="option-number"><?php echo e($index + 1); ?></div>
                                                <div class="flex-1">
                                                    <input type="text" wire:model.defer="form_fill_options.<?php echo e($index); ?>" 
                                                           value="<?php echo e($option); ?>"
                                                           placeholder="Enter answer option..." class="option-input">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["form_fill_options.{$index}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                                        <button type="button" wire:click="addFormFillOption" class="add-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <!--[if BLOCK]><![endif]--><?php if($index > 1): ?>
                                                        <button type="button" wire:click="removeFormFillOption(<?php echo e($index); ?>)" class="remove-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Answer Keys -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Answer Keys</h4>
                                <div class="answer-key-section">
                                    <div class="answer-key-info mb-4">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Provide the correct answer for each blank in order. The answer must match exactly one of the options above.</span>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <?php
                                            $answerData = is_string($record->answer_data) ? json_decode($record->answer_data, true) : $record->answer_data;
                                            $answerKeys = $answerData['answer_keys'] ?? [];
                                        ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $answerKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answerKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="answer-key-item" wire:key="form_fill_answer_<?php echo e($index); ?>">
                                                <div class="flex items-center space-x-3">
                                                    <div class="answer-number">Blank <?php echo e($index + 1); ?></div>
                                                    <div class="flex-1">
                                                        <input type="text" wire:model.defer="form_fill_answer_key.<?php echo e($index); ?>" 
                                                               value="<?php echo e($answerKey); ?>"
                                                               placeholder="Enter the correct answer for blank <?php echo e($index + 1); ?>..." class="option-input">
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["form_fill_answer_key.{$index}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                                            <button type="button" wire:click="addFormFillAnswerKey" class="add-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                </svg>
                                                            </button>
                                                        <?php else: ?>
                                                            <button type="button" wire:click="removeFormFillAnswerKey(<?php echo e($index); ?>)" class="remove-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="mb-6" wire:key="form-fill-preview-<?php echo e(count($form_fill_options)); ?>-<?php echo e(count($form_fill_answer_key)); ?>">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <?php
                                        $filteredAnswerKeys = array_filter($form_fill_answer_key, fn($a) => trim($a ?? '') !== '');
                                        $previewParagraph = trim($form_fill_paragraph ?? '');
                                        $hasValidPreview = $previewParagraph && count($filteredAnswerKeys) > 0;
                                        
                                        // Create preview with filled answers
                                        if ($hasValidPreview) {
                                            $answerIndex = 0;
                                            $filledParagraph = preg_replace_callback('/___/', function($matches) use ($filteredAnswerKeys, &$answerIndex) {
                                                if ($answerIndex < count($filteredAnswerKeys)) {
                                                    $answer = trim($filteredAnswerKeys[$answerIndex]);
                                                    $answerIndex++;
                                                    if (!empty($answer)) {
                                                        return '<span class="filled-answer">' . $answer . '</span>';
                                                    }
                                                }
                                                return '<span class="empty-blank">___</span>';
                                            }, $previewParagraph);
                                        }
                                    ?>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if($hasValidPreview): ?>
                                        <div class="preview-filled-main" wire:key="main-preview-<?php echo e(md5($previewParagraph . implode('', $filteredAnswerKeys))); ?>">
                                            <p class="preview-label-main">✅ Final Sentence with Answers:</p>
                                            <div class="filled-paragraph-main"><?php echo $filledParagraph; ?></div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(trim($form_fill_paragraph ?? '')): ?>
                                        <div class="preview-paragraph" wire:key="paragraph-preview-<?php echo e(md5($form_fill_paragraph)); ?>">
                                            <p class="preview-label">Original paragraph with blanks:</p>
                                            <div class="paragraph-preview"><?php echo e(trim($form_fill_paragraph)); ?></div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <div class="preview-options" wire:key="options-preview-<?php echo e(count($form_fill_options)); ?>">
                                        <p class="preview-label">Available options for students:</p>
                                        <div class="options-preview">
                                            <?php
                                                $filteredOptions = array_filter($form_fill_options, fn($o) => trim($o ?? '') !== '');
                                            ?>
                                            <!--[if BLOCK]><![endif]--><?php if(count($filteredOptions) > 0): ?>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form_fill_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <!--[if BLOCK]><![endif]--><?php if(trim($option ?? '') !== ''): ?>
                                                        <span class="option-preview" wire:key="option-preview-<?php echo e($index); ?>-<?php echo e(md5($option)); ?>"><?php echo e(trim($option)); ?></span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <span class="no-options-message">No options added yet...</span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reorder Section -->
                        <div class="section-block" id="reorder-section" x-show="type === 'reorder'">
                            <h3 class="section-title">Sentence Reordering</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Create sentence fragments that students will drag and drop to form the correct sentence. Add the answer key to validate the correct order.
                            </div>
                            
                            <!-- Sentence Fragments -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Sentence Fragments</h4>
                                <div class="space-y-4">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reorder_fragments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fragment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="reorder-fragment-item" wire:key="fragment_<?php echo e($index); ?>">
                                            <div class="flex items-center space-x-3">
                                                <div class="fragment-number"><?php echo e($index + 1); ?></div>
                                                <div class="flex-1">
                                                    <input type="text" wire:model.live.debounce.300ms="reorder_fragments.<?php echo e($index); ?>" 
                                                           placeholder="Enter sentence fragment..." class="option-input">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["reorder_fragments.{$index}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                                        <button type="button" wire:click="addReorderFragment" class="add-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <!--[if BLOCK]><![endif]--><?php if($index > 1): ?>
                                                        <button type="button" wire:click="removeReorderFragment(<?php echo e($index); ?>)" class="remove-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Answer Key -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Answer Key</h4>
                                <div class="answer-key-section">
                                    <label class="modern-label">Correct Sentence (Answer Key) *</label>
                                    <textarea wire:model.live.debounce.500ms="reorder_answer_key" rows="3" 
                                              placeholder="Enter the complete correct sentence that should be formed when fragments are arranged properly..."
                                              class="modern-textarea bg-green-50 border-green-200"></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['reorder_answer_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="answer-key-info mt-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>This is the target sentence that students should create by reordering the fragments above.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <!--[if BLOCK]><![endif]--><?php if(count($reorder_fragments) > 0 && trim($reorder_answer_key ?? '')): ?>
                                <div class="mb-6">
                                    <h4 class="sub-question-title mb-4">Preview</h4>
                                    <div class="preview-section">
                                        <div class="preview-fragments">
                                            <p class="preview-label">Fragments to be reordered:</p>
                                            <div class="fragments-preview">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reorder_fragments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fragment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="fragment-preview"><?php echo e(trim($fragment)); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                        <div class="preview-answer">
                                            <p class="preview-label">Expected result:</p>
                                            <div class="answer-preview"><?php echo e(trim($reorder_answer_key)); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- True/False Multiple Section -->
                        <div class="section-block" id="true-false-multiple-section" x-show="type === 'true_false_multiple'">
                            <h3 class="section-title">True/False Multiple Questions</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Multiple True/False statements for students to evaluate.
                            </div>
                            
                            <div class="space-y-6">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $true_false_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tfIndex => $tfQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="true-false-item" wire:key="tf_question_<?php echo e($tfIndex); ?>">
                                        <!-- True/False Question Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="sub-question-title">Statement <?php echo e(chr(97 + $tfIndex)); ?>)</h4>
                                            <div class="button-group">
                                                <!--[if BLOCK]><![endif]--><?php if($tfIndex === 0): ?>
                                                    <button type="button" wire:click="addTrueFalseQuestion" class="add-btn">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        Add Statement
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" wire:click="removeTrueFalseQuestion(<?php echo e($tfIndex); ?>)" class="remove-btn">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Remove Statement
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                        
                                        <!-- True/False Question Content -->
                                        <div class="true-false-content">
                                            <div class="mb-4">
                                                <label class="modern-label">Statement Text</label>
                                                <textarea wire:model.live.debounce.300ms="true_false_questions.<?php echo e($tfIndex); ?>.text" 
                                                          rows="3" placeholder="Enter the statement text..." class="modern-textarea"></textarea>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["true_false_questions.{$tfIndex}.text"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="mb-4">
                                                <label class="modern-label">Correct Answer</label>
                                                <div class="true-false-options">
                                                    <button type="button"
                                                        class="true-false-option <?php echo e(($true_false_questions[$tfIndex]['correct_answer'] ?? '') === 'true' ? 'selected' : ''); ?>"
                                                        wire:click="$set('true_false_questions.<?php echo e($tfIndex); ?>.correct_answer', 'true')">
                                                        <div class="option-circle">
                                                            <svg class="w-5 h-5 checkmark <?php echo e(($true_false_questions[$tfIndex]['correct_answer'] ?? '') === 'true' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="true-false-label">True</span>
                                                    </button>
                                                    <button type="button"
                                                        class="true-false-option <?php echo e(($true_false_questions[$tfIndex]['correct_answer'] ?? '') === 'false' ? 'selected' : ''); ?>"
                                                        wire:click="$set('true_false_questions.<?php echo e($tfIndex); ?>.correct_answer', 'false')">
                                                        <div class="option-circle">
                                                            <svg class="w-5 h-5 checkmark <?php echo e(($true_false_questions[$tfIndex]['correct_answer'] ?? '') === 'false' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="true-false-label">False</span>
                                                    </button>
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["true_false_questions.{$tfIndex}.correct_answer"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- MCQ Multiple Section -->
                        <div class="section-block" id="mcq-multiple-section" x-show="type === 'mcq_multiple'">
                            <h3 class="section-title">MCQ Multiple Questions</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Multiple sub-questions each with their own options and correct answers.
                            </div>
                            
                            <div class="space-y-6">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sub_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subIndex => $subQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="sub-question-item" wire:key="sub_question_<?php echo e($subIndex); ?>">
                                        <!-- Sub Question Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="sub-question-title">Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</h4>
                                            <div class="button-group">
                                                <!--[if BLOCK]><![endif]--><?php if($subIndex === 0): ?>
                                                    <button type="button" wire:click="addSubQuestion" class="add-btn">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        Add Sub-question
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" wire:click="removeSubQuestion(<?php echo e($subIndex); ?>)" class="remove-btn">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Remove Sub-question
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <!-- Sub Question Text -->
                                        <div class="mb-4">
                                            <label class="modern-label">Sub-question Text</label>
                                            <textarea wire:model.live.debounce.300ms="sub_questions.<?php echo e($subIndex); ?>.question" 
                                                      rows="2" placeholder="Enter the sub-question text..." class="modern-textarea"></textarea>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["sub_questions.{$subIndex}.question"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <!-- Sub Question Options -->
                                        <div class="mb-4">
                                            <label class="modern-label">Options</label>
                                            <div class="space-y-3">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sub_questions[$subIndex]['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="option-item" wire:key="option_<?php echo e($subIndex); ?>_<?php echo e($optIndex); ?>">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="option-number"><?php echo e($optIndex + 1); ?></div>
                                                            <div class="flex-1">
                                                                <input type="text" wire:model.live.debounce.300ms="sub_questions.<?php echo e($subIndex); ?>.options.<?php echo e($optIndex); ?>" 
                                                                       placeholder="Enter option text..." class="option-input">
                                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["sub_questions.{$subIndex}.options.{$optIndex}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div>
                                                            <div class="flex items-center space-x-2">
                                                                <!--[if BLOCK]><![endif]--><?php if($optIndex === 0): ?>
                                                                    <button type="button" wire:click="addSubQuestionOption(<?php echo e($subIndex); ?>)" class="add-btn-small">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                        </svg>
                                                                    </button>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                <!--[if BLOCK]><![endif]--><?php if($optIndex > 1): ?>
                                                                    <button type="button" wire:click="removeSubQuestionOption(<?php echo e($subIndex); ?>, <?php echo e($optIndex); ?>)" class="remove-btn-small">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <!-- Correct Answer Indices -->
                                        <div class="mb-4">
                                            <label class="modern-label">Correct Answer Indices</label>
                                            <div class="space-y-2">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sub_questions[$subIndex]['correct_indices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ansIndex => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="index-item" wire:key="correct_index_<?php echo e($subIndex); ?>_<?php echo e($ansIndex); ?>">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <label class="option-label">Answer Index <?php echo e($ansIndex + 1); ?></label>
                                                            <div class="text-sm text-gray-600 bg-green-100 px-3 py-1 rounded-full">
                                                                Points to: "<?php echo e($sub_questions[$subIndex]['options'][$correctIndex] ?? 'Option not found'); ?>"
                                                            </div>
                                                        </div>
                                                        <input type="number" wire:model.live.debounce.300ms="sub_questions.<?php echo e($subIndex); ?>.correct_indices.<?php echo e($ansIndex); ?>" 
                                                               min="0" placeholder="0" class="index-input bg-green-50 border-green-200">
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["sub_questions.{$subIndex}.correct_indices.{$ansIndex}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Preview Section -->
                            <div class="mb-6" wire:key="mcq-multiple-preview-<?php echo e(count($sub_questions)); ?>">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sub_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subIndex => $subQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="sub-question-item">
                                            <div class="mb-4">
                                                <h5 class="font-semibold mb-2">Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</h5>
                                                <div class="statement-text">
                                                    <?php echo e($subQuestion['question'] ?? ''); ?>

                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <p class="preview-label">Options:</p>
                                                <div class="space-y-3">
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestion['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="option-item">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="option-number"><?php echo e($optIndex + 1); ?></div>
                                                                <div class="flex-1">
                                                                    <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                            
                                            <!--[if BLOCK]><![endif]--><?php if(count($subQuestion['correct_indices'] ?? []) > 0): ?>
                                                <div class="mb-4">
                                                    <p class="preview-label">Correct Answer Indices:</p>
                                                    <div class="space-y-2">
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestion['correct_indices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ansIndex => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="index-item">
                                                                <div class="flex items-center justify-between mb-3">
                                                                    <label class="option-label">Answer Index <?php echo e($ansIndex + 1); ?></label>
                                                                    <div class="text-sm text-gray-600 bg-green-100 px-3 py-1 rounded-full">
                                                                        Points to: "<?php echo e($subQuestion['options'][$correctIndex] ?? 'Option not found'); ?>"
                                                                    </div>
                                                                </div>
                                                                <input type="number" value="<?php echo e($correctIndex); ?>" class="index-input bg-green-50 border-green-200" readonly>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Media Upload Section (hidden by default) -->
                        <div class="section-block" id="media-upload-section" style="display:none;">
                            <h3 class="section-title">Media Upload</h3>
                            <input type="file" name="media_file" id="media_file" class="modern-input" accept="audio/*,image/*">
                            <small class="text-gray-500">Upload an audio or image file as required by the question type.</small>
                        </div>

                        <!-- Statement Match Section -->
                        <div class="section-block" id="statement-match-section" x-show="type === 'statement_match'">
                            <h3 class="section-title">Statement Match</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Students match left side options with corresponding right side options.
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Side Options -->
                                <div>
                                    <h5 class="font-semibold mb-2">Left Side Options</h5>
                                    <div class="space-y-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $left_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item" wire:key="left_option_<?php echo e($idx); ?>">
                                                <div class="flex items-center space-x-3">
                                                    <div class="option-number"><?php echo e($idx + 1); ?></div>
                                                    <div class="flex-1">
                                                        <input type="text" wire:model.live.debounce.300ms="left_options.<?php echo e($idx); ?>" 
                                                               placeholder="Enter left option..." class="option-input">
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["left_options.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <!--[if BLOCK]><![endif]--><?php if($idx === 0): ?>
                                                            <button type="button" wire:click="addLeftOption" class="add-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                </svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <!--[if BLOCK]><![endif]--><?php if($idx > 1): ?>
                                                            <button type="button" wire:click="removeLeftOption(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                
                                <!-- Right Side Options -->
                                <div>
                                    <h5 class="font-semibold mb-2">Right Side Options</h5>
                                    <div class="space-y-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item" wire:key="right_option_<?php echo e($idx); ?>">
                                                <div class="flex items-center space-x-3">
                                                    <div class="option-number"><?php echo e($idx + 1); ?></div>
                                                    <div class="flex-1">
                                                        <input type="text" wire:model.live.debounce.300ms="right_options.<?php echo e($idx); ?>" 
                                                               placeholder="Enter right option..." class="option-input">
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["right_options.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <!--[if BLOCK]><![endif]--><?php if($idx === 0): ?>
                                                            <button type="button" wire:click="addRightOption" class="add-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                </svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <!--[if BLOCK]><![endif]--><?php if($idx > 1): ?>
                                                            <button type="button" wire:click="removeRightOption(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Correct Answer Pairs Section -->
                        <div class="section-block" x-show="type === 'statement_match'">
                            <h3 class="section-title">Correct Answer Pairs</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                These are the correct matching pairs for this statement match question.
                            </div>
                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = [0,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="option-item" wire:key="pair-<?php echo e($pairIdx); ?>">
                                        <div class="mb-2 font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx + 1); ?></div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="modern-label">Left Option</label>
                                                <select class="option-input" wire:model.live="correct_pairs.<?php echo e($pairIdx); ?>.left" wire:key="left-select-<?php echo e($pairIdx); ?>-<?php echo e(count($left_options)); ?>">
                                                    <option value="">Select Left Option</option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredLeftOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $alreadySelected = false;
                                                            foreach ($correct_pairs as $otherIdx => $pair) {
                                                                if ($otherIdx !== $pairIdx && isset($pair['left']) && $pair['left'] !== '' && $pair['left'] == $idx) {
                                                                    $alreadySelected = true;
                                                                    break;
                                                                }
                                                            }
                                                        ?>
                                                        <!--[if BLOCK]><![endif]--><?php if(!$alreadySelected): ?>
                                                            <option value="<?php echo e($idx); ?>"><?php echo e($idx); ?>. <?php echo e($option); ?></option>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["correct_pairs.{$pairIdx}.left"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="text-center text-lg font-bold text-blue-600">↓ matches with ↓</div>
                                            <div>
                                                <label class="modern-label">Right Option</label>
                                                <select class="option-input" wire:model.live="correct_pairs.<?php echo e($pairIdx); ?>.right" wire:key="right-select-<?php echo e($pairIdx); ?>-<?php echo e(count($right_options)); ?>">
                                                    <option value="">Select Right Option</option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredRightOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $alreadySelected = false;
                                                            foreach ($correct_pairs as $otherIdx => $pair) {
                                                                if ($otherIdx !== $pairIdx && isset($pair['right']) && $pair['right'] !== '' && $pair['right'] == $idx) {
                                                                    $alreadySelected = true;
                                                                    break;
                                                                }
                                                            }
                                                        ?>
                                                        <!--[if BLOCK]><![endif]--><?php if(!$alreadySelected): ?>
                                                            <option value="<?php echo e($idx); ?>"><?php echo e($idx); ?>. <?php echo e($option); ?></option>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["correct_pairs.{$pairIdx}.right"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Opinion Section -->
                        <div class="section-block" id="opinion-section" x-show="type === 'opinion'">
                            <h3 class="section-title">Opinion Question</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                This is an open-ended opinion question where students provide their own text response.
                            </div>
                            
                            <div>
                                <label class="modern-label">Expected/Sample Answer (Reference)</label>
                                <textarea rows="4" wire:model.live.debounce.300ms="opinion_answer" 
                                          placeholder="Enter a sample answer or expected response..." 
                                          class="modern-textarea bg-blue-50 border-blue-200"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['opinion_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="mb-6" wire:key="opinion-preview-<?php echo e($opinion_answer); ?>" x-show="type === 'opinion'">
                            <h4 class="sub-question-title mb-4">Preview</h4>
                            <div class="preview-section">
                                <div class="space-y-4">
                                    <div>
                                        <label class="modern-label">Expected/Sample Answer</label>
                                        <!--[if BLOCK]><![endif]--><?php if($opinion_answer): ?>
                                            <div class="option-input bg-blue-50 border-blue-200" style="color: #000 !important;">
                                                <?php echo e($opinion_answer); ?>

                                            </div>
                                        <?php else: ?>
                                            <div class="option-input bg-gray-50 border-gray-200" style="color: #6b7280 !important;">
                                                No sample answer provided - students will give their own opinion
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Simple True/False Section -->
                        <div class="section-block" x-show="type === 'true_false'">
                            <h3 class="section-title">True/False Question</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                A single True/False statement where students choose between True or False.
                            </div>
                            <div class="mb-4">
                                <label class="modern-label">Statement Text</label>
                                <textarea wire:model.live.debounce.300ms="true_false_statement" rows="3" placeholder="Enter the statement text..." class="modern-textarea"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['true_false_statement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="mb-4">
                                <label class="modern-label">Correct Answer</label>
                                <div class="true-false-options single">
                                    <button type="button"
                                        class="true-false-option single <?php echo e($true_false_answer === 'true' ? 'selected' : ''); ?>"
                                        wire:click="$set('true_false_answer', 'true')">
                                        <span class="option-circle single">
                                            <svg class="checkmark single" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                        <span class="true-false-label single">True</span>
                                    </button>
                                    <button type="button"
                                        class="true-false-option single <?php echo e($true_false_answer === 'false' ? 'selected' : ''); ?>"
                                        wire:click="$set('true_false_answer', 'false')">
                                        <span class="option-circle single">
                                            <svg class="checkmark single" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                        <span class="true-false-label single">False</span>
                                    </button>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['true_false_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="section-block">
                            <div class="flex justify-end space-x-4">
                                <a href="/admin/questions" class="cancel-btn">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" class="submit-btn">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Question
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
    /* Custom styling for Filament header */
    .fi-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        border-radius: 12px !important;
        margin-bottom: 1.5rem !important;
        padding: 1.25rem 1.5rem !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        border: 1px solid #e5e7eb !important;
        transition: all 0.3s ease !important;
    }

    .fi-header:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        transform: translateY(-1px) !important;
    }

    /* Style breadcrumbs */
    .fi-breadcrumbs {
        font-size: 0.875rem !important;
        color: #6b7280 !important;
        margin-bottom: 0.5rem !important;
    }

    .fi-breadcrumbs a {
        color: #3b82f6 !important;
        text-decoration: none !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
    }

    .fi-breadcrumbs a:hover {
        color: #1d4ed8 !important;
        text-decoration: underline !important;
    }

    .fi-breadcrumbs-separator {
        color: #9ca3af !important;
        margin: 0 0.5rem !important;
    }

    /* Style page heading */
    .fi-page-heading h1, .fi-heading {
        color: #1f2937 !important;
        font-size: 1.75rem !important;
        font-weight: 700 !important;
        margin: 0.5rem 0 0.25rem 0 !important;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
    }

    /* Style subheading */
    .fi-page-heading p, .fi-subheading {
        color: #6b7280 !important;
        font-size: 0.9rem !important;
        margin: 0 !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
    }

    /* Override Filament default spacing */
    .fi-page {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .fi-page-content {
        padding: 1rem !important;
        margin: 0 !important;
        max-width: none !important;
    }

    .fi-main {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Modern Single Card Form Styling */
    .modern-question-form {
        max-width: 98vw;
        width: 100%;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Single Modern Card Design */
    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        border: 1px solid #e5e7eb;
        position: relative;
        margin: 0;
        width: 100%;
    }

    .modern-card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border-color: #3b82f6;
    }

    .card-content {
        padding: 2rem;
        position: relative;
    }

    /* Section Blocks */
    .section-block {
        padding: 1.5rem 0;
        border-bottom: 1px solid #f3f4f6;
        position: relative;
    }

    .section-block:first-child {
        padding-top: 0.5rem;
    }

    .section-block:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        position: relative;
        padding-left: 1rem;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    /* Modern Form Elements */
    .modern-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151 !important;
        margin-bottom: 0.75rem;
        position: relative;
    }

    .modern-input, .modern-select, .modern-textarea {
        width: 100% !important;
        padding: 1rem 1.25rem !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        font-size: 0.875rem !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        background: white !important;
        color: #1f2937 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }

    .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
        outline: none !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px) !important;
    }

    .modern-input:hover, .modern-select:hover, .modern-textarea:hover {
        border-color: #6366f1 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-1px) !important;
    }

    .modern-checkbox-label {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .modern-checkbox-label:hover {
        background: #f3f4f6;
    }

    .modern-checkbox {
        width: 1.25rem !important;
        height: 1.25rem !important;
        border-radius: 0.375rem !important;
        border: 2px solid #d1d5db !important;
        background: white !important;
        transition: all 0.3s ease !important;
    }

    .modern-checkbox:checked {
        background: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }

    /* Option and Index Items */
    .option-item, .index-item {
        background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .option-item::before, .index-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .option-item:hover, .index-item:hover {
        border-color: #3b82f6;
        background: white;
        transform: translateY(-4px) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .option-item:hover::before, .index-item:hover::before {
        left: 100%;
    }

    .option-label {
        font-size: 0.875rem;
        font-weight: 700;
        color: #374151;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .option-input, .index-input {
        width: 100% !important;
        padding: 0.875rem 1.125rem !important;
        border: 2px solid #e2e8f0 !important;
        border-radius: 10px !important;
        font-size: 0.875rem !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        background: white !important;
        margin-top: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }

    .option-input:focus, .index-input:focus {
        outline: none !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-1px) !important;
    }

    /* Enhanced Button Styling */
    .button-group {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .add-btn, .add-index-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.625rem 1rem !important;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .add-btn:hover, .add-index-btn:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4) !important;
    }

    .remove-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.625rem 1rem !important;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .remove-btn:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.4) !important;
    }

    /* Main Action Buttons */
    .submit-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 1rem 2rem !important;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        font-size: 1rem !important;
        font-weight: 700 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
        color: white !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 20px 25px -5px rgba(245, 158, 11, 0.4) !important;
    }

    .cancel-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 1rem 2rem !important;
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        font-size: 1rem !important;
        font-weight: 600 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 4px 6px -1px rgba(107, 114, 128, 0.4) !important;
    }

    .cancel-btn:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(107, 114, 128, 0.4) !important;
    }

    /* Info Banner */
    .info-banner {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #f59e0b;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #92400e;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.1);
    }

    /* Error Text */
    .error-text {
        color: #ef4444 !important;
        font-size: 0.75rem !important;
        font-weight: 500 !important;
        margin-top: 0.5rem !important;
        padding: 0.25rem 0.5rem !important;
        background: #fef2f2 !important;
        border-radius: 6px !important;
    }

    /* Current file display */
    .bg-blue-50 {
        background-color: #eff6ff !important;
    }
    
    .border-blue-200 {
        border-color: #bfdbfe !important;
    }
    
    .text-blue-800 {
        color: #1e40af !important;
    }

    /* Responsive Design */
    @media (min-width: 1200px) {
        .modern-question-form {
            max-width: 95vw;
            padding: 0 2rem;
        }
        
        .card-content {
            padding: 2.5rem;
        }
    }

    @media (max-width: 1024px) {
        .modern-question-form {
            max-width: 98vw;
            padding: 0 1rem;
        }
    }

    @media (max-width: 768px) {
        .modern-question-form {
            max-width: 100vw;
            padding: 0 0.5rem;
        }
        
        .card-content {
            padding: 1.5rem;
        }
        
        .grid-cols-1.md\\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
        
        .button-group {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .section-block {
            padding: 1rem 0;
        }
    }

    /* Animation for new items */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .option-item, .index-item {
        animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Preview Section Styling */
    .preview-section {
        background: linear-gradient(145deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid #0ea5e9;
        border-radius: 16px;
        padding: 1.5rem;
    }

    .preview-label {
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
    }

    .preview-label-main {
        font-weight: 700;
        color: #065f46;
        margin-bottom: 1rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filled-paragraph-main {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 3px solid #10b981;
        border-radius: 16px;
        padding: 2rem;
        font-size: 1.25rem;
        line-height: 1.8;
        color: #1f2937;
        margin-bottom: 1.5rem;
        font-weight: 600;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2), 0 4px 6px -2px rgba(16, 185, 129, 0.1);
        position: relative;
    }

    .filled-paragraph-main::before {
        content: '🎯';
        position: absolute;
        top: -10px;
        left: -10px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .paragraph-preview {
        background: white;
        border: 2px solid #0ea5e9;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: #1f2937;
        margin-top: 0.75rem;
        font-weight: 500;
        white-space: pre-wrap;
    }

    .options-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .option-preview {
        background: white;
        border: 1px solid #0ea5e9;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: #0c4a6e;
        font-weight: 500;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .filled-answer {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 700;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        display: inline-block;
        margin: 0 2px;
    }

    .empty-blank {
        background: linear-gradient(135deg, #fee2e2, #fca5a5);
        color: #dc2626;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 700;
        box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);
        display: inline-block;
        margin: 0 2px;
        text-decoration: line-through;
    }

    .no-options-message {
        color: #6b7280;
        font-style: italic;
        font-size: 0.875rem;
    }

    /* Form Fill Section Styling */
    .form-fill-paragraph-section {
        background: linear-gradient(145deg, #fefce8 0%, #fef3c7 100%);
        border: 2px solid #f59e0b;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .paragraph-text {
        background: white;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: #1f2937;
        margin-top: 0.75rem;
        font-weight: 500;
        white-space: pre-wrap;
    }

    .form-fill-option-item, .answer-key-item {
        background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .form-fill-option-item:hover, .answer-key-item:hover {
        border-color: #3b82f6;
        background: white;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .option-number, .answer-number {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .answer-number {
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        width: auto;
        height: auto;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .paragraph-info {
        display: flex;
        align-items: center;
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #065f46;
        font-weight: 500;
    }

    /* Add/Remove Button Styling */
    .add-btn-small, .remove-btn-small {
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .add-btn-small {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .add-btn-small:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
    }

    .remove-btn-small {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .remove-btn-small:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }

    /* True/False Options Styling */
    .true-false-options {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .true-false-option {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border: 2px solid #000;
        border-radius: 12px;
        background: #000;
        color: #fff;
        position: relative;
        overflow: hidden;
        flex: 1;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }

    .true-false-option.selected {
        background: #22c55e !important; /* green-500 */
        border-color: #22c55e !important;
        color: #fff !important;
    }

    .true-false-option .option-circle {
        width: 2rem;
        height: 2rem;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        background: #fff;
        color: #000;
        transition: border-color 0.2s, background 0.2s;
    }

    .true-false-option.selected .option-circle {
        border-color: #22c55e;
        background: #22c55e;
        color: #fff;
    }

    .true-false-label {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        transition: color 0.3s ease;
    }

    .true-false-option.selected .true-false-label {
        color: #fff;
    }

    /* Reorder Preview Fragments Styling */
    .preview-section {
        background: #f0f9ff;
        border: 2px solid #38bdf8;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .preview-label {
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }
    .fragments-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .fragment-preview {
        background: #fff;
        border: 2px solid #6366f1;
        border-radius: 9999px;
        padding: 0.5rem 1.25rem;
        font-size: 1rem;
        color: #6366f1;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(99, 102, 241, 0.08);
        display: inline-block;
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }
    .answer-preview {
        background: #f0fdf4;
        border: 2px solid #22c55e;
        border-radius: 9999px;
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        color: #16a34a;
        font-weight: 700;
        margin-top: 0.5rem;
        display: inline-block;
        box-shadow: 0 1px 3px rgba(34, 197, 94, 0.08);
    }
    .no-fragments-message {
        color: #6b7280;
        font-style: italic;
        font-size: 0.95rem;
        padding: 1rem;
        text-align: center;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
    }

    /* True/False Single Option Styling (View Style) */
    .true-false-options.single {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.5rem;
    }
    .true-false-option.single {
        display: flex;
        align-items: center;
        padding: 1.5rem 2.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 18px;
        background: #fff;
        color: #111827;
        font-weight: 700;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        position: relative;
        min-width: 180px;
        justify-content: flex-start;
    }
    .true-false-option.single.selected {
        border: 2px solid #22c55e;
        background: linear-gradient(90deg, #e6f9ef 0%, #d1fae5 100%);
        color: #111827;
        box-shadow: 0 2px 8px rgba(34,197,94,0.08);
    }
    .option-circle.single {
        width: 2.2rem;
        height: 2.2rem;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.25rem;
        font-size: 1.2rem;
        transition: all 0.2s;
        color: #22c55e;
    }
    .true-false-option.single.selected .option-circle.single {
        background: #22c55e;
        border-color: #22c55e;
        color: #fff;
    }
    .checkmark.single {
        color: #fff;
        opacity: 0;
        font-size: 1.2rem;
        transition: opacity 0.2s;
    }
    .true-false-option.single.selected .checkmark.single {
        opacity: 1;
    }
    .true-false-label.single {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin-left: 0;
    }

    /* --- FORCE TRUE/FALSE BUTTONS TO MATCH VIEW PAGE --- */
    .true-false-option, .true-false-option.single {
        display: flex;
        align-items: center;
        padding: 1.5rem 2.5rem;
        border: 2px solid #e5e7eb !important;
        border-radius: 18px;
        background: #fff !important;
        color: #111827 !important;
        font-weight: 700;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        position: relative;
        min-width: 180px;
        justify-content: flex-start;
    }
    .true-false-option.selected, .true-false-option.single.selected {
        border: 2px solid #22c55e !important;
        background: linear-gradient(90deg, #e6f9ef 0%, #d1fae5 100%) !important;
        color: #111827 !important;
        box-shadow: 0 2px 8px rgba(34,197,94,0.08);
    }
    .option-circle, .option-circle.single {
        width: 2.2rem;
        height: 2.2rem;
        border-radius: 50%;
        border: 2px solid #d1d5db !important;
        background: #fff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.25rem;
        font-size: 1.2rem;
        transition: all 0.2s;
        color: #22c55e;
    }
    .true-false-option.selected .option-circle, .true-false-option.single.selected .option-circle.single {
        background: #22c55e !important;
        border-color: #22c55e !important;
        color: #fff !important;
    }
    .checkmark, .checkmark.single {
        color: #fff;
        opacity: 0;
        font-size: 1.2rem;
        transition: opacity 0.2s;
    }
    .true-false-option.selected .checkmark, .true-false-option.single.selected .checkmark.single {
        opacity: 1;
    }
    .true-false-label, .true-false-label.single {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827 !important;
        margin-left: 0;
    }
    /* --- END FORCE TRUE/FALSE BUTTONS --- */
    </style>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\learning\resources\views/filament/resources/question-resource/pages/edit-custom.blade.php ENDPATH**/ ?>