<?php

namespace App\Repositories\Installment;

use App\Models\Installment;

class InstallmentRepository {
    protected $installment;

    public function __construct(Installment $installment)
    {
        $this->installment = $installment;
    }
    /**
     * Function is deprecated
     */
    public function generateAkaNameUser($arrayInstallments) {
        $result = array_map(function($i) {
            $nameInArray = explode(' ', trim($i['user']['name']));
            if(count($nameInArray) > 1) {
                $i['user']['aka'] = strtoupper($nameInArray[0][0]) . strtoupper($nameInArray[count($nameInArray)-1][0]);
            } else {
                return $i['user']['aka'] = strtoupper($nameInArray[0][0]) . strtoupper($nameInArray[0][2]);
            }
            return $i;
        }, $arrayInstallments);
        return $result;
    }
    public function trataFiltros($filtros) {
        $filtrosTratados = [];
        $filtros = explode(';', $filtros);
        foreach($filtros as $filtro) {
            array_push($filtrosTratados, explode(':', $filtro));
        }
        return $filtrosTratados;
    }
    public function push($filtros = null) {
        if(is_null($filtros)) {
            $installments = $this->installment::with('user:id,name')
            ->select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
            ->get();
            $array_installments = $installments->toArray();
            $result = array_map(function ($installment) {
                if($installment['due_date'] < date('Y-m-d')) {
                    $installment['overdue_payment'] = 1;
                    $this->installment->find($installment['id'])->update($installment);
                }
                return $installment;
            }, $array_installments);
            return $this->generateAkaNameUser($result);
        }
        $filtrosTratados = $this->trataFiltros($filtros);
        $allInstallments = $this->installment->with('user:id,name');
        $allInstallments
        ->select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
        ->getQuery();
        foreach($filtrosTratados as $f) {
           $allInstallments->where($f[0], $f[1], $f[2]);
        }
        return $allInstallments->get()->toArray();

    }

}

?>
