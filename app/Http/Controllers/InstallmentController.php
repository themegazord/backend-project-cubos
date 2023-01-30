<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallmentStoreUpdateRequest;
use Illuminate\Http\Request;
use App\Services\Installment\InstallmentService;
use Illuminate\Http\JsonResponse;
class InstallmentController extends Controller
{
    public function __construct(private InstallmentService $installmentService) {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->installmentService->paginate($request->query('filter') ?? null));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InstallmentStoreUpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InstallmentStoreUpdateRequest $request): JsonResponse
    {
        $this->installmentService->create($request->only(
            'users_id',
            'id_billing',
            'debtor',
            'emission_date',
            'due_date',
            'overdue_payment',
            'amount',
            'paid_amount'
        ));

        return response()->json(['msg' => 'Installment has been created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id;
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->installmentService->findByid($id), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\InstallmentStoreUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InstallmentStoreUpdateRequest $request, int $id): JsonResponse
    {
        return response()->json($this->installmentService->determineStatusInstallment($request->all(), $id));
    }
}


