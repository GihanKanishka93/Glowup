<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'billing_id',
        'treatment_id',
        'billing_date',
        'payment_status',
        'note',
        'total',
        'discount',
        'tax_amount',
        'net_amount',
        'payment_type',
        'payment_note',
        'print_status',
        'bill_status',
        'bill_type',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }

    public function BillItems()
    {
        return $this->hasMany(BillItem::class, 'bill_id', 'id');
    }
}
