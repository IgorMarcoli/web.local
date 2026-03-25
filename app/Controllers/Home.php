<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index()
    {
    echo View('templates/header2');    
    echo View('login/index');
    echo View('templates/footer');
  
    }

    
}
