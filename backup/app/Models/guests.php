<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guests extends Model
{
    use HasFactory;
    protected $fillable = [
        "admission_id","name","dob","relationship_id","deleted_at","nic"
    ];

    /**
     * Get the user that owns the guests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admission()
    {
        return $this->belongsTo(admission::class, 'admission_id', 'id');
    }

    /**
     * Get the user that owns the guests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relationship()
    {
        return $this->belongsTo(relationship::class, 'relationship_id', 'id');
    }
}
