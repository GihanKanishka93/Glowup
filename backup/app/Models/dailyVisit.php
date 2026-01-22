<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dailyVisit extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'visit_time',
'description',
'user_id',
'admission_id'
    ];

    /**
     * Get the user that owns the dailyVisit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admission()
    {
        return $this->belongsTo(admission::class, 'admission_id');
    }

    /**
     * Get the user that owns the dailyVisit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
