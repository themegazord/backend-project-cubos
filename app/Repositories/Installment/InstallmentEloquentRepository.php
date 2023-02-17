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
        return Installment::findOrFail($id);
    }

    public function allInstallments(): array
    {
        return Installment::with('user:id,name')
            ->with('debtor:id,name')
            ->get()
            ->toArray();
    }

    public function allInstallmentsWithFilters(array $filtros): array {
        $installments = Installment::with('user:id,name')
            ->with('debtor:id,name');
        foreach($filtros as $filtro) {
            $installments->where($filtro[0], $filtro[1], $filtro[2]);
        }
        return $installments
            ->get()
            ->toArray();
    }

    public function findByIdBilling(int $id_billing): bool
    {
        return (bool)Installment::where('id_billing', $id_billing)
                ->first();
    }

    public function update(array $payload, int $id): void
    {
       Installment::find($id)->update($payload);
    }

    public function checkIfInstallmentItPartiallyPaid(int $id): bool
    {
        return (bool)Installment::query()
            ->where('id', $id)
            ->where('status', 'Partially Paid')
            ->first();
    }

    public function checkIfInstallmentItOverdue(int $id): bool
    {
        return (bool)Installment::query()
            ->where('id', $id)
            ->where('overdue_payment', 1)
            ->first();
    }

    public function checkIfInstallmentExists(int $id): bool
    {
        return (bool)Installment::query()
            ->where('id', $id)
            ->first();
    }
    public function destroy(int $id): void
    {
        Installment::query()
            ->findOrFail($id)
            ->delete();
    }
}
