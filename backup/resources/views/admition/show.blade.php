@extends('layouts.app')
@section('content')


<div class="row">

        <div class="col-xl-6 col-lg-6">
            <h1 class="h3 mb-2 text-gray-800">Admission Information</h1>
        </div>


    <div class="col-xl-6 col-lg-6 text-right">
        @if(request()->query('type') === 'current')
        <a href="{{ route('admission.index') }}" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Back</span>
        </a>
        @else
            <a href="{{ route('admission.checkout') }}" class="btn btn-sm btn-info btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fa fa-arrow-left"></i>
                </span>
                <span class="text">Back</span>
            </a>
        @endif
    </div>


</div><br>
@if(request()->query('type') === 'past')
<div class="row">

    <div class="col-xl-12 col-lg-12">

        <div class="card border-info mb-3" style="max-width: 100rem;">

            <div class="card-header">Discharge Information</div>
            <div class="card-body text-info">
              <h5 class="card-title">This patient already discharged</h5>
              <p class="card-text">
                 Discharge Note:
                 {{ $admission->remarks ? $admission->remarks  : '-'  }} <br>
                 Discharged On:
                 {{ $admission->date_of_check_out }} &nbsp;
                 Discharged By:
                 {{ $admission->updatedBy->user_name ? $admission->updatedBy->user_name : '-'  }}<br>
                 Logged Time:
                 {{ $admission->updated_at ? $admission->updated_at : '-'  }} <br/>
                 Note Inventory: 
                    {{ $admission->inventory_remarks? $admission->inventory_remarks:'' }} 
                   
       <ul class="list-unstyled row">
           @foreach($admission->item as $item)
           <li class=" d-inline-block col-md-4 {{ ($item->pivot->check_out==1)?'text-success':'text-danger' }}"> @if($item->pivot->check_out) <i class="fa fa-check"></i> @else <i class="fa fa-times"></i> @endif  {{ $item->name }}  </li>
           @endforeach
       </ul>
              </p>
             

            </div>
          </div>

    </div>

