<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EscolasModelgab;
use App\Models\SupervisoresModelgab;
use App\Models\VisitasModelgab;
class Dashboardgab extends BaseController{
    public function index(){
        $visitasModel = new VisitasModelgab();
        $supModel     = new SupervisoresModelgab();
        $escModel     = new EscolasModelgab();

        // ===== CARDS =====
        $totalSupervisores = $supModel->countAll();
        $totalEscolas     = $escModel->countAll();
        $totalVisitas     = $visitasModel->countAll();

        $visitasMes = $visitasModel
            ->where('MONTH(dataVisita)', date('m'))
            ->where('YEAR(dataVisita)', date('Y'))
            ->countAllResults();

        // ===== GRÁFICO POR SUPERVISOR =====
  $porSupervisor = $visitasModel
    ->select('s.nome, COUNT(*) as total')
    ->join('supervisores s', 's.SupervisorId = visitas_gab.SupervisorId')
    ->groupBy('s.nome')
    ->get()
    ->getResultArray();

    // ===== GRÁFICO POR SETOR=====
$porSupervisorEscolas = $escModel
    ->select('
        supervisores.SupervisorId,
        supervisores.nome AS supervisor,
        escolas.EscolaId,
        escolas.Nome AS escola,
        COUNT(visitas_gab.VisitaId) AS total
    ')
    ->join('setores', 'setores.SetorId = escolas.SetorId')
    ->join('supervisores', 'supervisores.SupervisorId = setores.SupervisorId')
    ->join('visitas_gab', 'visitas_gab.EscolaId = escolas.EscolaId', 'left')
    ->groupBy('escolas.EscolaId')
    ->orderBy('supervisores.nome, escolas.Nome')
    ->findAll();



        // ===== GRÁFICO POR ESCOLA =====
        $porEscola = $visitasModel
            ->select('escolas.nome, COUNT(*) total')
            ->join('escolas','escolas.EscolaId = visitas_gab.EscolaId')
            ->groupBy('escolas.nome')
            ->findAll();

        $data = [
            'totalSupervisores' => $totalSupervisores,
            'totalEscolas'     => $totalEscolas,
            'totalVisitas'     => $totalVisitas,
            'visitasMes'       => $visitasMes,
            'porSupervisor'    => $porSupervisor,
            'porEscola'        => $porEscola,
            'porSupervisorEscolas'         => $porSupervisorEscolas
        ];

        echo view('templates/headergabinete');
        echo view('dashboardgab', $data);
        echo view('templates/footer');
    }

}