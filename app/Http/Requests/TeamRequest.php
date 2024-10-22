<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'country_id' => [
                'required',
                'integer',
                'exists:countries,id',
            ],
            'code' => [
                'required',
                'string',
            ],
            'team_number' => [
                'required',
                'integer',
            ],
            'team_logo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
            ]
        ];
    }
}
