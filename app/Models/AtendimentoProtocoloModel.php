<?php

namespace App\Models;

use CodeIgniter\Model;

class AtendimentoProtocoloModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'atendimentos_protocolo';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'numero_protocolo',
        'nome_solicitante',
        'documento',
        'telefone',
        'email',
        'assunto',
        'setor_destino',
        'descricao',
        'atendido_por',
        'status',
        'data_atendimento',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Gera o próximo número de protocolo para o ano atual
     * Formato: PROT-ANO-SEQUENCIAL (Ex: PROT-2026-0001)
     */
    public function gerarNumeroProtocolo(): string
    {
        $ano = date('Y');
        $totalAno = $this->like('numero_protocolo', "PROT-{$ano}-", 'after')->countAllResults();
        $sequencial = str_pad((string)($totalAno + 1), 4, '0', STR_PAD_LEFT);

        return "PROT-{$ano}-{$sequencial}";
    }

    /**
     * Estatísticas consolidadas para os cards do dashboard do Protocolo.
     * Usa raw SQL no PostgreSQL para evitar LIKE em colunas timestamp.
     */
    public function getEstatisticas(): array
    {
        $db = \Config\Database::connect();

        $total       = (int)($db->query("SELECT COUNT(*) AS c FROM atendimentos_protocolo")->getRow()->c ?? 0);
        $pendentes   = (int)($db->query("SELECT COUNT(*) AS c FROM atendimentos_protocolo WHERE status = 'Pendente'")->getRow()->c ?? 0);
        $emAndamento = (int)($db->query("SELECT COUNT(*) AS c FROM atendimentos_protocolo WHERE status = 'Em Andamento'")->getRow()->c ?? 0);
        $concluidos  = (int)($db->query("SELECT COUNT(*) AS c FROM atendimentos_protocolo WHERE status = 'Concluído'")->getRow()->c ?? 0);

        $hojeIso = date('Y-m-d');
        $hoje    = date('d/m/Y');
        // Conta registros cujo campo data_atendimento (texto) é hoje OU cujo created_at (timestamp) é hoje
        $atendimentosHoje = (int)($db->query(
            "SELECT COUNT(*) AS c FROM atendimentos_protocolo
             WHERE data_atendimento = ? OR created_at::date = ?::date",
            [$hoje, $hojeIso]
        )->getRow()->c ?? 0);

        $taxaConclusao = ($total > 0) ? round(($concluidos / $total) * 100, 1) : 0;

        return [
            'total'          => $total,
            'hoje'           => $atendimentosHoje,
            'pendentes'      => $pendentes,
            'em_andamento'   => $emAndamento,
            'concluidos'     => $concluidos,
            'taxa_conclusao' => $taxaConclusao,
        ];
    }

    /**
     * Retorna dados formatados para os gráficos do Dashboard.
     * Usa raw SQL no PostgreSQL para compatibilidade com tipos timestamp e COALESCE/NULLIF.
     */
    public function getDadosGraficos(): array
    {
        $db = \Config\Database::connect();

        // 1. Distribuição por Status
        $statusCounts = [
            'Pendente'     => 0,
            'Em Andamento' => 0,
            'Concluído'    => 0,
        ];

        $rowsStatus = $db->query(
            "SELECT status, COUNT(*) AS total FROM atendimentos_protocolo GROUP BY status"
        )->getResultArray();

        foreach ($rowsStatus as $r) {
            $st = trim((string)($r['status'] ?? ''));
            if (isset($statusCounts[$st])) {
                $statusCounts[$st] = (int)$r['total'];
            }
        }

        // 2. Atendimentos por Setor de Destino (Top 6)
        $rowsSetor = $db->query(
            "SELECT COALESCE(NULLIF(TRIM(setor_destino), ''), 'Geral / Recepção') AS setor,
                    COUNT(*) AS total
             FROM atendimentos_protocolo
             GROUP BY 1
             ORDER BY 2 DESC
             LIMIT 6"
        )->getResultArray();

        $setoresLabels  = [];
        $setoresValores = [];
        foreach ($rowsSetor as $s) {
            $setoresLabels[]  = $s['setor'];
            $setoresValores[] = (int)$s['total'];
        }

        // 3. Evolução dos últimos 7 dias
        $dias = [];
        $hoje = new \DateTime();
        for ($i = 6; $i >= 0; $i--) {
            $d          = (clone $hoje)->modify("-{$i} days");
            $dataIso    = $d->format('Y-m-d');
            $dataLabel  = $d->format('d/m');
            $dias[$dataIso] = ['label' => $dataLabel, 'total' => 0];
        }

        $seteDiasAtras = (clone $hoje)->modify('-6 days')->format('Y-m-d');
        $rowsRecentes  = $db->query(
            "SELECT created_at::date AS dia, COUNT(*) AS total
             FROM atendimentos_protocolo
             WHERE created_at::date >= ?::date
             GROUP BY created_at::date",
            [$seteDiasAtras]
        )->getResultArray();

        foreach ($rowsRecentes as $rr) {
            // O driver pode retornar a data com hora (ex: "2026-10-16 00:00:00"), pega só os 10 chars
            $diaStr = substr((string)($rr['dia'] ?? ''), 0, 10);
            if (isset($dias[$diaStr])) {
                $dias[$diaStr]['total'] = (int)$rr['total'];
            }
        }

        return [
            'status'         => $statusCounts,
            'setoresLabels'  => $setoresLabels,
            'setoresValores' => $setoresValores,
            'diasLabels'     => array_values(array_column($dias, 'label')),
            'diasValores'    => array_values(array_column($dias, 'total')),
        ];
    }
}
