<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class district extends Model
{
    use HasFactory;

    /**
     * Get all of the address for the district
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany(address::class, 'district_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(province::class, 'province_id', 'id');
    }
}