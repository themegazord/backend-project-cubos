<?php

namespace App\Services\User;

use App\Exceptions\UserExceptions;
use App\Models\User;
use App\Actions\Utils\ValidateCPF;
use App\Exceptions\CPFException;
use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {

    }

    /**
     * @throws CPFException
     * @throws UserExceptions
     */
    public function update(array $payload, User $user): void
    {
        isset($payload['cpf']) && ValidateCPF::validateCPF($payload['cpf']);
        $this->verifyEmailExists($payload['email'], $user);
        isset($payload['cpf']) && $this->verifyCPFExists($payload['cpf'], $user);
        $this->userRepository->update($payload, $user);
    }

    /**
     * @throws UserExceptions
     */
    private function verifyEmailExists(string $email, User $user): void
    {
        if($email != $user['email'] && $this->findByEmail($email)) throw UserExceptions::emailAlreadyExists();
    }

    private function findByEmail(string $email): bool {
        return $this->userRepository->verifyByEmail($email);
    }

    /**
     * @throws CPFException
     */
    private function verifyCPFExists(string $cpf, User $user): void
    {
        if($cpf != $user['cpf'] && $this->findByCPF($cpf)) throw CPFException::CPFAlreadyExists();
    }

    private function findByCPF(string $cpf): bool
    {
        return $this->userRepository->verifyByCPF($cpf);
    }
}
