<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\VisitasModel;
use App\Models\EscolasModel;
use App\Models\AgendaModel;

class Dashboard extends BaseController
{
     public function index()
    {
        $chamados = new ProdutoModel();
        $visitas = new VisitasModel();
        $agenda = new AgendaModel();



        // CHAMADOS
        $totalChamados = $chamados->countAll();

        // separados por status
        $abertos = $chamados->where('status', 'Aberto')->countAllResults();
        $resolvidos = $chamados->where('status', 'Resolvido')->countAllResults();
        $naoResolvidos = $chamados->where('status', 'Nao resolvido')->countAllResults();

        $statusChamados = $chamados
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
