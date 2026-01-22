@extends('layouts.app')
@section('content')
    <x-list-page title="Past Admissions" :back-route="url()->previous()">
        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100']) !!}
    </x-list-page>
     <!-- Bootstrap Modal -->
     <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
    <div class="modal fade" id="dischargeInfoModal" tabindex="-1" role="dialog" aria-labelledby="dischargeInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dischargeInfoModalLabel"><strong>Discharge Information</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6><strong>Discharge Note:</strong></h6>
                    <p id="dischargeNote"></p>
                    <h6><strong>Discharge Remarks:</strong></h6>
                    <p id="dischargeRemark"></p>
                    <h6><strong>Discharged On:</strong></h6>
                    <p id="dischargedOn"></p>
                    <h6><strong>Discharged By:</strong></h6>
                    <p id="dischargedBy"></p>
                    <h6><strong>Logged Time:</strong></h6>
                    <p id="loggedTime"></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('third_party_stylesheets')
    <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('plugin/datatables/dataTables.bootstrap4.min.css') }}"> --}}
@stop

@section('third_party_scripts')

    {{-- <script src="{{ asset('plugin/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <script>
   // In your JavaScript file or inline script
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

$(document).on('click', '.discharge-btn', function () {
    var admissionId = $(this).data('id');
    // Send an AJAX request to fetch discharge information
    $.ajax({
        url: '/admission/checkout/' + admissionId,
        type: 'GET',
        success: function(response) {
            // Format the date and time
            var dischargedOn = formatDate(response.date_of_check_out);
            var loggedTime = formatDate(response.updated_at);

            // Populate the modal with the fetched discharge information
            $('#dischargeNote').text(response.remarks);

            $('#dischargeRemark').text(response.inventory_remarks);

            $('#dischargedOn').text(dischargedOn);
            $('#dischargedBy').text(response.updated_by.user_name);
            $('#loggedTime').text(loggedTime);
            $('#dischargeInfoModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
});

// Function to format date and time in the desired format
function formatDate(dateTimeString) {
    var dateTime = new Date(dateTimeString);
    var year = dateTime.getFullYear();
    var month = pad(dateTime.getMonth() + 1);
    var day = pad(dateTime.getDate());
    var hours = pad(dateTime.getHours());
    var minutes = pad(dateTime.getMinutes());
    var seconds = pad(dateTime.getSeconds());

    return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
}

// Function to pad single digit numbers with leading zeros
function pad(number) {
    return (number < 10 ? '0' : '') + number;
}


$(document).on('click', '.undo-discharge-btn', function () {
    var admissionId = $(this).data('id');
    //alert(admissionId)

 Swal.fire({
        title: 'Are you sure you want to undo this discharge?',
        text: 'This action will erase the current discharge information. Please proceed with caution.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Undo it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admission/undocheckout/' + admissionId;
        }
    });
});

$('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
})

    </script>

@if(session('fail-message'))
<script>
    Swal.fire({
        title: 'Operation Cannot be Completed!',
        text: '{{ session('message') }}',
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
@endif
@stop
