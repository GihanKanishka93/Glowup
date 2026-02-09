<?php $__env->startSection('content'); ?>

    <h1 class="h3 mb-2 text-gray-800">
    </h1>

    <div class="pet-profile">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="<?php echo e(route('patient.index')); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-secondary">Registered
                                <?php echo e(optional($patient->created_at)->format('d M Y') ?? '—'); ?></span>
                            <span class="badge bg-info text-dark">Last Update
                                <?php echo e(optional($patient->updated_at)->diffForHumans() ?? '—'); ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">Client Snapshot</h5>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row mb-0 small">
                                            <dt class="col-5 text-muted">Client ID</dt>
                                            <dd class="col-7 fw-semibold"><?php echo e($patient->patient_id); ?></dd>

                                            <dt class="col-5 text-muted">Name</dt>
                                            <dd class="col-7 fw-semibold text-capitalize"><?php echo e($patient->name); ?></dd>

                                            <dt class="col-5 text-muted">Gender</dt>
                                            <dd class="col-7 text-capitalize">
                                                <?php echo e($patient->gender == 1 ? 'Male' : 'Female'); ?></dd>

                                            <dt class="col-5 text-muted">Date of Birth</dt>
                                            <dd class="col-7">
                                                <?php echo e(optional($patient->date_of_birth)->format('d M Y') ?? '—'); ?></dd>

                                            <dt class="col-5 text-muted">Age at Register</dt>
                                            <dd class="col-7"><?php echo e($patient->age_at_register ?? '—'); ?></dd>

                                            <!--
                                        <dt class="col-5 text-muted">Current Age</dt>
                                        <dd class="col-7"><?php echo e($patient->current_age ?? '—'); ?></dd>
                                        -->

                                            <dt class="col-5 text-muted">Remarks</dt>
                                            <dd class="col-7"><?php echo e($patient->remarks ?: 'None recorded'); ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">Contact Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row mb-0 small">
                                            <dt class="col-5 text-muted">Mobile</dt>
                                            <dd class="col-7"><?php echo e($patient->mobile_number ?? '—'); ?></dd>

                                            <dt class="col-5 text-muted">WhatsApp</dt>
                                            <dd class="col-7"><?php echo e($patient->whatsapp_number ?? '—'); ?></dd>

                                            <dt class="col-5 text-muted">Email</dt>
                                            <dd class="col-7"><?php echo e($patient->email ?? '—'); ?></dd>

                                            <dt class="col-5 text-muted">National ID</dt>
                                            <dd class="col-7"><?php echo e($patient->nic ?? '—'); ?></dd>

                                            <dt class="col-5 text-muted">Address</dt>
                                            <dd class="col-7"><?php echo e($patient->address ?? '—'); ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div
                                        class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Quick Facts</h5>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patient-edit')): ?>
                                            <a href="<?php echo e(route('patient.edit', $patient->id)); ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body small">
                                        <ul class="list-unstyled mb-3">
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Treatments to date</span>
                                                <strong><?php echo e($treatments->count()); ?></strong>
                                            </li>
                                            <?php
                                                $lastVisit = $treatments->first();
                                                $lastVisitDate = $lastVisit && $lastVisit->treatment_date
                                                    ? \Carbon\Carbon::parse($lastVisit->treatment_date)->format('d M Y')
                                                    : '—';
                                                $nextVaccinationLabel = $nextVaccination ? ($nextVaccination->next_vacc_date
                                                    ? \Carbon\Carbon::parse($nextVaccination->next_vacc_date)->format('d M Y')
                                                    : null) : null;
                                            ?>
                                            <li class="d-flex justify-content-between mb-2">
                                                <span class="text-muted">Last Visit</span>
                                                <strong><?php echo e($lastVisitDate); ?></strong>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span class="text-muted">Outstanding Bills</span>
                                                <strong><?php echo e($outstandingBills); ?></strong>
                                            </li>
                                        </ul>
                                        <div class="alert alert-info py-2 px-3 mb-0">
                                            <small class="mb-0 d-block"><strong>Next Follow-up</strong></small>
                                            <small class="text-muted">
                                                <?php if($nextFollowUp): ?>
                                                    <?php echo e($nextFollowUp->next_clinic_date); ?>

                                                <?php else: ?>
                                                    No follow-up session scheduled
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 mt-1">
                            <div class="col-12">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h5 class="mb-0">Treatment Images</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <p class="text-muted small mb-2">Before Treatment</p>
                                                <?php if($patient->before_treatment_image): ?>
                                                    <img src="<?php echo e(asset($patient->before_treatment_image)); ?>"
                                                        alt="Before treatment" class="img-fluid rounded border">
                                                <?php else: ?>
                                                    <p class="text-muted mb-0">No image uploaded.</p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="text-muted small mb-2">After Treatment</p>
                                                <?php if($patient->after_treatment_image): ?>
                                                    <img src="<?php echo e(asset($patient->after_treatment_image)); ?>"
                                                        alt="After treatment" class="img-fluid rounded border">
                                                <?php else: ?>
                                                    <p class="text-muted mb-0">No image uploaded.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patient-edit')): ?>
                                            <hr>
                                            <form method="post" action="<?php echo e(route('patient.treatment-images', $patient->id)); ?>"
                                                enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Update Before Image</label>
                                                        <input type="file"
                                                            class="form-control <?php $__errorArgs = ['before_treatment_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="before_treatment_image" accept="image/*">
                                                        <?php $__errorArgs = ['before_treatment_image'];
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
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Add/Update After Image</label>
                                                        <input type="file"
                                                            class="form-control <?php $__errorArgs = ['after_treatment_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            name="after_treatment_image" accept="image/*">
                                                        <?php $__errorArgs = ['after_treatment_image'];
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
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-upload me-1"></i>Update Images
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Treatment History</h5>
                        <a href="<?php echo e(route('billing.index', ['search' => $patient->patient_id])); ?>"
                            class="btn btn-sm btn-outline-secondary">View Related Bills</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Doctor</th>
                                        <th scope="col">Complaint</th>
                                        <th scope="col">Observations</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $treatments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($treatment->treatment_date ? \Carbon\Carbon::parse($treatment->treatment_date)->format('d M Y') : '—'); ?>

                                            </td>
                                            <td><?php echo e(optional($treatment->doctor)->name ?? '—'); ?></td>
                                            <td><?php echo e($treatment->history_complaint ?: '—'); ?></td>
                                            <td><?php echo e($treatment->clinical_observation ?: '—'); ?></td>
                                            <td><?php echo e($treatment->remarks ?: '—'); ?></td>
                                            <td class="text-end">
                                                <a href="<?php echo e(route('billing.show', $treatment->bill->id ?? 0)); ?>"
                                                    class="btn btn-outline-primary btn-sm" <?php if(!optional($treatment->bill)->id): ?>
                                                    disabled <?php endif; ?>>
                                                    <i class="fas fa-receipt me-1"></i>Bill
                                                </a>
                                                <?php if($treatment->id): ?>
                                                    <a href="<?php echo e(route('medical-history.show', ['id' => $patient->id])); ?>"
                                                        target="_blank" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-notes-medical"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No treatments recorded yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .pet-profile {
            color: var(--text-primary);
        }

        .pet-profile .card,
        .pet-profile .card-body,
        .pet-profile .card-header {
            background-color: var(--surface) !important;
            color: var(--text-primary);
        }

        .pet-profile .card {
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            border-radius: 1rem;
        }

        .pet-profile .card-header {
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
        }

        .pet-profile .card-body {
            padding: 1.25rem 1.5rem;
        }

        .pet-profile .badge {
            background-color: rgba(29, 78, 216, 0.12);
            color: var(--primary);
        }

        .pet-profile .badge.bg-info {
            background-color: rgba(14, 165, 233, 0.16) !important;
            color: var(--info-contrast) !important;
        }

        .pet-profile .badge.bg-secondary {
            background-color: rgba(148, 163, 184, 0.18) !important;
            color: var(--text-primary) !important;
        }

        .pet-profile dl dt {
            font-weight: 600;
            color: var(--text-muted);
        }

        .pet-profile dl dd {
            color: var(--text-primary);
        }

        .pet-profile .table {
            margin: 0;
            color: var(--text-primary);
        }

        .pet-profile .table thead th {
            background-color: var(--surface-alt);
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }

        .pet-profile .table tbody tr {
            background-color: var(--surface);
        }

        .pet-profile .table tbody tr:nth-child(odd) {
            background-color: rgba(148, 163, 184, 0.12);
        }

        .pet-profile .table tbody td {
            border-color: var(--border);
        }

        .pet-profile .btn-outline-primary {
            color: var(--primary);
            border-color: var(--border);
        }

        .pet-profile .btn-outline-primary:hover,
        .pet-profile .btn-outline-primary:focus {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--primary-contrast);
        }

        .pet-profile .btn-outline-secondary {
            color: var(--text-muted);
            border-color: var(--border);
        }

        .pet-profile .btn-outline-secondary:hover,
        .pet-profile .btn-outline-secondary:focus {
            background-color: rgba(148, 163, 184, 0.16);
            border-color: rgba(148, 163, 184, 0.45);
            color: var(--text-primary);
        }

        .pet-profile .alert-info {
            background-color: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.35);
            color: var(--text-primary);
        }

        .pet-profile .list-unstyled strong {
            color: var(--text-primary);
        }

        .pet-profile .text-muted {
            color: var(--text-muted) !important;
        }

        .pet-profile .card.shadow-sm {
            box-shadow: var(--shadow-sm) !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/patient/show.blade.php ENDPATH**/ ?>