@extends('layouts.app')
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
    </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">
                        <a href="{{ route('patient.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                    <div></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">PatientID</dt>
                                <dd class="col-sm-8">{{ $patient->patient_id }}</dd>
                                <dt class="col-sm-4">Name</dt>

                                <dd class="col-sm-8">{{ $patient->name }}   </dd>


                                <dt class="col-sm-4">gender</dt>
                                <dd class="col-sm-8"> {{ $patient->gender == 1 ? 'male' : 'female' }}</dd>

                                <dt class="col-sm-4">Date of Birth</dt>
                                <dd class="col-sm-8"> {{ $patient->date_of_birth }}  ( {{ ($age) }} )</dd>

                                <dt class="col-sm-4">Age at register</dt>
                                <dd class="col-sm-8">{{ $patient->age_at_register }} </dd>
                                @if($patient->allergies !='')
                                <dt class="col-sm-4">Allergies</dt>
                                <dd class="col-sm-8">{{ $patient->allergies }} </dd>
                                @endif
                                @if($patient->remarks !='')
                                <dt class="col-sm-4">Remarks</dt>
                                <dd class="col-sm-8">{{ $patient->remarks }} </dd>
                                @endif
                                @if($patient->basic_ilness !='')
                                <dt class="col-sm-4">Basic Ilness</dt>
                                <dd class="col-sm-8">{{ $patient->basic_ilness }} </dd>
                                @endif

                                @if($patient->monthly_family_income !='')
                                <dt class="col-sm-4">Monthly Family Income:</dt>
                                <dd class="col-sm-8">{{ $patient->monthly_family_income }} </dd>
                                @endif
                                @if($patient->monthly_loan_diductions !='')
                                <dt class="col-sm-4">Monthly Loan Deductions:</dt>
                                <dd class="col-sm-8">{{ $patient->monthly_loan_diductions }} </dd>
                                @endif
                                @if($patient->transport_mode !='')
                                <dt class="col-sm-4">Mode Of Transportation:</dt>

                                    @php
                                    $transport_mode = json_decode($patient->transport_mode);
                                    @endphp
                                <dd class="col-sm-8">
                                    @if($transport_mode)
                                    <ul>
                                        @foreach ($transport_mode as $item)
                                           <li> {{ $item }}</li>
                                        @endforeach
                                    </ul>
                                    @endif

                                  </dd>
                                @endif
                                @if($patient->cost_of_travel !='')
                                <dt class="col-sm-4">Cost Of Travel Per Person (LKR):</dt>
                                <dd class="col-sm-8">{{ $patient->cost_of_travel }} </dd>
                                @endif
                                @if($patient->financial_support !='')
                                <dt class="col-sm-4">Other Financial Support Received:</dt>

                                    @php
                                    $financial_support = json_decode($patient->financial_support);
                                    @endphp
                                <dd class="col-sm-8">
                                    @if($financial_support)
                                    <ul>
                                        @foreach ($financial_support as $item)
                                           <li> {{ $item }}</li>
                                        @endforeach
                                    </ul>
                                    @endif

                                </dd>
                                @endif

                                <hr>
                                <dt class="col-sm-4">Address</dt>
                                <dd class="col-sm-8">{{ $patient->address->home }}
                                    {{ $patient->address->street }}
                                    {{ $patient->address->city }}
                                    {{ $patient->address->district->name_en }}</dd>
                                <dt class="col-sm-4">Distance to Suwa arana</dt>
                                <dd class="col-sm-8">
                                    {{ $patient->address->distance_to_suwa_arana }} KM
                                </dd>
                                @if($patient->wdu_reside !='')
                                <dt class="col-sm-4">Other Financial Support Received:</dt>

                                    @php
                                    $wdu_reside = json_decode($patient->wdu_reside);
                                    @endphp
                                <dd class="col-sm-8">
                                    @if($wdu_reside)
                                    <ul>
                                        @foreach ($wdu_reside as $item)
                                           <li> {{ $item }}</li>
                                        @endforeach
                                    </ul>
                                    @endif

                                </dd>
                                @endif
                                <hr>

                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-12"> <h2>Father</h2>  </dt>
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8">{{ $patient->father_name ?? 'n/a' }}</dd>
                                <dt class="col-sm-4">Occupation</dt>
                                <dd class="col-sm-8">{{ $patient->father_occupation ?? 'n/a' }}</dd>
                                <dt class="col-sm-4">NIC</dt>
                                <dd class="col-sm-8">{{ $patient->father_nic ?? 'n/a' }}</dd>
                                <dt class="col-sm-4">Contacts</dt>
                                <dd class="col-sm-8"> {{ $patient->father_contact ?? 'n/a' }} </dd>
                                @if($patient->father_contact2 !='')
                                <dt class="col-sm-4">Contacts 2</dt>
                                <dd class="col-sm-8">  {{ $patient->father_contact2 ?? 'n/a' }}</dd>
                                @endif

                                <dt class="col-sm-12"> <h2>Mother</h2>  </dt>
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8">{{ $patient->mother_name ?? 'n/a' }}</dd>
                                @if($patient->mother_occupation !='')
                                <dt class="col-sm-4">Occupation</dt>
                                <dd class="col-sm-8">{{ $patient->mother_occupation ?? 'n/a' }}</dd>
                                @endif
                                @if($patient->mother_nic !='')
                                <dt class="col-sm-4">NIC</dt>
                                <dd class="col-sm-8">{{ $patient->mother_nic ?? 'n/a' }}</dd>
                                @endif
                                @if($patient->mother_contact !='')
                                <dt class="col-sm-4">Contacts</dt>
                                <dd class="col-sm-8"> {{ $patient->mother_contact ?? 'n/a' }} </dd>
                                @endif
                                @if($patient->mother_contact2 !='')
                                <dt class="col-sm-4">Contacts 2</dt>
                                <dd class="col-sm-8">  {{ $patient->mother_contact2 ?? 'n/a' }}</dd>
                                @endif

                                <dt class="col-sm-12"> <h2>Legal Guardian</h2>  </dt>
                                @if($patient->guardian_name !='')
                                <dt class="col-sm-4">Name</dt>
                                <dd class="col-sm-8">{{ $patient->guardian_name ?? 'n/a' }}</dd>
                                @endif
                                @if($patient->guardian_nic !='')
                                <dt class="col-sm-4">NIC</dt>
                                <dd class="col-sm-8">{{ $patient->guardian_nic ?? 'n/a' }}</dd>
                                @endif
                                @if($patient->guartian_contact !='')
                                <dt class="col-sm-4">Contacts</dt>
                                <dd class="col-sm-8"> {{ $patient->guartian_contact ?? 'n/a' }} </dd>
                                @endif
                                @if($patient->guardian_contact2 !='')
                                <dt class="col-sm-4">Contacts 2</dt>
                                <dd class="col-sm-8"> {{ $patient->guardian_contact2 ?? 'n/a' }} </dd>
                                @endif
                                @if($patient->guardian_occupation !='')
                                <dt class="col-sm-4">Occupation</dt>
                                <dd class="col-sm-8">  {{ $patient->guardian_occupation }}</dd>
                                @endif
                                @if($patient->guardian_relationship !='')
                                <dt class="col-sm-4">Relationship</dt>
                                <dd class="col-sm-8">  {{ $patient->guardian_relationship }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
