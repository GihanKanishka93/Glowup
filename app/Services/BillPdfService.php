<?php

namespace App\Services;

use App\Models\Bill;
use PDF;

class BillPdfService
{
    public function stream(int $billId, string $fileName = 'billing_details.pdf')
    {
        return $this->makePdf($billId)->stream($fileName);
    }

    public function output(int $billId): string
    {
        return $this->makePdf($billId)->output();
    }

    private function makePdf(int $billId)
    {
        $billingData = Bill::with(['treatment.patient', 'treatment.doctor', 'treatment.prescription', 'BillItems'])
            ->where('id', $billId)
            ->firstOrFail();

        $hospitalInfo = [
            'name' => 'Glow Up Skin Care & Cosmetics',
            'address' => 'Kottawa, Sri Lanka',
            'phone' => '070-3843481',
        ];

        $data = [
            'hospital_info' => $hospitalInfo,
            'billing_data' => $billingData,
            'billing_items' => $billingData->BillItems,
            'date' => date('Y-m-d'),
            'patient' => $billingData->treatment->patient,
            'treatment' => $billingData->treatment,
            'doctor' => $billingData->treatment->doctor,
            'title' => 'Billing Details',
        ];

        set_time_limit(1200);
        $pdf = PDF::loadView('pdf', $data);
        $pdf->setPaper([0, 0, 340, 900], 'portrait');

        return $pdf;
    }
}
