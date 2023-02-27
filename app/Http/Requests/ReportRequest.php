<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
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
            'reportable_type' => [
                'required',
                Rule::in([User::class,]),
            ],
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'reportable_id' => [
                'required',
                'integer',
            ],
            'report_option_id' => [
                'required',
                'exists:report_options,id',
            ],
            'body' => [
                'nullable',
            ],
        ];
    }
}
