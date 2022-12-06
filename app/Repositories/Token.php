<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class Token
{
    /**
     * @var string
     */
    private string $table;

    /**
     * @var string
     */
    private string $token;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    private Authenticatable $authenticatable;

    /**
     * @param  string  $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * @param  string  $table
     * @return \App\Repositories\Token
     */
    public static function make(string $table): Token
    {
        return new static($table);
    }

    /**
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
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
     * @param  string  $token
     * @return bool
     */
    public function validate(string $token): bool
    {
        return (bool) $this->find($token);
    }

    /**
     * @param  string  $token
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
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function authenticatable(): Authenticatable
    {
        return $this->authenticatable;
    }

    /**
     * Get the authenticatable guard.
     *
     * @return string
     */
    public function guard(): string
    {
        return get_class($this->authenticatable) == Admin::class ? 'admin' : 'web';
    }

    /**
     * @return void
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
