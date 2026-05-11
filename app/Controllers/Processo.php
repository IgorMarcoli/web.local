<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\ProcessoModel;

class Processo extends BaseController
{
    public function Processo()
    {
        $processo_model = new ProcessoModel();

        $processo = $processo_model
                            ->findAll();

        $data['processos'] = $processo;
        $data['andamentos'] = [
             'PROTOCOLO',
             'AUTUACAO',
             'ANALISE',
             'INSTRUCAO',
             'PARECER',
             'DECISAO',
             'NOTIFICACAO',
             'RECURSO',
             'JULGAMENTO_RECURSO',
             'AGUARDANDO_DOCUMENTOS',
             'DEFERIDO',
             'INDEFERIDO',
             'ARQUIVAMENTO'
        ];
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
