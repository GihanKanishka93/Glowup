<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\DataTables\PatientDataTable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'before_treatment_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'after_treatment_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $maxId = Patient::max('id');
        $nextId = $maxId + 1;
        $generatedId = 'PT' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $patient = new Patient();
        $patient->patient_id = $generatedId;
        $patient->fill(Arr::except($validated, ['before_treatment_image', 'after_treatment_image']));
        $patient->save();

        $beforePath = $this->storeTreatmentImage($request->file('before_treatment_image'), $patient->id, 'before');
        $afterPath = $this->storeTreatmentImage($request->file('after_treatment_image'), $patient->id, 'after');

        if ($beforePath || $afterPath) {
            $patient->before_treatment_image = $beforePath ?: $patient->before_treatment_image;
            $patient->after_treatment_image = $afterPath ?: $patient->after_treatment_image;
            $patient->save();
        }

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
            'before_treatment_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'after_treatment_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $patient->fill(Arr::except($validated, ['before_treatment_image', 'after_treatment_image']));

        if ($request->hasFile('before_treatment_image')) {
            if ($patient->before_treatment_image) {
                Storage::disk('public')->delete($patient->before_treatment_image);
            }
            $patient->before_treatment_image = $this->storeTreatmentImage(
                $request->file('before_treatment_image'),
                $patient->id,
                'before'
            );
        }

        if ($request->hasFile('after_treatment_image')) {
            if ($patient->after_treatment_image) {
                Storage::disk('public')->delete($patient->after_treatment_image);
            }
            $patient->after_treatment_image = $this->storeTreatmentImage(
                $request->file('after_treatment_image'),
                $patient->id,
                'after'
            );
        }

        $patient->save();

        return redirect()->route('patient.index')->with('message', 'Client updated successfully.');
    }

    public function updateTreatmentImages(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'before_treatment_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'after_treatment_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if (!$request->hasFile('before_treatment_image') && !$request->hasFile('after_treatment_image')) {
            return redirect()->back()->with('danger', 'Please select at least one image to upload.');
        }

        if ($request->hasFile('before_treatment_image')) {
            if ($patient->before_treatment_image) {
                Storage::disk('public')->delete($patient->before_treatment_image);
            }
            $patient->before_treatment_image = $this->storeTreatmentImage(
                $request->file('before_treatment_image'),
                $patient->id,
                'before'
            );
        }

        if ($request->hasFile('after_treatment_image')) {
            if ($patient->after_treatment_image) {
                Storage::disk('public')->delete($patient->after_treatment_image);
            }
            $patient->after_treatment_image = $this->storeTreatmentImage(
                $request->file('after_treatment_image'),
                $patient->id,
                'after'
            );
        }

        $patient->save();

        return redirect()->back()->with('message', 'Treatment images updated.');
    }

    private function storeTreatmentImage($file, int $patientId, string $label): ?string
    {
        if (!$file) {
            return null;
        }

        $extension = $file->getClientOriginalExtension();
        $filename = 'patient_' . $patientId . '_' . $label . '_' . now()->format('YmdHis') . '_' . Str::random(6) . '.' . $extension;

        return $file->storeAs('patient-treatments', $filename, 'public');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patient.index')->with('message', 'Client deleted successfully.');
    }
}
