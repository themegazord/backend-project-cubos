<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Installment\InstallmentRepository;
use Laravel\Sanctum\PersonalAccessToken;
class InstallmentController extends Controller
{

    protected $installmentRepository;

    public function __construct(InstallmentRepository $installmentRepository)
    {
        $this->installmentRepository = $installmentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->query('filter');
        $installments = $this->installmentRepository->push($filters ?? null);

        return response()->json($installments);
    }

    /**
     * Display all installments based one only user
     */
    public function indexAllInstallmentsToUser($id) {
        $user = User::find($id);
        $installments = $user->installments()
        ->select('id', 'id_billing', 'status', 'debtor', 'emission_date', 'due_date', 'overdue_payment', 'amount', 'paid_amount')
        ->get()
        ->toArray();
        return response()->json($installments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $installment = new Installment();
        $payload = $request->validate($installment->rules(), $installment->feedback());
        $installment->create($payload);
        return response()->json(['msg' => 'Installment has been created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $installment = new Installment();
        if(is_null($installment->find($id))) return response()->json(['error' => 'Installment not exists'], 404);
        $response = $installment::select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
            ->with([
            'user' => function($query) {
                $query->select(['id', 'name']);
            }
        ])->find($id)->toArray();
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $installment = new Installment();
        $installment = $installment->find($id);
        if(is_null($installment)) return response()->json(['error' => 'Installment not exists'], 404);
        $inst = $request->validate($installment->rules(), $installment->feedback());
        if(doubleval($inst['paid_amount']) > 0  && doubleval($inst['paid_amount']) < $installment->amount) {
            $inst['status'] = 'P';
            $installment->update($inst);
            return response()->json($inst);
        } else if (doubleval($inst['paid_amount']) === $installment->amount) {
            $inst['status'] = 'B';
            $installment->update($inst);
            return response()->json($inst);
        } else {
            $inst['status'] = 'A';
            $installment->update($inst);
            return response()->json($inst);
        }
    }
}


