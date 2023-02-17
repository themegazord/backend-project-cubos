<?php

namespace App\Http\Controllers;

use App\Exceptions\InstallmentException;
use App\Http\Requests\InstallmentStoreUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Services\Installment\InstallmentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InstallmentController extends Controller
{
    public function __construct(private InstallmentService $installmentService) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->installmentService->allInstallments($request->query('filter') ?? null));
    }

    public function store(InstallmentStoreUpdateRequest $request): JsonResponse
    {
        try {
            $this->installmentService->
            create(
                $request->only(
                    'users_id',
                    'id_billing',
                    'debtor_id',
                    'emission_date',
                    'due_date',
                    'overdue_payment',
                    'amount',
                    'paid_amount'
                )
            );
            return response()->json(['msg' => 'Installment has been created'], Response::HTTP_CREATED);
        } catch (InstallmentException $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->installmentService->findByid($id));
    }

    public function update(InstallmentStoreUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return response()->json($this->installmentService->determineStatusInstallment($request->all(), $id));
        } catch (InstallmentException $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * @throws InstallmentException
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->installmentService->verifyPossibilityToDeleteAInstallment($id);
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (InstallmentException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}


