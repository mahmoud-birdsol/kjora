<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
            ],
            'body' => [
                'required_without:attachments',
            ],
            'attachments' => [
                'nullable',
                'max:2084',
            ],
        ];
    }
}
