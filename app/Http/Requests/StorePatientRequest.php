<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'age_at_register' => ['nullable', 'integer'],
            'allegics' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'basic_ilness' => ['nullable', 'string'],
        ];
    }
}
