<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;
use App\Models\EquipamentosModel;

class Equipamentos extends BaseController
{
    public function index()
    {
        $equipamentosModel = new EquipamentosModel();
        $categoriasModel = new CategoriasModel();

        $data['itens'] = $equipamentosModel->listar();
        $data['salas'] = $equipamentosModel->listarSalas();
        $data['categorias'] = $categoriasModel->listar();

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

    public function salvarMultiplo()
    {
        $dados = $this->request->getPost();
        $equipamentosModel = new EquipamentosModel();

        try {
            $equipamentosModel->salvarMultiplo($dados);
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

    public function editarMultiplo()
    {
        $dados = $this->request->getPost();
        $equipamentosModel = new EquipamentosModel();

        try {
            $equipamentosModel->editarMultiplo($dados);
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

    public function excluirMultiplo()
    {
        $ids = $this->request->getPost('id_item') ?? [];
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back();
        }

        $equipamentosModel = new EquipamentosModel();

        try {
            $equipamentosModel->excluirMultiplo($ids);
            return redirect()->back()->with('alert', 'successDelete');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorDelete');
        }
    }
}
