@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Register New Client</h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <div class="dropdown no-arrow show">
                    </div>
                </div>
                <form action="{{ route('pet.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">Client Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Name">
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
                                <select name="gender" id="" class="form-control  @error('gender') is-invalid @enderror">
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
                        <div class="form-group row">
                            <label class="col-sm-2">Date of Birth: </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control   @error('date_of_birth') is-invalid @enderror" id="date_of_birth"
                                    name="date_of_birth" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" placeholder="Date of bith">
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Age : </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('age') is-invalid @enderror" id="age"
                                    name="age" value="{{ old('age') }}" placeholder="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="pet-category">Skin Type: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                              <select name="pet_category" id="pet_category"  class="form-control @error('pet_category') is-invalid @enderror">
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

                        <div class="form-group row">
                            <label class="col-sm-2" for="breed">Skin Concern: </label>
                            <div class="col-sm-8">
                              <select name="breed" id="breed"  class="form-control @error('breed') is-invalid @enderror">
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

                        <div class="form-group row">
                            <label class="col-sm-2" for="Weight">Weight: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ old('weight') }}" placeholder=" ">
                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Colour">Skin Tone/Color: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('colour') is-invalid @enderror" id="colour"
                                name="colour" value="{{ old('colour') }}" placeholder=" ">
                                @error('colour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Colour">Remarks: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control   @error('remarks') is-invalid @enderror" id="remarks"
                                name="remarks" ></textarea>
                                @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <hr>
                        <legend>Contact Information</legend>
                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_name">Primary Contact Name: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_name') is-invalid @enderror" id="owner_name"
                                name="owner_name" value="{{ old('owner_name') }}" placeholder="Name">
                                @error('owner_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_nic">National ID: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_nic') is-invalid @enderror" id="owner_nic"
                                name="owner_nic" value="{{ old('owner_nic') }}" placeholder="NIC">
                                @error('owner_nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_contact">Mobile Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('owner_contact') is-invalid @enderror" id="owner_contact"
                                name="owner_contact" value="{{ old('owner_contact') }}" placeholder=" ">
                                @error('owner_contact')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2" for="owner_whatsapp">WhatsApp: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control   @error('owner_whatsapp') is-invalid @enderror" id="owner_whatsapp"
                            name="owner_whatsapp" value="{{ old('owner_whatsapp', '+94 ') }}" placeholder=" ">
                            @error('owner_whatsapp')
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
                                name="address" value="{{ old('address') }}" placeholder=" ">
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
                                name="owner_email" value="{{ old('owner_email') }}" placeholder=" ">
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
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
@stop

@section('third_party_scripts')
    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
        var gu = $('input[name="guardian"]:checked').val();
       function change_gu(gu){
        if(gu=='o'){
            $('.guardian').show();
        }else{
            $('.guardian').hide();
        }
       }
       change_gu(gu);

       $(document).ready(function() {
        // Hide the text box on page load
        $('#other_text').hide().prop('disabled', true);

        $('#tmOther').change(function() {
            var otherText = $('#other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });

    $(document).ready(function() {
        // Hide the text box on page load
        $('#fs-other_text').hide().prop('disabled', true);

        $('#fsOther').change(function() {
            var otherText = $('#fs-other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });

    $(document).ready(function() {
        // Hide the text box on page load
        $('#wdur-other_text').hide().prop('disabled', true);

        $('#wduOther').change(function() {
            var otherText = $('#wdur-other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });
    </script>
@stop
