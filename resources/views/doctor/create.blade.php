@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Add Doctor</h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <div class="dropdown no-arrow show">
                    </div>
                </div>
                <form action="{{ route('doctor.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">Name: <i class="text-danger">*</i></label>
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
                            <label class="col-sm-2">Designation : </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('designation') is-invalid @enderror" id="designation"
                                    name="designation" value="{{ old('designation') }}" placeholder="">
                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="address">Address: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('weight') is-invalid @enderror" id="address"
                                name="address" value="{{ old('weight') }}" placeholder=" ">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="contactno">Contact No: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('contactno') is-invalid @enderror" id="contactno"
                                name="contactno" value="{{ old('contactno') }}" placeholder=" ">
                                @error('contactno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_contact2">Email: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder=" ">
                                @error('email')
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
                            <a href="{{ route('doctor.index') }}" class="btn btn-info">
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
