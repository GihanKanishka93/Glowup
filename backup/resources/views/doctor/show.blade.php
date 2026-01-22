@extends('layouts.app')
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
    </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">
                        <a href="{{ route('doctor.index') }}" class="btn btn-sm btn-info btn-icon-split">
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
                                <dt class="col-sm-4">DoctorID</dt>
                                <dd class="col-sm-8">{{ $doctor->doctor_id }}</dd>
                                <dt class="col-sm-4">Name</dt>

                                <dd class="col-sm-8">{{ $doctor->name }}   </dd>


                                <dt class="col-sm-4">gender</dt>
                                <dd class="col-sm-8"> {{ $doctor->gender == 1 ? 'male' : 'female' }}</dd>

                                <dt class="col-sm-4">Designation</dt>
                                <dd class="col-sm-8"> {{ $doctor->designation }}  </dd>

                                <dt class="col-sm-4">Address</dt>
                                <dd class="col-sm-8">{{ $doctor->address }} </dd>

                                <dt class="col-sm-4">Contact</dt>
                                <dd class="col-sm-8">{{ $doctor->contact_no }} </dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $doctor->email }} </dd>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
