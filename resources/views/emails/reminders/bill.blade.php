<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $bill->billing_id }}</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family: 'Segoe UI', Tahoma, Verdana, sans-serif; color:#1f2937;">
@php
    $patientName = $patient->name ?? 'Valued Client';
    $doctorName = optional($treatment->doctor)->name ?? 'N/A';
    $billingDate = $bill->billing_date ? \Illuminate\Support\Carbon::parse($bill->billing_date)->format('Y-m-d') : 'N/A';
@endphp

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f4f6f8; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden; border:1px solid #e6ebf0;">
                    <tr>
                        <td style="background:linear-gradient(90deg, #111827, #1f2937); padding:20px 24px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="font-size:20px; font-weight:700; color:#f9fafb;">{{ $clinicName }}</td>
                                    <td align="right" style="font-size:12px; color:#d1d5db; letter-spacing:0.8px; text-transform:uppercase;">Skincare Invoice</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:26px 24px 10px 24px;">
                            <p style="margin:0 0 10px 0; font-size:28px; line-height:1.2; font-weight:700; color:#111827;">Hi {{ $patientName }},</p>
                            <p style="margin:0; font-size:15px; line-height:1.7; color:#374151;">
                                Thank you for visiting <strong>{{ $clinicName }}</strong>. Your invoice is attached as a PDF for your records.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:14px 24px 8px 24px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#fafafa; border:1px solid #eceff3; border-radius:10px;">
                                <tr>
                                    <td style="padding:16px 18px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280;">Bill ID</td>
                                                <td align="right" style="padding:6px 0; font-size:14px; font-weight:700; color:#111827;">{{ $bill->billing_id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280;">Billing Date</td>
                                                <td align="right" style="padding:6px 0; font-size:14px; font-weight:700; color:#111827;">{{ $billingDate }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280;">Client</td>
                                                <td align="right" style="padding:6px 0; font-size:14px; font-weight:700; color:#111827;">{{ $patientName }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; font-size:13px; color:#6b7280;">Doctor</td>
                                                <td align="right" style="padding:6px 0; font-size:14px; font-weight:700; color:#111827;">{{ $doctorName }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:10px 24px 24px 24px;">
                            <p style="margin:0; font-size:14px; line-height:1.7; color:#4b5563;">
                                If you have any questions, simply reply to this email and our team will help you.
                            </p>
                            <p style="margin:16px 0 0 0; font-size:14px; line-height:1.7; color:#111827;">
                                Thank you,<br>
                                <strong>{{ $clinicName }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
                <p style="margin:12px 0 0 0; font-size:11px; color:#9ca3af;">This is an automated invoice email.</p>
            </td>
        </tr>
    </table>
</body>
</html>
