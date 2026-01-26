<?php

namespace App\Http\Controllers;

use App\Models\ReminderLog;
use App\Models\ReminderSetting;
use Illuminate\Http\Request;

class ReminderSettingsController extends Controller
{
    public function index()
    {
        $settings = ReminderSetting::query()->latest('id')->first();
        $logs = ReminderLog::with(['patient'])
            ->latest('sent_at')
            ->paginate(25);

        return view('settings.reminders', [
            'settings' => $settings,
            'logs' => $logs,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'send_vaccination' => ['sometimes', 'boolean'],
            'send_followup' => ['sometimes', 'boolean'],
            'lead_days' => ['required', 'string'],
            'from_email' => ['nullable', 'email'],
            'from_name' => ['nullable', 'string', 'max:255'],
            'reply_to' => ['nullable', 'email'],
        ]);

        $leadDays = collect(explode(',', $validated['lead_days']))
            ->map(fn($d) => trim($d))
            ->filter()
            ->map(fn($d) => (int) $d)
            ->unique()
            ->values()
            ->toArray();

        ReminderSetting::create([
            'send_vaccination' => (bool) ($validated['send_vaccination'] ?? false),
            'send_followup' => (bool) ($validated['send_followup'] ?? false),
            'lead_days' => $leadDays,
            'from_email' => $validated['from_email'] ?? null,
            'from_name' => $validated['from_name'] ?? null,
            'reply_to' => $validated['reply_to'] ?? null,
        ]);

        return redirect()->route('settings.reminders.index')->with('message', 'Reminder settings updated.');
    }
}
