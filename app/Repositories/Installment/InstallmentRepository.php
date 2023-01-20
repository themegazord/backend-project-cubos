<?php

namespace App\Repositories\Installment;

use App\Models\Installment;
//TODO Documentar o código
class InstallmentRepository {
    /**
     * Essa função avalia o nome do usuário e retorna:
     * Se a
     */
    public static function generateAkaNameUser($arrayInstallments) {
        $result = array_map(function($i) {
            $nameInArray = explode(' ', trim($i['user']['name']));
            if(count($nameInArray) > 1) {
                $i['user']['aka'] = strtoupper($nameInArray[0][0]) . strtoupper($nameInArray[count($nameInArray)-1][0]);
            }
            return $i;
        }, $arrayInstallments);
        return $result;
    }
    public static function trataFiltros($filtros) {
        $filtrosTratados = [];
        $filtros = explode(';', $filtros);
        foreach($filtros as $filtro) {
            array_push($filtrosTratados, explode(':', $filtro));
        }
        return $filtrosTratados;
    }
    public static function determineIfInstallmentsAreOverduePayment($arrayInstallments) {
        return array_map(function ($installment) {
            if($installment['due_date'] < date('Y-m-d')) {
                $installment['overdue_payment'] = 1;
                Installment::find($installment['id'])->update($installment);
            }
            return $installment;
        }, $arrayInstallments);
    }
    public static function getTheInstallmentsWhenThereIsNoFilter() {
        $installments = Installment::with('user:id,name')
        ->select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
        ->get();
        return InstallmentRepository::generateAkaNameUser(InstallmentRepository::determineIfInstallmentsAreOverduePayment($installments->toArray()));
    }
    public static function getTheInstallmentsWhenThereFilter($filtros) {
        $filtrosTratados = InstallmentRepository::trataFiltros($filtros);
        $allInstallments = Installment::with('user:id,name');
        $allInstallments
        ->select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
        ->getQuery();
        foreach($filtrosTratados as $f) {
           $allInstallments->where($f[0], $f[1], $f[2]);
        }
        return $allInstallments->get()->toArray();
    }
    public function push($filtros = null) {
        if(is_null($filtros)) {
            return InstallmentRepository::getTheInstallmentsWhenThereIsNoFilter();
        }
        return InstallmentRepository::getTheInstallmentsWhenThereFilter($filtros);
    }
}

?>
