<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\servicesDataTable;

class ServiceController extends Controller
{
    function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(servicesDataTable $dataTable)
    {
        return $dataTable->render('settings.services.index');
    }

    public function getServicePrice($name)
    {
        $service = Services::where('name', $name)->first();
        if ($service) {
            return response()->json(['price' => $service->price]);
        } else {
            return response()->json(['error' => 'Service not found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|unique:services,name',
        ]);

        Services::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('services.index')->with('message', 'services Name Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $service)
    {
        return view('settings.services.edit', compact('service'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Services $service)
    {
        $request->validate([
            'name' => 'required|min:1|unique:services,name,' . $service->id,
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $service->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('services.index')->with('message', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('message', 'Service deleted successfully');
    }

}