<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InstallmentException extends Exception
{
    public static function billingAlreadyExists(): self {
        throw new self('A cobrança já existe.', Response::HTTP_BAD_REQUEST);
    }
}
