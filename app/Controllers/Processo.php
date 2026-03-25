<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ProcessoModel;

class Processo extends BaseController
{
    public function Processo()
    {
        $agendas_model = new ProcessoModel();

        $agendas = $agendas_model
                            ->findAll();

        $data['processos'] = $agendas;

        echo View('templates/headergabinete');
        echo View('processogab', $data);
        echo View('templates/footer');
    }

    public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $agendas_model = new ProcessoModel();

        $agendas_model->insert($dados);

        return redirect()->to('/processo/processo?alert=successCreate');
    }

    public function excluir($ProcessoId)
    {
        $agenda_model = new ProcessoModel();

        $agenda_model
                ->where('ProcessoId', $ProcessoId)
                ->delete();

        return redirect()->to('/processo/processo?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $agenda_model = new ProcessoModel();

        $agenda_model
                ->where('ProcessoId', $dados['ProcessoId'])
                ->set($dados)
                ->update();

        return redirect()->to('/processo/processo?alert=successEdit');
}
}
