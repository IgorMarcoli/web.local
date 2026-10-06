<?php

namespace App\Controllers;

use App\Models\InventarioEscolasModel;

class Painel extends BaseController
{
    /**
     * Valida se a requisição está autorizada:
     * 1. Sessão ativa da intranet (usuário logado).
     * 2. Token via parâmetro GET (?t=...).
     * 3. Token via cabeçalho Authorization: Bearer <token>.
     * 4. Token via cabeçalho customizado X-Painel-Token.
     * 5. Se nenhum token estiver configurado no .env, permite acesso direto.
     */
    private function autorizado(): bool
    {
        // 1. Sessão ativa da intranet
        if (session()->get('usuario') || session()->get('id') || session()->get('logado')) {
            return true;
        }

        $esperado = trim((string) env('painel.token', ''));

        // Se não houver token configurado no .env, libera acesso
        if ($esperado === '') {
            return true;
        }

        // 2. Token via query string ?t=
        $tokenGet = trim((string) $this->request->getGet('t'));
        if ($tokenGet !== '' && hash_equals($esperado, $tokenGet)) {
            return true;
        }

        // 3. Token via Authorization: Bearer ...
        $cabecalho = trim((string) $this->request->getHeaderLine('Authorization'));
        if ($cabecalho !== '' && preg_match('/\ABearer\s+(.+)\z/i', $cabecalho, $matches)) {
            if (hash_equals($esperado, trim($matches[1]))) {
                return true;
            }
        }

        // 4. Token via cabeçalho X-Painel-Token
        $cabecalhoCustom = trim((string) $this->request->getHeaderLine('X-Painel-Token'));
        if ($cabecalhoCustom !== '' && hash_equals($esperado, $cabecalhoCustom)) {
            return true;
        }

        return false;
    }

    /**
     * Extrai e formata os dados estatísticos consolidados do inventário escolar.
     */
    private function obterDadosInventario(): array
    {
        $model = new InventarioEscolasModel();

        // 1. Resumo geral
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

        // 2. Escolas mais críticas (% com problemas)
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
            static fn (array $escola): bool => $escola['problema'] > 0
        ));

        usort($escolasFiltradas, static function (array $a, array $b): int {
            return ($b['pct'] <=> $a['pct']) ?: ($b['problema'] <=> $a['problema']);
        });

        $criticas = array_slice($escolasFiltradas, 0, 10);

        // 3. Tipos / Categorias de equipamentos x Condição
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

        return [
            'resumo'     => $resumo,
            'criticas'   => $criticas,
            'tipos'      => array_slice($tipos, 0, 8),
            'atualizado' => date('H:i'),
        ];
    }

    public function index()
    {
        $tokenConfig = trim((string) env('painel.token', ''));
        $dados = $this->obterDadosInventario();

        return $this->response
            ->setHeader('Cache-Control', 'no-store, private')
            ->setHeader('Referrer-Policy', 'no-referrer')
            ->setHeader('X-Robots-Tag', 'noindex, nofollow')
            ->setBody(view('painel', [
                'dadosIniciais' => $dados,
                'token'         => $tokenConfig,
            ]));
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

        $dados = $this->obterDadosInventario();

        return $this->response
            ->setHeader('Cache-Control', 'no-store, private')
            ->setHeader('Referrer-Policy', 'no-referrer')
            ->setJSON($dados);
    }
}
