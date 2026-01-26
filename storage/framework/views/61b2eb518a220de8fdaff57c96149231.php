<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-2 text-gray-800">
        <?php echo e($user->user_name); ?> </h1>

    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8"><?php echo e($user->designation); ?> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8"><?php echo e($user->email); ?></dd>

                        <dt class="col-sm-4">Contact number</dt>
                        <dd class="col-sm-8"><?php echo e($user->contact_number); ?></dd>

                        <dt class="col-sm-4">User name</dt>
                        <dd class="col-sm-8"><?php echo e($user->user_name); ?></dd>

                        <dt class="col-sm-4">Roles</dt>
                        <dd class="col-sm-8">
                            <?php if(!empty($user->getRoleNames())): ?>
                                <?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="badge badge-success"><?php echo e($v); ?></label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </dd>

                    </dl>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    <div class="dropdown no-arrow show">
                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>
                <form action="<?php echo e(route('change.password')); ?>" method="POST"> <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4">Current Password <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control   <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="current_password"
                                name="current_password" value="" placeholder="Current Password">
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">New Password : <i class="text-danger">*</i></label>
                                  <div class="col-sm-8">
                                      <input type="password" class="form-control   <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id=""
                                          name="new_password" value="<?php echo e(old('new_password')); ?>"  placeholder="New Password">
                                      <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                          <span class="invalid-feedback" role="alert">
                                              <strong><?php echo e($message); ?></strong>
                                          </span>
                                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                  </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Comfirm Password : <i class="text-danger">*</i></label>
                                  <div class="col-sm-8">
                                      <input type="password" class="form-control   <?php $__errorArgs = ['new_confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  
                                          name="new_confirm_password"  value="<?php echo e(old('new_confirm_password')); ?>" placeholder="Comfirm">
                                      <?php $__errorArgs = ['new_confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                          <span class="invalid-feedback" role="alert">
                                              <strong><?php echo e($message); ?></strong>
                                          </span>
                                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                  </div>
                    </div>


                </div>
                <div class="card-footer text-right">
                    <button type="submit" value="save" class="btn btn-sm btn-primary btn-icon-split">
                               <span class="icon text-white-50">
                                   <i class="fa fa-save"></i>
                               </span>
                               <span class="text">Save</span>
                           </button>
               </div>
           </form>
            </div>
        </div>

    </div>
 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/settings/user/profile.blade.php ENDPATH**/ ?>