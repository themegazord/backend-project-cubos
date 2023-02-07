<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserExceptions extends Exception
{
    public static function emailAlreadyExists(): self
    {
        return new self('O email já está sendo usado por outro usuário', Response::HTTP_UNAUTHORIZED);
    }
}
