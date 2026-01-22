@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')
<style>
    .select2-container {
    width: 100% !important;
}
 .form-group input {
    border-radius: 30px !important;
 }
 #addVaccination, #addPrescription, #addService {
    margin-top: 3px;
 }
 #wrapper #content-wrapper #content {
    background-image: url("../img/background.jpg") !important;
    background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover; /* Resize the background image to cover the entire container */
  color: #fff !important;
 }
 #wrapper #content-wrapper {
    background-color: #230049;
    width: 100%;
    overflow-x: hidden;
}
 .card-body {
    background-color: transparent !important;
    background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover; /* Resize the background image to cover the entire container */
  color: #fff !important;
}
.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: #f5ecff00 !important;
    border-bottom: 0px solid #e3e6f0 !important;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #7b7ab700 !important;
    background-clip: border-box;
    border: 0px solid #e3e6f000 !important;
    border-radius: .35rem;
}
.bg-gray-200 {
    background-color: #008001 !important;
}
.text-gray-800{
    color:#fff!important
}
.bg-gradient-primary {
    background-color: #1c0442;
    background-image: none !important;
    background-size: none !important;
}
footer.sticky-footer {
    background-color: #1c0442 !important;
}
footer.sticky-footer .copyright {
    color:#fff !important;
}
.text-center {
    text-align: center !important;
}

/* durationweeks button */
#duration-weeks label {
    margin-right: 2px;
}
.radio-button-group {
    display: flex;
    gap: 10px; /* Adjust the gap to add space between the buttons */
    justify-content: flex-start; /* Align buttons to the left */
}

#duration-weeks .radio-button {
    position: relative;
    display: inline-block;
}

#duration-weeks .radio-button input[type="radio"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

#duration-weeks .radio-button span {
    padding: 7px 5px;
    background-color: #656363; /* Button background */
    border: 1px solid #ccc; /* Border style */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#duration-weeks .radio-button input[type="radio"]:checked + span {
    background-color: #007bff; /* Background when selected */
    color: white; /* Text color when selected */
    border-color: #007bff; /* Border color when selected */
}

#duration-weeks .radio-button span:hover {
    background-color: #e0e0e0; /* Hover effect */
}

</style>
<div class="row align-items-center">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">Update Bill ( Bill ID - {{ $bill->billing_id }})</h1>
    </div>
    @if(isset($treatment->pet->id) && $treatment->pet->id)
    <div class="col-auto bill-history">
        <a href="{{ route('medical-history.show', ['id' => $treatment->pet->id]) }}" target="_blank" class="btn btn-md btn-primary btn-icon-split ml-2 medical-history-btn">
            <span class="icon text-white-50">
                <i class="fa fa-file"></i>
            </span>
            <span class="text">Medical History</span>
        </a>
    </div>
@endif

