<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendagabModel;

class Agendagab extends BaseController
{
    public function Agendagab()
    {
     

        $agendas_model = new AgendagabModel();

        $agendas = $agendas_model
                            ->findAll();

        $data['agendagabs'] = $agendas;

        echo View('templates/headergabinete');
        echo View('agendagab', $data);
        echo View('templates/footer');
    }

    public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $agendas_model = new AgendagabModel();

        $agendas_model->insert($dados);

        return redirect()->to('/agendagab/agendagab?alert=successCreate');
    }

    public function excluir($AgendaId)
    {
        $agenda_model = new AgendagabModel();

        $agenda_model
                ->where('AgendaId', $AgendaId)
                ->delete();

        return redirect()->to('/agendagab/agendagab?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $agenda_model = new AgendagabModel();

        $agenda_model
                ->where('AgendaId', $dados['AgendaId'])
                ->set($dados)
                ->update();

        return redirect()->to('/agendagab/agendagab?alert=successEdit');
    }
}

