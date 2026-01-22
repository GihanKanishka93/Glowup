<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Treatment Follow-up Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2 style="margin-bottom: 12px;">Hi {{ $pet->owner_name ?? 'there' }},</h2>
    <p style="margin-top: 0;">This is a reminder that <strong>{{ $pet->name }}</strong> is scheduled for a skincare follow-up on <strong>{{ $dueDate }}</strong>.</p>

    <p style="margin: 12px 0 0 0;">
        @if ($vaccination->vaccine?->name)
            Treatment plan: <strong>{{ $vaccination->vaccine->name }}</strong><br>
        @endif
        Client ID: <strong>{{ $pet->pet_id }}</strong>
    </p>

    <p style="margin: 16px 0 0 0;">If you need to reschedule or have questions, please contact our clinic team.</p>

    <p style="margin: 20px 0 0 0;">Thank you,<br>{{ $clinicName }}</p>
</body>
</html>
