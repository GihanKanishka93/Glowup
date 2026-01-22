<?php

namespace App\Models;

use App\Models\item; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class room extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'room_number',
'floor_id',
'inventory',
'status',
'deleted_at',
'created_by',
'updated_by',
'deleted_by',
    ];

    public function admissions()
    {
        return $this->hasMany(admission::class);
    }

    /**
     * The roles that belong to the room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function item(): BelongsToMany
    {
        return $this->belongsToMany(item::class);
    }

    /**
     * Get the user that owns the room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function floor(): BelongsTo
    {
        return $this->belongsTo(floor::class, 'floor_id', 'id');
    }

    public function occupancy()
    {
        return $this->hasMany(occupancy::class);
    }
}
