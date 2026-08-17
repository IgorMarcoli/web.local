<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Escoladash extends BaseController
{
    public function index()
    {
        echo View('templates/header');
        echo View('escoladash');
        echo View('templates/footer');
    }
}
