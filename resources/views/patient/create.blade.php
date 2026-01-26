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
                <form action="{{ route('patient.store') }}" method="post">
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
                                    <option value="1" @if(old('gender') == 1) @selected(true) @endif>Male</option>
                                    <option value="2" @if(old('gender') == 2) @selected(true) @endif>Female</option>
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
                                <input type="date" class="form-control   @error('date_of_birth') is-invalid @enderror"
                                    id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                    max="{{ date('Y-m-d') }}" placeholder="Date of bith">
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




                        <hr>
                        <legend>Contact Information</legend>


                        <div class="form-group row">
                            <label class="col-sm-2" for="nic">National ID: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('nic') is-invalid @enderror" id="nic"
                                    name="nic" value="{{ old('nic') }}" placeholder="NIC">
                                @error('nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2" for="mobile_number">Mobile Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('mobile_number') is-invalid @enderror"
                                    id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}"
                                    placeholder=" ">
                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="whatsapp_number">WhatsApp: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('whatsapp_number') is-invalid @enderror"
                                    id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', '+94 ') }}"
                                    placeholder=" ">
                                @error('whatsapp_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="owner_contact2">Address: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}" placeholder=" ">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="email">Email: </label>
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





                        <hr>
                        <legend>Clinical Information</legend>

                        <div class="form-group row">
                            <label class="col-sm-2">Medical History: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control @error('basic_ilness') is-invalid @enderror"
                                    name="basic_ilness"
                                    placeholder="Existing medical conditions...">{{ old('basic_ilness') }}</textarea>
                                @error('basic_ilness')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Surgical History: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control @error('surgical_history') is-invalid @enderror"
                                    name="surgical_history"
                                    placeholder="Previous surgeries...">{{ old('surgical_history') }}</textarea>
                                @error('surgical_history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Allergies: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control @error('allegics') is-invalid @enderror" name="allegics"
                                    placeholder="Known allergies...">{{ old('allegics') }}</textarea>
                                @error('allegics')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">General Remarks: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks"
                                    placeholder="Any other notes...">{{ old('remarks') }}</textarea>
                                @error('remarks')
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
                            <a href="{{ route('patient.index') }}" class="btn btn-info">
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
    function change_gu(gu) {
        if (gu == 'o') {
            $('.guardian').show();
        } else {
            $('.guardian').hide();
        }
    }
    change_gu(gu);

    $(document).ready(function () {
        // Hide the text box on page load
        $('#other_text').hide().prop('disabled', true);

        $('#tmOther').change(function () {
            var otherText = $('#other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });

    $(document).ready(function () {
        // Hide the text box on page load
        $('#fs-other_text').hide().prop('disabled', true);

        $('#fsOther').change(function () {
            var otherText = $('#fs-other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });

    $(document).ready(function () {
        // Hide the text box on page load
        $('#wdur-other_text').hide().prop('disabled', true);

        $('#wduOther').change(function () {
            var otherText = $('#wdur-other_text');

            otherText.toggle(this.checked).prop('disabled', !this.checked);

            if (!this.checked) {
                otherText.val('');
            }
        });
    });
</script>
@stop