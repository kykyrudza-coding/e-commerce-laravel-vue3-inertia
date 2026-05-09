<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_token' => $this->order_token,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'notes' => $this->notes,
            'total_price' => (float) $this->total_price,
            'currency' => $this->currency,
            'items' => $this->whenLoaded('items'),
            'delivery_address' => $this->whenLoaded('delivery_address'),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
