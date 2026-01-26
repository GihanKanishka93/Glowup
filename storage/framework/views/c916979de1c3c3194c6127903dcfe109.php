<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.list-page','data' => ['title' => 'Bill Management','backRoute' => url()->previous()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('list-page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Bill Management','back-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(url()->previous())]); ?>
         <?php $__env->slot('actions', null, []); ?> 
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bill-create')): ?>
                <a href="<?php echo e(route('billing.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>New Bill
                </a>
            <?php endif; ?>
         <?php $__env->endSlot(); ?>

        <?php echo $dataTable->table(['class' => 'table table-hover align-middle w-100']); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd)): ?>
<?php $attributes = $__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd; ?>
<?php unset($__attributesOriginal7bc554465605ca2958f2d0eb6e9a7ddd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd)): ?>
<?php $component = $__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd; ?>
<?php unset($__componentOriginal7bc554465605ca2958f2d0eb6e9a7ddd); ?>
<?php endif; ?>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="treatmentModal" tabindex="-1" role="dialog" aria-labelledby="treatmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="treatmentModalLabel">Treatment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="treatmentBody">
                    <p><strong>Patient Name:</strong> <span id="treatmentPatientName"></span></p>
                    <p><strong>Doctor Name:</strong> <span id="treatmentDoctorName"></span></p>
                    <p><strong>Patient ID:</strong> <span id="treatmentPatientId"></span></p>
                    <p><strong>History/Complaint:</strong> <span id="treatmentHistoryComplaint"></span></p>
                    <p><strong>Clinical Observation:</strong> <span id="treatmentClinicalObservation"></span></p>
                    <p><strong>Remarks:</strong> <span id="treatmentRemarks"></span></p>
                    <div id="treatmentHistory"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Discharge Modal -->







<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_stylesheets'); ?>
<link href="<?php echo e(asset('plugin/datatable/jquery.dataTables.min.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">


<?php $__env->stopSection(); ?>

<?php $__env->startSection('third_party_scripts'); ?>


<script src="<?php echo e(asset('plugin/datatable/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
<?php echo $dataTable->scripts(); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // In your JavaScript file or inline script
    // Initialize the datetime picker
    flatpickr(".datetimepicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: new Date(),
        maxDate: new Date(),


    });
    $(document).on('click', '.delete-btn', function () {
        var itemId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = '#del' + itemId;
                $(id).submit();
            }
        });
    });



</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/billing/index.blade.php ENDPATH**/ ?>