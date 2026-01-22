<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medication extends Model
{
    use HasFactory;
    protected $fillable = [
        'admission_id',
        'patient_id',
        'name',
        'dose',
        'frequency',
        'route',
        'indication'
    ];

    /**
     * Get the user that owns the medication
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admission()
    {
        return $this->belongsTo(admission::class, 'admission_id', 'id');
    }

    public function patient()
        {
            return $this->belongsTo(patient::class, 'patient_id');
        }
}
