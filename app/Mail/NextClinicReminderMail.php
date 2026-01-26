<?php

namespace App\Mail;

use App\Models\Patient;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NextClinicReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Patient $patient,
        public Treatment $treatment
    ) {
    }

    public function build()
    {
        $clinicName = config('app.name');
        $subject = "Follow-up reminder for {$this->patient->name}";

        $nextClinicDate = $this->treatment->next_clinic_date;
        $dateFormatted = $nextClinicDate ? Carbon::parse($nextClinicDate)->format('Y-m-d') : null;

        $fromEmail = config('reminders.from_email') ?? config('mail.from.address');
        $fromName = config('reminders.from_name') ?? $clinicName;

        return $this->from($fromEmail, $fromName)
            ->subject($subject)
            ->replyTo(config('reminders.reply_to') ?? $fromEmail, $fromName)
            ->view('emails.reminders.next-clinic')
            ->with([
                'patient' => $this->patient,
                'treatment' => $this->treatment,
                'clinicName' => $clinicName,
                'nextClinicDate' => $dateFormatted,
            ]);
    }
}
