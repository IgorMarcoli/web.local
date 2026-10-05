<?php

namespace App\Controllers;

use App\Models\InventarioEscolasModel;

class Painel extends BaseController
{
    private function autorizado(): bool
    {
        $esperado   = (string) env('painel.token', '');
        $cabecalho  = $this->request->getHeaderLine('Authorization');
        $rateLimitKey = 'painel-auth:' . hash('sha256', $this->request->getIPAddress());

        if (! service('throttler')->check($rateLimitKey, 30, 60)) {
            return false;
        }

        if (strlen($esperado) < 32 || strlen($esperado) > 512
            || ! preg_match('/\ABearer\s+([A-Za-z0-9._~+\/-]{32,512})\z/i', $cabecalho, $matches)
        ) {
            return false;
        }

        if (hash_equals($esperado, $matches[1])) {
            return true;
        }

        return false;
    }

    public function index()
    {
        return $this->response
            ->setHeader('Cache-Control', 'no-store, private')
            ->setHeader('Referrer-Policy', 'no-referrer')
            ->setHeader('X-Robots-Tag', 'noindex, nofollow')
            ->setBody(view('painel'));
    }

    public function dados()
    {
        if (! $this->autorizado()) {
            return $this->response
                ->setStatusCode(403)
                ->setHeader('Cache-Control', 'no-store, private')
                ->setHeader('Referrer-Policy', 'no-referrer')
                ->setJSON(['erro' => 'Acesso negado']);
        }

        $model = new InventarioEscolasModel();
        $stats = $model->getEstatisticasGerais();
        $resumo = [
            'escolas'     => (int) ($stats['total_escolas'] ?? 0),
            'total'       => (int) ($stats['total_equipamentos'] ?? 0),
            'disponiveis' => (int) ($stats['total_disponivel'] ?? 0),
            'manutencao'  => (int) ($stats['total_manutencao'] ?? 0),
            'inserviveis' => (int) ($stats['total_inservivel'] ?? 0),
            'sem_status'  => (int) ($stats['total_sem_status'] ?? 0),
            'outros'      => (int) ($stats['total_outros'] ?? 0),
        ];

        $escolasCriticas = array_map(static function (array $escola): array {
            $total     = (int) ($escola['total_equipamentos'] ?? 0);
            $problemas = (int) ($escola['total_manutencao'] ?? 0) + (int) ($escola['total_inservivel'] ?? 0);

            return [
                'cie'      => (string) ($escola['escola_cie'] ?? ''),
                'nome'     => (string) ($escola['escola_nome'] ?? 'Escola'),
                'total'    => $total,
                'problema' => $problemas,
                'pct'      => $total > 0 ? round(($problemas / $total) * 100, 1) : 0.0,
            ];
        }, $model->getListaEscolas());

        $escolasFiltradas = array_values(array_filter(
            $escolasCriticas,
            static fn (array $escola): bool => $escola['problema'] > 0,
        ));

        usort($escolasFiltradas, static function (array $a, array $b): int {
            return ($b['pct'] <=> $a['pct']) ?: ($b['problema'] <=> $a['problema']);
        });

        $criticas = array_slice($escolasFiltradas, 0, 10);
        $tipos = array_map(static function (array $categoria): array {
            $disponiveis = (int) ($categoria['total_disponivel'] ?? 0);
            $manutencao  = (int) ($categoria['total_manutencao'] ?? 0);
            $inserviveis = (int) ($categoria['total_inservivel'] ?? 0);
            $semStatus   = (int) ($categoria['total_sem_status'] ?? 0);
            $outros      = (int) ($categoria['total_outros'] ?? 0);

            return [
                'tipo'        => (string) ($categoria['categoria'] ?? 'Sem categoria'),
                'total'       => (int) ($categoria['total_equipamentos'] ?? 0),
                'disponiveis' => $disponiveis,
                'manutencao'  => $manutencao,
                'inserviveis' => $inserviveis,
                'outros'      => $outros + $semStatus,
                'problemas'   => $manutencao + $inserviveis,
            ];
        }, $model->getResumoPorCategoria());

        usort($tipos, static function (array $a, array $b): int {
            return ($b['problemas'] <=> $a['problemas']) ?: ($b['total'] <=> $a['total']);
        });

        return $this->response
            ->setHeader('Cache-Control', 'no-store, private')
            ->setHeader('Referrer-Policy', 'no-referrer')
            ->setJSON([
                'resumo'     => $resumo,
                'criticas'   => $criticas,
                'tipos'      => array_slice($tipos, 0, 8),
                'atualizado' => date('H:i'),
            ]);
    }
}
