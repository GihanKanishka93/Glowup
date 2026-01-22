<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class person extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "nic",
        "address",
        "contact_number_one",
        "contact_number_two",
        "relationship_id",
        "is_guardian",
        "patient_id",
        "created_by",
        "updated_by",
        "deleted_by"];

        /**
         * Get the user that owns the person
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function relationship(): BelongsTo
        {
            return $this->belongsTo(relationship::class, 'relationship_id');
        }
}
