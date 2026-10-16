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

        $setor = strtoupper(trim($usuario['setor'] ?? ''));
        $session->set([
            'usuario_nome'  => $usuario['Nomeuser'] ?? '',
            'usuario_setor' => $usuario['setor'] ?? null,
        ]);

        $uriPath = trim($request->getUri()->getPath(), '/');
        $uriSegments = explode('/', strtolower($uriPath));
        $primeiroSegmento = $uriSegments[0] ?? '';

        // Usuário do setor PROTOCOLO: Acesso EXCLUSIVO à página de boas-vindas do protocolo,
        // registrar atendimentos, perfil e logout. Acesso BLOQUEADO a tudo do SETEC, SEINTEC e GABINETE.
        if ($setor === 'PROTOCOLO') {
            $rotasPermitidas = ['protocolo', 'perfil', 'login', ''];
            if (!in_array($primeiroSegmento, $rotasPermitidas, true)) {
                return redirect()->to('/protocolo?alert=acessoNegado');
            }
        } else {
            // Usuários que NÃO são do setor PROTOCOLO não podem acessar o módulo do protocolo
            if ($primeiroSegmento === 'protocolo') {
                $destino = ($setor === 'GABINETE') ? '/gabinete' : '/setec';
                return redirect()->to($destino . '?alert=acessoNegado');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada após a requisição
    }
}
