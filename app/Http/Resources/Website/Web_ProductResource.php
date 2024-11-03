<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Web_ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[

             'id' => $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'image' => $this->image,
        'volume' => $this->volume,
        'old_price' => $this->old_price,
        'current_price' => $this->current_price,
        'category_id' => $this->category_id,
        'category_name' => $this->category->name,
        'ingredients' => $this->ingredients,
        'specifications' => $this->specifications,
        'features' => $this->features,
        'quantity '=>$this->quantity,
        ];
    }
}
