<?php

namespace App\Repositories\Auth;

interface AuthRepositoryInterface {
    public function create(array $credentials): void;
    public function findByEmail(string $email): bool;
}

