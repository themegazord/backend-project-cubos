<?php

namespace App\Actions\Utils;

use App\Exceptions\CPFException;

class ValidateCPF
{
    /**
     * Código de: Rafael Neri
     * Link: https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
     * @throws CPFException
     */
    public static function validateCPF(string $cpf): CPFException|bool
    {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            throw CPFException::CPFIsNotValid();
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw CPFException::CPFIsNotValid();
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw CPFException::CPFIsNotValid();
            }
        }
        return true;
    }
}
