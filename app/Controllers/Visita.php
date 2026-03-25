<?php

namespace App\Controllers;
use App\Models\EscolasModel;
use App\Controllers\BaseController;
use App\Models\VisitasModel;

class Visita extends BaseController
{
    public function Visita()
{
    $db = \Config\Database::connect();

    $visitas = $db->query("
        SELECT v.*, e.Nome, e.Endereco
        FROM visitas v
        JOIN escolas e ON e.EscolaId = v.EscolaId
    ")->getResultArray();

    $escola_model = new EscolasModel();
    $escolas = $escola_model->findAll();

    $data = [
        'visitas' => $visitas,
        'escolas' => $escolas
    ];

    echo View('templates/header');
    echo View('visitas', $data);
    echo View('templates/footer');
}

    public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $visita_model = new VisitasModel();

        $visita_model->insert($dados);

        return redirect()->to('/visita/visita?alert=successCreate');
    }

    public function excluir($VisitaId)
    {
        $visita_model = new VisitasModel();

        $visita_model
                ->where('VisitaId', $VisitaId)
                ->delete();

        return redirect()->to('/visita/visita?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $visita_model = new VisitasModel();

        $visita_model
                ->where('VisitaId', $dados['VisitaId'])
                ->set($dados)
                ->update();

        return redirect()->to('/visita/visita?alert=successEdit');
    }
}