</div>
@endif

 <div class="row">

        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5>Admission No: {{ $admission->id }}</h5>
                    Check In to <b> Room {{ $admission->room->room_number }}</b>  at <b> {{ $admission->date_of_check_in }} </b>
                    @if(request()->query('type') === 'past')
                         Discharged On <b>{{ ($admission->date_of_check_out) ?? $admission->date_of_check_out }}</b>
                    @else
                        Plan to check out on <b>{{ ($admission->date_of_check_out) ?? $admission->plan_to_check_out }}</b>
                    @endif
                </div>
                <div class="card-body">
                     <h3>
                     </h3>
                    <dl class="row">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $admission->patient->name }}</dd>
                        <dt class="col-sm-4">gender</dt>
                        <dd class="col-sm-8"> {{ ($admission->patient->gender==1)?'male':'female' }}</dd>

                        <dt class="col-sm-4">Date of Birth</dt>
                        <dd class="col-sm-8"> {{ $admission->patient->name }}</dd>

                        <dt class="col-sm-4">age at register</dt>
                        <dd class="col-sm-8">{{ $admission->patient->age_at_register }} </dd>

                        <dt class="col-sm-4">allergies</dt>
                        <dd class="col-sm-8">{{ $admission->patient->allergies }} </dd>

                        <dt class="col-sm-4">remarks</dt>
                        <dd class="col-sm-8">{{ $admission->patient->remarks }} </dd>

                        <dt class="col-sm-4">basic ilness</dt>
                        <dd class="col-sm-8">{{ $admission->patient->basic_ilness }} </dd>
                       <hr>
                       <dt class="col-sm-4">Address</dt>
                        <dd class="col-sm-8">{{ $admission->patient->address->home }}
                             {{ $admission->patient->address->street }}
                             {{ $admission->patient->address->city }}
                             {{ $admission->patient->address->district->name_en }}</dd>
                        <hr>


                        <dt class="col-sm-12"><h4>Guardiant</h4></dt>
                        <dt class="col-sm-4">name</dt>
                        <dd class="col-sm-8">{{ ($admission->patient->guardian_name)??'N/a' }}</dd>
                        <dt class="col-sm-4">nic</dt>
                        <dd class="col-sm-8">{{ ($admission->patient->guardian_nic)??'N/a' }}</dd>
                        <dt class="col-sm-4">Contacts</dt>
                        <dd class="col-sm-8">{{ ($admission->patient->guardian_contact)??'N/a' }}  </dd>
                        <dt class="col-sm-4">Relationship</dt>
                        <dd class="col-sm-8">{{ ($admission->patient->relationship->name)??'N/a' }}</dd>
                      
                        <dt class="col-sm-12"><h4>Referral</h4></dt>
                        <dt class="col-sm-4">Estimate duration of stay</dt>
                        <dd class="col-sm-8">{{ ($admission->number_of_days) . ' Days' ??'-' }}</dd>
                        <dt class="col-sm-4">Referred Ward</dt>
                        <dd class="col-sm-8">{{ ($admission->reffered_ward)??'N/a' }}</dd>
                        <dt class="col-sm-4">Referred Consultant</dt>
                        <dd class="col-sm-8">{{ ($admission->reffered_counsultant)??'N/a' }}</dd>
                        <dt class="col-sm-4">Treatment History</dt>
                        @php
                            $treatment_history = json_decode($admission->treatment_history);
                            @endphp
                        <dd class="col-sm-8">
                            @if($treatment_history)
                                @foreach ($treatment_history as $item)
                                    {{ $item }} /
                                @endforeach
                            @endif
                        </dd>
                        <dt class="col-sm-4">Special Requirements</dt>
                        @php
                            $special_requirements = json_decode($admission->special_requirements);
                            @endphp
                        <dd class="col-sm-8">
                            @if($special_requirements)
                                @foreach ($special_requirements as $item)
                                    {{ $item }} /
                                @endforeach
                            @endif
                        </dd>

                        <dt class="col-sm-4">Agreement</dt>
                        <dd class="col-sm-8">{!!
                        ($admission->agreement_file)?
                        ' <a href="'.asset($admission->agreement_file).'" target="_blank">Currnt Agreement <i class="fa fa-2x fa-file-pdf"></i></a>
                            ':'N/a' !!}</dd>

                    </dl>
                    @can('admission-medical-view')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                       Medical Details
                      </button>

                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <!-- Use "modal-lg" class for a large modal, you can also try "modal-sm" for a smaller one -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Medical Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <dl class="row"><legend class="bg-gray-200 p-1 pl-lg-4">Health Status</legend>
                                        <dt class="col-md-3">Medical Diagnosis:</dt>
                                        <dd class="col-md-9">{{ ($admission->medical->medical_diagnosis)??'' }}</dd>
                                        <dt class="col-md-3">Medical History:</dt>
                                        <dd class="col-md-9">{{ ($admission->medical->medical_history)??'' }}</dd>
                                        <dt class="col-md-3">Allergies:</dt>
                                        <dd class="col-md-9">{{ ($admission->medical->allergies)??'' }}</dd>
                                        <dt class="col-md-3">Patient On Steroids :</dt>
                                        @if($admission->medical !=null)
                                        <dd class="col-md-9">{{ ($admission->medical->patient_on_steroids == 1) ? 'Yes' : 'No' }}</dd>
                                        @endif
                                        <legend class="bg-gray-200 p-1 pl-lg-4">Pain Assesment</legend>
                                        <dt class="col-md-4">Is the patient experiencing any pain?</dt>
                                        @if($admission->medical!=null)
                                        <dd class="col-md-2">{{ ($admission->medical->any_pain==1)?'yes':'no' }}</dd>

                                        <dt class="col-md-4">Pain Score</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->pain_score)??'' }}</dd>
                                        <dt class="col-md-4">If YES what type of pain?</dt>
                                        @php
                                        $type_of_pain = json_decode($admission->medical->type_of_pain)
                                        @endphp
                                        <dd class="col-md-8">
                                            @if(is_array($type_of_pain))
                                                @foreach ($type_of_pain as $k=>$v )
                                                    {{ $k }},
                                                @endforeach
                                            @endif</dd>
                                    @endif
                                            @if($admission->medical!=null)
                                        <legend class="bg-gray-200 p-1 pl-lg-4">Vital signs</legend>
                                        <dt class="col-md-3">Temperature ( )</dt>
                                        <dt class="col-md-3">Blood Pressure (mmHg)</dt>
                                        <dt class="col-md-3">Heart Rate (bpm)</dt>
                                        <dt class="col-md-3">Respiratory Rate (breaths pm)</dt>
                                        <dd class="col-md-3">{{ ($admission->medical->temperature)??'' }}</dd>
                                        <dd class="col-md-3">{{ $admission->medical->blood_pressure }}</dd>
                                        <dd class="col-md-3">{{ $admission->medical->heart_reate }}</dd>
                                        <dd class="col-md-3">{{ $admission->medical->breaths_per_minute }}</dd>
                                        <legend class="bg-gray-200 p-1 pl-lg-4">Body system review</legend>
                                        <dt class="col-md-4">Sensory (Eyes, ears, nose, throat)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->sensory==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->sensory_comment }}</dd>
                                        <dt class="col-md-4">Musculoskeletal (Mobility)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->musculoskelete==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->musculoskelete_comment }}</dd>
                                        <dt class="col-md-4">Integumentary ( Rashes, irritation, pale)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->integumentary==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->integumentary_comment }}</dd>
                                        <dt class="col-md-4">Neurovascular ( Pain, seizures, sensation)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->neurovascular==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->neurovascular_comment }}</dd>
                                        <dt class="col-md-4">Circulatory ( Skin, oedema)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->circularory==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->circularory_comment }}</dd>
                                        <dt class="col-md-4">Respiratory ( Shortness of breath)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->respiratory==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->respiratory_comment }}</dd>
                                        <dt class="col-md-4">Dental ( Dentures)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->dental==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->dental_comment }}</dd>
                                        <dt class="col-md-4">Psychosocial ( Hallucinations, delusions)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->psychosocial==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->psychosocial_comment }}</dd>
                                        <dt class="col-md-4">Nutrition (Diet, weight change, swallowing)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->nutrition==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->nutrition_comment }}</dd>
                                        <dt class="col-md-4">Elimination (Constipation, incontinence)</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->elimination==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->elimination_comment }}</dd>
                                        <dt class="col-md-4">Does the patient have trouble sleeping?</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->trouble_sleeping==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->trouble_sleeping_comment }}</dd>
                                        <dt class="col-md-4">Does the patient experience nausea & vomiting?</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->nausea_and_vomiting==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->nausea_and_vomiting_comment }}</dd>
                                        <dt class="col-md-4">Does the patient have problem in breathing?</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->breathing_problem==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->breathing_problem_comment }}</dd>
                                        <dt class="col-md-4">Does the patient have appetite problem?</dt>
                                        <dd class="col-md-2">{{ ($admission->medical->appetite_problem==1)?'Normal':'Not Normal' }}</dd>
                                        <dd class="col-md-6">{{ $admission->medical->appetite_problem_comment }}</dd>
                                        <legend class="bg-gray-200 p-1 pl-lg-4">List of Current Medication</legend>
                                        <dt class="col-md-4">Medication Name</dt>
                                        <dt class="col-md-1">Dose</dt>
                                        <dt class="col-md-2">Frequency</dt>
                                        <dt class="col-md-2">Route</dt>
                                        <dt class="col-md-2">Indication</dt>
                                        @foreach($admission->medication as $item)
                                            <dd class="col-md-4">{{ $item->name }}</dd>
                                            <dd class="col-md-1">{{ $item->dose }}</dd>
                                            <dd class="col-md-2">{{ $item->frequency }}</dd>
                                            <dd class="col-md-2">{{ $item->route }}</dd>
                                            <dd class="col-md-2">{{ $item->indication }}</dd>
                                        @endforeach
                                    </dl>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">

            @if(count($admission->guests)>0)
            <br/>
            <div class="card">
                <div class="card-header">
                    <h3 class="title">Guest</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>NIC</th>
                            {{-- <th>Date Of birth</th> --}}
                        </tr>

                    @foreach ($admission->guests as $item)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}  </td>
                        {{-- <td>{{ ($item->relationship->name)??'' }}  </td> --}}
                        <td>{{ $item->nic }}  </td>
                     </tr>

                    @endforeach
                </table>
                </div>

            </div>
            @endif
            </div>
    </div>
    @if(request()->query('type') !== 'past')
    <div class="card">
        <div class="card-body text-info">
            <h5 class="card-title">Inventory in Room</h5>
          
    <ul class="list-unstyled row">
        @foreach($admission->item as $item)
        <li class=" d-inline-block col-md-4 text-success">  <i class="fa fa-check"></i>   {{ $item->name }}  </li>
        @endforeach
    </ul>
  

</div>
</div>
@endif
@endsection
