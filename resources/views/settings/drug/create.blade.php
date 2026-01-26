@extends('layouts.app')

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Add Drug</h1>
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
                <form action="{{ route('drug.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label class="col-sm-2">Drug Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Enter drug/item name">
                                @error('name')
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
                                    name="stock_quantity" value="{{ old('stock_quantity', 0) }}" placeholder="0.00">
                                @error('stock_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-2 text-md-end">Unit:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                    name="unit" value="{{ old('unit') }}" placeholder="e.g. Tubes, Tablets, g, ml">
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
                                    name="min_stock_level" value="{{ old('min_stock_level', 0) }}"
                                    placeholder="Threshold for alert">
                                @error('min_stock_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="text-muted">You will get an alert when stock falls below this level.</small>
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
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
@stop

@section('third_party_scripts')
<script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
@stop