<?php

namespace App\Models;

use Carbon\Carbon;
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
        'owner_whatsapp',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function breed()
    {
        return $this->hasOne(PetBreed::class, 'pet_breed', 'id');
    }

    public function petbreed()
    {
        return $this->belongsTo(PetBreed::class, 'pet_breed');
    }

    public function petcategory()
    {
        return $this->belongsTo(PetCategory::class, 'pet_category');
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }


    public function getCurrentAgeAttribute(): ?string
    {
        if (!$this->date_of_birth) {
            return null;
        }

        $dob = Carbon::parse($this->date_of_birth);
        $diff = $dob->diff(Carbon::now());

        $yearsLabel = $diff->y === 1 ? 'year' : 'years';
        $monthsLabel = $diff->m === 1 ? 'month' : 'months';

        return sprintf('%d %s, %d %s', $diff->y, $yearsLabel, $diff->m, $monthsLabel);
    }


}
