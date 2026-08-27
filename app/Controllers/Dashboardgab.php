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
            $mesAtual = (int) date('m');
        $anoAtual = (int) date('Y');
        // ===== CARDS =====
        $totalSupervisores = $supModel->countAll();
        $totalEscolas     = $escModel->countAll();
        $totalVisitas     = $visitasModel->countAll();

        $visitasMes = $visitasModel
->where('EXTRACT(MONTH FROM "DataVisita") =', $mesAtual)
->where('EXTRACT(YEAR FROM "DataVisita") =', $anoAtual)                               
            ->countAllResults();

        // ===== GRÁFICO POR SUPERVISOR =====
  $porSupervisor = $visitasModel
    ->select('s.nome, COUNT(*) as total')
    ->join('supervisores s', 's.SupervisorId = visitas_gab.SupervisorId')
    ->groupBy('s.nome')
    ->get()
    ->getResultArray();
$db = \Config\Database::connect();
    // ===== GRÁFICO POR SETOR=====
$porSupervisorEscolas = $db->query("
    SELECT 
        supervisores.SupervisorId,
        supervisores.nome AS supervisor,
        escolas.id,
        escolas.nome AS escola,
        COUNT(visitas_gab.VisitaId) AS total
    FROM escolas
    JOIN setores ON setores.SetorId = escolas.SetorId
    JOIN supervisores ON supervisores.SupervisorId = setores.SupervisorId
    LEFT JOIN visitas_gab ON visitas_gab.EscolaId = escolas.id
    GROUP BY escolas.id
    ORDER BY supervisores.nome, escolas.nome
")->getResultArray();



        // ===== GRÁFICO POR ESCOLA =====
        $porEscola = $visitasModel
            ->select('escolas.nome, COUNT(*) total')
            ->join('escolas','escolas.id = visitas_gab.EscolaId')
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