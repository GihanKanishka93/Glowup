<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'bill_id',
        'billing_date',
        'item_name',
        'item_qty',
        'unit_price',
        'tax',
        'total_price',
        'note',
    ];

    public function bills()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }
}