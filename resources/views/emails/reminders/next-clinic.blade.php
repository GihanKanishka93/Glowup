<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Follow-up Appointment Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2 style="margin-bottom: 12px;">Hi {{ $pet->owner_name ?? 'there' }},</h2>
    <p style="margin-top: 0;">This is a reminder that <strong>{{ $pet->name }}</strong> has a follow-up skincare appointment on <strong>{{ $nextClinicDate }}</strong>.</p>

    <p style="margin: 12px 0 0 0;">
        Client ID: <strong>{{ $pet->pet_id }}</strong><br>
        @if ($treatment->doctor?->name)
            Doctor: <strong>{{ $treatment->doctor->name }}</strong><br>
        @endif
    </p>

    <p style="margin: 16px 0 0 0;">If you need to reschedule or have questions, please contact us.</p>

    <p style="margin: 20px 0 0 0;">Thank you,<br>{{ $clinicName }}</p>
</body>
</html>
