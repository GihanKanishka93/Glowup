<?php

namespace App\Jobs;

use App\Mail\BillEmail;
use App\Models\Bill;
use App\Services\BillPdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBillEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 180;
    public ?int $billId = null;

    public function __construct(int $billId)
    {
        $this->billId = $billId;
    }

    /**
     * Handle legacy serialized payloads where billId was a private property.
     */
    public function __unserialize(array $values): void
    {
        if (array_key_exists('billId', $values)) {
            $this->billId = (int) $values['billId'];
            return;
        }

        foreach ($values as $key => $value) {
            if (is_string($key) && str_ends_with($key, 'billId')) {
                $this->billId = (int) $value;
                return;
            }
        }
    }

    public function handle(BillPdfService $billPdfService): void
    {
        if (!$this->billId) {
            Log::warning('SendBillEmailJob missing bill id in payload');
            return;
        }

        $bill = Bill::with(['treatment.patient', 'treatment.doctor', 'BillItems'])->find($this->billId);
        $patient = $bill?->treatment?->patient;

        if (!$bill || !$patient || empty($patient->email)) {
            return;
        }

        $pdfContent = $billPdfService->output($bill->id);
        Mail::to($patient->email)->send(new BillEmail($bill, $pdfContent));
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SendBillEmailJob failed', [
            'bill_id' => $this->billId,
            'error' => $exception->getMessage(),
        ]);
    }
}
