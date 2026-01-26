<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('app.name')); ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    
    <link href="<?php echo e(asset('plugin/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css" >
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css" >
    <link rel="stylesheet"href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css"  >
    <link  rel="stylesheet"  href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet"  href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet">

    
    <link rel="stylesheet" href="<?php echo e(asset('plugin/toastr/toastr.css')); ?>">
    <style>
        body {
          text-transform: capitalize; /* This will capitalize the first letter of each word */
        }
        .loading {
	z-index: 20;
	position: absolute;
	top: 0;
	left:-5px;
	width: 100%;
	height: 100%;
    background-color: rgba(0,0,0,0.4);
}
.loading-content {
	position: absolute;
	border: 16px solid #f3f3f3; /* Light grey */
	border-top: 16px solid #3498db; /* Blue */
	border-radius: 50%;
	width: 50px;
	height: 50px;
	top: 40%;
	left:35%;
	animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
      </style>

    <?php echo $__env->yieldContent('third_party_stylesheets'); ?>

    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">

</head>

<body id="page-top">
    <section id="loading">
        <div id="loading-content"></div>
      </section>

    <div id="wrapper">

        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php echo $__env->make('layouts.top_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>

            </div>
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo e(asset('jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo e(asset('jquery-easing/jquery.easing.min.js')); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo e(asset('js/sb-admin-2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugin/toastr/toastr.min.js')); ?>"></script>

    <?php echo $__env->yieldContent('third_party_scripts'); ?>
    <script>

function showLoading() {
  document.querySelector('#loading').classList.add('loading');
  document.querySelector('#loading-content').classList.add('loading-content');
}

function hideLoading() {
  document.querySelector('#loading').classList.remove('loading');
  document.querySelector('#loading-content').classList.remove('loading-content');
}


        $(document).ready(function () {
            // Remove validation error when any input field gains focus
            $(".form-control").focus(function () {
                $(this).removeClass('is-invalid'); // Remove the 'is-invalid' class
                $(this).next('.invalid-feedback').html(''); // Clear the error message
            });
        });
    </script>
    <?php if(session()->has('info')): ?>
        <script>
            $(document).ready(function() {
                toastr.info('<?php echo e(session()->get('info')); ?>')
            });
        </script>
    <?php endif; ?>
    <?php if(session()->has('danger')): ?>
        <script>
            $(document).ready(function() {
                toastr.error('<?php echo e(session()->get('danger')); ?>')
            });
        </script>
    <?php endif; ?>
    <?php if(session()->has('message')): ?>
        <script>
            $(document).ready(function() {
                toastr.success('<?php echo e(session()->get('message')); ?>')
            });
        </script>
    <?php endif; ?>
    <?php if(session()->has('success')): ?>
        <script>
            $(document).ready(function() {
                toastr.success('<?php echo e(session()->get('success')); ?>')
            });
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.medical-history-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    window.open(url, 'MedicalHistory', 'width=800,height=600,scrollbars=yes,resizable=yes');
                });
            });
        });
    </script>
</body>

</html>
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/layouts/popup.blade.php ENDPATH**/ ?>