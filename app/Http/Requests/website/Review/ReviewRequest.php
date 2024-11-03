<?php

namespace App\Http\Requests\Website\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'rating'=> 'integer|in:1,2,3,4,5',
            'comment' => 'min:3|max:10000|nullable'
        ];
    }
}
