<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VaccinationInfoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'treatment_id' => $this->trement_id,
            'vaccine_id' => $this->vaccine_id,
            'next_vacc_date' => $this->next_vacc_date,
            'next_vacc_weeks' => $this->next_vacc_weeks,
        ];
    }
}
