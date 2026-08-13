<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;
use App\Models\InventarioModel;

class Inventario extends BaseController
{
    public function index()
    {
        $inventarioModel = new InventarioModel();
        $categoriasModel = new CategoriasModel();
        $inventoryData = $inventarioModel->getKitsWithItems();

        $data['kits'] = $inventoryData['kits'] ?? [];
        $data['extra_columns'] = $inventoryData['extra_columns'] ?? [];
        $data['categorias'] = $categoriasModel->listar();

        echo view('templates/header');
        echo view('inventario', $data);
        echo view('templates/footer');
    }

    public function salvar()
    {
        $dados = $this->request->getPost();
        $inventarioModel = new InventarioModel();

        try {
            $inventarioModel->saveKit($dados);
            return redirect()->back()->with('alert', 'successCreate');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorCreate');
        }
    }

    public function salvarMultiplo()
    {
        $dados = $this->request->getPost();
        $inventarioModel = new InventarioModel();

        try {
            $inventarioModel->saveKitMultiplo($dados);
            return redirect()->back()->with('alert', 'successCreate');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorCreate');
        }
    }

    public function editar()
    {
        $dados = $this->request->getPost();
        $inventarioModel = new InventarioModel();

        try {
            $inventarioModel->saveKit($dados);
            return redirect()->back()->with('alert', 'successEdit');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorEdit');
        }
    }

    public function editarMultiplo()
    {
        $dados = $this->request->getPost();
        $inventarioModel = new InventarioModel();

        try {
            $inventarioModel->saveKitMultiplo($dados, true);
            return redirect()->back()->with('alert', 'successEdit');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorEdit');
        }
    }

    public function excluir($idKit)
    {
        $inventarioModel = new InventarioModel();

        try {
            $inventarioModel->deleteKitItems((int) $idKit);
            return redirect()->back()->with('alert', 'successDelete');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorDelete');
        }
    }

    public function excluirMultiplo()
    {
        $ids = $this->request->getPost('id_kit') ?? [];
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back();
        }

        $inventarioModel = new InventarioModel();

        try {
            $inventarioModel->deleteKitItemsMultiplo($ids);
            return redirect()->back()->with('alert', 'successDelete');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert', 'errorDelete');
        }
    }
}
