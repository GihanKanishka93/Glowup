<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class item extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];


     /**
     * The roles that belong to the room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function room(): BelongsToMany
    {
        return $this->belongsToMany(room::class, 'items_rooms', 'item_id', 'room_id');
    }
}
