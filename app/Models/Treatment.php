<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'history_complaint',
        'clinical_observation',
        'remarks',
        'treatment_date',
        'next_clinic_date',
        'next_clinic_weeks',
        'next_clinic_reminder_sent_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'trement_id');
    }


    public function bills()
    {
        return $this->belongsTo(Bill::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'trement_id');
    }
}
