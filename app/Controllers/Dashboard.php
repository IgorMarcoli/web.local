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



          /*grafico tecnico 
        $porTecnico = $visitas
        ->select('t.nome, COUNT(*) as total')
        ->join('tecnicos_fields t', 't.tecnico_id = agendas.tecnico_id')
        ->groupBy('t.nome')
        ->get()
        ->getResultArray();
        */
        // CHAMADOS
        $totalChamados = $agenda->countAll();

        // separados por status
        $abertos = $agenda->where('status', 'pendente')->countAllResults();
        $resolvidos = $agenda->where('status', 'concluido')->countAllResults();
        $naoResolvidos = $agenda->where('status', 'NA')->countAllResults();

        $statusChamados = $agenda
        ->select('status, COUNT(*) as total')
        ->groupBy('status')
        ->findAll();

        // percentual resolvido
        $percentResolvido = $totalChamados > 0
         ? round(($resolvidos / $totalChamados) * 100)
         : 0;

        $totalVisitas = $agenda ->countAll();

        $visitasPendentes = $visitas
        ->select('visitas.*, escolas.Nome, escolas.Endereco')
        ->join('escolas', 'escolas.EscolaId = visitas.EscolaId')
        ->where('visitas.status', 'Pendente')
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
