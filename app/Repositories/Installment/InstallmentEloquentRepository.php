<?php

namespace App\Repositories\Installment;

use App\Http\Resources\InstallmentCollection;
use App\Models\Installment;
use App\Repositories\Installment\InstallmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InstallmentEloquentRepository implements InstallmentRepositoryInterface {
    public function create(array $installment): void
    {
        Installment::create($installment);
    }

    public function findById(int $id): Installment {
        return Installment::findOrFail($id)->select(
            'users_id',
            'id_billing',
            'status',
            'debtor',
            'emission_date',
            'due_date',
            'overdue_payment',
            'amount',
            'paid_amount'
        )
        ->first();
    }

    public function allInstallments(): array
    {
        return Installment::with('user:id,name')
        ->select(
            'id',
            'users_id',
            'id_billing',
            'status',
            'debtor',
            'emission_date',
            'due_date',
            'overdue_payment',
            'amount',
            'paid_amount'
        )->get()
        ->toArray();
    }

    public function allInstallmentsWithFilters(array $filtros): array {
        $installments = Installment::with('user:id,name');
        foreach($filtros as $f) {
            $installments->where($f[0], $f[1], $f[2]);
        }
        return $installments->select(
            'id',
            'users_id',
            'id_billing',
            'status',
            'debtor',
            'emission_date',
            'due_date',
            'overdue_payment',
            'amount',
            'paid_amount'
        )->get()
        ->toArray();
    }
}
