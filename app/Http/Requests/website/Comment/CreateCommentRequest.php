<?php

namespace App\Http\Requests\Website\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'rating' => 'integer|required|in:1,2,3,4,5',
            'comment' =>  'nullable|max:2000|string',
            'product_id' => 'exists:products,id',
            'user_id' => 'exists:users,id'

        ];
    }
}
