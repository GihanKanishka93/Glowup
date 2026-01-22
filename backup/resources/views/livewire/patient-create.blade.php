<h1 class="h3 mb-2 text-gray-800">Register new Patient</h1>
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
                        <div class="form-group row">
                            <label class="col-sm-2">Name: <i class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control   @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-1">Gender: <i class="text-danger">*</i></label>
                            <div class="col-sm-1">
                                <select name="gender" id="">
                                    <option value=""></option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-2">Date of Birth: <i class="text-danger">*</i></label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control   @error('dob') is-invalid @enderror" id="dob"
                                    name="dob" value="{{ old('dob') }}" placeholder="Date of bith">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <label class="col-sm-2">Allergics: <i class="text-danger">*</i></label>
                            <div class="col-sm-10">
                              <textarea name="" id="" cols="30" rows="10"></textarea>
                                @error('floor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Basic Illness: <i class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control   @error('room_number') is-invalid @enderror" id="room_number"
                                    name="room_number" value="{{ old('room_number') }}" placeholder="Room Number">
                                @error('room_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <label class="col-sm-2">Remarks: <i class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control   @error('floor') is-invalid @enderror" id="floor"
                                    name="floor" value="{{ old('floor') }}" placeholder="Floor Number">
                                @error('floor')
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