@extends('layouts.app')

@section('content')
    <x-list-page title="Bill Management" :back-route="url()->previous()">
        <x-slot:actions>
            @can('bill-create')
                <a href="{{ route('billing.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>New Bill
                </a>
            @endcan
        </x-slot:actions>

        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
    </x-list-page>

<!-- Bootstrap Modal -->
<div class="modal fade" id="treatmentModal" tabindex="-1" role="dialog" aria-labelledby="treatmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="treatmentModalLabel">Treatment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="treatmentBody">
                <p><strong>Client Name:</strong> <span id="treatmentPetName"></span></p>
                <p><strong>Doctor Name:</strong> <span id="treatmentDoctorName"></span></p>
                <p><strong>Client ID:</strong> <span id="treatmentPetId"></span></p>
                <p><strong>Skin Type:</strong> <span id="treatmentPetType"></span></p>
                <p><strong>Skin Concern:</strong> <span id="treatmentPetBreed"></span></p>
                <p><strong>History/Complaint:</strong> <span id="treatmentHistoryComplaint"></span></p>
                <p><strong>Clinical Observation:</strong> <span id="treatmentClinicalObservation"></span></p>
                <p><strong>Remarks:</strong> <span id="treatmentRemarks"></span></p>
                <div id="treatmentHistory"></div>
            </div>
        </div>
    </div>
</div>

    <!-- Discharge Modal -->







@endsection

@section('third_party_stylesheets')
    <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('plugin/datatables/dataTables.bootstrap4.min.css') }}"> --}}

@stop

@section('third_party_scripts')

    {{-- <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
    {!! $dataTable->scripts() !!}
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
                var id =  '#del'+itemId;
                $(id).submit();
            }
        });
    });



</script>
@stop
