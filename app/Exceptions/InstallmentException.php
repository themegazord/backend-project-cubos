<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InstallmentException extends Exception
{
    /**
     * @throws InstallmentException
     */
    public static function billingAlreadyExists(): self {
        throw new self('A cobrança já existe.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws InstallmentException
     */
    public static function installmentItPending(): self
    {
        throw new self('O titulo não pode ser apagado, pois está pendente de pagamento, defina-o como aberto.', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws InstallmentException
     */
    public static function installmentItOverdue(): self
    {
        throw new self('O titulo não pode ser apagado, pois está em atraso', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws InstallmentException
     */
    public static function debtorIsDebtor(): self
    {
        throw new self('O titulo não pode ser apagado, cliente vinculado a esse titulo contêm um ou mais titulos em atraso', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws InstallmentException
     */
    public static function installmentNotExists(): self
    {
        throw new self('O titulo não existe', Response::HTTP_NOT_FOUND);
    }

    public static function statusIsNotValid(): self {
        throw new self('O status passado não é valido, por favor, insira apenas Paid ou Pending', Response::HTTP_UNAUTHORIZED);
    }
}
