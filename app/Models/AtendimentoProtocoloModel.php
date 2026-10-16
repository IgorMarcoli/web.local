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
     * Estatísticas consolidadas para os cards do dashboard do Protocolo
     */
    public function getEstatisticas(): array
    {
        $total = $this->countAllResults();

        $hoje = date('d/m/Y');
        $hojeIso = date('Y-m-d');

        $atendimentosHoje = (clone $this)->groupStart()
            ->where('data_atendimento', $hoje)
            ->orLike('created_at', $hojeIso, 'after')
            ->groupEnd()
            ->countAllResults();

        $pendentes = (clone $this)->where('status', 'Pendente')->countAllResults();
        $emAndamento = (clone $this)->where('status', 'Em Andamento')->countAllResults();
        $concluidos = (clone $this)->where('status', 'Concluído')->countAllResults();

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
     * Retorna dados formatados para os gráficos do Dashboard
     */
    public function getDadosGraficos(): array
    {
        // 1. Distribuição por Status
        $statusCounts = [
            'Pendente'     => 0,
            'Em Andamento' => 0,
            'Concluído'    => 0,
        ];

        $rowsStatus = (clone $this)->select('status, COUNT(*) as total')
            ->groupBy('status')
            ->findAll();

        foreach ($rowsStatus as $r) {
            $st = trim((string)($r['status'] ?? ''));
            if (isset($statusCounts[$st])) {
                $statusCounts[$st] = (int)$r['total'];
            }
        }

        // 2. Atendimentos por Setor de Destino (Top 6)
        $rowsSetor = (clone $this)->select("COALESCE(NULLIF(TRIM(setor_destino), ''), 'Geral / Recepção') as setor, COUNT(*) as total")
            ->groupBy("COALESCE(NULLIF(TRIM(setor_destino), ''), 'Geral / Recepção')")
            ->orderBy('total', 'DESC')
            ->limit(6)
            ->findAll();

        $setoresLabels = [];
        $setoresValores = [];
        foreach ($rowsSetor as $s) {
            $setoresLabels[] = $s['setor'];
            $setoresValores[] = (int)$s['total'];
        }

        // 3. Evolução dos últimos 7 dias
        $dias = [];
        $hoje = new \DateTime();
        for ($i = 6; $i >= 0; $i--) {
            $d = (clone $hoje)->modify("-{$i} days");
            $dataIso = $d->format('Y-m-d');
            $dataLabel = $d->format('d/m');
            $dias[$dataIso] = [
                'label' => $dataLabel,
                'total' => 0,
            ];
        }

        $seteDiasAtras = (clone $hoje)->modify('-6 days')->format('Y-m-d 00:00:00');
        $rowsRecentes = (clone $this)->select("DATE(created_at) as dia, COUNT(*) as total")
            ->where('created_at >=', $seteDiasAtras)
            ->groupBy("DATE(created_at)")
            ->findAll();

        foreach ($rowsRecentes as $rr) {
            $diaStr = $rr['dia'] ?? '';
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
