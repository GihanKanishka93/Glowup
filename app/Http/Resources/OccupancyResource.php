<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OccupancyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'type' => $this->type,
            'room_id' => $this->room_id,
            'admission_id' => $this->admission_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'nic' => $this->nic,
            'admission' => new AdmissionResource($this->whenLoaded('admission')),
            'room' => new RoomResource($this->whenLoaded('room')),
        ];
    }
}
