@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

    <h1 class="h3 mb-2 text-gray-800">Modify Admission </h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <div class="dropdown no-arrow show">
                        <h5>Admission No: {{ $admission->id }}</h5>
                    </div>
                </div>
                <form action="{{ route('admission.update', $admission->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">Patient: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                {{ $admission->patient->name }}
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Check In: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datetimepicker step="60"
                                    @error('date_of_check_in') is-invalid @enderror" id="date_of_check_in"
                                    name="date_of_check_in" value="{{ $admission->date_of_check_in }}">
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
                               <select name="type_of_service" class="select2 form-control  @error('type_of_service') is-invalid @enderror" id="type_of_service" >
                                <option value="" @if($admission->type_of_service=='') @selected(true) @endif></option>
                                <option value="10" @if($admission->type_of_service=='10') @selected(true) @endif>Palliative care</option>
                                <option value="20" @if($admission->type_of_service=='20') @selected(true) @endif>Accommodation</option>
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
                                    class="form-control  datetimepicker @error('plan_to_check_out') is-invalid @enderror"
                                    id="plan_to_check_out" name="plan_to_check_out" step="60"
                                    value="{{ $admission->plan_to_check_out }}" placeholder="Check out at">
                                @error('plan_to_check_out')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Selected Room: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="room" id="room"
                                    class="select2 form-control @error('room') is-invalid @enderror">
                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}"
                                            @if ($item->id == $admission->room_id) selected @endif>
                                            {{ $item->room_number }}   -
                                            @switch($item->status)
                                                @case(1) Available (Inventory Complete) @break
                                                @case(2) Available (Inventory Incomplete)@break
                                                @case(20) Occupied @break
                                                @case(30) Under Maintenance @break

                                            @endswitch</option>
                                    @endforeach
                                </select>
                                @error('plan_to_check_out')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2"></div><div class="col-md-2"></div>
                            <div id="room_inventory" class="col-md-10 mt-2 row" style="margin-left: 3px">
                                @foreach ($admission->room->item as $item)
                                <label class="col-md-6">
                                    <input type="checkbox" class="form-check-input" @if(in_array($item->id,$admission->item->pluck('id')->toArray())) @checked(true) @endif name="room_inventory[]" value="{{ $item->id }}">
                                    {{ $item->name }}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <hr>
                        <div class="col-sm-2">
                            <legend>Guests</legend>
                        </div>
                        <div class="row">
                            @php
                            $parents = json_decode($admission->parents);
                            if ($parents === null) {
                                $parents = [];
                            }
                        @endphp
                            <label class="col-sm-2"></label>
                                <span id="guardian" style="margin-left: 23px">
                                    <label class="label label-defalt"><input type="checkbox" name="parents[]" value="f" class="form-check-input" @if(in_array('f',$parents)) @checked(true) @endif > Father : {{ $admission->patient->father_name  }} {{ $admission->patient->father_nic  }} </label><br/>
                                    <label class="label label-defalt"><input type="checkbox" name="parents[]" value="m" class="form-check-input" @if(in_array('m',$parents)) @checked(true) @endif > Mother : {{ $admission->patient->mother_name  }} {{ $admission->patient->mother_nic  }} </label><br/>

                                    <label class="label label-defalt"><input type="checkbox" name="parents[]" value="o" class="form-check-input" @if(in_array('o',$parents)) @checked(true) @endif > Guardian : {{ $admission->patient->guardian_name  }} {{ $admission->patient->guardian_nic  }} </label>
                                </span>
                        </div>
