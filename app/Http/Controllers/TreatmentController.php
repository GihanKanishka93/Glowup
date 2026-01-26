<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Bill;
use App\Models\Prescription;


class TreatmentController extends Controller
{

    public function show($patient_id)
    {
        // Fetch patient details
        $patient = Patient::findOrFail($patient_id);

        // Fetch treatments for the patient
        $treatments = Treatment::where('patient_id', $patient_id)
            ->orderBy('treatment_date', 'desc')
            ->with(['bills', 'prescriptions'])
            ->paginate(10);

        // Calculate total billing amount
        // $totalBillingAmount = $treatments->sum(function ($treatment) {
        //     return $treatment->bill->total;
        // });

        // Find the next billing date
        $nextBillingDate = $treatments->first()->treatment_date ?? 'N/A';

        return view('medical-history.show', compact('patient', 'treatments', 'nextBillingDate'));

    }

    public function getTreatmentDetails(Request $request)
    {
        $patientId = $request->query('patient_id');

        // Fetch treatment details from the database
        $treatments = Treatment::where('patient_id', $patientId)
            ->orderBy('treatment_date', 'desc')
            ->get();

        if ($treatments->isNotEmpty()) {
            $patient = Patient::find($patientId);
            $response = [
                'success' => true,
                'data' => [
                    'patient_name' => $patient->name,
                    'doctor_name' => $treatments->first()->doctor->name,
                    'patient_id' => $patient->id,
                    'patient_gender' => $patient->gender,
                    'history_complaint' => $treatments->first()->history_complaint,
                    'clinical_observation' => $treatments->first()->clinical_observation,
                    'remarks' => $treatments->first()->remarks,
                    'treatment_history' => []
                ]
            ];

            foreach ($treatments as $treatment) {
                $response['data']['treatment_history'][] = [
                    'treatment_date' => $treatment->treatment_date,
                    'billing_id' => $treatment->billing_id,
                    'observation' => $treatment->observation,
                    'remarks' => $treatment->remarks
                ];
            }

            return response()->json($response);
        } else {
            return response()->json(['success' => false, 'message' => 'No treatment details found.']);
        }
    }
}