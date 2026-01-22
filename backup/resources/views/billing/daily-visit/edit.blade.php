@extends('layouts.app')

@section('content')

    <h1 class="h3 mb-2 text-gray-800">{{ $admission->room->room_number }} | {{ $admission->patient->name }} </h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    <div class="dropdown no-arrow show">
                        <a href="{{ route('admission.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span></a>
                    </div>
                </div>
                <form action="{{ route('daily-visit.update',[$admission->id,$daily_visit->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body"> 
                        <div class="form-group row">
                            <label class="col-sm-2">Date Time: <i class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <input type="text"
                                    class="form-control datetimepicker @error('visit_time') is-invalid @enderror"
                                    id="visit_time" name="visit_time" step="300" value="{{ $daily_visit->visit_time }}" >
                                @error('visit_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="description">Description: <i
                                    class="text-danger"></i></label>
                            <div class="col-sm-10">
                                <textarea class="form-control  @error('description') is-invalid @enderror" id="description" cols="3"
                                    rows="15" name="description">{{ $daily_visit->description }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
<link href="{{ asset('css/summernote/dist/summernote.css') }}" rel="stylesheet">
@stop

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
<script src="{{ asset('css/summernote/dist/summernote-bs4.js') }}"></script>
    <script>
       $(document).ready(function() {
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            maxDate:"{{ date('Y-m-d H:i') }}" 
        });
      //  $('#description').summernote();

        $('#description').summernote({
            height: 150, // Set the height in pixels
            // Other Summernote options go here
        });


        
    });
    </script>
@stop
