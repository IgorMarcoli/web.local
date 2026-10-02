<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SetorFilter implements FilterInterface
{
    /**
     * Bloqueia rotas exclusivas do SEINTEC para usuários do SETEC.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $usuarioSetor = strtoupper(trim(session()->get('usuario_setor') ?? ''));

        // Se o usuário for do SETEC, restringe o acesso para as funcionalidades permitidas
        if ($usuarioSetor === 'SETEC') {
            return redirect()->to('/Dashboard')->with('alert', 'acessoNegado');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada após a execução
    }
}
