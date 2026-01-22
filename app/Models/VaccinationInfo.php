<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccinationInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'trement_id',
        'vaccine_id',
        'duration',
        'remarks',
        'next_vacc_date',
        'next_vacc_weeks',
        'reminder_sent_at'
    ];

    public function vaccine()
    {
        return $this->belongsTo(Vaccination::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'trement_id');
    }
}
