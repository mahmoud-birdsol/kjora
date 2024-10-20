<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class Token
{
    private string $table;

    private string $token;

    private Authenticatable $authenticatable;

    /**
     * Create a new token instance.
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * Create a new token instance.
     *
     * @return \App\Repositories\Token
     */
    public static function make(string $table): Token
    {
        return new static($table);
    }

    /**
     * Create an authenticatable token.
     *
     * @return bool
     */
    public function create(Authenticatable $user, string $token)
    {
        $this->authenticatable = $user;
        $this->token = $token;

        $this->save();

        return $this;
    }

    /**
     * Validate an authenticatable token.
     */
    public function validate(string $token): bool
    {
        return (bool) $this->find($token);
    }

    /**
     * Find the authenticatable model from token.
     *
     * @return $this|null
     */
    public function find(string $token): Token|null
    {
        $model = DB::table($this->table)->where('token', $token)->first();

        if (is_null($model)) {
            throw new ModelNotFoundException();
        }

        $class = new $model->authenticatable_type;
        $user = $class->find($model->authenticatable_id);

        $this->token = $model->token;
        $this->authenticatable = $user;

        return $this;
    }

    /**
     * Get the authenticatable model.
     */
    public function authenticatable(): Authenticatable
    {
        return $this->authenticatable;
    }

    /**
     * Get the authenticatable guard.
     */
    public function guard(): string
    {
        return get_class($this->authenticatable) == Admin::class ? 'admin' : 'web';
    }

    /**
     * Save the newly generated token to DB.
     */
    private function save(): void
    {
        DB::table($this->table)->insert([
            'authenticatable_id' => $this->authenticatable->id,
            'authenticatable_type' => get_class($this->authenticatable),
            'token' => $this->token,
        ]);
    }
}
