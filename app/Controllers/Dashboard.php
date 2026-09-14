<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VisitasModel;
use App\Models\AgendaModel;
use App\Models\FieldsModel;

class Dashboard extends BaseController
{
     public function index()
    {
        $visitas = new VisitasModel();
        $agenda = new AgendaModel();
        $field = new FieldsModel();

        $mesAtual = (int) date('m');
        $anoAtual = (int) date('Y');

          /*grafico tecnico 
        $porTecnico = $visitas
        ->select('t.nome, COUNT(*) as total')
        ->join('tecnicos_fields t', 't.tecnico_id = agendas.tecnico_id')
        ->groupBy('t.nome')
        ->get()
        ->getResultArray();
        */
        // CHAMADOS
         $totalChamados = $agenda
->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
        ->countAllResults();
        // separados por status
        $totalChamados = $agenda
->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
        ->countAllResults();

    // separados por status, também filtrando pelo mês
    $abertos = $agenda
        ->where('status', 'pendente')
->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
        ->countAllResults();

    $resolvidos = $agenda
        ->where('status', 'concluido')
->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
        ->countAllResults();

    $naoResolvidos = $agenda
        ->where('status', 'NA')
->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
        ->countAllResults();

    $statusChamados = $agenda
        ->select('status, COUNT(*) as total')
->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
        ->groupBy('status')
        ->findAll();


        // percentual resolvido
        $percentResolvido = $totalChamados > 0
         ? round(($resolvidos / $totalChamados) * 100)
         : 0;

        $totalVisitas = $agenda ->countAll();

        $visitasPendentes = $visitas
        ->select('visitas.*, escolas."nome", escolas."escola_endereco"')
        ->join('escolas', 'escolas."id" = visitas."EscolaId"')
        ->where('visitas.Status', 'Pendente')
        ->findAll();

        $data = [
                'totalVisitas' => $totalVisitas,
                'totalChamados' => $totalChamados,
                'abertos' => $abertos,
                'naoResolvidos' => $naoResolvidos,
                'percentResolvido' => $percentResolvido,
                'statusChamados' => $statusChamados,
                'visitasPendentes' => $visitasPendentes
        ];
        echo View('templates/header'); 
        echo View('dashboard', $data); 
        echo View('templates/footer');
       
    }
}
?>
