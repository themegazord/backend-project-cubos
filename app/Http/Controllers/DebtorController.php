<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthenticationException;
use App\Exceptions\CPFException;
use App\Exceptions\DebtorException;
use App\Http\Requests\DebtorDestroyRequest;
use App\Http\Requests\DebtorStoreUpdateRequest;
use App\Services\Debtors\DebtorsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DebtorController extends Controller
{
    public function __construct(private DebtorsService $debtorsService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->debtorsService->findAll());
    }

    public function usersDebtors(int $id): JsonResponse
    {
        return response()->json($this->debtorsService->findUserDebtors($id));
    }
    public function store(DebtorStoreUpdateRequest $request): JsonResponse
    {
        try {
            $this->debtorsService->create($request->all());
            return response()->json(['msg' => 'Cliente cadastrado com sucesso'], Response::HTTP_CREATED);
        } catch (DebtorException|CPFException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->debtorsService->findById($id));
        } catch (ModelNotFoundException) {
            return response()->json(['error' => DebtorException::debtorNotExists()->getMessage()], DebtorException::debtorNotExists()->getCode());
        }
    }
    public function update(DebtorStoreUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->debtorsService->update($request->all(), $id);
            return response()->json(['msg' => 'Cliente atualizado com sucesso']);
        } catch (DebtorException|CPFException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (ModelNotFoundException) {
            return response()->json(['error' => DebtorException::debtorNotExists()->getMessage()], DebtorException::debtorNotExists()->getCode());
        }
    }
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->debtorsService->verifyPossibilityADeleteDebtor($id);
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (DebtorException $e){
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (ModelNotFoundException) {
            return response()->json(['error' => DebtorException::debtorNotExists()->getMessage()], DebtorException::debtorNotExists()->getCode());
        }
    }

    public function payers(int $id): JsonResponse
    {
        return response()->json($this->debtorsService->getAllPayers($id));
    }

    public function defaulters(int $id): JsonResponse
    {
        return response()->json($this->debtorsService->getAllDefaulters($id));
    }
}
