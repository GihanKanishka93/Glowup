@extends('layouts.app')
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
    </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">
                        <a href="{{ route('pet.index') }}" class="btn btn-sm btn-info btn-icon-split">
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
                                <dt class="col-sm-4">petID</dt>
                                <dd class="col-sm-8">{{ $pet->pet_id }}</dd>
                                <dt class="col-sm-4">Name</dt>

                                <dd class="col-sm-8">{{ $pet->name }}   </dd>


                                <dt class="col-sm-4">gender</dt>
                                <dd class="col-sm-8"> {{ $pet->gender == 1 ? 'male' : 'female' }}</dd>

                                <dt class="col-sm-4">Date of Birth</dt>
                                <dd class="col-sm-8"> {{ $pet->date_of_birth }} </dd>

                                <dt class="col-sm-4">Age at register</dt>
                                <dd class="col-sm-8">{{ $pet->age_at_register }} </dd>

                                <dt class="col-sm-4">Weight</dt>
                                <dd class="col-sm-8">{{ $pet->weight }} </dd>

                                <dt class="col-sm-4">color</dt>
                                <dd class="col-sm-8">{{ $pet->color }} </dd>

                                <dt class="col-sm-4">Pet Category</dt>
                                <dd class="col-sm-8">{{ $pet->pet_category }}</dd>

                                <dt class="col-sm-4">Remarks</dt>
                                <dd class="col-sm-8">
                                    {{ $pet->remarks }}
                                </dd>


                            </dl>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
