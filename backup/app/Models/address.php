<?php

namespace App\Models;

use App\Models\district;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class address extends Model
{
    use HasFactory;
    protected $fillable = [
        "home",
        "street",
        "city",
        "district_id",
        "distance_to_suwa_arana",
        "patient_id",
        "created_by",
        "updated_by",
        "deleted_by"];
        

        public function patient(): BelongsTo
        {
            return $this->belongsTo(patient::class);
        }
        public function district(){
            return $this->belongsTo(district::class);
        }

}
