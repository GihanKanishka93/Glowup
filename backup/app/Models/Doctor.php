<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'deleted_by'
    ];
}