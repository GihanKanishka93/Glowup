<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderLog extends Model
{
    protected $fillable = [
        'reminder_type',
        'patient_id',
        'treatment_id',
        'vaccination_info_id',
        'owner_email',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function vaccinationInfo()
    {
        return $this->belongsTo(VaccinationInfo::class);
    }
}
