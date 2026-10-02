<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
    public function login()
    {
        return view('login/login');
        
    }

    public function autenticar()
    {
        $usuarioDigitado = trim((string) $this->request->getPost('Usuario'));
        $senhaDigitada = (string) $this->request->getPost('Senha');

        $login_model = new LoginModel();

        // Busca o usuário pelo nome de usuário
        $login = $login_model
            ->where('Usuario', $usuarioDigitado)
            ->first();

        $senhaValida = false;
        if (!empty($login)) {
            $senhaArmazenada = (string) ($login['Senha'] ?? '');
            if (password_verify($senhaDigitada, $senhaArmazenada)) {
                $senhaValida = true;
            } elseif ($senhaArmazenada !== '' && hash_equals($senhaArmazenada, $senhaDigitada)) {
                // Migra senhas legadas para hash após um login válido.
                $login_model->update($login['LoginId'], [
                    'Senha' => password_hash($senhaDigitada, PASSWORD_DEFAULT),
                ]);
                $senhaValida = true;
            }
        }

        if ($senhaValida) {
            session()->regenerate(true);

            // salva os dados do usuário na sessão
            session()->set([
                'usuario_id'    => $login['LoginId'], // ajuste pro nome real da PK
                'usuario_nome'  => $login['Nomeuser'],
                'usuario_foto'  => $login['foto'] ?? null, // ajuste pro nome real da coluna
                'usuario_setor' => $login['setor'] ?? null,
                'logado'        => true
            ]);

            return redirect()->to('/setec');
        }

        return redirect()->to('/login?alert=errorLogin');
    }
    public function perfil()
{
$login_model = new LoginModel();
    $usuario = $login_model->find(session()->get('usuario_id'));

    $data = ['usuario' => $usuario];

    echo View('templates/header');
    echo View('login/perfil', $data);
    echo View('templates/footer');
}

public function atualizarPerfil()
{
  $login_model = new LoginModel();
    $id = session()->get('usuario_id');
    $dados = [];

    if ($this->request->getPost('Nomeuser')) {
        $dados['Nomeuser'] = $this->request->getPost('Nomeuser');
    }

    $novaSenha = $this->request->getPost('Senha');
    if (!empty($novaSenha)) {
        // Criptografa a nova senha com hash seguro antes de gravar no banco de dados
        $dados['Senha'] = password_hash($novaSenha, PASSWORD_DEFAULT);
    }

    // upload pro Supabase Storage
    $foto = $this->request->getFile('foto');

    
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $mimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        $mimeType = $foto->getMimeType();
        $supabaseUrl = rtrim((string) env('supabase.url', ''), '/');
        $supabaseKey = (string) env('supabase.serviceKey', '');
        $bucket = (string) env('supabase.profileBucket', 'perfil');

        if (!isset($mimeTypes[$mimeType]) || $foto->getSize() > 2 * 1024 * 1024) {
            return redirect()->to('/perfil?alert=arquivoInvalido');
        }
        if ($supabaseUrl === '' || $supabaseKey === '') {
            log_message('error', 'Upload de perfil não configurado: faltam variáveis do Supabase.');
            return redirect()->to('/perfil?alert=uploadIndisponivel');
        }

        $nomeFoto = 'usuario_' . (int) $id . '_' . bin2hex(random_bytes(8)) . '.' . $mimeTypes[$mimeType];
        $conteudoFoto = file_get_contents($foto->getTempName());

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $supabaseUrl . '/storage/v1/object/' . rawurlencode($bucket) . '/' . rawurlencode($nomeFoto),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $conteudoFoto,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $supabaseKey,
                'Content-Type: ' . $mimeType,
                'x-upsert: false'
            ],
        ]);

        $resposta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($httpCode === 200 || $httpCode === 201) {
            // monta a URL pública
            $urlFoto = $supabaseUrl . '/storage/v1/object/public/' . rawurlencode($bucket) . '/' . rawurlencode($nomeFoto);
            $dados['foto'] = $urlFoto;
            session()->set('usuario_foto', $urlFoto);
        } else {
            // log do erro se quiser debugar
            log_message('error', 'Upload de perfil falhou no Supabase (HTTP {code}).', ['code' => $httpCode]);
        }
    }

    if (!empty($dados)) {
        $login_model->update($id, $dados);

        if (isset($dados['Nomeuser'])) {
            session()->set('usuario_nome', $dados['Nomeuser']);
        }
    }

    return redirect()->to('/perfil?alert=success');
}

public function sair()
{
    if (!$this->request->is('post')) {
        return $this->response->setStatusCode(405);
    }
    setcookie('usuario_salvo', '', time() - 3600, '/');
    session()->destroy();
    return redirect()->to('/login');
}

// serve a foto de perfil salva em WRITEPATH (fora do public)
public function foto($nome)
{
    $caminho = WRITEPATH . 'uploads/perfil/' . $nome;

    if (!file_exists($caminho)) {
        // retorna imagem padrão se não tiver foto
        return redirect()->to(base_url('tema/dist/img/user2-160x160.jpg'));
    }

    $mime = mime_content_type($caminho);
    return $this->response
        ->setHeader('Content-Type', $mime)
        ->setBody(file_get_contents($caminho));
}
}
