@extends('layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Edit {{ $pet->name }}</h1>
{{-- @if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif --}}
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">

                    </div>
                    <div></div>
                </div>
                <form method="post" action="{{ route('pet.update',$pet->id) }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">PatientID: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('pet_id') is-invalid @enderror" id="pet_id" name="pet_id"
                                value="{{ $pet->pet_id }}" @cannot('petid-edit') readonly @endcannot>
                                @error('pet_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ $pet->name }}" placeholder="Name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Gender: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror">
                                    <option value=""></option>
                                    <option value="1" @if($pet->gender == 1) @selected(true) @endif  >Male</option>
                                    <option value="2" @if($pet->gender == 2) @selected(true) @endif >Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Date of Birth: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control   @error('date_of_birth') is-invalid @enderror" id="date_of_birth"
                                    name="date_of_birth" value="{{ $pet->date_of_birth }}" placeholder="Date of bith">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Age at Register: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('age') is-invalid @enderror" id="age"
                                    name="age" value="{{ $pet->age_at_register }}">
                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="pet-category">Pet Type/ Category: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                              <select name="pet_category" id="pet_category"  class="form-control @error('pet_category') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($petcategory  as $item)
                                    <option value="{{ $item->id }}" @if($pet->pet_category  == $item->id) @selected(true) @endif >{{ $item->name }}</option>
                                @endforeach
                              </select>
                                @error('pet_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="breed">Breed: </label>
                            <div class="col-sm-8">
                              <select name="breed" id="breed"  class="form-control @error('breed') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($breed  as $item)
                                    <option value="{{ $item->id }}" @if($pet->pet_breed == $item->id) @selected(true) @endif >{{ $item->name }}</option>
                                @endforeach
                              </select>
                                @error('breed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Weight">Weight: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ $pet->weight }}" placeholder=" ">
                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Colour">Colour: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('colour') is-invalid @enderror" id="colour"
                                name="colour" value="{{ $pet->color }}" placeholder=" ">
                                @error('colour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-2" for="Colour">Remarks: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control   @error('remarks') is-invalid @enderror" id="remarks"
                                name="remarks" >{{ $pet->remarks }}</textarea>
                                @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <hr>
                        <legend>Owner Information</legend>
                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_name">Name: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_name') is-invalid @enderror" id="owner_name"
                                name="owner_name" value="{{ $pet->owner_name }}" placeholder="Name">
                                @error('owner_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_nic">NIC: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_nic') is-invalid @enderror" id="owner_nic"
                                name="owner_nic" value="{{ $pet->owner_nic }}" placeholder="NIC">
                                @error('owner_nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_contact">Contact Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_contact') is-invalid @enderror" id="owner_contact"
                                name="owner_contact" value="{{ $pet->owner_contact }}" placeholder=" ">
                                @error('owner_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_contact2">Address: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ $pet->owner_address }}" placeholder=" ">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_contact2">Email: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_email') is-invalid @enderror" id="owner_email"
                                name="owner_email" value="{{ $pet->owner_email }}" placeholder=" ">
                                @error('owner_email')
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
                            <a href="{{ route('pet.index') }}" class="btn btn-info">
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
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.css') }}">
@stop

@section('third_party_scripts')
<script src="{{ asset('plugin/select2/select2.js') }}"></script>
    <script>
        $('.select2').select2();

       function change_gu(gu){
        if(gu=='o'){
            $('.guardian').show();
        }else{
            $('.guardian').hide();
        }
       }
       var gu = $('input[name="guardian"]:checked').val();
        change_gu(gu);


        $(document).ready(function() {
        // Hide the text box on page load
       // $('#other_text').hide().prop('disabled', true);

        $('#other').change(function() {
            var otherText = $('#other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });

    $(document).ready(function() {
        // Hide the text box on page load
       // $('#fs-other_text').hide().prop('disabled', true);

        $('#fsother').change(function() {
            var otherText = $('#fs-other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });

    $(document).ready(function() {
        // Hide the text box on page load
        //$('#wdur-other_text').hide().prop('disabled', true);

        $('#wdurother').change(function() {
            var otherText = $('#wdur-other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });
    </script>
@stop
