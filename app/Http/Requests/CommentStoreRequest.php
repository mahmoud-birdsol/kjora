<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                'exists:comments,id'
            ],
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'body' => [
                'required',
                'string',
                'max:256'
            ],
            'commentable_id' => [
                'required'
            ],
            'commentable_type' => [
                'required'
            ]
        ];
    }
}
