<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmprestimosModel;
use App\Models\ServidoresModel;
use App\Models\ItensModel;
use App\Models\KitsModel;

class Emprestimo extends BaseController
{
    public function index()
    {
        $emprestimoModel = new EmprestimosModel();
        $servidorModel   = new ServidoresModel();
        $itensModel = new ItensModel();
        $kitsModel = new KitsModel();
        $emprestimos = $emprestimoModel
            ->select('emprestimos.*, servidores.nome')
            ->join('servidores', 'servidores.servidorID = emprestimos.servidor_ID')
            ->findAll();

        $data['emprestimos'] = $emprestimos;
        $data['servidores']  = $servidorModel->findAll();
        $data['itens']  = $itensModel->findAll();
        $data['kits']  = $kitsModel->findAll();
        echo View('templates/header');
        echo View('emprestimo', $data);
        echo View('templates/footer');
    }


    public function novo()
    {
        $servidorModel = new ServidoresModel();
        $itemModel     = new ItensModel();
        $kitModel      = new KitsModel();

        $data['servidores'] = $servidorModel->findAll();
        $data['itens']      = $itemModel->findAll();
        $data['kits']       = $kitModel->findAll();

        echo View('templates/header');
        echo View('emprestimo/novo', $data);
        echo View('templates/footer');
    }


    public function salvar()
    {
        $emprestimoModel = new EmprestimosModel();

         $dados = $this->request
                        ->getVar();

        $emprestimoModel = new EmprestimosModel();

        $emprestimoModel->insert($dados);

        return redirect()->to('/emprestimo');
    }


    public function devolver($id)
    {
        $emprestimoModel = new EmprestimosModel();

        $emprestimoModel->update($id, [
            'data_devolucao' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/emprestimo');
    }
}