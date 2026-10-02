<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Bloqueia qualquer navegação por URL para usuários que não estejam autenticados.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Se o usuário não estiver autenticado na sessão, redireciona para a página de login
        $session = session();
        $usuarioId = $session->get('usuario_id');

        if (!$session->get('logado') || !$usuarioId) {
            return redirect()->to('/login?alert=naoLogado');
        }

        // Revalida usuário e setor no banco para não confiar em permissões antigas na sessão.
        $usuario = (new \App\Models\LoginModel())->find($usuarioId);
        if (!$usuario) {
            $session->destroy();
            return redirect()->to('/login?alert=naoLogado');
        }

        $session->set([
            'usuario_nome'  => $usuario['Nomeuser'] ?? '',
            'usuario_setor' => $usuario['setor'] ?? null,
        ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada após a requisição
    }
}
