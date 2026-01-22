<?php

namespace App\Http\Controllers;

use App\Models\PetCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\petCategoryDataTable;

class PetCategoryController extends Controller
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
    public function index(petCategoryDataTable $dataTable)
    {
        return $dataTable->render('settings.pet-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.pet-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|unique:pet_categories,name',
        ]);

        PetCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('pet-category.index')->with('message', 'Pet Category creted');
    }

    /**
     * Display the specified resource.
     */
    public function show(PetCategory $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PetCategory $petCategory)
    {
        return view('settings.pet-category.edit', compact('petCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PetCategory $petCategory)
    {
        $request->validate([
            'name' => 'required|min:1|unique:pet_categories,name,' . $petCategory->id,
        ]);

        $petCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('pet-category.index')->with('message', 'pet-category update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PetCategory $petCategory)
    {
        $petCategory->delete();
        return redirect()->route('pet-category.index')->with('message', 'pet-category update');
    }
}
