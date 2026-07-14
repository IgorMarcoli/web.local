<?php

namespace App\Controllers;

use App\Models\EscolasModel;
use App\Controllers\BaseController;
use App\Models\AgendaModel;

class Agenda extends BaseController
{
    public function Agenda()
    {
        $agendas_model = new AgendaModel();

        $status  = $this->request->getGet('status');
        $periodo = $this->request->getGet('periodo');
        $mes     = $this->request->getGet('mes') ?? date('m');
        $ano     = $this->request->getGet('ano') ?? date('Y');

    $query = $agendas_model;
    
        if ($periodo !== null && $periodo !== 'todos') {
        $query = $query
            ->where('MONTH(Data)', $mes)
            ->where('YEAR(Data)', $ano);
    }
              if ($status) {
        $query->where('status', $status);
    }

    $agendas = $query->orderBy('Data', 'DESC')->findAll();

    $escola_model = new EscolasModel();
    $escolas = $escola_model->findAll();

    $data = [
        'agendas'     => $agendas,
        'escolas'     => $escolas,
        'mesAtual'    => $mes,
        'anoAtual'    => $ano,
        'statusAtual' => $status,
        'periodoAtual'=> $periodo
    ];

    echo View('templates/header');
    echo View('agendas', $data);
    echo View('templates/footer');

    }

    public function cadastrar()
    {
        $dados = $this->request
                        ->getVar();

        $agendas_model = new AgendaModel();

        $agendas_model->insert($dados);

        return redirect()->back()->with('alert', 'successCreate');
    }

    public function excluir($AgendaId)
    {
        $agenda_model = new AgendaModel();

        $agenda_model
                ->where('AgendaId', $AgendaId)
                ->delete();

        return redirect()->back()->with('alert', 'successCreate');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $agenda_model = new AgendaModel();

        $agenda_model
                ->where('AgendaId', $dados['AgendaId'])
                ->set($dados)
                ->update();

        return redirect()->to('/agenda/agenda?alert=successEdit');
    }

    public function alterarStatus(){
    $agenda_model = new AgendaModel(); 

    $agenda_model->update( $this->request->getPost('AgendaId'), 

    ['status' => $this->request->getPost('status')] );
    
    return "ok";
    }

    public function json()
{
    $agenda_model = new AgendaModel();
    $agendas = $agenda_model->findAll();

    $eventos = [];

    foreach ($agendas as $a) {

    switch ($a['status']) {
            case 'concluido':
                $cor = '#28a745'; // verde
                break;

            case 'pendente':
                $cor = '#ffc107'; // amarelo
                break;

            case 'Em atendimento':
                $cor = '#dc3545'; // vermelho
                break;

            default:
                $cor = '#007bff'; // azul padrão
        }
        $eventos[] = [
    'id'    => $a['AgendaId'],
    'title' => $a['Nomelocal'],
    'start' => $a['Data'],
    'color' => $a['status']
];
    }

    return $this->response->setJSON($eventos);
}
}

