<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'date_of_check_in' => ['nullable', 'date'],
            'date_of_check_out' => ['nullable', 'date'],
            'plan_to_check_in' => ['nullable', 'date'],
            'plan_to_check_out' => ['nullable', 'date'],
            'number_of_days' => ['nullable', 'integer'],
        ];
    }
}
