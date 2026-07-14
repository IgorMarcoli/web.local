<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NovaModel;
use App\Models\EscolasModel;

class Nova extends BaseController {
    public function index() {
        return $this->Nova();
    }

    public function Nova() {
        $model = new NovaModel();
        $escolasModel = new EscolasModel();

        $processos = $model->findAll();
        $escolas = $escolasModel->orderBy('Nome', 'ASC')->findAll();

        $escolaIdPorNome = [];
        foreach ($escolas as $escola) {
            $escolaIdPorNome[$escola['Nome']] = $escola['EscolaId'];
        }

        foreach ($processos as &$processo) {
            $dadosEscola = $model->normalizeEscolaData($processo['escola'] ?? '', $escolas);
            $processo['nomeEscola'] = $dadosEscola['escola'];
            $processo['escolaId'] = $dadosEscola['escolaId'];
        }

        $data['items'] = $processos;
        $data['escolas'] = $escolas;

        echo view('templates/headergabinete');
        echo view('nova', $data);
        echo view('templates/footer');
    }

    public function cadastrar() {
        $dados = $this->request->getPost();
        $escolasModel = new EscolasModel();
        $model = new NovaModel();

        if (!empty($dados['escola'])) {
            $dados['escola'] = $model->normalizeEscolaData($dados['escola'], $escolasModel->findAll())['escola'];
        }

        if (empty($dados['numeroSEI'])) {
            return redirect()->to('/nova/nova?alert=errorMissingSei');
        }

        $model->insert($dados);

        return redirect()->to('/nova/nova?alert=successCreate');
    }

    public function editar() {
        $dados = $this->request->getPost();
        $escolasModel = new EscolasModel();
        $model = new NovaModel();

        if (!empty($dados['escola'])) {
            $dados['escola'] = $model->normalizeEscolaData($dados['escola'], $escolasModel->findAll())['escola'];
        }

        if (empty($dados['numeroSEI'])) {
            return redirect()->to('/nova/nova?alert=errorMissingSei');
        }

        $model->where('numeroSEI', $dados['numeroSEI'])->set($dados)->update();

        return redirect()->to('/nova/nova?alert=successEdit');
    }

    public function excluir($numeroSEI) {
        $model = new NovaModel();
        if (!empty($numeroSEI)) {
            $model->where('numeroSEI', $numeroSEI)->delete();
        }

        return redirect()->to('/nova/nova?alert=successDelete');
    }
}