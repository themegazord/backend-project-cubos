<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class DebtorException extends Exception
{
    public static function debtorNotExists(): self
    {
        return new self('O cliente não existe', Response::HTTP_NOT_FOUND);
    }

    public static function emailAlreadyExists(): self
    {
        return new self('O email já está sendo usado por outro cliente', Response::HTTP_UNAUTHORIZED);
    }

    public static function debtorContainsADueInstallment(): self {
        return new self('O cliente contêm um ou mais titulos vencidos', Response::HTTP_UNAUTHORIZED);
    }

    public static function debtorContainsPartiallyPaidInstallment(): self
    {
        return new self('O cliente contêm um ou mais titulos parcialmente pagos', Response::HTTP_UNAUTHORIZED);
    }
}
