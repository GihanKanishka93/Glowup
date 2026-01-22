<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\drugDataTable;

class DrugController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(drugDataTable $dataTable)
    {
        return $dataTable->render('settings.drug.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.drug.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|unique:drugs,name',
        ]);

        Drug::create([
            'name' => $request->name,
        ]);

        return redirect()->route('drug.index')->with('message', 'Drug Name Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Drug $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drug $drug)
    {
        return view('settings.drug.edit', compact('drug'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drug $drug)
    {
        $request->validate([
            'name' => 'required|min:1|unique:pet_categories,name,' . $drug->id,
        ]);

        $drug->update([
            'name' => $request->name,
        ]);

        return redirect()->route('drug.index')->with('message', 'drug update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();
        return redirect()->route('drug.index')->with('message', 'drug update');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        $drugs = Drug::where('name', 'LIKE', '%' . $term . '%')->pluck('name');
        return response()->json($drugs);
    }
}