</div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">

                    </div>
                </div>


                <form action="{{ route('billing.update', $bill->id) }}" method="POST" id="billingForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Client: <i class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <select style="width: 100%" name="pet" id="pet"
                                        class="select2 form-control  @error('pet') is-invalid @enderror" >
                                        <option value=""></option>
                                        @foreach ($pets as $item)
                                            <option value="{{ $item->id }}" @if(old('pet', $treatment->pet_id) == $item->id) selected @endif>
                                                {{ $item->pet_id }} - {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pet')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">

                                    <label class="col-sm-12" for="reffered_ward">Doctor: <i class="text-danger">*</i></label>
                                    <div class="col-sm-12">
                                        <select name="doctor" id="doctor"
                                            class="select2 form-control @error('doctor') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($doctors as $item)
                                                <option value="{{ $item->id }}"  @if(old('doctor', $treatment->doctor_id) == $item->id) selected @endif>
                                                 {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('doctor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                            </div>




                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Client Id: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('pet_id') is-invalid @enderror" id="pet_id"
                                    name="pet_id" value="{{ old('pet_id', $treatment->pet->pet_id) }}" placeholder="" readonly>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Client Name: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('pet_name') is-invalid @enderror" id="pet_name"
                                        name="pet_name" value="{{ old('pet_name', $treatment->pet->name) }}" placeholder="">
                                    @error('pet_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-12">Date of Birth: </label>
                                    <div class="col-sm-12">
                                        <input type="date" class="form-control   @error('date_of_birth') is-invalid @enderror" id="date_of_birth"
                                            name="date_of_birth" value="{{ old('date_of_birth', $treatment->pet->date_of_birth) }}" max="{{ date('Y-m-d') }}" placeholder="Date of bith">
                                        @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col">
                                <label class="col-sm-12">Age : </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('age') is-invalid @enderror" id="age"
                                        name="age" value="{{ old('age', $treatment->pet->age_at_register) }}" placeholder="">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>



                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12" for="pet-category">Skin Type: </label>
                            <div class="col-sm-12">
                              <select name="pet_category" id="pet_category"  class="select2 form-control @error('pet_category') is-invalid @enderror" onchange="fetchVaccinations(this.value);">
                                <option value=""></option>
                                @foreach ($petcategory  as $item)
                                    <option value="{{ $item->id }}" @if(old('pet_category', $treatment->pet->pet_category) == $item->id) selected @endif >{{ $item->name }}</option>
                                @endforeach
                              </select>
                                @error('pet_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="breed">Breed: </label>
                            <div class="col-sm-12">
                              <select name="breed" id="breed"  class="select2 form-control @error('breed') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($breed  as $item)
                                    <option value="{{ $item->id }}"  @if(old('breed', $treatment->pet->pet_breed) == $item->id) selected @endif >{{ $item->name }}</option>
                                @endforeach
                              </select>
                                @error('breed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Gender: </label>
                            <div class="col-sm-12">
                                <select name="gender" id="gender" class="select2 form-control  @error('gender') is-invalid @enderror">
                                    <option value=""></option>
                                    <option value="1" @if(old('gender', $treatment->pet->gender)==1) @selected(true) @endif  >Male</option>
                                    <option value="2" @if(old('gender', $treatment->pet->gender)==2) @selected(true) @endif >Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12" for="Weight">Weight: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ old('weight', $treatment->pet->weight) }}" placeholder=" ">
                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="Colour">Colour: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('colour') is-invalid @enderror" id="colour"
                                name="colour" value="{{ old('colour', $treatment->pet->color) }}" placeholder=" ">
                                @error('colour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-12" for="Colour">Remarks: </label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control   @error('remarks') is-invalid @enderror" id="remarks"
                                        name="remarks" >{{ old('remarks', $treatment->pet->remarks) }}</textarea>
                                        @error('remarks')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Owner Information</legend>
                        <br>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12" for="owner_name">Name: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('owner_name') is-invalid @enderror" id="owner_name"
                                    name="owner_name" value="{{ old('owner_name', $treatment->pet->owner_name)  }}" placeholder="">
                                    @error('owner_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="owner_contact">Contact Number: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('owner_contact') is-invalid @enderror" id="owner_contact"
                                name="owner_contact" value="{{ old('owner_contact', $treatment->pet->owner_contact) }}" placeholder=" ">
                                @error('owner_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="owner_whatsapp">WhatsApp Number: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('owner_whatsapp') is-invalid @enderror" id="owner_whatsapp"
                                    name="owner_whatsapp" value="{{ old('owner_whatsapp', $treatment->pet->owner_whatsapp ?: '+94 ') }}" placeholder=" ">
                                    @error('owner_whatsapp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-12" for="owner_contact2">Address: </label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('address') is-invalid @enderror" id="address"
                                name="address" >{{ old('address', $treatment->pet->owner_address) }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Treatment Information</legend>
                        <br>

                        <div class="form-group row">

                            <label class="col-sm-2">History /Complaint: <i class="text-danger">*</i></label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('history') is-invalid @enderror" id="history"
                                name="history" >{{ old('history', $treatment->history_complaint) }}</textarea>
                                @error('history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2">Clinical Observation: <i class="text-danger">*</i></label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('observation') is-invalid @enderror" id="observation"
                                name="observation" >{{ old('observation', $treatment->clinical_observation) }}</textarea>
                                @error('observation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2">Treatment Remarks: <i class="text-danger">*</i></label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('remarks_t') is-invalid @enderror" id="remarks_t"
                                name="remarks_t" >{{ old('remarks_t', $treatment->remarks) }}</textarea>
                                @error('remarks_t')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br/><br/>
                        <legend class="bg-gray-200 p-1 pl-lg-4">Prescription</legend>
                        <br/>
                        <div id="prescription" class="form-group row">
                            <div class="form-group row base-prescription-row">
                                <div class="col-md-4">
                                    Drug Name
                                </div>
                                <div class="col-md-3">
                                    dose
                                </div>
                                <div class="col-md-2">
                                    Dosage
                                </div>
                                <div class="col-md-2">
                                    duration
                                </div>

                                <div class="col-md-1">

                                </div>
                            </div>
                            @foreach ($prescriptions as $prescription)
                                <div class="previous-prescription-details form-group row" id="prescription-{{ $prescription->id }}">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="drug_name[]" value="{{ $prescription->drug_name }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="dosage[]" value="{{ $prescription->dosage }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="dose[]" value="{{ $prescription->dose }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="duration[]" value="{{ $prescription->duration }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm mt-0 mb-2 removePerson" data-id="{{ $prescription->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="prescription-details col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <select name="drug_name[]" id="drug_name" class="select2 form-control drug_items @error('drug_name') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($drugs as $item)
                                                <option value="{{ $item->name }}" @if(old('drug_name') == $item->name) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="dosage[]" id="dosage" class="select2 form-control dosage_types @error('dosage') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($dosagetypes as $item)
                                                <option value="{{ $item->name }}" @if(old('dosage') == $item->name) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- <input type="text" class="form-control" name="duration[]" placeholder=""> --}}
                                        <select name="dose[]" id="dose"
                                        class="select2 form-control duration_types @error('dose') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($dose as $item)
                                            <option value="{{ $item->name }}"  @if(old('dose')==$item->name) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="duration[]" id="duration" class="select2 form-control duration_types @error('duration') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($durationtypes as $item)
                                                <option value="{{ $item->name }}" @if(old('duration') == $item->name) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center gap-2 flex-nowrap prescription-actions">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addPrescription">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon-split ms-2 remove-prescription-row">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Vaccination</legend>
                        <br/>
                        <div id="vaccination" class="form-group row">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Vaccine Name
                                </div>
                                <div class="col-md-3">
                                    Next Vaccination Date
                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            @foreach ($vaccinationInfo as $vaccination)
                                <div class="previous-vaccination-details form-group row" id="vaccination-{{ $vaccination->id }}">
                                    <div class="col-md-4">
                                        <select name="vaccine_name[]" id="vaccine_name" class="select2 form-control vaccine_item @error('vaccine_name') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($vaccine as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->price }}" @if($vaccination->vaccine_id == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control datetimepicker" name="vacc_duration[]" value="{{ $vaccination->next_vacc_date }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="next_vacc_weeks[]" id="next_vacc_weeks"
                                            class="select2 form-control vaccine_item durationweek-width @error('next_vacc_weeks') is-invalid @enderror" >
                                            <option value="" selected="selected">Duration Slots</option>
                                            @foreach ($durationweeks as $item)
                                                <option value="{{ $item->name }}"  @if( $vaccination->next_vacc_weeks == $item->name) @selected(true) @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center gap-2 flex-nowrap vaccination-actions">
                                        <button type="button" class="btn btn-danger btn-sm mt-0 mb-2 removePerson remove-vaccination-row" data-id="{{ $vaccination->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="vaccination-details col-md-12 base-vaccination-row">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <select name="vaccine_name[]" id="vaccine_name" class="select2 form-control vaccine_item @error('vaccine_name') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($vaccine as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->price }}" @if(old('vaccine_name') == $item->name) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control datetimepicker" name="vacc_duration[]" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="next_vacc_weeks[]" id="next_vacc_weeks"
                                            class="select2 form-control vaccine_item durationweek-width @error('next_vacc_weeks') is-invalid @enderror" >
                                            <option value="" selected="selected">Duration Slots</option>
                                            @foreach ($durationweeks as $item)
                                                <option value="{{ $item->name }}"  @if(old('next_treatment_weeks')==$item->name) @selected(true) @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center gap-2 flex-nowrap vaccination-actions">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addVaccination">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon-split ms-2 remove-vaccination-row">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>


                        <hr/>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Next Treatment Date: </label>
                            <div class="col-sm-12">
                                <input type="text"
                                    class="form-control datetimepicker  @error('next_treatment_date') is-invalid @enderror"
                                    id="next_treatment_date" name="next_treatment_date" step="60"
                                    value="{{ old(date('Y-m-d H:i'), $treatment->next_clinic_date) }}">
                                @error('next_treatment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12"> &nbsp;</label>
                                <div id="duration-weeks" class="radio-button-group">
                                    @foreach ($durationweeks as $item)
                                        <label class="radio-button">
                                            <input type="radio" name="next_treatment_weeks" value="{{ $item->name }}"
                                                   @if($treatment->next_clinic_weeks == $item->name) checked @endif>
                                            <span>{{ $item->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col"></div>
                            <div class="col">
                                <label class="col-sm-12">Billing Date: <i class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <input type="text"
                                        class="form-control datetimepicker  @error('billing_date') is-invalid @enderror"
                                        id="billing_date" name="billing_date" step="60"
                                        value="{{ old(date('Y-m-d H:i'), $bill->billing_date) }}">
                                    @error('billing_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>



                        <hr>
<legend class="bg-gray-200 p-1 pl-lg-4">Billing Information</legend>
<br>
<div class="form-group row">
    <div class="col-md-4">
        Service Name
    </div>
    <div class="col-md-1">
        Qty
    </div>
    <div class="col-md-2">
        Unit Price
    </div>
    <div class="col-md-2">
        Discount
    </div>
    <div class="col-md-2">
        Total
    </div>
    <div class="col-md-1">
    </div>
</div>

<!-- Existing Billing Items -->
@foreach ($billItems as $item)
<div class="prevous-bill-details form-group row" id="bill-item-{{ $item->id }}">
    <div class="col-md-4">
        {{-- <input type="text" class="form-control" name="service_name[]" placeholder="Service Name" value="{{ $item->item_name }}" readonly> --}}
        <select name="service_name[]" id="service_name" class="select2 form-control service_item @error('service_name') is-invalid @enderror">
            <option value="" selected="selected"></option>
            @foreach ($services as $sitem)
            <option value="{{ $sitem->name }}" @if($item->item_name == $sitem->name) @selected(true) @endif>{{ $sitem->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <input type="text" class="form-control" name="billing_qty[]" placeholder="Qty" value="{{ $item->item_qty }}" readonly>
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="unit_price[]" placeholder="Unit Price" value="{{ $item->unit_price }}" readonly>
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="tax[]" placeholder="Discount" value="{{ $item->tax }}" readonly>
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" name="last_price[]" placeholder="Total" value="{{ ($item->unit_price *  $item->item_qty)  - (($item->unit_price *  $item->item_qty) * ( $item->tax /100)) }}" readonly>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-danger btn-sm removeBillItem" data-id="{{ $item->id }}">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</div>
@endforeach

<div id="serviceDetails" class="form-group row">
                            <div class="service-detail col-md-12 base-service-row">
        <div class="form-group row">
            <div class="col-md-4">
                <select name="service_name[]" id="service_name" class="select2 form-control service_item @error('service_name') is-invalid @enderror">
                    <option value="" selected="selected"></option>
                    @foreach ($services as $item)
                    <option value="{{ $item->name }}" @if(old('service_name')==$item->name) @selected(true) @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <input type="text" class="form-control" name="billing_qty[]" placeholder="">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="unit_price[]" placeholder="">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="tax[]" placeholder="">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="last_price[]" placeholder="">
            </div>
            <div class="col-md-1 d-flex align-items-center gap-2 flex-nowrap service-actions">
                <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addService">
                    <span class="icon text-white-50">
                        <i class="fa fa-plus"></i>
                    </span>
                </button>
                <button type="button" class="btn btn-sm btn-danger btn-icon-split ms-2 remove-service-row">
                    <span class="icon text-white-50">
                        <i class="fa fa-trash"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="person-detail col-md-12">
    <div class="form-group row">
        <div class="col-md-4"></div>
        <div class="col-md-1"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2"><label class="col-sm-12">Net Total: </label></div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="net_total" id="net_total" value="0" readonly>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<div class="person-detail col-md-12">
    <div class="form-group row">
        <div class="col-md-4"></div>
        <div class="col-md-1"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2"><label class="col-sm-12">Discount: </label></div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="discount" id="discount" value="{{ $bill->discount }}">
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<div class="person-detail col-md-12">
    <div class="form-group row">
        <div class="col-md-4"></div>
        <div class="col-md-1"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2"><label class="col-sm-12">Grand Total: </label></div>
        <div class="col-md-2">
            <input type="text" class="form-control" name="grand_total" id="grand_total" value="0" readonly>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<br><br>


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


                        <hr />

                        <div class="form-group row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                                <a href="{{ route('billing.index') }}" class="btn btn-info">
                                    <span class="text">Cancel</span>
                                </a>
                                <button type="submit" name="action" value="update" class="btn btn-md btn-primary btn-icon-split ml-2">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Update</span>
                                </button>
                                @can('bill-print')
                                <button type="submit" name="action" value="update_and_print" class="btn btn-md btn-primary btn-icon-split ml-2">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Update & Print</span>
                                </button>
                                @endcan
                            </div>
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
    <style>
        #moodEmoji {
            font-size: 3em;
            /* Adjust the font size as needed */
        }
    </style>
@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
        $(document).ready(function() {
        $('#pet').select2({
            closeOnSelect: false,
            tags: false // Ensure tags is set to false
        });
    });
        // Initialize the datetime picker

        // Initialize the datetime picker
        // flatpickr(".datetimepicker", {
        //     enableTime: true,
        //     dateFormat: "Y-m-d",
        //     // Additional options if needed
        //     // dateFormat: "Y-m-d H:i",
        // });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>


// $(document).ready(function() {
//         $('#pet_category').change(function() {
//             var selectedText = $(this).find("option:selected").text();
//             $('#pet_category_text').val(selectedText);
//         });
//     });

        function getPetDetails(){
            var pet =  $('#pet').val();


            if(pet!=''){
            $.ajax({
                url: "{{ route('ajax.getPetDetails') }}",
                method: "GET", // or "POST" for a POST request
                data: {
                    "pet": pet,
                },
                success: function(response) {
                  //alert(response.id);
                    document.getElementById('pet_id').value = response.pet_id;
                    document.getElementById('pet_name').value = response.name;
                    document.getElementById('age').value = response.age_at_register;
                    document.getElementById('weight').value = response.weight;
                    document.getElementById('colour').value = response.color;
                    document.getElementById('date_of_birth').value = response.date_of_birth;
                    //document.getElementById('gender').value = response.gender;
                    $('#gender').select2();
                    $('#gender').val(response.gender).trigger('change');
                    document.getElementById('remarks').value = response.remarks;
                   // document.getElementById('pet_category').value = response.pet_category;
                    $('#pet_category').select2();
                    $('#pet_category').val(response.pet_category).trigger('change');

                    //document.getElementById('breed').value = response.pet_breed;
                    $('#breed').select2();
                    $('#breed').val(response.pet_breed).trigger('change');

                    document.getElementById('owner_name').value = response.owner_name;
                    document.getElementById('owner_contact').value = response.owner_contact;
                    const ownerWhatsappEl = document.getElementById('owner_whatsapp');
                    if (ownerWhatsappEl) {
                        ownerWhatsappEl.value = response.owner_whatsapp ? response.owner_whatsapp : '+94 ';
                    }
                    document.getElementById('address').value = response.owner_address;

                    fetchVaccinations(response.pet_category);

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
            }
        }

        function setSelectedValue(selectObj, valueToSet) {
            for (var i = 0; i < selectObj.options.length; i++) {
                if (selectObj.options[i].text== valueToSet) {
                    selectObj.options[i].selected = true;
                    return;
                }
            }
        }

        $('#pet').change(function() {
            getPetDetails();
        });


    </script>

<script>

//////////////////////////start prescription//////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for the initial select elements
    initializeSelect2('.select2');

    document.getElementById('addPrescription').addEventListener('click', function() {
        let original = document.querySelector('.prescription-details');
        let clone = original.cloneNode(true);
        clone.classList.remove('base-prescription-row');

        // Clear input values in the cloned node
        let clonedInputs = clone.querySelectorAll('input');
        clonedInputs.forEach(function(input) {
            input.value = '';
        });

        // Clear previous values and re-initialize Select2
        let clonedSelects = clone.querySelectorAll('select');
        clonedSelects.forEach(function(select) {
            $(select).val(null).trigger('change'); // Clear previous values
            $(select).next('.select2-container').remove(); // Remove the previous Select2 container
            initializeSelect2(select); // Re-initialize Select2
        });

        // Replace plus button with remove button
        let buttonContainer = clone.querySelector('.prescription-actions');
        if (buttonContainer) {
            buttonContainer.innerHTML = '';

            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-prescription-row';
            removeButton.innerHTML = '<span class="icon text-white-50"><i class="fa fa-trash"></i></span>';
            buttonContainer.appendChild(removeButton);
        }

        document.getElementById('prescription').appendChild(clone);
    });

    document.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.remove-prescription-row');
        if (removeBtn) {
            const row = removeBtn.closest('.previous-prescription-details, .prescription-details');
            if (row?.id && row.id.startsWith('prescription-')) {
                row.remove();
            } else if (row?.classList.contains('base-prescription-row')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
        }
    });
});

$(document).ready(function() {
    // Initialize Select2 for existing select elements on page load
    initializeSelect2('.select2');
});



//////////////////////////end prescription//////////////////////////////////
////////////////////////Start Vaccination Script ////////////////////
document.addEventListener('DOMContentLoaded', function() {
    let rowCounter = 1; // Counter to keep track of row numbers

    // Function to initialize datetimepicker (Flatpickr)
    function initializeDateTimePicker(element) {
        flatpickr(element, {
            dateFormat: 'Y-m-d'
        });
    }

    // Initialize Select2 and datetimepicker for the initial select elements
    initializeSelect2('.select2');
    initializeDateTimePicker('.datetimepicker');

    document.getElementById('addVaccination').addEventListener('click', function() {
        let original = document.querySelector('.vaccination-details');
        let clone = original.cloneNode(true);
        clone.classList.remove('base-vaccination-row');

        rowCounter++; // Increment the row counter for each new row

        // Clear input values in the cloned node
        let clonedInputs = clone.querySelectorAll('input');
        clonedInputs.forEach(function(input) {
            input.value = '';
        });

        // Clear previous values and re-initialize Select2
        let clonedSelects = clone.querySelectorAll('select');
        clonedSelects.forEach(function(select) {
            $(select).val(null).trigger('change'); // Clear previous values
            $(select).next('.select2-container').remove(); // Remove the previous Select2 container
            initializeSelect2(select); // Re-initialize Select2
        });

        // Re-initialize datetimepicker for the cloned inputs
        let clonedDateTimePickers = clone.querySelectorAll('.datetimepicker');
        clonedDateTimePickers.forEach(function(dateTimePicker) {
            flatpickr(dateTimePicker, {
                dateFormat: 'Y-m-d'
            });
        });

        // Replace plus button with remove button
        let buttonContainer = clone.querySelector('.vaccination-actions');
        if (buttonContainer) {
            buttonContainer.innerHTML = '';

            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-vaccination-row';
            removeButton.innerHTML = '<span class="icon text-white-50"><i class="fa fa-trash"></i></span>';
            buttonContainer.appendChild(removeButton);
        }

        document.getElementById('vaccination').appendChild(clone);
    });

    // Add click event listener to remove buttons for existing vaccinations
    document.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.remove-vaccination-row');
        if (removeBtn) {
            const row = removeBtn.closest('.previous-vaccination-details, .vaccination-details');
            if (row?.id && row.id.startsWith('vaccination-')) {
                row.remove();
            } else if (row?.querySelector('#addVaccination')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
            if (window.recalculateBillingTotals) {
                window.recalculateBillingTotals();
            }
        }
    });
});

$(document).ready(function() {
    // Initialize Select2 and datetimepicker for existing select elements on page load
    initializeSelect2('.select2');
    initializeDateTimePicker('.datetimepicker');
});


//////////////////////////end Vaccination//////////////////////////////////

////////////////////////Start Billing Script ////////////////////
document.addEventListener('DOMContentLoaded', function() {
    function updateTotal(row) {
        var qty = parseFloat(row.find('input[name="billing_qty[]"]').val()) || 0;
        var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
        var discountPercentage = parseFloat(row.find('input[name="tax[]"]').val()) || 0;

        var discountAmount = (qty * unitPrice) * (discountPercentage / 100);
        var total = (qty * unitPrice) - discountAmount;

        row.find('input[name="last_price[]"]').val(total.toFixed(2));
    }

    // Function to update the grand total
    function getVaccinationTotal() {
        var vaccinationTotal = 0;
        $('select[name="vaccine_name[]"]').each(function() {
            var price = parseFloat($(this).find('option:selected').data('price'));
            if (!isNaN(price)) {
                vaccinationTotal += price;
            }
        });

        return vaccinationTotal;
    }

    function updateGrandTotal() {
        var netTotal = 0;
        $('input[name="last_price[]"]').each(function() {
            netTotal += parseFloat($(this).val()) || 0;
        });

        netTotal += getVaccinationTotal();

        var discount = parseFloat($('#discount').val()) || 0;
        var grandTotal = netTotal - discount;

        $('#net_total').val(netTotal.toFixed(2));
        $('#grand_total').val(grandTotal.toFixed(2));
    }

    window.recalculateBillingTotals = updateGrandTotal;

    function attachServiceChangeHandler($select) {
        $select.off('change.service').on('change.service', function() {
            var selectedServiceId = $(this).val();
            var parentRow = $(this).closest('.service-row, .form-group.row');

            if (selectedServiceId) {
                $.ajax({
                    url: '/get-service-price/' + selectedServiceId,
                    method: 'GET',
                    success: function(response) {
                        if (response.price) {
                            parentRow.find('input[name="unit_price[]"]').val(response.price);
                            parentRow.find('input[name="billing_qty[]"]').val(1);
                            parentRow.find('input[name="tax[]"]').val(0);
                            updateTotal(parentRow);
                            updateGrandTotal();
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching service price:', error);
                    }
                });
            } else {
                parentRow.find('input[name="unit_price[]"]').val('');
                parentRow.find('input[name="billing_qty[]"]').val('');
                parentRow.find('input[name="tax[]"]').val('');
                updateTotal(parentRow);
                updateGrandTotal();
            }
        });
    }

    function initializeServiceSelects(context) {
        var $context = context ? $(context) : $(document);
        var $serviceSelects = $context.find('select[name="service_name[]"]');

        $serviceSelects.each(function() {
            var $select = $(this);
            $select.next('.select2-container').remove();
            initializeSelect2($select);
            attachServiceChangeHandler($select);
        });
    }

    initializeServiceSelects(document);

    $(document).on('change', 'select[name="vaccine_name[]"]', function() {
        updateGrandTotal();
    });

    document.getElementById('addService').addEventListener('click', function() {
        let original = document.querySelector('.service-detail');
        let clone = original.cloneNode(true);
        clone.classList.remove('base-service-row');

        // Clear input values in the cloned node
        let clonedInputs = clone.querySelectorAll('input');
        clonedInputs.forEach(function(input) {
            input.value = '';
        });

        initializeServiceSelects(clone);

        // Replace plus button with remove button
        let buttonContainer = clone.querySelector('.service-actions');
        if (buttonContainer) {
            buttonContainer.innerHTML = '';

            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm btn-icon-split mt-0 mb-2 remove-service-row';
            removeButton.innerHTML = '<span class="icon text-white-50"><i class="fa fa-trash"></i></span>';
            buttonContainer.appendChild(removeButton);
        }

        document.getElementById('serviceDetails').appendChild(clone);
    });

    // Attach change event to update total on quantity, discount, and unit price change
    document.addEventListener('input', function(event) {
        if (event.target.matches('input[name="billing_qty[]"], input[name="tax[]"], input[name="unit_price[]"]')) {
            var row = event.target.closest('.service-row, .form-group.row');
            updateTotal($(row));
            updateGrandTotal();
        }
    });

    // Update grand total when overall discount changes
    $('#discount').on('input', function() {
        updateGrandTotal();
    });

    document.addEventListener('click', function(event) {
        const existingServiceRemove = event.target.closest('.removeBillItem');
        if (existingServiceRemove) {
            const row = existingServiceRemove.closest('.form-group.row');
            row?.remove();
            updateGrandTotal();
        }

        const removeServiceRow = event.target.closest('.remove-service-row');
        if (removeServiceRow) {
            const row = removeServiceRow.closest('.service-detail');
            if (row?.querySelector('#addService')) {
                row.querySelectorAll('input').forEach(input => input.value = '');
                $(row).find('select').val(null).trigger('change');
            } else {
                row?.remove();
            }
            updateGrandTotal();
        }
    });

    // Initialize existing rows for edit mode
    document.querySelectorAll('.service-detail').forEach(function(row) {
        initializeSelect2($(row).find('select'));
        attachServiceChangeHandler($(row).find('select[name="service_name[]"]'));
        updateTotal($(row));
    });

    updateGrandTotal();
});

$(document).ready(function() {
    // Initialize Select2 for existing select element on page load
    initializeSelect2('.select2');
});

///////////////////////end Services script //////////////////////////

function fetchVaccinations(petCategoryIds) {

//alert(petCategoryIds);
$.ajax({
    url: "{{ route('ajax.getVaccinationsByPetCategory') }}",
    method: "GET",
    data: {
        "pet_category": petCategoryIds,
    },
    success: function(vaccinations) {
       // alert(vaccinations);
        const vaccineSelects = $('select[name="vaccine_name[]"]');
        vaccineSelects.each(function() {
            const $select = $(this);
            $select.empty();
            $select.append('<option value="" selected="selected"></option>');
            $.each(vaccinations, function(key, value) {
                const option = $('<option></option>')
                    .val(value.id)
                    .attr('data-price', value.price || 0)
                    .text(value.name);
                $select.append(option);
            });
            $select.val(null).trigger('change');
        });

        if (window.recalculateBillingTotals) {
            window.recalculateBillingTotals();
        }
    },
    error: function(xhr, status, error) {
       // alert(error);
        console.log(error);
    }
});
}


$(document).ready(function() {
    // Event listener for radio buttons
    $('input[name="next_treatment_weeks"]').on('change', function() {
        var selectedValue = $(this).val();
        var currentDate = new Date(); // Get current date

        // Check the selected value and add weeks accordingly
        if (selectedValue.endsWith('W')) {
            var weeksToAdd = parseInt(selectedValue); // Extract the number of weeks
            currentDate.setDate(currentDate.getDate() + (weeksToAdd * 7)); // Add weeks to the current date
        } else if (selectedValue.endsWith('Y')) {
            var yearsToAdd = parseInt(selectedValue); // Extract the number of years
            currentDate.setFullYear(currentDate.getFullYear() + yearsToAdd); // Add years to the current date
        }

        // Format the new date in YYYY-MM-DD
        var newDate = currentDate.toISOString().split('T')[0];

        // Set the new date in the datetimepicker input field
        $('#next_treatment_date').val(newDate);
    });

    // Event listener for each group of radio buttons related to next vaccination weeks
    $(document).on('change', 'select[name^="next_vacc_weeks[]"]', function() {
            var selectedValue = $(this).val();
            var currentDate = new Date(); // Get current date

            if (selectedValue.endsWith('W')) {
                var weeksToAdd = parseInt(selectedValue); // Extract the number of weeks (e.g., "1W" becomes 1)
                currentDate.setDate(currentDate.getDate() + (weeksToAdd * 7)); // Add weeks to the current date
            } else if(selectedValue.endsWith('Y')) {
                var yearsToAdd = parseInt(selectedValue); // Extract the number of weeks (e.g., "1W" becomes 1)
                currentDate.setFullYear(currentDate.getFullYear() + yearsToAdd);
            }

            // Format the new date in YYYY-MM-DD
            var newDate = currentDate.toISOString().split('T')[0];

            // Set the new date in the corresponding 'vacc_duration[]' input field
            $(this).closest('.form-group.row').find('input[name="vacc_duration[]"]').val(newDate);
        });


});
</script>
@stop
