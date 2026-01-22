<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\vaccinationDataTable;
use App\Models\PetCategory;
use Illuminate\Support\Facades\Log;

class VaccinationController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(vaccinationDataTable $dataTable)
    {
        return $dataTable->render('settings.vaccination.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petcategory = PetCategory::all();
        return view('settings.vaccination.create', compact('petcategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|unique:vaccinations,name',
            'petcategory' => 'required'
        ]);

        Vaccination::create([
            'name' => $request->name,
            'duration' => $request->duration,
            'price' => $request->price,
            'pet_category' => json_encode($request->petcategory),
        ]);

        return redirect()->route('vaccination.index')->with('message', 'Vaccination Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vaccination $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vaccination $vaccination)
    {
        $petcategory = PetCategory::all();
        return view('settings.vaccination.edit', compact('vaccination', 'petcategory'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vaccination $vaccination)
    {
        $request->validate([
            'name' => 'required|min:1|unique:vaccinations,name,' . $vaccination->id,
            'petcategory' => 'required'
        ]);

        $vaccination->update([
            'name' => $request->name,
            'duration' => $request->duration,
            'price' => $request->price,
            'pet_category' => json_encode($request->petcategory),
        ]);

        return redirect()->route('vaccination.index')->with('message', 'Vaccination updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vaccination $vaccination)
    {
        $vaccination->delete();
        return redirect()->route('vaccination.index')->with('message', 'Vaccination deleted successfully');
    }

    public function getVaccinationsByPetCategory(Request $request)
    {

        $petCategoryId = $request->input('pet_category'); // Single category ID

        // echo "test id " . $petCategoryId;

        // Ensure the category ID is an integer
        if (is_numeric($petCategoryId) && $petCategoryId != 20) {
            //$vaccinations = Vaccination::whereJsonContains('pet_category', (int) $petCategoryId)->get();
            $vaccinations = Vaccination::whereJsonContains('pet_category', $petCategoryId)->get();
        } else {
            $vaccinations = Vaccination::all(); // Return an empty collection if no valid category ID
        }

        return $vaccinations;

    }


}