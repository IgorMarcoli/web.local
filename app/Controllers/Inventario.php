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
}
