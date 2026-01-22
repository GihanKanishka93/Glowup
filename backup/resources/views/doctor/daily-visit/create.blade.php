@extends('layouts.app')

@section('content')

<h1 class="h3 mb-2 text-gray-800">{{ $patient->id }} | {{ $patient->name }} </h1>
<div class="row">
      <div class="col-xl-12 col-lg-12">
            @can('counselor-create')
            <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <div class="dropdown no-arrow show">
                              <a href="{{ route('patient.index') }}" class="btn btn-sm btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                          <i class="fa fa-arrow-left"></i>
                                    </span>
                                    <span class="text">Back</span></a>
                        </div>
                  </div>
                  <form action="{{ route('visit.store',$patient->id) }}" method="post">
                        @csrf
                        @method('post')
                        <div class="card-body">

                            



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

                              <!-- Field for Remark -->
                              <div class="form-group row">
                                    <label class="col-sm-2" for="remark">Remark:</label>
                                    <div class="col-sm-10">
                                          <textarea class="form-control @error('remark') is-invalid @enderror" id="remark" name="remark" rows="3" maxlength="150">{{ old('remark') }}</textarea>

                                          @error('remark')
                                          <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                    </div>
                              </div>

                              <div class="form-group row">
                                    <label class="col-sm-2">Date Time: <i class="text-danger">*</i></label>
                                    <div class="col-sm-4">
                                          <input type="text" class="form-control datetimepicker @error('visit_time') is-invalid @enderror" id="visit_time" name="visit_time" step="300" value="{{ old('visit_time',date('Y-m-d H:i')) }}">
                                          @error('visit_time')
                                          <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                    </div>
                              </div>


                        </div>
                        <div class="card-footer text-right">



                              <a href="{{ route('patient.index') }}" class="btn btn-info" style="padding: 3px; width: 73px;">
                                    <span class="text">Cancel</span>
                              </a>
                              <button type="submit" class="btn btn-sm btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                          <i class="fa fa-save"></i>
                                    </span>
                                    <span class="text">Save</span>
                              </button>



                        </div>

                  </form>

            </div>
            @endcan

            <div class="card shadow mb-4">
                  @cannot('counselor-create')
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                        <div class="dropdown no-arrow show">
                              <a href="{{ route('admission.index') }}" class="btn btn-sm btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                          <i class="fa fa-arrow-left"></i>
                                    </span>
                                    <span class="text">Back</span></a>
                        </div>
                  </div>
                  @endcannot

                  <table class="table table-striped w-100">
                        <thead>
                              <tr>
                                    <th>No</th>
                                    <th>Date Time</th>
                                    <th>Description</th>

                                    <th>Remark</th>
                                    <th>Actions</th>
                              </tr>
                        </thead>
                        <tbody>
                              @foreach ($patient->dailyVisitPatient->sortByDesc('id') as $item)
                              <tr>
                                    <td data-label="No">{{ $loop->iteration }}</td>
                                    <td data-label="Date Time">{{ $item->visit_time }}<br/> <span class="badge badge-custom-purple"><small class="text-gray-500"> {{ $item->user->user_name }}</small></span></td>
                                    <td data-label="Description">{!! $item->description !!}</td>

                                    <td data-label="Remark">{{ $item->remark }}</td>
                                    <td data-label="Actions">
                                          <div class="d-flex justify-content-around"> <!-- Flex container with spacing -->
                                                <!-- Assuming you're using a framework like Laravel for user permissions -->

                                                <a class="btn btn-info btn-circle btn-sm" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#detailsModal" title="View Details">
                                                      <i class="fa fa-eye"></i>
                                                </a>

                                                @can('counselor-edit')
                                                <a class="btn btn-info btn-circle btn-sm" href="{{ route('visit.edit', [$item->patient_id, $item->id]) }}" title="Edit">
                                                      <i class="fa fa-pen"></i>
                                                </a>
                                                @endcan

                                                @can('counselor-delete')
                                                <button class="btn btn-danger btn-circle btn-sm delete-btn" data-id="{{ $item->id }}">
                                                      <i class="fa fa-trash-alt"></i>
                                                </button>
                                                <form action="{{ route('visit.destroy', [$item->patient_id, $item->id]) }}" method="POST" class="d-inline" id="del{{ $item->id }}">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-danger btn-circle btn-sm d-none" onclick="return confirm('Are you sure you want to delete this?');" title="Delete">
                                                            <i class="fa fa-trash-alt"></i>
                                                      </button>
                                                </form>
                                                @endcan
                                          </div>
                                    </td>
                              </tr>
                              @endforeach
                        </tbody>
                  </table>



                  <!-- end table div -->
            </div>
      </div>
</div>

<!-- Modal to display visit details -->
<!-- Modal to display item details -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel"><b>Counselor Notes</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="detailsContent">
                        <!-- This will be populated with AJAX -->
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
            </div>
      </div>
</div>


@endsection

@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
<link href="{{ asset('css/summernote/dist/summernote.css') }}" rel="stylesheet">

<style>
      @media (max-width: 767px) {
            table {
                  display: block;
                
            }

            thead {
                  display: none;      
            }

            tbody {
                  display: block;
            }

            tr {
                  display: block;   
                  border-bottom: 1px solid #ddd;
                 
            }

            td {
                  display: block;
                  text-align: right;
                  padding: 10px;

            }

            td:before {
                  content: attr(data-label);
                
                  float: left;
                 
                  font-weight: bold;
                 
                  text-transform: uppercase;
                
            }
      }
</style>

@stop

@section('third_party_scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>
<script src="{{ asset('css/summernote/dist/summernote-bs4.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Bootstrap JS and dependencies (like Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
      $(document).ready(function() {
            $('#family_history').summernote({
                  height: 150,
                  toolbar: [
                        ['style', ['bold', 'italic', 'underline']], 
                        ['para', ['ul', 'ol', 'paragraph']], 
                        ['view', ['codeview']] 
                  ],
                  callbacks: {
                        onImageUpload: function(files) {
                              alert("Image uploads are not allowed.");
                        }
                  }
            });

            // Keep the existing code for other Summernote fields and SweetAlert2
      });

      $(document).ready(function() {
            $('#visit_time').datetimepicker({
                  format: 'Y-m-d',
                  timepicker: false,
            });
      });

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

      document.addEventListener('DOMContentLoaded', function() {
            const detailsModal = document.getElementById('detailsModal');

            detailsModal.addEventListener('show.bs.modal', function(event) {
                  const button = event.relatedTarget; // The button that triggered the modal
                  const itemId = button.getAttribute('data-id'); // Get the item ID from the button

                  const detailsContent = document.getElementById('detailsContent');
                  detailsContent.innerHTML = 'Loading...';

                  $.ajax({
                        url: `/visit/${itemId}`,

                        method: 'GET',
                        success: function(data) {
                              console.log('Data:', data.date);

                              detailsContent.innerHTML = `
                    <p><strong>Date:</strong> ${data.date}</p>
                    <p><strong>Description:</strong>  ${data.description}</p>
                   
                    <p><strong>Remark:</strong> ${data.remark}</p>
                `;
                        },
                        error: function(xhr, status, error) {
                              detailsContent.innerHTML = 'Error loading item details.';
                        }
                  });
            });
      });
</script>
@stop