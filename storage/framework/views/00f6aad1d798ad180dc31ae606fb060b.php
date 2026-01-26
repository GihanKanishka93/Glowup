<?php $__env->startSection('content'); ?>
    <style>
        .pulsing-alert {
            border: 2px solid #dc3545;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.4);
            animation: alert-pulse 2s infinite;
            border-radius: 12px;
            background-color: #fff5f5;
        }

        @keyframes alert-pulse {
            0% {
                border-color: #dc3545;
                box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
            }

            50% {
                border-color: #ffc107;
                box-shadow: 0 0 25px rgba(255, 193, 7, 0.6);
            }

            100% {
                border-color: #dc3545;
                box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
            }
        }
    </style>
    <div class="billing-dashboard container-fluid">
        <div class="row g-4 align-items-start billing-grid">
            <div class="col-12 col-xl-4 col-xxl-3 insight-column d-flex flex-column gap-4">
                <?php echo $__env->make('billing.partials.metrics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('billing.partials.stock-alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('billing.partials.recent-bills', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-12 col-xl-8 col-xxl-9 workspace-column">
                <div class="card shadow-sm billing-workspace">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                            <div>
                                <h1 class="h4 mb-0 text-dark">In-Clinic Billing Workspace</h1>
                            </div>
                            <div class="bill-history" style="display: none;">
                                <a href="#" target="_blank" class="btn btn-primary btn-icon-split medical-history-btn"
                                    data-template="<?php echo e(route('medical-history.show', ['id' => 'PLACEHOLDER'])); ?>">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-notes-medical"></i>
                                    </span>
                                    <span class="text">Medical History</span>
                                </a>
                            </div>
                        </div>

                        <form action="<?php echo e(route('billing.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                            <div class="row g-4">
                                <div class="col-12 col-xxl-8">
                                    <div class="billing-flow mb-4">
                                        <nav class="billing-section-nav" aria-label="Billing sections">
                                            <a class="billing-nav-link is-current" href="#billing-section-patient">
                                                <span class="billing-nav-icon"><i class="fas fa-user"></i></span>
                                                Patient
                                            </a>
                                            <a class="billing-nav-link" href="#billing-section-clinical">
                                                <span class="billing-nav-icon"><i class="fas fa-stethoscope"></i></span>
                                                Clinical Notes
                                            </a>
                                            <a class="billing-nav-link" href="#billing-section-medication">
                                                <span class="billing-nav-icon"><i class="fas fa-pills"></i></span>
                                                Medication & Services
                                            </a>
                                            <a class="billing-nav-link" href="#billing-section-billing">
                                                <span class="billing-nav-icon"><i
                                                        class="fas fa-file-invoice-dollar"></i></span>
                                                Billing Summary
                                            </a>
                                        </nav>
                                        <div class="billing-sections">
                                            <div id="safety-alert-banner" class="alert pulsing-alert mb-4"
                                                style="display: none;">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="alert-icon-wrapper text-danger">
                                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="alert-heading mb-1 text-danger fw-bold">CRITICAL CLINICAL
                                                            ALERT</h5>
                                                        <div id="safety-alert-content" class="mb-0 text-dark fw-bold"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="billing-section-patient" class="billing-section">
                                                <h6 class="panel-title">Patient Snapshot</h6>
                                                <div class="panel-body">
                                                    <div class="row g-3 patient-snapshot-grid">
                                                        <?php if (isset($component)) { $__componentOriginalae36a5873a6ae18bdc4ca77a6253b91e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalae36a5873a6ae18bdc4ca77a6253b91e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.pet-selector','data' => ['pets' => $patients ?? [],'columnClass' => 'col-12 col-lg-6','id' => 'patient','name' => 'patient','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.pet-selector'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pets' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patients ?? []),'column-class' => 'col-12 col-lg-6','id' => 'patient','name' => 'patient','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalae36a5873a6ae18bdc4ca77a6253b91e)): ?>
<?php $attributes = $__attributesOriginalae36a5873a6ae18bdc4ca77a6253b91e; ?>
<?php unset($__attributesOriginalae36a5873a6ae18bdc4ca77a6253b91e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalae36a5873a6ae18bdc4ca77a6253b91e)): ?>
<?php $component = $__componentOriginalae36a5873a6ae18bdc4ca77a6253b91e; ?>
<?php unset($__componentOriginalae36a5873a6ae18bdc4ca77a6253b91e); ?>
<?php endif; ?>
                                                        <div class="col-12 col-lg-6">
                                                            <label for="doctor" class="form-label fw-semibold">
                                                                Doctor <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="doctor" id="doctor"
                                                                class="select2 form-select <?php $__errorArgs = ['doctor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                <option value=""></option>
                                                                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($item->id); ?>" <?php if(old('doctor', $authenticatedDoctorId) == $item->id): echo 'selected'; endif; ?>>
                                                                        <?php echo e($item->name); ?>

                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                            <?php $__errorArgs = ['doctor'];
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
                                                        <div class="col-12 col-md-6 col-xl-3">
                                                            <label for="patient_id" class="form-label fw-semibold">Patient
                                                                ID</label>
                                                            <input type="text"
                                                                class="form-control <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="patient_id" name="patient_id"
                                                                value="<?php echo e(old('patient_id')); ?>" readonly>
                                                            <?php $__errorArgs = ['patient_id'];
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
                                                        <div class="col-12 col-md-6 col-xl-3">
                                                            <label for="patient_name" class="form-label fw-semibold">
                                                                Patient Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control <?php $__errorArgs = ['patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="patient_name" name="patient_name"
                                                                value="<?php echo e(old('patient_name')); ?>">
                                                            <?php $__errorArgs = ['patient_name'];
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
                                                        <div class="col-12 col-md-6 col-xl-3">
                                                            <label for="date_of_birth" class="form-label fw-semibold">Date
                                                                of Birth</label>
                                                            <input type="date"
                                                                class="form-control <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="date_of_birth" name="date_of_birth"
                                                                value="<?php echo e(old('date_of_birth')); ?>"
                                                                max="<?php echo e(date('Y-m-d')); ?>">
                                                            <?php $__errorArgs = ['date_of_birth'];
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
                                                        <div class="col-12 col-md-6 col-xl-3">
                                                            <label for="age" class="form-label fw-semibold">Age</label>
                                                            <input type="text"
                                                                class="form-control <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="age" name="age" value="<?php echo e(old('age')); ?>">
                                                            <?php $__errorArgs = ['age'];
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
                                                        <div class="col-12 col-md-4">
                                                            <label for="nic" class="form-label fw-semibold">NIC</label>
                                                            <input type="text"
                                                                class="form-control <?php $__errorArgs = ['nic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="nic" name="nic" value="<?php echo e(old('nic')); ?>">
                                                            <?php $__errorArgs = ['nic'];
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
                                                        <div class="col-12 col-md-4">
                                                            <label for="occupation"
                                                                class="form-label fw-semibold">Occupation</label>
                                                            <input type="text"
                                                                class="form-control <?php $__errorArgs = ['occupation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="occupation" name="occupation"
                                                                value="<?php echo e(old('occupation')); ?>">
                                                            <?php $__errorArgs = ['occupation'];
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
                                                        <div class="col-12 col-md-4">
                                                            <label for="medical_history"
                                                                class="form-label fw-semibold">Medical History</label>
                                                            <textarea class="form-control" id="medical_history"
                                                                name="medical_history"
                                                                rows="1"><?php echo e(old('medical_history')); ?></textarea>
                                                        </div>
                                                        <div class="col-12 col-md-4">
                                                            <label for="surgical_history"
                                                                class="form-label fw-semibold">Surgical History</label>
                                                            <textarea class="form-control" id="surgical_history"
                                                                name="surgical_history"
                                                                rows="1"><?php echo e(old('surgical_history')); ?></textarea>
                                                        </div>
                                                        <div class="col-12 col-md-4">
                                                            <label for="allegics"
                                                                class="form-label fw-semibold">Allergies</label>
                                                            <textarea class="form-control" id="allegics" name="allegics"
                                                                rows="1"><?php echo e(old('allegics')); ?></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="remarks" class="form-label fw-semibold">General
                                                                Remarks</label>
                                                            <textarea
                                                                class="form-control <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="remarks" name="remarks"
                                                                rows="1"><?php echo e(old('remarks')); ?></textarea>
                                                            <?php $__errorArgs = ['remarks'];
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
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="address" class="form-label fw-semibold">Address</label>
                                                        <textarea
                                                            class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="address" name="address"
                                                            rows="2"><?php echo e(old('address')); ?></textarea>
                                                        <?php $__errorArgs = ['address'];
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
                                                </div>

                                                <div class="panel-divider"></div>
                                                <h6 class="panel-subtitle mt-3">Contact Information</h6>
                                                <div class="row g-3 patient-snapshot-grid">
                                                    <?php if (isset($component)) { $__componentOriginal62b7cd7a92b47c148b807955c67f2770 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62b7cd7a92b47c148b807955c67f2770 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.owner-contact','data' => ['id' => 'contact','name' => 'contact','value' => old('contact'),'columnClass' => 'col-12 col-lg-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.owner-contact'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'contact','name' => 'contact','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('contact')),'column-class' => 'col-12 col-lg-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62b7cd7a92b47c148b807955c67f2770)): ?>
<?php $attributes = $__attributesOriginal62b7cd7a92b47c148b807955c67f2770; ?>
<?php unset($__attributesOriginal62b7cd7a92b47c148b807955c67f2770); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62b7cd7a92b47c148b807955c67f2770)): ?>
<?php $component = $__componentOriginal62b7cd7a92b47c148b807955c67f2770; ?>
<?php unset($__componentOriginal62b7cd7a92b47c148b807955c67f2770); ?>
<?php endif; ?>
                                                    <?php if (isset($component)) { $__componentOriginal62b7cd7a92b47c148b807955c67f2770 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62b7cd7a92b47c148b807955c67f2770 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.owner-contact','data' => ['id' => 'whatsapp','name' => 'whatsapp','label' => 'WhatsApp Number','value' => old('whatsapp', '+94 '),'placeholder' => '+94 7X XXX XXXX','columnClass' => 'col-12 col-lg-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.owner-contact'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'whatsapp','name' => 'whatsapp','label' => 'WhatsApp Number','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('whatsapp', '+94 ')),'placeholder' => '+94 7X XXX XXXX','column-class' => 'col-12 col-lg-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62b7cd7a92b47c148b807955c67f2770)): ?>
