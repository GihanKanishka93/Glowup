@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Add Medical Details</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                       <div></div>
                    <div class="dropdown no-arrow show">
                        <a href="#" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>
                <form action="#" method="post">
                    @csrf
                    <div class="card-body">
                         

                    </div>

                    <div class="card-footer text-right">
                         <button type="submit" value="save" class="btn btn-sm btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Save</span>
                                </button>
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
    </script>
@stop
