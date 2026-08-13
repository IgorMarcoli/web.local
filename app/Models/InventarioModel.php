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
        $isBulkPayload = is_array($dados['numero_mochila'] ?? null)
            || is_array($dados['categoria'] ?? null)
            || is_array($dados['items']['notebook']['marca_modelo'] ?? null)
            || is_array($dados['items']['mouse']['marca_modelo'] ?? null)
            || is_array($dados['items']['carregador']['marca_modelo'] ?? null)
            || is_array($dados['items']['adaptador']['marca_modelo'] ?? null)
            || is_array($dados['items']['locker']['marca_modelo'] ?? null);

        if ($isBulkPayload) {
            $this->saveKitMultiplo($dados, !empty($dados['id_kit']));
            return 0;
        }

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

        if ($numeroMochila !== null) {
            if ($idKit > 0) {
                // When editing a single kit, validate against existing kit IDs/numbers
                $this->validateBulkKitNumbers([$idKit], [$numeroMochilaRaw]);
            }
            $duplicateKit = $builderKits
                ->where('numero', $numeroMochila)
                ->where('id_kit !=', $idKit > 0 ? $idKit : -1)
                ->get()
                ->getRowArray();

            if ($duplicateKit) {
                throw new \RuntimeException('Esse número ou ID de kit já está registrado. Favor insira outro.');
            }
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
                    throw new \RuntimeException('Esse número ou ID de kit já está registrado. Favor insira outro.');
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
                // Prevent inserting with an id_kit that already exists
                $existingId = $builderKits->select('id_kit')->where('id_kit', $targetKitId)->get()->getRowArray();
                if ($existingId) {
                    throw new \RuntimeException('Esse número ou ID de kit já está registrado. Favor insira outro.');
                }
                $insertPayload['id_kit'] = $targetKitId;
            }

            $builderKits->insert($insertPayload);
            $actualKitId = $targetKitId !== null ? $targetKitId : (int) $db->insertID();
        }

        $dataRegistro = $existingDataRegistro ?? Time::now()->format('Y-m-d H:i:s');
        $itemDefinitions = [
            'notebook' => ['tipo' => 'Notebook', 'required' => true],
            'mouse' => ['tipo' => 'Mouse', 'required' => true],
            'carregador' => ['tipo' => 'Carregador', 'required' => true],
            'adaptador' => ['tipo' => 'Adaptador USB VGA', 'required' => false],
            'locker' => ['tipo' => 'Locker', 'required' => false],
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

    public function saveKitMultiplo(array $dados, bool $isEdit = false): void
    {
        $numeros = $dados['numero_mochila'] ?? [];
        if (!is_array($numeros) || empty($numeros)) {
            $this->saveKit($dados);
            return;
        }

        $idKits = is_array($dados['id_kit'] ?? null) ? $dados['id_kit'] : [ $dados['id_kit'] ?? null ];
        $categorias = is_array($dados['categoria'] ?? null) ? $dados['categoria'] : [ $dados['categoria'] ?? ''];
        $items = $dados['items'] ?? [];
        $count = count($numeros);

        // Validate bulk numbers/ids when editing to avoid accidental duplicates
        if ($isEdit) {
            // Ensure every edited row includes its original id to avoid accidental inserts
            foreach ($idKits as $idx => $val) {
                $v = $this->normalizeValue($val ?? '');
                if ($v === '') {
                    throw new \RuntimeException('ID do kit ausente em pelo menos um registro editado. Verifique os registros selecionados.');
                }
                if (!ctype_digit($v)) {
                    throw new \InvalidArgumentException('ID do kit deve ser numérico.');
                }
            }

            $this->validateBulkKitNumbers($idKits, $numeros);

            // Detect target-id collisions inside the batch (when a target id equals another original id)
            $originalIds = array_map(function ($v) { $v = $this->normalizeValue($v ?? ''); return $v === '' ? null : (int) $v; }, $idKits);
            $desiredTargets = [];
            $countNumeros = count($numeros);
            for ($i = 0; $i < $countNumeros; $i++) {
                $num = $this->normalizeValue($numeros[$i] ?? '');
                $desiredTargets[$i] = ($num !== '' && ctype_digit($num)) ? (int) $num : null;
            }

            $originalIdSet = array_values(array_filter($originalIds, function ($v) { return $v !== null; }));
            $needsTemp = [];
            foreach ($desiredTargets as $i => $tgt) {
                $orig = $originalIds[$i] ?? null;
                if ($tgt !== null && $orig !== null && $tgt !== $orig && in_array($tgt, $originalIdSet, true)) {
                    $needsTemp[$i] = true;
                }
            }

            if (!empty($needsTemp)) {
                // Assign unique negative temp ids and update DB rows to free desired targets
                $tempCounter = 1;
                foreach ($needsTemp as $i => $_) {
                    $origId = $originalIds[$i];
                    $tempId = -1 * (1000 + $tempCounter);
                    $tempCounter++;

                    // Update kits primary key to temporary id
                    $this->db->table('kits')->where('id_kit', $origId)->update(['id_kit' => $tempId]);
                    // Update itens.numero_mochila references
                    $this->db->table('itens')->where('numero_mochila', $origId)->update(['numero_mochila' => $tempId]);

                    // Reflect temp id back into idKits array so subsequent saveKit sees the right record
                    $idKits[$i] = (string) $tempId;
                    // Also update originalIds to the temp so we don't try to temp it again
                    $originalIds[$i] = $tempId;
                }
            }
        }

        for ($i = 0; $i < $count; $i++) {
            $single = [
                'id_kit' => $idKits[$i] ?? null,
                'numero_mochila' => $numeros[$i] ?? '',
                'categoria' => $categorias[$i] ?? '',
                'items' => [
                    'notebook' => [
                        'marca_modelo' => $items['notebook']['marca_modelo'][$i] ?? '',
                        'serial' => $items['notebook']['serial'][$i] ?? '',
                        'patrimonio' => $items['notebook']['patrimonio'][$i] ?? '',
                        'estado_conservacao' => $items['notebook']['estado_conservacao'][$i] ?? '',
                        'skip' => $items['notebook']['skip'][$i] ?? '',
                    ],
                    'mouse' => [
                        'marca_modelo' => $items['mouse']['marca_modelo'][$i] ?? '',
                        'serial' => $items['mouse']['serial'][$i] ?? '',
                        'patrimonio' => $items['mouse']['patrimonio'][$i] ?? '',
                        'estado_conservacao' => $items['mouse']['estado_conservacao'][$i] ?? '',
                        'skip' => $items['mouse']['skip'][$i] ?? '',
                    ],
                    'carregador' => [
                        'marca_modelo' => $items['carregador']['marca_modelo'][$i] ?? '',
                        'serial' => $items['carregador']['serial'][$i] ?? '',
                        'patrimonio' => $items['carregador']['patrimonio'][$i] ?? '',
                        'estado_conservacao' => $items['carregador']['estado_conservacao'][$i] ?? '',
                        'skip' => $items['carregador']['skip'][$i] ?? '',
                    ],
                    'adaptador' => [
                        'marca_modelo' => $items['adaptador']['marca_modelo'][$i] ?? '',
                        'serial' => $items['adaptador']['serial'][$i] ?? '',
                        'patrimonio' => $items['adaptador']['patrimonio'][$i] ?? '',
                        'estado_conservacao' => $items['adaptador']['estado_conservacao'][$i] ?? '',
                        'skip' => $items['adaptador']['skip'][$i] ?? '',
                    ],
                    'locker' => [
                        'marca_modelo' => $items['locker']['marca_modelo'][$i] ?? '',
                        'serial' => $items['locker']['serial'][$i] ?? '',
                        'patrimonio' => $items['locker']['patrimonio'][$i] ?? '',
                        'estado_conservacao' => $items['locker']['estado_conservacao'][$i] ?? '',
                        'skip' => $items['locker']['skip'][$i] ?? '',
                    ],
                ],
            ];

            if ($this->isKitPayloadEmpty($single)) {
                continue;
            }

            $this->saveKit($single);
        }
    }

    private function isKitPayloadEmpty(array $kit): bool
    {
        if (trim((string) ($kit['numero_mochila'] ?? '')) !== '') {
            return false;
        }

        if (trim((string) ($kit['categoria'] ?? '')) !== '') {
            return false;
        }

        foreach ($kit['items'] as $item) {
            if (!is_array($item)) {
                continue;
            }

            if (trim((string) ($item['marca_modelo'] ?? '')) !== '') {
                return false;
            }
            if (trim((string) ($item['serial'] ?? '')) !== '') {
                return false;
            }
            if (trim((string) ($item['patrimonio'] ?? '')) !== '') {
                return false;
            }
            if (trim((string) ($item['estado_conservacao'] ?? '')) !== '') {
                return false;
            }
        }

        return true;
    }

    private function validateBulkKitNumbers(array $idKits, array $numeros): void
    {
        // Normalize inputs but keep pairwise mapping for bulk validation
        $normalizedNumerosMap = [];
        $normalizedIdsMap = [];
        $selectedIds = array_values(array_filter(array_map(function ($id) {
            return is_numeric($id) ? (int) $id : null;
        }, $idKits), function ($id) {
            return $id > 0;
        }));

        $countNumeros = count($numeros);
        for ($i = 0; $i < $countNumeros; $i++) {
            $rawNumero = $numeros[$i] ?? '';
            $numero = $this->normalizeValue($rawNumero);
            $rawIdKit = $idKits[$i] ?? '';
            $idKit = $this->normalizeValue($rawIdKit);

            if ($idKit !== '') {
                if (!ctype_digit($idKit)) {
                    throw new \InvalidArgumentException('ID do kit deve ser numérico.');
                }
                $normalizedIdsMap[$i] = (int) $idKit;
            } else {
                $normalizedIdsMap[$i] = null;
            }

            if ($numero === '') {
                $normalizedNumerosMap[$i] = null;
                continue;
            }

            if (!ctype_digit($numero)) {
                throw new \InvalidArgumentException('Número da mochila deve ser numérico.');
            }

            $normalizedNumerosMap[$i] = (int) $numero;
        }

        // Check for duplicates among provided numeros and ids
        $presentNumeros = array_values(array_filter($normalizedNumerosMap, function ($v) {
            return $v !== null;
        }));
        if (count($presentNumeros) !== count(array_unique($presentNumeros))) {
            throw new \RuntimeException('Existem números de mochila duplicados na edição em lote.');
        }

        $presentIds = array_values(array_filter($normalizedIdsMap, function ($v) {
            return $v !== null;
        }));
        if (count($presentIds) !== count(array_unique($presentIds))) {
            throw new \RuntimeException('Existem IDs de kit duplicados na edição em lote.');
        }

        $conflictMessage = 'Esse número ou ID de kit já está registrado. Favor insira outro.';

        // Per-item validation: each provided numero must not conflict with any other kit's numero or id,
        // except when it equals the id of the same kit being edited (self).
        foreach ($normalizedNumerosMap as $idx => $numVal) {
            if ($numVal === null) {
                continue;
            }

            $currentId = $normalizedIdsMap[$idx] ?? null; // may be null for new inserts

            // If numero equals own id, allow
            if ($currentId !== null && $numVal === $currentId) {
                continue;
            }

            // Check DB for any kit that has this numero or has this id (regardless of selectedIds)
            $qb = $this->db->table('kits');
            $qb->groupStart();
            $qb->where('numero', $numVal);
            $qb->orWhere('id_kit', $numVal);
            $qb->groupEnd();
            if ($currentId !== null) {
                $qb->where('id_kit !=', $currentId);
            }

            $found = $qb->get()->getResultArray();
            if (!empty($found)) {
                throw new \RuntimeException($conflictMessage);
            }
        }
    }

    public function deleteKitItemsMultiplo(array $ids): void
    {
        foreach ($ids as $idKit) {
            $kitId = (int) $idKit;
            if ($kitId > 0) {
                $this->deleteKitItems($kitId);
            }
        }
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

    private function normalizeValue($value): string
    {
        return trim((string) ($value ?? ''));
    }
}
