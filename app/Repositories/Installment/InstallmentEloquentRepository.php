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
        return Installment::findOrFail($id)
            ->first();
    }

    public function allInstallments(): array
    {
        return Installment::with('user:id,name')
            ->get()
            ->toArray();
    }

    public function allInstallmentsWithFilters(array $filtros): array {
        $installments = Installment::with('user:id,name');
        foreach($filtros as $filtro) {
            $installments->where($filtro[0], $filtro[1], $filtro[2]);
        }
        return $installments
            ->get()
            ->toArray();
    }
}
