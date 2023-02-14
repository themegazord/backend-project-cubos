<?php

namespace App\Services\Debtors;

use App\Actions\Utils\ValidateCPF;
use App\Exceptions\CPFException;
use App\Exceptions\DebtorException;
use App\Repositories\Debtor\DebtorRepositoryInterface;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;

class DebtorsService
{
    public function __construct(
        private DebtorRepositoryInterface $debtorRepository,
        private ValidateCPF $validateCPF
    )
    {

    }

    public function findAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->debtorRepository->findAll();
    }

    public function findUserDebtors(int $id): \Illuminate\Database\Eloquent\Collection
    {
        return $this->debtorRepository->findUserDebtors($id);
    }

    public function findById(int $id): array
    {
        return $this->debtorRepository->findById($id);
    }

    /**
     * @throws CPFException
     * @throws DebtorException
     */
    public function create(array $payload): void
    {
        $this->validateCPF::validateCPF($payload['cpf']);
        $this->verifyEmailExists($payload['email'], null);
        $this->verifyCPFExists($payload['cpf'], null);
        $this->debtorRepository->create($payload);
    }

    /**
     * @throws DebtorException
     * @throws CPFException
     */
    public function update(array $payload, int $id): void
    {
        $this->validateCPF::validateCPF($payload['cpf']);
        $this->verifyEmailExists($payload['email'], $id);
        $this->verifyCPFExists($payload['cpf'], $id);
        $this->debtorRepository->update($payload, $id);
    }

    /**
     * @throws DebtorException
     */
    public function verifyPossibilityADeleteDebtor(int $id): void
    {
        $this->findById($id);
        if(!$this->debtorRepository->debtorContainsInstallments($id)) {
            $this->destroy($id);
            die(); // vai retornar 200 nessa porra e que se foda kkksakakkas
        }
        $this->debtorContainsADueInstallment($id);
        $this->debtorContainsPartiallyPaidInstallment($id);
        $this->destroy($id);
    }

    public function getAllPayers(int $id): array|\Illuminate\Database\Eloquent\Collection
    {
        return $this->debtorRepository->getAllPayers($id);
    }

    public function getAllDefaulters(int $id): array|\Illuminate\Database\Eloquent\Collection
    {
        return $this->debtorRepository->getAllDefaulters($id);
    }

    private function destroy(int $id): void
    {
       $this->debtorRepository->destroy($id);
    }

    private function findByEmail(string $email): array
    {
        return $this->debtorRepository->findByEmail($email);
    }

    private function findByCPF(string $cpf): array {
        return $this->debtorRepository->findByCPF($cpf);
    }

    /**
     * @throws DebtorException
     * @throws Exception
     */
    private function verifyEmailExists(string $email, int $id = null): void
    {
        if(is_null($id)) {
            if ($this->findByEmail($email)) throw DebtorException::emailAlreadyExists();
        }

        if(!is_null($id)) {
            if ($email != $this->findById($id)['email'] && $this->findByEmail($email)) throw DebtorException::emailAlreadyExists();
        }
    }

    /**
     * @throws CPFException
     */
    private function verifyCPFExists(string $cpf, int $id = null): void
    {
        if (is_null($id)) {
            if($this->findByCPF($cpf)) throw CPFException::CPFAlreadyExists();
        }

        if (!is_null($id)) {
            if ($cpf != $this->findById($id)['cpf'] && $this->findByCPF($cpf)) throw CPFException::CPFAlreadyExists();
        }
    }


    /**
     * @throws DebtorException
     */
    private function debtorContainsADueInstallment(int $id): void
    {
        if($this->debtorRepository->debtorContainsADueInstallment($id)) throw DebtorException::debtorContainsADueInstallment();
    }

    /**
     * @throws DebtorException
     */
    private function debtorContainsPartiallyPaidInstallment(int $id): void
    {
        if($this->debtorRepository->debtorContainsPartiallyPaidInstallment($id)) throw DebtorException::debtorContainsPartiallyPaidInstallment();
    }

}
