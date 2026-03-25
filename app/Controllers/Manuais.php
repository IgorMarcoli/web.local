<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Manuais extends BaseController
{
    public function index()
    {
       echo View('templates/header');     
    echo View('manuais');
    echo View('templates/footer');
    }
}
