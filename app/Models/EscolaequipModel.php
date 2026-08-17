<?php

namespace App\Models;

use CodeIgniter\Model;

class EscolaequipModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'equipamentos_escolas';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nome', 'codigo_qr', 'categoria', 'conservacao', 'id_status', 'escola_id', 'marca', 'modelo', 'numero_serie', 'local', 'lote_id', 'observacao', 'created_at'
    ];

    public function getAll(): array
    {
        $builder = $this->db->table($this->table);
        $builder->select([
            'id', 'nome', 'codigo_qr', 'categoria', 'conservacao', 'id_status', 'escola_id', 'marca', 'modelo', 'numero_serie', 'local', 'lote_id', 'observacao', 'created_at'
        ]);

        return $builder->orderBy('id', 'DESC')->get()->getResultArray();
    }

    public function getStatistics(): array
    {
        // Total de equipamentos
        $total = $this->db->table($this->table)->countAllResults();

        // Equipamentos em funcionamento (status = "Funcional")
        $funcional = $this->db->table($this->table . ' e')
            ->join('status s', 's.id_status = e.id_status', 'left')
            ->where('s.nome', 'Funcional')
            ->countAllResults();

        // Equipamentos emprestados (via movimentacoes com tipo "Emprestimo")
        $emprestado = $this->db->table($this->table . ' e')
            ->join('movimentacoes m', 'm.id = e.id_emprestimo', 'inner')
            ->where('m.tipo', 'Emprestimo')
            ->countAllResults();

        // Equipamentos em manutenção (status = "Chamado aberto")
        $manutencao = $this->db->table($this->table . ' e')
            ->join('status s', 's.id_status = e.id_status', 'left')
            ->where('s.nome', 'Chamado aberto')
            ->countAllResults();

        return [
            'total' => $total,
            'funcional' => $funcional,
            'emprestado' => $emprestado,
            'manutencao' => $manutencao,
        ];
    }
}
