<div class="card shadow-sm billing-card" id="billing-treatment-images" data-base-url="<?php echo e(rtrim(asset(''), '/')); ?>">
    <div class="card-header border-0 pb-0">
        <h6 class="mb-0 text-uppercase text-muted small">Treatment Images</h6>
    </div>
    <div class="card-body pt-3">
        <div class="row g-3">
            <div class="col-6">
                <div class="text-muted small mb-1">Before</div>
                <div class="ratio ratio-4x3 bg-light rounded border d-flex align-items-center justify-content-center overflow-hidden">
                    <img id="billingBeforeImage" class="img-fluid d-none billing-image-preview" alt="Before treatment"
                        style="object-fit: cover; width: 100%; height: 100%;">
                    <div id="billingBeforePlaceholder" class="text-muted small">No image</div>
                </div>
            </div>
            <div class="col-6">
                <div class="text-muted small mb-1">After</div>
                <div class="ratio ratio-4x3 bg-light rounded border d-flex align-items-center justify-content-center overflow-hidden">
                    <img id="billingAfterImage" class="img-fluid d-none billing-image-preview" alt="After treatment"
                        style="object-fit: cover; width: 100%; height: 100%;">
                    <div id="billingAfterPlaceholder" class="text-muted small">No image</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="billingImageModal" class="billing-image-modal" aria-hidden="true">
    <div class="billing-image-modal__backdrop" data-modal-close></div>
    <div class="billing-image-modal__dialog" role="dialog" aria-modal="true">
        <button type="button" class="billing-image-modal__close" aria-label="Close" data-modal-close>×</button>
        <img id="billingImageModalImg" class="billing-image-modal__image" alt="Treatment image preview">
    </div>
</div>
<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/billing/partials/patient-treatment-images.blade.php ENDPATH**/ ?>