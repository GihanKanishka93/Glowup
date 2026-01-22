<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Patient::class, 'patient');
    }

    public function index(Request $request): JsonResponse
    {
        $query = Patient::query();

        $query->filter(
            $request->only(['gender']),
            ['gender']
        )->sort(
            $request->query('sort'),
            ['name', 'created_at']
        );

        $patients = $query->paginateRequest($request->integer('per_page'));

        return PatientResource::collection($patients)->response();
    }

    public function store(StorePatientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $nextId = (int) Patient::withTrashed()->max('id') + 1;
        $patientId = 'PT' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $patient = Patient::create([
            'patient_id' => $patientId,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'age_at_register' => $data['age_at_register'] ?? null,
            'allegics' => $data['allegics'] ?? null,
            'remarks' => $data['remarks'] ?? null,
            'basic_ilness' => $data['basic_ilness'] ?? null,
        ]);

        return (new PatientResource($patient))->response()->setStatusCode(201);
    }

    public function show(Patient $patient): JsonResponse
    {
        $patient->load(['admissions.room', 'admissions.occupancies']);

        return (new PatientResource($patient))->response();
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse
    {
        $data = $request->validated();

        $patient->update([
            'patient_id' => $data['patient_id'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'age_at_register' => $data['age_at_register'] ?? null,
            'allegics' => $data['allegics'] ?? null,
            'remarks' => $data['remarks'] ?? null,
            'basic_ilness' => $data['basic_ilness'] ?? null,
        ]);

        return (new PatientResource($patient))->response();
    }

    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();

        return response()->json(['message' => 'Patient deleted']);
    }
}
