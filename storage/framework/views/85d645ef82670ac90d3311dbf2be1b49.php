<div class="card shadow-sm billing-card">
    <div class="card-header border-0 pb-0">
        <h6 class="mb-0 text-uppercase text-muted small">Recently Printed Bills</h6>
    </div>
    <div class="list-group list-group-flush">
        <?php $__empty_1 = true; $__currentLoopData = $recentBills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $billDate = $bill->billing_date ? \Illuminate\Support\Carbon::parse($bill->billing_date) : null;
            ?>
            <a href="<?php echo e(route('billing.show', $bill->id)); ?>"
                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold"><?php echo e($bill->treatment->patient->name ?? 'Unknown Client'); ?></div>
                    <div class="text-muted small">Bill #<?php echo e($bill->billing_id); ?> <?php if($billDate): ?> ·
                    <?php echo e($billDate->format('d M')); ?> <?php endif; ?></div>
                </div>
                <span class="fw-semibold">Rs <?php echo e(number_format($bill->total ?? 0, 2)); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="list-group-item text-muted small">No recent bills yet.</div>
        <?php endif; ?>
    </div>
</div><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/billing/partials/recent-bills.blade.php ENDPATH**/ ?>