<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'photo',
        'gender',
        'date_of_birth',
        'age_at_register',
        'allergies',
        'remarks',
        'basic_ilness',
        'created_by',
        'updated_by',
        'deleted_by',
        'father_name',
        'father_nic',
        'father_occupation',
        'father_income',
        'father_contact',
        'father_address',
        'mother_name',
        'mother_nic',
        'mother_occupation',
        'mother_income',
        'mother_contact',
        'mother_address',
        'guardian_name',
        'guardian_nic',
        'guartian_contact',
        'guardian_relationship_id',
        'patient_id',
        'guardian_occupation',
        'guardian_relationship',
        'guardian_contact2',
        'monthly_family_income',
        'monthly_loan_diductions',
        'transport_mode',
        'father_contact2',
        'mother_contact2',
        'cost_of_travel',
        'financial_support',
        'wdu_reside',
    ];

    /**
     * Get the address associated with the patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(address::class, 'patient_id', 'id');
    }

    /**
     * Get all of the person for the patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function person()
    {
        return $this->hasMany(person::class, 'patient_id', 'id');
    }


    public function admissions()
    {
        return $this->hasMany(admission::class);
    }
    public function dailyVisitPatient()
    {
        return $this->hasMany(PatientDailyVisit::class ,'patient_id', 'id');
    }
    /**
     * Get the user that owns the patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relationship()
    {
        return $this->belongsTo(relationship::class, 'guardian_relationship_id');
    }

}