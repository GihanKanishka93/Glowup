@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">
        Admissions
    </h1>

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
                    
                </div>

                <div class="card-body">
                    <form id="dateRangeForm" action="{{ route('report.served-periodes-data') }}" method="get"  >
                        @csrf
                        @method('GET')
                        <div class=" row mb-3">
                        <label for="start_date" class="col-md-2">Start Date:</label>
                        <div class="col-md-2">
                            @php $date = date('Y-m-d');
                            @endphp
                            <input type="text" id="start_date" name="start_date" value="{{ old('start_date', $date) }}"
                                class="datepicker form-control">
                        </div>
                        <label for="end_date" class="col-md-2">End Date:</label>
                        <div class="col-md-2">
                            <input type="text" id="end_date" name="end_date" value="{{ old('end_date', $date) }}"
                                class="datepicker form-control">
                        </div>
                        <label for="end_date" class="col-md-2">Patient:</label>
                        <div class="col-md-2">
                            <select name="patient_id" class="form-control" id="patient_id">
                                <option value=""></option>
                                @foreach ($patients as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="mb-3 row">
                        <label for="room_id" class="col-md-2">Room:</label>
                        <div class="col-md-2">
                            <select name="room_id" id="room_id" class="form-control">
                                <option value=""></option>
                                @foreach ($room as $item)
                                    <option value="{{ $item->id }}">{{ $item->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="district_id" class="col-md-2">District:</label>
                        <div class="col-md-2">
                            <select name="district_id" id="district_id" class="form-control">
                                <option value=""></option>
                                @foreach ($district as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 text-right">
                            <button type="submit" id="filterBtn" class="btn w-100 btn-primary">Filter</button>
                        </div>
                        </div>
                    </form>

                    {{-- <table id="myTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th> No</th>
                                <th> Name</th>
                                <th> Room</th>
                                <th> District</th>
                                <th> Check In</th>
                                <th> Check Out</th>
                            </tr>
                        </thead>
                    </table> --}}


                </div>
            </div>
        </div>
    </div>

@endsection

@section('third_party_stylesheets')

    {{-- <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

@stop

@section('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    {{-- <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>


    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script> --}}
    <script>
        // $(document).ready(function () { 
        //     var dataTable = $('#myTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             url: "{{ route('report.served-periodes-data') }}",
        //             data: function (d) { 
        //                 d.start_date = $('#start_date').val();
        //                 d.end_date = $('#end_date').val();
        //                 d.patient_id=$('#patient_id').val();
        //                 d.district_id = $('#district_id').val();
        //                 d.room_id = $('#room_id').val();

        //             },
        //             error: function (xhr, textStatus, errorThrown) {
        //                 $('#start_date').addClass('is-invalid');
        //                 $('#end_date').addClass('is-invalid');

        //     },
        //         },
        //         columns: [
        //             { data: 'id', name: 'id',searchable: true },
        //             { data: 'patient_name', name: 'patient_name' ,searchable: true }, // Add this line for patient name
        //             { data: 'room_number', name: 'room_number',searchable: true },  
        //             { data: 'district', name: 'district',searchable: true }, 
        //             { data: 'date_of_check_in', name: 'date_of_check_in',searchable: true },
        //             { data: 'date_of_check_out', name: 'date_of_check_out',searchable: true },

        //         ], dom: 'Bfrtip',
        //         buttons: [{
        //     extend: 'pdf',
        //     orientation: 'Portrait', // Set page orientation
        //     pageSize: 'A4',           // Set page size
        //     margin: [30, 20, 30, 20], // Set margins: [top, right, bottom, left]
        //     customize: function (doc) {

        //     // Set the width of the content area to 100%
        //     doc.content[1].table.widths = ['*'].concat(new Array(doc.content[1].table.body[0].length - 1).fill('*'));
        //      // Set column headers to left align
        //      doc.content[1].table.body[0].forEach(function (header) {
        //             header.alignment = 'left';
        //         });

        //         // Add custom footer
        //         var footer = [
        //             {
        //                 text: 'Print By {{ Auth::user()->first_name }} at {{ date('Y-m-d h:i:s') }}'   ,
        //                 alignment: 'center',
        //                 fontSize: 10,
        //                 margin: [0, 10, 0, 0] // top, right, bottom, left
        //             }
        //         ];
        //         doc.content.push({ table: { body: [footer] }, layout: 'noBorders', margin: [30, 20, 30, 20] });

        // }


        // }],
        //         rowCallback: function (row, data, index) {
        //     // Add index column to each row
        //     var api = this.api();
        //     var startIndex = api.page() * api.page.len();
        //     var rowNumber = startIndex + index + 1;
        //     $('td:eq(0)', row).html(rowNumber);
        // }
        //     });

        //     // Datepicker initialization
        //     $('.datepicker').datepicker({
        //         format: 'yyyy-mm-dd',
        //         autoclose: true,
        //     });

        //     // Filter button click event
        //     $('#filterBtn').on('click', function () {
        //         $('#start_date').removeClass('is-invalid');
        //         $('#end_date').removeClass('is-invalid');
        //         dataTable.draw();
        //     });
        // });

        $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
    </script>
@stop
