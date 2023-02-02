<?php

namespace App\Repositories\Installment;

use App\Http\Resources\InstallmentCollection;
use App\Models\Installment;
use Illuminate\Pagination\LengthAwarePaginator;

interface InstallmentRepositoryInterface {
    public function create(array $installment): void;
    public function findById(int $id): Installment;
    public function allInstallments(): array;
    public function allInstallmentsWithFilters(array $filtros): array;
    public function findByIdBilling(int $id_billing): bool;
    public function update(array $payload, int $id): void;
}
