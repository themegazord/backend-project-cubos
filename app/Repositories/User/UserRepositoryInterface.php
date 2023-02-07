<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function update(array $payload, User $user): void;

    public function verifyByEmail(string $email): bool;

    public function verifyByCPF(string $cpf): bool;

}
