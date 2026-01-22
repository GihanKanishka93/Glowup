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
    background-image: url("../img/background.jpg");
    background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover; /* Resize the background image to cover the entire container */
  color: #fff !important;
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
</style>
<div class="row align-items-center">
    <div class="col">
        <h1 class="h3 mb-2 text-gray-800">New Bill</h1>
    </div>
    <div class="col-auto bill-history" style="display: none;">
        <a href="#" target="_blank" class="btn btn-md btn-primary btn-icon-split ml-2 medical-history-btn" data-template="{{ route('medical-history.show', ['id' => 'PLACEHOLDER']) }}">
            <span class="icon text-white-50">
                <i class="fa fa-file"></i>
            </span>
            <span class="text">Medical History</span>
        </a>
    </div>
</div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">

                    </div>
                </div>


                <form action="{{ route('billing.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Pet: <i class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <select style="width: 100%" name="pet" id="pet"
                                        class="select2 form-control  @error('pet') is-invalid @enderror" >
                                        <option value=""></option>
                                        @foreach ($pets as $item)
                                            <option value="{{ $item->id }}" @selected(old('pet'))>
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
                                                <option value="{{ $item->id }}"  @if( Auth::user()->doc_id ==$item->id) @selected(true) @endif>
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
                                <label class="col-sm-12">Pet Id: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('pet_id') is-invalid @enderror" id="pet_id"
                                    name="pet_id" value="{{ old('pet_id') }}" placeholder="" readonly>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Name: <i class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('pet_name') is-invalid @enderror" id="pet_name"
                                        name="pet_name" value="{{ old('pet_name') }}" placeholder="">
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
                                            name="date_of_birth" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" placeholder="Date of bith">
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
                                        name="age" value="{{ old('age') }}" placeholder="">
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
                                <label class="col-sm-12" for="pet-category">Pet Type/ Category: </label>
                            <div class="col-sm-12">
                              <select name="pet_category" id="pet_category"  class="select2 form-control @error('pet_category') is-invalid @enderror" onchange="fetchVaccinations(this.value);">
                                <option value=""></option>
                                @foreach ($petcategory  as $item)
                                    <option value="{{ $item->id }}" @if(old('pet_category')==$item->id) @selected(true) @endif >{{ $item->name }}</option>
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
                                    <option value="{{ $item->id }}" @if(old('breed')==$item->id) @selected(true) @endif >{{ $item->name }}</option>
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
                                    <option value="1" @if(old('gender')==1) @selected(true) @endif  >Male</option>
                                    <option value="2" @if(old('gender')==2) @selected(true) @endif >Female</option>
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
                                name="weight" value="{{ old('weight') }}" placeholder=" ">
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
                                name="colour" value="{{ old('colour') }}" placeholder=" ">
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
                                        name="remarks" ></textarea>
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
                                    name="owner_name" value="{{ old('owner_name') }}" placeholder="">
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
                                name="owner_contact" value="{{ old('owner_contact') }}" placeholder=" ">
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
                                    name="owner_whatsapp" value="{{ old('owner_whatsapp', '+94 ') }}" placeholder=" ">
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
                                name="address" >{{ old('address') }}</textarea>
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

                            <label class="col-sm-4">History /Complaint: </label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('history') is-invalid @enderror" id="history"
                                name="history" ></textarea>
                                @error('history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-4">Clinical Observation: </label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('observation') is-invalid @enderror" id="observation"
                                name="observation" ></textarea>
                                @error('observation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-4">Treatment Remarks: </label>
                            <div class="col-sm-12">
                                <textarea class="form-control   @error('remarks_t') is-invalid @enderror" id="remarks_t"
                                name="remarks_t" ></textarea>
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
                            <div class="form-group row">
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
                            <div class="prescription-details col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        {{-- <input type="text" class="form-control drug_name" placeholder="Enter drug name" name="drug_name[]"> --}}
                                        <select name="drug_name[]" id="drug_name"
                                        class="select2 form-control drug_items @error('drug_name') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($drugs as $item)
                                            <option value="{{ $item->name }}"  @if(old('drug_name')==$item->name) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        {{-- <input type="text" class="form-control" name="dosage[]" placeholder=""> --}}
                                        <select name="dosage[]" id="dosage"
                                        class="select2 form-control dosage_types @error('dosage') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($dosagetypes as $item)
                                            <option value="{{ $item->name }}"  @if(old('dosage')==$item->name) @selected(true) @endif>
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
                                        {{-- <input type="text" class="form-control" name="duration[]" placeholder=""> --}}
                                        <select name="duration[]" id="duration"
                                        class="select2 form-control duration_types @error('duration') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($durationtypes as $item)
                                            <option value="{{ $item->name }}"  @if(old('duration')==$item->name) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addPrescription">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <br>

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

                                <div class="col-md-1">

                                </div>

                            </div>
                            <div class="vaccination-details col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        {{-- <input type="text" class="form-control" placeholder="" name="vaccine_name[]"> --}}
                                        <select name="vaccine_name[]" id="vaccine_name"
                                        class="select2 form-control vaccine_item @error('vaccine_name') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        {{-- @foreach ($vaccine as $item)
                                            <option value="{{ $item->id }}"  @if(old('vaccine_name')==$item->name) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control datetimepicker" name="vacc_duration[]" value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addVaccination">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Next Treatment Date: </label>
                            <div class="col-sm-12">
                                <input type="text"
                                    class="form-control datetimepicker  @error('next_treatment_date') is-invalid @enderror"
                                    id="next_treatment_date" name="next_treatment_date" step="60"
                                    value="{{ date('Y-m-d') }}">
                                @error('next_treatment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col"></div>
                            <div class="col">
                                <label class="col-sm-12">Billing Date: </label>
                                <div class="col-sm-12">
                                    <input type="text"
                                        class="form-control datetimepicker  @error('billing_date') is-invalid @enderror"
                                        id="billing_date" name="billing_date" step="60" value="{{ Date('Y-m-d') }}">
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

                        <div id="serviceDetails" class="form-group row">
                            <div class="service-detail col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        {{-- <input type="text" class="form-control" placeholder="" name="service_name[]"> --}}
                                        <select name="service_name[]" id="service_name"
                                        class="select2 form-control service_item @error('service_name') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($services as $item)
                                            <option value="{{ $item->name }}"  @if(old('service_name')==$item->name) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
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

                                    <div class="col-md-1">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addService">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
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
                                    <input type="text" class="form-control" name="net_total" id="net_total" >
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
                                    <input type="number" class="form-control" name="discount" id="discount" value="0" >
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
                                    <input type="text" class="form-control" name="grand_total" id="grand_total" >
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
                                <button type="submit" name="action" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Save</span>
                                </button>

                                <button type="submit" name="action" value="save_and_print" class="btn btn-md btn-primary btn-icon-split ml-2">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Save & Print</span>
                                </button>
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
            var medicalHistoryBtn = document.querySelector('.medical-history-btn');
            var billHistoryDiv = document.querySelector('.bill-history');

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

                    if (response.id) {
                        var templateUrl = medicalHistoryBtn.getAttribute('data-template');
                        var url = templateUrl.replace('PLACEHOLDER', response.id);
                        medicalHistoryBtn.href = url;
                        billHistoryDiv.style.display = 'block';
                    } else {
                        billHistoryDiv.style.display = 'none';
                    }

                    // Fetch vaccination options based on pet category
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
    // Function to initialize Select2
    function initializeSelect2(element) {
        $(element).select2({
            tags: true,
            width: '100%',
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
    }

    // Initialize Select2 for the initial select element
    initializeSelect2('.select2');

    document.getElementById('addPrescription').addEventListener('click', function() {
        let original = document.querySelector('.prescription-details');
        let clone = original.cloneNode(true);

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
        let buttonContainer = clone.querySelector('.form-group.row');
        let plusButton = buttonContainer.querySelector('.btn.btn-sm.text-white.btn-icon-split');
        if (plusButton) {
            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm mt-0 mb-2 removePerson';
            removeButton.innerHTML = '<i class="fa fa-trash"></i>';
            plusButton.replaceWith(removeButton);

            // Add click event listener to the remove button
            removeButton.addEventListener('click', function() {
                clone.remove();
            });
        }

        document.getElementById('prescription').appendChild(clone);
    });
});

$(document).ready(function() {
    // Initialize Select2 for existing select element on page load
    initializeSelect2('.select2');
});


//////////////////////////end prescription//////////////////////////////////
////////////////////////Start Vaccination Script ////////////////////
document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize Select2
    function initializeSelect2(element) {
        $(element).select2({
            tags: true,
            width: '100%',
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
    }

    // Function to initialize datetimepicker (Flatpickr)
    function initializeDateTimePicker(element) {
        flatpickr(element, {
            dateFormat: 'Y-m-d'
        });
    }

    // Initialize Select2 for the initial select element
    initializeSelect2('.select2');
    initializeDateTimePicker('.datetimepicker');

    document.getElementById('addVaccination').addEventListener('click', function() {
        let original = document.querySelector('.vaccination-details');
        let clone = original.cloneNode(true);

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
        let buttonContainer = clone.querySelector('.form-group.row');
        let plusButton = buttonContainer.querySelector('.btn.btn-sm.text-white.btn-icon-split');
        if (plusButton) {
            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm mt-0 mb-2 removePerson';
            removeButton.innerHTML = '<i class="fa fa-trash"></i>';
            plusButton.replaceWith(removeButton);

            // Add click event listener to the remove button
            removeButton.addEventListener('click', function() {
                clone.remove();
            });
        }

        document.getElementById('vaccination').appendChild(clone);
    });
});

$(document).ready(function() {
    // Initialize Select2 for existing select element on page load
    initializeSelect2('.select2');
    initializeDateTimePicker('.datetimepicker');
});


//////////////////////////end Vaccination//////////////////////////////////

////////////////////////Start Billing Script ////////////////////
document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize Select2
    function initializeSelect2(element) {
        $(element).select2({
            tags: true,
            width: '100%',
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
        }).on('change', function(e) {
            // Fetch the selected service ID
            var selectedServiceId = $(this).val();
            var parentRow = $(this).closest('.form-group.row');
            if (selectedServiceId) {
                // Make an AJAX request to get the price
                $.ajax({
                    url: '/get-service-price/' + selectedServiceId,
                    method: 'GET',
                    success: function(response) {
                        if (response.price) {
                            // Update the unit price and quantity
                            parentRow.find('input[name="unit_price[]"]').val(response.price);
                            parentRow.find('input[name="billing_qty[]"]').val(1);
                            parentRow.find('input[name="tax[]"]').val(0); // Set discount to 0
                            updateTotal(parentRow);
                            updateGrandTotal();
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching service price:', error);
                    }
                });
            } else {
                // Clear the unit price, quantity, and discount if no service is selected
                parentRow.find('input[name="unit_price[]"]').val('');
                parentRow.find('input[name="billing_qty[]"]').val('');
                parentRow.find('input[name="tax[]"]').val('');
                updateTotal(parentRow);
                updateGrandTotal();
            }
        });
    }

    // Function to update the total for each row
    function updateTotal(row) {
        var qty = parseFloat(row.find('input[name="billing_qty[]"]').val()) || 0;
        var unitPrice = parseFloat(row.find('input[name="unit_price[]"]').val()) || 0;
        var discountPercentage = parseFloat(row.find('input[name="tax[]"]').val()) || 0;

        var discountAmount = (qty * unitPrice) * (discountPercentage / 100);
        var total = (qty * unitPrice) - discountAmount;

        row.find('input[name="last_price[]"]').val(total.toFixed(2));
    }

    // Function to update the grand total
    function updateGrandTotal() {
        var netTotal = 0;
        $('input[name="last_price[]"]').each(function() {
            netTotal += parseFloat($(this).val()) || 0;
        });

        var discount = parseFloat($('#discount').val()) || 0;
        var grandTotal = netTotal - discount;

        $('#net_total').val(netTotal.toFixed(2));
        $('#grand_total').val(grandTotal.toFixed(2));
    }

    // Initialize Select2 for the initial select element
    initializeSelect2('.select2');

    // Handle the addService button click event
    document.getElementById('addService').addEventListener('click', function() {
        let original = document.querySelector('.service-detail');
        let clone = original.cloneNode(true);

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
        let buttonContainer = clone.querySelector('.form-group.row');
        let plusButton = buttonContainer.querySelector('.btn.btn-sm.text-white.btn-icon-split');
        if (plusButton) {
            let removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm mt-0 mb-2 removePerson';
            removeButton.innerHTML = '<i class="fa fa-trash"></i>';
            plusButton.replaceWith(removeButton);

            // Add click event listener to the remove button
            removeButton.addEventListener('click', function() {
                clone.remove();
                updateGrandTotal();
            });
        }

        document.getElementById('serviceDetails').appendChild(clone);
    });

    // Attach change event to update total on quantity, discount, and unit price change
    document.addEventListener('input', function(event) {
        if (event.target.matches('input[name="billing_qty[]"], input[name="tax[]"], input[name="unit_price[]"]')) {
            var row = event.target.closest('.form-group.row');
            updateTotal($(row));
            updateGrandTotal();
        }
    });

    // Update grand total when overall discount changes
    $('#discount').on('input', function() {
        updateGrandTotal();
    });
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
            $('#vaccine_name').empty();
            $('#vaccine_name').append('<option value="" selected="selected"></option>');
            $.each(vaccinations, function(key, value) {
                $('#vaccine_name').append('<option value="'+ value.id +'">'+ value.name +'</option>');
            });
        },
        error: function(xhr, status, error) {
           // alert(error);
            console.log(error);
        }
    });
}

</script>
@stop
