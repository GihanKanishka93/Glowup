<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'gender' => ['required', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'age' => ['nullable', 'integer'],
            'weight' => ['nullable', 'numeric'],
            'colour' => ['nullable', 'string', 'max:255'],
            'pet_category' => ['nullable', 'integer', 'exists:pet_categories,id'],
            'breed' => ['nullable', 'integer', 'exists:pet_breeds,id'],
            'remarks' => ['nullable', 'string'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'owner_nic' => ['nullable', 'string', 'max:25'],
            'owner_contact' => ['nullable', 'string', 'max:25'],
            'owner_whatsapp' => ['nullable', 'string', 'max:25'],
            'owner_email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
        ];
    }
}
