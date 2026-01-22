<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderSetting extends Model
{
    protected $fillable = [
        'send_vaccination',
        'send_followup',
        'lead_days',
        'from_email',
        'from_name',
        'reply_to',
    ];

    protected $casts = [
        'send_vaccination' => 'boolean',
        'send_followup' => 'boolean',
        'lead_days' => 'array',
    ];
}
