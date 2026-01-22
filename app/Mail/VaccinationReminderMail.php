<?php

namespace App\Mail;

use App\Models\Pet;
use App\Models\VaccinationInfo;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VaccinationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pet $pet,
        public VaccinationInfo $vaccination
    ) {
    }

    public function build()
    {
        $clinicName = config('app.name');
        $subject = "Vaccination reminder for {$this->pet->name}";

        $nextDate = $this->vaccination->next_vacc_date;
        $dueDate = $nextDate ? Carbon::parse($nextDate)->format('Y-m-d') : null;

        $fromEmail = config('reminders.from_email') ?? config('mail.from.address');
        $fromName = config('reminders.from_name') ?? $clinicName;

        $mail = $this->from($fromEmail, $fromName)
            ->subject($subject)
            ->replyTo(config('reminders.reply_to') ?? $fromEmail, $fromName)
            ->view('emails.reminders.vaccination')
            ->with([
                'pet' => $this->pet,
                'vaccination' => $this->vaccination,
                'clinicName' => $clinicName,
                'dueDate' => $dueDate,
            ]);

        return $mail;
    }
}
