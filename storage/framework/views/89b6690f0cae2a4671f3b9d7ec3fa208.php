<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'pets' => [],
    'name' => 'pet',
    'id' => null,
    'label' => 'Patient',
    'selected' => null,
    'required' => false,
    'columnClass' => 'col-12 col-lg-6',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'pets' => [],
    'name' => 'pet',
    'id' => null,
    'label' => 'Patient',
    'selected' => null,
    'required' => false,
    'columnClass' => 'col-12 col-lg-6',
]); ?>
<?php foreach (array_filter(([
    'pets' => [],
    'name' => 'pet',
    'id' => null,
    'label' => 'Patient',
    'selected' => null,
    'required' => false,
    'columnClass' => 'col-12 col-lg-6',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $controlId = $id ?? $name;
    $inputName = $name;
    $currentValue = $selected ?? old($inputName);
?>

<div class="<?php echo e($columnClass); ?>">
    <label for="<?php echo e($controlId); ?>" class="form-label fw-semibold">
        <?php echo e($label); ?>

        <?php if($required): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <select
        style="width: 100%"
        id="<?php echo e($controlId); ?>"
        name="<?php echo e($inputName); ?>"
        <?php echo e($attributes->merge([
            'class' => 'select2 form-select'.($errors->has($inputName) ? ' is-invalid' : ''),
        ])); ?>

    >
        <option value=""></option>
        <?php $__currentLoopData = $pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id); ?>" <?php if($currentValue == $item->id): echo 'selected'; endif; ?>>
                <?php echo e($item->patient_id); ?> - <?php echo e($item->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php $__errorArgs = [$inputName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="invalid-feedback">
            <strong><?php echo e($message); ?></strong>
        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/components/forms/pet-selector.blade.php ENDPATH**/ ?>