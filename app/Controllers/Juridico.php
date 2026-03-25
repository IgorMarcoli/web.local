<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JuridicoModel;

class Juridico extends BaseController
{
    public function Juridico()
    {
        $agendas_model = new JuridicoModel();

        $agendas = $agendas_model
                            ->findAll();

        $data['juridicos'] = $agendas;

      echo View('templates/headergabinete');    
      echo View('juridicogab', $data);
      echo View('templates/footer');
    }

     public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $agendas_model = new JuridicoModel();

        $agendas_model->insert($dados);

        return redirect()->to('/juridico/juridico?alert=successCreate');
    }

    public function excluir($juridicoId)
    {
        $agenda_model = new JuridicoModel();

        $agenda_model
                ->where('juridicoId', $juridicoId)
                ->delete();

        return redirect()->to('/juridico/juridico?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $agenda_model = new JuridicoModel();

        $agenda_model
                ->where('juridicoId', $dados['juridicoId'])
                ->set($dados)
                ->update();

        return redirect()->to('/juridico/juridico?alert=successEdit');
}
}
