<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'number' => $this->number,
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'delivery_address' => $this->delivery_address,
            'total_price' => $this->total_price,
            'payment_status' => $this->payment_status,
            'payment_url' => $this->payment_url,
            'created_at' => $this->whenHas('created_at'),
            'updated_at' => $this->whenHas('updated_at'),
        ];
    }
}
