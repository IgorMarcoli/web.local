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
        $builder = $this->db->table('itens i');
        $builder->select([
            'i.id_item',
            'i.tipo',
            'i.marca_modelo',
            'i.serial',
            'i.patrimonio',
            'i.estado_conservacao',
            'i.andar',
            'i.sala',
            's.nome_sala',
            'i.data_registro',
        ]);
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
        $andar = $this->normalizeValue($dados['andar'] ?? '');
        $sala = $this->normalizeValue($dados['sala'] ?? '');

        if ($andar !== '' && !ctype_digit((string) $andar)) {
            throw new \InvalidArgumentException('O número do andar deve estar entre 0 e 4.');
        }

        if ($andar !== '' && ((int) $andar < 0 || (int) $andar > 4)) {
            throw new \InvalidArgumentException('O número do andar deve estar entre 0 e 4.');
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
