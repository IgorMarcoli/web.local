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
     * Gera o próximo número de protocolo para o ano/dia atual
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
     * Estatísticas consolidadas para os cards do painel de boas-vindas do Protocolo
     */
    public function getEstatisticas(): array
    {
        $total = $this->countAllResults();

        $builder = $this->builder();
        $hoje = date('d/m/Y');
        $hojeIso = date('Y-m-d');

        $atendimentosHoje = $this->where('data_atendimento', $hoje)
            ->orLike('created_at', $hojeIso, 'after')
            ->countAllResults();

        $pendentes = (clone $this)->where('status', 'Pendente')->countAllResults();
        $emAndamento = (clone $this)->where('status', 'Em Andamento')->countAllResults();
        $concluidos = (clone $this)->where('status', 'Concluído')->countAllResults();

        return [
            'total'        => $total,
            'hoje'         => $atendimentosHoje,
            'pendentes'    => $pendentes,
            'em_andamento' => $emAndamento,
            'concluidos'   => $concluidos,
        ];
    }
}

