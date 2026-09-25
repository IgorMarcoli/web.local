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
        if (!session()->get('logado') || !session()->get('usuario_id')) {
            return redirect()->to('/login?alert=naoLogado');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada após a requisição
    }
}
