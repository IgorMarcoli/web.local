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
        $statusCounts = $this->db->query(
            'SELECT LOWER(TRIM(status)) AS status_normalizado, COUNT(*) AS quantidade
             FROM equipamentos
             GROUP BY LOWER(TRIM(status))'
        )->getResultArray();

        $aliases = [
            'ativos' => [
                'ativo', 'ativa', 'ativos', 'ativas', 'disponivel', 'disponiveis',
                'em_uso', 'funcionando', 'em_funcionamento', 'operacional', 'operacionais',
            ],
            'inserviveis' => [
                'inservivel', 'inserviveis', 'baixado', 'baixada', 'sucata',
                'sem_conserto', 'irrecuperavel', 'irrecuperaveis', 'inutilizavel', 'inutilizaveis',
            ],
            'manutencao' => [
                'manutencao', 'em_manutencao', 'chamado_aberto', 'chamado_em_aberto',
                'em_reparo', 'reparo', 'reparando',
            ],
        ];

        $stats = ['ativos' => 0, 'inserviveis' => 0, 'manutencao' => 0, 'outros' => 0, 'total' => 0];
        $categoryByStatus = [];
        foreach ($aliases as $category => $values) {
            foreach ($values as $value) {
                $categoryByStatus[$value] = $category;
            }
        }

        foreach ($statusCounts as $row) {
            $status = mb_strtolower(trim((string) ($row['status_normalizado'] ?? '')), 'UTF-8');
            $status = strtr($status, [
                'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a',
                'é' => 'e', 'ê' => 'e', 'í' => 'i',
                'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ú' => 'u', 'ç' => 'c',
            ]);
            $status = trim((string) preg_replace('/[^a-z0-9]+/', '_', $status), '_');
            $quantidade = (int) ($row['quantidade'] ?? 0);
            $categoria = $categoryByStatus[$status] ?? 'outros';

            $stats[$categoria] += $quantidade;
            $stats['total'] += $quantidade;
        }

        return $stats;
    }
}
