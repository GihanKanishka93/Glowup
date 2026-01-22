<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medical extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_id',
        'patient_id',
        'medical_diagnosis',
        'medical_history',
        'allergies',
        'patient_on_steroids',
        'current_medication',
        'any_pain',
        'type_of_pain',
        'pain_score',
        'temperature',
        'blood_pressure',
        'heart_reate',
        'breaths_per_minute',
        'sensory',
        'musculoskelete',
        'integumentary',
        'neurovascular',
        'circularory',
        'respiratory',
        'dental',
        'psychosocial',
        'nutrition',
        'elimination',
        'trouble_sleeping',
        'nausea_and_vomiting',
        'breathing_problem',
        'appetite_problem',
        'sensory_comment',
        'musculoskelete_comment',
        'integumentary_comment',
        'neurovascular_comment',
        'circularory_comment',
        'respiratory_comment',
        'dental_comment',
        'psychosocial_comment',
        'nutrition_comment',
        'elimination_comment',
        'trouble_sleeping_comment',
        'nausea_and_vomiting_comment',
        'breathing_problem_comment',
        'appetite_problem_comment'
    ];

    public function admission()
    {
        return $this->hasOne(admission::class, 'admission_id', 'id');
    }

    /**
     * Get the user that owns the medical
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(patient::class, 'patient_id');
    }


}