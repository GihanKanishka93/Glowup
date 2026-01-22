@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
        Update Bill</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">

                    </div>
                </div>


                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
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

                                    <label class="col-sm-12" for="reffered_ward">Doctor:</label>
                                    <div class="col-sm-12">
                                        <select name="doctor" id="doctor"
                                            class="select2 form-control @error('doctor') is-invalid @enderror">
                                            <option value="" selected=""></option>
                                            @foreach ($doctors as $item)
                                            <option value="{{ $item->id }}" @if(old('doctor', $treatment->doctor_id) == $item->id) selected @endif>
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
                                <input type="text" class="form-control @error('pet_id') is-invalid @enderror" id="pet_id"
                                    name="pet_id" value="{{ old('pet_id', $treatment->pet->pet_id) }}" placeholder="">
                                @error('pet_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Name: </label>
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
                            <div class="col-sm-10">
                                <select name="pet_category" id="pet_category" class="select2 form-control @error('pet_category') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach ($petcategory as $item)
                                        <option value="{{ $item->id }}" @if(old('pet_category', $treatment->pet->pet_category) == $item->id) selected @endif>
                                            {{ $item->name }}
                                        </option>
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
                            <div class="col-sm-10">
                              <select name="breed" id="breed"  class="select2 form-control @error('breed') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($breed  as $item)
                                    <option value="{{ $item->id }}" @if(old('breed', $treatment->pet->pet_breed) == $item->id) selected @endif>{{ $item->name }}</option>
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
                                <label class="col-sm-12">Gender: <i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <select name="gender" id="" class="select2 form-control  @error('gender') is-invalid @enderror">
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
                                    name="owner_name" value="{{ old('owner_name', $treatment->pet->owner_name) }}" placeholder="Name">
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
                            <div class="col-sm-8">
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
                            <div class="col-sm-8">
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

                            <label class="col-sm-2">Trement Remarks: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control   @error('remarks_t') is-invalid @enderror" id="remarks_t"
                                name="remarks_t" >{{ old('remarks_t', $treatment->remarks) }}</textarea>
                                @error('remarks_t')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Prescription</legend>
                        <br/>
                        <div id="prescription" class="form-group row">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Drug Name
                                </div>
                                <div class="col-md-2">
                                    dosage
                                </div>
                                <div class="col-md-3">
                                    duration
                                </div>

                                <div class="col-md-1">

                                </div>

                            </div>

                            @foreach ($prescriptions as $prescription)
                                <div class="previous-prescription-details form-group row" id="prescription-{{ $prescription->id }}">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="drug_name[]"  value="{{ $prescription->drug_name }}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="dosage[]" value="{{ $prescription->dosage }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="duration[]" value="{{ $prescription->duration }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm mt-0 mb-2 removePerson"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="prescription-details col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Drug Name" name="drug_name[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="dosage[]" placeholder="dosage">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="duration[]" placeholder="duration">
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
                                <div class="col-md-2">
                                    Duration
                                </div>

                                <div class="col-md-1">

                                </div>

                            </div>
                            @foreach ($vaccinationInfo as $vaccinationInfo)
                                <div class="previous-prescription-details form-group row" id="prescription-{{ $prescription->id }}">
                                    <div class="col-md-4">

                                        <select name="vaccine_name[]" id="vaccine_name"
                                        class="select2 form-control vaccine_item @error('vaccine_name') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($vaccine as $item)
                                            <option value="{{ $item->id }}"  @if($vaccinationInfo->vaccine_id == $item->id) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="vacc_duration[]" value="{{ $vaccinationInfo->duration }}" readonly>
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm mt-0 mb-2 removePerson"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="vaccination-details col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        {{-- <input type="text" class="form-control" placeholder="" name="vaccine_name[]"> --}}
                                        <select name="vaccine_name[]" id="vaccine_name"
                                        class="select2 form-control vaccine_item @error('vaccine_name') is-invalid @enderror">
                                        <option value="" selected="selected"></option>
                                        @foreach ($vaccine as $item)
                                            <option value="{{ $item->id }}"  @if(old('vaccine_name')==$item->name) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="vacc_duration[]" placeholder="">
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
                                <label class="col-sm-12">Next Treatment Date: <i class="text-danger">*</i></label>
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

                        <div id="personDetails" class="form-group row">
                            @foreach ($billItems as $item)
                                <div class="prevous-bill-details form-group row" id="bill-item-{{ $item->id }}">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="service_name[]" placeholder="Service Name" value="{{ $item->item_name }}" readonly>
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
                                        <input type="text" class="form-control" name="last_price[]" placeholder="Total" value="{{ ($item->unit_price *  $item->item_qty)  - (($item->unit_price *  $item->item_qty) * ( $item->tax /100))  }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm removeBillItem" data-id="{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <div class="person-detail col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Service Name" name="service_name[]">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" name="billing_qty[]" placeholder="Qty">
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="unit_price[]" placeholder="Unit Price">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="tax[]" placeholder="Discount">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="last_price[]" placeholder="Total">
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addPerson">
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
                                    <input type="text" class="form-control" name="discount" id="discount" >
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



                    </div>


                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('billing.index') }}" class="btn btn-info">
                                <span class="text">Cancel</span>
                            </a>
                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>

                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save & Print</span>
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
        // Initialize the datetime picker

        // Initialize the datetime picker
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Additional options if needed
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@stop
