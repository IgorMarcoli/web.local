<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Proatis extends BaseController
{
    public function index()
    {
        echo View('templates/header');
        echo View('proatis');
        echo View('templates/footer');
    }
}
