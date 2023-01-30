<?php

namespace App\Repositories\Installment;

use App\Http\Resources\InstallmentCollection;
use App\Models\Installment;
use Illuminate\Pagination\LengthAwarePaginator;

interface InstallmentRepositoryInterface {
    public function create(array $installment): void;
    public function findById(int $id): Installment;

    public function paginate(): array;
    public function paginateWithFilters(array $filtros): array;
}
