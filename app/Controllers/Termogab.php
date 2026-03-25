<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupervisoresModelgab;
use App\Models\SetoresModelgab;
use App\Models\EscolasModelgab;
use App\Models\VisitasModelgab;

class Termogab extends BaseController
{
public function termogab()
{
    $visitaModel = new VisitasModelgab();
    $supModel    = new SupervisoresModelgab();
    $setorModel  = new SetoresModelgab();
    $escModel    = new EscolasModelgab();

    $data['termogabs'] = $visitaModel
        ->select('
            visitas_gab.VisitaId,
            visitas_gab.Observacoes as Processosei,
            visitas_gab.Tipo,
            visitas_gab.DataVisita as Data,

           
            supervisores.SupervisorId,
            supervisores.nome as Supervisor,

            escolas.EscolaId,
            escolas.Nome as Escola,

            setores.SetorId,
            setores.nome as Setor
        ')
        ->join('supervisores', 'supervisores.SupervisorId = visitas_gab.SupervisorId')
        ->join('escolas', 'escolas.EscolaId = visitas_gab.EscolaId')
        ->join('setores', 'setores.SetorId = supervisores.SetorId')
        ->findAll();

    $data['supervisores'] = $supModel->findAll();
    $data['setores']      = $setorModel->findAll();

    $data['escolas'] = $escModel
        ->select('EscolaId, Nome as nome, SetorId')
        ->findAll();

    echo view('templates/headergabinete');
    echo view('termogab', $data);
    echo view('templates/footer');
}


  public function cadastrar()
{
    $model = new VisitasModelgab();

    $model->insert([
        'SupervisorId' => $this->request->getPost('SupervisorId'),
        'EscolaId'     => $this->request->getPost('EscolaId'),
        'DataVisita'   => $this->request->getPost('Data'),
        'Tipo'         => $this->request->getPost('Tipo'),
        'Observacoes'  => $this->request->getPost('Observacoes')
    ]);

    return redirect()->back()->with('alert', 'successCreate');
}

    public function excluir($TermoId)
    {
    $model = new VisitasModelgab();

    $model->delete($VisitaId);

    return redirect()->back()->with('alert', 'successDelete');
    }

public function editar()
{
    $model = new VisitasModelgab();

    $model->update(
        $this->request->getPost('VisitaId'),
        [
            'SupervisorId' => $this->request->getPost('SupervisorId'),
            'EscolaId'     => $this->request->getPost('EscolaId'),
            'DataVisita'   => $this->request->getPost('Data'),
            'Tipo'         => $this->request->getPost('Tipo')
        ]
    );

    return redirect()->back()->with('alert', 'successEdit');
}


    public function buscarEscolas()
{
    $termo = $this->request->getGet('q');

    $model = new EscolasModelgab();

    $escolas = $model
        ->like('Nome', $termo)
        ->limit(10)
        ->findAll();

    return $this->response->setJSON($escolas);
}
}