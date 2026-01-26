<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'title',
    'subtitle' => null,
    'backRoute' => null,
    'backLabel' => 'Back',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'title',
    'subtitle' => null,
    'backRoute' => null,
    'backLabel' => 'Back',
]); ?>
<?php foreach (array_filter(([
    'title',
    'subtitle' => null,
    'backRoute' => null,
    'backLabel' => 'Back',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'list-page'])); ?>>
    <div class="list-toolbar">
        <div class="list-toolbar-heading">
            <h1 class="page-title"><?php echo e($title); ?></h1>
            <?php if($subtitle): ?>
                <p class="page-subtitle"><?php echo e($subtitle); ?></p>
            <?php endif; ?>
        </div>
        <div class="list-toolbar-actions">
            <?php if($backRoute): ?>
                <a href="<?php echo e($backRoute); ?>" class="btn btn-outline-primary btn-sm list-back-btn">
                    <i class="fas fa-arrow-left me-1"></i><?php echo e($backLabel); ?>

                </a>
            <?php endif; ?>
            <?php echo e($actions ?? ''); ?>

        </div>
    </div>

    <div class="card list-card shadow-sm border-0">
        <div class="card-body">
            <?php echo e($slot); ?>

        </div>
    </div>
</div>
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/components/list-page.blade.php ENDPATH**/ ?>