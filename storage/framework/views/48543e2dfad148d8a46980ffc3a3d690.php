<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'name' => 'owner_contact',
    'id' => null,
    'label' => 'Contact Number',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'columnClass' => 'col-12 col-lg-6',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'name' => 'owner_contact',
    'id' => null,
    'label' => 'Contact Number',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'columnClass' => 'col-12 col-lg-6',
]); ?>
<?php foreach (array_filter(([
    'name' => 'owner_contact',
    'id' => null,
    'label' => 'Contact Number',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
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
    $inputName = $name;
    $controlId = $id ?? $name;
    $currentValue = old($inputName, $value);
?>

<div class="<?php echo e($columnClass); ?>">
    <label for="<?php echo e($controlId); ?>" class="form-label fw-semibold">
        <?php echo e($label); ?>

        <?php if($required): ?>
            <span class="text-danger">*</span>
        <?php endif; ?>
    </label>
    <input
        type="<?php echo e($type); ?>"
        id="<?php echo e($controlId); ?>"
        name="<?php echo e($inputName); ?>"
        value="<?php echo e($currentValue); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        <?php echo e($attributes->merge([
            'class' => 'form-control'.($errors->has($inputName) ? ' is-invalid' : ''),
        ])); ?>

    >
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
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/components/forms/owner-contact.blade.php ENDPATH**/ ?>