<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\DataTables\PatientDataTable;

class PatientController extends Controller
{
    public function index(PatientDataTable $dataTable)
    {
        return $dataTable->render('patient.index');
    }

    public function create()
    {
        return view('patient.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nic' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'age_at_register' => 'nullable|string|max:50',
            'allegics' => 'nullable|string',
            'basic_ilness' => 'nullable|string',
            'surgical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $maxId = Patient::max('id');
        $nextId = $maxId + 1;
        $generatedId = 'PT' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $patient = new Patient();
        $patient->patient_id = $generatedId;
        $patient->fill($request->all());
        $patient->save();

        return redirect()->route('patient.index')->with('message', 'Client registered successfully.');
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        $treatments = $patient->treatments()->with(['doctor', 'bill'])->latest('treatment_date')->get();

        $outstandingBills = $treatments->filter(function ($treatment) {
            return $treatment->bill && ($treatment->bill->payment_status != 1);
        })->count();

        $nextFollowUp = $treatments->whereNotNull('next_clinic_date')
            ->where('next_clinic_date', '>=', now()->toDateString())
            ->sortBy('next_clinic_date')
            ->first();

        // Vaccination logic removed/hidden as per plan
        $nextVaccination = null;

        return view('patient.show', compact('patient', 'treatments', 'outstandingBills', 'nextFollowUp', 'nextVaccination'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nic' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'age_at_register' => 'nullable|string|max:50',
            'allegics' => 'nullable|string',
            'basic_ilness' => 'nullable|string',
            'surgical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $patient->fill($request->all());
        $patient->save();

        return redirect()->route('patient.index')->with('message', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patient.index')->with('message', 'Client deleted successfully.');
    }
}
