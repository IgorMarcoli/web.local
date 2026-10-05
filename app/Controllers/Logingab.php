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
        $usuarioPostado = $this->request->getPost('Usuario');
        $senhaPostada = $this->request->getPost('Senha');
        $usuario = is_string($usuarioPostado) ? trim($usuarioPostado) : '';
        $senha = is_string($senhaPostada) ? $senhaPostada : '';
        if ($usuario === '' || $senha === '' || strlen($usuario) > 120 || strlen($senha) > 4096) {
            return redirect()->to('/logingab?alert=errorLogin');
        }
        if (!$this->loginAttemptAllowed($usuario)) {
            return redirect()->to('/logingab?alert=rateLimit');
        }

        $loginModel = new LoginModel();
        $login = $loginModel->where('Usuario', $usuario)->first();

        $senhaArmazenada = (string) ($login['Senha'] ?? '');
        $senhaValida = $login && password_verify($senha, $senhaArmazenada);
        if ($senhaValida && password_needs_rehash($senhaArmazenada, PASSWORD_DEFAULT)) {
            $loginModel->update($login['LoginId'], ['Senha' => password_hash($senha, PASSWORD_DEFAULT)]);
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

        return redirect()->to('/logingab?alert=errorLogin');
    }
}
