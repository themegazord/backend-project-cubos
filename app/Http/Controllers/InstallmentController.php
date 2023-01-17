<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $installments = Installment::with([
            'user' => function($query) {
                $query->select('id', 'name');
            }
        ])->get();
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
        $response = $installment::select('id', 'users_id', 'id_billing', 'emission_date', 'due_date', 'amount', 'paid_amount')
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
    public function update(Request $request, Installment $installment)
    {
        $inst = $request->validate($installment->rules(), $installment->feedback());
        $installment->update($inst);
        return response()->json($inst);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        //
    }
}
