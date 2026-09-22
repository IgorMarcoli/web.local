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

        // ===== GRÁFICO TÉCNICO — Todos os períodos =====
        // AJUSTE os nomes das colunas se forem diferentes:
        // - Tabela: tecnicos_fields (ou outro nome)
        // - Coluna de ID: id (ou TecnicoId, tecnico_id, etc.)
        // - Coluna de nome: nome (ou Nome, tecnico_nome, etc.)
        // - FK em agendas: tecnico_id (ou TecnicoId, id_tecnico, etc.)
        $porTecnico = $agenda
            ->select('t."nome" as tecnico, COUNT(*) as total, SUM(CASE WHEN "agendas"."status" = \'concluido\' THEN 1 ELSE 0 END) as concluidos')
            ->join('tecnicos_fields t', 't."id" = "agendas"."tecnico_id"', 'left')
            ->groupBy('t."nome"')
            ->orderBy('total', 'DESC')
            ->findAll();

        // ===== GRÁFICO TÉCNICO — Mês atual (ranking/donut) =====
        $porTecnicoMes = $agenda
            ->select('t."nome" as tecnico, COUNT(*) as total')
            ->join('tecnicos_fields t', 't."id" = "agendas"."tecnico_id"', 'left')
            ->where('EXTRACT(MONTH FROM "agendas"."Data") =', $mesAtual)
            ->where('EXTRACT(YEAR FROM "agendas"."Data") =', $anoAtual)
            ->groupBy('t."nome"')
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

        $data = [
            'totalVisitas' => $totalVisitas,
            'totalChamados' => $totalChamados,
            'abertos' => $abertos,
            'naoResolvidos' => $naoResolvidos,
            'percentResolvido' => $percentResolvido,
            'statusChamados' => $statusChamados,
            'visitasPendentes' => $visitasPendentes,
            'porTecnico' => $porTecnico,        // ← gráfico geral
            'porTecnicoMes' => $porTecnicoMes,  // ← gráfico do mês (ranking/donut)
        ];
        echo View('templates/header');
        echo View('dashboard', $data);
        echo View('templates/footer');
    }

    /**
     * Altera o status de um agendamento (visita/chamado) via AJAX.
     * Recebe: AgendaId (POST), status (POST)
     */
    public function alterarStatusVisita()
    {
        $agenda = new AgendaModel();

        $agenda->update(
            $this->request->getPost('AgendaId'),
            ['status' => $this->request->getPost('status')]
        );

        return $this->response->setJSON(['ok' => true]);
    }
}
?>