<?php

namespace App\Console\Commands;

use App\Services\ReminderService;
use Illuminate\Console\Command;

class SendReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send email reminders for upcoming vaccinations and next clinic dates';

    public function __construct(private ReminderService $reminderService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Sending reminders...');

        $results = $this->reminderService->sendReminders();
        $weekly = $this->reminderService->sendWeeklyReminders();

        $this->info("Vaccination reminders sent: {$results['vaccinations']}");
        $this->info("Next clinic reminders sent: {$results['followups']}");
        $this->info("Weekly vaccination reminders sent: {$weekly['vaccinations']}");
        $this->info("Weekly next clinic reminders sent: {$weekly['followups']}");

        return self::SUCCESS;
    }
}
