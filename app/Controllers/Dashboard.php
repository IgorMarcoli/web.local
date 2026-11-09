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
        $db = \Config\Database::connect();

        $usuarioSetor = strtoupper(trim(session()->get('usuario_setor') ?? ''));
        $isSetec = ($usuarioSetor === 'SETEC');

        $mesesNomesCompletos = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];
        $mesesNomesAbrev = [
            1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
            5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
        ];

        // Obter meses disponíveis com registros em agendas
        $mesesRows = $agenda
            ->select('EXTRACT(YEAR FROM "Data") as ano, EXTRACT(MONTH FROM "Data") as mes, COUNT(*) as total')
            ->where('"Data" IS NOT NULL')
            ->groupBy('ano, mes')
            ->orderBy('ano', 'DESC')
            ->orderBy('mes', 'DESC')
            ->findAll();

        $mesesDisponiveis = [];
        foreach ($mesesRows as $mr) {
            $mNum = (int) $mr['mes'];
            $yNum = (int) $mr['ano'];
            if ($mNum >= 1 && $mNum <= 12 && $yNum > 2000) {
                $mesesDisponiveis[] = [
                    'mes' => $mNum,
                    'ano' => $yNum,
                    'total' => (int) $mr['total'],
                    'label' => ($mesesNomesCompletos[$mNum] ?? 'Mês ' . $mNum) . ' / ' . $yNum,
                    'label_curto' => ($mesesNomesAbrev[$mNum] ?? 'M' . $mNum) . '/' . substr((string) $yNum, 2),
                ];
            }
        }

        // Definir mês e ano selecionados
        $periodoParam = $this->request->getGet('periodo') 
            ?? $this->request->getGet('mes_ano') 
            ?? ($_GET['periodo'] ?? ($_GET['mes_ano'] ?? null));

        if (!empty($periodoParam) && preg_match('/^(\d{1,2})[-_\/](\d{4})$/', trim($periodoParam), $matches)) {
            $mesAtual = (int) $matches[1];
            $anoAtual = (int) $matches[2];
        } elseif (!empty($periodoParam) && preg_match('/^(\d{4})[-_\/](\d{1,2})$/', trim($periodoParam), $matches)) {
            $anoAtual = (int) $matches[1];
            $mesAtual = (int) $matches[2];
        } elseif ($this->request->getGet('mes') !== null || isset($_GET['mes'])) {
            $mesAtual = (int) ($this->request->getGet('mes') ?? $_GET['mes']);
            $anoAtual = (int) ($this->request->getGet('ano') ?? ($_GET['ano'] ?? date('Y')));
        } else {
            $mesAtual = (int) date('m');
            $anoAtual = (int) date('Y');
        }

        $nomeMesAtual = $mesesNomesCompletos[$mesAtual] ?? ('Mês ' . $mesAtual);

        // Visitas pendentes — da tabela agenda
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
        $historicoMeses = ['labels' => [], 'datasets' => [], 'tabela' => []];

        // Quem for do SETEC vê apenas o calendário e as visitas técnicas pendentes
        if (!$isSetec) {
            $equipamentosModel = new EquipamentosModel();
            $totalEquipamentos = $equipamentosModel->countAll();

            // ===== APENAS OS 7 TÉCNICOS DA TABELA tecnicos_fields NO MÊS SELECIONADO =====
            // Unifica variações de nomes pelo primeiro nome do técnico (ex: Luiz Junior/Luiz Carlos, Sérgio/Sergio, etc.)
            $sqlTecnicosMes = '
                SELECT 
                    t.tecnico_id,
                    t.nome as tecnico,
                    COUNT(a."AgendaId") as total,
                    SUM(CASE WHEN LOWER(TRIM(a."status")) = \'concluido\' THEN 1 ELSE 0 END) as concluidos
                FROM "tecnicos_fields" t
                LEFT JOIN "agendas" a ON 
                    TRANSLATE(LOWER(SPLIT_PART(TRIM(a."Atendidopor"), \' \', 1)), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') 
                    = TRANSLATE(LOWER(SPLIT_PART(TRIM(t."nome"), \' \', 1)), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
                    AND EXTRACT(MONTH FROM a."Data") = ' . (int)$mesAtual . '
                    AND EXTRACT(YEAR FROM a."Data") = ' . (int)$anoAtual . '
                GROUP BY t.tecnico_id, t.nome
                ORDER BY total DESC, t.nome ASC
            ';
            $porTecnico = $db->query($sqlTecnicosMes)->getResultArray();

            // Para o gráfico Donut e ranking do mês, técnicos com atendimentos
            $porTecnicoMes = array_values(array_filter($porTecnico, function ($item) {
                return (int) ($item['total'] ?? 0) > 0;
            }));

            // ===== HISTÓRICO DE CADA MÊS (EVOLUÇÃO MÊS A MÊS DOS 7 TÉCNICOS) =====
            $sqlHistorico = '
                SELECT 
                    EXTRACT(YEAR FROM a."Data") as ano,
                    EXTRACT(MONTH FROM a."Data") as mes,
                    t.nome as tecnico,
                    COUNT(a."AgendaId") as total
                FROM "tecnicos_fields" t
                JOIN "agendas" a ON 
                    TRANSLATE(LOWER(SPLIT_PART(TRIM(a."Atendidopor"), \' \', 1)), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\') 
                    = TRANSLATE(LOWER(SPLIT_PART(TRIM(t."nome"), \' \', 1)), \'áéíóúâêîôûãõàèìòùäëïöü\', \'aeiouaeiouaoaeiouaeiou\')
                WHERE a."Data" >= \'2026-01-01\'
                GROUP BY ano, mes, t.tecnico_id, t.nome
                ORDER BY ano ASC, mes ASC, t.nome ASC
            ';
            $rowsHist = $db->query($sqlHistorico)->getResultArray();

            $monthsMap = [];
            $matrix = [];
            $tecnicosList = array_column($porTecnico, 'tecnico');
            sort($tecnicosList);

            foreach ($rowsHist as $rh) {
                $mNum = (int)$rh['mes'];
                $yNum = (int)$rh['ano'];
                $mKey = sprintf('%04d-%02d', $yNum, $mNum);
                $monthsMap[$mKey] = ($mesesNomesAbrev[$mNum] ?? $mNum) . '/' . substr((string)$yNum, 2);
                $matrix[$mKey][$rh['tecnico']] = (int)$rh['total'];
            }

            $labelsMeses = array_values($monthsMap);
            $datasetsHist = [];
            $coresTecnicos = [
                'Angelo'      => '#0284c7',
                'Laudo'       => '#10b981',
                'Luciano'     => '#f59e0b',
                'Luiz Carlos' => '#7c3aed',
                'Renan'       => '#ef4444',
                'Sergio'      => '#06b6d4',
                'Thiago'      => '#8b5cf6',
            ];

            $tabelaHistorico = [];
            foreach ($tecnicosList as $tec) {
                $dataVal = [];
                $rowTot = 0;
                foreach (array_keys($monthsMap) as $mKey) {
                    $val = $matrix[$mKey][$tec] ?? 0;
                    $dataVal[] = $val;
                    $rowTot += $val;
                }
                $datasetsHist[] = [
                    'label' => $tec,
                    'data' => $dataVal,
                    'backgroundColor' => $coresTecnicos[$tec] ?? '#94a3b8',
                ];
                $tabelaHistorico[$tec] = [
                    'valores' => $dataVal,
                    'total' => $rowTot,
                ];
            }

            $historicoMeses = [
                'labels' => $labelsMeses,
                'datasets' => $datasetsHist,
                'tabela' => $tabelaHistorico,
            ];

            // CHAMADOS NO MÊS SELECIONADO
            $totalChamados = $agenda
                ->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
                ->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
                ->countAllResults();

            // separados por status, filtrando pelo mês selecionado
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

            $totalVisitas = $agenda
                ->where('EXTRACT(MONTH FROM "Data") =', $mesAtual)
                ->where('EXTRACT(YEAR FROM "Data") =', $anoAtual)
                ->countAllResults();

            // Próximos agendamentos
            $proximosAgendamentos = $agenda
                ->where('Data >=', date('Y-m-d'))
                ->orderBy('Data', 'ASC')
                ->findAll(5);
        }

        $data = [
            'isSetec' => $isSetec,
            'usuarioSetor' => $usuarioSetor,
            'mesAtual' => $mesAtual,
            'anoAtual' => $anoAtual,
            'nomeMesAtual' => $nomeMesAtual,
            'mesNomeAtual' => $nomeMesAtual,
            'mesesDisponiveis' => $mesesDisponiveis,
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
            'porTecnico' => $porTecnico,          // ← exatamente os 7 técnicos no mês selecionado
            'porTecnicoMes' => $porTecnicoMes,    // ← técnicos com atendimentos no mês para ranking/donut
            'historicoMeses' => $historicoMeses,  // ← comparativo dos 7 técnicos em cada mês
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
        $idPostado = $this->request->getPost('AgendaId') ?? $this->request->getPost('VisitaId');
        $statusPostado = $this->request->getPost('status');

        if ((!is_string($idPostado) && !is_int($idPostado)) || !ctype_digit((string) $idPostado) || (int) $idPostado < 1 || !is_string($statusPostado)) {
            return $this->response->setStatusCode(422)->setJSON(['ok' => false]);
        }

        $status = mb_strtolower(trim($statusPostado), 'UTF-8');
        if (!in_array($status, ['pendente', 'concluido', 'concluida', 'concluído', 'em_atendimento', 'suspenso', 'suspensa'], true)) {
            return $this->response->setStatusCode(422)->setJSON(['ok' => false]);
        }

        $agendaId = (int) $idPostado;
        if (!$agenda->find($agendaId)) {
            return $this->response->setStatusCode(404)->setJSON(['ok' => false]);
        }
        if (!$agenda->update($agendaId, ['status' => $status])) {
            return $this->response->setStatusCode(500)->setJSON(['ok' => false]);
        }

        return $this->response->setJSON(['ok' => true]);
    }
}
