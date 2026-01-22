<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientDailyVisit extends Model
{
    use HasFactory, SoftDeletes;

    // Define which attributes are mass-assignable
    protected $fillable = [
        'visit_time',
        'description',
        'user_id',
        'patient_id',
        'remark',
    ];

    /**
     * Relationship with the User model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Defines a relationship with the User who created the visit
    }
    /**
     * Relationship with the Patient model.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
