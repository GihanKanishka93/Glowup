<?php

namespace App\Http\Controllers;

use App\Models\PetBreed;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\petBreedDataTable;

class PetBreedController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:pet-category-list|pet-category-create|pet-category-edit|pet-category-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:pet-category-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:pet-category-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:pet-category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(petBreedDataTable $dataTable)
    {
        return $dataTable->render('settings.pet-breed.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.pet-breed.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|unique:pet_breeds,name',
        ]);

        PetBreed::create([
            'name' => $request->name,
        ]);

        return redirect()->route('pet-breed.index')->with('message', 'Pet Breed creted');
    }

    /**
     * Display the specified resource.
     */
    public function show(PetBreed $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetBreed $petBreed)
    {
        return view('settings.pet-breed.edit', compact('petBreed'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetBreed $petBreed)
    {
        $request->validate([
            'name' => 'required|min:1|unique:pet_breeds,name,' . $petBreed->id,
        ]);

        $petBreed->update([
            'name' => $request->name,
        ]);

        return redirect()->route('pet-breed.index')->with('message', 'pet breed update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetBreed $petBreed)
    {
        $petBreed->delete();
        return redirect()->route('pet-breed.index')->with('message', 'pet breed update');
    }
}