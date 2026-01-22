@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Current Admissions</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">Forms</h6> --}}

                    <div class="dropdown no-arrow show">
                        <a href="{{ URL::previous() }}" class="btn btn-md btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                    @can('admission-create')
                    <a href="{{ route('admission.create') }}" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus"></i>
                        </span>
                        <span class="text">New</span>
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="userInfoModalLabel">Log Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="userInfoBody">
                    <p><strong>User Name:</strong> <span id="userName"></span></p>
                    <p><strong>Name:</strong> <span id="userFullName"></span></p>
                    {{-- <p><strong>User ID:</strong> <span id="userId"></span></p> --}}
                    <p><strong>Email:</strong> <span id="userEmail"></span></p>
                    <p><strong>Log Date Time:</strong> <span id="userLogDateTime"></span></p>
                    <p><strong>Log Type:</strong> <span id="userLogEvent"></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Discharge Modal -->
    <div class="modal fade" id="dischargeModal" tabindex="-1" role="dialog" aria-labelledby="dischargeModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="h3 modal-title" id="dischargeModalLabel">Discharge Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="dischargeForm" action="{{ route('admission.checkout') }}" method="post">
                    @csrf
                    @method('PUT') <!-- Ensure the method is PUT -->
                    <div class="modal-body">
                        <input type="hidden" name="admission_id" id="admissionIdInput">
                        <div class="form-group">
                            <label for="dischargeRemarks">Enter Discharge Note <i class="text-danger">*</i></label>
                            <textarea  maxlength="255" class="form-control" id="dischargeRemarks" name="remarks"></textarea>
                            <span id="remarks_error" class="invalid-feedback discharge_field_error" role="alert"></span>
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="dischargeDateTime">Discharge Date and Time <i class="text-danger">*</i></label>
                            <input type="text" class="form-control datetimepicker" id="dischargeDateTime" name="dischargeDateTime">
                            <span id="dischargeDateTime_error" class="invalid-feedback discharge_date_field_error" role="alert"></span>

                        </div>
                        <hr>
                        <legend class="h5 dislabel">Room Items</legend>
                        <div class="form-group" id="room_inventory">

                        </div>

                        <div class="form-group">
                            <label for="remarks">Remarks <i class="text-danger">*</i></label>
                            <textarea  maxlength="255" class="form-control" id="inventory_remarks" name="inventory_remarks"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save & Discharge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






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
    $(document).on('click', '.user-popup', function () {

        let userData = $(this).data('user-info');
        let admissionLogDateTime = $(this).data('updated-at');
        $('#userName').text(userData.user_name);
        $('#userFullName').text(userData.first_name+" "+ userData.last_name);
        $('#userId').text(userData.id);
        $('#userEmail').text( userData.email.toLowerCase());

        $('#userLogDateTime').text(admissionLogDateTime);
        $('#userLogEvent').text(userData.log_type);
        $('#userInfoModal').modal('show');

    });

    // Add this script in your view or a separate JavaScript file

    $(document).ready(function () {
        $("#dischargeForm").submit(function (e) {
            e.preventDefault(); // Prevent the default form submission
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: $(this).serialize(),
                success: function (response) {
                    $("#dischargeModal").modal("hide");
                    location.reload();
                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $("#" + key).addClass("is-invalid");
                        $("#" + key + "_error").addClass('d-block')
                        $("#" + key + "_error").html("<div class='text-danger d-block'>" + value[0] + "</div>");
                    });
                    $("#dischargeModal").modal("show");
                },
            });
        });
    });

    $(document).on('click', '.discharge-btn', function () {
        var admissionId = $(this).data('id');
        $.ajax({
         url: "{{ route('ajax.admission-item') }}",
         method: "GET", // or "POST" for a POST request
         data: {
             "admission": admissionId,
         },
         success: function(response) {
            console.log(response);
            $('#room_inventory').html('');
            $.each(response[0], function(index, item) {
                $('#room_inventory').append('<label class="col-md-4"><input type="checkbox" class="form-check-input" checked name="room_inventory[]" value="' + item['id'] + '">' + item['name'] + '</label>');
            });
         },
         error: function(xhr, status, error) {
            console.log(error);
         }
         });

        $('#admissionIdInput').val(admissionId);
        $('#dischargeModal').modal('show');
    });
    $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})


</script>
@stop
