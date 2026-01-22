<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Pet::class, 'pet');
    }

    public function index(Request $request): JsonResponse
    {
        $query = Pet::with(['petcategory', 'petbreed']);

        $query->filter(
            $request->only(['pet_category', 'pet_breed', 'gender']),
            ['pet_category', 'pet_breed', 'gender']
        )->sort(
            $request->query('sort'),
            ['name', 'created_at']
        );

        $pets = $query->paginateRequest($request->integer('per_page'));

        return PetResource::collection($pets)->response();
    }

    public function store(StorePetRequest $request): JsonResponse
    {
        $data = $request->validated();
        $nextId = (int) Pet::withTrashed()->max('id') + 1;
        $petId = 'CV' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $pet = Pet::create([
            'pet_id' => $petId,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'age_at_register' => $data['age'] ?? null,
            'weight' => $data['weight'] ?? null,
            'color' => $data['colour'] ?? null,
            'pet_category' => $data['pet_category'] ?? null,
            'pet_breed' => $data['breed'] ?? null,
            'remarks' => $data['remarks'] ?? null,
            'owner_name' => $data['owner_name'] ?? null,
            'owner_nic' => $data['owner_nic'] ?? null,
            'owner_contact' => $data['owner_contact'] ?? null,
            'owner_whatsapp' => $data['owner_whatsapp'] ?? null,
            'owner_email' => $data['owner_email'] ?? null,
            'owner_address' => $data['address'] ?? null,
        ]);

        return (new PetResource($pet))->response()->setStatusCode(201);
    }

    public function show(Pet $pet): JsonResponse
    {
        $pet->load(['petcategory', 'petbreed', 'treatments.doctor', 'treatments.bill']);

        return (new PetResource($pet))->response();
    }

    public function update(UpdatePetRequest $request, Pet $pet): JsonResponse
    {
        $data = $request->validated();

        $pet->update([
            'pet_id' => $data['pet_id'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'age_at_register' => $data['age'] ?? null,
            'weight' => $data['weight'] ?? null,
            'color' => $data['colour'] ?? null,
            'pet_category' => $data['pet_category'] ?? null,
            'pet_breed' => $data['breed'] ?? null,
            'remarks' => $data['remarks'] ?? null,
            'owner_name' => $data['owner_name'] ?? null,
            'owner_nic' => $data['owner_nic'] ?? null,
            'owner_contact' => $data['owner_contact'] ?? null,
            'owner_whatsapp' => $data['owner_whatsapp'] ?? null,
            'owner_email' => $data['owner_email'] ?? null,
            'owner_address' => $data['address'] ?? null,
        ]);

        return (new PetResource($pet))->response();
    }

    public function destroy(Pet $pet): JsonResponse
    {
        $pet->delete();

        return response()->json(['message' => 'Pet deleted']);
    }
}
