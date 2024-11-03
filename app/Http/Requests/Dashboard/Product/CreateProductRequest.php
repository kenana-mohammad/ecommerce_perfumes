<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required|string|min:2',
            'volume' => 'nullable|integer|between:10,500',
            'image' => 'required|file|image|mimes:png,jpg,jpeg,jfif|max:10000|mimetypes:image/jpeg,image/png,image/jpg,image/jfif',
            'description' => 'nullable|min:5|max:10000|string',
            'old_price' => 'nullable|numeric',
            'current_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'parent_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer',

           'ingredients' => 'nullable|array',
           'ingredients.*' => 'string|max:50', 
           'specifications' => 'nullable|json',
             'features' => 'nullable|array',
           'features.*' => 'string|max:50', 

        ];
    }
}
