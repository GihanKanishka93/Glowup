<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'pet_id' => $this->pet_id,
            'doctor_id' => $this->doctor_id,
            'history_complaint' => $this->history_complaint,
            'clinical_observation' => $this->clinical_observation,
            'remarks' => $this->remarks,
            'treatment_date' => optional($this->treatment_date ? \Carbon\Carbon::parse($this->treatment_date) : null)->toDateString(),
            'next_clinic_date' => optional($this->next_clinic_date ? \Carbon\Carbon::parse($this->next_clinic_date) : null)->toDateString(),
            'next_clinic_weeks' => $this->next_clinic_weeks,
            'pet' => new PetResource($this->whenLoaded('pet')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'prescriptions' => PrescriptionResource::collection($this->whenLoaded('prescriptions')),
            'vaccinations' => VaccinationInfoResource::collection($this->whenLoaded('vaccinations')),
        ];
    }
}
