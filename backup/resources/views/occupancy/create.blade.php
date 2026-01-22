@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

    <h1 class="h3 mb-2 text-gray-800">Room Occupancy</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    <div class="dropdown no-arrow show">
                        <a href="{{ route('occupancy.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>



                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2">Date: <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <form action="" id="select_date" method="get">
                                <input type="text" class="form-control datepicker   @error('date') is-invalid @enderror"
                                    id="date" name="date_occ" value="{{ $date }}">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </form>
                        </div>
                    </div>
                    <form id="rmoccupancyForm" action="{{ route('occupancy.store') }}" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" id="form_date" name="date" value="{{ $date }}">
                        <br />
                        <div id="getdate">
                            <h4>{{ $date }}</h4>
                        </div>
                        <hr style="border-top: 1px solid rgb(0 0 0 / 46%);" />
                        <br />
                        <div class="row">

                            @foreach ($admssions as $item)
                                <div class="col-md-6">
                                    <h3> {{ $item->room->floor->number }} - {{ $item->room->room_number }} </h3>
                                    <hr />
                                    <div style="margin-left: 3px">
                                        <input type="hidden" name="admission_id[{{ $item->room_id }}]"
                                            value="{{ $item->id }}" />
                                        <label class="border-bottom form-check pb-1" for="{{ $item->room_id }}p"><input
                                                type="checkbox" value="{{ $item->patient->name }}" class="form-check-input"
                                                @checked(true) name="room[{{ $item->room_id }}][p]"
                                                id="{{ $item->room_id }}p"> Patient : {{ $item->patient->name }}
                                                <i class="fa fa-solid fa-bed float-right"></i> </label>

                                        <label class="border-bottom form-check pb-1" for="{{ $item->room_id }}f"><input
                                                type="checkbox"
                                                value="{{ $item->patient->father_name . '|' . $item->patient->father_nic . '|' . $item->patient->father_contact }}"
                                                @if (count($item->occ))
                                                    @if(in_array($item->patient->father_name,json_decode($item->occ)) )@checked(true) @endif
                                                @else
                                                    @if (is_array(json_decode($item->parents)) && (in_array('f', json_decode($item->parents)))) @checked(true) @endif
                                                @endif

                                                name="room[{{ $item->room_id }}][f]" id="{{ $item->room_id }}f"
                                                class="form-check-input"> Father : {{ $item->patient->father_name }}


                                                <i class="fs fa-solid fa-person float-right"></i> </label>
                                        <label class="border-bottom form-check pb-1" for="{{ $item->room_id }}m"><input
                                                type="checkbox"
                                                value="{{ $item->patient->mother_name . '|' . $item->patient->mother_nic . '|' . $item->patient->mother_contact }}"
                                                @if (count($item->occ))
                                                    @if(in_array($item->patient->mother_name,json_decode($item->occ)) )@checked(true) @endif
                                                @else
                                                    @if (is_array(json_decode($item->parents)) && (in_array('m', json_decode($item->parents)))) @checked(true) @endif
                                                @endif
                                                name="room[{{ $item->room_id }}][m]" id="{{ $item->room_id }}m"
                                                class="form-check-input"> Mother : {{ $item->patient->mother_name }}
                                                <i class="float-right fa fa-solid fa-person-dress"></i> </label>
                                        @if (
                                            $item->patient->father_name != $item->patient->guardian_name &&
                                                $item->patient->mother_name != $item->patient->guardian_name)
                                            <label class="border-bottom form-check pb-1" for="{{ $item->room_id }}g"><input
                                                    type="checkbox"
                                                    value="{{ $item->patient->guardian_name . '|' . $item->patient->guardian_nic . '|' . $item->patient->guardian_contact }}"
                                                @if (count($item->occ))
                                                    @if(in_array($item->patient->guardian_name,json_decode($item->occ)) )@checked(true) @endif
                                                @else
                                                    @if (in_array('o', json_decode($item->parents))) @checked(true) @endif
                                                @endif

                                                    name="room[{{ $item->room_id }}][g]" id="{{ $item->room_id }}g"
                                                    class="form-check-input"> Guardian :
                                                {{ $item->patient->guardian_name }}
                                                <i class="fa fa-user-tie float-right"></i> </label>
                                        @endif
                                        <br />
                                        <h4>Others
                                        </h4>
                                        @foreach ($item->guests as $guests)
                                            <label class="border-bottom form-check pb-1"
                                                for="{{ $item->room_id }}o{{ $loop->iteration }}">
                                                <input type="checkbox" value="{{ $guests->name . '|' . $guests->nic . '|' }}"
                                                    name="room[{{ $item->room_id }}][o][]"
                                                    @if (count($item->occ))
                                                        @if(in_array($guests->name,json_decode($item->occ)) )@checked(true) @endif
                                                    @else
                                                        @checked(true)
                                                    @endif


                                                    id="{{ $item->room_id }}o{{ $loop->iteration }}"
                                                    class="form-check-input"> {{ $guests->name }} <i
                                                    class="fa fa-users float-right"></i> </label>
                                            <div style="height: 10px;"></div>
                                        @endforeach

                                        @can('admission-edit')
                                                <a href="{{ route('admission.edit', $item->id) }}"
                                                    class="btn btn-sm bg-success text-white float-start btn-icon-split" target="_blank" data-toggle="addguests" title="Add Guests">
                                                    <span class="icon text-white-50">
                                                        <i class="fa-solid fa-person-circle-plus faperson-icon"></i>
                                                    </span>
                                                    <span class="text">Add Guests</span>
                                                </a>
                                                @else
                                                <a href="#"
                                                    class="btn btn-sm bg-success text-white disabled float-start btn-icon-split" target="_blank" data-toggle="addguests" title="Add Guests">
                                                    <span class="icon text-white-50">
                                                        <i class="fa-solid fa-person-circle-plus faperson-disabled"></i>
                                                    </span>
                                                    <span class="text">Add Guests</span>
                                                </a>
                                             @endcan
                                             <br /> <br />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>

                <div class="card-footer text-right">
                    <button type="button" value="save" class="btn btn-sm btn-primary btn-icon-split"
                        id="room_occ_submit_btn">
                        <span class="icon text-white-50">
                            <i class="fa fa-save"></i>
                        </span>
                        <span class="text">Save</span>
                    </button>
                </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@stop

@section('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        $(document).ready(function() {
            // Attach a change event handler to the date input
            $("#date").on("change", function() {
                // Get the updated value of the date input
                var updatedDate = $(this).val();
                // Update the content of the div
                $("#getdate h4").text(updatedDate);
                $('#form_date').val(updatedDate);
            });


            $('#room_occ_submit_btn').on('click', function() {
                // Show confirmation message
                Swal.fire({
                    title: 'Are you sure you want to save?',
                    text: 'This action will save the data. Please proceed with caution.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form
                        $('#rmoccupancyForm').submit();
                    }
                });
            });

        });
    </script>

    <script>
        $('#date').change(function() {
            $('#select_date').submit();
        });

        $(document).ready(function(){
        $('[data-toggle="addguests"]').tooltip();
    });
    </script>
@stop
