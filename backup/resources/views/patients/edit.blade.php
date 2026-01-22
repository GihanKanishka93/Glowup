@extends('layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Edit {{ $patient->name }}</h1>
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
                <form method="post" action="{{ route('patient.update',$patient->id) }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2">PatientID: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id"
                                value="{{ $patient->patient_id }}" @cannot('patientid-edit') readonly @endcannot>
                                @error('name')
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
                                    name="name" value="{{ $patient->name }}" placeholder="Name">
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
                                    <option value="1" @if($patient->gender)==1) @selected(true) @endif  >Male</option>
                                    <option value="2" @if($patient->gender)==2) @selected(true) @endif >Female</option>
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
                                    name="date_of_birth" value="{{ $patient->date_of_birth }}" placeholder="Date of bith">
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
                                    name="age" value="{{ $patient->age_at_register }}">
                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_income">Monthly Family Income: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('monthly_family_income') is-invalid @enderror" id="monthly_family_income"
                                name="monthly_family_income" value="{{ ($patient->monthly_family_income)??'' }}" placeholder=" ">
                                @error('monthly_family_income')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="father_income">Monthly Loan Deductions: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('monthly_loan_diductions') is-invalid @enderror" id="monthly_loan_diductions"
                                name="monthly_loan_diductions" value="{{ ($patient->monthly_loan_diductions)??'' }}" placeholder=" ">
                                @error('monthly_loan_diductions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="special_requirements">Mode of Transportation:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">
                                @php
                                $disable = "";
                                $displayclass = "";
                                    $transport_mode = json_decode($patient->transport_mode);
                                    if ($transport_mode === null) {
                                        $transport_mode = [];
                                    }
                                    if(!in_array('Other',$transport_mode)){
                                        $disable = " disabled";
                                        $displayclass = "chkboxdisplaynone";
                                    }

                                @endphp

                                <div class="col-sm-3"> <label for="bus"><input type="checkbox" name="transport_mode[]" class="form-check-input" @if(in_array('Bus',$transport_mode)) @checked(true)  @endif value="Bus" id="bus"> Bus</label></div>
                                <div class="col-sm-3">  <label for="train"><input type="checkbox" name="transport_mode[]" class="form-check-input" @if(in_array('Train',$transport_mode)) @checked(true)  @endif value="Train" id="train"> Train</label></div>
                                <div class="col-sm-3"> <label for="three_wheel"><input type="checkbox" name="transport_mode[]" class="form-check-input" @if(in_array('Three Wheel',$transport_mode)) @checked(true)  @endif id="three_wheel" value="Three Wheel"> Three Wheel </label></div>
                                <div class="col-sm-3"> <label for="personal_vehicle"><input type="checkbox" name="transport_mode[]" class="form-check-input {{ $displayclass }}" @if(in_array('Personal Vehicle',$transport_mode)) @checked(true)  @endif id="personal_vehicle" value="Personal Vehicle"> Personal Vehicle </label></div>
                                <div class="col-sm-3">
                                 <label for="other"><input type="checkbox" name="transport_mode[]" class="form-check-input" @if(in_array('Other',$transport_mode)) @checked(true)  @endif value="Other" id="other" class="transport-checkbox"> Other </label>
                             </div>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control {{  $displayclass }} @error('other_text') is-invalid @enderror" id="other_text" name="transport_mode[]" value="@if(in_array('Other',$transport_mode)) {{ end($transport_mode) }} @endif" {{ $disable }} >
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
                                name="cost_of_travel" value="{{ ($patient->cost_of_travel)??'' }}" placeholder=" ">
                                @error('cost_of_travel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="special_requirements">Other financial support received:</label>
                            <div class="col-sm-8 row" style="margin-left: 3px">
                                @php
                                $disable2 = "";
                                $displayclass2 = "";
                                    $financial_support = json_decode($patient->financial_support);
                                    if ($financial_support === null) {
                                        $financial_support = [];
                                    }
                                    if(!in_array('Other',$financial_support)){
                                        $disable2 = " disabled";
                                        $displayclass2 = "chkboxdisplaynone";
                                    }
                                @endphp
                                <div class="col-sm-3"> <label for="Aswesuma"><input type="checkbox" name="financial_support[]" class="form-check-input" @if(in_array('Aswesuma',$financial_support)) @checked(true)  @endif value="Aswesuma" id="Aswesuma"> Aswesuma</label></div>
                                <div class="col-sm-3">  <label for="government_allowance"><input type="checkbox" name="financial_support[]" class="form-check-input" @if(in_array('Government Allowance',$financial_support)) @checked(true)  @endif value="Government Allowance" id="government_allowance"> Government Allowance</label></div>
                                <div class="col-sm-3">
                                 <label for="fsother"><input type="checkbox" name="financial_support[]" class="form-check-input" @if(in_array('Other',$financial_support)) @checked(true)  @endif value="Other" id="fsother" > Other </label>
                             </div>

                                <div class="col-sm-3">  <input type="text" class="form-control {{ $displayclass2 }} @error('other_text') is-invalid @enderror" id="fs-other_text" name="financial_support[]" value="@if(in_array('Other',$financial_support)) {{ end($financial_support) }} @endif" {{ $disable2 }}>
                                </div>

                                @error('financial_support')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <legend>Address</legend>
                        <div class="form-group row">
                            <label class="col-sm-2" for="home">House Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('home') is-invalid @enderror" id="home"
                                name="home" value="{{ ($patient->address->home)??'' }}" placeholder="Home">
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
                                name="street" value="{{ ($patient->address->street)??'' }}" placeholder="Street">
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
                                name="city" value="{{ ($patient->address->city)??'' }}" placeholder="city">
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
                                    <option value="{{ $item->id }}" @if(($patient->address->district_id)==$item->id) @selected(true) @endif >{{ $item->name_en }}</option>
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
                                <option value={{ $i }} @if($patient->address->distance_to_suwa_arana== $i) @selected(true) @endif>{{ $i-5 }} - {{ $i }} km </option>
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
                                $disable3 = "";
                                $displayclass3 = "";
                                $wdu_reside = json_decode($patient->wdu_reside);
                                if ($wdu_reside === null) {
                                    $wdu_reside = [];
                                }
                                if(!in_array('Other',$wdu_reside)){
                                        $disable3 = " disabled";
                                        $displayclass3 = "chkboxdisplaynone";
                                    }
                            @endphp
                                <div class="col-sm-3"> <label for="rented"><input type="checkbox" name="wdu_reside[]" class="form-check-input" @if(in_array('Rented',$wdu_reside)) @checked(true)  @endif value="Rented" id="rented">  Rented</label></div>
                               <div class="col-sm-3">  <label for="own_home"><input type="checkbox" name="wdu_reside[]" class="form-check-input" @if(in_array('Own home',$wdu_reside)) @checked(true)  @endif value="Own home" id="own_home">  Own home</label></div>
                               <div class="col-sm-4">  <label for="with_relatives"><input type="checkbox" name="wdu_reside[]" class="form-check-input" @if(in_array('with Relatives',$wdu_reside)) @checked(true)  @endif value="with Relatives" id="with_relatives">  with Relatives</label></div>
                               <div class="col-sm-4">
                                <label for="wdurother"><input type="checkbox" name="wdu_reside[]" class="form-check-input" @if(in_array('Other',$wdu_reside)) @checked(true)  @endif value="Other" id="wdurother">  Other </label>
                            </div>


                               <div class="col-sm-3">  <input type="text" class="form-control {{ $displayclass3 }} @error('other_text') is-invalid @enderror" id="wdur-other_text" name="wdu_reside[]" value="@if(in_array('Other',$wdu_reside)) {{ end($wdu_reside) }} @endif" {{ $disable3 }}>
                               </div>

                               @error('wdu_reside')
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
                                name="father_name" value="{{ $patient->father_name }}" placeholder="Name">
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
                                name="father_nic" value="{{ $patient->father_nic }}" placeholder="NIC">
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
                                name="father_occupation" value="{{ $patient->father_occupation }}" placeholder=" ">
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
                                name="father_contact" value="{{ $patient->father_contact }}" placeholder=" ">
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
                                name="father_contact2" value="{{ $patient->father_contact2 }}" placeholder=" ">
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
                                name="mother_name" value="{{ $patient->mother_name }}" placeholder="Name">
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
                                name="mother_nic" value="{{ $patient->mother_nic }}" placeholder="NIC">
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
                                name="mother_occupation" value="{{ $patient->mother_occupation }}" placeholder=" ">
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
                                name="mother_contact" value="{{ $patient->mother_contact }}" placeholder=" ">
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
                                name="mother_contact2" value="{{ $patient->mother_contact2 }}" placeholder=" ">
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
                                <label for="Father"><input  id="Father" onchange="change_gu('f')" value="f" @if($patient->guardian_relationship== 'Father') @checked('true') @endif type="radio" name="guardian"> Father</label>
                                <label for="Mother"><input id="Mother" onchange="change_gu('m')" value="m" @if($patient->guardian_relationship== 'Mother') @checked('true') @endif type="radio" name="guardian"> Mother</label>
                                <label for="Other"><input id="Other" onchange="change_gu('o')" value="o"  @if($patient->guardian_relationship != 'Father' || $patient->guardian_relationship== 'Mother') @checked('true') @endif type="radio" name="guardian"> Other</label>
                            </div>
                        </div>
                        <div class="form-group row guardian" >
                            <label class="col-sm-2" for="guardian_name">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_name') is-invalid @enderror" id="guardian_name"
                                name="guardian_name" value="{{ $patient->guardian_name }}" placeholder="Name">
                                @error('guardian_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row guardian" >
                            <label class="col-sm-2" for="nic">NIC: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_nic') is-invalid @enderror" id="guardian_nic"
                                name="guardian_nic" value="{{ $patient->guardian_nic }}" placeholder="nic">
                                @error('guardian_nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row guardian">
                            <label class="col-sm-2" for="guardian_contact">Contact Number: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('guardian_contact') is-invalid @enderror" id="guardian_contact"
                                name="guardian_contact" value="{{ $patient->guartian_contact }}" placeholder=" ">
                                @error('guardian_contact')
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
                                name="guardian_contact2" value="{{ $patient->guardian_contact2 }}" placeholder=" ">
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
                                name="guardian_occupation" value="{{ $patient->guardian_occupation }}" placeholder=" ">
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
                                name="relationship" value="{{ $patient->guardian_relationship }}" placeholder=" ">
                                @error('guardian_occupation')
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
