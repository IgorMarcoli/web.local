<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
    public function login()
    {
        $dados = $this->request->getVar();
        
        $login_model = new LoginModel();
        $login_nome = $login_model -> select('Nomeuser');
            $data = [
            'loginNome' => $login_nome,
        ];

        echo View('login/login');
        
    }

    public function autenticar()
    {
    $dados = $this->request->getVar();

    $login_model = new LoginModel();

    $login = $login_model
        ->where('Usuario', $dados['Usuario'])
        ->where('Senha', $dados['Senha'])
        ->first();
if (isset($dados['foto'])) {
    session()->set('usuario_foto', $dados['foto']);
}
    if (!empty($login)) {
        // salva os dados do usuário na sessão
        session()->set([
            'usuario_id'   => $login['LoginId'], // ajuste pro nome real da PK
            'usuario_nome' => $login['Nomeuser'],
            'usuario_foto' => $login['foto'] ?? null, // ajuste pro nome real da coluna
            'logado'       => true
        ]);

        return redirect()->to(base_url('setec'));
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

    if ($this->request->getPost('Senha')) {
        $dados['Senha'] = $this->request->getPost('Senha');
    }

    // upload pro Supabase Storage
    $foto = $this->request->getFile('foto');

    
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {

        $supabaseUrl    = 'https://xzuavctadzcnihultxjh.supabase.co';
        $supabaseKey    = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh6dWF2Y3RhZHpjbmlodWx0eGpoIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3OTQyNDQ2MSwiZXhwIjoyMDk1MDAwNDYxfQ.mn7XefZw1RE-Y-EBZrsgLYG_oHKTouLKKVIECXx0zUs'; // não a anon key
        $bucket         = 'perfil'; // nome do bucket que você criar no Supabase
        $nomeFoto       = 'usuario_' . $id . '_' . time() . '.' . $foto->getExtension();
        $conteudoFoto   = file_get_contents($foto->getTempName());

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $supabaseUrl . '/storage/v1/object/' . $bucket . '/' . $nomeFoto,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $conteudoFoto,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $supabaseKey,
                'Content-Type: ' . $foto->getMimeType(),
                'x-upsert: true' // sobrescreve se já existir
            ],
        ]);

        $resposta = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($httpCode === 200 || $httpCode === 201) {
            // monta a URL pública
            $urlFoto = $supabaseUrl . '/storage/v1/object/public/' . $bucket . '/' . $nomeFoto;
            $dados['foto'] = $urlFoto;
            session()->set('usuario_foto', $urlFoto);
        } else {
            // log do erro se quiser debugar
            log_message('error', 'Supabase upload falhou: ' . $resposta);
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
