<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'billing_id' => $this->billing_id,
            'billing_date' => optional($this->billing_date ? \Carbon\Carbon::parse($this->billing_date) : null)->toDateString(),
            'payment_status' => $this->payment_status,
            'note' => $this->note,
            'total' => $this->total,
            'discount' => $this->discount,
            'tax_amount' => $this->tax_amount,
            'net_amount' => $this->net_amount,
            'payment_type' => $this->payment_type,
            'payment_note' => $this->payment_note,
            'print_status' => $this->print_status,
            'bill_status' => $this->bill_status,
            'bill_type' => $this->bill_type,
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
            'treatment' => new TreatmentResource($this->whenLoaded('treatment')),
            'items' => BillItemResource::collection($this->whenLoaded('BillItems')),
        ];
    }
}
