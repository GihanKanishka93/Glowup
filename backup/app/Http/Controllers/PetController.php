<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pet;
use App\Models\PetCategory;
use App\Models\PetBreed;
use App\DataTables\petDataTable;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(petDataTable $dataTable)
    {
        return $dataTable->render("pet.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        return view('pet.create', compact('petcategory', 'breed'));
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



        $age_at_register = Carbon::createFromFormat('Y-m-d', $request->date_of_birth);
        $maxId = Pet::max('id');
        $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

        $patient = Pet::create(
            [
                'pet_id' => $formattedId,
                'name' => $request->name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age_at_register' => $request->age,
                'weight' => $request->weight,
                'color' => $request->colour,
                'pet_category' => $request->pet_category,
                'pet_breed' => $request->breed,
                'remarks' => $request->remarks,

                'owner_name' => $request->owner_name,
                'owner_nic' => $request->owner_nic,
                'owner_contact' => $request->owner_contact,
                'owner_address' => $request->address,
                'owner_email' => $request->owner_email,

            ]
        );




        return redirect()->route('pet.index')->with('message', 'Pet registerd');
    }

    /**
     * Display the specified resource.
     */
    public function show(pet $pet)
    {
        return view('pet.show', compact('pet'));
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
    public function edit(pet $pet)
    {
        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        return view('pet.edit', compact('petcategory', 'breed', 'pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pet $pet)
    {
        $this->validate(
            $request,
            [
                'pet_id' => 'required|min:1',
                'name' => 'required|min:2|max:255',
                'gender' => 'required|min:1',

            ]
        );

        // $age_at_register = Carbon::createFromFormat('Y-m-d', $request->date_of_birth);
        $getPatientId = $request->pet_id;
        $trimPatientId = ltrim($getPatientId, '0');
        $patientID = str_pad($trimPatientId, 4, '0', STR_PAD_LEFT);

        $pet->update(
            [
                'pet_id' => $request->pet_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age_at_register' => $request->age,
                'weight' => $request->weight,
                'color' => $request->colour,
                'pet_category' => $request->pet_category,
                'pet_breed' => $request->breed,
                'remarks' => $request->remarks,

                'owner_name' => $request->owner_name,
                'owner_nic' => $request->owner_nic,
                'owner_contact' => $request->owner_contact,
                'owner_address' => $request->address,
                'owner_email' => $request->owner_email
            ]
        );


        return redirect()->route('pet.index')->with('message', 'Pet Details updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pet $pet)
    {
        $pet->update([
            'deleted_by' => Auth::user()->id
        ]);

        $pet->delete();
        return redirect()->route('pet.index')->with('message', 'Pet updated');
    }
}