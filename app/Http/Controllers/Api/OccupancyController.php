<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOccupancyRequest;
use App\Http\Requests\UpdateOccupancyRequest;
use App\Http\Resources\OccupancyResource;
use App\Models\Occupancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OccupancyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Occupancy::class, 'occupancy');
    }

    public function index(Request $request): JsonResponse
    {
        $query = Occupancy::with(['admission', 'room']);

        $query->filter(
            $request->only(['room_id', 'admission_id', 'date']),
            ['room_id', 'admission_id', 'date']
        )->sort(
            $request->query('sort'),
            ['date', 'created_at']
        );

        $occupancies = $query->paginateRequest($request->integer('per_page'));

        return OccupancyResource::collection($occupancies)->response();
    }

    public function store(StoreOccupancyRequest $request): JsonResponse
    {
        $occupancy = Occupancy::create($request->validated());
        $occupancy->load(['admission', 'room']);

        return (new OccupancyResource($occupancy))->response()->setStatusCode(201);
    }

    public function show(Occupancy $occupancy): JsonResponse
    {
        $occupancy->load(['admission', 'room']);

        return (new OccupancyResource($occupancy))->response();
    }

    public function update(UpdateOccupancyRequest $request, Occupancy $occupancy): JsonResponse
    {
        $occupancy->update($request->validated());
        $occupancy->load(['admission', 'room']);

        return (new OccupancyResource($occupancy))->response();
    }

    public function destroy(Occupancy $occupancy): JsonResponse
    {
        $occupancy->delete();

        return response()->json(['message' => 'Occupancy deleted']);
    }
}
