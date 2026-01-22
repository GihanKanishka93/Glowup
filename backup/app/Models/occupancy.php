<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class occupancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'room_id',
        'type',
        'admission_id',
        'name',
        'phone',
        'nic',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by_user_id = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by_user_id = auth()->id();
        });

        static::deleting(function ($model) {
            $model->deleted_by_user_id = auth()->id();
            $model->save();
        });
    }

    public function admissions()
    {
        return $this->belongsTo(admission::class);
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
 

    /**
     * Get the user that owns the occupancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

     /**
     * Get the user that owns the occupancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
     /**
     * Get the user that owns the occupancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by_user_id');
    }



}