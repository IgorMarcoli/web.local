<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Logingab extends BaseController
{
    public function logingab()
    {
         
        echo View('/logingab');
        
    }

    public function autenticar()
    {
        $usuario = trim((string) $this->request->getPost('Usuario'));
        $senha = (string) $this->request->getPost('Senha');
        $loginModel = new LoginModel();
        $login = $loginModel->where('Usuario', $usuario)->first();

        $senhaArmazenada = (string) ($login['Senha'] ?? '');
        $senhaValida = $login && password_verify($senha, $senhaArmazenada);
        if ($login && !$senhaValida && $senhaArmazenada !== '' && hash_equals($senhaArmazenada, $senha)) {
            $loginModel->update($login['LoginId'], ['Senha' => password_hash($senha, PASSWORD_DEFAULT)]);
            $senhaValida = true;
        }

        if ($senhaValida) {
            session()->regenerate(true);
            session()->set([
                'usuario_id'    => $login['LoginId'],
                'usuario_nome'  => $login['Nomeuser'],
                'usuario_foto'  => $login['foto'] ?? null,
                'usuario_setor' => $login['setor'] ?? null,
                'logado'        => true,
            ]);
            return redirect()->to('/gabinete');
        }

        return redirect()->to('/login?alert=errorLogin');
    }
}
