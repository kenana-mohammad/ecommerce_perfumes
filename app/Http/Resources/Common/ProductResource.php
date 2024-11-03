<?php

namespace App\Http\Resources\Common;

use App\Http\Resources\Website\Comment\commentresource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parentProduct = $this->parent;


        return[
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'volume' => $this->volume,
            'old_price' => $this->old_price,
            'current_price' => $this->current_price,
            'quantity '=>$this->quantity,
            'ingredients' => $this->ingredients,
            'specifications' => $this->specifications,
            'features' => $this->features,
           'category_id' => $this->category_id,
           'category_name' => $this->category->name,
          //اذا كان يوجد بديل 
           'parent' =>     $parentProduct
           ?[
            'id' => $parentProduct->id,
            'name' => $parentProduct->name,
            'description' => $parentProduct->description,
        ] : null,
        'comments' => commentresource::collecation($this->comments)??null
                         

        ];
    }
}
