<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VerifyPhoneRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'code' => [
                'required',
                // todo refactor rule.
                function ($attribute, $value, $fail) {
                    $verificationCode = DB::table(config('verification.verification_codes_table'))
                        ->where('phone', $this->user_id)
                        ->where('code', $this->code)
                        ->first();

                    if (is_null($verificationCode)) {
                        return $fail(__('validation.exists', ['attribute' => $attribute]));
                    }

                    if (
                        Carbon::parse($verificationCode->created_at)
                            ->addMinutes(config('verification.expiry') ?? 3)
                            ->isPast()
                    ) {
                        return $fail(__('verification.verification_code_expired'));
                    }
                },
            ],
        ];
    }
}
