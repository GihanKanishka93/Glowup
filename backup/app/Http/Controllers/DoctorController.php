<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Doctor;
use App\DataTables\doctorDataTable;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    //
    //
    /**
     * Display a listing of the resource.
     */
    public function index(doctorDataTable $dataTable)
    {
        return $dataTable->render("doctor.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required|min:2|max:255',
                'gender' => 'required|min:1',

            ]
        );

        $maxId = Doctor::max('id');
        $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

        $doctor = Doctor::create(
            [
                'doctor_id' => $formattedId,
                'name' => $request->name,
                'gender' => $request->gender,
                'designation' => $request->designation,
                'address' => $request->address,
                'contact_no' => $request->contactno,
                'email' => $request->email,

            ]
        );




        return redirect()->route('doctor.index')->with('message', 'Doctor registerd');
    }

    /**
     * Display the specified resource.
     */
    public function show(doctor $doctor)
    {
        return view('doctor.show', compact('doctor'));
    }

    protected static function calculateAge($dateOfBirth)
    {
        // Calculate age using Carbon\Carbon
        $dob = Carbon::parse($dateOfBirth);
        $now = Carbon::now();
        $age = $dob->diff($now);

        // Format age as 'years' and 'months'
        $ageString = '';
        if ($age->y > 0) {
            $ageString .= $age->y . ' years';
        } else {
            $ageString .= '0 years';
        }
        if ($age->m > 0) {
            $ageString .= ', ' . $age->m . ' months';
        } else {
            $ageString .= ', 0 months';
        }

        return $ageString;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(doctor $doctor)
    {
        return view('doctor.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, doctor $doctor)
    {
        $this->validate(
            $request,
            [
                'doctor_id' => 'required|min:1',
                'name' => 'required|min:2|max:255',
                'gender' => 'required|min:1',

            ]
        );

        // $age_at_register = Carbon::createFromFormat('Y-m-d', $request->date_of_birth);
        $getDoctorId = $request->doctor_id;
        $trimDoctorId = ltrim($getDoctorId, '0');
        $doctorID = str_pad($trimDoctorId, 4, '0', STR_PAD_LEFT);

        $doctor->update(
            [
                'doctor_id' => $doctorID,
                'name' => $request->name,
                'gender' => $request->gender,
                'designation' => $request->designation,
                'address' => $request->address,
                'contact_no' => $request->contactno,
                'email' => $request->email
            ]
        );


        return redirect()->route('doctor.index')->with('message', 'Doctor Details updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(doctor $doctor)
    {
        $doctor->update([
            'deleted_by' => Auth::user()->id
        ]);

        $doctor->delete();
        return redirect()->route('doctor.index')->with('message', 'Doctor updated');
    }
}