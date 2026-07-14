<?php
namespace App\Models;
use CodeIgniter\Model;


class NovaModel extends Model {
    protected $table = 'processos';
    protected $primaryKey = 'numeroSEI';
    protected $allowedFields = [
        'numeroSEI',
        'assunto',
        'escola',
        'dataEntrada',
        'dataSaida',
        'mesaDestino',
        'comarca'
        ];

    public function normalizeEscolaData($escolaValue, array $escolas = []): array
    {
        $normalized = [
            'escola' => '',
            'escolaId' => '',
        ];

        if ($escolaValue === null || $escolaValue === '') {
            return $normalized;
        }

        foreach ($escolas as $escola) {
            $escolaId = (string)($escola['EscolaId'] ?? '');
            $nomeEscola = (string)($escola['Nome'] ?? '');

            if ($escolaId !== '' && (string) $escolaValue === $escolaId) {
                $normalized['escola'] = $nomeEscola;
                $normalized['escolaId'] = $escolaId;
                return $normalized;
            }

            if ($nomeEscola !== '' && (string) $escolaValue === $nomeEscola) {
                $normalized['escola'] = $nomeEscola;
                $normalized['escolaId'] = $escolaId;
                return $normalized;
            }
        }

        $normalized['escola'] = (string) $escolaValue;

        return $normalized;
    }
}