<?php $attributes = $__attributesOriginal62b7cd7a92b47c148b807955c67f2770; ?>
<?php unset($__attributesOriginal62b7cd7a92b47c148b807955c67f2770); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62b7cd7a92b47c148b807955c67f2770)): ?>
<?php $component = $__componentOriginal62b7cd7a92b47c148b807955c67f2770; ?>
<?php unset($__componentOriginal62b7cd7a92b47c148b807955c67f2770); ?>
<?php endif; ?>
                                                    <div class="col-12 col-lg-6">
                                                        <label for="email" class="form-label fw-semibold">Email</label>
                                                        <input type="email"
                                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="email" name="email" value="<?php echo e(old('email')); ?>"
                                                            placeholder="patient@example.com">
                                                        <?php $__errorArgs = ['email'];
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
                                                </div>
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button type="button"
                                                        class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
                                                        id="savePatientDetailsBtn">
                                                        <i class="fas fa-save"></i>
                                                        <span>Save patient details</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="billing-section-clinical" class="billing-section">
                                            <h6 class="panel-title">Clinical Notes</h6>
                                            <div class="panel-body">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="history" class="form-label fw-semibold">History /
                                                            Complaint</label>
                                                        <textarea
                                                            class="form-control <?php $__errorArgs = ['history'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="history" name="history"
                                                            rows="3"><?php echo e(old('history')); ?></textarea>
                                                        <?php $__errorArgs = ['history'];
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
                                                    <div class="col-12">
                                                        <label for="observation" class="form-label fw-semibold">Clinical
                                                            Observation</label>
                                                        <textarea
                                                            class="form-control <?php $__errorArgs = ['observation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="observation" name="observation"
                                                            rows="3"><?php echo e(old('observation')); ?></textarea>
                                                        <?php $__errorArgs = ['observation'];
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
                                                    <div class="col-12">
                                                        <label for="remarks_t" class="form-label fw-semibold">Treatment
                                                            Remarks</label>
                                                        <textarea
                                                            class="form-control <?php $__errorArgs = ['remarks_t'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="remarks_t" name="remarks_t"
                                                            rows="3"><?php echo e(old('remarks_t')); ?></textarea>
                                                        <?php $__errorArgs = ['remarks_t'];
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
                                                </div>
                                            </div>
                                        </div>
                                        <div id="billing-section-medication" class="billing-section">
                                            <h6 class="panel-title">Prescription</h6>
                                            <div class="panel-body">
                                                <h6 class="panel-subtitle">Prescription</h6>
                                                <div id="prescription" class="row g-3">
                                                    <div class="col-12">
                                                        <div class="row g-3 px-2 d-none d-md-flex">
                                                            <div class="col-md-4">
                                                                <label
                                                                    class="form-label fw-semibold text-uppercase small">Drug
                                                                    Name</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label
                                                                    class="form-label fw-semibold text-uppercase small">Dosage</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label
                                                                    class="form-label fw-semibold text-uppercase small">Dose</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label
                                                                    class="form-label fw-semibold text-uppercase small">Duration</label>
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                        </div>
                                                    </div>
                                                    <div class="prescription-details col-12 base-prescription-row">
                                                        <div class="row g-2 align-items-center prescription-row">
                                                            <div class="col-md-4">
                                                                <label class="form-label d-md-none small fw-bold">Drug
                                                                    Name</label>
                                                                <select name="drug_name[]"
                                                                    class="select2 form-select drug_items <?php $__errorArgs = ['drug_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    style="width: 100%">
                                                                    <option value=""></option>
                                                                    <?php $__currentLoopData = $drugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->name); ?>"
                                                                            <?php if(old('drug_name') == $item->name): echo 'selected'; endif; ?>>
                                                                            <?php echo e($item->name); ?> <?php if($item->unit): ?>
                                                                                [<?php echo e((float) $item->stock_quantity); ?>

                                                                            <?php echo e($item->unit); ?>] <?php endif; ?>
                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label
                                                                    class="form-label d-md-none small fw-bold">Dosage</label>
                                                                <select name="dosage[]"
                                                                    class="select2 form-select dosage_types <?php $__errorArgs = ['dosage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    style="width: 100%">
                                                                    <option value=""></option>
                                                                    <?php $__currentLoopData = $dosagetypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->name); ?>"
                                                                            <?php if(old('dosage') == $item->name): echo 'selected'; endif; ?>>
                                                                            <?php echo e($item->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label
                                                                    class="form-label d-md-none small fw-bold">Dose</label>
                                                                <select name="dose[]"
                                                                    class="select2 form-select duration_types <?php $__errorArgs = ['dose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    style="width: 100%">
                                                                    <option value=""></option>
                                                                    <?php $__currentLoopData = $dose; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->name); ?>"
                                                                            <?php if(old('dose') == $item->name): echo 'selected'; endif; ?>>
                                                                            <?php echo e($item->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label
                                                                    class="form-label d-md-none small fw-bold">Duration</label>
                                                                <select name="duration[]"
                                                                    class="select2 form-select duration_types <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    style="width: 100%">
                                                                    <option value=""></option>
                                                                    <?php $__currentLoopData = $durationtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->name); ?>"
                                                                            <?php if(old('duration') == $item->name): echo 'selected'; endif; ?>>
                                                                            <?php echo e($item->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div
                                                                class="col-md-1 d-flex justify-content-md-center gap-2 flex-nowrap prescription-actions">
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm btn-icon-split"
                                                                    id="addPrescription">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-plus"></i>
                                                                    </span>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-icon-split ms-2 remove-prescription-row"
                                                                    title="Remove prescription row">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-trash"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Vaccination section removed -->
                                                <div class="row g-3 align-items-end mt-3">
                                                    <div class="col-12 col-lg-4">
                                                        <label for="next_treatment_date" class="form-label fw-semibold">Next
                                                            Treatment Date</label>
                                                        <input type="text"
                                                            class="form-control datetimepicker <?php $__errorArgs = ['next_treatment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="next_treatment_date" name="next_treatment_date" step="60"
                                                            value="<?php echo e(old('next_treatment_date')); ?>"
                                                            placeholder="Select date">
                                                        <?php $__errorArgs = ['next_treatment_date'];
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
                                                    <div class="col-12 col-lg-4">
                                                        <label class="form-label fw-semibold d-block">Recommended
                                                            Interval</label>
                                                        <div id="duration-weeks" class="radio-button-group">
                                                            <?php $__currentLoopData = $durationweeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <label class="radio-button">
                                                                    <input type="radio" name="next_treatment_weeks"
                                                                        value="<?php echo e($item->name); ?>"
                                                                        <?php if(old('next_treatment_weeks') == $item->name): echo 'checked'; endif; ?>>
                                                                    <span><?php echo e($item->name); ?></span>
                                                                </label>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <label for="billing_date" class="form-label fw-semibold">Billing
                                                            Date</label>
                                                        <input type="text"
                                                            class="form-control datetimepicker <?php $__errorArgs = ['billing_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="billing_date" name="billing_date" step="60"
                                                            value="<?php echo e(Date('Y-m-d')); ?>">
                                                        <?php $__errorArgs = ['billing_date'];
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
                                                </div>
                                            </div>
                                        </div>
                                        <div id="billing-section-billing" class="billing-section">
                                            <h6 class="panel-title">Billing & Checkout</h6>
                                            <div class="panel-body">
                                                <h6 class="panel-subtitle">Billable Services</h6>
                                                <div class="row g-3 px-2">
                                                    <div class="col-md-4">
                                                        <span class="form-label fw-semibold text-uppercase small">Service
                                                            Name</span>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <span class="form-label fw-semibold text-uppercase small">Qty</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="form-label fw-semibold text-uppercase small">Unit
                                                            Price</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span class="form-label fw-semibold text-uppercase small">Discount
                                                            (%)</span>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <span
                                                            class="form-label fw-semibold text-uppercase small">Total</span>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div id="serviceDetails" class="row g-3">
                                                    <div class="service-detail col-12 base-service-row">
                                                        <div class="row g-3 align-items-center service-row">
                                                            <div class="col-md-4">
                                                                <select name="service_name[]" id="service_name"
                                                                    class="select2 form-select service_item <?php $__errorArgs = ['service_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                                    <option value=""></option>
                                                                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->id); ?>"
                                                                            <?php if(old('service_name') == $item->id): echo 'selected'; endif; ?>>
                                                                            <?php echo e($item->name); ?> <?php if($item->unit): ?>
                                                                                [<?php echo e((float) $item->stock_quantity); ?>

                                                                            <?php echo e($item->unit); ?>] <?php endif; ?>
                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <input type="text" class="form-control" name="billing_qty[]"
                                                                    placeholder="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" name="unit_price[]"
                                                                    placeholder="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" name="tax[]"
                                                                    placeholder="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control" name="last_price[]"
                                                                    placeholder="">
                                                            </div>
                                                            <div
                                                                class="col-md-1 d-flex justify-content-md-center gap-2 flex-nowrap service-actions">
                                                                <button type="button"
                                                                    class="btn btn-success btn-sm btn-icon-split"
                                                                    id="addService">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-plus"></i>
                                                                    </span>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-icon-split ms-2 remove-service-row"
                                                                    title="Remove service row">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fas fa-trash"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['parents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger mt-3" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <?php $__errorArgs = ['name.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger mt-3" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                                <hr class="my-4" />

                                                <div class="row g-3 justify-content-end">
                                                    <div
                                                        class="col-12 col-lg-8 d-flex justify-content-end flex-wrap gap-3 custom-buttons-container">
                                                        <a href="<?php echo e(route('billing.index')); ?>"
                                                            class="btn btn-outline-secondary mb-2">
                                                            <span class="text">Cancel</span>
                                                        </a>
                                                        <div class="d-flex gap-2 flex-wrap mb-2">
                                                            <button type="submit" name="action" value="save"
                                                                class="btn btn-primary btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-save"></i>
                                                                </span>
                                                                <span class="text">Save</span>
                                                            </button>
                                                            <button type="submit" name="action" value="save_and_print"
                                                                class="btn btn-primary btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-print"></i>
                                                                </span>
                                                                <span class="text">Save & Print</span>
                                                            </button>
                                                        </div>
                                                        <div class="w-100"></div>
                                                        <div class="d-flex justify-content-end w-100">
                                                            <button type="submit" name="action" value="save_and_email"
                                                                class="btn btn-warning btn-icon-split"
                                                                style="background-color:#f59e0b;border-color:#f59e0b;color:#0b1a39;">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-envelope"></i>
                                                                </span>
                                                                <span class="text">Save & Email</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xxl-4">
                                    <div class="card shadow-sm sticky-card">
                                        <div class="card-header border-0 pb-0">
                                            <h6 class="mb-0 text-uppercase text-muted small">Billing Summary</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="net_total">Net Total</label>
                                                <input type="text" class="form-control" name="net_total" id="net_total">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="discount">Discount</label>
                                                <input type="number" class="form-control" name="discount" id="discount"
                                                    value="0">
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label" for="grand_total">Grand Total</label>
                                                <input type="text" class="form-control" name="grand_total" id="grand_total">
                                            </div>
                                            <div class="bg-light rounded-3 p-3 small text-muted summary-hints">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Next Visit</span>
                                                    <span id="summaryNextTreatment">—</span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <span>Billing Date</span>
                                                    <span id="summaryBillingDate"><?php echo e(Date('Y-m-d')); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_stylesheets'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugin/select2/select2.min.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

<script src="<?php echo e(asset('plugin/select2/select2.min.js')); ?>"></script>
<script>
    $('.select2').select2();
    $(document).ready(function () {
        $('#patient').select2({
            closeOnSelect: false,
            tags: false // Ensure tags is set to false
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const billingForm = document.querySelector('.billing-workspace form');
        const savePrintButton = billingForm ? billingForm.querySelector('button[type="submit"][name="action"][value="save_and_print"]') : null;

        if (billingForm && savePrintButton) {
            savePrintButton.addEventListener('click', function () {
                billingForm.setAttribute('target', '_blank');
                billingForm.dataset.printSubmit = 'true';
            });

            billingForm.addEventListener('submit', function () {
                if (billingForm.dataset.printSubmit === 'true') {
                    setTimeout(function () {
                        billingForm.removeAttribute('target');
                        delete billingForm.dataset.printSubmit;
                    }, 500);
                }
            });
        }

        const sectionLinks = document.querySelectorAll('.billing-section-nav .billing-nav-link');
        const sections = document.querySelectorAll('.billing-section');

        sectionLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                const targetId = this.getAttribute('href');
                const target = targetId ? document.querySelector(targetId) : null;
                if (target) {
                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    const id = entry.target.getAttribute('id');
                    if (!id) {
                        return;
                    }
                    const relatedLink = document.querySelector('.billing-section-nav .billing-nav-link[href="#' + id + '"]');
                    if (!relatedLink) {
                        return;
                    }
                    if (entry.isIntersecting) {
                        sectionLinks.forEach(function (link) { link.classList.remove('is-current'); });
                        relatedLink.classList.add('is-current');
                    }
                });
            }, {
                rootMargin: '-40% 0px -50% 0px',
                threshold: [0.25, 0.6]
            });

            sections.forEach(function (section) {
                observer.observe(section);
            });
        } else if (sectionLinks.length) {
            sectionLinks.forEach(function (link) { link.classList.remove('is-current'); });
            sectionLinks[0].classList.add('is-current');
        }

        const summaryNextTreatment = document.getElementById('summaryNextTreatment');

        const summaryBillingDate = document.getElementById('summaryBillingDate');

        function updateSummaryCard() {
            const nextTreatment = document.getElementById('next_treatment_date');

            const billingDate = document.getElementById('billing_date');

            if (summaryNextTreatment && nextTreatment) {
                summaryNextTreatment.textContent = nextTreatment.value || '—';
            }

            if (summaryBillingDate && billingDate) {
                summaryBillingDate.textContent = billingDate.value || '—';
            }
        }

        window.updateBillingSummaryCard = updateSummaryCard;

        ['next_treatment_date', 'billing_date'].forEach(function (id) {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('change', updateSummaryCard);
                element.addEventListener('input', updateSummaryCard);
            }
        });



        document.addEventListener('keydown', function (event) {
            if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
                event.preventDefault();
                const saveButton = document.querySelector('button[type="submit"][name="action"][value="save"]');
                if (saveButton) {
                    saveButton.click();
                }
            }
        });

        updateSummaryCard();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

    // $(document).ready(function() {
    //         $('#pet_category').change(function() {
    //             var selectedText = $(this).find("option:selected").text();
    //             $('#pet_category_text').val(selectedText);
    //         });
    //     });

    function getPatientDetails() {
        var patient = $('#patient').val();
        var medicalHistoryBtn = document.querySelector('.medical-history-btn');
        var billHistoryDiv = document.querySelector('.bill-history');

        if (patient != '') {
            $.ajax({
                url: "<?php echo e(route('ajax.getPetDetails')); ?>",
                method: "GET", // or "POST" for a POST request
                data: {
                    "patient": patient,
                },
                success: function (response) {
                    //alert(response.id);
                    document.getElementById('patient_id').value = response.patient_id;
                    document.getElementById('patient_name').value = response.name;
                    document.getElementById('age').value = response.age; // Ajax returns calculated string, or use age_at_register if preferred? Ajax returns age string.
                    document.getElementById('date_of_birth').value = response.date_of_birth;
                    //document.getElementById('gender').value = response.gender;
                    $('#gender').val(response.gender).trigger('change');
                    document.getElementById('medical_history').value = response.basic_ilness || '';
                    document.getElementById('surgical_history').value = response.surgical_history || '';
                    document.getElementById('allegics').value = response.allegics || '';
                    document.getElementById('remarks').value = response.remarks;

                    // Safety Alert Logic
                    const safetyBanner = document.getElementById('safety-alert-banner');
                    const safetyContent = document.getElementById('safety-alert-content');
                    let risks = [];
                    if (response.allegics && response.allegics.trim() !== '' && response.allegics.toLowerCase() !== 'none') {
                        risks.push('<i class="fas fa-hand-holding-medical me-2"></i> ALLERGY: ' + response.allegics);
                    }
                    if (response.basic_ilness && response.basic_ilness.trim() !== '' && response.basic_ilness.toLowerCase() !== 'none') {
                        risks.push('<i class="fas fa-file-medical me-2"></i> MEDICAL HISTORY: ' + response.basic_ilness);
                    }

                    if (risks.length > 0) {
                        safetyContent.innerHTML = risks.join('<br>');
                        $(safetyBanner).fadeIn();
                        // Trigger a loud notification if toastr is available
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Safety Alert: Patient has critical clinical history!', 'Attention Required', { timeOut: 10000 });
                        }
                    } else {
                        $(safetyBanner).hide();
                    }

                    document.getElementById('nic').value = response.nic;
                    document.getElementById('occupation').value = response.occupation;

                    document.getElementById('contact').value = response.mobile_number;
                    document.getElementById('email').value = response.email;
                    const whatsappEl = document.getElementById('whatsapp');
                    if (whatsappEl) {
                        whatsappEl.value = response.whatsapp_number ? response.whatsapp_number : '+94 ';
                    }
                    document.getElementById('address').value = response.address;

                    if (response.id) {
                        var templateUrl = medicalHistoryBtn.getAttribute('data-template');
                        var url = templateUrl.replace('PLACEHOLDER', response.id);
                        medicalHistoryBtn.href = url;
                        billHistoryDiv.style.display = 'block';
                    } else {
                        billHistoryDiv.style.display = 'none';
                    }

                    if (window.updateBillingSummaryCard) {
                        window.updateBillingSummaryCard();
                    }

                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }
    }

    function setSelectedValue(selectObj, valueToSet) {
        for (var i = 0; i < selectObj.options.length; i++) {
            if (selectObj.options[i].text == valueToSet) {
                selectObj.options[i].selected = true;
                return;
            }
        }
    }

    $('#patient').change(function () {
        getPatientDetails();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const savePatientDetailsBtn = document.getElementById('savePatientDetailsBtn');
        const patientSelect = document.getElementById('patient');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (savePatientDetailsBtn) {
            savePatientDetailsBtn.addEventListener('click', function () {
                if (!patientSelect || !patientSelect.value) {
                    toastr.warning('Select a patient before saving details.');
                    return;
                }

                const payload = {
                    patient: patientSelect.value,
                    patient_id: document.getElementById('patient_id')?.value,
                    patient_name: document.getElementById('patient_name')?.value,
                    gender: document.getElementById('gender')?.value,
                    age: document.getElementById('age')?.value,
                    date_of_birth: document.getElementById('date_of_birth')?.value,
                    occupation: document.getElementById('occupation')?.value,
                    nic: document.getElementById('nic')?.value,
                    remarks: document.getElementById('remarks')?.value,
                    contact: document.getElementById('contact')?.value,
                    whatsapp: document.getElementById('whatsapp')?.value,
                    email: document.getElementById('email')?.value,
                    address: document.getElementById('address')?.value,
                };

                savePatientDetailsBtn.disabled = true;

                fetch("<?php echo e(route('billing.save-client-details')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                })
                    .then(async (response) => {
                        const data = await response.json().catch(() => ({}));
                        if (!response.ok) {
                            const message = data.message || 'Unable to save patient details.';
                            const validation = data.errors
                                ? Object.values(data.errors).flat().join(' ')
                                : '';
                            throw new Error(validation ? `${message} ${validation}` : message);
                        }

                        toastr.success(data.message || 'Patient details saved.');
                    })
                    .catch((error) => {
                        toastr.error(error.message || 'Unable to save patient details.');
                    })
                    .finally(() => {
                        savePatientDetailsBtn.disabled = false;
                    });
            });
        }
    });

</script>

<script>

    //////////////////////////start prescription//////////////////////////////////
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Select2 for the initial select element
        initializeSelect2('.select2');

        document.getElementById('addPrescription').addEventListener('click', function () {
            let original = document.querySelector('.prescription-details');
            let clone = original.cloneNode(true);
            clone.classList.remove('base-prescription-row');

            // Clear input values in the cloned node
            let clonedInputs = clone.querySelectorAll('input');
            clonedInputs.forEach(function (input) {
                input.value = '';
            });

            // Clear previous values and re-initialize Select2
            let clonedSelects = clone.querySelectorAll('select');
            clonedSelects.forEach(function (select) {
                $(select).val(null).trigger('change'); // Clear previous values
                $(select).next('.select2-container').remove(); // Remove the previous Select2 container
                initializeSelect2(select); // Re-initialize Select2
            });

            // Replace plus button with remove button
            let buttonContainer = clone.querySelector('.prescription-actions');
            if (buttonContainer) {
                buttonContainer.innerHTML = '';

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-prescription-row';
                removeButton.innerHTML = '<span class="icon text-white-50"><i class="fas fa-trash"></i></span>';
                buttonContainer.appendChild(removeButton);
            }

            document.getElementById('prescription').appendChild(clone);
        });

        document.addEventListener('click', function (event) {
            const removeBtn = event.target.closest('.remove-prescription-row');
            if (removeBtn) {
                const row = removeBtn.closest('.prescription-details');
                if (row?.classList.contains('base-prescription-row')) {
                    row.querySelectorAll('input').forEach(input => input.value = '');
                    $(row).find('select').val(null).trigger('change');
                } else {
                    row?.remove();
                }
            }
        });
    });

    $(document).ready(function () {
        // Initialize Select2 for existing select element on page load
        initializeSelect2('.select2');
    });


    //////////////////////////end prescription//////////////////////////////////


    ////////////////////////Start Billing Script ////////////////////
    document.addEventListener('DOMContentLoaded', function () {
        function updateTotal(row) {
            var qty = parseFloat(row.find('input[name="billing_qty[]"]').val()) || 0;
            var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
            var discountPercentage = parseFloat(row.find('input[name="tax[]"]').val()) || 0;

            var discountAmount = (qty * unitPrice) * (discountPercentage / 100);
            var total = (qty * unitPrice) - discountAmount;

            row.find('input[name="last_price[]"]').val(total.toFixed(2));
        }



        function updateGrandTotal() {
            var netTotal = 0;
            $('input[name="last_price[]"]').each(function () {
                netTotal += parseFloat($(this).val()) || 0;
            });

            // netTotal += getVaccinationTotal();

            var discount = parseFloat($('#discount').val()) || 0;
            var grandTotal = netTotal - discount;

            $('#net_total').val(netTotal.toFixed(2));
            $('#grand_total').val(grandTotal.toFixed(2));
        }

        window.recalculateBillingTotals = updateGrandTotal;

        function attachServiceChangeHandler($select) {
            $select.off('change.service').on('change.service', function () {
                var selectedServiceId = $(this).val();
                var parentRow = $(this).closest('.service-row');

                if (selectedServiceId) {
                    $.ajax({
                        url: '/get-service-price/' + selectedServiceId,
                        method: 'GET',
                        success: function (response) {
                            if (response.hasOwnProperty('price')) {
                                parentRow.find('input[name="unit_price[]"]').val(response.price);
                                parentRow.find('input[name="billing_qty[]"]').val(1);
                                parentRow.find('input[name="tax[]"]').val(0);
                                updateTotal(parentRow);
                                updateGrandTotal();
                            }
                        },
                        error: function (error) {
                            console.error('Error fetching service price:', error);
                        }
                    });
                } else {
                    parentRow.find('input[name="unit_price[]"]').val('');
                    parentRow.find('input[name="billing_qty[]"]').val('');
                    parentRow.find('input[name="tax[]"]').val('');
                    updateTotal(parentRow);
                    updateGrandTotal();
                }
            });
        }

        function initializeServiceSelects(context) {
            var $context = context ? $(context) : $(document);
            var $serviceSelects = $context.find('select[name="service_name[]"]');

            $serviceSelects.each(function () {
                var $select = $(this);
                $select.next('.select2-container').remove();
                initializeSelect2($select);
                attachServiceChangeHandler($select);
            });
        }

        initializeServiceSelects(document);



        document.getElementById('addService').addEventListener('click', function () {
            let original = document.querySelector('.service-detail');
            let clone = original.cloneNode(true);
            clone.classList.remove('base-service-row');

            let clonedInputs = clone.querySelectorAll('input');
            clonedInputs.forEach(function (input) {
                input.value = '';
            });

            initializeServiceSelects(clone);

            let buttonContainer = clone.querySelector('.service-actions');
            if (buttonContainer) {
                buttonContainer.innerHTML = '';

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-service-row';
                removeButton.innerHTML = '<span class="icon text-white-50"><i class="fas fa-trash"></i></span>';
                buttonContainer.appendChild(removeButton);
            }

            document.getElementById('serviceDetails').appendChild(clone);
        });

        document.addEventListener('input', function (event) {
            if (event.target.matches('input[name="billing_qty[]"], input[name="tax[]"], input[name="unit_price[]"]')) {
                var row = event.target.closest('.service-row');
                updateTotal($(row));
                updateGrandTotal();
            }
        });

        $('#discount').on('input', updateGrandTotal);

        document.addEventListener('click', function (event) {
            const serviceBtn = event.target.closest('.remove-service-row');
            if (serviceBtn) {
                const row = serviceBtn.closest('.service-detail');
                if (row) {
                    if (row.classList.contains('base-service-row')) {
                        row.querySelectorAll('input').forEach(input => input.value = '');
                        $(row).find('select').val(null).trigger('change');
                    } else {
                        row.remove();
                    }
                    updateGrandTotal();
                }
            }
        });

        updateGrandTotal();
    });

    $(document).ready(function () {
        // Initialize Select2 for existing select element on page load
        initializeSelect2('.select2');
    });


    ///////////////////////end Services script //////////////////////////





    $(document).ready(function () {
        // Event listener for radio buttons
        $('input[name="next_treatment_weeks"]').on('change', function () {
            var selectedValue = $(this).val();
            var currentDate = new Date(); // Get current date

            // Check the selected value and add weeks accordingly
            if (selectedValue.endsWith('W')) {
                var weeksToAdd = parseInt(selectedValue); // Extract the number of weeks
                currentDate.setDate(currentDate.getDate() + (weeksToAdd * 7)); // Add weeks to the current date
            } else if (selectedValue.endsWith('Y')) {
                var yearsToAdd = parseInt(selectedValue); // Extract the number of years
                currentDate.setFullYear(currentDate.getFullYear() + yearsToAdd); // Add years to the current date
            }

            // Format the new date in YYYY-MM-DD
            var newDate = currentDate.toISOString().split('T')[0];

            // Set the new date in the datetimepicker input field
            $('#next_treatment_date').val(newDate).trigger('change');
        });

        // Event listener for each group of radio buttons related to next vaccination weeks
        // Use event delegation to handle dynamically added radio buttons






    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/billing/create.blade.php ENDPATH**/ ?>