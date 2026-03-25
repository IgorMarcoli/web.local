<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BancogabModel;
use App\Models\ServidoresModel;
use App\Models\SercaoModel;
use App\Models\ServicoModel;

class Bancogab extends BaseController
{
    public function Bancogab()
   {
    
       $bancoModel = new BancogabModel();
    $status = $this->request->getGet('Status');

   $bancoModel
    ->select("
        bancogabs.*,
        servidores.nome,
        servidores.ultimoNome,
        secao.nomeSecao,
        servico.nomeServico,
        COALESCE(secao.nomeSecao, servico.nomeServico, 'Não informado') as lotacao
    ")
    ->join('servidores', 'servidores.servidorID = bancogabs.servidor_id', 'left')
    ->join('secao', 'secao.SecaoId = servidores.secao', 'left')
    ->join('servico', 'servico.ServicoId = servidores.servico', 'left');

    $data['bancogabs'] = $bancoModel->findAll();

    echo view('templates/headergabinete');
    echo view('bancogab', $data);
    echo view('templates/footer');
    }

    public function cadastrar()
    {
        
         $dados = [
        'servidor_id' => $this->request->getPost('servidor_id'),
        'Data'        => $this->request->getPost('Data'),
        'Horas'       => $this->request->getPost('Horas'),
        'Status'      => 'Disponivel'
    ];

    $agendas_model = new BancogabModel();
    $agendas_model->insert($dados);

    return redirect()->to('/bancogab/bancogab?alert=successCreate');
    }

    public function excluir($BancoId)
    {
        $agenda_model = new BancogabModel();

        $agenda_model
                ->where('BancoId', $BancoId)
                ->delete();

        return redirect()->to('/bancogab/bancogab?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request
                        ->getVar();

        $agenda_model = new BancogabModel();

        $agenda_model
                ->where('BancoId', $dados['BancoId'])
                ->set($dados)
                ->update();

        return redirect()->to('/bancogab/bancogab?alert=successEdit');
    }
    public function alterarStatusBanco(){
    $banco_model = new BancogabModel(); 

    $banco_model->update( $this->request->getPost('BancoId'), 
    ['Status' => $this->request->getPost('Status')] );
    
    return "ok";
    }
    public function buscarServidores(){
        $termo = $this -> request->getGet('term');

        $model = new ServidoresModel();

$result = $model
    ->groupStart()
        ->like('nome', $termo)
        ->orLike('ultimoNome', $termo)
    ->groupEnd()
    ->findAll(10);

        return $this-> response -> setJSON($result);
    }
}