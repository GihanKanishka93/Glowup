<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
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
    public function store(StorePetRequest $request)
    {
        $maxId = Pet::max('id');
        // $formattedId = str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);
        $formattedId = 'CV' . str_pad(($maxId + 1), 4, '0', STR_PAD_LEFT);

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
                'owner_whatsapp' => $request->owner_whatsapp,
                'owner_address' => $request->address,
                'owner_email' => $request->owner_email,

            ]
        );




        return redirect()->route('pet.index')->with('message', 'Client registered');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet->load(['petcategory', 'petbreed', 'treatments' => function ($query) {
            $query->with(['doctor', 'bill', 'vaccinations.vaccine'])->latest('treatment_date');
        }]);

        $treatments = $pet->treatments ?? collect();
        $outstandingBills = $pet->treatments
            ? $pet->treatments->pluck('bill')->filter(function ($bill) {
                return $bill && (int) $bill->payment_status !== 1;
            })->count()
            : 0;

        $nextVaccination = $pet->treatments
            ? $pet->treatments
                ->flatMap(function ($treatment) {
                    return $treatment->vaccinations ?? [];
                })
                ->filter(fn ($vaccination) => $vaccination->next_vacc_date)
                ->sortBy('next_vacc_date')
                ->first()
            : null;

        return view('pet.show', [
            'pet' => $pet,
            'treatments' => $treatments,
            'outstandingBills' => $outstandingBills,
            'nextVaccination' => $nextVaccination,
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
    public function edit(pet $pet)
    {
        $petcategory = PetCategory::all();
        $breed = PetBreed::all();
        return view('pet.edit', compact('petcategory', 'breed', 'pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, pet $pet)
    {
        $patientID = $request->pet_id;
        //$trimPatientId = ltrim($getPatientId, '0');
        //$patientID = str_pad($trimPatientId, 4, '0', STR_PAD_LEFT);
        // $patientID = 'CV' . str_pad(($trimPatientId + 1), 4, '0', STR_PAD_LEFT);

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
                'owner_whatsapp' => $request->owner_whatsapp,
                'owner_address' => $request->address,
                'owner_email' => $request->owner_email
            ]
        );


        return redirect()->route('pet.index')->with('message', 'Client details updated');
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
        return redirect()->route('pet.index')->with('message', 'Client archived');
    }
}
