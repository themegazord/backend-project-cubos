<?php

namespace App\Repositories\User;

use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    public function update(array $payload, User $user): void
    {
        $user->update($payload);
    }

    public function verifyByEmail(string $email): bool
    {
        return (bool)User::where('email', $email)
            ->first();
    }

    public function verifyByCPF(string $cpf): bool
    {
        return (bool)User::where('cpf', $cpf)
            ->first();
    }

}
