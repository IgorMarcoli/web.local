<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogingabModel;

class Logingab extends BaseController
{
    public function logingab()
    {
         
        echo View('/logingab');
        
    }

    public function autenticar()
    {
        $dados = $this->request
                            ->getVar();

        $login_model = new LogingabModel();

        $login = $login_model
                        ->where('Usuario', $dados['Usuario'])
                        ->where('Senha', $dados['Senha'])
                        ->first();

        if(!empty($login))
        {
            return redirect()->to('/gabinete');
        }

        return redirect()->to('/login?alert=errorLogin');
    }
}
