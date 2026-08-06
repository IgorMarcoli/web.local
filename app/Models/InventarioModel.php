<?php

namespace App\Models;

use App\Models\CategoriasModel;
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
            'COALESCE(cat.nome, k.categoria) AS categoria',
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
        $builder->join('categorias cat', 'cat.nome = k.categoria', 'left');
        $builder->join('itens n', 'n.id_item = k.id_notebook', 'left');
        $builder->join('itens m', 'm.id_item = k.id_mouse', 'left');
        $builder->join('itens c', 'c.id_item = k.id_carregador', 'left');
        $builder->join('itens a', 'a.id_item = k.id_adaptador', 'left');
        $builder->join('itens l', 'l.id_item = k.id_locker', 'left');
        $builder->orderBy('k.id_kit', 'ASC');

        $kits = $builder->get()->getResultArray();

        return [
            'kits' => $kits,
            'extra_columns' => [],
        ];
    }

    public function saveKit(array $dados): int
    {
        $idKit = (int) ($dados['id_kit'] ?? 0);
        $numeroMochilaRaw = $this->normalizeValue($dados['numero_mochila'] ?? '');

        $db = $this->db;
        $builderKits = $db->table('kits');
        $builderItens = $db->table('itens');

        $kitRecord = null;
        if ($idKit > 0) {
            $kitRecord = $builderKits->where('id_kit', $idKit)->get()->getRowArray();
        }

        $numeroMochila = null;
        if ($numeroMochilaRaw !== '') {
            if (!ctype_digit($numeroMochilaRaw)) {
                throw new \InvalidArgumentException('Número da mochila deve ser numérico.');
            }

            $numeroMochila = (int) $numeroMochilaRaw;
        }

        $db->transStart();

        $categoriaKit = $this->normalizeValue($dados['categoria'] ?? '');
        $categoriasModel = new CategoriasModel();
        if ($categoriaKit === '' || !$categoriasModel->exists($categoriaKit)) {
            throw new \InvalidArgumentException('A categoria é obrigatória.');
        }

        $existingKitId = (int) ($kitRecord['id_kit'] ?? 0);
        $targetNumeroKit = $numeroMochila;
        $targetKitId = $numeroMochila !== null ? $numeroMochila : null;

        if ($kitRecord && $numeroMochila === null && $kitRecord['numero'] !== null) {
            $targetKitId = $this->getNextAvailableKitId();
        }

        if ($kitRecord && $numeroMochila !== null) {
            $currentKitId = (int) ($kitRecord['id_kit'] ?? 0);
            $currentNumero = (int) ($kitRecord['numero'] ?? 0);
            if ($targetKitId !== $currentKitId && $targetKitId !== $currentNumero) {
                $conflictKit = $builderKits->select('id_kit')->where('id_kit', $targetKitId)->get()->getRowArray();
                if ($conflictKit) {
                    throw new \RuntimeException('Já existe outro kit com esse número da mochila.');
                }
            }
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

        $actualKitId = $existingKitId;
        if ($kitRecord) {
            $updatePayload = [
                'categoria' => $categoriaKit,
                'numero' => $targetNumeroKit,
            ];

            if ($targetKitId !== null && $targetKitId !== $existingKitId) {
                $updatePayload['id_kit'] = $targetKitId;
            }

            $builderKits->where('id_kit', $existingKitId)->update($updatePayload);
            $actualKitId = $targetKitId !== null ? $targetKitId : $existingKitId;
        } else {
            $insertPayload = [
                'categoria' => $categoriaKit,
                'numero' => $targetNumeroKit,
            ];

            if ($targetKitId !== null) {
                $insertPayload['id_kit'] = $targetKitId;
            }

            $builderKits->insert($insertPayload);
            $actualKitId = $targetKitId !== null ? $targetKitId : (int) $db->insertID();
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
            $skipItem = !empty($itemInput['skip'] ?? '');
            if ($skipItem) {
                $itemIds[$inputKey] = null;
                continue;
            }

            $marcaModelo = $this->normalizeValue($itemInput['marca_modelo'] ?? '');
            $serial = $this->normalizeValue($itemInput['serial'] ?? '');
            $patrimonio = $this->normalizeValue($itemInput['patrimonio'] ?? '');
            $estadoConservacao = $this->normalizeValue($itemInput['estado_conservacao'] ?? '');

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
                    'numero_mochila' => $actualKitId,
                    'categoria' => $categoriaKit,
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
                    'numero_mochila' => $actualKitId,
                    'categoria' => $categoriaKit,
                    'data_registro' => $dataRegistro,
                ]);

                $itemIds[$inputKey] = (int) $db->insertID();
            }
        }

        if (empty($itemIds['notebook'])) {
            $db->transComplete();
            throw new \RuntimeException('Não foi possível registrar todos os itens obrigatórios do kit.');
        }

        $builderKits->where('id_kit', $actualKitId)->update([
            'numero' => $targetNumeroKit,
            'categoria' => $categoriaKit,
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

        return $actualKitId;
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

        if (!empty($itemIdsToRemove)) {
            $db->table('itens')->whereIn('id_item', array_unique($itemIdsToRemove))->delete();
        }

        $builderKits->where('id_kit', $idKit)->delete();
        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \RuntimeException('A exclusão do kit falhou.');
        }
    }

    private function resolveTargetKitId(?array $kitRecord, int $currentId, ?int $numeroMochila): int
    {
        if ($numeroMochila !== null) {
            return $numeroMochila;
        }

        if ($kitRecord && !empty($kitRecord['id_kit'])) {
            return (int) $kitRecord['id_kit'];
        }

        return $this->getNextAvailableKitId();
    }

    private function getNextAvailableKitId(): int
    {
        $builder = $this->db->table('kits');
        $result = $builder->select('id_kit')->get()->getResultArray();

        $usedIds = [];
        foreach ($result as $row) {
            $kitId = (int) ($row['id_kit'] ?? 0);
            $usedIds[$kitId] = true;
        }

        $candidate = 0;
        while (isset($usedIds[$candidate])) {
            $candidate++;
        }

        return $candidate;
    }

    private function normalizeValue(string $value): string
    {
        return trim($value);
    }
}
