<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BancogabModel;
use App\Models\ServidoresModel;
use App\Models\SupervisoresModel;
use App\Models\SupervisoresModelgab;

class Bancogab extends BaseController
{
    public function Bancogab()
    {
        $bancoModel = new BancogabModel();
        $status = $this->request->getGet('Status');

        $bancoModel
            ->select("
                bancogabs.*,

                servidores.nome AS nome_servidor,
                servidores.ultimoNome AS sobrenome_servidor,

                supervisores.nome AS nome_supervisor
            ")
            ->join('servidores', 'servidores.servidorID = bancogabs.servidor_id', 'left')
            ->join('supervisores', 'supervisores.SupervisorId = bancogabs.supervisor_id', 'left');

        if ($status) {
            $bancoModel->where('bancogabs.Status', $status);
        }

        $bancoModel->orderBy('bancogabs.Data', 'DESC');

        $registros = $bancoModel->findAll();

        foreach ($registros as &$registro) {
            if (!empty($registro['nome_servidor'])) {
                $registro['nome_exibicao'] = trim($registro['nome_servidor'] . ' ' . ($registro['sobrenome_servidor'] ?? ''));
                $registro['tipo_pessoa'] = 'Servidor';
            } elseif (!empty($registro['nome_supervisor'])) {
                $registro['nome_exibicao'] = $registro['nome_supervisor'];
                $registro['tipo_pessoa'] = 'Supervisor';
            } else {
                $registro['nome_exibicao'] = 'Não informado';
                $registro['tipo_pessoa'] = '';
            }

            // ajuste depois se quiser puxar setor/serviço real de cada tabela
            $registro['lotacao'] = $registro['tipo_pessoa'];
        }

        $data['bancogabs'] = $registros;

        echo view('templates/headergabinete');
        echo view('bancogab', $data);
        echo view('templates/footer');
    }

    public function cadastrar()
    {
        $dados = [
            'servidor_id'   => $this->request->getPost('servidor_id') ?: null,
            'supervisor_id' => $this->request->getPost('supervisor_id') ?: null,
            'Data'          => $this->request->getPost('Data'),
            'Horas'         => $this->request->getPost('Horas'),
            'Status'        => 'Disponivel'
        ];

        if (empty($dados['servidor_id']) && empty($dados['supervisor_id'])) {
            return redirect()->to('/bancogab/bancogab?alert=errorPessoa');
        }

        $bancoModel = new BancogabModel();
        $bancoModel->insert($dados);

        return redirect()->to('/bancogab/bancogab?alert=successCreate');
    }

    public function editar()
    {
        $dados = [
            'BancoId'       => $this->request->getPost('BancoId'),
            'servidor_id'   => $this->request->getPost('servidor_id') ?: null,
            'supervisor_id' => $this->request->getPost('supervisor_id') ?: null,
            'Data'          => $this->request->getPost('Data'),
            'Horas'         => $this->request->getPost('Horas'),
            'Status'        => $this->request->getPost('Status')
        ];

        $bancoModel = new BancogabModel();

        $bancoModel
            ->where('BancoId', $dados['BancoId'])
            ->set($dados)
            ->update();

        return redirect()->to('/bancogab/bancogab?alert=successEdit');
    }

    public function excluir($BancoId)
    {
        $bancoModel = new BancogabModel();

        $bancoModel
            ->where('BancoId', $BancoId)
            ->delete();

        return redirect()->to('/bancogab/bancogab?alert=successDelete');
    }

    public function alterarStatusBanco()
    {
        $bancoModel = new BancogabModel();

        $bancoModel->update(
            $this->request->getPost('BancoId'),
            ['Status' => $this->request->getPost('Status')]
        );

        return "ok";
    }

    public function buscarPessoas()
    {
        $termo = $this->request->getGet('term');

        if (!$termo) {
            return $this->response->setJSON([]);
        }

        $servidoresModel = new ServidoresModel();
        $supervisoresModel = new SupervisoresModelgab();

        $servidores = $servidoresModel
            ->select("
                'servidor' AS tipo,
                servidorID AS id,
                nome,
                ultimoNome
            ")
            ->groupStart()
                ->like('nome', $termo)
                ->orLike('ultimoNome', $termo)
            ->groupEnd()
            ->findAll(10);

        $supervisores = $supervisoresModel
            ->select("
                'supervisor' AS tipo,
                SupervisorId AS id,
                nome
            ")
            ->like('nome', $termo)
            ->findAll(10);

        $resultado = [];

        foreach ($servidores as $s) {
            $resultado[] = [
                'tipo' => 'servidor',
                'id' => $s['id'],
                'nome' => $s['nome'],
                'ultimoNome' => $s['ultimoNome'] ?? '',
                'lotacao' => 'Servidor'
            ];
        }

        foreach ($supervisores as $s) {
            $resultado[] = [
                'tipo' => 'supervisor',
                'id' => $s['id'],
                'nome' => $s['nome'],
                'ultimoNome' => '',
                'lotacao' => 'Supervisor'
            ];
        }

        return $this->response->setJSON($resultado);
    }
}