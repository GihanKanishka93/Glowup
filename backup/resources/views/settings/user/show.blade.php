@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">
        {{ $user->user_name }} </h1>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> 
                    <div class="dropdown no-arrow show">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $user->designation }} {{ $user->first_name }} {{ $user->last_name }}</dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4">Contact number</dt>
                        <dd class="col-sm-8">{{ $user->contact_number }}</dd>

                        <dt class="col-sm-4">User name</dt>
                        <dd class="col-sm-8">{{ $user->user_name }}</dd>

                        <dt class="col-sm-4">Roles</dt>
                        <dd class="col-sm-8">
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </dd>

                    </dl>
                </div>
            </div>
        </div>
    </div>
 
@endsection
