<?php

namespace App\Repositories\Debtor;

use App\Models\Debtor;
use Illuminate\Support\Facades\DB;

class DebtorEloquentRepository implements DebtorRepositoryInterface
{
    public function findAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Debtor::with('user:id,name')->get();
    }

    public function findUserDebtors(int $id): \Illuminate\Database\Eloquent\Collection
    {
        return Debtor::query()
            ->distinct()
            ->select(DB::raw(
                '(
                    case
                        when installments.overdue_payment = 0 then "Payer"
                        when installments.overdue_payment = 1 then "Defaulter"
                        else "New"
                    end
                ) as status'
                ), 'debtors.*')
            ->leftJoin('installments', function($join) {
                $join->on('installments.debtor_id', '=', 'debtors.id');
            })
            ->where('debtors.user_id', $id)
            ->get();
    }

    public function create(array $payload): void
    {
        Debtor::query()
            ->create($payload);
    }

    public function update(array $payload, int $id): void
    {
        Debtor::query()
            ->findOrFail($id)
            ->update($payload);
    }

    public function findByEmail(string $email): array
    {
        return Debtor::query()
            ->where('email', $email)
            ->get()
            ->toArray();
    }

    public function findByCPF(string $cpf): array
    {
        return Debtor::query()
            ->where('cpf', $cpf)
            ->get()
            ->toArray();
    }

    public function findById(int $id): array
    {
        return Debtor::query()
            ->findOrFail($id)
            ->toArray();
    }

    public function debtorContainsADueInstallment(int $id): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
    {
        return Debtor::query()
            ->select('installments.*', 'debtors.id')
            ->join('installments', function ($join) {
                $join->on('debtors.id', '=', 'installments.debtor_id');
            })
            ->where('installments.debtor_id', $id)
            ->where('installments.overdue_payment', 1)
            ->first();
    }

    public function debtorContainsPartiallyPaidInstallment(int $id): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
    {
        return Debtor::query()
            ->select('installments.*', 'debtors.id')
            ->join('installments', function($join) {
                $join->on('debtors.id', '=', 'installments.debtor_id');
            })
            ->where('installments.debtor_id', $id)
            ->where('installments.status', 'Partially paid')
            ->first();
    }

    public function debtorContainsInstallments(int $id): bool
    {
        return (bool)Debtor::query()
            ->select('installments.*', 'debtors.id')
            ->join('installments', function ($join) {
                $join->on('debtors.id', '=', 'installments.debtor_id');
            })
            ->where('installments.debtor_id', $id)
            ->first();
    }

    public function destroy(int $id): void
    {
        Debtor::query()
            ->findOrFail($id)
            ->delete();
    }

    public function getAllDefaulters(int $id): array|\Illuminate\Database\Eloquent\Collection
    {
        return Debtor::query()
            ->distinct()
            ->select('debtors.*')
            ->join('installments', function($join) {
                $join->on('installments.debtor_id', '=', 'debtors.id');
            })
            ->where('debtors.user_id', $id)
            ->where('installments.overdue_payment', 1)
            ->get();
    }

    public function getAllPayers(int $id): array|\Illuminate\Database\Eloquent\Collection
    {
        return Debtor::query()
            ->distinct()
            ->select('debtors.*')
            ->join('installments', function($join) {
                $join->on('installments.debtor_id', '=', 'debtors.id');
            })
            ->where('debtors.user_id', $id)
            ->where('installments.overdue_payment', 0)
            ->get();
    }
}
