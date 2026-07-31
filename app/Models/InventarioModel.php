<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class InventarioModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kits';
    protected $primaryKey       = 'id_kit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kit',
        'numero',
        'id_notebook',
        'id_mouse',
        'id_carregador',
        'id_adaptador',
        'id_locker'
    ];

    public function getKitsWithItems(): array
    {
        $builder = $this->db->table('kits k');
        $builder->select([
            'k.id_kit',
            'k.numero AS numero_mochila',
            'k.id_notebook',
            'k.id_mouse',
            'k.id_carregador',
            'k.id_adaptador',
            'k.id_locker',
            'n.marca_modelo AS notebook_marca_modelo',
            'n.serial AS notebook_serial',
            'n.patrimonio AS notebook_patrimonio',
            'n.estado_conservacao AS notebook_estado_conservacao',
            'm.marca_modelo AS mouse_marca_modelo',
            'm.serial AS mouse_serial',
            'm.patrimonio AS mouse_patrimonio',
            'm.estado_conservacao AS mouse_estado_conservacao',
            'c.marca_modelo AS carregador_marca_modelo',
            'c.serial AS carregador_serial',
            'c.patrimonio AS carregador_patrimonio',
            'c.estado_conservacao AS carregador_estado_conservacao',
            'a.marca_modelo AS adaptador_marca_modelo',
            'a.serial AS adaptador_serial',
            'a.patrimonio AS adaptador_patrimonio',
            'a.estado_conservacao AS adaptador_estado_conservacao',
            'l.marca_modelo AS locker_marca_modelo',
            'l.serial AS locker_serial',
            'l.patrimonio AS locker_patrimonio',
            'l.estado_conservacao AS locker_estado_conservacao',
            'n.data_registro AS data_registro'
        ]);
        $builder->join('itens n', 'n.id_item = k.id_notebook', 'left');
        $builder->join('itens m', 'm.id_item = k.id_mouse', 'left');
        $builder->join('itens c', 'c.id_item = k.id_carregador', 'left');
        $builder->join('itens a', 'a.id_item = k.id_adaptador', 'left');
        $builder->join('itens l', 'l.id_item = k.id_locker', 'left');

        $kits = $builder->orderBy('k.id_kit', 'ASC')->get()->getResultArray();

        return [
            'kits' => $kits,
            'extra_columns' => [],
        ];
    }

    public function saveKit(array $dados): int
    {
        $idKit = (int) ($dados['id_kit'] ?? 0);
        $numeroMochila = $this->normalizeValue($dados['numero_mochila'] ?? '');

        $db = $this->db;
        $builderKits = $db->table('kits');
        $builderItens = $db->table('itens');

        $kitRecord = null;
        if ($idKit > 0) {
            $kitRecord = $builderKits->where('id_kit', $idKit)->get()->getRowArray();
        }

        if ($numeroMochila === '') {
            if ($kitRecord && !empty($kitRecord['numero'])) {
                $numeroMochila = (string) $kitRecord['numero'];
            } elseif ($idKit > 0) {
                $numeroMochila = (string) $idKit;
            }
        }

        if ($numeroMochila === '' || !ctype_digit($numeroMochila)) {
            throw new \InvalidArgumentException('Número da mochila é obrigatório e deve ser numérico.');
        }

        $numeroMochila = (int) $numeroMochila;

        $db->transStart();

        if ($kitRecord) {
            $builderKits->where('id_kit', $idKit)->update([
                'numero' => $numeroMochila,
            ]);
        } else {
            $builderKits->insert([
                'id_kit' => $numeroMochila,
                'numero' => $numeroMochila,
            ]);
            $idKit = $numeroMochila;
        }

        if ($idKit <= 0) {
            $db->transComplete();
            throw new \RuntimeException('Não foi possível criar ou atualizar o kit.');
        }

        $existingDataRegistro = null;
        if ($kitRecord) {
            $existingNotebook = $builderItens->where('id_item', $kitRecord['id_notebook'] ?? 0)->get()->getRowArray();
            $existingMouse = $builderItens->where('id_item', $kitRecord['id_mouse'] ?? 0)->get()->getRowArray();
            $existingCarregador = $builderItens->where('id_item', $kitRecord['id_carregador'] ?? 0)->get()->getRowArray();
            $existingAdaptador = $builderItens->where('id_item', $kitRecord['id_adaptador'] ?? 0)->get()->getRowArray();
            $existingLocker = $builderItens->where('id_item', $kitRecord['id_locker'] ?? 0)->get()->getRowArray();

            foreach ([$existingNotebook, $existingMouse, $existingCarregador, $existingAdaptador, $existingLocker] as $existingItem) {
                if (!empty($existingItem['data_registro'])) {
                    $existingDataRegistro = $existingItem['data_registro'];
                    break;
                }
            }
        }

        $dataRegistro = $existingDataRegistro ?? Time::now()->format('Y-m-d H:i:s');
        $itemDefinitions = [
            'notebook' => [
                'tipo' => 'Notebook',
                'required' => true,
            ],
            'mouse' => [
                'tipo' => 'Mouse',
                'required' => true,
            ],
            'carregador' => [
                'tipo' => 'Carregador',
                'required' => true,
            ],
            'adaptador' => [
                'tipo' => 'Adaptador USB VGA',
                'required' => false,
            ],
            'locker' => [
                'tipo' => 'Locker',
                'required' => false,
            ],
        ];

        $itemIds = [];
        $existingItemIds = [];
        if ($kitRecord) {
            $existingItemIds = [
                'notebook' => $kitRecord['id_notebook'] ?? null,
                'mouse' => $kitRecord['id_mouse'] ?? null,
                'carregador' => $kitRecord['id_carregador'] ?? null,
                'adaptador' => $kitRecord['id_adaptador'] ?? null,
                'locker' => $kitRecord['id_locker'] ?? null,
            ];
        }

        foreach ($itemDefinitions as $inputKey => $definition) {
            $itemInput = $dados['items'][$inputKey] ?? [];
            $marcaModelo = $this->normalizeValue($itemInput['marca_modelo'] ?? '');
            $serial = $this->normalizeValue($itemInput['serial'] ?? '');
            $patrimonio = $this->normalizeValue($itemInput['patrimonio'] ?? '');
            $estadoConservacao = $this->normalizeValue($itemInput['estado_conservacao'] ?? '');
            $tipoPersonalizado = $this->normalizeValue($itemInput['tipo_personalizado'] ?? '');

            $hasAnyValue = $marcaModelo !== '' || $serial !== '' || $patrimonio !== '' || $estadoConservacao !== '';

            if ($definition['required'] && !$hasAnyValue) {
                $db->transComplete();
                throw new \InvalidArgumentException('O item "' . $definition['tipo'] . '" é obrigatório.');
            }

            if (!$definition['required'] && !$hasAnyValue) {
                continue;
            }

            $tipoItem = $definition['tipo'];

            $existingItemId = $existingItemIds[$inputKey] ?? null;
            if (!empty($existingItemId)) {
                $builderItens->where('id_item', $existingItemId)->update([
                    'tipo' => $tipoItem,
                    'marca_modelo' => $marcaModelo,
                    'serial' => $serial,
                    'patrimonio' => $patrimonio,
                    'estado_conservacao' => $estadoConservacao,
                    'numero_mochila' => $numeroMochila,
                    'data_registro' => $dataRegistro,
                ]);
                $itemIds[$inputKey] = (int) $existingItemId;
            } else {
                $builderItens->insert([
                    'tipo' => $tipoItem,
                    'marca_modelo' => $marcaModelo,
                    'serial' => $serial,
                    'patrimonio' => $patrimonio,
                    'estado_conservacao' => $estadoConservacao,
                    'numero_mochila' => $numeroMochila,
                    'data_registro' => $dataRegistro,
                ]);

                $itemIds[$inputKey] = (int) $db->insertID();
            }
        }

        if (empty($itemIds['notebook']) || empty($itemIds['mouse']) || empty($itemIds['carregador'])) {
            $db->transComplete();
            throw new \RuntimeException('Não foi possível registrar todos os itens obrigatórios do kit.');
        }

        $builderKits->where('id_kit', $idKit)->update([
            'id_notebook' => $itemIds['notebook'],
            'id_mouse' => $itemIds['mouse'],
            'id_carregador' => $itemIds['carregador'],
            'id_adaptador' => $itemIds['adaptador'] ?? null,
            'id_locker' => $itemIds['locker'] ?? null,
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \RuntimeException('O registro do kit falhou.');
        }

        return $idKit;
    }

    public function deleteKitItems(int $idKit): void
    {
        $db = $this->db;
        $builderKits = $db->table('kits');
        $kitRecord = $builderKits->where('id_kit', $idKit)->get()->getRowArray();

        if (!$kitRecord) {
            return;
        }

        $db->transStart();

        $itemIdsToRemove = [];
        foreach (['id_notebook', 'id_mouse', 'id_carregador', 'id_adaptador', 'id_locker'] as $field) {
            $itemId = $kitRecord[$field] ?? null;
            if (!empty($itemId)) {
                $itemIdsToRemove[] = (int) $itemId;
            }
        }

        $numeroMochila = $kitRecord['numero'] ?? null;

        $builderKits->where('id_kit', $idKit)->update([
            'id_notebook' => null,
            'id_mouse' => null,
            'id_carregador' => null,
            'id_adaptador' => null,
            'id_locker' => null,
        ]);

        if (!empty($itemIdsToRemove)) {
            $db->table('itens')->whereIn('id_item', array_unique($itemIdsToRemove))->delete();
        }

        if (!empty($numeroMochila) && is_numeric($numeroMochila)) {
            $db->table('itens')->where('numero_mochila', (int) $numeroMochila)->delete();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \RuntimeException('A exclusão do kit falhou.');
        }
    }

    private function normalizeValue(string $value): string
    {
        return trim($value);
    }
}
