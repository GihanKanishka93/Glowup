<?php

return [
    // Days before the due date to trigger reminders (dates are matched by day, not time)
    'lead_days' => [1, 3, 7],

    // Optional weekly cadence (every 7 days until the due date)
    'weekly_vaccination' => true,
    'weekly_followup' => true,

    // Toggle reminder types
    'send_vaccination' => true,
    'send_followup' => true,

    // Mail settings (fallback to mail.from if null)
    'from_email' => env('REMINDER_FROM_EMAIL', null),
    'from_name' => env('REMINDER_FROM_NAME', null),
    'reply_to' => env('REMINDER_REPLY_TO', null),
];
