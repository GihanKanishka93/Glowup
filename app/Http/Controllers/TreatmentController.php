<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Treatment;
use App\Models\Bill;
use App\Models\Prescription;
use App\Models\VaccinationInfo;

class TreatmentController extends Controller
{

    public function show($pet_id)
    {
        // Fetch pet details
        $pet = Pet::findOrFail($pet_id);

        // Fetch treatments for the pet
        $treatments = Treatment::where('pet_id', $pet_id)
            ->orderBy('treatment_date', 'desc')
            ->with(['bills', 'prescriptions', 'vaccinations'])
            ->paginate(10);

        // Calculate total billing amount
        // $totalBillingAmount = $treatments->sum(function ($treatment) {
        //     return $treatment->bill->total;
        // });

       // Find the next billing date
       $nextBillingDate = $treatments->first()->treatment_date ?? 'N/A';

       return view('medical-history.show', compact('pet', 'treatments', 'nextBillingDate'));

    }

    public function getTreatmentDetails(Request $request)
    {
        $petId = $request->query('pet_id');

        // Fetch treatment details from the database
        $treatments = Treatment::where('pet_id', $petId)
            ->orderBy('treatment_date', 'desc')
            ->get();

        if ($treatments->isNotEmpty()) {
            $pet = Pet::find($petId);
            $response = [
                'success' => true,
                'data' => [
                    'pet_name' => $pet->name,
                    'doctor_name' => $treatments->first()->doctor->name,
                    'pet_id' => $pet->id,
                    'pet_type' => $pet->category->name,
                    'pet_breed' => $pet->breed->name,
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