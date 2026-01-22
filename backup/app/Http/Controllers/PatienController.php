<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\patient;
use App\Models\district;
use App\Models\relationship;
use Illuminate\Http\Request;
use App\DataTables\patientDataTable;
use Illuminate\Support\Facades\Auth;

class PatienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(patientDataTable $dataTable)
    {
        return $dataTable->render("patients.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $districts = district::all();
        $relationships = relationship::all();
        return view('patients.create', compact('districts', 'relationships'));
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
                'date_of_birth' => 'required|date',
                'age' => 'required',
                'home' => 'nullable|min:1',
                'city' => 'nullable|min:1',
                'district' => 'required|min:1',
                'distance_to_suwa_arana' => 'nullable:min:1',
                'monthly_family_income' => 'nullable|numeric|min:1',
                'monthly_loan_diductions' => 'nullable|numeric|min:1',
                'cost_of_travel' => 'nullable|numeric|min:1',
                'father_name' => 'required|min:2|max:255',
                'father_nic' => 'nullable|min:10|max:13',
                'father_occupation' => 'nullable|min:2|max:250',
                'father_contact' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',
                'father_contact2' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',

                'mother_name' => 'required|min:2|max:255',
                'mother_nic' => 'nullable|min:10|max:13',
                'mother_occupation' => 'nullable|min:2|max:100',
                'mother_contact' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',
                'mother_contact2' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',
            ]
        );

        switch ($request->guardian) {
            case 'o':
                $this->validate($request, [
                    'guardian_name' => 'required|min:2|max:255',
                    'guardian_nic' => 'nullable|min:2|max:13',
                    'guartian_contact' => 'nullable|numeric|digits:10',
                    'guardian_contact2' => 'nullable|numeric|digits:10',
                    'guardian_occupation' => 'nullable|min:2|max:100',
                    'relationship' => 'required|min:1',
                ]);
                $guardian_name = $request->guardian_name;
                $guardian_nic = $request->guardian_nic;
                $guartian_contact = $request->guartian_contact;
                $guardian_occupation = $request->guardian_occupation;
                $guardian_relationship = $request->relationship;
                $guardian_contact2 = $request->guardian_contact2;
                break;

            case 'f':
                $guardian_name = $request->father_name;
                $guardian_nic = $request->father_nic;
                $guartian_contact = $request->father_contact;
                $guardian_contact2 = $request->father_address;
                $guardian_occupation = $request->father_occupation;

                $guardian_relationship = 'Father';
                break;
            case 'm':
                $guardian_name = $request->mother_name;
                $guardian_nic = $request->mother_nic;
                $guartian_contact = $request->mother_contact;
                $guardian_contact2 = $request->mother_address;
                $guardian_occupation = $request->mother_occupation;

                $guardian_relationship = 'Mother';
                break;
        }

        $age_at_register = Carbon::createFromFormat('Y-m-d', $request->date_of_birth);
        $maxId = Patient::max('id');
        $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

        $patient = patient::create(
            [
                'patient_id' => $formattedId,
                'name' => $request->name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age_at_register' => $request->age,
                'monthly_family_income' => $request->monthly_family_income,
                'monthly_loan_diductions' => $request->monthly_loan_diductions,
                'transport_mode' => json_encode($request->transport_mode),
                'cost_of_travel' => $request->cost_of_travel,
                'financial_support' => json_encode($request->financial_support),
                'wdu_reside' => json_encode($request->wdu_reside),

                'father_name' => $request->father_name,
                'father_nic' => $request->father_nic,
                'father_occupation' => $request->father_occupation,
                'father_contact' => $request->father_contact,
                'father_contact2' => $request->father_contact2,

                'mother_name' => $request->mother_name,
                'mother_nic' => $request->mother_nic,
                'mother_occupation' => $request->mother_occupation,
                'mother_contact' => $request->mother_contact,
                'mother_contact2' => $request->mother_contact2,

                'guardian_name' => $guardian_name,
                'guardian_nic' => $guardian_nic,
                'guartian_contact' => $guartian_contact,
                'guardian_occupation' => $guardian_occupation,
                'guardian_relationship' => $guardian_relationship,
                'guardian_contact2' => $guardian_contact2,

            ]
        );

        $address = $patient->address()->create([
            'home' => $request->home,
            'street' => $request->street,
            'city' => $request->city,
            'district_id' => $request->district,
            'distance_to_suwa_arana' => $request->distance_to_suwa_arana
        ]);

        // $patient->person()->create([
        //     'name' => $request->guardian_name,
        //     'relationship_id' => $request->relationship,
        //     'nic' => $request->nic,
        //     'is_guardian' => 1,
        //     'contact_number_one' => $request->contact_number_one,
        //     'contact_number_two' => $request->contact_number_two
        // ]);


        return redirect()->route('patient.index')->with('message', 'patient registerd');
    }

    /**
     * Display the specified resource.
     */
    public function show(patient $patient)
    {
        $age = self::calculateAge($patient->date_of_birth);
        return view('patients.show', compact('patient', 'age'));
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
    public function edit(patient $patient)
    {
        $districts = district::all();
        $relationships = relationship::all();
        return view('patients.edit', compact('districts', 'relationships', 'patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, patient $patient)
    {
        $this->validate(
            $request,
            [
                'patient_id' => 'required|min:1',
                'name' => 'required|min:2|max:255',
                'gender' => 'required|min:1',
                'date_of_birth' => 'required|date',
                'age' => 'required',
                'home' => 'nullable|min:1',
                'city' => 'nullable|min:1',
                'district' => 'required|min:1',
                'distance_to_suwa_arana' => 'nullable:min:1',
                'monthly_family_income' => 'nullable|numeric|min:1',
                'monthly_loan_diductions' => 'nullable|numeric|min:1',
                'cost_of_travel' => 'nullable|numeric|min:1',
                'father_name' => 'required|min:2|max:255',
                'father_nic' => 'nullable|min:10|max:13',
                'father_occupation' => 'nullable|min:2|max:250',
                'father_contact' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',
                'father_contact2' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',

                'mother_name' => 'required|min:2|max:255',
                'mother_nic' => 'nullable|min:10|max:13',
                'mother_occupation' => 'nullable|min:2|max:100',
                'mother_contact' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',
                'mother_contact2' => 'nullable|digits:10|regex:/^\d{10}$/|numeric',
            ]
        );

        switch ($request->guardian) {
            case 'o':
                $this->validate($request, [
                    'guardian_name' => 'required|min:2|max:255',
                    'guardian_nic' => 'nullable|min:2|max:13',
                    'guartian_contact' => 'nullable|numeric|digits:10',
                    'guardian_contact2' => 'nullable|numeric|digits:10',
                    'guardian_occupation' => 'nullable|min:2|max:100',
                    'relationship' => 'nullable|min:1',
                ]);
                $guardian_name = $request->guardian_name;
                $guardian_nic = $request->guardian_nic;
                $guartian_contact = $request->guardian_contact;
                $guardian_occupation = $request->guardian_occupation;
                $guardian_relationship = $request->relationship;
                $guardian_contact2 = $request->guardian_contact2;
                break;

            case 'f':
                $guardian_name = $request->father_name;
                $guardian_nic = $request->father_nic;
                $guartian_contact = $request->father_contact;
                $guardian_contact2 = $request->father_address;
                $guardian_occupation = $request->father_occupation;
                $guartian_relationship_id = 1;
                $guardian_relationship = 'Father';
                break;
            case 'm':
                $guardian_name = $request->mother_name;
                $guardian_nic = $request->mother_nic;
                $guartian_contact = $request->mother_contact;
                $guardian_contact2 = $request->mother_address;
                $guardian_occupation = $request->mother_occupation;
                $guartian_relationship_id = 2;
                $guardian_relationship = 'Mother';
                break;
        }

        $age_at_register = Carbon::createFromFormat('Y-m-d', $request->date_of_birth);
        $getPatientId = $request->patient_id;
        $trimPatientId = ltrim($getPatientId, '0');
        $patientID = str_pad($trimPatientId, 4, '0', STR_PAD_LEFT);

        $patient->update(
            [
                'patient_id' => $request->patient_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age_at_register' => $request->age,
                'monthly_family_income' => $request->monthly_family_income,
                'monthly_loan_diductions' => $request->monthly_loan_diductions,
                'transport_mode' => json_encode($request->transport_mode),
                'cost_of_travel' => $request->cost_of_travel,
                'financial_support' => json_encode($request->financial_support),
                'wdu_reside' => json_encode($request->wdu_reside),

                'father_name' => $request->father_name,
                'father_nic' => $request->father_nic,
                'father_occupation' => $request->father_occupation,
                'father_contact' => $request->father_contact,
                'father_contact2' => $request->father_contact2,

                'mother_name' => $request->mother_name,
                'mother_nic' => $request->mother_nic,
                'mother_occupation' => $request->mother_occupation,
                'mother_contact' => $request->mother_contact,
                'mother_contact2' => $request->mother_contact2,

                'guardian_name' => $guardian_name,
                'guardian_nic' => $guardian_nic,
                'guartian_contact' => $guartian_contact,
                'guardian_occupation' => $guardian_occupation,
                'guardian_relationship' => $guardian_relationship,
                'guardian_contact2' => $guardian_contact2,
            ]
        );

        //   print_r($patient);
        $patient->address()->updateOrCreate([
            'home' => $request->home,
            'street' => $request->street,
            'city' => $request->city,
            'district_id' => $request->district,
            'distance_to_suwa_arana' => $request->distance_to_suwa_arana
        ]);



        return redirect()->route('patient.index')->with('message', 'patient updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient)
    {
        $patient->update([
            'deleted_by' => Auth::user()->id
        ]);

        $patient->delete();
        return redirect()->route('patient.index')->with('message', 'patient updated');
    }
}
