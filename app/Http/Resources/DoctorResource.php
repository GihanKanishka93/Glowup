<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'name' => $this->name,
            'gender' => $this->gender,
            'designation' => $this->designation,
            'address' => $this->address,
            'contact_no' => $this->contact_no,
            'email' => $this->email,
        ];
    }
}
