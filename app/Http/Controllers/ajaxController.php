<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use DateTime;
use App\Models\Room;
use App\Models\Patient;
use Illuminate\Http\Request;

class ajaxController extends Controller
{

    public function getPatientDetails(request $request)
    {

        $id = $request->input('patient');
        $patient = Patient::where('id', $id)->get()->first();
        if ($patient) {
            $dob = new DateTime($patient->date_of_birth);
            $now = new DateTime();
            $diff = $dob->diff($now);
            $ageYears = $diff->y;
            $ageMonths = $diff->m;

            // Add age in years and months to the $patient object
            $patient->age = "$ageYears years and $ageMonths months";
        }

        return response()->json($patient);
    }

    public function getPetion(request $request)
    {

        $id = $request->input('patient');
        $patient = Patient::where('id', $id)->get()->first();
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
        $patient = Patient::where('id', $id)->get()->first();
        return response()->json([
            $patient->person
        ]);
    }

    public function roomItems(request $request)
    {
        $id = $request->input('room');
        $room = Room::where('id', $id)->get()->first();
        return response()->json([
            $room->item
        ]);
    }

    public function admissionItems(request $request)
    {
        $id = $request->input('admission');
        $admission = Admission::where('id', $id)->get()->first();
        return response()->json([
            $admission->item
        ]);
    }



}