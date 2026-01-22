@extends('layouts.app')

@section('content')

    <h1 class="h3 mb-2 text-gray-800">{{ $admission->room->room_number }} | {{ $admission->patient->name }} </h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between">
                    <div></div>
                    <div class="dropdown no-arrow show">

                    </div>
                </div>
                <form action="{{ route('medical.store',$admission->id) }}" method="post">
                    @csrf
                    @method('post')
                    <div class="card-body">
                        <div class="user-information-container text-right">
                            <p class="u_information_added_label">
                                <i>Information Added By: </i>
                                <span class="badge badge-info ml-2">{{ Auth::user()->user_name }}</span>
                                <span class="badge badge-info ml-2 current_date_time">{{ now()->format('l, F j, Y g:i A T')}}</span>
                            </p>
                        </div>
                        <!-- ... rest of your form ... -->
                    <legend class="bg-gray-200 p-1 pl-lg-4">Health Status</legend>
                        <br>
                        <div class="form-group row">
                            <label class="col-sm-2">Medical Diagnosis: <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control    @error('medical_diagnosis') is-invalid @enderror"
                                    id="medical_diagnosis" name="medical_diagnosis" value="{{ old('medical_diagnosis') }}">
                                @error('medical_diagnosis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="medical_history">Medical History: <i
                                    class="text-danger"></i></label>
                            <div class="col-sm-8">
                                <textarea class="form-control  @error('medical_history') is-invalid @enderror" id="" cols="3"
                                    rows="3" name="medical_history">{{ old('medical_history') }}</textarea>

                                @error('medical_history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="allergies">Allergies: <i class="text-danger"></i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control    @error('allergies') is-invalid @enderror"
                                    id="allergies" name="allergies" value="{{ old('allergies') }}">
                                @error('allergies')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2" for="patient_on_steroids">Patient on Steroids : <i class="text-danger"></i></label>

                            <div class="col-sm-2">
                                <label for="patient_on_steroids_yes">
                                    <input type="radio" name="patient_on_steroids"  value="1" id="patient_on_steroids_yes"> Yes</label>
                                <label for="patient_on_steroids_no">
                                    <input type="radio" name="patient_on_steroids" value="0" id="patient_on_steroids_no"> No</label>
                                @error('patient_on_steroids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <legend class="bg-gray-200 p-1 pl-lg-4">Pain Assesment</legend>
                        <br>
                        <div class="form-group row">
                            <label class="col-sm-3">Is the patient experiencing any pain? <i
                                    class="text-danger">*</i></label>
                            <div class="col-sm-2">
                                <label for="any_pain_yes">
                                    <input type="radio" name="any_pain"  value="1" id="any_pain_yes"> Yes</label>
                                <label for="any_pain_no">
                                    <input type="radio" name="any_pain" value="0" id="any_pain_no"> No</label>
                                @error('medical_diagnosis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">If YES what type of pain? <i class="text-danger"></i></label>
                            <div class="col-sm-10 row" style="margin-left: 3px">
                                <label class="col-sm-2" for="type_of_pain_acute"> <input type="checkbox" name="type_of_pain[acute]"  class="form-check-input"  id="type_of_pain_acute">  Acute Pain </label>
                                <label class="col-sm-2" for="type_of_pain_chronic"> <input type="checkbox" name="type_of_pain[chronic]"  class="form-check-input"  id="type_of_pain_chronic">  Chronic Pain</label>
                                <label class="col-sm-2" for="type_of_pain_radicular"> <input type="checkbox" name="type_of_pain[radicular]"  class="form-check-input"  id="type_of_pain_radicular">  Radicular Pain</label>
                                <label class="col-sm-2" for="type_of_pain_nocioc"> <input type="checkbox" name="type_of_pain[nocioceptive]"  class="form-check-input" id="type_of_pain_nocioc"> Nocioceptive Pain</label>
                                    <label class="col-sm-2" for="type_of_pain_nero">    <input type="checkbox" name="type_of_pain[neropathic]"  class="form-check-input" id="type_of_pain_nero"> Neropathic Pain</label>

                                @error('medical_diagnosis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2">Pain Score </label>
                            <div class="col-sm-9">
                                <input type="range" id="moodRange" name="pain_score" min="1" max="10"
                                    value="{{ old('pain_score', 5) }}" class="form-control">
                            </div>
                            <div class="col-sm-1"> <span id="moodEmoji">&#x1F60A;</span></div>
                        </div>

                        <legend class="bg-gray-200 p-1 pl-lg-4">Vital signs</legend>
                         <br>
                        <div class="form-group row">
                            <div class="col-md-3"><label for="">Temperature ( )</label>
                                <input value="{{ old('temperature') }}" class="form-control" type="number" name="temperature"></div>
                            <div class="col-md-3"><label for="">Blood Pressure (mmHg)</label>
                                <input value="{{ old('blood_pressure') }}"  class="form-control" type="text" name="blood_pressure"></div>
                            <div class="col-md-3"><label for="">Heart Rate (bpm)</label>
                                 <input value="{{ old('heart_reate') }}"  class="form-control" type="number" name="heart_reate"></div>
                            <div class="col-md-3"><label for="">Respiratory Rate (breaths pm)</label>
                                <input value="{{ old('breaths_per_minute') }}" class="form-control" type="number" name="breaths_per_minute"></div>
                        </div>

                        <div>

                            <legend class="bg-gray-200 p-1 pl-lg-4">Body system review</legend>
                            <br>
                            <table class="table table-bordered dataTable">
                                <tr>
                                    <th width="30%"></th>
                                    <th width="5%">Normal</th>
                                    <th width="10%">Not Normal</th>
                                    <th width="55%">Comment</th>
                                </tr>
                                <tr>
                                    <td>Sensory (Eyes, ears, nose, throat)</td>
                                    <td><input type="radio" value="0" name="sensory" id=""></td>
                                    <td><input type="radio" value="1" name="sensory" id=""></td>
                                    <td><input type="text" class="form-control" name="sensory_comment" value="{{ old('sensory_comment') }}" id=""></td>
                                </tr>
                                <tr>
                                    <td>Musculoskeletal (Mobility) </td>
                                    <td><input type="radio" value="0" name="musculoskelete" id=""></td>
                                    <td><input type="radio" value="1" name="musculoskelete" id=""></td>
                                    <td><input type="text" class="form-control" name="musculoskelete_comment" value="{{ old('musculoskelete_comment') }}" id=""></td>
                                </tr>
                                <tr>
                                    <td>Integumentary ( Rashes, irritation, pale)
                                    </td>
                                    <td><input type="radio" value="0" name="integumentary" id=""></td>
                                    <td><input type="radio" value="1" name="integumentary" id=""></td>
                                    <td><input type="text" class="form-control" name="integumentary_comment" value="{{ old('integumentary_comment') }}" id=""></td>
                                </tr>
                                <tr>
                                    <td>Neurovascular ( Pain, seizures, sensation)</td>
                                    <td><input type="radio" value="0" name="neurovascular" id=""></td>
                                    <td><input type="radio" value="1" name="neurovascular" id=""></td>
                                    <td><input type="text" class="form-control" name="neurovascular_comment" value="{{ old('neurovascular_comment') }}" id=""></td>
                                </tr>
                                <tr>
                                    <td> Circulatory ( Skin, oedema)</td>
                                    <td><input type="radio" value="0" name="circularory" id=""></td>
                                    <td><input type="radio" value="1" name="circularory" id=""></td>
                                    <td><input type="text" class="form-control" name="circularory_comment" value="{{ old('circularory_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td> Respiratory ( Shortness of breath)</td>
                                    <td><input type="radio" value="0" name="respiratory" id=""></td>
                                    <td><input type="radio" value="1" name="respiratory" id=""></td>
                                    <td><input type="text" class="form-control" name="respiratory_comment" value="{{ old('respiratory_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td> Dental ( Dentures)</td>
                                    <td><input type="radio" value="0" name="dental" id=""></td>
                                    <td><input type="radio" value="1" name="dental" id=""></td>
                                    <td><input type="text" class="form-control" name="dental_comment" value="{{ old('dental_comment') }}" id="">
                                    </td>
                                </tr>
                                <tr>
                                    <td> Psychosocial ( Hallucinations, delusions)</td>
                                    <td><input type="radio" value="0" name="psychosocial" id=""></td>
                                    <td><input type="radio" value="1" name="psychosocial" id=""></td>
                                    <td><input type="text" class="form-control" name="psychosocial_comment" value="{{ old('psychosocial_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td> Nutrition (Diet, weight change, swallowing)</td>
                                    <td><input type="radio" value="0" name="nutrition" id=""></td>
                                    <td><input type="radio" value="1" name="nutrition" id=""></td>
                                    <td><input type="text" class="form-control" name="nutrition_comment" value="{{ old('nutrition_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td>Elimination (Constipation, incontinence)</td>
                                    <td><input type="radio" value="1" name="elimination" id=""> Yes</td>
                                    <td><input type="radio" value="0" name="elimination" id=""> No</td>
                                    <td><input type="text" class="form-control" name="elimination_comment" value="{{ old('elimination_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td> Does the patient have trouble sleeping?</td>
                                    <td><input type="radio" value="1" name="trouble_sleeping" id=""> Yes</td>
                                    <td><input type="radio" value="0" name="trouble_sleeping" id=""> No</td>
                                    <td><input type="text" class="form-control" name="trouble_sleeping_comment" value="{{ old('trouble_sleeping_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td>Does the patient experience nausea & vomiting?</td>
                                    <td><input type="radio" value="1" name="nausea_and_vomiting" id=""> Yes</td>
                                    <td><input type="radio" value="0" name="nausea_and_vomiting" id=""> No</td>
                                    <td><input type="text" class="form-control" name="nausea_and_vomiting_comment" value="{{ old('nausea_and_vomiting_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td>Does the patient have problem in breathing?</td>
                                    <td><input type="radio" value="1" name="breathing_problem" id=""> Yes</td>
                                    <td><input type="radio" value="0" name="breathing_problem" id=""> No</td>
                                    <td><input type="text" class="form-control" name="breathing_problem_comment" value="{{ old('breathing_problem_comment') }}"id=""></td>
                                </tr>
                                <tr>
                                    <td>Does the patient have appetite problem?</td>
                                    <td><input type="radio" value="1" name="appetite_problem" id=""> Yes</td>
                                    <td><input type="radio" value="0" name="appetite_problem" id=""> No</td>
                                    <td><input type="text" class="form-control" name="appetite_problem_comment" value="{{ old('appetite_problem_comment') }}"id=""></td>
                                </tr>

                            </table>
                        </div>
                        <legend class="bg-gray-200 p-1 pl-lg-4">List of Current Medication</legend>
                        <br>
                        <div id="personDetails" class="form-group row">
                            <div class="person-detail col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Medication Name" name="name[]">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" name="dose[]" placeholder="Dose">
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="frequency[]" placeholder="Frequency">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="route[]" placeholder="Route">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="indication[]" placeholder="Indication">
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

                        <br><br>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 d-flex justify-content-sm-end custom-buttons-container">
                            <a href="{{ route('admission.index') }}" class="btn btn-info">
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
    <style>
        #moodEmoji {
            font-size: 3em;
            /* Adjust the font size as needed */
        }
    </style>
@stop

@section('third_party_scripts')
    <script src="{{ asset('plugin/select2/select2.min.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>
    <script>
        function updateMoodEmoji() {
            var rangeValue = document.getElementById("moodRange").value;
            var moodEmoji = document.getElementById("moodEmoji");

            // Using Unicode characters for emojis from 😀 to 😢
            var emojiCode = 0x1F604;

            switch (parseInt(rangeValue)) {
                case 1:
                    emojiCode = 0x1F602;
                    break;
                case 2:
                    emojiCode = 0x1F601;
                    break;
                case 3:
                    emojiCode = 0x1F60A;
                    break;
                case 4:
                    emojiCode = 0x1F60C;
                    break;
                case 5:
                    emojiCode = 0x1F610;
                    break;
                case 6:
                    emojiCode = 0x1F615;
                    break;
                case 7:
                    emojiCode = 0x1F612;
                    break;
                case 8:
                    emojiCode = 0x1F616;
                    break;
                case 9:
                    emojiCode = 0X1F613;
                    break;
                case 10:
                    emojiCode = 0x1F621;
                    break;
            }

            moodEmoji.innerHTML = String.fromCodePoint(emojiCode);
        }

        // Attach the updateMoodEmoji function to the input event of the range input
        document.getElementById("moodRange").addEventListener("input", updateMoodEmoji);

        // Initial update
        updateMoodEmoji();
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


    </script>
@stop
