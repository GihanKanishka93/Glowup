<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PatientDailyVisit;


class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'name',
        'nic',
        'mobile_number',
        'whatsapp_number',
        'email',
        'address',
        'occupation',
        'referral_source',
        'photo',
        'gender',
        'date_of_birth',
        'age_at_register',
        'allegics',
        'remarks',
        'basic_ilness',
        'surgical_history',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    public function dailyVisitPatient(): HasMany
    {
        return $this->hasMany(PatientDailyVisit::class);
    }
}
