<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('app.name')); ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, viewport-fit=cover" name="viewport">

    
    <?php
        $customCssVersion = file_exists(public_path('css/custom.css')) ? filemtime(public_path('css/custom.css')) : time();
    ?>
    <link href="<?php echo e(asset('plugin/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>?v=<?php echo e($customCssVersion); ?>" rel="stylesheet">
    
   
    <?php echo $__env->yieldPushContent('third_party_stylesheets'); ?>
    <?php echo $__env->yieldPushContent('page_css'); ?>

</head>
<?php echo $__env->yieldContent('content'); ?>

<!-- Bootstrap core JavaScript -->
<script src="<?php echo e(asset('jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- Core plugin JavaScript-->
<script src="<?php echo e(asset('jquery-easing/jquery.easing.min.js')); ?>"></script>
<!-- Custom scripts for all pages-->
<script src="<?php echo e(asset('js/sb-admin-2.min.js')); ?>"></script>


<?php echo $__env->yieldPushContent('third_party_scripts'); ?>
<?php echo $__env->yieldPushContent('page_scripts'); ?>

</html>
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/layouts/public.blade.php ENDPATH**/ ?>