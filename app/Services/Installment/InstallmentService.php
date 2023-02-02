<?php

namespace App\Services\Installment;

use App\Exceptions\InstallmentException;
use App\Models\Installment;
use App\Repositories\Installment\InstallmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class InstallmentService {
    public function __construct(private InstallmentRepositoryInterface $installmentRepository)
    {}

    public function create(array $installment): void {
        $this->verifyExistsBilling($installment['id_billing']);
        $this->installmentRepository->create($installment);
    }

    public function findById(int $id): Installment {
        return $this->installmentRepository->findById($id);
    }

    private function update(array $payload, int $id): void {
        $this->verifyIsPossibleAlterIdBilling($payload, $id);
        $this->installmentRepository->update($payload, $id);
    }

    private function verifyIsPossibleAlterIdBilling(array $payload, int $id): InstallmentException|bool {
        if(($this->findById($id)->id_billing != $payload['id_billing']) && $this->verifyExistsBilling($payload['id_billing'])) {
            throw InstallmentException::billingAlreadyExists();
        }
        return false;
    }

    public function determineStatusInstallment (array $installmentRequest, int $id): array {
        $installment = $this->findById($id);
        if(doubleval($installmentRequest['paid_amount']) > 0  && doubleval($installmentRequest['paid_amount']) < $installment->amount) {
            $installmentRequest['status'] = 'Partially paid';
            $this->update($installmentRequest, $installment['id']);
            return $installmentRequest;
        }
        if (doubleval($installmentRequest['paid_amount']) === $installment->amount) {
            $installmentRequest['status'] = 'Paid';
            $this->update($installmentRequest, $installment['id']);
            return $installmentRequest;
        }
        if (doubleval($installmentRequest['paid_amount']) == 0){
            $installmentRequest['status'] = 'Open';
            $this->update($installmentRequest, $installment['id']);
            return $installmentRequest;
        }
    }

    public function allInstallments(string $filtros = null): array {
        if(is_null($filtros)) {
            return $this->determineIfInstallmentsAreOverduePayment($this->getTheInstallmentsWhenThereIsNoFilter());
        }
        return $this->determineIfInstallmentsAreOverduePayment($this->getTheInstallmentWhenThereFilter($filtros));
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
                return $this->determineStatusInstallment($installment, $installment['id']);
            }
            if ($installment['due_date'] >= date('Y-m-d')) {
                $installment['overdue_payment'] = 0;
                $this->update($installment, $installment['id']);
                return $this->determineStatusInstallment($installment, $installment['id']);
            }
        }, $installmentRequest);
    }

    private function verifyExistsBilling(int $id_billing):InstallmentException|bool {
        if($this->installmentRepository->findByIdBilling($id_billing)) {
            throw InstallmentException::billingAlreadyExists();
        }
        return false;
    }
 }
