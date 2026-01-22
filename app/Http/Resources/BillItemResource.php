<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'bill_id' => $this->bill_id,
            'billing_date' => $this->billing_date,
            'item_name' => $this->item_name,
            'item_qty' => $this->item_qty,
            'unit_price' => $this->unit_price,
            'tax' => $this->tax,
            'total_price' => $this->total_price,
            'note' => $this->note,
        ];
    }
}
