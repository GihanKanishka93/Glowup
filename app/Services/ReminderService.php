<?php

namespace App\Services;

use App\Mail\NextClinicReminderMail;
use App\Mail\VaccinationReminderMail;
use App\Models\ReminderLog;
use App\Models\ReminderSetting;
use App\Models\Treatment;
use App\Models\VaccinationInfo;
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
            'vaccinations' => $this->sendVaccinationReminders(),
            'followups' => $this->sendNextClinicReminders(),
        ];
    }

    public function sendVaccinationReminders(): int
    {
        $settings = $this->settings();

        if (!$settings['send_vaccination']) {
            return 0;
        }

        $dates = $this->targetDates($settings['lead_days']);
        $count = 0;

        VaccinationInfo::with(['treatment.pet', 'vaccine'])
            ->whereIn(\DB::raw('DATE(next_vacc_date)'), $dates)
            ->whereNull('reminder_sent_at')
            ->whereHas('treatment.pet', function ($q) {
                $q->whereNotNull('owner_email');
            })
            ->chunk(100, function ($items) use (&$count) {
                foreach ($items as $vaccination) {
                    $pet = $vaccination->treatment?->pet;
                    if (!$pet || empty($pet->owner_email)) {
                        continue;
                    }

                    try {
                        Mail::to($pet->owner_email)
                            ->send(new VaccinationReminderMail($pet, $vaccination));

                        $vaccination->reminder_sent_at = Carbon::now();
                        $vaccination->save();
                        $this->logReminder('vaccination', $pet->id, $vaccination->trement_id, $vaccination->id, $pet->owner_email, 'sent', null);
                        $count++;
                    } catch (\Throwable $e) {
                        Log::warning('Vaccination reminder failed', [
                            'vaccination_id' => $vaccination->id,
                            'pet_id' => $pet->id ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        $this->logReminder('vaccination', $pet->id ?? null, $vaccination->trement_id, $vaccination->id, $pet->owner_email ?? null, 'failed', $e->getMessage());
                    }
                }
            });

        return $count;
    }

    public function sendNextClinicReminders(): int
    {
        $settings = $this->settings();

        if (!$settings['send_followup']) {
            return 0;
        }

        $dates = $this->targetDates($settings['lead_days']);
        $count = 0;

        Treatment::with(['pet', 'doctor'])
            ->whereIn(\DB::raw('DATE(next_clinic_date)'), $dates)
            ->whereNull('next_clinic_reminder_sent_at')
            ->whereHas('pet', function ($q) {
                $q->whereNotNull('owner_email');
            })
            ->chunk(100, function ($treatments) use (&$count) {
                foreach ($treatments as $treatment) {
                    $pet = $treatment->pet;
                    if (!$pet || empty($pet->owner_email)) {
                        continue;
                    }

                    try {
                        Mail::to($pet->owner_email)
                            ->send(new NextClinicReminderMail($pet, $treatment));

                        $treatment->next_clinic_reminder_sent_at = Carbon::now();
                        $treatment->save();
                        $this->logReminder('next_clinic', $pet->id, $treatment->id, null, $pet->owner_email, 'sent', null);
                        $count++;
                    } catch (\Throwable $e) {
                        Log::warning('Next clinic reminder failed', [
                            'treatment_id' => $treatment->id,
                            'pet_id' => $pet->id ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        $this->logReminder('next_clinic', $pet->id ?? null, $treatment->id, null, $pet->owner_email ?? null, 'failed', $e->getMessage());
                    }
                }
            });

        return $count;
    }

    public function sendWeeklyReminders(): array
    {
        $settings = $this->settings();
        $results = ['vaccinations' => 0, 'followups' => 0];

        if ($settings['weekly_vaccination']) {
            $results['vaccinations'] = $this->sendWeeklyVaccinationReminders();
        }
        if ($settings['weekly_followup']) {
            $results['followups'] = $this->sendWeeklyNextClinicReminders();
        }

        return $results;
    }

    protected function sendWeeklyVaccinationReminders(): int
    {
        $count = 0;
        VaccinationInfo::with(['treatment.pet', 'vaccine'])
            ->whereNotNull('next_vacc_date')
            ->whereRaw('DATEDIFF(next_vacc_date, CURDATE()) >= 0')
            ->whereRaw('MOD(DATEDIFF(next_vacc_date, CURDATE()), 7) = 0')
            ->whereHas('treatment.pet', function ($q) {
                $q->whereNotNull('owner_email');
            })
            ->chunk(100, function ($items) use (&$count) {
                foreach ($items as $vaccination) {
                    $pet = $vaccination->treatment?->pet;
                    if (!$pet || empty($pet->owner_email)) {
                        continue;
                    }
                    if ($this->alreadySentToday('vaccination', $pet->id, $vaccination->trement_id, $vaccination->id)) {
                        continue;
                    }
                    try {
                        Mail::to($pet->owner_email)
                            ->send(new VaccinationReminderMail($pet, $vaccination));

                        $this->logReminder('vaccination', $pet->id, $vaccination->trement_id, $vaccination->id, $pet->owner_email, 'sent', null);
                        $count++;
                    } catch (\Throwable $e) {
                        Log::warning('Weekly vaccination reminder failed', [
                            'vaccination_id' => $vaccination->id,
                            'pet_id' => $pet->id ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        $this->logReminder('vaccination', $pet->id ?? null, $vaccination->trement_id, $vaccination->id, $pet->owner_email ?? null, 'failed', $e->getMessage());
                    }
                }
            });

        return $count;
    }

    protected function sendWeeklyNextClinicReminders(): int
    {
        $count = 0;
        Treatment::with(['pet', 'doctor'])
            ->whereNotNull('next_clinic_date')
            ->whereRaw('DATEDIFF(next_clinic_date, CURDATE()) >= 0')
            ->whereRaw('MOD(DATEDIFF(next_clinic_date, CURDATE()), 7) = 0')
            ->whereHas('pet', function ($q) {
                $q->whereNotNull('owner_email');
            })
            ->chunk(100, function ($treatments) use (&$count) {
                foreach ($treatments as $treatment) {
                    $pet = $treatment->pet;
                    if (!$pet || empty($pet->owner_email)) {
                        continue;
                    }
                    if ($this->alreadySentToday('next_clinic', $pet->id, $treatment->id, null)) {
                        continue;
                    }
                    try {
                        Mail::to($pet->owner_email)
                            ->send(new NextClinicReminderMail($pet, $treatment));

                        $this->logReminder('next_clinic', $pet->id, $treatment->id, null, $pet->owner_email, 'sent', null);
                        $count++;
                    } catch (\Throwable $e) {
                        Log::warning('Weekly next clinic reminder failed', [
                            'treatment_id' => $treatment->id,
                            'pet_id' => $pet->id ?? null,
                            'error' => $e->getMessage(),
                        ]);
                        $this->logReminder('next_clinic', $pet->id ?? null, $treatment->id, null, $pet->owner_email ?? null, 'failed', $e->getMessage());
                    }
                }
            });

        return $count;
    }

    private function targetDates(array $leadDays): array
    {
        return array_map(fn ($d) => Carbon::now()->addDays((int) $d)->toDateString(), $leadDays);
    }

    private function settings(): array
    {
        $db = ReminderSetting::query()->latest('id')->first();
        $leadDays = $db?->lead_days ?: config('reminders.lead_days', [1, 3, 7]);

        return [
            'send_vaccination' => $db?->send_vaccination ?? config('reminders.send_vaccination', true),
            'send_followup' => $db?->send_followup ?? config('reminders.send_followup', true),
            'weekly_vaccination' => $db?->send_vaccination ?? config('reminders.weekly_vaccination', true),
            'weekly_followup' => $db?->send_followup ?? config('reminders.weekly_followup', true),
            'lead_days' => array_map('intval', (array) $leadDays),
            'from_email' => $db?->from_email ?? config('reminders.from_email'),
            'from_name' => $db?->from_name ?? config('reminders.from_name'),
            'reply_to' => $db?->reply_to ?? config('reminders.reply_to'),
        ];
    }

    private function logReminder(
        string $type,
        ?int $petId,
        ?int $treatmentId,
        ?int $vaccinationInfoId,
        ?string $ownerEmail,
        string $status,
        ?string $errorMessage
    ): void {
        ReminderLog::create([
            'reminder_type' => $type,
            'pet_id' => $petId,
            'treatment_id' => $treatmentId,
            'vaccination_info_id' => $vaccinationInfoId,
            'owner_email' => $ownerEmail,
            'status' => $status,
            'error_message' => $errorMessage,
            'sent_at' => Carbon::now(),
        ]);
    }

    private function alreadySentToday(string $type, ?int $petId, ?int $treatmentId, ?int $vaccinationInfoId): bool
    {
        return ReminderLog::query()
            ->whereDate('sent_at', Carbon::today())
            ->where('reminder_type', $type)
            ->where('pet_id', $petId)
            ->where('treatment_id', $treatmentId)
            ->where('vaccination_info_id', $vaccinationInfoId)
            ->exists();
    }
}
