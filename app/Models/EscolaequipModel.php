<?php

namespace App\Models;

use CodeIgniter\Model;

class EscolaequipModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'equipamentos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nome', 'codigo_qr', 'categoria', 'status', 'escola_id', 'marca', 'modelo', 'numero_serie', 'local', 'lote_id', 'observacao', 'created_at'
    ];

public function getAll(?string $escolaId = null, ?string $status = null): array
{
    $builder = $this->db->table($this->table . ' equipamentos');
    $builder->select([
        'equipamentos.id',
        'equipamentos.nome',
        'equipamentos.codigo_qr',
        'equipamentos.categoria',
        'equipamentos.status',
        'equipamentos.escola_id',
        'escolas.nome as escola_nome',
        'equipamentos.marca',
        'equipamentos.modelo',
        'equipamentos.numero_serie',
        'equipamentos.local',
        'equipamentos.lote_id',
        'equipamentos.observacao',
        'equipamentos.created_at',
    ]);
    $builder->join('escolas', 'escolas.id = equipamentos.escola_id');

    if ($escolaId !== null) {
        $builder->where('equipamentos.escola_id', $escolaId);
    }

    if ($status !== null) {
        $builder->where('equipamentos.status', $status);
    }

    return $builder->orderBy('equipamentos.id', 'DESC')->get()->getResultArray();
}

    public function getStatistics(): array
    {
        // Total de equipamentos
        $total = $this->db->table($this->table)->countAllResults();

        // Equipamentos em funcionamento (status = "disponivel")
        $funcional = $this->db->table($this->table)
            ->where('status', 'disponivel')
            ->countAllResults();

        // Equipamentos emprestados (status = "em_uso")
        $emprestado = $this->db->table($this->table)
            ->where('status', 'em_uso')
            ->countAllResults();

        // Equipamentos em manutenção (status = "chamado_aberto")
        $manutencao = $this->db->table($this->table)
            ->where('status', 'chamado_aberto')
            ->countAllResults();

        return [
            'total' => $total,
            'funcional' => $funcional,
            'emprestado' => $emprestado,
            'manutencao' => $manutencao,
        ];
    }
}
