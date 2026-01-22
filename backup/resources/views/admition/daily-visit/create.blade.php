@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">{{ $admission->room->room_number }} | {{ $admission->patient->name }}</h1>
<div class="row">
    <div class="col-xl-12 col-lg-12">
        @can('daily-visit-create')
        @if(request()->query('type') !== 'checkout')
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="dropdown no-arrow show">
                    <a href="{{ route('admission.index') }}" class="btn btn-sm btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span></a>
                </div>
            </div>
            <form action="{{ route('daily-visit.store', $admission->id) }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2">Date Time: <i class="text-danger">*</i></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control datetimepicker" name="visit_time" value="{{ old('visit_time', date('Y-m-d H:i')) }}">
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label class="col-sm-2">Description:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="description" rows="15">{{ old('description') }}</textarea>
                        </div>
                    </div> -->
                    <div class="form-group row">
                            <label class="col-sm-2" for="description">Description: <i class="text-danger"></i></label>
                            <div class="col-sm-10">
                                <textarea class="form-control  @error('description') is-invalid @enderror" id="description" cols="3" rows="15" name="description">{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-save"></i>
                        </span>
                        <span class="text">Save</span>
                    </button>
                </div>
            </form>
        </div>
        @endif
        @endcan

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="dropdown no-arrow show">

                    @if(request()->query('type') === 'checkout')
                    <a href="{{ route('admission.checkout') }}" class="btn btn-sm btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span></a>
                    @else
                    <a href="{{ route('admission.index') }}" class="btn btn-sm btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span></a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table table-strip w-100">
                    <tr>
                        <th>No</th>
                        <th>Date time</th>
                        <th>Details</th>
                        @if(request()->query('type') !== 'checkout')
                        <th>Actions</th>
                        @endif
                    </tr>
                    @foreach ($admission->dailyvisit as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->visit_time }}<br /> <span class="badge badge-custom-purple"><small class="text-gray-500">{{ $item->user->designation }} {{ $item->user->first_name }}</small></span></td>
                        <td>{!! $item->description !!}</td>
                        <td>
                            @if(request()->query('type') !== 'checkout')
                            @can('daily-visit-edit')
                            <a class="btn btn-info btn-circle btn-sm" href="{{ route('daily-visit.edit', [$item->admission_id, $item->id]) }}">
                                <i class="fa fa-pen"></i>
                            </a>
                            @endcan
                            @can('daily-visit-delete')
                            <button class="btn btn-danger btn-circle btn-sm delete-btn" data-id="{{ $item->id }}">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            <form action="{{ route('daily-visit.destroy', [$item->admission_id, $item->id]) }}" method="POST" class="d-inline" id="del{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endcan
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            maxDate: "{{ date('Y-m-d H:i') }}"
        });
        //  $('#description').summernote();

        $('#description').summernote({
            height: 150, // Set the height in pixels
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
            // Other Summernote options go here
        });

        $(document).on('click', '.delete-btn', function() {
            var itemId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = '#del' + itemId;
                    $(id).submit();
                }
            });
        });

    });
</script>
@stop