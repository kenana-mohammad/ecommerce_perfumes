<?php

namespace App\Http\Resources\Common;

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
$orderItems= $this->items->map(function ($item) {
        return [
            'product_id' => $item->product_id,
            'product_name' => $item->product->name, // assuming there is a relation to get product name
            'quantity' => $item->quantity,
            'sum_price' => $item->sum_price,
        ];
    });
            return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'user' => $this->user->name,
            'copone_code' => $this->copone_code ? $this->copone_code : 'null',
            'status' => $this->status,
            'orderItem'=> $orderItems
        ];
    }
}
