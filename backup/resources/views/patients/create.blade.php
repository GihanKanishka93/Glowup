@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Register new Patient</h1>

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
                            <label class="col-sm-2">Date of Birth: <i class="text-danger">*</i></label>
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
                            <label class="col-sm-2">Age at Register : <i class="text-danger">*</i></label>
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
                            <label class="col-sm-2" for="Monthly Family Income">Monthly Family Income: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('monthly_family_income') is-invalid @enderror" id="monthly_family_income"
                                name="monthly_family_income" value="{{ old('monthly_family_income') }}" placeholder=" ">
                                @error('monthly_family_income')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Monthly Loan Deductions">Monthly Loan Deductions: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('monthly_loan_diductions') is-invalid @enderror" id="monthly_loan_diductions"
                                name="monthly_loan_diductions" value="{{ old('monthly_loan_diductions') }}" placeholder=" ">
                                @error('monthly_loan_diductions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Mode_of_Transportation">Mode of Transportation:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">
                                @php
                                $transportMode = ['Bus', 'Train', 'Three Wheel', 'Personal Vehicle', 'Other'];
                                @endphp

                                @foreach($transportMode as $tmode)
                                <div class="col-sm-3">
                                    <label for="tm{{ $tmode }}" class="label label-defalt">
                                        <input type="checkbox" name="transport_mode[]" id="tm{{ $tmode }}" value="{{ $tmode }}" class="form-check-input" @if(is_array(old('transport_mode')) && in_array($tmode, old('transport_mode'))) checked @endif>
                                        {{ $tmode }}
                                    </label>
                                </div>
                                @endforeach
                               <div class="col-sm-4">  <input type="text" class="form-control @error('other_text') is-invalid @enderror" id="other_text" name="transport_mode[]" value="{{ old('other_text') }}" placeholder=" " style="display: none;" disabled>
                               </div>


                                @error('transport_mode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Cost_of_travel_per_person">Cost of travel per person (LKR): </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('cost_of_travel') is-invalid @enderror" id="cost_of_travel"
                                name="cost_of_travel" value="{{ old('cost_of_travel') }}" placeholder=" ">
                                @error('cost_of_travel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Other_financial_support">Other financial support received:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">
                                @php
                                $financialSupport = ['Aswesuma', 'Government Allowance', 'Other'];
                                @endphp

                                @foreach($financialSupport as $fsupport)
                                <div class="col-sm-4">
                                    <label for="fs{{ $fsupport }}" class="label label-defalt">
                                        <input type="checkbox" name="financial_support[]" id="fs{{ $fsupport }}" value="{{ $fsupport }}" class="form-check-input" @if(is_array(old('financial_support')) && in_array($fsupport, old('financial_support'))) checked @endif>
                                        {{ $fsupport }}
                                    </label>
                                </div>
                                @endforeach

                               <div class="col-sm-5">  <input type="text" class="form-control" id="fs-other_text" name="financial_support[]" value="{{ old('other_text') }}" placeholder=" " style="display: none;" disabled>
                               </div>


                                @error('financial_support')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <legend>Address</legend>

                        <div class="form-group row">
                            <label class="col-sm-2" for="home">House Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('home') is-invalid @enderror" id="home"
                                name="home" value="{{ old('home') }}" placeholder="Home">
                                @error('home')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="street">Street: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('street') is-invalid @enderror" id="street"
                                name="street" value="{{ old('street') }}" placeholder="Street">
                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="city">City: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('city') is-invalid @enderror" id="city"
                                name="city" value="{{ old('city') }}" placeholder="city">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="district">District: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                              <select name="district" id="district"  class="form-control @error('district') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($districts  as $item)
                                    <option value="{{ $item->id }}" @if(old('district')==$item->id) @selected(true) @endif >{{ $item->name_en }}</option>
                                @endforeach
                              </select>
                                @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="distance_to_suwa_arana">Distance (km): </label>
                            <div class="col-sm-8">
                              <select name="distance_to_suwa_arana" id="distance_to_suwa_arana"  class="form-control @error('distance_to_suwa_arana') is-invalid @enderror">
                                <option value=""></option>
                                @for($i=5; $i<300; $i+=5)
                                <option value={{ $i }} @if(old('distance_to_suwa_arana')== $i) @selected(true) @endif>{{ $i-5 }} - {{ $i }} km</option>
                                @endfor
                              </select>
                                @error('distance_to_suwa_arana')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="Other_financial_support">Where do you Reside?:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">
                                @php
                                $wduReside = ['Rented', 'Own home', 'with Relatives', 'Other'];
                                @endphp

                                @foreach($wduReside as $wreside)
                                <div class="col-sm-4">
                                    <label for="wdu{{ $wreside }}" class="label label-defalt">
                                        <input type="checkbox" name="wdu_reside[]" id="wdu{{ $wreside }}" value="{{ $wreside }}" class="form-check-input" @if(is_array(old('wdu_reside')) && in_array($wreside, old('wdu_reside'))) checked @endif>
                                        {{ $wreside }}
                                    </label>
                                </div>
                                @endforeach
                               <div class="col-sm-4">  <input type="text" class="form-control" id="wdur-other_text" name="wdu_reside[]" value="{{ old('other_text') }}" placeholder=" " style="display: none;" disabled>
                               </div>


                                @error('financial_support')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <legend>Father</legend>
                        <div class="form-group row">
                            <label class="col-sm-2" for="father_name">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('father_name') is-invalid @enderror" id="father_name"
                                name="father_name" value="{{ old('father_name') }}" placeholder="Name">
                                @error('father_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_nic">NIC: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('father_nic') is-invalid @enderror" id="father_nic"
                                name="father_nic" value="{{ old('father_nic') }}" placeholder="NIC">
                                @error('father_nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_occupation">Occupation: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('father_occupation') is-invalid @enderror" id="father_occupation"
                                name="father_occupation" value="{{ old('father_occupation') }}" placeholder=" ">
                                @error('father_occupation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="father_contact">Contact Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('father_contact') is-invalid @enderror" id="father_contact"
                                name="father_contact" value="{{ old('father_contact') }}" placeholder=" ">
                                @error('father_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_contact">Contact Number 2: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('father_contact2') is-invalid @enderror" id="father_contact2"
                                name="father_contact2" value="{{ old('father_contact2') }}" placeholder=" ">
                                @error('father_contact2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <hr>
                        <legend>Mother</legend>
                        <div class="form-group row">
                            <label class="col-sm-2" for="mother_name">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('mother_name') is-invalid @enderror" id="mother_name"
                                name="mother_name" value="{{ old('mother_name') }}" placeholder="Name">
                                @error('mother_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="mother_nic">NIC: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('mother_nic') is-invalid @enderror" id="mother_nic"
                                name="mother_nic" value="{{ old('mother_nic') }}" placeholder="NIC">
                                @error('mother_nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="mother_occupation">Occupation: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('mother_occupation') is-invalid @enderror" id="mother_occupation"
                                name="mother_occupation" value="{{ old('mother_occupation') }}" placeholder=" ">
                                @error('mother_occupation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="mother_contact">Contact Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('mother_contact') is-invalid @enderror" id="mother_contact"
                                name="mother_contact" value="{{ old('mother_contact') }}" placeholder=" ">
                                @error('mother_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="mother_contact">Contact Number 2: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('mother_contact2') is-invalid @enderror" id="mother_contact2"
                                name="mother_contact2" value="{{ old('mother_contact2') }}" placeholder=" ">
                                @error('mother_contact2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <legend>Legal Guardian</legend>
                            </div>
                            <div class="col-sm-8">
                                <label for="Father"><input  id="Father" onchange="change_gu('f')" value="f" @if(old('guardian','f')=='f') @checked('true') @endif type="radio" name="guardian"> Father</label>
                                <label for="Mother"><input id="Mother" onchange="change_gu('m')" value="m" @if(old('guardian')=='m') @checked('true') @endif type="radio" name="guardian"> Mother</label>
                                <label for="Other"><input id="Other" onchange="change_gu('o')" value="o"  @if(old('guardian')=='o') @checked('true') @endif type="radio" name="guardian"> Other</label>
                            </div>
                        </div>
                        <div class="form-group row guardian" >
                            <label class="col-sm-2" for="guardian_name">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_name') is-invalid @enderror" id="guardian_name"
                                name="guardian_name" value="{{ old('guardian_name') }}" placeholder="Name">
                                @error('guardian_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row guardian" >
                            <label class="col-sm-2" for="nic">NIC: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_nic') is-invalid @enderror" id="guardian_nic"
                                name="guardian_nic" value="{{ old('guardian_nic') }}" placeholder="nic">
                                @error('guardian_nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row guardian">
                            <label class="col-sm-2" for="guartian_contact">Contact Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guartian_contact') is-invalid @enderror" id="guartian_contact"
                                name="guartian_contact" value="{{ old('guartian_contact') }}" placeholder=" ">
                                @error('guartian_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-2">

                            </div>


                        </div>

                        <div class="form-group row guardian">
                            <label class="col-sm-2" for="guardian_contact2">Contact Number 2: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_contact2') is-invalid @enderror" id="guardian_contact2"
                                name="guardian_contact2" value="{{ old('guardian_contact2') }}" placeholder=" ">
                                @error('guardian_contact2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-2">

                            </div>


                        </div>

                        <div class="form-group row guardian">
                            <label class="col-sm-2" for="guardian_occupation">Occupation: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_occupation') is-invalid @enderror" id="guardian_occupation"
                                name="guardian_occupation" value="{{ old('guardian_occupation') }}" placeholder=" ">
                                @error('guardian_occupation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row guardian">
                            <label class="col-sm-2" for="relationship">Relationship: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('relationship') is-invalid @enderror" id="relationship"
                                name="relationship" value="{{ old('relationship') }}" placeholder=" ">
                                @error('relationship')
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
