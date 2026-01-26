<div class="card shadow-sm billing-card">
    <div class="card-header border-0 pb-0 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 text-uppercase text-muted small">Upcoming Follow-ups</h6>
        <span class="badge bg-warning-subtle text-warning">Next 7 days</span>
    </div>
    <div class="list-group list-group-flush">
        <?php $__empty_1 = true; $__currentLoopData = $upcomingVaccinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vaccination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $dueDate = $vaccination->next_vacc_date
                    ? \Illuminate\Support\Carbon::parse($vaccination->next_vacc_date)
                    : null;
                $pet = optional(optional($vaccination->treatment)->pet);
                $petName = $pet->name ?? 'Unknown Client';
            ?>
            <?php if($pet?->id): ?>
                <a class="list-group-item list-group-item-action" href="<?php echo e(route('pet.show', $pet->id)); ?>">
                    <div class="fw-semibold"><?php echo e($petName); ?></div>
                    <div class="text-muted small">
                        <?php echo e($vaccination->vaccine->name ?? 'Treatment plan'); ?>

                        <?php if($dueDate): ?>
                            · due <?php echo e($dueDate->format('d M')); ?>

                        <?php endif; ?>
                    </div>
                </a>
            <?php else: ?>
                <div class="list-group-item">
                    <div class="fw-semibold"><?php echo e($petName); ?></div>
                    <div class="text-muted small">
                        <?php echo e($vaccination->vaccine->name ?? 'Treatment plan'); ?>

                        <?php if($dueDate): ?>
                            · due <?php echo e($dueDate->format('d M')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="list-group-item text-muted small">No follow-ups scheduled over the next 7 days.</div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/billing/partials/upcoming-vaccinations.blade.php ENDPATH**/ ?>