<?php

namespace App\Repositories\Debtor;

use App\Models\User;

interface DebtorRepositoryInterface
{
    public function findAll(): \Illuminate\Database\Eloquent\Collection;

    public function findUserDebtors(int $id): \Illuminate\Database\Eloquent\Collection;

    public function create(array $payload): void;

    public function update(array $payload, int $id): void;

    public function findByEmail(string $email): array;

    public function findByCPF(string $cpf): array;

    public function findById(int $id): array;

    public function debtorContainsADueInstallment(int $id): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null;

    public function debtorContainsPartiallyPaidInstallment(int $id): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null;

    public function debtorContainsInstallments(int $id): bool;

    public function destroy(int $id): void;

    public function getAllPayers(int $id): array|\Illuminate\Database\Eloquent\Collection;
    public function getAllDefaulters(int $id): array|\Illuminate\Database\Eloquent\Collection;
}
