<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Manutencao extends BaseController
{
    public function index()
    {
        echo View('templates/header');
        echo View('manutencao');
        echo View('templates/footer');
    }
}
