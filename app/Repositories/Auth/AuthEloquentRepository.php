<?php

namespace App\Repositories\Auth;

use App\Repositories\Auth\AuthRepositoryInterface;
use App\Models\User;


class AuthEloquentRepository implements AuthRepositoryInterface {
    public function create(array $credentials): void
    {
        User::create($credentials);
    }
}
