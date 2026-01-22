<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOccupancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'type' => ['nullable', 'string', 'max:1'],
            'room_id' => ['nullable', 'integer', 'exists:rooms,id'],
            'admission_id' => ['nullable', 'integer', 'exists:admissions,id'],
            'name' => ['nullable', 'string', 'max:250'],
            'phone' => ['nullable', 'string', 'max:20'],
            'nic' => ['nullable', 'string', 'max:20'],
        ];
    }
}
