<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'name',
        'photo',
        'gender',
        'date_of_birth',
        'age_at_register',
        'allegics',
        'remarks',
        'basic_ilness',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }
}
