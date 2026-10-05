<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Login extends BaseController
{
    public function login()
    {
        return view('login/login');
    }

    public function autenticar()
    {
        $usuarioPostado = $this->request->getPost('Usuario');
        $senhaPostada   = $this->request->getPost('Senha');
        $usuario        = is_string($usuarioPostado) ? trim($usuarioPostado) : '';
        $senha          = is_string($senhaPostada) ? $senhaPostada : '';

        if ($usuario === '' || $senha === '' || strlen($usuario) > 120 || strlen($senha) > 4096) {
            return redirect()->to('/login?alert=errorLogin');
        }

        if (!$this->loginAttemptAllowed($usuario)) {
            return redirect()->to('/login?alert=rateLimit');
        }

        $loginModel = new LoginModel();
        $login      = $loginModel->where('Usuario', $usuario)->first();
        $senhaValida = false;

        if ($login) {
            $senhaArmazenada = (string) ($login['Senha'] ?? '');
            $senhaValida     = $senhaArmazenada !== '' && password_verify($senha, $senhaArmazenada);

            if ($senhaValida && password_needs_rehash($senhaArmazenada, PASSWORD_DEFAULT)) {
                $loginModel->update($login['LoginId'], [
                    'Senha' => password_hash($senha, PASSWORD_DEFAULT),
                ]);
            }
        }

        if (!$senhaValida) {
            return redirect()->to('/login?alert=errorLogin');
        }

        session()->regenerate(true);
        session()->set([
            'usuario_id'    => $login['LoginId'],
            'usuario_nome'  => $login['Nomeuser'],
            'usuario_foto'  => $login['foto'] ?? null,
            'usuario_setor' => $login['setor'] ?? null,
            'logado'        => true,
        ]);

        return redirect()->to('/setec');
    }

    public function perfil()
    {
        $usuario = (new LoginModel())->find(session()->get('usuario_id'));

        if (!$usuario) {
            session()->destroy();
            return redirect()->to('/login?alert=errorLogin');
        }

        echo view('templates/header');
        echo view('login/perfil', ['usuario' => $usuario]);
        echo view('templates/footer');
    }

    public function atualizarPerfil()
    {
        $loginModel = new LoginModel();
        $id         = session()->get('usuario_id');
        $usuario    = $loginModel->find($id);

        if (!$usuario) {
            session()->destroy();
            return redirect()->to('/login?alert=errorLogin');
        }

        $dados       = [];
        $nomePostado = $this->request->getPost('Nomeuser');
        if (is_string($nomePostado)) {
            $nome = trim($nomePostado);
            if ($nome === '' || mb_strlen($nome, 'UTF-8') > 120) {
                return redirect()->to('/perfil?alert=invalidName');
            }
            $dados['Nomeuser'] = $nome;
        }

        $novaSenhaPostada = $this->request->getPost('Senha');
        $novaSenha        = is_string($novaSenhaPostada) ? $novaSenhaPostada : '';
        if ($novaSenha !== '') {
            $senhaAtualPostada = $this->request->getPost('SenhaAtual');
            $confirmacaoPostada = $this->request->getPost('SenhaConfirmacao');
            $senhaAtual = is_string($senhaAtualPostada) ? $senhaAtualPostada : '';
            $confirmacao = is_string($confirmacaoPostada) ? $confirmacaoPostada : '';

            if (!password_verify($senhaAtual, (string) ($usuario['Senha'] ?? ''))) {
                return redirect()->to('/perfil?alert=currentPassword');
            }
            if (strlen($novaSenha) < 12 || strlen($novaSenha) > 72) {
                return redirect()->to('/perfil?alert=passwordLength');
            }
            if (!hash_equals($novaSenha, $confirmacao)) {
                return redirect()->to('/perfil?alert=passwordMismatch');
            }

            $dados['Senha'] = password_hash($novaSenha, PASSWORD_DEFAULT);
        }

        $foto = $this->request->getFile('foto');
        $urlFoto = null;
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $mimeTypes = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
            ];
            $mimeType = $foto->getMimeType();

            if (!isset($mimeTypes[$mimeType]) || $foto->getSize() > 2 * 1024 * 1024) {
                return redirect()->to('/perfil?alert=arquivoInvalido');
            }

            $supabaseUrl = rtrim((string) env('supabase.url', ''), '/');
            $supabaseKey = (string) env('supabase.serviceKey', '');
            $bucket      = (string) env('supabase.profileBucket', 'perfil');
            $urlParts    = parse_url($supabaseUrl);
            if (
                !is_array($urlParts)
                || ($urlParts['scheme'] ?? '') !== 'https'
                || empty($urlParts['host'])
                || $supabaseKey === ''
            ) {
                log_message('error', 'Upload de perfil não configurado com uma URL HTTPS e chave do Supabase.');
                return redirect()->to('/perfil?alert=uploadIndisponivel');
            }

            $conteudoFoto = file_get_contents($foto->getTempName());
            if ($conteudoFoto === false) {
                return redirect()->to('/perfil?alert=uploadFalhou');
            }

            $nomeFoto = 'usuario_' . (int) $id . '_' . bin2hex(random_bytes(8)) . '.' . $mimeTypes[$mimeType];
            $ch       = curl_init();
            if ($ch === false) {
                log_message('error', 'Não foi possível iniciar cURL para o upload de perfil.');
                return redirect()->to('/perfil?alert=uploadFalhou');
            }

            curl_setopt_array($ch, [
                CURLOPT_URL            => $supabaseUrl . '/storage/v1/object/' . rawurlencode($bucket) . '/' . rawurlencode($nomeFoto),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => $conteudoFoto,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_PROTOCOLS      => CURLPROTO_HTTPS,
                CURLOPT_HTTPHEADER     => [
                    'Authorization: Bearer ' . $supabaseKey,
                    'Content-Type: ' . $mimeType,
                    'x-upsert: false',
                ],
            ]);

            $resposta = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErro = curl_errno($ch);
            curl_close($ch);

            if ($resposta === false || !in_array($httpCode, [200, 201], true)) {
                log_message('error', 'Upload de perfil falhou no Supabase (HTTP {code}, cURL {curlCode}).', [
                    'code'     => $httpCode,
                    'curlCode' => $curlErro,
                ]);
                return redirect()->to('/perfil?alert=uploadFalhou');
            }

            $urlFoto = $supabaseUrl . '/storage/v1/object/public/' . rawurlencode($bucket) . '/' . rawurlencode($nomeFoto);
            $dados['foto'] = $urlFoto;
        } elseif ($foto && $foto->getError() !== UPLOAD_ERR_NO_FILE) {
            return redirect()->to('/perfil?alert=arquivoInvalido');
        }

        if ($dados !== []) {
            if (!$loginModel->update($id, $dados)) {
                log_message('error', 'Não foi possível atualizar o perfil do usuário {userId}.', ['userId' => (int) $id]);
                return redirect()->to('/perfil?alert=updateFailed');
            }

            if (isset($dados['Nomeuser'])) {
                session()->set('usuario_nome', $dados['Nomeuser']);
            }
            if (isset($dados['Senha'])) {
                session()->regenerate(true);
            }
            if ($urlFoto !== null) {
                session()->set('usuario_foto', $urlFoto);
            }
        }

        return redirect()->to('/perfil?alert=success');
    }

    public function sair()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(405);
        }

        setcookie('usuario_salvo', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'secure'   => env('CI_ENVIRONMENT', 'production') === 'production',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session()->destroy();

        return redirect()->to('/login');
    }

    /**
     * Compatibilidade com fotos legadas salvas em WRITEPATH.
     */
    public function foto($nome)
    {
        if (!is_string($nome) || !preg_match('/\Ausuario_[0-9]+_[a-f0-9]{16}\.(?:jpg|png|webp)\z/i', $nome)) {
            return $this->response->setStatusCode(404);
        }

        $diretorio = realpath(WRITEPATH . 'uploads/perfil');
        $caminho   = $diretorio === false ? false : realpath($diretorio . DIRECTORY_SEPARATOR . $nome);

        if ($caminho === false || !is_file($caminho) || dirname($caminho) !== $diretorio) {
            return redirect()->to(base_url('tema/dist/img/user2-160x160.jpg'));
        }

        $mime = mime_content_type($caminho);
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return $this->response->setStatusCode(404);
        }

        $conteudo = file_get_contents($caminho);
        if ($conteudo === false) {
            return $this->response->setStatusCode(404);
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody($conteudo);
    }
}
