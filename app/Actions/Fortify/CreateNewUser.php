<?php

namespace App\Actions\Fortify;

use App\Models\States\Free;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @return \App\Models\User
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'min:3', 'max:18'],
            'last_name' => ['required', 'string', 'min:3', 'max:18'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'club_id' => ['required', 'integer', 'exists:clubs,id'],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            'phone' => ['required', 'phone' , 'unique:users,phone'],
            'position_id' => ['required', 'exists:positions,id'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'date_of_birth.before' => 'You must be at least 18 years of age.',
        ])->validate();

        $user = User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'joined_platform_at' => now(),
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'country_id' => $input['country_id'],
            'club_id' => $input['club_id'],
            'date_of_birth' => Carbon::parse($input['date_of_birth']),
            'phone' => $input['phone'],
            'position_id' => $input['position_id'],
            'gender' => $input['gender'],
            'state' => Free::class,
            'accepted_terms_and_conditions_at' => now(),
            'accepted_privacy_policy_at' => now(),
            'accepted_cookie_policy_at' => now(),
        ]);

        if (isset($input['photo'])) {
            $user->addMediaFromRequest('photo')->toMediaCollection('avatar');
        }

        return $user;
    }
}
