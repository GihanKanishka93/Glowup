<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $bill->billing_id }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937;">
    <h2 style="margin-bottom: 12px;">Hi {{ $pet->owner_name ?? 'there' }},</h2>
    <p style="margin-top: 0;">Thank you for visiting {{ $clinicName }}. Attached is your skincare invoice.</p>

    <p style="margin: 12px 0 0 0;">
        Bill ID: <strong>{{ $bill->billing_id }}</strong><br>
        Billing Date: <strong>{{ $bill->billing_date }}</strong><br>
        Client: <strong>{{ $pet->name ?? 'N/A' }}</strong><br>
        Doctor: <strong>{{ $treatment->doctor->name ?? 'N/A' }}</strong>
    </p>

    <p style="margin: 16px 0 0 0;">If you have any questions about this bill, please contact us.</p>

    <p style="margin: 20px 0 0 0;">Thank you,<br>{{ $clinicName }}</p>
</body>
</html>
