<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = Product::find($this->product_id, ['id', 'name', 'description', 'price', 'image_url', 'user_id']);
        $product->load('user');
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'product' => ProductResource::make($product),
            'quantity' => $this->quantity,
            'created_at' => $this->whenHas('created_at'),
            'updated_at' => $this->whenHas('updated_at'),
        ];
    }
}
