<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Gabinete extends BaseController
{
    public function index()
    {
    echo View('templates/headergabinete');     
    echo View('gabinete');
    echo View('templates/footer');
    }
}
