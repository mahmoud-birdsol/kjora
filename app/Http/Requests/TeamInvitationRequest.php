<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'team_id' => [
                'required',
                'integer',
                'exists:teams,id'
            ],
            'players' => [
                'array',
                'required'
            ],
            'players.*.id' => [
                'required',
                'integer',
                'exists:users,id'
            ]
        ];
    }
}
