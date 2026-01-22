<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class admission extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
                                        "room_id",
                                        "patient_id",
                                        "type_of_service",
                                        "date_of_check_in",
                                        "date_of_check_out",
                                        "plan_to_check_in",
                                        "plan_to_check_out",
                                        "number_of_days",
                                        "room_id",
                                        "patient_id",
                                        "created_by",
                                        "updated_by",
                                        "deleted_by",
                                        "on_screan_medical",
                                        "agreement_file",
                                        "duration_of_stay",
                                        "reffered_ward",
                                        "reffered_counsultant",
                                        "treatment_history",
                                        "special_requirements",
                                        "remarks",
                                        "parents",
                                        "inventory_remarks"
                                        ];

        /**
         * Get the user that owns the admission
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function patient()
        {
            return $this->belongsTo(patient::class, 'patient_id');
        }

        /**
         * Get the user that owns the admission
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function room()
        {
            return $this->belongsTo(room::class, 'room_id');
        }

        public function scopeNotDischarged($query)
        {
            return $query->whereNull('date_of_check_out');
        }

        /**
         * Get all of the comments for the admission
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function guests()
        {
            return $this->hasMany(guests::class, 'admission_id', 'id');
        }

        public function medical(){
            return $this->hasOne(medical::class, 'admission_id', 'id');
        }

        /**
         * Get the medication associated with the admission
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function medication()
        {
            return $this->hasMany(medication::class, 'admission_id', 'id');
        }

        /**
         * Get all of the comments for the admission
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function dailyvisit()
        {
            return $this->hasMany(dailyVisit::class, 'admission_id', 'id');
        }

        public function createdBy()
        {
            return $this->belongsTo(User::class, 'created_by', 'id')->withDefault([
                'user_name' => '', 
            ]);
        }

        public function updatedBy()
        {
            return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault([
                'user_name' => '', 
            ]);
        }

        public function deletedBy()
        {
            return $this->belongsTo(User::class, 'deleted_by', 'id')->withDefault([
                'user_name' => '', 
            ]);
        }

        /**
     * The roles that belong to the room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function item(): BelongsToMany
    {
        return $this->belongsToMany(item::class)->withPivot('check_out');
    }

    /**
     * Get all of the occupancy for the admission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function occupancy(): HasMany
    {
        return $this->hasMany(occupancy::class);
    }
        
       
}
