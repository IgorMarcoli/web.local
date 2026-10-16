<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index()
    {
        if (session()->get('logado')) {
            $setor = strtoupper(trim((string)(session()->get('usuario_setor') ?? '')));
            if ($setor === 'PROTOCOLO') {
                return redirect()->to('/protocolo');
            }
            if ($setor === 'GABINETE') {
                return redirect()->to('/gabinete');
            }
            return redirect()->to('/setec');
        }

        echo View('templates/header2');    
        echo View('login/index');
        echo View('templates/footer');
    }

    
}
