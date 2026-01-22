<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'pet_id' => $this->pet_id,
            'name' => $this->name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'age_at_register' => $this->age_at_register,
            'weight' => $this->weight,
            'color' => $this->color,
            'remarks' => $this->remarks,
            'basic_ilness' => $this->basic_ilness,
            'pet_category' => $this->pet_category,
            'pet_breed' => $this->pet_breed,
            'owner_name' => $this->owner_name,
            'owner_nic' => $this->owner_nic,
            'owner_contact' => $this->owner_contact,
            'owner_whatsapp' => $this->owner_whatsapp,
            'owner_address' => $this->owner_address,
            'owner_email' => $this->owner_email,
            'current_age' => $this->when(isset($this->current_age), $this->current_age),
            'treatments' => TreatmentResource::collection($this->whenLoaded('treatments')),
        ];
    }
}
