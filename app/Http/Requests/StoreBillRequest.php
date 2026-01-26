<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'billing_date' => ['required', 'date'],
            'doctor' => ['required', 'integer', 'exists:doctors,id'],
            'patient' => ['nullable', 'integer', 'exists:patients,id'],

            'patient_name' => ['required_without:patient', 'string', 'max:255'],
            'gender' => ['nullable', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'occupation' => ['nullable', 'string', 'max:100'],
            'nic' => ['nullable', 'string', 'max:20'],
            'remarks' => ['nullable', 'string'],
            'contact' => ['nullable', 'string', 'max:25'],
            'whatsapp' => ['nullable', 'string', 'max:25'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'remarks_t' => ['nullable', 'string'],
            'next_treatment_date' => ['nullable', 'date'],
            'next_treatment_weeks' => ['nullable', 'string', 'max:25'],
            'net_total' => ['required', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'grand_total' => ['required', 'numeric'],
            'drug_name' => ['sometimes', 'array'],
            'drug_name.*' => ['nullable', 'string', 'max:255'],
            'dosage' => ['sometimes', 'array'],
            'dosage.*' => ['nullable', 'string', 'max:255'],
            'dose' => ['sometimes', 'array'],
            'dose.*' => ['nullable', 'string', 'max:255'],
            'duration' => ['sometimes', 'array'],
            'duration.*' => ['nullable', 'string', 'max:255'],
            // 'vaccine_name' => ['sometimes', 'array'],
            // 'vaccine_name.*' => ['nullable', 'integer', 'exists:vaccinations,id'],
            // 'vacc_duration' => ['sometimes', 'array'],
            // 'vacc_duration.*' => ['nullable', 'date'],
            // 'next_vacc_weeks' => ['sometimes', 'array'],
            // 'next_vacc_weeks.*' => ['nullable', 'string', 'max:25'],
            'service_name' => ['sometimes', 'array'],
            'service_name.*' => ['nullable', 'string', 'max:255'],
            'billing_qty' => ['sometimes', 'array'],
            'billing_qty.*' => ['nullable', 'numeric'],
            'unit_price' => ['sometimes', 'array'],
            'unit_price.*' => ['nullable', 'numeric'],
            'tax' => ['sometimes', 'array'],
            'tax.*' => ['nullable', 'numeric'],
            'last_price' => ['sometimes', 'array'],
            'last_price.*' => ['nullable', 'numeric'],
            'action' => ['nullable', 'string'],
        ];
    }
}
