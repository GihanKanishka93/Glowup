<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use App\Models\Admission;
use Illuminate\Http\Request;

class MedicalController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index','store']]);
        $this->middleware('permission:admission-medical-create', ['only' => ['create', 'store', 'update']]);
        //   $this->middleware('permission:room-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Admission $admission)
    {
        if ($admission->medical) {
            return view('admition.medical.edit', compact('admission'));
        }
        return view('admition.medical.create', compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Admission $admission, Request $request)
    {
        $request->validate([
            'medical_diagnosis' => 'required|min:1|max:250',

        ]);

        $admission->medical()->create(
            [
                'patient_id' => $admission->patient_id,
                'medical_diagnosis' => $request->medical_diagnosis,
                'medical_history' => $request->medical_history,
                'allergies' => $request->allergies,
                'patient_on_steroids' => $request->patient_on_steroids,
                'any_pain' => $request->any_pain,
                'type_of_pain' => json_encode($request->type_of_pain),
                'pain_score' => $request->pain_score,
                'temperature' => $request->temperature,
                'blood_pressure' => $request->blood_pressure,
                'heart_reate' => $request->heart_reate,
                'breaths_per_minute' => $request->breaths_per_minute,
                'sensory' => $request->sensory,
                'musculoskelete' => $request->musculoskelete,
                'integumentary' => $request->integumentary,
                'neurovascular' => $request->neurovascular,
                'circularory' => $request->circularory,
                'respiratory' => $request->respiratory,
                'dental' => $request->dental,
                'psychosocial' => $request->psychosocial,
                'nutrition' => $request->nutrition,
                'elimination' => $request->elimination,
                'trouble_sleeping' => $request->trouble_sleeping,
                'nausea_and_vomiting' => $request->nausea_and_vomiting,
                'breathing_problem' => $request->breathing_problem,
                'appetite_problem' => $request->appetite_problem,
                'sensory_comment' => $request->sensory_comment,
                'musculoskelete_comment' => $request->musculoskelete_comment,
                'integumentary_comment' => $request->integumentary_comment,
                'neurovascular_comment' => $request->neurovascular_comment,
                'circularory_comment' => $request->circularory_comment,
                'respiratory_comment' => $request->respiratory_comment,
                'dental_comment' => $request->dental_comment,
                'psychosocial_comment' => $request->psychosocial_comment,
                'nutrition_comment' => $request->nutrition_comment,
                'elimination_comment' => $request->elimination_comment,
                'trouble_sleeping_comment' => $request->trouble_sleeping_comment,
                'nausea_and_vomiting_comment' => $request->nausea_and_vomiting_comment,
                'breathing_problem_comment' => $request->breathing_problem_comment,
                'appetite_problem_comment' => $request->appetite_problem_comment
            ]
        );

        $medicationData = [];

        if ($request->has('name')) {
            foreach ($request->name as $key => $name) {
                if ($name != '') {
                    $medicationData[] = [
                        'patient_id' => $admission->patient_id,
                        'name' => $name,
                        'dose' => $request->dose[$key] ?? null,
                        'frequency' => $request->frequency[$key] ?? null,
                        'route' => $request->route[$key] ?? null,
                        'indication' => $request->indication[$key] ?? null,
                    ];
                }
            }
        }

        // Save guest details using createMany
        if (!empty($medicationData)) {
            $admission->medication()->createMany($medicationData);
        }

        return redirect()->route('admission.index')->with('message', 'Medical details added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medical $medical)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medical $medical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admission $admission, Medical $medical)
    {
        $request->validate([
            'medical_diagnosis' => 'required|min:1|max:250',

        ]);

        $admission->medical()->update(
            [
                'patient_id' => $admission->patient_id,
                'medical_diagnosis' => $request->medical_diagnosis,
                'medical_history' => $request->medical_history,
                'allergies' => $request->allergies,
                'patient_on_steroids' => $request->patient_on_steroids,
                'any_pain' => $request->any_pain,
                'type_of_pain' => json_encode($request->type_of_pain),
                'pain_score' => $request->pain_score,
                'temperature' => $request->temperature,
                'blood_pressure' => $request->blood_pressure,
                'heart_reate' => $request->heart_reate,
                'breaths_per_minute' => $request->breaths_per_minute,
                'sensory' => $request->sensory,
                'musculoskelete' => $request->musculoskelete,
                'integumentary' => $request->integumentary,
                'neurovascular' => $request->neurovascular,
                'circularory' => $request->circularory,
                'respiratory' => $request->respiratory,
                'dental' => $request->dental,
                'psychosocial' => $request->psychosocial,
                'nutrition' => $request->nutrition,
                'elimination' => $request->elimination,
                'trouble_sleeping' => $request->trouble_sleeping,
                'nausea_and_vomiting' => $request->nausea_and_vomiting,
                'breathing_problem' => $request->breathing_problem,
                'appetite_problem' => $request->appetite_problem,
                'sensory_comment' => $request->sensory_comment,
                'musculoskelete_comment' => $request->musculoskelete_comment,
                'integumentary_comment' => $request->integumentary_comment,
                'neurovascular_comment' => $request->neurovascular_comment,
                'circularory_comment' => $request->circularory_comment,
                'respiratory_comment' => $request->respiratory_comment,
                'dental_comment' => $request->dental_comment,
                'psychosocial_comment' => $request->psychosocial_comment,
                'nutrition_comment' => $request->nutrition_comment,
                'elimination_comment' => $request->elimination_comment,
                'trouble_sleeping_comment' => $request->trouble_sleeping_comment,
                'nausea_and_vomiting_comment' => $request->nausea_and_vomiting_comment,
                'breathing_problem_comment' => $request->breathing_problem_comment,
                'appetite_problem_comment' => $request->appetite_problem_comment
            ]
        );


        if ($request->has('name')) {
            foreach ($request->name as $key => $name) {
                if (!empty($name)) {
                    $admission->medication()
                        ->updateOrCreate(
                            ['id' => $key], // If 'id' is the primary key of the Guest model
                            [
                                'name' => $name,
                                'dose' => $request->dose[$key] ?? null,
                                'frequency' => $request->frequency[$key] ?? null,
                                'route' => $request->route[$key] ?? null,
                                'indication' => $request->indication[$key] ?? null
                            ]
                        );
                } else {
                    $admission->medication()->where('id', '=', $key)->delete();
                }
            }
        }

        return redirect()->route('admission.index')->with('message', 'Medical details updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medical $medical)
    {
        //
    }
}
