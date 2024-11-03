<?php

namespace App\Http\Requests\Dashboard\Copon;

use Illuminate\Foundation\Http\FormRequest;

class CreateCoponRequest extends FormRequest
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
            'code' => 'required|string|unique:coupons,code|max:20', 
            'discount_percent' => 'nullable|numeric|min:0|max:100', 
            'discount_amount' => 'nullable|numeric|min:0', // 
                        'expires_at' => 'nullable|date|after_or_equal:today',
         ];
    }
}
