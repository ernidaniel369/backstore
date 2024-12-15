<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null, // Check for null before formatting
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null, 
        ];
    }
}