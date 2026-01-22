<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'name',
        'gender',
        'designation',
        'address',
        'contact_no',
        'email',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }
}
