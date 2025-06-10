<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => ['class' => \Illuminate\Support\Arr::toCssClasses([
        'fi-resource-list-records-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
        'fi-resource-list-records-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ]))]); ?>
    <div class="flex flex-col gap-y-6">
        <?php if (isset($component)) { $__componentOriginale77d85bd24d039fa58cc32119f1d9bc5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.resources.tabs','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::resources.tabs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5)): ?>
<?php $attributes = $__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5; ?>
<?php unset($__attributesOriginale77d85bd24d039fa58cc32119f1d9bc5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale77d85bd24d039fa58cc32119f1d9bc5)): ?>
<?php $component = $__componentOriginale77d85bd24d039fa58cc32119f1d9bc5; ?>
<?php unset($__componentOriginale77d85bd24d039fa58cc32119f1d9bc5); ?>
<?php endif; ?>

        <div class="modern-card-table">
            <div class="modern-list-header">
                <!--[if BLOCK]><![endif]--><?php if(method_exists($this, 'getCreateButtonLabel')): ?>
                    <a href="<?php echo e($this->getResource()::getUrl('create')); ?>" class="modern-btn-primary">+ <?php echo e($this->getCreateButtonLabel()); ?></a>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE, scopes: $this->getRenderHookScopes())); ?>


            <?php echo e($this->table); ?>


            <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER, scopes: $this->getRenderHookScopes())); ?>

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
.modern-card-table {
    background: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 2px 12px 0 #0001;
    padding: 2rem 2.5rem;
    position: relative;
}
.modern-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.modern-list-header-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
}
.modern-btn-primary {
    background: #2563eb;
    color: #fff;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    transition: background 0.2s;
    box-shadow: 0 1px 4px 0 #0001;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}
.modern-btn-primary:hover {
    background: #1d4ed8;
}
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 1px 6px 0 #0001;
    overflow: hidden;
}
thead tr {
    background: linear-gradient(90deg, #f1f5f9 0%, #e0e7ef 100%);
}
th {
    font-weight: 700;
    color: #1e293b;
    padding: 1rem 0.75rem;
    font-size: 1.05rem;
    border-bottom: 2px solid #e5e7eb;
}
td {
    padding: 0.85rem 0.75rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: 1rem;
    color: #334155;
}
tbody tr {
    transition: background 0.15s;
}
tbody tr:hover {
    background: #f3f4f6;
}
tr:last-child td {
    border-bottom: none;
}
th:first-child, td:first-child {
    border-top-left-radius: 0.75rem;
}
th:last-child, td:last-child {
    border-top-right-radius: 0.75rem;
}
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\learning\resources\views/vendor/filament-panels/resources/pages/list-records.blade.php ENDPATH**/ ?>