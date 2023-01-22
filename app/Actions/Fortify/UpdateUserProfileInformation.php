<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],

            'first_name' => ['required', 'string', 'min:3', 'max:18'],
            'last_name' => ['required', 'string', 'min:3', 'max:18'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'club_id' => ['required', 'integer', 'exists:clubs,id'],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            'position_id' => ['required', 'exists:positions,id'],
            'gender' => ['required', Rule::in(['male', 'female'])],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['avatar'])) {
            $user->updateProfilePhoto($input['avatar']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'username' => $input['username'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'username' => $input['username'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
