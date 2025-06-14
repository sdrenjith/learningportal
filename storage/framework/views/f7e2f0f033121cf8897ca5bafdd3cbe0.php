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
    <div class="modern-question-form">
        <form wire:submit="create">
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
                                        <!--[if BLOCK]><![endif]--><?php if(!in_array($type->name, ['audio_mcq_single', 'audio_image_text_single', 'audio_image_text_multiple', 'picture_mcq'])): ?>
                                            <option value="<?php echo e($type->name); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $type->name))); ?></option>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <option value="audio_mcq_single">Audio MCQ - Single Audio, Multiple Questions</option>
                                    <option value="audio_image_text_single">Audio Image Text - Single Audio with Image Matching</option>
                                    <option value="audio_image_text_multiple">Multiple Audio, Multiple Images & Texts</option>
                                    <option value="picture_mcq">Picture MCQ (Images to Text Matching)</option>
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
                                <input type="file" wire:model="explanation_file" class="modern-input" accept="*/*">
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
                        <!-- Audio Image Text Single Section -->
                        <div class="section-block" id="audio-image-text-single-section" x-show="type === 'audio_image_text_single'">
                            <h3 class="section-title">Audio Image Text - Single Audio with Image to Text Matching</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Upload one audio file as context/hint, add images on the left, text options on the right, then match images to correct text options. Students will listen to the audio and match accordingly.
                            </div>

                            <!-- Audio Upload Section -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">🎵 Context Audio File</h4>
                                <div class="audio-upload-section">
                                    <label class="modern-label">Upload Audio File (Context/Hint) *</label>
                                    <input type="file" wire:model="audio_image_text_audio_file" class="modern-input" accept="audio/*" placeholder="Upload audio file">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['audio_image_text_audio_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!--[if BLOCK]><![endif]--><?php if($audio_image_text_audio_file ?? null): ?>
                                        <div class="mt-3 p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-semibold text-green-800"><?php echo e($audio_image_text_audio_file->getClientOriginalName()); ?></p>
                                                    <p class="text-sm text-green-600">Audio file uploaded successfully</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <div class="mt-2 text-sm text-gray-500">
                                        <strong>Supported formats:</strong> MP3, WAV, OGG, M4A (Max size: 10MB)<br>
                                        <strong>Purpose:</strong> This audio provides context or hints to help students match images to text options.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Side - Images -->
                                <div>
                                    <h5 class="font-semibold mb-4 text-lg">📷 Images to Match</h5>
                                    <div id="audio-image-text-images-container">
                                        <!--[if BLOCK]><![endif]--><?php if(is_array($audio_image_text_image_uploads ?? []) && count($audio_image_text_image_uploads) > 0): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $audio_image_text_image_uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $imageUpload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="picture-mcq-image-item flex flex-col mb-4 p-4 border-2 border-dashed border-purple-300 rounded-lg" wire:key="audio_image_text_image_<?php echo e($idx); ?>">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="font-medium text-gray-700">Image <?php echo e($idx + 1); ?></span>
                                                        <!--[if BLOCK]><![endif]--><?php if($idx > 0): ?>
                                                            <button type="button" wire:click="removeAudioImageTextImage(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <input type="file" wire:model="audio_image_text_image_uploads.<?php echo e($idx); ?>" class="modern-input" accept="image/*" placeholder="Upload image">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_image_uploads.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                    
                                                    <!--[if BLOCK]><![endif]--><?php if(isset($audio_image_text_image_uploads[$idx]) && $audio_image_text_image_uploads[$idx]): ?>
                                                        <div class="mt-2">
                                                            <img src="<?php echo e($audio_image_text_image_uploads[$idx]->temporaryUrl()); ?>" alt="Preview" class="w-20 h-20 object-cover rounded border">
                                                        </div>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            <div class="picture-mcq-image-item flex flex-col mb-4 p-4 border-2 border-dashed border-purple-300 rounded-lg">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-gray-700">Image 1</span>
                                                </div>
                                                <input type="file" wire:model="audio_image_text_image_uploads.0" class="modern-input" accept="image/*" placeholder="Upload image">
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_image_uploads.0"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <button type="button" wire:click="addAudioImageTextImage" class="add-btn mt-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Image
                                    </button>
                                </div>
                                
                                <!-- Right Side - Text Options -->
                                <div>
                                    <h5 class="font-semibold mb-4 text-lg">📝 Text Options</h5>
                                    <div id="audio-image-text-right-options-container">
                                        <!--[if BLOCK]><![endif]--><?php if(is_array($audio_image_text_right_options ?? []) && count($audio_image_text_right_options) > 0): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $audio_image_text_right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="option-item flex items-center mb-2" wire:key="audio_image_text_right_option_<?php echo e($idx); ?>">
                                                    <input type="text" wire:model.live="audio_image_text_right_options.<?php echo e($idx); ?>" class="option-input flex-1 mr-2" placeholder="Enter text option <?php echo e($idx + 1); ?>">
                                                    <!--[if BLOCK]><![endif]--><?php if($idx === 0): ?>
                                                        <button type="button" wire:click="addAudioImageTextRightOption" class="add-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" wire:click="removeAudioImageTextRightOption(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_right_options.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            <div class="option-item flex items-center mb-2">
                                                <input type="text" wire:model.live="audio_image_text_right_options.0" class="option-input flex-1 mr-2" placeholder="Enter text option 1">
                                                <button type="button" wire:click="addAudioImageTextRightOption" class="add-btn-small">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_right_options.0"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>

                            <!-- Correct Answer Pairs for Audio Image Text -->
                            <div class="mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="sub-question-title">Correct Answer Pairs</h4>
                                    <button type="button" wire:click="$set('audio_image_text_correct_pairs', [['left' => '', 'right' => ''], ['left' => '', 'right' => '']])" class="clear-all-btn">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear All Pairs
                                    </button>
                                </div>
                                <div class="info-banner-small">
                                    <span class="text-sm">Select exactly 2 pairs. Image indices: 0 = first image, 1 = second image, etc. Text indices: 0 = first text option, 1 = second text option, etc.</span>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4" wire:key="audio-image-text-correct-pairs-section">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = [0,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item" wire:key="audio-image-text-pair-<?php echo e($pairIdx); ?>">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx+1); ?></div>
                                                <button type="button" wire:click="$set('audio_image_text_correct_pairs.<?php echo e($pairIdx); ?>.left', ''); $set('audio_image_text_correct_pairs.<?php echo e($pairIdx); ?>.right', '')" class="clear-pair-btn" title="Clear this pair">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="flex gap-4">
                                                <div class="flex-1">
                                                    <label class="modern-label">Image</label>
                                                    <select class="option-input" wire:model.live="audio_image_text_correct_pairs.<?php echo e($pairIdx); ?>.left" wire:key="audio-image-text-left-select-<?php echo e($pairIdx); ?>-<?php echo e(count($audio_image_text_image_uploads ?? [])); ?>">
                                                        <option value="">Select Image</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredAudioImageTextImages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $alreadySelected = false;
                                                                $pairs = $audio_image_text_correct_pairs ?? [];
                                                                foreach ($pairs as $otherIdx => $pair) {
                                                                    if ($otherIdx !== $pairIdx && isset($pair['left']) && $pair['left'] !== '' && $pair['left'] == $idx) {
                                                                        $alreadySelected = true;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            <!--[if BLOCK]><![endif]--><?php if(!$alreadySelected): ?>
                                                                <option value="<?php echo e($idx); ?>"><?php echo e($idx); ?>. Image <?php echo e($idx + 1); ?></option>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </select>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="modern-label">Text Option</label>
                                                    <select class="option-input" wire:model.live="audio_image_text_correct_pairs.<?php echo e($pairIdx); ?>.right" wire:key="audio-image-text-right-select-<?php echo e($pairIdx); ?>-<?php echo e(count($audio_image_text_right_options ?? [])); ?>">
                                                        <option value="">Select Text Option</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredAudioImageTextRightOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $alreadySelected = false;
                                                                $pairs = $audio_image_text_correct_pairs ?? [];
                                                                foreach ($pairs as $otherIdx => $pair) {
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
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Preview Section for Audio Image Text -->
                            <div class="mb-6" wire:key="audio-image-text-preview-<?php echo e(count($audio_image_text_image_uploads)); ?>-<?php echo e(count($audio_image_text_right_options)); ?>">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <!--[if BLOCK]><![endif]--><?php if($audio_image_text_audio_file ?? null): ?>
                                        <div class="mb-4 p-4 bg-blue-50 border-2 border-blue-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-semibold text-blue-800">🎵 Context Audio: <?php echo e($audio_image_text_audio_file->getClientOriginalName()); ?></p>
                                                    <p class="text-sm text-blue-600">Students will listen to this audio before matching</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <?php
                                        $validPairs = array_filter($audio_image_text_correct_pairs ?? [], function($pair) {
                                            return isset($pair['left'], $pair['right']) && 
                                                   $pair['left'] !== '' && $pair['right'] !== '' &&
                                                   $pair['left'] !== null && $pair['right'] !== null;
                                        });
                                        $imageUploads = $audio_image_text_image_uploads ?? [];
                                        $rightOptions = $audio_image_text_right_options ?? [];
                                    ?>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(count($validPairs) > 0): ?>
                                        <p class="preview-label mb-4">💡 Image-Text Matching Preview:</p>
                                        <div class="space-y-6">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $validPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $imageIndex = (int)$pair['left'];
                                                    $textIndex = (int)$pair['right'];
                                                    $imageUpload = $imageUploads[$imageIndex] ?? null;
                                                    $textOption = $rightOptions[$textIndex] ?? '';
                                                ?>
                                                
                                                <!--[if BLOCK]><![endif]--><?php if($imageUpload && trim($textOption) !== ''): ?>
                                                    <div class="picture-mcq-match-item">
                                                        <div class="flex items-center justify-center space-x-8 p-6 bg-white border-2 border-green-200 rounded-xl">
                                                            <!-- Image Section -->
                                                            <div class="flex flex-col items-center space-y-2">
                                                                <div class="image-container">
                                                                    <img src="<?php echo e($imageUpload->temporaryUrl()); ?>" 
                                                                         alt="Image <?php echo e($imageIndex + 1); ?>" 
                                                                         class="preview-image object-cover rounded-lg border-2 border-blue-300">
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">Image <?php echo e($imageIndex + 1); ?></span>
                                                            </div>
                                                            
                                                            <!-- Arrow -->
                                                            <div class="flex items-center px-4">
                                                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                                </svg>
                                                            </div>
                                                            
                                                            <!-- Text Section -->
                                                            <div class="flex flex-col items-center space-y-2">
                                                                <div class="text-container bg-blue-50 border-2 border-blue-300 px-6 py-3 rounded-lg">
                                                                    <span class="font-bold text-blue-900 text-lg"><?php echo e(trim($textOption)); ?></span>
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">Text Option</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-8">
                                            <div class="text-gray-500 mb-2">
                                                <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Upload audio, add images & text options, and set answer pairs to see preview</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Audio Image Text Multiple Section -->
                        <div class="section-block" id="audio-image-text-multiple-section" x-show="type === 'audio_image_text_multiple'">
                            <h3 class="section-title">Multiple Audio, Multiple Images & Texts</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Create multiple image+audio pairs on the left side and text options on the right. Students will see images, listen to their corresponding audio files, and match them to the correct text descriptions.
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Side - Image + Audio Pairs -->
                                <div>
                                    <h5 class="font-semibold mb-4 text-lg">🎭 Image + Audio Pairs</h5>
                                    <div id="audio-image-text-multiple-pairs-container">
                                        <!--[if BLOCK]><![endif]--><?php if(is_array($audio_image_text_multiple_pairs ?? []) && count($audio_image_text_multiple_pairs) > 0): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $audio_image_text_multiple_pairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="audio-image-pair-item flex flex-col mb-6 p-4 border-2 border-dashed border-indigo-300 rounded-lg bg-gradient-to-br from-indigo-50 to-purple-50" wire:key="audio_image_text_multiple_pair_<?php echo e($idx); ?>">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <span class="font-bold text-indigo-700">📱 Pair <?php echo e($idx + 1); ?></span>
                                                        <!--[if BLOCK]><![endif]--><?php if($idx > 0): ?>
                                                            <button type="button" wire:click="removeAudioImageTextMultiplePair(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    
                                                    <!-- Image Upload -->
                                                    <div class="mb-3">
                                                        <label class="modern-label text-sm">🖼️ Image File *</label>
                                                        <input type="file" wire:model="audio_image_text_multiple_pairs.<?php echo e($idx); ?>.image" class="modern-input" accept="image/*" placeholder="Upload image">
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_multiple_pairs.{$idx}.image"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                        
                                                        <!--[if BLOCK]><![endif]--><?php if(isset($audio_image_text_multiple_pairs[$idx]['image']) && $audio_image_text_multiple_pairs[$idx]['image']): ?>
                                                            <div class="mt-2">
                                                                <img src="<?php echo e($audio_image_text_multiple_pairs[$idx]['image']->temporaryUrl()); ?>" alt="Preview" class="w-20 h-20 object-cover rounded border-2 border-indigo-200">
                                                            </div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    
                                                    <!-- Audio Upload -->
                                                    <div class="mb-2">
                                                        <label class="modern-label text-sm">🎵 Audio File *</label>
                                                        <input type="file" wire:model="audio_image_text_multiple_pairs.<?php echo e($idx); ?>.audio" class="modern-input" accept="audio/*" placeholder="Upload audio">
                                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_multiple_pairs.{$idx}.audio"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                        
                                                        <!--[if BLOCK]><![endif]--><?php if(isset($audio_image_text_multiple_pairs[$idx]['audio']) && $audio_image_text_multiple_pairs[$idx]['audio']): ?>
                                                            <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded">
                                                                <div class="flex items-center space-x-2">
                                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                                    </svg>
                                                                    <span class="text-sm font-medium text-green-700"><?php echo e($audio_image_text_multiple_pairs[$idx]['audio']->getClientOriginalName()); ?></span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        Both image and audio files are required for each pair.
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            <div class="audio-image-pair-item flex flex-col mb-6 p-4 border-2 border-dashed border-indigo-300 rounded-lg bg-gradient-to-br from-indigo-50 to-purple-50">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="font-bold text-indigo-700">📱 Pair 1</span>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="modern-label text-sm">🖼️ Image File *</label>
                                                    <input type="file" wire:model="audio_image_text_multiple_pairs.0.image" class="modern-input" accept="image/*" placeholder="Upload image">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_multiple_pairs.0.image"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="modern-label text-sm">🎵 Audio File *</label>
                                                    <input type="file" wire:model="audio_image_text_multiple_pairs.0.audio" class="modern-input" accept="audio/*" placeholder="Upload audio">
                                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_multiple_pairs.0.audio"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Both image and audio files are required for each pair.
                                                </div>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <button type="button" wire:click="addAudioImageTextMultiplePair" class="add-btn mt-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Image+Audio Pair
                                    </button>
                                </div>
                                
                                <!-- Right Side - Text Options -->
                                <div>
                                    <h5 class="font-semibold mb-4 text-lg">📝 Text Options</h5>
                                    <div id="audio-image-text-multiple-right-options-container">
                                        <!--[if BLOCK]><![endif]--><?php if(is_array($audio_image_text_multiple_right_options ?? []) && count($audio_image_text_multiple_right_options) > 0): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $audio_image_text_multiple_right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="option-item flex items-center mb-2" wire:key="audio_image_text_multiple_right_option_<?php echo e($idx); ?>">
                                                    <input type="text" wire:model.live="audio_image_text_multiple_right_options.<?php echo e($idx); ?>" class="option-input flex-1 mr-2" placeholder="Enter text option <?php echo e($idx + 1); ?>">
                                                    <!--[if BLOCK]><![endif]--><?php if($idx === 0): ?>
                                                        <button type="button" wire:click="addAudioImageTextMultipleRightOption" class="add-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" wire:click="removeAudioImageTextMultipleRightOption(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_multiple_right_options.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            <div class="option-item flex items-center mb-2">
                                                <input type="text" wire:model.live="audio_image_text_multiple_right_options.0" class="option-input flex-1 mr-2" placeholder="Enter text option 1">
                                                <button type="button" wire:click="addAudioImageTextMultipleRightOption" class="add-btn-small">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                </button>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_image_text_multiple_right_options.0"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>

                            <!-- Correct Answer Pairs for Audio Image Text Multiple -->
                            <div class="mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="sub-question-title">Correct Answer Pairs</h4>
                                    <button type="button" wire:click="$set('audio_image_text_multiple_correct_pairs', [['left' => '', 'right' => ''], ['left' => '', 'right' => '']])" class="clear-all-btn">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear All Pairs
                                    </button>
                                </div>
                                <div class="info-banner-small">
                                    <span class="text-sm">Select exactly 2 pairs. Pair indices: 0 = first image+audio pair, 1 = second pair, etc. Text indices: 0 = first text option, 1 = second text option, etc.</span>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4" wire:key="audio-image-text-multiple-correct-pairs-section">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = [0,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item" wire:key="audio-image-text-multiple-pair-<?php echo e($pairIdx); ?>">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx+1); ?></div>
                                                <button type="button" wire:click="$set('audio_image_text_multiple_correct_pairs.<?php echo e($pairIdx); ?>.left', ''); $set('audio_image_text_multiple_correct_pairs.<?php echo e($pairIdx); ?>.right', '')" class="clear-pair-btn" title="Clear this pair">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="flex gap-4">
                                                <div class="flex-1">
                                                    <label class="modern-label">Image+Audio Pair</label>
                                                    <select class="option-input" wire:model.live="audio_image_text_multiple_correct_pairs.<?php echo e($pairIdx); ?>.left" wire:key="audio-image-text-multiple-left-select-<?php echo e($pairIdx); ?>-<?php echo e(count($audio_image_text_multiple_pairs ?? [])); ?>">
                                                        <option value="">Select Pair</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredAudioImageTextMultiplePairs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $alreadySelected = false;
                                                                $pairs = $audio_image_text_multiple_correct_pairs ?? [];
                                                                foreach ($pairs as $otherIdx => $correctPair) {
                                                                    if ($otherIdx !== $pairIdx && isset($correctPair['left']) && $correctPair['left'] !== '' && $correctPair['left'] == $idx) {
                                                                        $alreadySelected = true;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            <!--[if BLOCK]><![endif]--><?php if(!$alreadySelected): ?>
                                                                <option value="<?php echo e($idx); ?>"><?php echo e($idx); ?>. Pair <?php echo e($idx + 1); ?></option>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </select>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="modern-label">Text Option</label>
                                                    <select class="option-input" wire:model.live="audio_image_text_multiple_correct_pairs.<?php echo e($pairIdx); ?>.right" wire:key="audio-image-text-multiple-right-select-<?php echo e($pairIdx); ?>-<?php echo e(count($audio_image_text_multiple_right_options ?? [])); ?>">
                                                        <option value="">Select Text Option</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredAudioImageTextMultipleRightOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $alreadySelected = false;
                                                                $pairs = $audio_image_text_multiple_correct_pairs ?? [];
                                                                foreach ($pairs as $otherIdx => $correctPair) {
                                                                    if ($otherIdx !== $pairIdx && isset($correctPair['right']) && $correctPair['right'] !== '' && $correctPair['right'] == $idx) {
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
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Preview Section for Audio Image Text Multiple -->
                            <div class="mb-6" wire:key="audio-image-text-multiple-preview-<?php echo e(count($audio_image_text_multiple_pairs)); ?>-<?php echo e(count($audio_image_text_multiple_right_options)); ?>">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <?php
                                        $validPairs = array_filter($audio_image_text_multiple_correct_pairs ?? [], function($pair) {
                                            return isset($pair['left'], $pair['right']) && 
                                                   $pair['left'] !== '' && $pair['right'] !== '' &&
                                                   $pair['left'] !== null && $pair['right'] !== null;
                                        });
                                        $multiplePairs = $audio_image_text_multiple_pairs ?? [];
                                        $multipleRightOptions = $audio_image_text_multiple_right_options ?? [];
                                    ?>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(count($validPairs) > 0): ?>
                                        <p class="preview-label mb-4">💡 Image+Audio to Text Matching Preview:</p>
                                        <div class="space-y-6">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $validPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $pairIndex = (int)$pair['left'];
                                                    $textIndex = (int)$pair['right'];
                                                    $imagePair = $multiplePairs[$pairIndex] ?? null;
                                                    $textOption = $multipleRightOptions[$textIndex] ?? '';
                                                ?>
                                                
                                                <!--[if BLOCK]><![endif]--><?php if($imagePair && isset($imagePair['image']) && isset($imagePair['audio']) && trim($textOption) !== ''): ?>
                                                    <div class="audio-image-multiple-match-item">
                                                        <div class="flex items-center justify-center space-x-8 p-6 bg-white border-2 border-green-200 rounded-xl">
                                                            <!-- Image + Audio Section -->
                                                            <div class="flex flex-col items-center space-y-3">
                                                                <div class="image-container">
                                                                    <!--[if BLOCK]><![endif]--><?php if($imagePair['image']): ?>
                                                                        <img src="<?php echo e($imagePair['image']->temporaryUrl()); ?>" 
                                                                             alt="Image <?php echo e($pairIndex + 1); ?>" 
                                                                             class="preview-image object-cover rounded-lg border-2 border-indigo-300">
                                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                                <!--[if BLOCK]><![endif]--><?php if($imagePair['audio']): ?>
                                                                    <div class="audio-indicator bg-indigo-100 border-2 border-indigo-300 px-3 py-2 rounded-lg">
                                                                        <div class="flex items-center space-x-2">
                                                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                                            </svg>
                                                                            <span class="text-sm font-medium text-indigo-700">🎵 <?php echo e($imagePair['audio']->getClientOriginalName()); ?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">Pair <?php echo e($pairIndex + 1); ?></span>
                                                            </div>
                                                            
                                                            <!-- Arrow -->
                                                            <div class="flex items-center px-4">
                                                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                                </svg>
                                                            </div>
                                                            
                                                            <!-- Text Section -->
                                                            <div class="flex flex-col items-center space-y-2">
                                                                <div class="text-container bg-blue-50 border-2 border-blue-300 px-6 py-3 rounded-lg">
                                                                    <span class="font-bold text-blue-900 text-lg"><?php echo e(trim($textOption)); ?></span>
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">Text Option</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-8">
                                            <div class="text-gray-500 mb-2">
                                                <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Upload image+audio pairs, add text options, and set answer pairs to see preview</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <div class="section-block" id="audio-mcq-single-section" x-show="type === 'audio_mcq_single'">
                            <h3 class="section-title">Audio MCQ - Single Audio, Multiple Questions</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Upload one audio file and create multiple sub-questions (a, b, c, etc.) based on that audio. Each sub-question can have multiple options and correct answers.
                            </div>

                            <!-- Audio Upload Section -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">🎵 Audio File</h4>
                                <div class="audio-upload-section">
                                    <label class="modern-label">Upload Audio File *</label>
                                    <input type="file" wire:model="audio_mcq_file" class="modern-input" accept="audio/*" placeholder="Upload audio file">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['audio_mcq_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!--[if BLOCK]><![endif]--><?php if($audio_mcq_file ?? null): ?>
                                        <div class="mt-3 p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                </svg>
                                                <div>
                                                    <p class="font-semibold text-green-800"><?php echo e($audio_mcq_file->getClientOriginalName()); ?></p>
                                                    <p class="text-sm text-green-600">Audio file uploaded successfully</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <div class="mt-2 text-sm text-gray-500">
                                        <strong>Supported formats:</strong> MP3, WAV, OGG, M4A (Max size: 10MB)<br>
                                        <strong>Tip:</strong> Upload a clear audio recording that students can listen to while answering the questions below.
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Audio MCQ Sub Questions Container -->
                            <div class="space-y-6">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $audio_mcq_sub_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subIndex => $subQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="sub-question-item" wire:key="audio_mcq_sub_question_<?php echo e($subIndex); ?>">
                                        <!-- Sub Question Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="sub-question-title">Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</h4>
                                            <div class="button-group">
                                                <!--[if BLOCK]><![endif]--><?php if($subIndex === 0): ?>
                                                    <button type="button" wire:click="addAudioMcqSubQuestion" class="add-btn">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        Add Sub-question
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" wire:click="removeAudioMcqSubQuestion(<?php echo e($subIndex); ?>)" class="remove-btn">
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
                                            <label class="modern-label">Sub-question <?php echo e(chr(97 + $subIndex)); ?>) Text *</label>
                                            <textarea wire:model="audio_mcq_sub_questions.<?php echo e($subIndex); ?>.question" rows="2" 
                                                    placeholder="Enter the sub-question text..." class="modern-textarea"></textarea>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["audio_mcq_sub_questions.{$subIndex}.question"];
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
                                            <label class="modern-label">Options for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="space-y-3">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestion['options'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center space-x-3" wire:key="audio_mcq_sub_opt_<?php echo e($subIndex); ?>_<?php echo e($optIndex); ?>">
                                                        <div class="flex-1">
                                                            <input type="text" wire:model="audio_mcq_sub_questions.<?php echo e($subIndex); ?>.options.<?php echo e($optIndex); ?>" 
                                                                   placeholder="Option <?php echo e($optIndex + 1); ?>" class="option-input">
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <!--[if BLOCK]><![endif]--><?php if($optIndex === 0 && count($subQuestion['options']) < 6): ?>
                                                                <button type="button" wire:click="addAudioMcqSubQuestionOption(<?php echo e($subIndex); ?>)" class="add-btn-small">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                    </svg>
                                                                </button>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            <!--[if BLOCK]><![endif]--><?php if($optIndex > 1): ?>
                                                                <button type="button" wire:click="removeAudioMcqSubQuestionOption(<?php echo e($subIndex); ?>, <?php echo e($optIndex); ?>)" class="remove-btn-small">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                </button>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <!-- Correct Answer Indices for this sub-question -->
                                        <div class="mb-4">
                                            <label class="modern-label">Correct Answer Indices for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="info-banner-small">
                                                <span class="text-sm">Use 0 for first option, 1 for second option, etc. You can select multiple correct answers.</span>
                                            </div>
                                            <div class="space-y-2">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestion['correct_indices'] ?? [0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ansIndex => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center space-x-3" wire:key="audio_mcq_sub_ans_<?php echo e($subIndex); ?>_<?php echo e($ansIndex); ?>">
                                                        <div class="flex-1">
                                                            <input type="number" wire:model="audio_mcq_sub_questions.<?php echo e($subIndex); ?>.correct_indices.<?php echo e($ansIndex); ?>" 
                                                                   min="0" max="<?php echo e(max(0, count($subQuestion['options']) - 1)); ?>" placeholder="0" class="index-input">
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <!--[if BLOCK]><![endif]--><?php if($ansIndex === 0): ?>
                                                                <button type="button" wire:click="addAudioMcqSubQuestionAnswerIndex(<?php echo e($subIndex); ?>)" class="add-btn-small">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                    </svg>
                                                                </button>
                                                            <?php else: ?>
                                                                <button type="button" wire:click="removeAudioMcqSubQuestionAnswerIndex(<?php echo e($subIndex); ?>, <?php echo e($ansIndex); ?>)" class="remove-btn-small">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                </button>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <!-- Picture MCQ Section -->
                        <div class="section-block" id="picture-mcq-section" x-show="type === 'picture_mcq'">
                            <h3 class="section-title">Picture MCQ (Images to Text Matching)</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Upload images on the left side and create text options on the right side. Students will match each image with the correct text option. Select exactly 2 pairs for the answer key.
                            </div>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Side - Images -->
                                <div>
                                    <h5 class="font-semibold mb-4 text-lg">📷 Images</h5>
                                    <div id="picture-mcq-images-container">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $picture_mcq_image_uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $imageUpload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="picture-mcq-image-item flex flex-col mb-4 p-4 border-2 border-dashed border-gray-300 rounded-lg" wire:key="picture_mcq_image_<?php echo e($idx); ?>">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-gray-700">Image <?php echo e($idx + 1); ?></span>
                                                    <!--[if BLOCK]><![endif]--><?php if($idx > 0): ?>
                                                        <button type="button" wire:click="removePictureMcqImage(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <input type="file" wire:model="picture_mcq_image_uploads.<?php echo e($idx); ?>" class="modern-input" accept="image/*" placeholder="Upload image">
                                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["picture_mcq_image_uploads.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                                
                                                <!--[if BLOCK]><![endif]--><?php if(isset($picture_mcq_image_uploads[$idx]) && $picture_mcq_image_uploads[$idx]): ?>
                                                    <div class="mt-2">
                                                        <img src="<?php echo e($picture_mcq_image_uploads[$idx]->temporaryUrl()); ?>" alt="Preview" class="w-20 h-20 object-cover rounded border">
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <button type="button" wire:click="addPictureMcqImage" class="add-btn mt-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Image
                                    </button>
                                </div>
                                
                                <!-- Right Side - Text Options -->
                                <div>
                                    <h5 class="font-semibold mb-4 text-lg">📝 Text Options</h5>
                                    <div id="picture-mcq-right-options-container">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $picture_mcq_right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item flex items-center mb-2" wire:key="picture_mcq_right_option_<?php echo e($idx); ?>">
                                                <input type="text" wire:model.live="picture_mcq_right_options.<?php echo e($idx); ?>" class="option-input flex-1 mr-2" placeholder="Enter text option <?php echo e($idx + 1); ?>">
                                                <!--[if BLOCK]><![endif]--><?php if($idx === 0): ?>
                                                    <button type="button" wire:click="addPictureMcqRightOption" class="add-btn-small">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" wire:click="removePictureMcqRightOption(<?php echo e($idx); ?>)" class="remove-btn-small">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["picture_mcq_right_options.{$idx}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>

                            <!-- Correct Answer Pairs for Picture MCQ -->
                            <div class="mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="sub-question-title">Correct Answer Pairs</h4>
                                    <button type="button" wire:click="$set('picture_mcq_correct_pairs', [['left' => '', 'right' => ''], ['left' => '', 'right' => '']])" class="clear-all-btn">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear All Pairs
                                    </button>
                                </div>
                                <div class="info-banner-small">
                                    <span class="text-sm">Select exactly 2 pairs. Image indices: 0 = first image, 1 = second image, etc. Text indices: 0 = first text option, 1 = second text option, etc.</span>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4" wire:key="picture-mcq-correct-pairs-section">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = [0,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item" wire:key="picture-mcq-pair-<?php echo e($pairIdx); ?>">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx+1); ?></div>
                                                <button type="button" wire:click="$set('picture_mcq_correct_pairs.<?php echo e($pairIdx); ?>.left', ''); $set('picture_mcq_correct_pairs.<?php echo e($pairIdx); ?>.right', '')" class="clear-pair-btn" title="Clear this pair">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="flex gap-4">
                                                <div class="flex-1">
                                                    <label class="modern-label">Image</label>
                                                    <select class="option-input" wire:model.live="picture_mcq_correct_pairs.<?php echo e($pairIdx); ?>.left" wire:key="picture-mcq-left-select-<?php echo e($pairIdx); ?>-<?php echo e(count($picture_mcq_image_uploads)); ?>">
                                                        <option value="">Select Image</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredPictureMcqImages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $alreadySelected = false;
                                                                foreach ($picture_mcq_correct_pairs as $otherIdx => $pair) {
                                                                    if ($otherIdx !== $pairIdx && isset($pair['left']) && $pair['left'] !== '' && $pair['left'] == $idx) {
                                                                        $alreadySelected = true;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            <!--[if BLOCK]><![endif]--><?php if(!$alreadySelected): ?>
                                                                <option value="<?php echo e($idx); ?>"><?php echo e($idx); ?>. Image <?php echo e($idx + 1); ?></option>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </select>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="modern-label">Text Option</label>
                                                    <select class="option-input" wire:model.live="picture_mcq_correct_pairs.<?php echo e($pairIdx); ?>.right" wire:key="picture-mcq-right-select-<?php echo e($pairIdx); ?>-<?php echo e(count($picture_mcq_right_options)); ?>">
                                                        <option value="">Select Text Option</option>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getFilteredPictureMcqRightOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $alreadySelected = false;
                                                                foreach ($picture_mcq_correct_pairs as $otherIdx => $pair) {
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
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Preview Section for Picture MCQ -->
                            <div class="mb-6" wire:key="picture-mcq-preview-<?php echo e(count($picture_mcq_image_uploads)); ?>-<?php echo e(count($picture_mcq_right_options)); ?>">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <?php
                                        $validPairs = array_filter($picture_mcq_correct_pairs, function($pair) {
                                            return isset($pair['left'], $pair['right']) && 
                                                   $pair['left'] !== '' && $pair['right'] !== '' &&
                                                   $pair['left'] !== null && $pair['right'] !== null;
                                        });
                                    ?>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(count($validPairs) > 0): ?>
                                        <p class="preview-label mb-4">💡 Image-Text Matching Preview:</p>
                                        <div class="space-y-6">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $validPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $imageIndex = (int)$pair['left'];
                                                    $textIndex = (int)$pair['right'];
                                                    $imageUpload = $picture_mcq_image_uploads[$imageIndex] ?? null;
                                                    $textOption = $picture_mcq_right_options[$textIndex] ?? '';
                                                ?>
                                                
                                                <!--[if BLOCK]><![endif]--><?php if($imageUpload && trim($textOption) !== ''): ?>
                                                    <div class="picture-mcq-match-item">
                                                        <div class="flex items-center justify-center space-x-8 p-6 bg-white border-2 border-green-200 rounded-xl">
                                                            <!-- Image Section -->
                                                            <div class="flex flex-col items-center space-y-2">
                                                                <div class="image-container">
                                                                    <img src="<?php echo e($imageUpload->temporaryUrl()); ?>" 
                                                                         alt="Image <?php echo e($imageIndex + 1); ?>" 
                                                                         class="w-24 h-24 object-cover rounded-lg border-2 border-blue-300">
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">Image <?php echo e($imageIndex + 1); ?></span>
                                                            </div>
                                                            
                                                            <!-- Arrow -->
                                                            <div class="flex items-center px-4">
                                                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                                </svg>
                                                            </div>
                                                            
                                                            <!-- Text Section -->
                                                            <div class="flex flex-col items-center space-y-2">
                                                                <div class="text-container bg-blue-50 border-2 border-blue-300 px-6 py-3 rounded-lg">
                                                                    <span class="font-bold text-blue-900 text-lg"><?php echo e(trim($textOption)); ?></span>
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">Text Option</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-8">
                                            <div class="text-gray-500 mb-2">
                                                <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Upload images, add text options, and set answer pairs to see preview</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Simple True/False Section -->
                        <div class="section-block" id="true-false-section" x-show="type === 'true_false'">
                            <h3 class="section-title">True/False Question</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Create a single True/False statement. Students will choose between True or False. Simply click the correct answer.
                            </div>
                            
                            <!-- True/False Statement -->
                            <div class="mb-6">
                                <label class="modern-label">Statement Text *</label>
                                <textarea wire:model="true_false_statement" rows="3" 
                                        placeholder="Enter the true/false statement..." class="modern-textarea"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['true_false_statement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- True/False Answer Selection -->
                            <div class="mb-6">
                                <label class="modern-label">Correct Answer</label>
                                <div class="true-false-options">
                                    <div class="flex space-x-4">
                                        <label class="true-false-option true-option <?php echo e(($true_false_answer ?? '') === 'true' ? 'selected' : ''); ?>"
                                               wire:click="$set('true_false_answer', 'true')">
                                            <div class="option-circle">
                                                <svg class="w-5 h-5 checkmark <?php echo e(($true_false_answer ?? '') === 'true' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span class="option-text">TRUE</span>
                                        </label>
                                        
                                        <label class="true-false-option false-option <?php echo e(($true_false_answer ?? '') === 'false' ? 'selected' : ''); ?>"
                                               wire:click="$set('true_false_answer', 'false')">
                                            <div class="option-circle">
                                                <svg class="w-5 h-5 checkmark <?php echo e(($true_false_answer ?? '') === 'false' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span class="option-text">FALSE</span>
                                        </label>
                                    </div>
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

                        <!-- Form Fill Section -->
                        <div class="section-block" id="form-fill-section" x-show="type === 'form_fill'">
                            <h3 class="section-title">Form Fill (Fill in the Blanks)</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Create a paragraph with blanks marked as ___ (three underscores). Add options that students can choose from to fill in the blanks. Then provide the answer key for each blank.
                            </div>
                            
                            <!-- Paragraph with Blanks -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Paragraph with Blanks</h4>
                                <div class="form-fill-paragraph-section">
                                    <label class="modern-label">Paragraph Text (use ___ for blanks) *</label>
                                    <textarea wire:model.live.debounce.100ms="form_fill_paragraph" rows="6" 
                                              placeholder="Enter your paragraph here. Use ___ (three underscores) to mark blanks where students should fill in answers. For example: The capital of France is ___. It is located in the ___ of the country."
                                              class="modern-textarea"></textarea>
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
                                            <span>Detected <?php echo e(substr_count($form_fill_paragraph, '___')); ?> blank(s) in the paragraph.</span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Options -->
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Answer Options</h4>
                                <div class="space-y-4">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form_fill_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-fill-option-item" wire:key="form_fill_option_<?php echo e($index); ?>">
                                            <div class="flex items-center space-x-3">
                                                <div class="option-number"><?php echo e($index + 1); ?></div>
                                                <div class="flex-1">
                                                    <input type="text" wire:model.defer="form_fill_options.<?php echo e($index); ?>" 
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
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form_fill_answer_key; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answerKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="answer-key-item" wire:key="form_fill_answer_<?php echo e($index); ?>">
                                                <div class="flex items-center space-x-3">
                                                    <div class="answer-number">Blank <?php echo e($index + 1); ?></div>
                                                    <div class="flex-1">
                                                        <input type="text" wire:model.defer="form_fill_answer_key.<?php echo e($index); ?>" 
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
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(count($filteredAnswerKeys) > 0): ?>
                                        <div class="preview-answers" wire:key="answers-preview-<?php echo e(count($form_fill_answer_key)); ?>">
                                            <p class="preview-label">Answer key summary:</p>
                                            <div class="answers-preview">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form_fill_answer_key; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answerKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <!--[if BLOCK]><![endif]--><?php if(trim($answerKey ?? '') !== ''): ?>
                                                        <div class="answer-key-preview" wire:key="answer-key-preview-<?php echo e($index); ?>-<?php echo e(md5($answerKey)); ?>">
                                                            <strong>Blank <?php echo e($index + 1); ?>:</strong> <?php echo e(trim($answerKey)); ?>

                                                        </div>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                                              class="modern-textarea"></textarea>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['reorder_answer_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <div class="answer-key-info">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>This is the target sentence that students should create by reordering the fragments above.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="mb-6" wire:key="preview-section-<?php echo e(count($reorder_fragments)); ?>">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <div class="preview-fragments" wire:key="fragments-preview-<?php echo e(count($reorder_fragments)); ?>">
                                        <p class="preview-label">Fragments to be reordered:</p>
                                        <div class="fragments-preview">
                                            <?php
                                                $filteredFragments = array_filter($reorder_fragments, fn($f) => trim($f ?? '') !== '');
                                            ?>
                                            <!--[if BLOCK]><![endif]--><?php if(count($filteredFragments) > 0): ?>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $reorder_fragments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fragment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <!--[if BLOCK]><![endif]--><?php if(trim($fragment ?? '') !== ''): ?>
                                                        <span class="fragment-preview" wire:key="fragment-preview-<?php echo e($index); ?>-<?php echo e(md5($fragment)); ?>"><?php echo e(trim($fragment)); ?></span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <span class="no-fragments-message">No fragments added yet...</span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(trim($reorder_answer_key ?? '')): ?>
                                        <div class="preview-answer" wire:key="answer-preview-<?php echo e(md5($reorder_answer_key)); ?>">
                                            <p class="preview-label">Expected result:</p>
                                            <div class="answer-preview"><?php echo e(trim($reorder_answer_key)); ?></div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- True/False Multiple Section -->
                        <div class="section-block" id="true-false-multiple-section" x-show="type === 'true_false_multiple'">
                            <h3 class="section-title">True/False Multiple Questions</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Create multiple True/False statements (a, b, c, etc.). Each statement will have True and False options. Simply click the correct answer for each statement.
                            </div>
                            
                            <!-- True/False Sub Questions Container -->
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

                                        <!-- True/False Statement Text -->
                                        <div class="mb-4">
                                            <label class="modern-label">Statement <?php echo e(chr(97 + $tfIndex)); ?>) Text *</label>
                                            <textarea wire:model="true_false_questions.<?php echo e($tfIndex); ?>.statement" rows="2" 
                                                    placeholder="Enter the true/false statement..." class="modern-textarea"></textarea>
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["true_false_questions.{$tfIndex}.statement"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error-text"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <!-- True/False Answer Selection -->
                                        <div class="mb-4">
                                            <label class="modern-label">Correct Answer for Statement <?php echo e(chr(97 + $tfIndex)); ?>)</label>
                                            <div class="true-false-options">
                                                <div class="flex space-x-4">
                                                    <label class="true-false-option true-option <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'true' ? 'selected' : ''); ?>"
                                                           wire:click="setTrueFalseAnswer(<?php echo e($tfIndex); ?>, 'true')">
                                                        <div class="option-circle">
                                                            <svg class="w-5 h-5 checkmark <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'true' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="option-text">TRUE</span>
                                                    </label>
                                                    
                                                    <label class="true-false-option false-option <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'false' ? 'selected' : ''); ?>"
                                                           wire:click="setTrueFalseAnswer(<?php echo e($tfIndex); ?>, 'false')">
                                                        <div class="option-circle">
                                                            <svg class="w-5 h-5 checkmark <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'false' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="option-text">FALSE</span>
                                                    </label>
                                                </div>
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
                                Create multiple sub-questions (a, b, c, etc.) each with their own options and correct answers. Each sub-question can have multiple correct answers.
                            </div>
                            
                            <!-- Sub Questions Container -->
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
                                            <label class="modern-label">Sub-question <?php echo e(chr(97 + $subIndex)); ?>) Text *</label>
                                            <textarea wire:model="sub_questions.<?php echo e($subIndex); ?>.question" rows="2" 
                                                    placeholder="Enter the sub-question text..." class="modern-textarea"></textarea>
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
                                            <label class="modern-label">Options for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="space-y-3">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestion['options'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center space-x-3" wire:key="sub_opt_<?php echo e($subIndex); ?>_<?php echo e($optIndex); ?>">
                                                        <div class="flex-1">
                                                            <input type="text" wire:model="sub_questions.<?php echo e($subIndex); ?>.options.<?php echo e($optIndex); ?>" 
                                                                   placeholder="Option <?php echo e($optIndex + 1); ?>" class="option-input">
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <!--[if BLOCK]><![endif]--><?php if($optIndex === 0 && count($subQuestion['options']) < 6): ?>
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
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <!-- Correct Answer Indices for this sub-question -->
                                        <div class="mb-4">
                                            <label class="modern-label">Correct Answer Indices for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="info-banner-small">
                                                <span class="text-sm">Use 0 for first option, 1 for second option, etc. You can select multiple correct answers.</span>
                                            </div>
                                            <div class="space-y-2">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestion['correct_indices'] ?? [0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ansIndex => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center space-x-3" wire:key="sub_ans_<?php echo e($subIndex); ?>_<?php echo e($ansIndex); ?>">
                                                        <div class="flex-1">
                                                            <input type="number" wire:model="sub_questions.<?php echo e($subIndex); ?>.correct_indices.<?php echo e($ansIndex); ?>" 
                                                                   min="0" max="<?php echo e(max(0, count($subQuestion['options']) - 1)); ?>" placeholder="0" class="index-input">
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            <!--[if BLOCK]><![endif]--><?php if($ansIndex === 0): ?>
                                                                <button type="button" wire:click="addSubQuestionAnswerIndex(<?php echo e($subIndex); ?>)" class="add-btn-small">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                    </svg>
                                                                </button>
                                                            <?php else: ?>
                                                                <button type="button" wire:click="removeSubQuestionAnswerIndex(<?php echo e($subIndex); ?>, <?php echo e($ansIndex); ?>)" class="remove-btn-small">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                    </svg>
                                                                </button>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Question Options Section (for regular MCQ) -->
                        <div class="section-block" id="question-options-section" x-show="type !== 'statement_match' && type !== 'opinion' && type !== 'mcq_multiple' && type !== 'true_false_multiple' && type !== 'true_false' && type !== 'reorder' && type !== 'form_fill' && type !== 'picture_mcq' && type !== 'audio_mcq_single' && type !== 'audio_image_text_single' && type !== 'audio_image_text_multiple'">
                            <h3 class="section-title">Question Options</h3>
                            <div class="options-wrapper">
                                <div id="options-container" class="space-y-4">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item">
                                            <div class="flex items-center justify-between mb-3">
                                                <label class="option-label">Option <?php echo e($index + 1); ?></label>
                                                <div class="button-group">
                                                    <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                                        <button type="button" wire:click="addOption" class="add-btn">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                            Add Option
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" wire:click="removeOption(<?php echo e($index); ?>)" class="remove-btn">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                            <input type="text" wire:model="options.<?php echo e($index); ?>" placeholder="Enter option text..." class="option-input">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Opinion Type Section -->
                        <div class="section-block" id="opinion-section" x-show="type === 'opinion'">
                            <h3 class="section-title">Opinion Question</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Opinion questions are open-ended. Students will provide their own text response. You can optionally provide a sample answer for reference.
                            </div>
                            <div>
                                <label class="modern-label">Expected/Sample Answer (Optional)</label>
                                <textarea wire:model="opinion_answer" rows="4" class="modern-textarea" placeholder="Enter a sample or expected opinion answer (this is optional and for reference only)..."></textarea>
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

                        <!-- Statement Match Section -->
                        <div class="section-block" id="statement-match-section" x-show="type === 'statement_match'">
                            <h3 class="section-title">Statement Match</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Side Options -->
                                <div>
                                    <h5 class="font-semibold mb-2">Left Side Options</h5>
                                    <div id="left-options-container">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $left_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item flex items-center mb-2" wire:key="left_option_<?php echo e($idx); ?>">
                                                <input type="text" wire:model.live="left_options.<?php echo e($idx); ?>" class="option-input flex-1 mr-2" placeholder="Enter left option">
                                                <button type="button" wire:click="removeLeftOption(<?php echo e($idx); ?>)" class="remove-btn w-8 h-8 flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <button type="button" wire:click="addLeftOption" class="add-btn mt-2 w-32">+ Add Left Option</button>
                                </div>
                                <!-- Right Side Options -->
                                <div>
                                    <h5 class="font-semibold mb-2">Right Side Options</h5>
                                    <div id="right-options-container">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item flex items-center mb-2" wire:key="right_option_<?php echo e($idx); ?>">
                                                <input type="text" wire:model.live="right_options.<?php echo e($idx); ?>" class="option-input flex-1 mr-2" placeholder="Enter right option">
                                                <button type="button" wire:click="removeRightOption(<?php echo e($idx); ?>)" class="remove-btn w-8 h-8 flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <button type="button" wire:click="addRightOption" class="add-btn mt-2 w-32">+ Add Right Option</button>
                                </div>
                            </div>
                        </div>

                        <!-- Correct Answer Indices Section -->
                        <!-- Show for statement_match -->
                        <div class="section-block" x-show="type === 'statement_match'">
                            <h3 class="section-title">Correct Answer Pairs</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Select exactly 2 pairs. Use indices starting from 0. Left side: 0 = first option, 1 = second option, etc. Right side: 0 = first option, 1 = second option, etc.
                            </div>
                            <div class="grid grid-cols-2 gap-6 mt-4" wire:key="correct-pairs-section">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = [0,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="option-item" wire:key="pair-<?php echo e($pairIdx); ?>">
                                        <div class="mb-2 font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx+1); ?></div>
                                        <div class="flex gap-4">
                                            <div class="flex-1">
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
                                            </div>
                                            <div class="flex-1">
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
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        
                        <!-- Show for other types (NOT statement_match, NOT opinion, NOT mcq_multiple, NOT true_false_multiple, NOT true_false, NOT reorder, NOT form_fill, NOT picture_mcq, NOT audio_mcq_single, NOT audio_image_text_single, NOT audio_image_text_multiple) -->
                        <div class="section-block" x-show="type !== 'statement_match' && type !== 'opinion' && type !== 'mcq_multiple' && type !== 'true_false_multiple' && type !== 'true_false' && type !== 'reorder' && type !== 'form_fill' && type !== 'picture_mcq' && type !== 'audio_mcq_single' && type !== 'audio_image_text_single' && type !== 'audio_image_text_multiple'">
                            <h3 class="section-title">Correct Answer Indices</h3>
                            <div class="info-banner">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Use 0 for first option, 1 for second option, 2 for third option, etc.
                            </div>
                            <div class="indices-wrapper">
                                <div class="space-y-4">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $answer_indices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answer_index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="index-item">
                                            <div class="flex items-center justify-between mb-3">
                                                <label class="option-label">Answer Index <?php echo e($index + 1); ?></label>
                                                <div class="button-group">
                                                    <!--[if BLOCK]><![endif]--><?php if($index === 0): ?>
                                                        <button type="button" wire:click="addAnswerIndex" class="add-index-btn">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                            Add Index
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" wire:click="removeAnswerIndex(<?php echo e($index); ?>)" class="remove-btn">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                            <input type="number" wire:model="answer_indices.<?php echo e($index); ?>" min="0" placeholder="0" class="index-input">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Upload Section (hidden by default) -->
                    <div class="section-block" id="media-upload-section" style="display:none;">
                        <h3 class="section-title">Media Upload</h3>
                        <input type="file" name="media_file" id="media_file" class="modern-input" accept="audio/*,image/*">
                        <small class="text-gray-500">Upload an audio or image file as required by the question type.</small>
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
                                Create Question
                            </button>
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

    /* Audio Image Text Multiple Section Styling */
    .audio-image-pair-item {
        background: linear-gradient(145deg, #fef7ff 0%, #f3e8ff 100%);
        border: 2px dashed #a855f7;
        transition: all 0.3s ease;
    }

    .audio-image-pair-item:hover {
        border-color: #7c3aed;
        background: linear-gradient(145deg, #faf5ff 0%, #f3e8ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(168, 85, 247, 0.2);
    }

    .audio-image-multiple-match-item {
        animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .audio-indicator {
        transition: all 0.3s ease;
    }

    .audio-indicator:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
    }

    /* Picture MCQ Section Styling */
    .picture-mcq-image-item {
        background: linear-gradient(145deg, #fef7ff 0%, #f3e8ff 100%);
        border: 2px dashed #a855f7;
        transition: all 0.3s ease;
    }

    .picture-mcq-image-item:hover {
        border-color: #7c3aed;
        background: linear-gradient(145deg, #faf5ff 0%, #f3e8ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(168, 85, 247, 0.2);
    }

    /* Form Fill Section Styling */
    .form-fill-paragraph-section {
        background: linear-gradient(145deg, #fefce8 0%, #fef3c7 100%);
        border: 2px solid #f59e0b;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
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

    .filled-paragraph-preview {
        background: white;
        border: 2px solid #10b981;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: #1f2937;
        margin-bottom: 1rem;
        font-weight: 500;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1);
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

    .paragraph-preview {
        background: white;
        border: 2px solid #f59e0b;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: #1f2937;
        margin-bottom: 1rem;
        font-weight: 500;
    }

    .options-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .option-preview {
        background: white;
        border: 1px solid #3b82f6;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: #1e40af;
        font-weight: 500;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin: 0.25rem;
        display: inline-block;
    }

    .no-options-message {
        color: #6b7280;
        font-style: italic;
        font-size: 0.875rem;
        padding: 1rem;
        text-align: center;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
    }

    .answers-preview {
        space-y: 0.5rem;
    }

    .answer-key-preview {
        background: white;
        border: 1px solid #10b981;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #065f46;
        margin-bottom: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Reorder Section Styling */
    .reorder-fragment-item {
        background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .reorder-fragment-item:hover {
        border-color: #3b82f6;
        background: white;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .fragment-number {
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

    .answer-key-section {
        background: linear-gradient(145deg, #fefce8 0%, #fef3c7 100%);
        border: 2px solid #f59e0b;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
    }

    .answer-key-info {
        display: flex;
        align-items: center;
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: rgba(245, 158, 11, 0.1);
        border-radius: 8px;
        font-size: 0.875rem;
        color: #92400e;
        font-weight: 500;
    }

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

    .fragments-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .fragment-preview {
        background: white;
        border: 1px solid #0ea5e9;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: #0c4a6e;
        font-weight: 500;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin: 0.25rem;
        display: inline-block;
    }

    .no-fragments-message {
        color: #6b7280;
        font-style: italic;
        font-size: 0.875rem;
        padding: 1rem;
        text-align: center;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
    }

    .answer-preview {
        background: white;
        border: 2px solid #10b981;
        border-radius: 8px;
        padding: 1rem;
        font-weight: 600;
        color: #064e3b;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Sub Question Styling */
    .sub-question-item, .true-false-item {
        background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .sub-question-item:hover, .true-false-item:hover {
        border-color: #3b82f6;
        background: white;
        transform: translateY(-4px) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .sub-question-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #374151;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* True/False Options Styling */
    .true-false-options {
        margin-top: 0.5rem;
    }

    .true-false-option {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        position: relative;
        overflow: hidden;
        flex: 1;
    }

    .true-false-option:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .true-false-option.selected {
        border-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
    }

    .true-false-option.true-option.selected {
        border-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    .true-false-option.false-option.selected {
        border-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
    }

    .option-circle {
        width: 2rem;
        height: 2rem;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .true-false-option.selected .option-circle {
        border-color: #10b981;
        background: #10b981;
    }

    .true-false-option.false-option.selected .option-circle {
        border-color: #ef4444;
        background: #ef4444;
    }

    .checkmark {
        color: white;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.3s ease;
    }

    .checkmark.show {
        opacity: 1;
        transform: scale(1);
    }

    .option-text {
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        transition: color 0.3s ease;
    }

    .true-false-option.selected .option-text {
        color: #1f2937;
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

    .add-btn-small, .remove-btn-small {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.5rem !important;
        border: none !important;
        border-radius: 6px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .add-btn-small {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        box-shadow: 0 2px 4px -1px rgba(16, 185, 129, 0.4) !important;
    }

    .add-btn-small:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4) !important;
    }

    .remove-btn-small {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        box-shadow: 0 2px 4px -1px rgba(239, 68, 68, 0.4) !important;
    }

    .remove-btn-small:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.4) !important;
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

    /* Clear Buttons for Picture MCQ */
    .clear-pair-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.5rem !important;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 6px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 2px 4px -1px rgba(245, 158, 11, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .clear-pair-btn:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.4) !important;
    }

    .clear-all-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.625rem 1rem !important;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .clear-all-btn:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%) !important;
        color: white !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.4) !important;
    }

    /* Main Action Buttons */
    .submit-btn {
        display: inline-flex !important;
        align-items: center !important;
        padding: 1rem 2rem !important;
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        font-size: 1rem !important;
        font-weight: 700 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #7c3aed 100%) !important;
        color: white !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4) !important;
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

    .info-banner-small {
        padding: 0.5rem 0.75rem;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid #3b82f6;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #1e40af;
        margin-bottom: 0.75rem;
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

    /* Audio Upload Section Styling */
    .audio-upload-section {
        background: linear-gradient(145deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid #0ea5e9;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .audio-upload-section:hover {
        border-color: #0284c7;
        background: linear-gradient(145deg, #e0f2fe 0%, #bae6fd 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -3px rgba(14, 165, 233, 0.2);
    }

    .audio-upload-section .modern-input {
        border-color: #0ea5e9 !important;
        background: white !important;
    }

    .audio-upload-section .modern-input:focus {
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1) !important;
    }

    /* Picture MCQ Match Item Styles */
    .picture-mcq-match-item {
        animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Fixed responsive image sizing for preview */
    .preview-image {
        width: 120px !important;
        height: 120px !important;
        object-fit: cover !important;
        object-position: center !important;
    }

    .picture-mcq-match-item .image-container {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border-radius: 12px;
        overflow: hidden;
    }

    .picture-mcq-match-item .image-container img {
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .picture-mcq-match-item .image-container img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 15px -3px rgba(59, 130, 246, 0.4);
    }

    .picture-mcq-match-item .text-container {
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        transition: all 0.3s ease;
        min-width: 180px;
        text-align: center;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%) !important;
        border: 2px solid #3b82f6 !important;
    }

    .picture-mcq-match-item .text-container span {
        color: #1e3a8a !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    .picture-mcq-match-item .text-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 10px -1px rgba(59, 130, 246, 0.3);
        background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%) !important;
    }

    .picture-mcq-match-item svg {
        transition: all 0.3s ease;
        filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.1));
    }

    .picture-mcq-match-item:hover svg {
        transform: translateX(6px) scale(1.1);
        color: #059669;
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

        .true-false-option {
            padding: 0.75rem 1rem;
        }

        .option-text {
            font-size: 0.875rem;
        }

        .fragments-preview, .options-preview {
            flex-direction: column;
        }

        .true-false-options .flex {
            flex-direction: column;
            gap: 0.75rem;
        }

        .picture-mcq-image-item {
            margin-bottom: 1rem;
        }

        .picture-mcq-image-item img {
            width: 100%;
            max-width: 200px;
            height: auto;
        }

        .preview-image {
            width: 100px !important;
            height: 100px !important;
        }

        .picture-mcq-match-item .image-container {
            width: 100px;
            height: 100px;
        }

        .picture-mcq-match-item .flex {
            flex-direction: column !important;
            space-x: 0 !important;
        }

        .picture-mcq-match-item .flex > * + * {
            margin-left: 0 !important;
            margin-top: 1.5rem !important;
        }

        .picture-mcq-match-item svg {
            transform: rotate(90deg);
        }

        .picture-mcq-match-item:hover svg {
            transform: rotate(90deg) translateX(6px) scale(1.1);
        }

        .picture-mcq-match-item .text-container {
            min-width: 200px;
        }
    }

    @media (max-width: 480px) {
        .preview-image {
            width: 70px !important;
            height: 70px !important;
        }

        .picture-mcq-match-item .image-container {
            width: 70px;
            height: 70px;
        }

        .picture-mcq-match-item .text-container {
            min-width: 160px;
            font-size: 0.875rem !important;
        }

        .clear-pair-btn, .clear-all-btn {
            font-size: 0.625rem !important;
            padding: 0.5rem 0.75rem !important;
        }

        .audio-upload-section {
            padding: 1rem;
        }

        .picture-mcq-image-item {
            margin-bottom: 1rem;
        }

        .picture-mcq-image-item img {
            width: 100%;
            max-width: 200px;
            height: auto;
        }

        .audio-image-pair-item {
            margin-bottom: 1rem;
            padding: 1rem;
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

    .option-item, .index-item, .sub-question-item, .true-false-item, .reorder-fragment-item, .form-fill-option-item, .answer-key-item, .picture-mcq-image-item, .audio-image-pair-item {
        animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\learning\resources\views/filament/resources/question-resource/pages/create-custom.blade.php ENDPATH**/ ?>