<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'name' => $this->name,
            'photo' => $this->photo,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'age_at_register' => $this->age_at_register,
            'allegics' => $this->allegics,
            'remarks' => $this->remarks,
            'basic_ilness' => $this->basic_ilness,
            'admissions' => AdmissionResource::collection($this->whenLoaded('admissions')),
        ];
    }
}
