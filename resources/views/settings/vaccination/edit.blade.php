@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Edit Vaccine</h1>
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div></div>
                <div class="dropdown no-arrow show">
                    <a href="{{ route('vaccination.index') }}" class="btn btn-sm btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                </div>
            </div>
            <form method="post" action="{{ route('vaccination.update', $vaccination->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2">Vaccine Name: <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name" value="{{ old('name', $vaccination->name) }}" placeholder="Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Skin Type: </label>
                        <div class="col-sm-8">

                                    <select name="petcategory[]" id="petcategory" class="form-control multipel select2" multiple >
                                        <option value=""></option>
                                        @foreach ($petcategory as $item)
                                        @php
                                            $petCategories = json_decode($vaccination->pet_category, true);
                                        @endphp
                                            <option value="{{ $item->id }}"  @if(is_array($petCategories) && in_array($item->id, $petCategories)) @selected(true) @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @error('petcategory')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Vaccine Duration: <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration"
                                   name="duration" value="{{ old('duration', $vaccination->duration) }}" placeholder="duration">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Price: <i class="text-danger">*</i></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                                   name="price" value="{{ old('price', $vaccination->price) }}" placeholder=""
                                   pattern="^\d+(\.\d{1,2})?$" title="Enter a valid price (e.g., 1234.56)"
                                   oninput="validatePrice(this)">
                            @error('price')
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
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.css') }}">
@stop

@section('third_party_scripts')
<script src="{{ asset('plugin/select2/select2.js') }}"></script>
<script>
    $('.select2').select2();

    function validatePrice(input) {
        const regex = /^\d*\.?\d{0,2}$/;
        if (!regex.test(input.value)) {
            input.setCustomValidity('Enter a valid price (e.g., 1234.56)');
        } else {
            input.setCustomValidity('');
        }
    }
</script>
@stop
