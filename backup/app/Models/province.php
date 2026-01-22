<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    use HasFactory;

    /**
     * Get all of the district for the province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function district()
    {
        return $this->hasMany(district::class, 'province_id', 'id');
    }
}
