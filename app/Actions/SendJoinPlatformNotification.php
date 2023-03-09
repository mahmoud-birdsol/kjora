<?php

namespace App\Actions;

use App\Notifications\JoinPlatformNotification;
use App\Repositories\Token;
use Illuminate\Contracts\Auth\Authenticatable;

class SendJoinPlatformNotification
{
    const TABLE_NAME = 'join_platform_tokens';

    /**
     * @var \App\Actions\GenerateUniqueToken
     */
    private GenerateUniqueToken $generateUniqueToken;

    /**
     * @param  \App\Actions\GenerateUniqueToken  $generateUniqueToken
     */
    public function __construct(GenerateUniqueToken $generateUniqueToken)
    {
        $this->generateUniqueToken = $generateUniqueToken;
    }

    /**
     * Send a tokenized join platform notification which will redirect
     * the user to reset their password and join the platform.
     */
    public function __invoke(Authenticatable $user): void
    {
        $token = $this->storeToken($user);

        $user->notify(new JoinPlatformNotification($token));
    }

    /**
     * Generate and store a new unique token.
     */
    private function storeToken(Authenticatable $user): string
    {
        $token = ($this->generateUniqueToken)(self::TABLE_NAME);

        Token::make(self::TABLE_NAME)
            ->create($user, $token);

        return $token;
    }
}
