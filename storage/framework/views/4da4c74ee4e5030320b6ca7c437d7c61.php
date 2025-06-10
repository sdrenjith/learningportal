<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => ['class' => 'fi-dashboard-page']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'fi-dashboard-page']); ?>
    <div class="px-4 min-h-screen bg-white text-gray-900">
        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6 dashboard-card-container">
            <!-- Courses Card -->
            <a href="<?php echo e(route('filament.admin.resources.courses.index')); ?>" class="group db-card relative overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 p-8 shadow-2xl transition-all duration-300 hover:shadow-3xl text-white cursor-pointer block focus:outline-none focus:ring-2 focus:ring-blue-400">
                <div class="absolute top-4 right-4 text-5xl text-white opacity-10">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="text-5xl font-black mb-3 leading-none text-white"><?php echo e(App\Models\Course::count()); ?></div>
                    <div class="text-lg font-semibold tracking-wide opacity-95 mb-4 text-white">Courses</div>
                </div>
            </a>

            <!-- Subjects Card -->
            <a href="<?php echo e(route('filament.admin.resources.subjects.index')); ?>" class="group db-card relative overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 p-8 shadow-2xl transition-all duration-300 hover:shadow-3xl text-white cursor-pointer block focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <div class="absolute top-4 right-4 text-5xl text-white opacity-10">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 012-2h8a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V3zm2 0v14h8V3H6zm2 2h4v2H8V5zm0 4h4v2H8V9zm0 4h4v2H8v-2z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="text-5xl font-black mb-3 leading-none text-white"><?php echo e(App\Models\Subject::count()); ?></div>
                    <div class="text-lg font-semibold tracking-wide opacity-95 mb-4 text-white">Subjects</div>
                </div>
            </a>

            <!-- Questions Card -->
            <a href="<?php echo e(route('filament.admin.resources.questions.index')); ?>" class="group db-card relative overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 p-8 shadow-2xl transition-all duration-300 hover:shadow-3xl text-white cursor-pointer block focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <div class="absolute top-4 right-4 text-5xl text-white opacity-10">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="text-5xl font-black mb-3 leading-none text-white"><?php echo e(App\Models\Question::count()); ?></div>
                    <div class="text-lg font-semibold tracking-wide opacity-95 mb-4 text-white">Questions</div>
                </div>
            </a>

            <!-- Users Card -->
            <a href="<?php echo e(route('filament.admin.resources.users.index')); ?>" class="group db-card relative overflow-hidden rounded-2xl bg-gray-900 border border-gray-800 p-8 shadow-2xl transition-all duration-300 hover:shadow-3xl text-white cursor-pointer block focus:outline-none focus:ring-2 focus:ring-blue-400">
                <div class="absolute top-4 right-4 text-5xl text-white opacity-10">
                    <svg class="w-14 h-14" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 100 12A6 6 0 0010 2zm0 2a4 4 0 110 8 4 4 0 010-8zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="text-5xl font-black mb-3 leading-none text-white"><?php echo e(App\Models\User::count()); ?></div>
                    <div class="text-lg font-semibold tracking-wide opacity-95 mb-4 text-white">Users</div>
                </div>
            </a>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>

<?php $__env->startPush('styles'); ?>
<style>
.dashboard-card-container {
    max-width: 98%;
    margin: 0 auto;
}
</style>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\learning\resources\views/filament/pages/dashboard.blade.php ENDPATH**/ ?>