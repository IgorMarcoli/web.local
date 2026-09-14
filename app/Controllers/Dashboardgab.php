<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EscolasModelgab;
use App\Models\SupervisoresModelgab;
use App\Models\VisitasModelgab;
use App\Models\OuvidoriaModel;
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

$porSupervisorEscolas = $escModel
    ->select('
        supervisores.SupervisorId,
        supervisores.nome AS supervisor,
        escolas.id,
        escolas.nome AS escola
    ')
    ->selectCount('visitas_gab.VisitaId', 'total')
    ->join('setores', 'setores.SetorId = escolas.SetorId')
    ->join('supervisores', 'supervisores.SupervisorId = setores.SupervisorId')
    ->join('visitas_gab', 'visitas_gab.EscolaId = escolas.id', 'left')
    ->groupBy('supervisores.SupervisorId, escolas.id')
    ->orderBy('supervisores.nome, escolas.nome')
    ->findAll();


        // ===== GRÁFICO POR ESCOLA =====
        $porEscola = $visitasModel
            ->select('escolas.nome, COUNT(*) total')
            ->join('escolas','escolas.id = visitas_gab.EscolaId')
            ->groupBy('escolas.nome')
            ->findAll();

        // ===== GRÁFICO OUVIDORIA: Tipo x Responsável =====
        $ouvidoriaModel = new OuvidoriaModel();
        $ouvidoriaTipoResp = $ouvidoriaModel->db
            ->table('ouvidoriagabs')
            ->select('tipo_manifestacao, responsavel_resposta, COUNT(*) as total')
            ->where('responsavel_resposta IS NOT NULL', null, false)
            ->where("responsavel_resposta != ''")
            ->groupBy('tipo_manifestacao, responsavel_resposta')
            ->orderBy('tipo_manifestacao, responsavel_resposta')
            ->get()
            ->getResultArray();

        $data = [
            'totalSupervisores' => $totalSupervisores,
            'totalEscolas'     => $totalEscolas,
            'totalVisitas'     => $totalVisitas,
            'visitasMes'       => $visitasMes,
            'porSupervisor'    => $porSupervisor,
            'porEscola'        => $porEscola,
            'porSupervisorEscolas'         => $porSupervisorEscolas,
            'ouvidoriaTipoResp' => $ouvidoriaTipoResp,
        ];

        echo view('templates/headergabinete');
        echo view('dashboardgab', $data);
        echo view('templates/footer');
    }

}