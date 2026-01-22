@extends('layouts.app')
@section('content')

<h1 class="h3 mb-2 text-gray-800">Add New Room</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <div class="dropdown no-arrow show">
                    </div>
                </div>
                <form method="post" action="{{ route('room.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-sm-2">Room Number: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control   @error('room_number') is-invalid @enderror" id="room_number"
                                        name="room_number" value="{{ old('room_number') }}" placeholder="Room Number">
                                    @error('room_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  class="col-sm-2">Floor Number: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select name="floor_id" class="form-control  @error('floor') is-invalid @enderror" id="">
                                    <option value=""></option>
                                    @foreach ($floor as $item)
                                    <option value="{{ $item->id }}">{{ $item->number }}</option>
                                    @endforeach

                                </select>
                                    @error('floor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2">Room Status: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                               <select name="status" id="status" class="select2 form-control @error('status') is-invalid @enderror">
                                <option value=""></option>
                                <option value="1">Available (Inventory Complete)</option>
                                <option value="2">Available (Inventory Incomplete)</option>
                                <option value="20">Occupied</option>
                                <option value="30">Under Maintenance</option>
                               </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2" for="inventory">Inventory: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">


                                @foreach ($items as $item)
                                        <div class="col-md-4 form-check">
                                            <label class="label label-defalt">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[]" id=""
                                                    value="{{ $item->id }}" class="@error('items') is-invalid @enderror">
                                                {{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                @error('items')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="col-md-4 form-check">
                                    <label class="label label-defalt">
                                        <input class="form-check-input" type="checkbox" name="checkall" id="checkall"
                                            value="" >
                                        Check All</label>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('room.index') }}" class="btn btn-info">
                                <span class="text">Cancel</span>
                            </a>
                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@section('third_party_stylesheets')
<link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">
<link href="{{ asset('css/summernote/dist/summernote.css') }}" rel="stylesheet">
<style>
    .note-editable.card-block{
    height: 200px; /* Set your desired height here */
}
</style>
@stop

@section('third_party_scripts')
    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script src="{{ asset('css/summernote/dist/summernote-bs4.js') }}"></script>
</body>
    <script>
        $(document).ready(function() {
        $('.select2').select2();
        $('#inventory').summernote();
        });

        $(document).ready(function() {
        $('#checkall').change(function() {
            if ($(this).prop('checked')) {
                $('.item-checkbox').prop('checked', true);
            } else {
                $('.item-checkbox').prop('checked', false);
            }
        });
});
    </script>
@stop
