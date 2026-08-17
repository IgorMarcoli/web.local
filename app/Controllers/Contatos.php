<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Contatos extends BaseController
{
    public function index()
    {
        echo View('templates/header');
        echo View('contatos');
        echo View('templates/footer');
    }
}
