<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;
use App\Models\EquipamentosModel;
use App\Models\SecaoModel;
use App\Models\ServicoModel;
use App\Models\ServidoresModel;
use App\Models\SupervisoresModelGab;

class Equipamentos extends BaseController
{
    public function index()
    {
        $equipamentosModel = new EquipamentosModel();
        $categoriasModel = new CategoriasModel();
        $secaoModel      = new SecaoModel();
        $servicoModel    = new ServicoModel();
        $servidoresModel = new ServidoresModel();
        $supervisoresModel = new SupervisoresModelGab();
        $db              = \Config\Database::connect();

        $filtros = [
            'busca'     => trim((string) ($this->request->getGet('busca') ?? '')),
            'estado'    => trim((string) ($this->request->getGet('estado') ?? '')),
            'categoria' => trim((string) ($this->request->getGet('categoria') ?? '')),
            'sala'      => trim((string) ($this->request->getGet('sala') ?? '')),
        ];

        $todosItens = $equipamentosModel->listar();

        $temFiltro = ($filtros['busca'] !== '' || $filtros['estado'] !== '' || $filtros['categoria'] !== '' || $filtros['sala'] !== '');
        $data['itens'] = $temFiltro ? $equipamentosModel->listar($filtros) : $todosItens;
        $data['salas'] = $equipamentosModel->listarSalas();
        $data['categorias'] = $categoriasModel->listar();
        $data['filtros'] = $filtros;

        // Servidores e Supervisores para sugestões e modal de informações
        $sessoes  = $secaoModel->orderBy('secaoID', 'ASC')->findAll();
        $servicos = $servicoModel->orderBy('servicoId', 'ASC')->findAll();

        $secaoNomePorId = [];
        foreach ($sessoes as $s) {
            $secaoNomePorId[$s['secaoID']] = $s['nomeSecao'];
        }

        $servicoNomePorId = [];
        foreach ($servicos as $servico) {
            $servicoId = $servico['servicoId'] ?? null;
            if ($servicoId !== null) {
                $servicoNomePorId[(int) $servicoId] = $servico['nome'] ?? $servico['nomeServico'] ?? $servico['servico_nome'] ?? '';
            }
        }

        $setoresRows = $db->table('setores')->get()->getResultArray();
        $setorNomePorId = [];
        foreach ($setoresRows as $st) {
            $setorNomePorId[$st['SetorId']] = $st['nome'];
        }

        $servidores = $servidoresModel->orderBy('nome', 'ASC')->findAll();
        $servidoresFormatados = [];
        foreach ($servidores as $servidor) {
            $nomeCompleto = trim(($servidor['nome'] ?? '') . ' ' . ($servidor['ultimoNome'] ?? ''));
            if ($nomeCompleto === '') {
                continue;
            }

            $servidoresFormatados[] = [
                'id'            => $servidor['servidorID'] ?? null,
                'servidorID'    => $servidor['servidorID'] ?? null,
                'nome'          => $servidor['nome'] ?? '',
                'ultimoNome'    => $servidor['ultimoNome'] ?? '',
                'nome_completo' => $nomeCompleto,
                'ramal'         => $servidor['ramal'] ?? '',
                'secao'         => $servidor['secao'] ?? null,
                'servico'       => $servidor['servico'] ?? null,
                'secao_nome'    => $secaoNomePorId[$servidor['secao']] ?? null,
                'servico_nome'  => $servicoNomePorId[$servidor['servico']] ?? null,
                'tipo'          => 'servidor',
            ];
        }

        $supervisores = $supervisoresModel->orderBy('nome', 'ASC')->findAll();
        $supervisoresFormatados = [];
        foreach ($supervisores as $sup) {
            $nome = trim($sup['Nome'] ?? $sup['nome'] ?? '');
            if ($nome === '') {
                continue;
            }

            $supervisoresFormatados[] = [
                'id'            => $sup['SupervisorId'] ?? null,
                'nome_completo' => $nome,
                'nome'          => $nome,
                'tipo'          => 'supervisor',
                'setor_id'      => $sup['SetorId'] ?? null,
                'setor_nome'    => $setorNomePorId[$sup['SetorId'] ?? null] ?? ('Setor ' . ($sup['SetorId'] ?? '')),
                'servico_nome'  => 'Supervisão de Ensino',
            ];
        }

        $data['servidores']   = $servidoresFormatados;
        $data['supervisores'] = $supervisoresFormatados;

        // Cálculo de KPIs estatísticos
        $totalItens = count($todosItens);
        $excelenteBom = 0;
        $atencaoProblema = 0;
        $chamadosAbertos = 0;

        foreach ($todosItens as $it) {
            $st = mb_strtolower((string) ($it['estado_conservacao'] ?? ''), 'UTF-8');
            if (strpos($st, 'excelente') !== false || strpos($st, 'bom') !== false) {
                $excelenteBom++;
            } elseif (strpos($st, 'ruim') !== false || strpos($st, 'péssimo') !== false || strpos($st, 'pessimo') !== false) {
                $atencaoProblema++;
            } elseif (strpos($st, 'chamado') !== false) {
                $chamadosAbertos++;
            }
        }

        $data['stats'] = [
            'total'           => $totalItens,
            'excelenteBom'    => $excelenteBom,
            'atencaoProblema' => $atencaoProblema,
            'chamadosAbertos' => $chamadosAbertos,
        ];

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

    public function getServidorDetalhes()
    {
        $nome = trim((string) ($this->request->getGet('nome') ?? ''));
        $id = $this->request->getGet('id') ? (int) $this->request->getGet('id') : null;

        if ($nome === '' && empty($id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Parâmetro nome ou id não informado'
            ]);
        }

        $servidoresModel = new ServidoresModel();
        $secaoModel = new SecaoModel();
        $servicoModel = new ServicoModel();

        $servidor = null;
        if (!empty($id)) {
            $servidor = $servidoresModel->find($id);
        }

        $lowerNome = mb_strtolower($nome, 'UTF-8');

        if (empty($servidor) && !empty($nome)) {
            $todosServidores = $servidoresModel->findAll();
            foreach ($todosServidores as $s) {
                $nc = mb_strtolower(trim(($s['nome'] ?? '') . ' ' . ($s['ultimoNome'] ?? '')), 'UTF-8');
                $p = mb_strtolower(trim($s['nome'] ?? ''), 'UTF-8');
                $u = mb_strtolower(trim($s['ultimoNome'] ?? ''), 'UTF-8');
                if ($nc === $lowerNome || $p === $lowerNome || $u === $lowerNome || strpos($nc, $lowerNome) !== false || strpos($lowerNome, $nc) !== false) {
                    $servidor = $s;
                    break;
                }
            }
        }

        if (!empty($servidor)) {
            $secaoRow = !empty($servidor['secao']) ? $secaoModel->find($servidor['secao']) : null;
            $servicoRow = !empty($servidor['servico']) ? $servicoModel->find($servidor['servico']) : null;

            return $this->response->setJSON([
                'status' => 'success',
                'encontrado' => true,
                'tipo' => 'servidor',
                'dados' => [
                    'id' => $servidor['servidorID'] ?? '',
                    'servidorID' => $servidor['servidorID'] ?? '',
                    'nome' => $servidor['nome'] ?? '',
                    'ultimoNome' => $servidor['ultimoNome'] ?? '',
                    'nome_completo' => trim(($servidor['nome'] ?? '') . ' ' . ($servidor['ultimoNome'] ?? '')),
                    'ramal' => !empty($servidor['ramal']) ? $servidor['ramal'] : 'Não informado',
                    'secao' => $servidor['secao'] ?? '',
                    'secao_nome' => $secaoRow['nomeSecao'] ?? $secaoRow['nome'] ?? 'Não informada',
                    'servico' => $servidor['servico'] ?? '',
                    'servico_nome' => $servicoRow['nomeServico'] ?? $servicoRow['nome'] ?? 'Não informado',
                ]
            ]);
        }

        // Check if supervisor
        $supervisor = null;
        if (!empty($nome)) {
            $supervisoresModel = new SupervisoresModelGab();
            $todosSupervisores = $supervisoresModel->findAll();
            foreach ($todosSupervisores as $sup) {
                $n = mb_strtolower(trim($sup['nome'] ?? $sup['Nome'] ?? ''), 'UTF-8');
                if ($n === $lowerNome || strpos($n, $lowerNome) !== false || strpos($lowerNome, $n) !== false) {
                    $supervisor = $sup;
                    break;
                }
            }
        }

        if (!empty($supervisor)) {
            $db = \Config\Database::connect();
            $setorRow = !empty($supervisor['SetorId']) ? $db->table('setores')->where('SetorId', $supervisor['SetorId'])->get()->getRowArray() : null;

            return $this->response->setJSON([
                'status' => 'success',
                'encontrado' => true,
                'tipo' => 'supervisor',
                'dados' => [
                    'id' => $supervisor['SupervisorId'] ?? '',
                    'nome_completo' => $supervisor['nome'] ?? $supervisor['Nome'] ?? '',
                    'nome' => $supervisor['nome'] ?? $supervisor['Nome'] ?? '',
                    'ultimoNome' => '',
                    'ramal' => 'Não informado',
                    'secao' => '',
                    'secao_nome' => $setorRow['nome'] ?? ('Setor ' . ($supervisor['SetorId'] ?? '')),
                    'servico' => '',
                    'servico_nome' => 'Supervisão de Ensino',
                ]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'encontrado' => false,
            'dados' => [
                'nome_completo' => $nome,
            ]
        ]);
    }
}
