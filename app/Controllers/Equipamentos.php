<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EquipamentosModel;

class Equipamentos extends BaseController
{
    public function index()
    {
        $equipamentosModel = new EquipamentosModel();
        $data['itens'] = $equipamentosModel->listar();

        echo view('templates/header');
        echo view('equipamentos', $data);
        echo view('templates/footer');
    }

    public function salvar()
    {
        $dados = $this->request->getPost();
        $equipamentosModel = new EquipamentosModel();

        try {
            $equipamentosModel->salvar($dados);
            return redirect()->back()->with('alert', 'successCreate');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorCreate');
        }
    }

    public function editar()
    {
        $dados = $this->request->getPost();
        $equipamentosModel = new EquipamentosModel();

        try {
            $equipamentosModel->salvar($dados);
            return redirect()->back()->with('alert', 'successEdit');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorEdit');
        }
    }

    public function excluir($idItem)
    {
        $equipamentosModel = new EquipamentosModel();

        try {
            $equipamentosModel->excluir((int) $idItem);
            return redirect()->back()->with('alert', 'successDelete');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorDelete');
        }
    }
}
