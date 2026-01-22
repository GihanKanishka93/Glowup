<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'pet_id',
        'name',
        'photo',
        'gender',
        'date_of_birth',
        'age_at_register',
        'weight',
        'color',
        'remarks',
        'basic_ilness',
        'pet_category',
        'pet_breed',
        'created_by',
        'updated_by',
        'deleted_by',
        'owner_name',
        'owner_nic',
        'owner_occupation',
        'owner_contact',
        'owner_address',
        'owner_email',
    ];

    /**
     * Get the address associated with the patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pet_category()
    {
        return $this->hasOne(PetCategory::class, 'pet_category', 'id');
    }

    /**
     * Get all of the person for the patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function breed()
    {
        return $this->hasMany(PetBreed::class, 'pet_breed', 'id');
    }


}