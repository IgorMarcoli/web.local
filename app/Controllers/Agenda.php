<?php

namespace App\Controllers;

use App\Models\EscolasModel;
use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\FieldsModel;

class Agenda extends BaseController
{
    public function agenda()
    {
        $agendas_model = new AgendaModel();
        $fields = new FieldsModel();
        $nomeFields = $fields->findAll();
        $status  = $this->request->getGet('status');
        $periodo = $this->request->getGet('periodo');
        $mes     = $this->request->getGet('mes') ?? date('m');
        $ano     = $this->request->getGet('ano') ?? date('Y');

    $query = $agendas_model;
    
        if ($periodo !== null && $periodo !== 'todos') {
        $query = $query
            ->where('EXTRACT(MONTH FROM "Data") =', $mes)
            ->where('EXTRACT(YEAR FROM "Data") =', $ano);
    }
              if ($status) {
        $query->where('status', $status);
    }

    $agendas = $query->orderBy('Data', 'DESC')->findAll();

    $escola_model = new EscolasModel();
    $escolas = $escola_model->findAll();

    $totalGeral = count($agendas);
    $totalConcluido = 0;
    $totalPendente = 0;
    $totalEmAtendimento = 0;

    foreach ($agendas as $itemAg) {
        $stAg = mb_strtolower(trim($itemAg['status'] ?? ''), 'UTF-8');
        if ($stAg === 'concluido' || $stAg === 'concluído') {
            $totalConcluido++;
        } elseif ($stAg === 'pendente') {
            $totalPendente++;
        } elseif ($stAg === 'Em_atendimento') {
            $totalEmAtendimento++;
        }
    }

    $data = [
        'agendas'     => $agendas,
        'escolas'     => $escolas,
        'mesAtual'    => $mes,
        'anoAtual'    => $ano,
        'statusAtual' => $status,
        'periodoAtual'=> $periodo,
        'statsAgenda' => [
            'total'         => $totalGeral,
            'concluido'     => $totalConcluido,
            'pendente'      => $totalPendente,
            'emAtendimento' => $totalEmAtendimento,
        ]
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

       return redirect()->to('/agenda/agenda?alert=successCreate');
    }

    public function excluir($AgendaId)
    {
        $agenda_model = new AgendaModel();

        $agenda_model
                ->where('AgendaId', $AgendaId)
                ->delete();

        return redirect()->to('/agenda/agenda?alert=successDelete');
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

