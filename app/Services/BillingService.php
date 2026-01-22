<?php

namespace App\Services;

use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Pet;
use App\Models\Prescription;
use App\Models\Treatment;
use App\Models\VaccinationInfo;
use App\Models\Vaccination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BillingService
{
    public function createFromRequest(StoreBillRequest $request): Bill
    {
        return DB::transaction(function () use ($request) {
            $petId = $request->input('pet');
            $petData = $this->extractPetPayload($request);
            $pet = null;

            if (empty($petId) && $request->filled('pet_name')) {
                $nextId = (int) Pet::withTrashed()->max('id') + 1;
                $generatedPetId = 'CV' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                $pet = Pet::create(array_merge([
                    'pet_id' => $generatedPetId,
                ], $petData));

                $petId = $pet->id;
            } elseif (!empty($petId)) {
                $pet = Pet::findOrFail($petId);
                $this->applyPetUpdates($pet, $petData);
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

            $vaccinationBillItems = $this->buildVaccinationBillItems(
                $request->input('billing_date'),
                $request->input('vaccine_name', []),
                array_column($serviceBillItems, 'item_name')
            );

            $billItems = array_merge($serviceBillItems, $vaccinationBillItems);
            $discount = (float) $request->input('discount', 0);
            $netAmount = $this->calculateNetAmount($billItems);
            $grandTotal = $this->calculateGrandTotal($netAmount, $discount);

            $treatment = Treatment::create([
                'pet_id' => $petId,
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
            $this->syncVaccinations($treatment->id, $request->input('vaccine_name', []), $request->input('vacc_duration', []), $request->input('next_vacc_weeks', []));
            $this->syncBillItems($bill->id, $billItems);

            return $bill->load([
                'treatment.pet',
                'treatment.doctor',
                'BillItems',
                'treatment.prescriptions',
                'treatment.vaccinations',
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

            $vaccinationBillItems = $this->buildVaccinationBillItems(
                $billingDate,
                $request->input('vaccine_name', []),
                array_column($serviceBillItems, 'item_name')
            );

            $billItems = array_merge($serviceBillItems, $vaccinationBillItems);
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
                'pet_id' => $request->integer('pet'),
                'doctor_id' => $request->integer('doctor'),
                'history_complaint' => $request->input('history'),
                'treatment_date' => $billingDate,
                'clinical_observation' => $request->input('remarks_t'),
                'remarks' => $request->input('remarks_t'),
                'next_clinic_date' => $request->input('next_treatment_date'),
                'next_clinic_weeks' => $request->input('next_treatment_weeks'),
            ]);

            $pet = $treatment->pet;
            $petData = $this->extractPetPayload($request);
            if ($pet) {
                $this->applyPetUpdates($pet, $petData);
            }

            Prescription::where('trement_id', $treatment->id)->delete();
            $this->syncPrescriptions($treatment->id, $request->input('drug_name', []), $request->input('dosage', []), $request->input('dose', []), $request->input('duration', []));

            VaccinationInfo::where('trement_id', $treatment->id)->delete();
            $this->syncVaccinations($treatment->id, $request->input('vaccine_name', []), $request->input('vacc_duration', []), $request->input('next_vacc_weeks', []));

            BillItem::where('bill_id', $bill->id)->delete();
            $this->syncBillItems($bill->id, $billItems);

            return $bill->load([
                'treatment.pet',
                'treatment.doctor',
                'BillItems',
                'treatment.prescriptions',
                'treatment.vaccinations',
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
        }
    }

    protected function syncVaccinations(int $treatmentId, array $vaccineIds, array $dates, array $weeks): void
    {
        foreach ($vaccineIds as $index => $vaccineId) {
            if (!filled($vaccineId)) {
                continue;
            }

            VaccinationInfo::create([
                'trement_id' => $treatmentId,
                'vaccine_id' => $vaccineId,
                'next_vacc_date' => $dates[$index] ?? null,
                'next_vacc_weeks' => $weeks[$index] ?? null,
            ]);
        }
    }

    protected function buildServiceBillItems(?string $billingDate, array $serviceNames, array $quantities, array $unitPrices, array $taxes, array $totals): array
    {
        $items = [];

        foreach ($serviceNames as $index => $serviceName) {
            if (!filled($serviceName)) {
                continue;
            }

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

    protected function buildVaccinationBillItems(?string $billingDate, array $vaccineIds, array $existingItemNames = []): array
    {
        $items = [];
        $existingLookup = array_map(fn ($name) => strtolower((string) $name), array_filter($existingItemNames));

        $vaccinations = Vaccination::whereIn('id', array_filter($vaccineIds))->get()->keyBy('id');

        foreach ($vaccineIds as $vaccineId) {
            if (!filled($vaccineId)) {
                continue;
            }

            $vaccination = $vaccinations->get((int) $vaccineId);
            if (!$vaccination) {
                continue;
            }

            $label = $vaccination->name ?? 'Vaccination';

            if (in_array(strtolower($label), $existingLookup, true)) {
                continue;
            }

            $price = (float) ($vaccination->price ?? 0);

            $items[] = [
                'billing_date' => $billingDate,
                'item_name' => $label,
                'item_qty' => 1,
                'unit_price' => $price,
                'tax' => 0,
                'total_price' => $price,
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
        }
    }

    /**
     * Build an array of pet attributes from the request payload.
     */
    private function extractPetPayload($request): array
    {
        return [
            'name' => $request->input('pet_name'),
            'gender' => $request->input('gender'),
            'age_at_register' => $request->input('age'),
            'date_of_birth' => $request->input('date_of_birth'),
            'weight' => $request->input('weight'),
            'color' => $request->input('colour'),
            'pet_category' => $request->input('pet_category'),
            'pet_breed' => $request->input('breed'),
            'remarks' => $request->input('remarks'),
            'owner_name' => $request->input('owner_name'),
            'owner_contact' => $request->input('owner_contact'),
            'owner_whatsapp' => $request->input('owner_whatsapp'),
            'owner_email' => $request->input('owner_email'),
            'owner_address' => $request->input('address'),
        ];
    }

    /**
     * Apply updates to a pet while ignoring empty values, saving only when data changed.
     */
    private function applyPetUpdates(Pet $pet, array $petData): void
    {
        $filteredData = array_filter(
            $petData,
            fn ($value) => $value !== null && $value !== ''
        );

        if (!empty($filteredData)) {
            $pet->fill($filteredData);

            if ($pet->isDirty()) {
                $pet->save();
            }
        }
    }
}
