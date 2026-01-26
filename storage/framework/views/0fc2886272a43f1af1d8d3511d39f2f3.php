<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.list-page','data' => ['title' => 'Deleted Users','backRoute' => url()->previous()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('list-page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Deleted Users','back-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(url()->previous())]); ?>
        <?php echo $dataTable->table(['class' => 'table table-hover align-middle w-100']); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd)): ?>
<?php $attributes = $__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd; ?>
<?php unset($__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd)): ?>
<?php $component = $__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd; ?>
<?php unset($__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_stylesheets'); ?>
    <link href="<?php echo e(asset('plugin/datatable/jquery.dataTables.min.css')); ?>" rel="stylesheet">
    <style> body {
      text-transform: none !important; /* or any other value you want */
  }
  </style> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
    
    <script src="<?php echo e(asset('plugin/datatable/jquery.dataTables.min.js')); ?>"></script>
    <?php echo $dataTable->scripts(); ?>

    <script>
       $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})
    </script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/settings/user/suspend.blade.php ENDPATH**/ ?>