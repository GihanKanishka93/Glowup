<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Bill $bill,
        public string $pdfContent
    ) {
    }

    public function build()
    {
        $clinicName = config('app.name');
        $subject = "Bill {$this->bill->billing_id} from {$clinicName}";

        return $this->subject($subject)
            ->view('emails.reminders.bill')
            ->with([
                'bill' => $this->bill,
                'treatment' => $this->bill->treatment,
                'pet' => $this->bill->treatment->pet ?? null,
                'clinicName' => $clinicName,
            ])
            ->attachData($this->pdfContent, "bill-{$this->bill->billing_id}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
