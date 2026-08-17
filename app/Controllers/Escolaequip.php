<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EscolaequipModel;

class Escolaequip extends BaseController
{
    public function index()
    {
        $model = new EscolaequipModel();
        $data['items'] = $model->getAll();
        $data['stats'] = $model->getStatistics();

        echo View('templates/header');
        echo View('escolaequip', $data);
        echo View('templates/footer');
    }
}
