<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OuvidoriagabModel;

class Ouvidoriagab extends BaseController
{
    public function Ouvidoriagab()
    {
        $agendas_model = new OuvidoriagabModel();

        $agendas = $agendas_model
                            ->findAll();

        $data['ouvidoriagabs'] = $agendas;

        echo View('templates/headergabinete');
        echo View('ouvidoriagab', $data);
        echo View('templates/footer');
    }

    public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $agendas_model = new OuvidoriagabModel();

        $agendas_model->insert($dados);

        return redirect()->to('/ouvidoriagab/ouvidoriagab?alert=successCreate');
    }

    public function excluir($OuvidoriaId)
    {
        $agenda_model = new OuvidoriagabModel();

        $agenda_model
                ->where('OuvidoriaId', $OuvidoriaId)
                ->delete();

        return redirect()->to('/ouvidoriagab/ouvidoriagab?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $agenda_model = new OuvidoriagabModel();

        $agenda_model
                ->where('OuvidoriaId', $dados['OuvidoriaId'])
                ->set($dados)
                ->update();

        return redirect()->to('/ouvidoriagab/ouvidoriagab?alert=successEdit');
    }
}
