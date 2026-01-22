@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
        new admission</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">

                    </div>
                </div>


                <form action="{{ route('admission.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">Patient: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select style="width: 100%" name="patient" id="patient"
                                    class="select2 form-control  @error('patient') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach ($patients as $item)
                                        <option value="{{ $item->id }}" @selected(old('patient'))>{{ $item->name }}
                                            ({{ $item->guardian_name ?? '' }} -
                                            {{ $item->guardian_nic ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2">Check In: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control datetimepicker  @error('date_of_check_in') is-invalid @enderror"
                                    id="date_of_check_in" name="date_of_check_in" step="60"
                                    value="{{ date('Y-m-d H:i') }}">
                                @error('date_of_check_in')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Type of service: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select style="width: 100%" name="type_of_service"
                                    class="select2 form-control  @error('type_of_service') is-invalid @enderror"
                                    id="type_of_service">
                                    <option value=""></option>
                                    <option value="10" {{ old('type_of_service') == '10' ? 'selected' : '' }}>Palliative
                                        care</option>
                                    <option value="20" {{ old('type_of_service', '20') == '20' ? 'selected' : '' }}>
                                        Accommodation</option>
                                </select>
                                @error('type_of_service')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Plan to Check out: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control datetimepicker  @error('plan_to_check_out') is-invalid @enderror"
                                    id="plan_to_check_out" name="plan_to_check_out" step="60"
                                    value="{{ old('plan_to_check_out') }}" placeholder="Check out at">
                                @error('plan_to_check_out')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Available Rooms: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select style="width: 100%" name="room" id="room"
                                    class="select2 form-control @error('room') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}" @if(old('room')==$item->id) @selected(true) @endif  >
                                            {{ $item->room_number }} -
                                            @switch($item->status)
                                                @case(1)
                                                    Available (Inventory Complete)
                                                @break

                                                @case(2)
                                                    Available (Inventory Incomplete)
                                                @break

                                                @case(20)
                                                    Occupied
                                                @break

                                                @case(30)
                                                    Under Maintenance
                                                @break
                                            @endswitch
                                        </option>
                                    @endforeach
                                </select>
                                @error('room')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2"></div>
                            <div id="room_inventory" class="col-md-10 mt-2 row" style="margin-left: 3px">

                            </div>
                        </div>

                        <hr>

                        <div class="col-sm-12">
                            <legend>Guardian / Family details</legend>
                        </div>
                        <hr />
                        <div class="row">
                            <label class="col-sm-2"></label>
                            <span id="guardian" style="margin-left: 33px">
                            </span>
                        </div>
                        {{-- Person Details --}}
                        <div id="personDetails" class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="person-detail col-md-8">
                                <!-- Label Row -->
                                <div class="form-group row">
                                    <label for="name[]" class="col-md-8">Person's Name</label>
                                    <label for="nic[]" class="col-md-3">NIC</label>
                                    {{-- <label for="relationship[]" class="col-md-3">Relationship</label> --}}
                                </div>
                                <!-- Input Row -->
                                <div class="form-group row guest_row">
                                    <div class="col-md-8 col-sm-6 mb-2 mb-sm-0">
                                        <input type="text" class="form-control" name="name[]"
                                            value="{{ old('name.0') }}">
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-2 mb-sm-0">
                                        <input type="text" class="form-control @error('nic.0') is-invalid @enderror" name="nic[]"  value="{{ old('nic.0') }}">
                                        @error('nic')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div> 
                                    
                                    <div class="col-md-1 col-sm-6 add_new_guest_col">
                                        <button type="button" style="background-color: #578b26"
                                            class="btn btn-sm text-white btn-icon-split" id="addPerson">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>

                        @error('parents')
                        <span class="invalid-feedback" role="alert">

                            <div class="alert alert-danger">
                                <strong>{{ $message }}</strong>
                              </div>
                        </span>
                        @enderror

                        @error('name.0')
                        <span class="invalid-feedback" role="alert">
                            <div class="alert alert-danger">
                                <strong>{{ $message }}</strong>
                              </div>
                        </span>
                        @enderror

                        <hr>
                        <div class="col-sm-12">
                            <legend>Referral</legend>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="reffered_ward">Referred Ward:</label>
                            <div class="col-sm-8">
                                <select name="reffered_ward" id="reffered_ward"
                                    class="select2 form-control @error('reffered_ward') is-invalid @enderror">
                                    <option value="" selected="selected"></option>
                                    @foreach ($disreferred_ward as $item)
                                        <option value="{{ $item->reffered_ward }}"  @if(old('reffered_ward')==$item->reffered_ward) @selected(true) @endif>
                                            {{ $item->reffered_ward }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('reffered_ward')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="reffered_counsultant">Referred Consultant:</label>
                            <div class="col-sm-8">
                                <select name="reffered_counsultant" id="reffered_counsultant"
                                    class="form-control @error('reffered_counsultant') is-invalid @enderror">
                                    <option value="" selected="selected"></option>
                                    @foreach ($disreffered_counsultant as $item)
                                        <option value="{{ $item->reffered_counsultant }}"  @if(old('reffered_counsultant')==$item->reffered_counsultant) @selected(true) @endif>
                                            {{ $item->reffered_counsultant }}
                                        </option>
                                    @endforeach
                                </select>


                                @error('reffered_counsultant')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="treatment_history">Treatment History:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">

                                @php
                                $treatmentHistory = ['Chemotherapy', 'Radiotherapy'];
                                @endphp

                                @foreach($treatmentHistory as $values)
                                <div class="col-sm-3">
                                    <label for="{{ $values }}" class="label label-defalt">
                                        <input type="checkbox" name="treatment_history[]" id="{{ $values }}" value="{{ $values }}" class="form-check-input" @if(is_array(old('treatment_history')) && in_array($values, old('treatment_history'))) checked @endif>
                                        {{ $values }}
                                    </label>
                                </div>
                                @endforeach

                                <div class="col-sm-4">
                                    <input class="form-control @error('treatment_history') is-invalid @enderror" type="text" name="treatment_history[]" value="{{ old('treatment_history.2') }}">
                                </div>
                                @error('treatment_history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2" for="special_requirements">Special Requirements:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">
                                @php
                                $specialRequirements = ['Special Diet', 'Social Services', 'Counseling', 'Relaxation Therapy', 'Physiotherapy', 'Religious Intervation'];
                                @endphp

                                @foreach($specialRequirements as $requirement)
                                <div class="col-sm-3">
                                    <label for="{{ $requirement }}" class="label label-defalt">
                                        <input type="checkbox" name="special_requirements[]" id="{{ $requirement }}" value="{{ $requirement }}" class="form-check-input" @if(is_array(old('special_requirements')) && in_array($requirement, old('special_requirements'))) checked @endif>
                                        {{ $requirement }}
                                    </label>
                                </div>
                                @endforeach

                                @error('special_requirements')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        </hr>
                        <hr />
                        {{-- <div class="col-sm-2">
                            <legend>Agreement</legend>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-2" for="agreement_file">Admission Request (pdf): <br /><small
                                    class="text-red">(5 Mb Max)</small></label>
                            <div class="col-sm-8">
                                <input class="form-control @error('agreement_file') is-invalid @enderror" type="file"
                                    name="agreement_file" id="agreement_file">
                                @error('agreement_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>


                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('admission.index') }}" class="btn btn-info">
                                <span class="text">Cancel</span>
                            </a>
                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">

@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
        // Initialize the datetime picker

        // Initialize the datetime picker
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Additional options if needed
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addPerson').addEventListener('click', function() {
                let inputRow = document.querySelector('#personDetails .guest_row').cloneNode(true);

                // Clear input values in the cloned row
                let clonedInputs = inputRow.querySelectorAll('input, select');
                clonedInputs.forEach(function(input) {
                    input.value = '';
                });

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm mt-0 mb-2 removePerson';
                removeButton.innerHTML = '<i class="fa fa-trash"></i>';

                // Add click event listener to the remove button
                removeButton.addEventListener('click', function() {
                    inputRow.remove();
                });

                // Append the remove button to the cloned input row
                inputRow.querySelector('.add_new_guest_col').innerHTML = '';
                inputRow.querySelector('.add_new_guest_col').appendChild(removeButton);

                // Find the row with class "guest_row" and append the new row after it
                let guestRow = document.querySelector('#personDetails .guest_row');
                guestRow.parentNode.insertBefore(inputRow, guestRow.nextSibling);
            });

            // Remove guest row when delete button is clicked
            document.getElementById('personDetails').addEventListener('click', function(event) {
                if (event.target.classList.contains('removePerson')) {
                    event.target.closest('.form-group.row').remove();
                }
            });

            function setPlanToCheckOutDate() {
                var checkInDate = document.getElementById('date_of_check_in').value;
                if (checkInDate) {
                    var parsedCheckInDate = new Date(checkInDate);
                    var twoWeeksLaterDate = new Date(parsedCheckInDate.getTime() + (14 * 24 * 60 * 60 * 1000));
                    var formattedTwoWeeksLaterDate = twoWeeksLaterDate.toISOString().slice(0, 16).replace('T', ' ');
                    document.getElementById('plan_to_check_out').value = formattedTwoWeeksLaterDate;
                }
            }
            setPlanToCheckOutDate();
            document.getElementById('date_of_check_in').addEventListener('change', setPlanToCheckOutDate);

        });


        function getParent(pop){
            var patient =  $('#patient').val();
            if(patient!=''){
            $.ajax({
                url: "{{ route('ajax.getPetion') }}",
                method: "GET", // or "POST" for a POST request
                data: {
                    "patient": patient,
                },
                success: function(response) {
                    //  $('#havet').text(response[0]['cultivated_land']);
                    //  havest =  response[0]['cultivated_land'];
                    var gender = (response[0]['gender'] == 1) ? 'male' : 'female';
                    if(pop==true){
                    Swal.fire({
                        title: response[0]['name'],
                        html: '<table class="text-left" width="100%"><tr><th>Date Of Birth </th><td>' +
                            response[0]['date_of_birth'] + ' (' + response[0]['age'] +
                            ' )</td></tr>' +
                            '<tr><th>Gender </th><td>' + gender + '</td></tr>' +
                            '<tr><th>Age At Register </th><td>' + response[0][
                            'age_at_register'] + '</td></tr>' +
                            '<tr><th>Distance</th><td>' + response[0]['address'][
                                'distance_to_suwa_arana'
                            ] + ' Km</td></tr>' +
                            '<tr><th colspan="2">Address</th></tr>' +
                            '<tr><td colspan="2">' + response[0]['address']['home'] + ' ' +
                            response[0]['address']['street'] + ' ' + response[0]['address'][
                                'city'
                            ] + '</td></tr>' +

                            '<tr><th colspan="2" class="text-white bg-primary">Father</th></tr>' +
                            '<tr><th>Name</th><td>' + response[0]['father_name'] +
                            '</td></tr>' +
                            '<tr><th>NIC </th><td>' + response[0]['father_nic'] + '</td></tr>' +
                            '<tr><th>Contact </th><td>' + response[0]['father_contact'] +
                            '</td></tr>' +
                            '<tr><th>Occupation</th><td>' + response[0]['father_occupation'] +
                            '</td></tr>' +
                            '<tr><th>Income</th><td>' + response[0]['father_income'] +
                            '</td></tr>' +
                            '<tr><th colspan="2" class="text-white bg-primary">Mother</th></tr>' +
                            '<tr><th>Name</th><td>' + response[0]['mother_name'] +
                            '</td></tr>' +
                            '<tr><th>NIC </th><td>' + response[0]['mother_nic'] + '</td></tr>' +
                            '<tr><th>Contact </th><td>' + response[0]['mother_contact'] +
                            '</td></tr>' +
                            '<tr><th>Occupation</th><td>' + response[0]['mother_occupation'] +
                            '</td></tr>' +
                            '</table>',
                        //  icon: 'info',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Select it!'
                    });
                }
                    $('#guardian').html('');
                    $('#guardian').append(
                        '<label><input type="checkbox"  name="parents[]" value="f" class="form-check-input" @if(is_array(old('parents')) && in_array('f', old('parents'))) checked @endif> Father : ' +
                        response[0]['father_name'] + ' ' + response[0]['father_nic'] + ' </label>');
                    $('#guardian').append(
                        '<br/><label><input type="checkbox"  name="parents[]" value="m" class="form-check-input" @if(is_array(old('parents')) && in_array('m', old('parents'))) checked @endif> Mother : ' +
                        response[0]['mother_name'] + ' ' + response[0]['mother_nic'] + ' </label>');
                    if (response[0]['guardian_relationship'] !== 'Father' || response[0]['guardian_relationship'] !== 'Mother') {
                        $('#guardian').append(
                            '<br/><label><input type="checkbox"  name="parents[]" value="o" class="form-check-input" @if(is_array(old('parents')) && in_array('o', old('parents'))) checked @endif> Guardian : ' +
                            response[0]['guardian_name'] + ' ' + response[0]['guardian_nic'] +
                            ' </label>');
                    }

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
        }

        function getRoomInventrory(){
            var room = $('#room').val();

$.ajax({
    url: "{{ route('ajax.room-item') }}",
    method: "GET", // or "POST" for a POST request
    data: {
        "room": room,
    },
    success: function(response) {
        $('#room_inventory').html('');
        $.each(response[0], function(index, item) {
            $('#room_inventory').append(
                '<label class="col-md-6 label label-defalt"><input type="checkbox" class="form-check-input" checked name="room_inventory[]" value="' +
                item['id'] + '">' + item['name'] + '</label>');
        });



    },
    error: function(xhr, status, error) {
        console.log(error);
    }
});
        }

        $('#patient').change(function() {
            getParent(true);
        });

        $('#room').change(function() {
            getRoomInventrory();
        });

        $(document).ready(function() {
            $('#reffered_ward').select2({
                tags: true,
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            });
        });


        $(document).ready(function() {
            $('#reffered_counsultant').select2({
                tags: true,
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            });
        });

        getParent(false);
        getRoomInventrory();
    </script>


@stop
