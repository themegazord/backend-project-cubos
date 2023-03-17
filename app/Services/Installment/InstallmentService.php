<?php

namespace App\Services\Installment;

use App\Exceptions\InstallmentException;
use App\Models\Installment;
use App\Repositories\Installment\InstallmentRepositoryInterface;

class InstallmentService {
    public function __construct(private InstallmentRepositoryInterface $installmentRepository)
    {}

    public function create(array $installment): void {
        $installment['id_billing'] = $this->generateUuid();
        $this->installmentRepository->create($installment);
    }

    public function findById(int $id): Installment {
        return $this->installmentRepository->findById($id);
    }

    /**
     * @throws InstallmentException
     */
    public function update(array $payload, int $id): void {
        $this->determineStatusInstallment($payload);
        $this->installmentRepository->update($payload, $id);
    }


    public function allInstallments(string $filtros = null): array {
        if(is_null($filtros)) {
            return $this->determineIfInstallmentsAreOverduePayment($this->getTheInstallmentsWhenThereIsNoFilter());
        }
        return $this->determineIfInstallmentsAreOverduePayment($this->getTheInstallmentWhenThereFilter($filtros));
    }

    /**
     * @throws InstallmentException
     */
    private function verifyPossibilityToDeleteAInstallment(int $id): void
    {
        $this->checkIfInstallmentExists($id);
        $this->checkIfInstallmentItPending($id);
        $this->checkIfInstallmentItOverdue($id);
    }

    public function destroy(int $id): void
    {
        $this->verifyPossibilityToDeleteAInstallment($id);
        $this->installmentRepository->destroy($id);
    }


    /**
     * @throws InstallmentException
     */
    private function determineStatusInstallment (array $installmentRequest): void {
        if(!$installmentRequest['status'] == 'Paid' || !$installmentRequest['status'] == 'Pending') {
            throw InstallmentException::statusIsNotValid();
        }
    }

    private function getTheInstallmentsWhenThereIsNoFilter(): array {
        return $this->installmentRepository->allInstallments();
    }

    private function getTheInstallmentWhenThereFilter(string $filtros): array {
        return $this->installmentRepository->allInstallmentsWithFilters($this->explodeFilters($filtros));
    }

    private function explodeFilters(string $filtros): array {
        $filtrosTratados = [];
        $filtros = explode(';', $filtros);
        foreach($filtros as $filtro) {
            $filtrosTratados[] = explode(':', $filtro);
        }
        return $filtrosTratados;
    }

    private function determineIfInstallmentsAreOverduePayment(array $installmentRequest): array {
        return array_map(function ($installment) {
            if ($installment['due_date'] < date('Y-m-d')) {
                $installment['overdue_payment'] = 1;
                $this->update($installment, $installment['id']);
                return $installment;
            }
            if ($installment['due_date'] >= date('Y-m-d')) {
                $installment['overdue_payment'] = 0;
                $this->update($installment, $installment['id']);
                return $installment;
            }
        }, $installmentRequest);
    }

    /**
     * @throws InstallmentException
     */
    private function checkIfInstallmentItPending(int $id): void
    {
        if($this->installmentRepository->checkIfInstallmentItPending($id)) throw InstallmentException::installmentItPending();
    }

    /**
     * @throws InstallmentException
     */
    private function checkIfInstallmentItOverdue(int $id): void
    {
        if($this->installmentRepository->checkIfInstallmentItOverdue($id)) throw InstallmentException::installmentItOverdue();
    }

    /**
     * @throws InstallmentException
     */
    private function checkIfInstallmentExists(int $id): void
    {
        if(!$this->installmentRepository->checkIfInstallmentExists($id)) throw InstallmentException::installmentNotExists();
    }

    private function generateUuid(): null|string {
        return uuid_create();
    }
 }
