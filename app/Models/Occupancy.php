<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
