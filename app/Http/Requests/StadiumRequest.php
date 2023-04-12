<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StadiumRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:256',
            ],
            'longitude' => [
                'required',
            ],
            'latitude' => [
                'required',
            ],
            'google_place_id' => [
                'nullable',
            ],
            'user_id' => [
                'nullable',
            ],
            'approved_at' => [
                'nullable',
            ],
        ];
    }
}
