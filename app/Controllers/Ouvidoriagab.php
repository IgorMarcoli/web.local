<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OuvidoriaModel;
use App\Models\EscolasModel;
class Ouvidoriagab extends BaseController
{
    public function Ouvidoriagab()
    {
         $agendas_model = new OuvidoriaModel();
    $escolaModel = new EscolasModel();

    $agendas = $agendas_model->getComEscola(); // <-- troca aqui

    $escolas = $escolaModel->findAll();
    $data = [
        'ouvidoria' => $agendas,
        'escolas' => $escolas
    ];

    echo View('templates/headergabinete');
    echo View('ouvidoria', $data);
    echo View('templates/footer');
    }

    public function cadastrar()
    {
        $dados = $this->request->getPost();
         $dados['escola_id'] = (int) $dados['escola_id'];
        $agendas_model = new OuvidoriaModel();
       
        $agendas_model->insert($dados);

        return redirect()->to('/ouvidoriagab/ouvidoriagab?alert=successCreate');
    }

    public function excluir($ouvidoria_id)
    {
        $agenda_model = new OuvidoriaModel();

        $agenda_model
                ->where('ouvidoria_id', $ouvidoria_id)
                ->delete();

        return redirect()->to('/ouvidoria/ouvidoria?alert=successDelete');
    }

    public function editar()
    {
$dados = $this->request->getPost();

        $agenda_model = new OuvidoriaModel();
         $dados['escola_id'] = (int) $dados['escola_id'];
         
        $agenda_model
                ->where('ouvidoria_id', $dados['ouvidoria_id'])
                ->set($dados)
                ->update();

        return redirect()->to('/ouvidoria/ouvidoria?alert=successEdit');
    }
}
