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
        <!-- Single Full-Width Card -->
        <div class="modern-card">
            <div class="card-content">
                <!-- Question Details Section -->
                <div class="section-block">
                    <h3 class="section-title">Question Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="modern-label">Day Number</label>
                            <input type="number" value="<?php echo e($record->day->day_number ?? ''); ?>" class="modern-input" readonly>
                        </div>

                        <div>
                            <label class="modern-label">Course</label>
                            <input type="text" value="<?php echo e($record->course->name ?? ''); ?>" class="modern-input" readonly>
                        </div>

                        <div>
                            <label class="modern-label">Subject</label>
                            <input type="text" value="<?php echo e($record->subject->name ?? ''); ?>" class="modern-input" readonly>
                        </div>

                        <div>
                            <label class="modern-label">Question Type</label>
                            <input type="text" value="<?php echo e(ucfirst(str_replace('_', ' ', $record->questionType->name ?? ''))); ?>" class="modern-input" readonly>
                        </div>

                        <div>
                            <label class="modern-label">Marks</label>
                            <input type="number" value="<?php echo e($record->points ?? 1); ?>" class="modern-input" readonly>
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="modern-checkbox-label">
                                <input type="checkbox" class="modern-checkbox" <?php if($record->is_active): ?> checked <?php endif; ?> disabled>
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
                            <label class="modern-label">Question Instruction</label>
                            <textarea rows="4" class="modern-textarea" readonly><?php echo e($record->instruction); ?></textarea>
                        </div>

                        <div>
                            <label class="modern-label">Explanation File</label>
                            <!--[if BLOCK]><![endif]--><?php if($record->explanation): ?>
                                <div class="modern-input flex items-center justify-between">
                                    <span><?php echo e(basename($record->explanation)); ?></span>
                                    <a href="<?php echo e(Storage::url($record->explanation)); ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            <?php else: ?>
                                <input type="text" value="No file uploaded" class="modern-input" readonly>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <?php
                    $isStatementMatch = ($record->questionType->name ?? '') === 'statement_match';
                    $isFormFill = ($record->questionType->name ?? '') === 'form_fill';
                    $isReorder = ($record->questionType->name ?? '') === 'reorder';
                    $isTrueFalseMultiple = ($record->questionType->name ?? '') === 'true_false_multiple';
                    $isTrueFalse = ($record->questionType->name ?? '') === 'true_false';
                    $isMcqMultiple = ($record->questionType->name ?? '') === 'mcq_multiple';
                    $isOpinion = ($record->questionType->name ?? '') === 'opinion';
                    $isPictureMcq = ($record->questionType->name ?? '') === 'picture_mcq';
                    $isAudioMcqSingle = ($record->questionType->name ?? '') === 'audio_mcq_single';
                    $isAudioImageTextSingle = ($record->questionType->name ?? '') === 'audio_image_text_single';
                    $isAudioImageTextMultiple = ($record->questionType->name ?? '') === 'audio_image_text_multiple';

                    // Decode question and answer data
                    $questionData = is_string($record->question_data) ? json_decode($record->question_data, true) : $record->question_data;
                    $answerData = is_string($record->answer_data) ? json_decode($record->answer_data, true) : $record->answer_data;
                ?>

                <!--[if BLOCK]><![endif]--><?php if($isAudioImageTextSingle): ?>
                    <!-- Audio Image Text Single Section -->
                    <div class="section-block">
                        <h3 class="section-title">Audio Image Text - Single Audio with Image to Text Matching</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            This question has one audio file as context/hint, with images that students match to text options while listening to the audio.
                        </div>

                        <!-- Audio File Section -->
                        <?php
                            $audioFile = $record->audio_image_text_audio_file ?? ($questionData['audio_file'] ?? '');
                        ?>
                        <!--[if BLOCK]><![endif]--><?php if($audioFile): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">🎵 Context Audio File</h4>
                                <div class="audio-upload-section">
                                    <label class="modern-label">Audio File (Context/Hint)</label>
                                    <div class="modern-input flex items-center justify-between">
                                        <span><?php echo e(basename($audioFile)); ?></span>
                                        <a href="<?php echo e(Storage::url($audioFile)); ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    
                                    <div class="mt-3 p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <audio controls style="width: 100%;">
                                                <source src="<?php echo e(Storage::url($audioFile)); ?>" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-green-800 mt-2"><?php echo e(basename($audioFile)); ?></p>
                                            <p class="text-sm text-green-600">Students listen to this audio before answering questions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-red-500">Audio file not available.</div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Side - Images -->
                            <div>
                                <h5 class="font-semibold mb-4 text-lg">📷 Images to Match</h5>
                                <div class="space-y-4">
                                    <?php
                                        $images = $record->audio_image_text_images ?? ($questionData['images'] ?? []);
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php if(count($images) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $imagePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="picture-mcq-image-item">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-gray-700">Image <?php echo e($idx + 1); ?></span>
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php if($imagePath): ?>
                                                    <div class="mt-2">
                                                        <img src="<?php echo e(Storage::url($imagePath)); ?>" alt="Image <?php echo e($idx + 1); ?>" class="preview-image object-cover rounded border-2 border-purple-300" style="width: 120px; height: 120px; max-width: 100%; max-height: 100%;">
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="picture-mcq-image-item">
                                            <p class="text-gray-500">No images available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            
                            <!-- Right Side - Text Options -->
                            <div>
                                <h5 class="font-semibold mb-4 text-lg">📝 Text Options</h5>
                                <div class="space-y-2">
                                    <!--[if BLOCK]><![endif]--><?php if($record->right_options && count($record->right_options) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item">
                                                <label class="option-label">Text Option <?php echo e($idx + 1); ?></label>
                                                <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="option-item">
                                            <p class="text-gray-500">No text options available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Correct Answer Pairs -->
                        <div class="mt-6">
                            <h4 class="sub-question-title mb-4">Correct Answer Pairs</h4>
                            <div class="info-banner-small">
                                <span class="text-sm">These are the correct matching pairs for this audio image text question.</span>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">
                                <!--[if BLOCK]><![endif]--><?php if($record->correct_pairs && count($record->correct_pairs) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->correct_pairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item">
                                            <div class="mb-2 font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx + 1); ?></div>
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="modern-label">Image</label>
                                                    <div class="option-input bg-green-50 border-green-200" style="color: #000 !important;">
                                                        <strong><?php echo e($pair['left'] ?? 'N/A'); ?>.</strong> Image <?php echo e(($pair['left'] ?? 0) + 1); ?>

                                                    </div>
                                                </div>
                                                <div class="text-center text-lg font-bold text-blue-600">↓ matches with ↓</div>
                                                <div>
                                                    <label class="modern-label">Text Option</label>
                                                    <div class="option-input bg-blue-50 border-blue-200" style="color: #000 !important;">
                                                        <strong><?php echo e($pair['right'] ?? 'N/A'); ?>.</strong> <?php echo e($record->right_options[$pair['right']] ?? 'Option not found'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="col-span-2">
                                        <div class="option-item text-center">
                                            <p class="text-gray-500">No correct pairs defined</p>
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <?php
                            $images = $record->audio_image_text_images ?? ($questionData['images'] ?? []);
                            $rightOptions = $record->right_options ?? [];
                            $correctPairs = $record->correct_pairs ?? [];
                        ?>
                        <?php if(count($images) > 0 && count($rightOptions) > 0 && count($correctPairs) > 0): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Preview - Image-Text Matching</h4>
                                <div class="preview-section">
                                    <p class="preview-label mb-4">💡 Audio-guided Image-Text Matching:</p>
                                    <div class="space-y-6">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $correctPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $imageIndex = (int)($pair['left'] ?? 0);
                                                $textIndex = (int)($pair['right'] ?? 0);
                                                $imagePath = $images[$imageIndex] ?? '';
                                                $textOption = $rightOptions[$textIndex] ?? '';
                                            ?>
                                            
                                            <!--[if BLOCK]><![endif]--><?php if($imagePath && $textOption): ?>
                                                <div class="picture-mcq-match-item">
                                                    <div class="flex items-center justify-center space-x-8 p-6 bg-white border-2 border-green-200 rounded-xl">
                                                        <!-- Image Section -->
                                                        <div class="flex flex-col items-center space-y-2">
                                                            <div class="image-container">
                                                                <img src="<?php echo e(Storage::url($imagePath)); ?>" 
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
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                <?php elseif($isAudioImageTextMultiple): ?>
                    <!-- Audio Image Text Multiple Section -->
                    <div class="section-block">
                        <h3 class="section-title">Multiple Audio, Multiple Images & Texts</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            This question has multiple image+audio pairs on the left side that students match to text descriptions on the right.
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Side - Image + Audio Pairs -->
                            <div>
                                <h5 class="font-semibold mb-4 text-lg">🎭 Image + Audio Pairs</h5>
                                <div class="space-y-6">
                                    <?php
                                        $imagePairs = $record->audio_image_text_multiple_pairs ?? ($questionData['image_audio_pairs'] ?? []);
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php if(count($imagePairs) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $imagePairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="audio-image-pair-item">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="font-bold text-indigo-700">📱 Pair <?php echo e($idx + 1); ?></span>
                                                </div>
                                                
                                                <!-- Image Display -->
                                                <!--[if BLOCK]><![endif]--><?php if(isset($pair['image']) && $pair['image']): ?>
                                                    <div class="mb-3">
                                                        <label class="modern-label text-sm">🖼️ Image File</label>
                                                        <div class="mt-2">
                                                            <img src="<?php echo e(Storage::url($pair['image'])); ?>" alt="Pair <?php echo e($idx + 1); ?> Image" class="w-20 h-20 object-cover rounded border-2 border-indigo-200">
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                
                                                <!-- Audio Display -->
                                                <!--[if BLOCK]><![endif]--><?php if(isset($pair['audio']) && $pair['audio']): ?>
                                                    <div class="mb-2">
                                                        <label class="modern-label text-sm">🎵 Audio File</label>
                                                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded">
                                                            <span class="text-sm font-medium text-green-700"><?php echo e(basename($pair['audio'])); ?></span>
                                                            <audio controls style="width: 100%; margin-top: 0.5rem; display: block;">
                                                                <source src="<?php echo e(Storage::url($pair['audio'])); ?>" type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="audio-image-pair-item">
                                            <p class="text-gray-500">No image-audio pairs available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            
                            <!-- Right Side - Text Options -->
                            <div>
                                <h5 class="font-semibold mb-4 text-lg">📝 Text Options</h5>
                                <div class="space-y-2">
                                    <!--[if BLOCK]><![endif]--><?php if($record->right_options && count($record->right_options) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item">
                                                <label class="option-label">Text Option <?php echo e($idx + 1); ?></label>
                                                <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="option-item">
                                            <p class="text-gray-500">No text options available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Correct Answer Pairs -->
                        <div class="mt-6">
                            <h4 class="sub-question-title mb-4">Correct Answer Pairs</h4>
                            <div class="info-banner-small">
                                <span class="text-sm">These are the correct matching pairs for this audio image text multiple question.</span>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">
                                <!--[if BLOCK]><![endif]--><?php if($record->correct_pairs && count($record->correct_pairs) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->correct_pairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item">
                                            <div class="mb-2 font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx + 1); ?></div>
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="modern-label">Image+Audio Pair</label>
                                                    <div class="option-input bg-green-50 border-green-200" style="color: #000 !important;">
                                                        <strong><?php echo e($pair['left'] ?? 'N/A'); ?>.</strong> Pair <?php echo e(($pair['left'] ?? 0) + 1); ?>

                                                    </div>
                                                </div>
                                                <div class="text-center text-lg font-bold text-blue-600">↓ matches with ↓</div>
                                                <div>
                                                    <label class="modern-label">Text Option</label>
                                                    <div class="option-input bg-blue-50 border-blue-200" style="color: #000 !important;">
                                                        <strong><?php echo e($pair['right'] ?? 'N/A'); ?>.</strong> <?php echo e($record->right_options[$pair['right']] ?? 'Option not found'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="col-span-2">
                                        <div class="option-item text-center">
                                            <p class="text-gray-500">No correct pairs defined</p>
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <?php
                            $imagePairs = $record->audio_image_text_multiple_pairs ?? ($questionData['image_audio_pairs'] ?? []);
                            $rightOptions = $record->right_options ?? [];
                            $correctPairs = $record->correct_pairs ?? [];
                        ?>
                        <?php if(count($imagePairs) > 0 && count($rightOptions) > 0 && count($correctPairs) > 0): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Preview - Image+Audio to Text Matching</h4>
                                <div class="preview-section">
                                    <p class="preview-label mb-4">💡 Image+Audio to Text Matching Preview:</p>
                                    <div class="space-y-6">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $correctPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $pairIndex = (int)($pair['left'] ?? 0);
                                                $textIndex = (int)($pair['right'] ?? 0);
                                                $imagePair = $imagePairs[$pairIndex] ?? null;
                                                $textOption = $rightOptions[$textIndex] ?? '';
                                            ?>
                                            
                                            <!--[if BLOCK]><![endif]--><?php if($imagePair && isset($imagePair['image']) && isset($imagePair['audio']) && $textOption): ?>
                                                <div class="audio-image-multiple-match-item">
                                                    <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-8 p-6 bg-white border-2 border-green-200 rounded-xl">
                                                        <!-- Image + Audio Section -->
                                                        <div class="flex flex-col items-center space-y-3">
                                                            <div class="image-container">
                                                                <img src="<?php echo e(Storage::url($imagePair['image'])); ?>" 
                                                                     alt="Image <?php echo e($pairIndex + 1); ?>" 
                                                                     class="preview-image object-cover rounded-lg border-2 border-indigo-300">
                                                            </div>
                                                            <div class="audio-indicator bg-indigo-100 border-2 border-indigo-300 px-3 py-2 rounded-lg">
                                                                <div class="flex items-center space-x-2">
                                                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                                                    </svg>
                                                                    <span class="text-sm font-medium text-indigo-700">🎵 <?php echo e(basename($imagePair['audio'])); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Answer Preview Section -->
                                                        <div class="flex flex-col items-center w-full md:w-auto">
                                                            <div class="answer-preview"><?php echo e($textOption); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                <?php elseif($isAudioMcqSingle): ?>
                    <!-- Audio MCQ Single Section -->
                    <div class="section-block">
                        <h3 class="section-title">Audio MCQ - Single Audio, Multiple Questions</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            This question has one audio file with multiple sub-questions that students answer after listening.
                        </div>

                        <!-- Audio File Section -->
                        <?php
                            $audioFile = $questionData['audio_file'] ?? '';
                        ?>
                        <!--[if BLOCK]><![endif]--><?php if($audioFile): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">🎵 Audio File</h4>
                                <div class="audio-upload-section">
                                    <label class="modern-label">Audio File</label>
                                    <div class="modern-input flex items-center justify-between">
                                        <span><?php echo e(basename($audioFile)); ?></span>
                                        <a href="<?php echo e(Storage::url($audioFile)); ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    
                                    <div class="mt-3 p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <audio controls style="width: 100%;">
                                                <source src="<?php echo e(Storage::url($audioFile)); ?>" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-green-800 mt-2"><?php echo e(basename($audioFile)); ?></p>
                                            <p class="text-sm text-green-600">Students listen to this audio before answering questions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-red-500">Audio file not available.</div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!-- Audio MCQ Sub Questions Container -->
                        <div class="space-y-6">
                            <?php
                                $subQuestions = $questionData['sub_questions'] ?? [];
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if(count($subQuestions) > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subIndex => $subQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="sub-question-item">
                                        <!-- Sub Question Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="sub-question-title">Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</h4>
                                        </div>

                                        <!-- Sub Question Text -->
                                        <div class="mb-4">
                                            <label class="modern-label">Sub-question <?php echo e(chr(97 + $subIndex)); ?>) Text</label>
                                            <textarea rows="2" class="modern-textarea" readonly><?php echo e($subQuestion['question'] ?? ''); ?></textarea>
                                        </div>

                                        <!-- Sub Question Options -->
                                        <div class="mb-4">
                                            <label class="modern-label">Options for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="space-y-3">
                                                <?php
                                                    $subOptions = $subQuestion['options'] ?? [];
                                                ?>
                                                <!--[if BLOCK]><![endif]--><?php if(count($subOptions) > 0): ?>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="option-item">
                                                            <label class="option-label">Option <?php echo e($optIndex + 1); ?></label>
                                                            <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php else: ?>
                                                    <p class="text-gray-500">No options defined</p>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <!-- Correct Answer Indices for this sub-question -->
                                        <div class="mb-4">
                                            <label class="modern-label">Correct Answer Indices for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="info-banner-small">
                                                <span class="text-sm">Use 0 for first option, 1 for second option, etc. Multiple correct answers are supported.</span>
                                            </div>
                                            <div class="space-y-2">
                                                <?php
                                                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                                                ?>
                                                <!--[if BLOCK]><![endif]--><?php if(count($correctIndices) > 0): ?>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $correctIndices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ansIndex => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="index-item">
                                                            <div class="flex items-center justify-between mb-3">
                                                                <label class="option-label">Answer Index <?php echo e($ansIndex + 1); ?></label>
                                                                <div class="text-sm text-gray-600 bg-green-100 px-3 py-1 rounded-full">
                                                                    Points to: "<?php echo e($subOptions[$correctIndex] ?? 'Option not found'); ?>"
                                                                </div>
                                                            </div>
                                                            <input type="number" value="<?php echo e($correctIndex); ?>" class="index-input bg-green-50 border-green-200" readonly>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php else: ?>
                                                    <p class="text-gray-500">No correct indices defined</p>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <div class="sub-question-item">
                                    <p class="text-gray-500">No sub-questions defined</p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                <?php elseif($isPictureMcq): ?>
                    <!-- Picture MCQ Section -->
                    <div class="section-block">
                        <h3 class="section-title">Picture MCQ (Images to Text Matching)</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Students match images on the left side with corresponding text options on the right side.
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Side - Images -->
                            <div>
                                <h5 class="font-semibold mb-4 text-lg">📷 Images</h5>
                                <div class="space-y-4">
                                    <?php
                                        $images = $record->picture_mcq_images ?? ($questionData['images'] ?? []);
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php if(count($images) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $imagePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="picture-mcq-image-item">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-gray-700">Image <?php echo e($idx + 1); ?></span>
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php if($imagePath): ?>
                                                    <div class="mt-2">
                                                        <img src="<?php echo e(Storage::url($imagePath)); ?>" alt="Image <?php echo e($idx + 1); ?>" class="w-20 h-20 object-cover rounded border">
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="picture-mcq-image-item">
                                            <p class="text-gray-500">No images available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            
                            <!-- Right Side - Text Options -->
                            <div>
                                <h5 class="font-semibold mb-4 text-lg">📝 Text Options</h5>
                                <div class="space-y-2">
                                    <!--[if BLOCK]><![endif]--><?php if($record->right_options && count($record->right_options) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item">
                                                <label class="option-label">Text Option <?php echo e($idx + 1); ?></label>
                                                <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="option-item">
                                            <p class="text-gray-500">No text options available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Correct Answer Pairs for Picture MCQ -->
                        <div class="mt-6">
                            <h4 class="sub-question-title mb-4">Correct Answer Pairs</h4>
                            <div class="info-banner-small">
                                <span class="text-sm">These are the correct matching pairs for this picture MCQ question.</span>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">
                                <!--[if BLOCK]><![endif]--><?php if($record->correct_pairs && count($record->correct_pairs) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->correct_pairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item">
                                            <div class="mb-2 font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx + 1); ?></div>
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="modern-label">Image</label>
                                                    <div class="option-input bg-green-50 border-green-200" style="color: #000 !important;">
                                                        <strong><?php echo e($pair['left'] ?? 'N/A'); ?>.</strong> Image <?php echo e(($pair['left'] ?? 0) + 1); ?>

                                                    </div>
                                                </div>
                                                <div class="text-center text-lg font-bold text-blue-600">↓ matches with ↓</div>
                                                <div>
                                                    <label class="modern-label">Text Option</label>
                                                    <div class="option-input bg-blue-50 border-blue-200" style="color: #000 !important;">
                                                        <strong><?php echo e($pair['right'] ?? 'N/A'); ?>.</strong> <?php echo e($record->right_options[$pair['right']] ?? 'Option not found'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="col-span-2">
                                        <div class="option-item text-center">
                                            <p class="text-gray-500">No correct pairs defined</p>
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Preview Section for Picture MCQ -->
                        <?php
                            $images = $record->picture_mcq_images ?? ($questionData['images'] ?? []);
                            $rightOptions = $record->right_options ?? [];
                            $correctPairs = $record->correct_pairs ?? [];
                        ?>
                        <?php if(count($images) > 0 && count($rightOptions) > 0 && count($correctPairs) > 0): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Preview - Image-Text Matching</h4>
                                <div class="preview-section">
                                    <p class="preview-label mb-4">💡 Image-Text Matching Preview:</p>
                                    <div class="space-y-6">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $correctPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $imageIndex = (int)($pair['left'] ?? 0);
                                                $textIndex = (int)($pair['right'] ?? 0);
                                                $imagePath = $images[$imageIndex] ?? '';
                                                $textOption = $rightOptions[$textIndex] ?? '';
                                            ?>
                                            
                                            <!--[if BLOCK]><![endif]--><?php if($imagePath && $textOption): ?>
                                                <div class="picture-mcq-match-item">
                                                    <div class="flex items-center justify-center space-x-8 p-6 bg-white border-2 border-green-200 rounded-xl">
                                                        <!-- Image Section -->
                                                        <div class="flex flex-col items-center space-y-2">
                                                            <div class="image-container">
                                                                <img src="<?php echo e(Storage::url($imagePath)); ?>" 
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
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                <?php elseif($isFormFill): ?>
                    <!-- Form Fill Section -->
                    <div class="section-block">
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
                                <label class="modern-label">Paragraph Text</label>
                                <?php
                                    $paragraph = $record->form_fill_paragraph ?? ($questionData['paragraph'] ?? '');
                                ?>
                                <div class="paragraph-text">
                                    <?php echo e($paragraph); ?>

                                </div>
                                
                                <!--[if BLOCK]><![endif]--><?php if($paragraph): ?>
                                    <div class="paragraph-info">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Contains <?php echo e(substr_count($paragraph, '___')); ?> blank(s) to fill.</span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Options -->
                        <div class="mb-6">
                            <h4 class="sub-question-title mb-4">Answer Options</h4>
                            <div class="space-y-4">
                                <?php
                                    $options = $questionData['options'] ?? [];
                                ?>
                                <!--[if BLOCK]><![endif]--><?php if(count($options) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-fill-option-item">
                                            <div class="flex items-center space-x-3">
                                                <div class="option-number"><?php echo e($index + 1); ?></div>
                                                <div class="flex-1">
                                                    <input type="text" value="<?php echo e($option); ?>" readonly class="option-input">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="form-fill-option-item">
                                        <p class="text-gray-500">No options available</p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Answer Keys -->
                        <div class="mb-6">
                            <h4 class="sub-question-title mb-4">Answer Keys</h4>
                            <div class="answer-key-section">
                                <div class="space-y-4">
                                    <?php
                                        $answerKeys = $answerData['answer_keys'] ?? [];
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php if(count($answerKeys) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $answerKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answerKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="answer-key-item">
                                                <div class="flex items-center space-x-3">
                                                    <div class="answer-number">Blank <?php echo e($index + 1); ?></div>
                                                    <div class="flex-1">
                                                        <input type="text" value="<?php echo e($answerKey); ?>" readonly class="option-input bg-green-50 border-green-200">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="answer-key-item">
                                            <p class="text-gray-500">No answer keys defined</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <?php
                            $paragraph = $record->form_fill_paragraph ?? ($questionData['paragraph'] ?? '');
                            $answerKeys = $answerData['answer_keys'] ?? [];
                        ?>
                        <!--[if BLOCK]><![endif]--><?php if($paragraph && count($answerKeys) > 0): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Preview - Complete Sentence</h4>
                                <div class="preview-section">
                                    <?php
                                        $answerIndex = 0;
                                        $filledParagraph = preg_replace_callback('/___/', function($matches) use ($answerKeys, &$answerIndex) {
                                            if ($answerIndex < count($answerKeys)) {
                                                $answer = trim($answerKeys[$answerIndex]);
                                                $answerIndex++;
                                                if (!empty($answer)) {
                                                    return '<span class="filled-answer">' . $answer . '</span>';
                                                }
                                            }
                                            return '<span class="empty-blank">___</span>';
                                        }, $paragraph);
                                    ?>
                                    
                                    <div class="filled-paragraph-main">
                                        <p class="preview-label-main">✅ Complete Sentence with Answers:</p>
                                        <div class="paragraph-preview-filled"><?php echo $filledParagraph; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                <?php elseif($isReorder): ?>
                    <!-- Reorder Section -->
                    <div class="section-block">
                        <h3 class="section-title">Sentence Reordering</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Students will reorder these sentence fragments to form the correct sentence.
                        </div>
                        
                        <!-- Sentence Fragments -->
                        <div class="mb-6">
                            <h4 class="sub-question-title mb-4">Sentence Fragments</h4>
                            <div class="space-y-4">
                                <?php
                                    $fragments = $record->reorder_fragments ?? ($questionData['fragments'] ?? []);
                                ?>
                                <!--[if BLOCK]><![endif]--><?php if(count($fragments) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $fragments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fragment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="reorder-fragment-item">
                                            <div class="flex items-center space-x-3">
                                                <div class="fragment-number"><?php echo e($index + 1); ?></div>
                                                <div class="flex-1">
                                                    <input type="text" value="<?php echo e($fragment); ?>" class="option-input" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="reorder-fragment-item">
                                        <p class="text-gray-500">No fragments available</p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Answer Key -->
                        <div class="mb-6">
                            <h4 class="sub-question-title mb-4">Answer Key</h4>
                            <div class="answer-key-section">
                                <?php
                                    $answerKey = $record->reorder_answer_key ?? ($answerData['answer_key'] ?? '');
                                ?>
                                <!--[if BLOCK]><![endif]--><?php if($answerKey): ?>
                                    <label class="modern-label">Correct Sentence</label>
                                    <textarea rows="3" class="modern-textarea bg-green-50 border-green-200" readonly><?php echo e($answerKey); ?></textarea>
                                <?php else: ?>
                                    <p class="text-gray-500">No answer key defined</p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <?php
                            $fragments = $record->reorder_fragments ?? ($questionData['fragments'] ?? []);
                            $answerKey = $record->reorder_answer_key ?? ($answerData['answer_key'] ?? '');
                        ?>
                        <?php if(count($fragments) > 0 && $answerKey): ?>
                            <div class="mb-6">
                                <h4 class="sub-question-title mb-4">Preview</h4>
                                <div class="preview-section">
                                    <div class="preview-fragments">
                                        <p class="preview-label">Fragments to be reordered:</p>
                                        <div class="fragments-preview">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $fragments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fragment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="fragment-preview"><?php echo e(trim($fragment)); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    
                                    <div class="preview-answer">
                                        <p class="preview-label">Expected result:</p>
                                        <div class="answer-preview"><?php echo e(trim($answerKey)); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                <?php elseif($isTrueFalse): ?>
                    <!-- Simple True/False Section -->
                    <div class="section-block">
                        <h3 class="section-title">True/False Question</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            A single True/False statement where students choose between True or False.
                        </div>
                        
                        <!-- Statement Text -->
                        <div class="mb-4">
                            <label class="modern-label">Statement Text</label>
                            <?php
                                $statement = $questionData['statement'] ?? '';
                            ?>
                            <div class="statement-text">
                                <?php echo e($statement); ?>

                            </div>
                        </div>
                        
                        <!-- Correct Answer -->
                        <div class="mb-4">
                            <label class="modern-label">Correct Answer</label>
                            <?php
                                $correctAnswer = $answerData['correct_answer'] ?? '';
                            ?>
                            <div class="true-false-options">
                                <div class="true-false-option <?php echo e($correctAnswer === 'true' ? 'selected' : ''); ?>">
                                    <div class="option-circle">
                                        <svg class="w-5 h-5 checkmark <?php echo e($correctAnswer === 'true' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="true-false-label">True</span>
                                </div>
                                <div class="true-false-option <?php echo e($correctAnswer === 'false' ? 'selected' : ''); ?>">
                                    <div class="option-circle">
                                        <svg class="w-5 h-5 checkmark <?php echo e($correctAnswer === 'false' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="true-false-label">False</span>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php elseif($isTrueFalseMultiple): ?>
                    <!-- True/False Multiple Section -->
                    <div class="section-block">
                        <h3 class="section-title">True/False Multiple Questions</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Multiple True/False statements for students to evaluate.
                        </div>
                        
                        <div class="space-y-6">
                            <?php
                                $questions = $record->true_false_questions ?? ($questionData['questions'] ?? []);
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if(count($questions) > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tfIndex => $tfQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="true-false-item">
                                        <!-- True/False Question Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="sub-question-title">Statement <?php echo e(chr(97 + $tfIndex)); ?>)</h4>
                                        </div>
                                        
                                        <!-- True/False Question Content -->
                                        <div class="true-false-content">
                                            <div class="mb-4">
                                                <label class="modern-label">Statement Text</label>
                                                <div class="statement-text">
                                                    <?php echo e($tfQuestion['text'] ?? $tfQuestion['statement'] ?? ''); ?>

                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label class="modern-label">Correct Answer</label>
                                                <div class="true-false-options">
                                                    <div class="true-false-option <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'true' ? 'selected' : ''); ?>">
                                                        <div class="option-circle">
                                                            <svg class="w-5 h-5 checkmark <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'true' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="true-false-label">True</span>
                                                    </div>
                                                    <div class="true-false-option <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'false' ? 'selected' : ''); ?>">
                                                        <div class="option-circle">
                                                            <svg class="w-5 h-5 checkmark <?php echo e(($tfQuestion['correct_answer'] ?? '') === 'false' ? 'show' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="true-false-label">False</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <div class="true-false-item">
                                    <p class="text-gray-500">No True/False questions defined</p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                <?php elseif($isMcqMultiple): ?>
                    <!-- MCQ Multiple Section -->
                    <div class="section-block">
                        <h3 class="section-title">MCQ Multiple Questions</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Multiple sub-questions each with their own options and correct answers.
                        </div>
                        
                        <div class="space-y-6">
                            <?php
                                $subQuestions = $questionData['sub_questions'] ?? [];
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if(count($subQuestions) > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subIndex => $subQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="sub-question-item">
                                        <!-- Sub Question Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="sub-question-title">Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</h4>
                                        </div>

                                        <!-- Sub Question Text -->
                                        <div class="mb-4">
                                            <label class="modern-label">Sub-question <?php echo e(chr(97 + $subIndex)); ?>) Text</label>
                                            <textarea rows="2" class="modern-textarea" readonly><?php echo e($subQuestion['question'] ?? ''); ?></textarea>
                                        </div>

                                        <!-- Sub Question Options -->
                                        <div class="mb-4">
                                            <label class="modern-label">Options for Sub-question <?php echo e(chr(97 + $subIndex)); ?>)</label>
                                            <div class="space-y-3">
                                                <?php
                                                    $subOptions = $subQuestion['options'] ?? [];
                                                ?>
                                                <!--[if BLOCK]><![endif]--><?php if(count($subOptions) > 0): ?>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optIndex => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="option-item">
                                                            <label class="option-label">Option <?php echo e($optIndex + 1); ?></label>
                                                            <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php else: ?>
                                                    <p class="text-gray-500">No options defined</p>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <!-- Correct Answer Indices -->
                                        <div class="mb-4">
                                            <label class="modern-label">Correct Answer Indices</label>
                                            <div class="space-y-2">
                                                <?php
                                                    $correctIndices = $subQuestion['correct_indices'] ?? [];
                                                ?>
                                                <!--[if BLOCK]><![endif]--><?php if(count($correctIndices) > 0): ?>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $correctIndices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ansIndex => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="index-item">
                                                            <div class="flex items-center justify-between mb-3">
                                                                <label class="option-label">Answer Index <?php echo e($ansIndex + 1); ?></label>
                                                                <div class="text-sm text-gray-600 bg-green-100 px-3 py-1 rounded-full">
                                                                    Points to: "<?php echo e($subOptions[$correctIndex] ?? 'Option not found'); ?>"
                                                                </div>
                                                            </div>
                                                            <input type="number" value="<?php echo e($correctIndex); ?>" class="index-input bg-green-50 border-green-200" readonly>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php else: ?>
                                                    <p class="text-gray-500">No correct indices defined</p>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <div class="sub-question-item">
                                    <p class="text-gray-500">No sub-questions defined</p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                <?php elseif($isStatementMatch): ?>
                    <!-- Statement Match Section -->
                    <div class="section-block">
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
                                    <!--[if BLOCK]><![endif]--><?php if($record->left_options && count($record->left_options) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->left_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item">
                                                <label class="option-label">Left Option <?php echo e($idx + 1); ?></label>
                                                <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="option-item">
                                            <p class="text-gray-500">No left options available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            
                            <!-- Right Side Options -->
                            <div>
                                <h5 class="font-semibold mb-2">Right Side Options</h5>
                                <div class="space-y-2">
                                    <!--[if BLOCK]><![endif]--><?php if($record->right_options && count($record->right_options) > 0): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->right_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="option-item">
                                                <label class="option-label">Right Option <?php echo e($idx + 1); ?></label>
                                                <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                        <div class="option-item">
                                            <p class="text-gray-500">No right options available</p>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Correct Answer Pairs Section -->
                    <div class="section-block">
                        <h3 class="section-title">Correct Answer Pairs</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            These are the correct matching pairs for this statement match question.
                        </div>
                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <!--[if BLOCK]><![endif]--><?php if($record->correct_pairs && count($record->correct_pairs) > 0): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->correct_pairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pairIdx => $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="option-item">
                                        <div class="mb-2 font-semibold" style="color: #000 !important;">Correct Pair <?php echo e($pairIdx + 1); ?></div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="modern-label">Left Option</label>
                                                <div class="option-input bg-green-50 border-green-200" style="color: #000 !important;">
                                                    <strong><?php echo e($pair['left'] ?? 'N/A'); ?>.</strong> <?php echo e($record->left_options[$pair['left']] ?? 'Option not found'); ?>

                                                </div>
                                            </div>
                                            <div class="text-center text-lg font-bold text-blue-600">↓ matches with ↓</div>
                                            <div>
                                                <label class="modern-label">Right Option</label>
                                                <div class="option-input bg-blue-50 border-blue-200" style="color: #000 !important;">
                                                    <strong><?php echo e($pair['right'] ?? 'N/A'); ?>.</strong> <?php echo e($record->right_options[$pair['right']] ?? 'Option not found'); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <div class="col-span-2">
                                    <div class="option-item text-center">
                                        <p class="text-gray-500">No correct pairs defined</p>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                <?php elseif($isOpinion): ?>
                    <!-- Opinion Type Section -->
                    <div class="section-block">
                        <h3 class="section-title">Opinion Question</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            This is an open-ended opinion question where students provide their own text response.
                        </div>
                        
                        <div>
                            <label class="modern-label">Expected/Sample Answer (Reference)</label>
                            <?php
                                $opinionAnswer = $answerData['opinion_answer'] ?? ($questionData['opinion_answer'] ?? '');
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if($opinionAnswer): ?>
                                <textarea rows="4" class="modern-textarea bg-blue-50 border-blue-200" readonly><?php echo e($opinionAnswer); ?></textarea>
                            <?php else: ?>
                                <textarea rows="4" class="modern-textarea" readonly placeholder="No sample answer provided - students will give their own opinion"></textarea>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Regular Question Options Section -->
                    <div class="section-block">
                        <h3 class="section-title">Question Options</h3>
                        <div class="options-wrapper">
                            <div class="space-y-4">
                                <?php
                                    $options = $questionData['options'] ?? [];
                                ?>
                                <!--[if BLOCK]><![endif]--><?php if($options && count($options) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="option-item">
                                            <label class="option-label">Option <?php echo e($index + 1); ?></label>
                                            <input type="text" value="<?php echo e($option); ?>" class="option-input" readonly>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="option-item">
                                        <label class="option-label">No options available</label>
                                        <input type="text" value="" class="option-input" readonly>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>

                    <!-- Correct Answer Indices Section -->
                    <div class="section-block">
                        <h3 class="section-title">Correct Answer Indices</h3>
                        <div class="info-banner">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            These indices indicate the correct answer options (0 = first option, 1 = second option, etc.)
                        </div>
                        <div class="indices-wrapper">
                            <div class="space-y-4">
                                <?php
                                    $correctIndices = $answerData['correct_indices'] ?? [];
                                ?>
                                <!--[if BLOCK]><![endif]--><?php if($correctIndices && count($correctIndices) > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $correctIndices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $correctIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="index-item">
                                            <div class="flex items-center justify-between mb-3">
                                                <label class="option-label">Answer Index <?php echo e($index + 1); ?></label>
                                                <div class="text-sm text-gray-600 bg-green-100 px-3 py-1 rounded-full">
                                                    Points to: "<?php echo e($options[$correctIndex] ?? 'Option not found'); ?>"
                                                </div>
                                            </div>
                                            <input type="number" value="<?php echo e($correctIndex); ?>" class="index-input bg-green-50 border-green-200" readonly>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <div class="index-item">
                                        <label class="option-label">No correct indices defined</label>
                                        <input type="text" value="" class="index-input" readonly>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Action Buttons -->
                <div class="section-block">
                    <div class="flex justify-end space-x-4">
                        <a href="<?php echo e(\App\Filament\Resources\QuestionResource::getUrl('index')); ?>" class="cancel-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Questions
                        </a>
                        <a href="<?php echo e(\App\Filament\Resources\QuestionResource::getUrl('edit', ['record' => $record])); ?>" class="submit-btn">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Question
                        </a>
                    </div>
                </div>
            </div>
        </div>
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

    /* Audio Image Text Multiple Section Styling */
    .audio-image-pair-item {
        background: linear-gradient(145deg, #fef7ff 0%, #f3e8ff 100%);
        border: 2px dashed #a855f7;
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
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
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
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

    .form-fill-option-item, .answer-key-item, .reorder-fragment-item {
        background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .form-fill-option-item:hover, .answer-key-item:hover, .reorder-fragment-item:hover {
        border-color: #3b82f6;
        background: white;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .option-number, .answer-number, .fragment-number {
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

    .paragraph-preview-filled {
        font-size: 1.125rem;
        line-height: 1.7;
        color: #1f2937;
        font-weight: 500;
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

    /* Answer Key Section */
    .answer-key-section {
        background: linear-gradient(145deg, #fefce8 0%, #fef3c7 100%);
        border: 2px solid #f59e0b;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
    }

    /* Preview Section */
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

    .answer-preview {
        background: white;
        border: 2px solid #10b981;
        border-radius: 8px;
        padding: 1rem;
        font-weight: 600;
        color: #064e3b;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: white;
        position: relative;
        overflow: hidden;
        flex: 1;
    }

    .true-false-option.selected {
        border-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
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

    .true-false-label {
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        transition: color 0.3s ease;
    }

    .true-false-option.selected .true-false-label {
        color: #1f2937;
    }

    /* Statement Text */
    .statement-text {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        color: #1f2937;
        margin-top: 0.75rem;
        font-weight: 500;
        white-space: pre-wrap;
    }

    /* Sub Question and True/False Items */
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

    /* Sub Question Styling */
    .sub-question-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #374151;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.75rem;
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
        background: #f8fafc !important;
        color: #1f2937 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }

    .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
        outline: none !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px) !important;
    }

    .modern-checkbox-label {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        cursor: default;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
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
        background: #f8fafc !important;
        margin-top: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }

    .option-input:focus, .index-input:focus {
        outline: none !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-1px) !important;
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
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 2px solid #3b82f6;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
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

    /* Special styling for correct answers */
    .bg-green-50 {
        background: #f0fdf4 !important;
    }
    
    .border-green-200 {
        border-color: #bbf7d0 !important;
    }
    
    .bg-blue-50 {
        background: #eff6ff !important;
    }
    
    .border-blue-200 {
        border-color: #bfdbfe !important;
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
        
        .section-block {
            padding: 1rem 0;
        }

        .true-false-options {
            flex-direction: column;
            gap: 0.75rem;
        }

        .fragments-preview {
            flex-direction: column;
        }

        .filled-paragraph-main {
            font-size: 1rem;
            padding: 1.5rem;
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

        .audio-image-pair-item {
            margin-bottom: 1rem;
            padding: 1rem;
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

    /* Animation for items */
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\learning\resources\views/filament/resources/question-resource/pages/view-custom.blade.php ENDPATH**/ ?>