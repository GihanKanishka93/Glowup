<?php

namespace App\Http\Controllers;

use App\Models\admission;
use DateTime;
use App\Models\room;
use App\Models\patient;
use App\Models\Pet;
use Illuminate\Http\Request;

class ajaxController extends Controller
{

    public function getPetDetails(request $request)
    {

        $id = $request->input('pet');
        $pet = Pet::where('id', $id)->get()->first();
        if ($pet) {
            $dob = new DateTime($pet->date_of_birth);
            $now = new DateTime();
            $diff = $dob->diff($now);
            $ageYears = $diff->y;
            $ageMonths = $diff->m;

            // Add age in years and months to the $patient object
            $pet->age = "$ageYears years and $ageMonths months";
        }

        return response()->json($pet);
    }

    public function getPetion(request $request)
    {

        $id = $request->input('patient');
        $patient = patient::where('id', $id)->with('address')->get()->first();
        if ($patient) {
            $dob = new DateTime($patient->date_of_birth);
            $now = new DateTime();
            $diff = $dob->diff($now);
            $ageYears = $diff->y;
            $ageMonths = $diff->m;

            // Add age in years and months to the $patient object
            $patient->age = "$ageYears years and $ageMonths months";
        }

        return response()->json([
            $patient
        ]);
    }


    public function getGuardiants(request $request)
    {
        $id = $request->input('patient');
        $patient = patient::where('id', $id)->get()->first();
        return response()->json([
            $patient->person
        ]);
    }

    public function roomItems(request $request)
    {
        $id = $request->input('room');
        $room = room::where('id', $id)->get()->first();
        return response()->json([
            $room->item
        ]);
    }

    public function admissionItems(request $request)
    {
        $id = $request->input('admission');
        $admission = admission::where('id', $id)->get()->first();
        return response()->json([
            $admission->item
        ]);
    }



}