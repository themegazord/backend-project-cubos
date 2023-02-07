<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class CPFException extends Exception
{
    public static function CPFIsNotValid(): self {
        return new self('O CPF inserido não é matematicamente válido', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function CPFAlreadyExists(): self
    {
        return new self('O CPF já está cadastrado em outro usuário', Response::HTTP_UNAUTHORIZED);
    }
}
