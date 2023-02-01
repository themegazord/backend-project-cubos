<?php

namespace App\Services\Auth;

use Exception;
use App\Exceptions\AuthenticationException;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AuthenticationService {
    public function __construct(private AuthRepositoryInterface $authRepository)
    {}

    public function create(array $credentials): void
    {
        $this->authRepository->create($credentials);
    }

    public function authenticate(array $credentials): void
    {
        if(!auth()->attempt($credentials)) {
            throw AuthenticationException::emailOrPasswordAreNotValid();
        }
    }

    public function createResponse(array $auth): array {
        $auth['aka'] = $this->generateAkaName($auth['name']);
        return $auth;

    }

    private function generateAkaName(string $name): string {
        if(count($this->explodeName($name)) > 1) {
            return $this->explodeName($name)[0][0] . $this->explodeName($name)[count($this->explodeName($name)) - 1][0];
        } else {
            return $this->explodeName($name)[0][0] . $this->explodeName($name)[0][2];
        }
    }

    private function explodeName(string $name): array {
        return explode(' ', $name);
    }
}

