<?php

namespace App\Services\Installment;

use App\Models\Installment;
use App\Repositories\Installment\InstallmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class InstallmentService {
    public function __construct(private InstallmentRepositoryInterface $installmentRepository)
    {}

    public function create(array $installment): void {
        $this->installmentRepository->create($installment);
    }

    public function findById(int $id): Installment {
        return $this->installmentRepository->findById($id);
    }

    public function update(array $payload, Installment $installment): void {
        $installment->update($payload);
    }

    public function determineStatusInstallment (array $installmentRequest, int $id): array {
        $installment = $this->findById($id);
        if(doubleval($installmentRequest['paid_amount']) > 0  && doubleval($installmentRequest['paid_amount']) < $installment->amount) {
            $installmentRequest['status'] = 'Baixado parcialmente';
            $this->update($installmentRequest, $installment);
            return $installmentRequest;
        }
        if (doubleval($installmentRequest['paid_amount']) === $installment->amount) {
            $installmentRequest['status'] = 'Baixado';
            $this->update($installmentRequest, $installment);
            return $installmentRequest;
        }
        if (doubleval($installmentRequest['paid_amount']) == 0){
            $installmentRequest['status'] = 'Aberto';
            $this->update($installmentRequest, $installment);
            return $installmentRequest;
        }
    }

    public function paginate(string $filtros = null): array {
        if(is_null($filtros)) {
            return $this->determineIfInstallmentsAreOverduePayment($this->getTheInstallmentsWhenThereIsNoFilter());
        }
        return $this->determineIfInstallmentsAreOverduePayment($this->getTheInstallmentWhenThereFilter($filtros));
    }

    public function getTheInstallmentsWhenThereIsNoFilter(): array {
        return $this->installmentRepository->allInstallments();
    }

    public function getTheInstallmentWhenThereFilter(string $filtros): array {
        return $this->installmentRepository->allInstallmentsWithFilters($this->explodeFilters($filtros));
    }

    public function explodeFilters(string $filtros): array {
        $filtrosTratados = [];
        $filtros = explode(';', $filtros);
        foreach($filtros as $filtro) {
            array_push($filtrosTratados, explode(':', $filtro));
        }
        return $filtrosTratados;
    }

    public function determineIfInstallmentsAreOverduePayment(array $installmentRequest): array {
        return array_map(function ($installment) {
            if ($installment['due_date'] < date('Y-m-d')) {
                $installment['overdue_payment'] = 1;
                $this->update($installment, $this->findById($installment['id']));
            } else {
                $installment['overdue_payment'] = 0;
                $this->update($installment, $this->findById($installment['id']));
            }
            return $installment;
        }, $installmentRequest);
    }
 }
