<?php

namespace App\Services;

use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Treatment;
use App\Models\Drug;
use App\Models\Services;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BillingService
{
    public function createFromRequest(StoreBillRequest $request): Bill
    {
        return DB::transaction(function () use ($request) {
            $patientId = $request->input('patient');
            $patientData = $this->extractPatientPayload($request);
            $patient = null;

            if (empty($patientId) && $request->filled('patient_name')) {
                $nextId = (int) Patient::withTrashed()->max('id') + 1;
                $generatedPatientId = 'PT' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                $patient = Patient::create(array_merge([
                    'patient_id' => $generatedPatientId,
                ], $patientData));

                $patientId = $patient->id;
            } elseif (!empty($patientId)) {
                $patient = Patient::findOrFail($patientId);
                $this->applyPatientUpdates($patient, $patientData);
            }

            $billingDate = $request->date('billing_date');
            $currentDateForQuery = Carbon::parse($billingDate ?? now())->format('Y-m-d');
            $currentDateFormatted = Carbon::parse($billingDate ?? now())->format('ymd');
            $dailyCount = Bill::whereDate('created_at', $currentDateForQuery)->count();
            $billingIdentifier = $currentDateFormatted . str_pad($dailyCount + 1, 3, '0', STR_PAD_LEFT);

            $serviceBillItems = $this->buildServiceBillItems(
                $request->input('billing_date'),
                $request->input('service_name', []),
                $request->input('billing_qty', []),
                $request->input('unit_price', []),
                $request->input('tax', []),
                $request->input('last_price', [])
            );

            $billItems = $serviceBillItems;
            $discount = (float) $request->input('discount', 0);
            $netAmount = $this->calculateNetAmount($billItems);
            $grandTotal = $this->calculateGrandTotal($netAmount, $discount);

            $treatment = Treatment::create([
                'patient_id' => $patientId,
                'doctor_id' => $request->integer('doctor'),
                'history_complaint' => $request->input('history'),
                'treatment_date' => $request->input('billing_date'),
                'clinical_observation' => $request->input('remarks_t'),
                'remarks' => $request->input('remarks_t'),
                'next_clinic_date' => $request->input('next_treatment_date'),
                'next_clinic_weeks' => $request->input('next_treatment_weeks'),
            ]);

            $bill = Bill::create([
                'billing_id' => $billingIdentifier,
                'treatment_id' => $treatment->id,
                'billing_date' => $request->input('billing_date'),
                'net_amount' => $netAmount,
                'discount' => $discount,
                'total' => $grandTotal,
                'bill_status' => 1,
                'bill_type' => 1,
            ]);

            $this->syncPrescriptions($treatment->id, $request->input('drug_name', []), $request->input('dosage', []), $request->input('dose', []), $request->input('duration', []));
            $this->syncBillItems($bill->id, $billItems);

            return $bill->load([
                'treatment.patient',
                'treatment.doctor',
                'BillItems',
                'treatment.prescriptions',
            ]);
        });
    }

    public function updateFromRequest(UpdateBillRequest $request, Bill $bill): Bill
    {
        return DB::transaction(function () use ($request, $bill) {
            $billingDate = $request->input('billing_date');

            $serviceBillItems = $this->buildServiceBillItems(
                $billingDate,
                $request->input('service_name', []),
                $request->input('billing_qty', []),
                $request->input('unit_price', []),
                $request->input('tax', []),
                $request->input('last_price', [])
            );

            $billItems = $serviceBillItems;
            $discount = (float) $request->input('discount', 0);
            $netAmount = $this->calculateNetAmount($billItems);
            $grandTotal = $this->calculateGrandTotal($netAmount, $discount);

            $bill->update([
                'billing_date' => $billingDate,
                'net_amount' => $netAmount,
                'discount' => $discount,
                'total' => $grandTotal,
            ]);

            $treatment = $bill->treatment;
            $treatment->update([
                'patient_id' => $request->integer('patient'),
                'doctor_id' => $request->integer('doctor'),
                'history_complaint' => $request->input('history'),
                'treatment_date' => $billingDate,
                'clinical_observation' => $request->input('remarks_t'),
                'remarks' => $request->input('remarks_t'),
                'next_clinic_date' => $request->input('next_treatment_date'),
                'next_clinic_weeks' => $request->input('next_treatment_weeks'),
            ]);

            $patient = $treatment->patient;
            $patientData = $this->extractPatientPayload($request);
            if ($patient) {
                $this->applyPatientUpdates($patient, $patientData);
            }

            // Restore stock from old bill items before deleting them
            $oldBillItems = BillItem::where('bill_id', $bill->id)->get();
            foreach ($oldBillItems as $oldItem) {
                $service = Services::where('name', $oldItem->item_name)->first();
                if ($service) {
                    $service->increment('stock_quantity', $oldItem->item_qty);
                }
            }
            BillItem::where('bill_id', $bill->id)->delete();

            // Restore stock from old prescriptions before deleting them
            $oldPrescriptions = Prescription::where('trement_id', $treatment->id)->get();
            foreach ($oldPrescriptions as $oldPx) {
                $drug = Drug::where('name', $oldPx->drug_name)->first();
                if ($drug) {
                    $drug->increment('stock_quantity', 1);
                }
            }
            Prescription::where('trement_id', $treatment->id)->delete();

            $this->syncPrescriptions($treatment->id, $request->input('drug_name', []), $request->input('dosage', []), $request->input('dose', []), $request->input('duration', []));
            $this->syncBillItems($bill->id, $billItems);

            return $bill->load([
                'treatment.patient',
                'treatment.doctor',
                'BillItems',
                'treatment.prescriptions',
            ]);
        });
    }

    protected function syncPrescriptions(int $treatmentId, array $drugNames, array $dosages, array $doses, array $durations): void
    {
        foreach ($drugNames as $index => $drugName) {
            if (!filled($drugName)) {
                continue;
            }

            Prescription::create([
                'trement_id' => $treatmentId,
                'drug_name' => $drugName,
                'dosage' => $dosages[$index] ?? null,
                'dose' => $doses[$index] ?? null,
                'duration' => $durations[$index] ?? null,
            ]);

            // Decrement stock for the drug
            $drug = Drug::where('name', $drugName)->first();
            if ($drug) {
                $drug->decrement('stock_quantity', 1);
            }
        }
    }



    protected function buildServiceBillItems(?string $billingDate, array $serviceIds, array $quantities, array $unitPrices, array $taxes, array $totals): array
    {
        $items = [];

        foreach ($serviceIds as $index => $serviceId) {
            if (!filled($serviceId)) {
                continue;
            }

            // Fetch the service name and latest price by ID
            $service = Services::find($serviceId);
            $serviceName = $service ? $service->name : 'Unknown Service';

            $qty = (float) ($quantities[$index] ?? 0);
            $unitPrice = (float) ($unitPrices[$index] ?? 0);
            $discountPercentage = (float) ($taxes[$index] ?? 0);
            $totalPrice = (float) ($totals[$index] ?? 0);

            if ($qty <= 0) {
                $qty = 1;
            }

            if ($totalPrice === 0.0 && $unitPrice > 0) {
                $totalPrice = max(($qty * $unitPrice) - (($qty * $unitPrice) * $discountPercentage / 100), 0);
            }

            $items[] = [
                'billing_date' => $billingDate,
                'item_name' => $serviceName,
                'item_qty' => $qty,
                'unit_price' => $unitPrice,
                'tax' => $discountPercentage,
                'total_price' => $totalPrice,
            ];
        }

        return $items;
    }



    protected function calculateNetAmount(array $billItems): float
    {
        return array_reduce($billItems, function ($carry, $item) {
            return $carry + (float) ($item['total_price'] ?? 0);
        }, 0.0);
    }

    protected function calculateGrandTotal(float $netAmount, float $discount): float
    {
        return max($netAmount - $discount, 0);
    }

    protected function syncBillItems(int $billId, array $items): void
    {
        foreach ($items as $item) {
            BillItem::create([
                'bill_id' => $billId,
                'billing_date' => $item['billing_date'] ?? null,
                'item_name' => $item['item_name'] ?? null,
                'item_qty' => $item['item_qty'] ?? null,
                'unit_price' => $item['unit_price'] ?? null,
                'tax' => $item['tax'] ?? null,
                'total_price' => $item['total_price'] ?? null,
            ]);

            // Decrement stock for the service/item
            $service = Services::where('name', $item['item_name'])->first();
            if ($service) {
                $service->decrement('stock_quantity', $item['item_qty']);
            }
        }
    }

    /**
     * Build an array of patient attributes from the request payload.
     */
    private function extractPatientPayload($request): array
    {
        return [
            'name' => $request->input('patient_name') ?? $request->input('name') ?? $request->input('pet_name') ?? $request->input('owner_name'), // Fallback to owner_name if mixed input
            'nic' => $request->input('nic') ?? $request->input('owner_nic'),
            'mobile_number' => $request->input('contact') ?? $request->input('owner_contact'),
            'whatsapp_number' => $request->input('whatsapp') ?? $request->input('owner_whatsapp'),
            'email' => $request->input('email') ?? $request->input('owner_email'),
            'address' => $request->input('address') ?? $request->input('owner_address'),
            'occupation' => $request->input('occupation'),
            'gender' => $request->input('gender'),
            'date_of_birth' => $request->input('date_of_birth'),
            'allegics' => $request->input('allegics'),
            'basic_ilness' => $request->input('medical_history') ?? $request->input('basic_ilness'),
            'surgical_history' => $request->input('surgical_history'),
            'remarks' => $request->input('remarks'),
        ];
    }

    /**
     * Apply updates to a patient while ignoring empty values, saving only when data changed.
     */
    private function applyPatientUpdates(Patient $patient, array $patientData): void
    {
        $filteredData = array_filter(
            $patientData,
            fn($value) => $value !== null && $value !== '' && $value !== 'undefined'
        );

        if (!empty($filteredData)) {
            $patient->fill($filteredData);

            if ($patient->isDirty()) {
                $patient->save();
            }
        }
    }

    /**
     * Restore stock when a bill is deleted.
     */
    public function restoreStock(Bill $bill): void
    {
        $treatment = $bill->treatment;
        if (!$treatment)
            return;

        // Restore stock from bill items
        foreach ($bill->BillItems ?? [] as $item) {
            $service = Services::where('name', $item->item_name)->first();
            if ($service) {
                $service->increment('stock_quantity', $item->item_qty);
            }
        }

        // Restore stock from prescriptions
        foreach ($treatment->prescriptions ?? [] as $px) {
            $drug = Drug::where('name', $px->drug_name)->first();
            if ($drug) {
                $drug->increment('stock_quantity', 1);
            }
        }
    }
}
