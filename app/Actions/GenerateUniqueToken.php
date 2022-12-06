<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateUniqueToken
{
    /**
     * Generate a unique token for the specified table and column.
     *
     * @param  string  $tableName
     * @param  int  $length
     * @param  string  $tokenColumnName
     * @return string
     */
    public function __invoke(string $tableName, int $length = 16, string $tokenColumnName = 'token'): string
    {
        return $this->generateToken($length, $tableName, $tokenColumnName);
    }

    /**
     * Generate a new token.
     *
     * @param  int  $length
     * @param  string  $tableName
     * @param  string  $tokenColumnName
     * @return string
     */
    private function generateToken(int $length, string $tableName, string $tokenColumnName): string
    {
        $token = Str::random($length);

        if ($this->tokenExists($tableName, $tokenColumnName, $token)) {
            return $this->generateToken($length, $tableName, $tokenColumnName);
        }

        return $token;
    }

    /**
     * Check if the token exists.
     *
     * @param  string  $tableName
     * @param  string  $tokenColumnName
     * @param  string  $token
     * @return bool
     */
    private function tokenExists(string $tableName, string $tokenColumnName, string $token): bool
    {
        return DB::table($tableName)->where($tokenColumnName, $token)->exists();
    }
}
