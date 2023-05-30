<?php

namespace App\Http\Requests;

use App\Rules\UserHasPendingReview;
use Illuminate\Foundation\Http\FormRequest;

class InvitationRequest extends FormRequest
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
            'stadium_id' => ['required', 'integer', 'exists:stadia,id'],
            'invited_player_id' => ['required', 'integer', 'exists:users,id'],
            'date' => [
                'required',
                'after_or_equal:today',
            ],

            'time' => ['required'],

            'review' => [
                'nullable',
                new UserHasPendingReview($this->user())
            ],

        ];
    }
}
