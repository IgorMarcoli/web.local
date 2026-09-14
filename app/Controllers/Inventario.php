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
            // Debug: Log dos dados recebidos
            log_message('debug', '=== EDIÇÃO MÚLTIPLA - Dados Recebidos ===');
            log_message('debug', 'id_kit: ' . json_encode($dados['id_kit'] ?? []));
            log_message('debug', 'numero_mochila: ' . json_encode($dados['numero_mochila'] ?? []));
            log_message('debug', 'categoria: ' . json_encode($dados['categoria'] ?? []));
            log_message('debug', 'items[notebook][marca_modelo]: ' . json_encode($dados['items']['notebook']['marca_modelo'] ?? []));
            log_message('debug', 'items[notebook][skip]: ' . json_encode($dados['items']['notebook']['skip'] ?? []));
            log_message('debug', 'items[mouse][skip]: ' . json_encode($dados['items']['mouse']['skip'] ?? []));
            
            $inventarioModel->saveKitMultiplo($dados, true);
            return redirect()->back()->with('alert', 'successEdit');
        } catch (\Throwable $e) {
            log_message('error', 'Erro ao editar múltiplo: ' . $e->getMessage() . ' em ' . $e->getFile() . ':' . $e->getLine());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
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
