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
                'max:254',
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
            'street_address' => [
                'required',
                'string',
                'max:254',
            ],
            'country' => [
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
