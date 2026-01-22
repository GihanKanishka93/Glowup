<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Treatment;
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
    public function show($doctorId)
    {
        $doctor = Doctor::where('id', $doctorId)
            ->orWhere('doctor_id', $doctorId)
            ->firstOrFail();

        $safeParse = function ($value) {
            if (!$value || in_array($value, ['0000-00-00', '1970-01-01'], true)) {
                return null;
            }
            try {
                return Carbon::parse($value);
            } catch (\Throwable $th) {
                return null;
            }
        };

        $treatmentsBase = Treatment::where('doctor_id', $doctor->id);

        $totalTreatments = (clone $treatmentsBase)->count();
        $patientsServed = (clone $treatmentsBase)->distinct('pet_id')->count('pet_id');
        $lastTreatment = (clone $treatmentsBase)->orderByDesc('treatment_date')->first();
        $lastActiveDate = $safeParse($lastTreatment?->treatment_date);

        $upcomingFollowUp = (clone $treatmentsBase)
            ->whereNotNull('next_clinic_date')
            ->whereNotIn('next_clinic_date', ['', '0000-00-00'])
            ->orderBy('next_clinic_date')
            ->first();
        $nextFollowUpDate = $safeParse($upcomingFollowUp?->next_clinic_date);

        $outstandingBills = (clone $treatmentsBase)
            ->whereHas('bill', function ($query) {
                $query->whereNull('payment_status')->orWhere('payment_status', '!=', 1);
            })
            ->count();

        $recentTreatments = (clone $treatmentsBase)
            ->with(['pet' => function ($relation) {
                $relation->withTrashed();
            }, 'bill'])
            ->orderByDesc('treatment_date')
            ->limit(10)
            ->get()
            ->map(function ($treatment) use ($safeParse) {
                $treatment->formatted_treatment_date = optional($safeParse($treatment->treatment_date))->format('d M Y');
                $treatment->formatted_next_visit = optional($safeParse($treatment->next_clinic_date))->format('d M Y');
                return $treatment;
            });

        return view('doctor.show', [
            'doctor' => $doctor,
            'treatments' => $recentTreatments,
            'patientsServed' => $patientsServed,
            'totalTreatments' => $totalTreatments,
            'lastActiveDate' => $lastActiveDate,
            'upcomingFollowUp' => $upcomingFollowUp,
            'nextFollowUpDate' => $nextFollowUpDate,
            'outstandingBills' => $outstandingBills,
        ]);
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
