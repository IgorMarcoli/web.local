<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VisitasModel;
use App\Models\AgendaModel;
use App\Models\FieldsModel;
use App\Models\EquipamentosModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $visitas = new VisitasModel();
        $agenda = new AgendaModel();
        $field = new FieldsModel();

        $usuarioSetor = strtoupper(trim(session()->get('usuario_setor') ?? ''));
        $isSetec = ($usuarioSetor === 'SETEC');

        $mesAtual = (int) date('m');
        $anoAtual = (int) date('Y');

        // ===== GRÁFICO TÉCNICO — Todos os períodos =====
        // Em agendas, o técnico é gravado na coluna Atendidopor com o nome do técnico (vinda de tecnicos_fields).
        // A condição abaixo associa por nome, tratando acentos (Sérgio / Sergio) e variações/prefixos (Luiz / Luiz Carlos).
        $joinTecnico = '(
            TRANSLATE(LOWER(TRIM("agendas"."Atendidopor")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') 
            = TRANSLATE(LOWER(TRIM(t."nome")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
            OR TRANSLATE(LOWER(TRIM(t."nome")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') 
            LIKE TRANSLATE(LOWER(TRIM("agendas"."Atendidopor")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') || \'%\'
            OR TRANSLATE(LOWER(TRIM("agendas"."Atendidopor")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') 
            LIKE TRANSLATE(LOWER(TRIM(t."nome")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') || \'%\'
        )';

        $porTecnico = $agenda
            ->select('COALESCE(t."nome", TRIM("agendas"."Atendidopor")) as tecnico, COUNT(*) as total, SUM(CASE WHEN LOWER(TRIM("agendas"."status")) = \'concluido\' THEN 1 ELSE 0 END) as concluidos', false)
            ->join('tecnicos_fields t', $joinTecnico, 'left', false)
            ->where('TRIM(COALESCE("agendas"."Atendidopor", \'\')) !=', '')
            ->groupBy('COALESCE(t."nome", TRIM("agendas"."Atendidopor"))')
            ->orderBy('total', 'DESC')
            ->findAll();

        // ===== GRÁFICO TÉCNICO — Mês atual (ranking/donut) =====
        $porTecnicoMes = $agenda
            ->select('COALESCE(t."nome", TRIM("agendas"."Atendidopor")) as tecnico, COUNT(*) as total', false)
            ->join('tecnicos_fields t', $joinTecnico, 'left', false)
            ->where('TRIM(COALESCE("agendas"."Atendidopor", \'\')) !=', '')
            ->where('EXTRACT(MONTH FROM "agendas"."Data") =', $mesAtual)
            ->where('EXTRACT(YEAR FROM "agendas"."Data") =', $anoAtual)
            ->groupBy('COALESCE(t."nome", TRIM("agendas"."Atendidopor"))')
            ->orderBy('total', 'DESC')
            ->findAll();

        // CHAMADOS
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

        $totalVisitas = $agenda->countAll();

        // Visitas pendentes — da tabela agenda, não visitas
        $visitasPendentes = $agenda
            ->select('agendas.*, escolas."nome", escolas."escola_endereco"')
            ->join('escolas', 'LOWER(TRIM(escolas."nome")) = LOWER(TRIM(agendas."Nomelocal"))', 'left')
            ->where('agendas.status', 'pendente')
            ->findAll();

        $totalEquipamentos = 0;
        $totalVisitas = 0;
        $totalChamados = 0;
        $abertos = 0;
        $resolvidos = 0;
        $naoResolvidos = 0;
        $percentResolvido = 0;
        $statusChamados = [];
        $statusChamadosPresenciais = [];
        $porTecnico = [];
        $porTecnicoMes = [];
        $proximosAgendamentos = [];

        // Quem for do SETEC vê apenas o calendário e as visitas técnicas pendentes (não vê os dashboards)
        if (!$isSetec) {
            $equipamentosModel = new EquipamentosModel();
            $totalEquipamentos = $equipamentosModel->countAll();

            // ===== GRÁFICO TÉCNICO — Todos os períodos =====
            $joinTecnico = '(
                TRANSLATE(LOWER(TRIM("agendas"."Atendidopor")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
                = TRANSLATE(LOWER(TRIM(t."nome")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
                OR TRANSLATE(LOWER(TRIM(t."nome")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
                LIKE TRANSLATE(LOWER(TRIM("agendas"."Atendidopor")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') || \'%\'
                OR TRANSLATE(LOWER(TRIM("agendas"."Atendidopor")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
                LIKE TRANSLATE(LOWER(TRIM(t."nome")), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') || \'%\'
            )';

            $porTecnico = $agenda
                ->select('COALESCE(t."nome", TRIM("agendas"."Atendidopor")) as tecnico, COUNT(*) as total, SUM(CASE WHEN LOWER(TRIM("agendas"."status")) = \'concluido\' THEN 1 ELSE 0 END) as concluidos', false)
                ->join('tecnicos_fields t', $joinTecnico, 'left', false)
                ->where('TRIM(COALESCE("agendas"."Atendidopor", \'\')) !=', '')
                ->groupBy('COALESCE(t."nome", TRIM("agendas"."Atendidopor"))')
                ->orderBy('total', 'DESC')
                ->findAll();

            // ===== GRÁFICO TÉCNICO — Mês atual (ranking/donut) =====
            $porTecnicoMes = $agenda
                ->select('COALESCE(t."nome", TRIM("agendas"."Atendidopor")) as tecnico, COUNT(*) as total', false)
                ->join('tecnicos_fields t', $joinTecnico, 'left', false)
                ->where('TRIM(COALESCE("agendas"."Atendidopor", \'\')) !=', '')
                ->where('EXTRACT(MONTH FROM "agendas"."Data") =', $mesAtual)
                ->where('EXTRACT(YEAR FROM "agendas"."Data") =', $anoAtual)
                ->groupBy('COALESCE(t."nome", TRIM("agendas"."Atendidopor"))')
                ->orderBy('total', 'DESC')
                ->findAll();

            // CHAMADOS
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

            $totalVisitas = $agenda->countAll();

            // Próximos agendamentos
            $proximosAgendamentos = $agenda
                ->where('Data >=', date('Y-m-d'))
                ->orderBy('Data', 'ASC')
                ->findAll(5);
        }

        $data = [
            'isSetec' => $isSetec,
            'usuarioSetor' => $usuarioSetor,
            'totalEquipamentos' => $totalEquipamentos,
            'totalVisitas' => $totalVisitas,
            'totalChamados' => $totalChamados,
            'abertos' => $abertos,
            'naoResolvidos' => $naoResolvidos,
            'percentResolvido' => $percentResolvido,
            'statusChamados' => $statusChamados,
            'statusChamadosPresenciais' => $statusChamadosPresenciais,
            'visitasPendentes' => $visitasPendentes,
            'proximosAgendamentos' => $proximosAgendamentos,
            'porTecnico' => $porTecnico,        // ← gráfico geral
            'porTecnicoMes' => $porTecnicoMes,  // ← gráfico do mês (ranking/donut)
        ];
        echo View('templates/header');
        echo View('dashboard', $data);
        echo View('templates/footer');
    }

    /**
     * Altera o status de um agendamento (visita/chamado) via AJAX.
     * Recebe: AgendaId ou VisitaId (POST), status (POST)
     */
    public function alterarStatusVisita()
    {
        $agenda = new AgendaModel();
        $agendaId = $this->request->getPost('AgendaId') ?? $this->request->getPost('VisitaId');

        if ($agendaId) {
            $agenda->update(
                $agendaId,
                ['status' => $this->request->getPost('status')]
            );
        }

        return $this->response->setJSON(['ok' => true]);
    }
}
?>
