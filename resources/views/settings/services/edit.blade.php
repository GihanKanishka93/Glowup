@extends('layouts.app')

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Edit Service</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    <div class="dropdown no-arrow show">
                        <a href="{{ route('services.index') }}" class="btn btn-sm btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                    </div>
                </div>
                <form method="post" action="{{ route('services.update', $service->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label class="col-sm-2">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $service->name) }}" placeholder="Name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-2">Price: <i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                                    name="price" value="{{ old('price', $service->price) }}" placeholder="0.00"
                                    pattern="^\d+(\.\d{1,2})?$" title="Enter a valid price (e.g., 1234.56)"
                                    oninput="validatePrice(this)">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-2">Stock Quantity:</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01"
                                    class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity"
                                    name="stock_quantity"
                                    value="{{ old('stock_quantity', (float) $service->stock_quantity) }}" placeholder="0.00">
                                @error('stock_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-2 text-md-end">Unit:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                    name="unit" value="{{ old('unit', $service->unit) }}"
                                    placeholder="e.g. Tubes, Bottles, Units">
                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-2">Min Stock Level:</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01"
                                    class="form-control @error('min_stock_level') is-invalid @enderror" id="min_stock_level"
                                    name="min_stock_level"
                                    value="{{ old('min_stock_level', (float) $service->min_stock_level) }}"
                                    placeholder="Threshold for alert">
                                @error('min_stock_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="text-muted">For items only. Leave at 0 for pure services.</small>
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