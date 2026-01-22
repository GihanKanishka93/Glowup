@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

    <h1 class="h3 mb-2 text-gray-800">
        New Bill</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">

                    <div class="dropdown no-arrow show">

                    </div>
                </div>


                <form action="{{ route('billing.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Pet: <i class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <select style="width: 100%" name="pet" id="pet"
                                        class="select2 form-control  @error('pet') is-invalid @enderror" >
                                        <option value=""></option>
                                        @foreach ($pets as $item)
                                            <option value="{{ $item->id }}" @selected(old('pet'))>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pet')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">

                                    <label class="col-sm-12" for="reffered_ward">Doctor:</label>
                                    <div class="col-sm-12">
                                        <select name="doctor" id="doctor"
                                            class="select2 form-control @error('doctor') is-invalid @enderror">
                                            <option value="" selected="selected"></option>
                                            @foreach ($doctors as $item)
                                                <option value="{{ $item->id }}"  @if(old('doctor')==$item->id) @selected(true) @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('doctor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                            </div>




                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Pet Id: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('pet_id') is-invalid @enderror" id="pet_id"
                                    name="pet_id" value="{{ old('pet_id') }}" placeholder="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Name: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('pet_name') is-invalid @enderror" id="pet_name"
                                        name="pet_name" value="{{ old('pet_name') }}" placeholder="">
                                    @error('pet_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Age : </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('age') is-invalid @enderror" id="age"
                                    name="age" value="{{ old('age') }}" placeholder="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12" for="pet-category">Pet Type/ Category: <i class="text-danger">*</i></label>
                            <div class="col-sm-12">
                              <select name="pet_category" id="pet_category"  class="form-control @error('pet_category') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($petcategory  as $item)
                                    <option value="{{ $item->id }}" @if(old('pet_category')==$item->id) @selected(true) @endif >{{ $item->name }}</option>
                                @endforeach
                              </select>
                                @error('pet_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="breed">Breed: </label>
                            <div class="col-sm-12">
                              <select name="breed" id="breed"  class="form-control @error('breed') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($breed  as $item)
                                    <option value="{{ $item->id }}" @if(old('breed')==$item->id) @selected(true) @endif >{{ $item->name }}</option>
                                @endforeach
                              </select>
                                @error('breed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12">Gender: <i class="text-danger">*</i></label>
                            <div class="col-sm-12">
                                <select name="gender" id="" class="form-control  @error('gender') is-invalid @enderror">
                                    <option value=""></option>
                                    <option value="1" @if(old('gender')==1) @selected(true) @endif  >Male</option>
                                    <option value="2" @if(old('gender')==2) @selected(true) @endif >Female</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12" for="Weight">Weight: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('weight') is-invalid @enderror" id="weight"
                                name="weight" value="{{ old('weight') }}" placeholder=" ">
                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="Colour">Colour: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('colour') is-invalid @enderror" id="colour"
                                name="colour" value="{{ old('colour') }}" placeholder=" ">
                                @error('colour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-12" for="Colour">Remarks: </label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control   @error('remarks') is-invalid @enderror" id="remarks"
                                        name="remarks" ></textarea>
                                        @error('remarks')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Owner Information</legend>
                        <br>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12" for="owner_name">Name: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control   @error('owner_name') is-invalid @enderror" id="owner_name"
                                    name="owner_name" value="{{ old('owner_name') }}" placeholder="Name">
                                    @error('owner_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <label class="col-sm-12" for="owner_contact">Contact Number: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('owner_contact') is-invalid @enderror" id="owner_contact"
                                name="owner_contact" value="{{ old('owner_contact') }}" placeholder=" ">
                                @error('owner_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-12" for="owner_contact2">Address: </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control   @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ old('address') }}" placeholder=" ">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Treatment Information</legend>
                        <br>

                        <div class="form-group row">

                            <label class="col-sm-2">History /Complaint: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control   @error('history') is-invalid @enderror" id="history"
                                name="history" ></textarea>
                                @error('history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2">Clinical Observation: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control   @error('observation') is-invalid @enderror" id="observation"
                                name="observation" ></textarea>
                                @error('observation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2">Trement Remarks: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control   @error('remarks_t') is-invalid @enderror" id="remarks_t"
                                name="remarks_t" ></textarea>
                                @error('remarks_t')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="col-sm-12">Next Treatment Date: <i class="text-danger">*</i></label>
                            <div class="col-sm-12">
                                <input type="text"
                                    class="form-control datetimepicker  @error('next_treatment_date') is-invalid @enderror"
                                    id="next_treatment_date" name="next_treatment_date" step="60"
                                    value="{{ date('Y-m-d H:i') }}">
                                @error('next_treatment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col"></div>
                            <div class="col">
                                <label class="col-sm-12">Billing Date: <i class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <input type="text"
                                        class="form-control datetimepicker  @error('billing_date') is-invalid @enderror"
                                        id="billing_date" name="billing_date" step="60"
                                        value="{{ date('Y-m-d H:i') }}">
                                    @error('billing_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>



                        <hr>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Billing Information</legend>
                        <br>
                        <div id="personDetails" class="form-group row">
                            <div class="person-detail col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Service Name" name="service_name[]">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" name="billing_qty[]" placeholder="Qty">
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="unit_price[]" placeholder="Unit Price">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="tax[]" placeholder="Tax">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="last_price[]" placeholder="Total">
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" style="background-color: #578b26" class="btn btn-sm text-white btn-icon-split" id="addPerson">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="person-detail col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><label class="col-sm-12">Net Total: </label></div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="net_total" id="net_total" >
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                        <div class="person-detail col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><label class="col-sm-12">Discount: </label></div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="discount" id="discount" >
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                        <div class="person-detail col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><label class="col-sm-12">Grand Total: </label></div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="grand_total" id="grand_total" >
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>

                        <br><br>

                        @error('parents')
                        <span class="invalid-feedback" role="alert">

                            <div class="alert alert-danger">
                                <strong>{{ $message }}</strong>
                              </div>
                        </span>
                        @enderror

                        @error('name.0')
                        <span class="invalid-feedback" role="alert">
                            <div class="alert alert-danger">
                                <strong>{{ $message }}</strong>
                              </div>
                        </span>
                        @enderror




                        <hr />



                    </div>


                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('billing.index') }}" class="btn btn-info">
                                <span class="text">Cancel</span>
                            </a>
                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save</span>
                            </button>

                            <button type="submit" value="save" class="btn btn-md btn-primary btn-icon-split ml-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-save"></i>
                                </span>
                                <span class="text">Save & Print</span>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
    <style>
        #moodEmoji {
            font-size: 3em;
            /* Adjust the font size as needed */
        }
    </style>
@stop

@section('third_party_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
        // Initialize the datetime picker

        // Initialize the datetime picker
        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Additional options if needed
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>



        function getPetDetails(){
            var pet =  $('#pet').val();

            if(pet!=''){
            $.ajax({
                url: "{{ route('ajax.getPetDetails') }}",
                method: "GET", // or "POST" for a POST request
                data: {
                    "pet": pet,
                },
                success: function(response) {
                  // alert(response.owner_name);
                    document.getElementById('pet_id').value = response.pet_id;
                    document.getElementById('pet_name').value = response.name;
                    document.getElementById('age').value = response.age_at_register;
                    document.getElementById('weight').value = response.weight;
                    document.getElementById('colour').value = response.color;
                    //document.getElementById('gender').value = response.gender;
                    //document.getElementById('remarks').value = response.remarks;
                    // document.getElementById('pet_category').value = response.pet_category;
                    // document.getElementById('breed').value = response.breed;
                    document.getElementById('owner_name').value = response.owner_name;
                    document.getElementById('owner_contact').value = response.owner_contact;
                    document.getElementById('address').value = response.address;



                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
            }
        }

        function setSelectedValue(selectObj, valueToSet) {
            for (var i = 0; i < selectObj.options.length; i++) {
                if (selectObj.options[i].text== valueToSet) {
                    selectObj.options[i].selected = true;
                    return;
                }
            }
        }

        $('#pet').change(function() {
            getPetDetails();
        });


    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
document.getElementById('addPerson').addEventListener('click', function() {
    let personDetailClone = document.querySelector('.person-detail').cloneNode(true);

    // Clear input values in the cloned node
    let clonedInputs = personDetailClone.querySelectorAll('input, select');
    clonedInputs.forEach(function(input) {
        input.value = '';
    });

    let removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger btn-sm mt-0 mb-2 removePerson';
    removeButton.innerHTML = '<i class="fa fa-trash"></i>';

    // Remove the plus button and add the delete button in the cloned row
    let buttonContainer = personDetailClone.querySelector('.form-group.row');
    let plusButton = buttonContainer.querySelector('.btn.btn-sm.text-white.btn-icon-split');
    if (plusButton) {
        plusButton.replaceWith(removeButton);
    }

    // Add click event listener to the remove button
    removeButton.addEventListener('click', function() {
        personDetailClone.remove();
    });

    document.getElementById('personDetails').appendChild(personDetailClone);
});
});

$(document).ready(function() {
  // Function to calculate net total
  function calculateNetTotal() {
    var netTotal = 0;
    var grandTotal = 0;
    var discount = parseFloat($("#discount").val() || 0); // Get discount value (handle empty input)
    var discountAmount = 0;

    $("#personDetails .person-detail").each(function() {
      var qty = parseFloat($(this).find("input[name='billing_qty[]']").val() || 0);
      var unitPrice = parseFloat($(this).find("input[name='unit_price[]']").val() || 0);
      var tax = parseFloat($(this).find("input[name='tax[]']").val() || 0);
      var lastPrice = (qty * unitPrice) - ((qty * unitPrice) * (tax/100)) ;

      $(this).find("input[name='last_price[]']").val(lastPrice.toFixed(2));
      netTotal += lastPrice;
    });
    //$("#personDetails input[name='net_total']").val(netTotal.toFixed(2)); // Update net total field
    document.getElementById('net_total').value = netTotal.toFixed(2);
    // if (discount > 0) {
    //   discountAmount = netTotal * (discount / 100); // Discount as a percentage
    // }

    // Calculate grand total (sub total minus discount)
    var grandTotal = netTotal - discount;
    document.getElementById('grand_total').value = grandTotal.toFixed(2);

  }

  // Call the function initially to calculate net total based on existing values
  calculateNetTotal();

  // Bind events to update net total on changes
  $("#personDetails").on("change", "input[name='billing_qty[]'], input[name='unit_price[]'], input[name='tax[]'], input[name='discount']", calculateNetTotal);
  $("#discount").on("change","", calculateNetTotal);
  // Handle adding new rows (assuming the button with ID "addPerson" does this)
  $("#addPerson").click(function() {
    // Add your logic to append a new row to the DOM (not included here)
    calculateNetTotal(); // Recalculate net total after adding a new row
  });
});
</script>
@stop
