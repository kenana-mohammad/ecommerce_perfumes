<?php

namespace App\Http\Requests\website;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'order_number' => 'string|unique:orders,order_number',
            'user_id'=> 'exists:users,id',
            'status' => 'in:pending,returned,confirmed',
            'delivery_type' => 'required|in:delivery,non_delivery',
            'code'=> 'nullable|exists:coupons,code',
            'products' => 'required|array',
            'products.*.product_id'=>'required|exists:products,id',
            'products.*.quantity'=>'nullable|min:1',

        ];
    }
}
