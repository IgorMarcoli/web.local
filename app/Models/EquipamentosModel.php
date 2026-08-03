<?php

namespace App\Models;

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
        'numero_mochila',
        'data_registro',
    ];

    public function listar(): array
    {
        $builder = $this->db->table('itens');
        $builder->select([
            'id_item',
            'tipo',
            'marca_modelo',
            'serial',
            'patrimonio',
            'estado_conservacao',
            'andar',
            'sala',
            'data_registro',
        ]);

        return $builder->orderBy('id_item', 'DESC')->get()->getResultArray();
    }

    public function salvar(array $dados): int
    {
        $idItem = (int) ($dados['id_item'] ?? 0);
        $tipo = $this->normalizeValue($dados['tipo'] ?? '');
        $marcaModelo = $this->normalizeValue($dados['marca_modelo'] ?? '');
        $serial = $this->normalizeValue($dados['serial'] ?? '');
        $patrimonio = $this->normalizeValue($dados['patrimonio'] ?? '');
        $estadoConservacao = $this->normalizeValue($dados['estado_conservacao'] ?? '');
        $andar = $this->normalizeValue($dados['andar'] ?? '');
        $sala = $this->normalizeValue($dados['sala'] ?? '');

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
