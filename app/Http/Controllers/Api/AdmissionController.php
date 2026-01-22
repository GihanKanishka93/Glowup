<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmissionRequest;
use App\Http\Requests\UpdateAdmissionRequest;
use App\Http\Resources\AdmissionResource;
use App\Models\Admission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admission::class, 'admission');
    }

    public function index(Request $request): JsonResponse
    {
        $query = Admission::with(['patient', 'room', 'occupancies']);

        $query->filter(
            $request->only(['room_id', 'patient_id']),
            ['room_id', 'patient_id']
        )->sort(
            $request->query('sort'),
            ['date_of_check_in', 'created_at']
        );

        $admissions = $query->paginateRequest($request->integer('per_page'));

        return AdmissionResource::collection($admissions)->response();
    }

    public function store(StoreAdmissionRequest $request): JsonResponse
    {
        $admission = Admission::create($request->validated());
        $admission->load(['patient', 'room']);

        return (new AdmissionResource($admission))->response()->setStatusCode(201);
    }

    public function show(Admission $admission): JsonResponse
    {
        $admission->load(['patient', 'room', 'occupancies.room']);

        return (new AdmissionResource($admission))->response();
    }

    public function update(UpdateAdmissionRequest $request, Admission $admission): JsonResponse
    {
        $admission->update($request->validated());
        $admission->load(['patient', 'room']);

        return (new AdmissionResource($admission))->response();
    }

    public function destroy(Admission $admission): JsonResponse
    {
        $admission->delete();

        return response()->json(['message' => 'Admission deleted']);
    }
}
