<?php $__env->startSection('content'); ?>

    <body class="bg-gradient-login login-body">
        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-lg-12">
                    <div class="login-shell shadow-lg">
                        <div class="row no-gutters align-items-stretch">
                            <div class="col-lg-5 d-none d-lg-flex login-visual">
                                <div class="login-visual-overlay">
                                    <img src="<?php echo e(asset('img/Glowup_Logo-modified.png')); ?>" alt="Glowup Skin Clinic"
                                        class="login-logo mb-4">
                                    <h2 class="login-visual-title">Glowup Skin Clinic</h2>
                                    <p class="login-visual-subtitle">Password Recovery Workspace</p>
                                    <ul class="login-highlights list-unstyled mt-4 mb-0">
                                        <li><i class="fas fa-shield-alt mr-2"></i>Secure automated reset link</li>
                                        <li><i class="fas fa-key mr-2"></i>Choose a strong new password</li>
                                        <li><i class="fas fa-user-check mr-2"></i>Instant access after recovery</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5 login-form">
                                    <div class="mb-4">
                                        <p class="eyebrow text-primary mb-1">Reset requested</p>
                                        <h1 class="login-title mb-2">Forgot Password?</h1>
                                        <p class="login-copy mb-0">Enter your user name and we'll send you a recovery link.
                                        </p>
                                    </div>

                                    <?php if(session('status')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?php echo e(session('status')); ?>

                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="user" action="<?php echo e(route('password.email')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="loginUserName">User name</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                                </div>
                                                <input type="text" name="user_name" value="<?php echo e(old('user_name')); ?>"
                                                    class="form-control login-control <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="loginUserName" placeholder="Your username" required>
                                                <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block login-submit">
                                            Send reset link
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <a class="small font-weight-bold" href="<?php echo e(route('login')); ?>">
                                            <i class="fas fa-arrow-left mr-1"></i> Back to sign in
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>