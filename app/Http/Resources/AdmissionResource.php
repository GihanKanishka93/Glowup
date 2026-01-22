<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'patient_id' => $this->patient_id,
            'date_of_check_in' => $this->date_of_check_in,
            'date_of_check_out' => $this->date_of_check_out,
            'plan_to_check_in' => $this->plan_to_check_in,
            'plan_to_check_out' => $this->plan_to_check_out,
            'number_of_days' => $this->number_of_days,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'room' => new RoomResource($this->whenLoaded('room')),
            'occupancies' => OccupancyResource::collection($this->whenLoaded('occupancies')),
        ];
    }
}