<br/>
                        <div id="personDetails" class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="person-detail col-md-8">
                                <!-- Label Row -->
                                <div class="form-group row">
                                    <label for="name[]" class="col-md-8">Person's Name</label>
                                    <label for="nic[]" class="col-md-3">NIC</label>
                                   
                                    <div class="col-md-1"></div>
                                </div>
                                <!-- Existing Input Rows -->
                                @foreach ($admission->guests as $item)
                                    <div class="form-group row">
                                        <div class="col-md-8 mb-8">
                                            <input type="text" class="form-control" name="name[{{ $item->id }}]" value="{{ $item->name }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="text" class="form-control @error('nic.' . $item->id) is-invalid @enderror" name="nic[{{ $item->id }}]" value="{{ $item->nic }}" >
                                            @error('nic.' . $item->id)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-1" style="display: none">
                                            <button type="button" class="btn btn-danger btn-sm mt-0 mb-2 removePerson">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Additional Input Row -->
                                <div class="form-group row guest_row">
                                    <div class="col-md-8 mb-2">
                                        <input type="text" class="form-control" name="name[]">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="text" class="form-control" name="nic[]"  >
                                    </div> 
                                    <div class="col-md-1 add_new_guest_col">
                                        <button id="addPerson" type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split">
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
                                <select name="reffered_ward" id="reffered_ward" class="select2 form-control @error('reffered_ward') is-invalid @enderror">
                                    <option value="" selected="selected"></option>
                                    @foreach ($disreferred_ward as $item)
                                            <option value="{{ $item->reffered_ward }}"
                                                @if ($item->reffered_ward == $admission->reffered_ward) selected @endif >
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
                                <select name="reffered_counsultant" id="reffered_counsultant" class="select2 form-control @error('reffered_counsultant') is-invalid @enderror">
                                    <option value="" selected="selected"></option>
                                    @foreach ($disreffered_counsultant as $item)
                                            <option value="{{ $item->reffered_counsultant }}"
                                                @if ($item->reffered_counsultant == $admission->reffered_counsultant) selected @endif>
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
                            @php
                            $treatment_history = json_decode($admission->treatment_history);
                            if ($treatment_history === null) {
                                $treatment_history = [];
                            }
                            @endphp
                            <div class="col-sm-8 row" style="margin-left: 3px">
                               <div class="col-sm-4"> <label for="chemotherapy"><input type="checkbox" name="treatment_history[]" value="Chemotherapy" id="chemotherapy" class="form-check-input" @if(in_array('Chemotherapy',$treatment_history)) @checked(true)  @endif > Chemotherapy</label></div>
                               <div class="col-sm-4">  <label for="radiotherapy"><input type="checkbox" name="treatment_history[]" value="Radiotherapy" id="radiotherapy" class="form-check-input" @if(in_array('Radiotherapy',$treatment_history)) @checked(true)  @endif> Radiotherapy</label></div>
                               <div class="col-sm-4">
                                @php
                                if (($key = array_search('Chemotherapy', $treatment_history)) !== false) {
                                    unset($treatment_history[$key]);
                                }
                                if (($key = array_search('Radiotherapy', $treatment_history)) !== false) {
                                    unset($treatment_history[$key]);
                                }

                                @endphp
                                <input class="form-control @error('treatment_history') is-invalid @enderror" type="text" name="treatment_history[]" value="{{ reset($treatment_history) }}"> </div>
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
                                    $special_requirements = json_decode($admission->special_requirements);
                                    if ($special_requirements === null) {
                                        $special_requirements = [];
                                    }
                                @endphp
                                <div class="col-sm-3"> <label for="Special_Diet"><input type="checkbox" name="special_requirements[]" @if(in_array('Special Diet',$special_requirements)) @checked(true)  @endif id="Special_Diet" value="Special Diet" class="form-check-input"> Special Diet</label></div>
                               <div class="col-sm-3">  <label for="Social_services"><input type="checkbox" name="special_requirements[]" @if(in_array('Social Services',$special_requirements)) @checked(true)  @endif value="Social Services" id="Social_services" class="form-check-input"> Social Services</label></div>
                               <div class="col-sm-3"> <label for="Counseling"><input type="checkbox" name="special_requirements[]" @if(in_array('Counseling',$special_requirements)) @checked(true)  @endif id="Counseling" value="Counseling" class="form-check-input"> Counseling </label></div>
                               <div class="col-sm-3"> <label for="Relaxation_Therapy"><input type="checkbox" name="special_requirements[]" @if(in_array('Relaxation Therapy',$special_requirements)) @checked(true)  @endif id="Relaxation_Therapy" value="Relaxation Therapy" class="form-check-input"> Relaxation Therapy </label></div>
                               <div class="col-sm-3"> <label for="Physiotherapy"><input type="checkbox" name="special_requirements[]" @if(in_array('Physiotherapy',$special_requirements)) @checked(true)  @endif id="Physiotherapy" value="Physiotherapy" class="form-check-input"> Physiotherapy </label></div>
                               <div class="col-sm-3"> <label for="Religious_Intervation"><input type="checkbox" name="special_requirements[]" @if(in_array('Religious Intervation',$special_requirements)) @checked(true)  @endif id="Religious_Intervation" value="Religious Intervation" class="form-check-input"> Religious Intervation </label></div>

                                @error('special_requirements')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </hr>
<hr/>

                        @if ($admission->agreement_file)
                            <div class="form-group row">
                                <label class="col-sm-2" for="agreement_file"></label>
                                <div class="col-sm-4">
                                    <a href="{{ asset($admission->agreement_file) }}" target="_blank">Currnt
                                        Agreement</a>

                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-sm-2" for="agreement_file">Admission Request (pdf): <br/><small class="text-red">(5 Mb Max)</small></label>
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
    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <script>
        $('.select2').select2();
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Additional options if needed
        });
    </script>
    <script>
         document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('addPerson').addEventListener('click', function () {
                let inputRow = document.querySelector('#personDetails .guest_row').cloneNode(true);
                // Clear input values in the cloned row
                let clonedInputs = inputRow.querySelectorAll('input, select');
                clonedInputs.forEach(function (input) {
                    input.value = '';
                });

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm mt-0 mb-2 removePerson';
                removeButton.innerHTML = '<i class="fa fa-trash"></i>';

                // Add click event listener to the remove button
                removeButton.addEventListener('click', function () {
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
            document.getElementById('personDetails').addEventListener('click', function (event) {
                if (event.target.classList.contains('removePerson')) {
                    event.target.closest('.form-group.row').remove();
                }
            });
        });


        $('#room').change(function(){
        var room = this.value;

     $.ajax({
         url: "{{ route('ajax.room-item') }}",
         method: "GET", // or "POST" for a POST request
         data: {
             "room": room,
         },
         success: function(response) {
            $('#room_inventory').html('');
            $.each(response[0], function(index, item) {
                $('#room_inventory').append('<label class="col-md-6"><input type="checkbox" class="form-check-input" checked name="room_inventory[]" value="' + item['id'] + '">' + item['name'] + '</label>');
            });



         },
         error: function(xhr, status, error) {
            console.log(error);
         }
         });
     });

     $(document).ready(function () {
        $('#reffered_ward').select2({
            tags: true,
            createTag: function (params) {
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


    $(document).ready(function () {
        $('#reffered_counsultant').select2({
            tags: true,
            createTag: function (params) {
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

    </script>
@stop
