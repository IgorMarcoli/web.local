<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AtendimentogabModel;


class Atendimentogab extends BaseController
{
    public function Atendimentogab()
    {
       $atendimento_model = new AtendimentogabModel();

        $atendimentos = $atendimento_model
                            ->findAll();

        $data['atendimentos'] = $atendimentos;

        echo View('templates/headergabinete');
        echo View('atendimentogab', $data);
        echo View('templates/footer');
    }

    public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $atendimento_model = new AtendimentogabModel();

        $atendimento_model->insert($dados);

        return redirect()->to('/atendimentogab/atendimentogab?alert=successCreate');
    }

    public function excluir($AtendimentoId)
    {
        $atendimento_model = new AtendimentogabModel();

        $atendimento_model
                ->where('AtendimentoId', $AtendimentoId)
                ->delete();

        return redirect()->to('/atendimentogab/atendimentogab?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $atendimento_model = new AtendimentogabModel();

        $atendimento_model
                ->where('AtendimentoId', $dados['AtendimentoId'])
                ->set($dados)
                ->update();

        return redirect()->to('/atendimentogab/atendimentogab?alert=successEdit');
    }
}
