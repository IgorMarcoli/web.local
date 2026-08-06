<?php

namespace App\Models;

use App\Models\CategoriasModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class EquipamentosModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'itens';
    protected $primaryKey       = 'id_item';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tipo',
        'marca_modelo',
        'serial',
        'patrimonio',
        'estado_conservacao',
        'andar',
        'sala',
        'categoria',
        'numero_mochila',
        'data_registro',
    ];

    public function listar(): array
    {
        $builder = $this->db->table('itens i');
        $builder->select([
            'i.id_item',
            'i.tipo',
            'i.marca_modelo',
            'i.serial',
            'i.patrimonio',
            'i.estado_conservacao',
            'COALESCE(c.nome, i.categoria) AS categoria',
            'i.andar',
            'i.sala',
            's.nome_sala',
            'i.data_registro',
        ]);
        $builder->join('categorias c', 'c.nome = i.categoria', 'left');
        $builder->join('salas s', 's.id_sala = i.sala', 'left');

        return $builder->orderBy('i.id_item', 'DESC')->get()->getResultArray();
    }

    public function listarSalas(): array
    {
        $builder = $this->db->table('salas');
        $builder->select([
            'id_sala',
            'nome_sala',
        ]);

        return $builder->orderBy('nome_sala', 'ASC')->get()->getResultArray();
    }

    public function salvar(array $dados): int
    {
        $idItem = (int) ($dados['id_item'] ?? 0);
        $tipo = $this->normalizeValue($dados['tipo'] ?? '');
        $marcaModelo = $this->normalizeValue($dados['marca_modelo'] ?? '');
        $serial = $this->normalizeValue($dados['serial'] ?? '');
        $patrimonio = $this->normalizeValue($dados['patrimonio'] ?? '');
        $estadoConservacao = $this->normalizeValue($dados['estado_conservacao'] ?? '');
        $salaRaw = $this->normalizeValue($dados['sala'] ?? '');
        $sala = $salaRaw !== '' ? (int) $salaRaw : null;
        $andar = '';
        $categoria = $this->normalizeValue($dados['categoria'] ?? '');

        if ($sala !== null) {
            $salaRow = $this->db->table('salas')->select('andar')->where('id_sala', $sala)->get()->getRowArray();
            if (isset($salaRow['andar'])) {
                $andar = (string) $salaRow['andar'];
            }
        }

        $categoriasModel = new CategoriasModel();
        if ($categoria === '' || !$categoriasModel->exists($categoria)) {
            throw new \InvalidArgumentException('A categoria é obrigatória.');
        }

        if ($tipo === '' || $marcaModelo === '' || $serial === '' || $patrimonio === '' || $estadoConservacao === '') {
            throw new \InvalidArgumentException('Todos os campos obrigatórios devem ser preenchidos.');
        }

        $payload = [
            'tipo' => $tipo,
            'marca_modelo' => $marcaModelo,
            'serial' => $serial,
            'patrimonio' => $patrimonio,
            'estado_conservacao' => $estadoConservacao,
            'andar' => $andar,
            'sala' => $sala,
            'categoria' => $categoria,
        ];

        if ($idItem > 0) {
            $existing = $this->find($idItem);
            if (!empty($existing)) {
                $payload['data_registro'] = $existing['data_registro'] ?? Time::now()->format('Y-m-d H:i:s');
                $this->update($idItem, $payload);
                return $idItem;
            }
        }

        $payload['data_registro'] = Time::now()->format('Y-m-d H:i:s');
        $this->insert($payload);

        return (int) $this->insertID();
    }

    public function excluir(int $idItem): void
    {
        $this->where('id_item', $idItem)->delete();
    }

    private function normalizeValue(string $value): string
    {
        return trim($value);
    }
}
