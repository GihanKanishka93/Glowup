<?php

namespace App\Services;

use App\Mail\NextClinicReminderMail;
use App\Models\ReminderLog;
use App\Models\ReminderSetting;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderService
{
    public function sendReminders(): array
    {
        $settings = $this->settings();
        config()->set('reminders.from_email', $settings['from_email']);
        config()->set('reminders.from_name', $settings['from_name']);
        config()->set('reminders.reply_to', $settings['reply_to']);

        return [
            'followups' => $this->sendNextClinicReminders(),
        ];
    }



    public function sendNextClinicReminders(): int
    {
        $settings = $this->settings();

        if (!$settings['send_followup']) {
            return 0;
        }

        $dates = $this->targetDates($settings['lead_days']);
        $count = 0;

        Treatment::with(['patient', 'doctor'])
            ->whereIn(\DB::raw('DATE(next_clinic_date)'), $dates)
            ->whereNull('next_clinic_reminder_sent_at')
            ->whereHas('patient', function ($q) {
                $q->whereNotNull('email');
            })
            ->chunk(100, function ($treatments) use (&$count) {
                foreach ($treatments as $treatment) {
                    $patient = $treatment->patient;
                    if (!$patient || empty($patient->email)) {
                        continue;
                    }

                    try {
                        Mail::to($patient->email)
                            ->send(new NextClinicReminderMail($patient, $treatment));

                        $treatment->next_clinic_reminder_sent_at = Carbon::now();
                        $treatment->save();
                        $this->logReminder('next_clinic', $patient->id, $treatment->id, null, $patient->email, 'sent', null);
                        $count++;
                    } catch (\Throwable $e) {
                        Log::warning('Next clinic reminder failed', [
                            'treatment_id' => $treatment->id,
                            'patient_id' => $patient->id ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        $this->logReminder('next_clinic', $patient->id ?? null, $treatment->id, null, $patient->email ?? null, 'failed', $e->getMessage());
                    }
                }
            });

        return $count;
    }

    public function sendWeeklyReminders(): array
    {
        $settings = $this->settings();
        $results = ['vaccinations' => 0, 'followups' => 0];

        if ($settings['weekly_followup']) {
            $results['followups'] = $this->sendWeeklyNextClinicReminders();
        }

        return $results;
    }



    protected function sendWeeklyNextClinicReminders(): int
    {
        $count = 0;
        Treatment::with(['patient', 'doctor'])
            ->whereNotNull('next_clinic_date')
            ->whereRaw('DATEDIFF(next_clinic_date, CURDATE()) >= 0')
            ->whereRaw('MOD(DATEDIFF(next_clinic_date, CURDATE()), 7) = 0')
            ->whereHas('patient', function ($q) {
                $q->whereNotNull('email');
            })
            ->chunk(100, function ($treatments) use (&$count) {
                foreach ($treatments as $treatment) {
                    $patient = $treatment->patient;
                    if (!$patient || empty($patient->email)) {
                        continue;
                    }
                    if ($this->alreadySentToday('next_clinic', $patient->id, $treatment->id, null)) {
                        continue;
                    }
                    try {
                        Mail::to($patient->email)
                            ->send(new NextClinicReminderMail($patient, $treatment));

                        $this->logReminder('next_clinic', $patient->id, $treatment->id, null, $patient->email, 'sent', null);
                        $count++;
                    } catch (\Throwable $e) {
                        Log::warning('Weekly next clinic reminder failed', [
                            'treatment_id' => $treatment->id,
                            'patient_id' => $patient->id ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        $this->logReminder('next_clinic', $patient->id ?? null, $treatment->id, null, $patient->email ?? null, 'failed', $e->getMessage());
                    }
                }
            });

        return $count;
    }

    private function targetDates(array $leadDays): array
    {
        return array_map(fn($d) => Carbon::now()->addDays((int) $d)->toDateString(), $leadDays);
    }

    private function settings(): array
    {
        $db = ReminderSetting::query()->latest('id')->first();
        $leadDays = $db?->lead_days ?: config('reminders.lead_days', [1, 3, 7]);

        return [
            'send_followup' => $db?->send_followup ?? config('reminders.send_followup', true),
            'weekly_followup' => $db?->send_followup ?? config('reminders.weekly_followup', true),
            'lead_days' => array_map('intval', (array) $leadDays),
            'from_email' => $db?->from_email ?? config('reminders.from_email'),
            'from_name' => $db?->from_name ?? config('reminders.from_name'),
            'reply_to' => $db?->reply_to ?? config('reminders.reply_to'),
        ];
    }

    private function logReminder(
        string $type,
        ?int $patientId,
        ?int $treatmentId,
        ?int $vaccinationInfoId,
        ?string $ownerEmail,
        string $status,
        ?string $errorMessage
    ): void {
        ReminderLog::create([
            'reminder_type' => $type,
            'patient_id' => $patientId,
            'treatment_id' => $treatmentId,
            'vaccination_info_id' => $vaccinationInfoId,
            'owner_email' => $ownerEmail,
            'status' => $status,
            'error_message' => $errorMessage,
            'sent_at' => Carbon::now(),
        ]);
    }

    private function alreadySentToday(string $type, ?int $patientId, ?int $treatmentId, ?int $vaccinationInfoId): bool
    {
        return ReminderLog::query()
            ->whereDate('sent_at', Carbon::today())
            ->where('reminder_type', $type)
            ->where('patient_id', $patientId)
            ->where('treatment_id', $treatmentId)
            ->where('vaccination_info_id', $vaccinationInfoId)
            ->exists();
    }
}
