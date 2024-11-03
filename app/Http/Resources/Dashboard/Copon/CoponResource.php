<?php

namespace App\Http\Resources\Dashboard\Copon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoponResource extends JsonResource
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
            'code' => $this->code,
            'discount_percent'=> $this->discount_percent,
            'discount_amount' => $this->discount_amount,
            'expires_at' => $this->expires_at
        ];
    }
}
