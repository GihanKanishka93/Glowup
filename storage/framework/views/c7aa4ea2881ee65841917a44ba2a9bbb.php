<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php $__env->startSection('content'); ?>
<h1 class="h3 mb-2 text-gray-800">Edit User Role</h1>

<div class="row">
  <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
          <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
              <div class="dropdown no-arrow show">

              </div>
          </div>
          <form action="<?php echo e(route('role.update',$role->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
              <div class="card-body">
                  <div class="form-group row">
                      <label class="col-sm-2" for="name">Role Name <i class="text-danger">*</i> </label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control   <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              id="name" name="name" value="<?php echo e($role->name); ?>" placeholder="Name">
                          <?php $__errorArgs = ['name'];
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


                  <div class="form-group  row">
                      <label class="col-sm-2   " for="name">Permissions
                          <i class="text-danger">*</i></label>

                      <div class="col-sm-10">
                          <div class="row " style="margin-left: 3px">
                          <input type="text" class=" d-none <?php $__errorArgs = ['permission'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>   ">
                            <?php $__errorArgs = ['permission'];
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
                              <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <div class="col-md-4 " >

                                        <label class="label label-defalt">
                                          <input  class="form-check-input" type="checkbox" name="permission[]" <?php if(in_array($value->id, $rolePermissions)): ?> <?php if(true): echo 'checked'; endif; ?>  <?php endif; ?> id="" value="<?php echo e($value->name); ?>">
                                        <?php echo e($value->name); ?></label>
                                  </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                    <a href="<?php echo e(route('role.index')); ?>" class="btn btn-info">
                        <span class="text">Cancel</span>
                    </a>
                    <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                        <span class="icon text-white-50">
                            <i class="fa fa-save"></i>
                        </span>
                        <span class="text">Save</span>
                    </button>
                </div>
            </div>
          </form>

      </div>
  </div>
</div>













    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/settings/role/edit.blade.php ENDPATH**/ ?>