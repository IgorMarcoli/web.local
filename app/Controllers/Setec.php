<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Setec extends BaseController
{
    public function index()
    {
    echo View('templates/header');     
    echo View('setec');
    echo View('templates/footer');
    }
}
