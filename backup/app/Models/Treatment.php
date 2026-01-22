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
        'pet_id',
        'doctor_id',
        'history_complaint',
        'clinical_observation',
        'remarks',
        'next_clinic_date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
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
        return $this->belongsTo(Prescription::class, 'treatment_id');
    }
}
