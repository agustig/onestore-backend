<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'products' => ProductResource::collection($this->whenLoaded('products')),
                'created_at' => $this->whenHas('created_at'),
                'updated_at' => $this->whenHas('updated_at'),
            ];
    }
}
