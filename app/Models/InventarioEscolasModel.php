<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioEscolasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'inventario_escolas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'escola_cie',
        'escola_nome',
        'aba',
        'ure_diretoria',
        'ambiente',
        'categoria',
        'fabricante',
        'modelo',
        'hostname',
        'numero_serie',
        'id_controle_ue',
        'status_equipamento',
        'avaliacao_tecnica',
        'descricao',
        'data_abertura_chamado',
        'numero_chamado',
        'data_visita',
        'tecnico_responsavel',
        'status_visita',
        'observacoes',
        'created_at',
    ];

    /** Expressões SQL comuns para classificar cada equipamento em uma única situação. */
    private function statusMetricExpressions(): array
    {
        $status = "COALESCE(LOWER(TRIM(status_equipamento)), '')";
        $disponivel = "{$status} IN ('disponível', 'disponivel')";
        $inservivel = "{$status} IN ('inservível', 'inservivel')";
        $manutencao = "({$status} LIKE '%manuten%' OR {$status} LIKE '%chamado%' OR {$status} LIKE '%danificad%')";
        $semStatus = "TRIM(COALESCE(status_equipamento, '')) = ''";

        return [
            "SUM(CASE WHEN {$disponivel} THEN 1 ELSE 0 END) as total_disponivel",
            "SUM(CASE WHEN {$inservivel} THEN 1 ELSE 0 END) as total_inservivel",
            "SUM(CASE WHEN NOT ({$disponivel}) AND NOT ({$inservivel}) AND {$manutencao} THEN 1 ELSE 0 END) as total_manutencao",
            "SUM(CASE WHEN NOT ({$disponivel}) AND NOT ({$inservivel}) AND NOT ({$manutencao}) AND NOT ({$semStatus}) THEN 1 ELSE 0 END) as total_outros",
            "SUM(CASE WHEN {$semStatus} THEN 1 ELSE 0 END) as total_sem_status",
        ];
    }

    /**
     * Retorna a lista de todas as escolas com totais consolidados de equipamentos.
     */
    public function getListaEscolas(?string $busca = null): array
    {
        $builder = $this->db->table($this->table);
        $builder->select(array_merge([
            'TRIM(escola_cie) as escola_cie',
            'TRIM(escola_nome) as escola_nome',
            'MAX(ure_diretoria) as ure_diretoria',
            'COUNT(*) as total_equipamentos',
        ], $this->statusMetricExpressions()), false);

        if (!empty($busca)) {
            $b = strtolower(trim($busca));
            $builder->groupStart()
                ->like('LOWER(escola_nome)', $b)
                ->orLike('escola_cie', trim($busca))
                ->groupEnd();
        }

        $builder->groupBy(['TRIM(escola_cie)', 'TRIM(escola_nome)']);
        $builder->orderBy('total_equipamentos', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Retorna métricas globais de todas as escolas no inventário.
     */
    public function getEstatisticasGerais(): array
    {
        $builder = $this->db->table($this->table);
        $builder->select(array_merge([
            'COUNT(DISTINCT TRIM(escola_cie)) as total_escolas',
            'COUNT(*) as total_equipamentos',
        ], $this->statusMetricExpressions()), false);

        return $builder->get()->getRowArray() ?? [
            'total_escolas'      => 0,
            'total_equipamentos' => 0,
            'total_disponivel'   => 0,
            'total_inservivel'   => 0,
            'total_manutencao'   => 0,
            'total_outros'       => 0,
            'total_sem_status'   => 0,
        ];
    }

    /** Consolida por tipo de equipamento e sua condição atual para análise de prioridade. */
    public function getResumoPorCategoria(): array
    {
        $builder = $this->db->table($this->table);
        $categoria = "COALESCE(NULLIF(TRIM(categoria), ''), 'Sem categoria')";
        $builder->select(array_merge([
            "{$categoria} as categoria",
            'COUNT(*) as total_equipamentos',
        ], $this->statusMetricExpressions()), false);
        $builder->groupBy($categoria);
        $builder->orderBy('total_equipamentos', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Retorna informações cadastrais e resumo de indicadores de uma escola específica.
     */
    public function getDadosEscola(string $cie): ?array
    {
        $builder = $this->db->table($this->table);
        $builder->select(array_merge([
            'TRIM(escola_cie) as escola_cie',
            'TRIM(escola_nome) as escola_nome',
            'MAX(ure_diretoria) as ure_diretoria',
            'COUNT(*) as total_equipamentos',
        ], $this->statusMetricExpressions()), false);

        $builder->where('TRIM(escola_cie)', trim($cie));
        $builder->groupBy(['TRIM(escola_cie)', 'TRIM(escola_nome)']);

        $dados = $builder->get()->getRowArray();
        return $dados ?: null;
    }

    /**
     * Retorna a lista de categorias presentes na escola com contagem de equipamentos.
     */
    public function getCategoriasResumo(string $cie): array
    {
        $builder = $this->db->table($this->table);
        $builder->select('COALESCE(NULLIF(TRIM(categoria), \'\'), \'Outros\') as categoria, COUNT(*) as total', false);
        $builder->where('TRIM(escola_cie)', trim($cie));
        $builder->groupBy('COALESCE(NULLIF(TRIM(categoria), \'\'), \'Outros\')');
        $builder->orderBy('total', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Retorna os valores únicos disponíveis para filtros dinâmicos de uma escola.
     */
    public function getFiltrosDisponiveis(string $cie): array
    {
        $cats = $this->db->table($this->table)
            ->select('DISTINCT TRIM(categoria) as categoria', false)
            ->where('TRIM(escola_cie)', trim($cie))
            ->where('categoria IS NOT NULL')
            ->where('TRIM(categoria) !=', '')
            ->orderBy('categoria', 'ASC')
            ->get()->getResultArray();

        $status = $this->db->table($this->table)
            ->select('DISTINCT TRIM(status_equipamento) as status_equipamento', false)
            ->where('TRIM(escola_cie)', trim($cie))
            ->where('status_equipamento IS NOT NULL')
            ->where('TRIM(status_equipamento) !=', '')
            ->orderBy('status_equipamento', 'ASC')
            ->get()->getResultArray();

        $ambientes = $this->db->table($this->table)
            ->select('DISTINCT TRIM(ambiente) as ambiente', false)
            ->where('TRIM(escola_cie)', trim($cie))
            ->where('ambiente IS NOT NULL')
            ->where('TRIM(ambiente) !=', '')
            ->orderBy('ambiente', 'ASC')
            ->get()->getResultArray();

        return [
            'categorias' => array_column($cats, 'categoria'),
            'status'     => array_column($status, 'status_equipamento'),
            'ambientes'  => array_column($ambientes, 'ambiente'),
        ];
    }

    /**
     * Retorna todos os equipamentos da escola selecionada com suporte a filtros.
     */
    public function getEquipamentosPorEscola(string $cie, array $filtros = []): array
    {
        $builder = $this->db->table($this->table);
        $builder->where('TRIM(escola_cie)', trim($cie));

        if (!empty($filtros['categoria'])) {
            $builder->where('TRIM(categoria)', trim($filtros['categoria']));
        }

        if (!empty($filtros['status'])) {
            $builder->where('TRIM(status_equipamento)', trim($filtros['status']));
        }

        if (!empty($filtros['ambiente'])) {
            $builder->where('TRIM(ambiente)', trim($filtros['ambiente']));
        }

        if (!empty($filtros['busca'])) {
            $b = strtolower(trim($filtros['busca']));
            $builder->groupStart()
                ->like('LOWER(hostname)', $b)
                ->orLike('LOWER(numero_serie)', $b)
                ->orLike('LOWER(modelo)', $b)
                ->orLike('LOWER(fabricante)', $b)
                ->orLike('LOWER(id_controle_ue)', $b)
                ->orLike('LOWER(descricao)', $b)
                ->orLike('LOWER(numero_chamado)', $b)
                ->orLike('LOWER(tecnico_responsavel)', $b)
                ->groupEnd();
        }

        $builder->orderBy('ambiente', 'ASC');
        $builder->orderBy('categoria', 'ASC');
        $builder->orderBy('hostname', 'ASC');

        return $builder->get()->getResultArray();
    }
}

