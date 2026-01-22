@extends('layouts.app')
@section('content')
<style>
</style>
    <h1 class="h3 mb-2 text-gray-800">
     Average Length of Stay
       </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-12">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">
                        <div class="dropdown no-arrow show">
                            <a href="{{ route("report.avg-len-of-stay") }}" class="btn btn-sm btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fa fa-arrow-left"></i>
                                </span>
                                <span class="text">Back</span></a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <form id="avgLenOfStayForm" class="row" method="POST" action="{{ route("report.avg-len-of-stay-search") }}">
                        @csrf
                    @method('post')
                        {{-- <div class="col-md-8 row"> --}}
                        <label for="start_date" class="col-md-1.5 labeltext" >Start Date:</label>
                        <div class="col-md-2">
                            @php  $date = date('Y-m-d');
                            @endphp
                        <input type="text" id="start_date" name="start_date" value="{{ $search_data->start_date }}" class="datepicker form-control">
                    </div>
                    <div class="col-md-1"></div>
                        <label for="end_date" class="col-md-1.5 labeltext">End Date:</label>
                    <div class="col-md-2">
                        <input type="text" id="end_date" name="end_date" value="{{ $search_data->end_date }}" class="datepicker form-control">
                    </div>




                    <div class="col-md-4">
                        <button type="submit" id="filterBtn" class="btn btn-primary">  Find Average Length of Stay  </button>
                    </div>

                {{-- </div> --}}
                    </form><br/><br/><br/>
                    <div class="row">
                        <p>total number of bed nights occupied - {{ $search_data->day_count}}</p>
                    </div>
                    <div class="row">
                        <p>total number of children - {{ $patients_count }}</p>
                    </div>
                    <hr/>
                    <div class="row">
                        <p><strong>Average Length of Stay -  {{ $search_data->avg_len_of_stay}}</strong></p>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection



@section('third_party_stylesheets')

    <link href="{{ asset('plugin/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

@stop

@section('third_party_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="{{ asset('plugin/datatable/jquery.dataTables.min.js') }}"></script>



    <!-- DataTables Buttons JS -->

<script>
    $(document).ready(function () {
        // Initialize DataTable


        // Datepicker initialization
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        // Filter button click event
        $('#filterBtn').on('click', function () {
            $('#start_date').removeClass('is-invalid');
            $('#end_date').removeClass('is-invalid');
            dataTable.draw();
        });
    });
    $('table').on('draw.dt', function() {
    $('[data-bs-toggle="tooltip"]').tooltip();


    // $('#filterBtn').click(function() {
    //     var backward_day_count = $('#backward_day_count').val(); // Get the value from the text box

    //     // Construct the URL with the backward_day_count as a query parameter
    // var url = '{{ route("report.upcoming-discharges-data") }}' + '?backward_day_count=' + backward_day_count;

    //     // Redirect to the constructed URL
    //     window.location.href = url;

    // });

});
</script>
@stop
