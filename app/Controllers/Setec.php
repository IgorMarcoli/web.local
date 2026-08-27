<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Controllers\BaseController;

class Setec extends BaseController
{
    public function index()
    {
   $dados = $this->request->getVar();
        
        $login_model = new LoginModel();
        $login_nome = $login_model -> select('Nomeuser');
        $data = [
            'loginNome' => $login_nome,
        ];
    echo View('templates/header');     
    echo View('setec', $data);
    echo View('templates/footer');
    }
}
