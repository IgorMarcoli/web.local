<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Fluxos extends BaseController
{
    public function index()
    {
       echo View('templates/header');     
    echo View('fluxos');
    echo View('templates/footer');
    }
}
