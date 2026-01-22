<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'treatment_id' => $this->trement_id,
            'drug_name' => $this->drug_name,
            'dosage' => $this->dosage,
            'dose' => $this->dose,
            'duration' => $this->duration,
        ];
    }
}
