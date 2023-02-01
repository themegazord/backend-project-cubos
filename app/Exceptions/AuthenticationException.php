<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends Exception
{
    public static function emailOrPasswordAreNotValid(): self{
        throw new self('O email e a senha não são válidos', Response::HTTP_UNAUTHORIZED);
    }
 }
