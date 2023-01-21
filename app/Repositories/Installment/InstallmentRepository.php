<?php

namespace App\Repositories\Installment;

use App\Models\Installment;
//TODO Documentar o código
class InstallmentRepository {
    /**
     * Essa função avalia o nome do usuário e retorna o a.k.a "apelido":
     *
     * Se o nome inserido tiver mais de 1 palavra, ou seja, nome completo,
     * retorna a primeira letra do nome e a primeira letra do último nome,
     * sempre maiusculo, por exemplo:
     *
     * Gustavo de Camargo Campos -> GC
     * Aline da Silva Santos -> AS
     *
     * Se o nome inserido for apenas o primeiro nome, vai retornar a primeira e
     * terceira letra do nome sempre em maiusculo, exemplo:
     *
     * Gustavo -> GS
     * Aline -> AI
     *
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
    /**
     * A função retorna um array com todos os filtros recebidos como parametro
     *
     * É feito a tratativa se tem mais de um grupo de filtro, caso, tenha, o
     * explode é usado para separar os tipos de filtros separados por ; e novamente
     * separando tabela, operador e valor com :
     */
    public static function handleFilters($filtros) {
        $filtrosTratados = [];
        $filtros = explode(';', $filtros);
        foreach($filtros as $filtro) {
            array_push($filtrosTratados, explode(':', $filtro));
        }
        return $filtrosTratados;
    }

    /**
     * Essa funçãoo determina se o titulo está vencido ou não
     */
    public static function determineIfInstallmentsAreOverduePayment($arrayInstallments) {
        return array_map(function ($installment) {
            if($installment['due_date'] < date('Y-m-d')) {
                $installment['overdue_payment'] = 1;
                Installment::find($installment['id'])->update($installment);
            }
            return $installment;
        }, $arrayInstallments);
    }

    /**
     * Faz o retorno do titulo quando o mesmo não contem filtros
     */
    public static function getTheInstallmentsWhenThereIsNoFilter() {
        $installments = Installment::with('user:id,name')
        ->select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
        ->get();
        return InstallmentRepository::generateAkaNameUser(InstallmentRepository::determineIfInstallmentsAreOverduePayment($installments->toArray()));
    }
    /**
     * Faz o retorno do titulo quando é utilizado filtros na consulta
     */
    public static function getTheInstallmentsWhenThereFilter($filtros) {
        $filtrosTratados = InstallmentRepository::handleFilters($filtros);
        $allInstallments = Installment::with('user:id,name');
        $allInstallments
        ->select('id', 'users_id', 'id_billing','status', 'debtor', 'emission_date', 'due_date', 'overdue_payment' ,'amount', 'paid_amount')
        ->getQuery();
        foreach($filtrosTratados as $f) {
           $allInstallments->where($f[0], $f[1], $f[2]);
        }
        return $allInstallments->get()->toArray();
    }
    /**
     * É a função que é usada para retornar ao Controller todo procedimento formatado.
     */
    public function push($filtros = null) {
        if(is_null($filtros)) {
            return InstallmentRepository::getTheInstallmentsWhenThereIsNoFilter();
        }
        return InstallmentRepository::getTheInstallmentsWhenThereFilter($filtros);
    }
}

?>
