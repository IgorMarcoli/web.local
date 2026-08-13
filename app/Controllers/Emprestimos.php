<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmprestimosModel;
use App\Models\SecaoModel;
use App\Models\ServicoModel;
use App\Models\ServidoresModel;
use App\Models\SupervisoresModelGab;
use App\Models\FieldsModel;
use CodeIgniter\I18n\Time;

class Emprestimos extends BaseController
{
    public function index()
    {
        $emprestimoModel = new EmprestimosModel();
        $secaoModel      = new SecaoModel();
        $servicoModel    = new ServicoModel();
        $servidoresModel = new ServidoresModel();

        $nomeRecebedorFiltro = $this->request->getGet('nome_recebedor');
        $nomeResponsavelFiltro = $this->request->getGet('nome_responsavel');
        $dataRecebimentoFiltro = $this->request->getGet('data_emprestimo');
        $dataDevolucaoFiltro = $this->request->getGet('data_devolucao');
        $secaoFiltro = $this->request->getGet('secao');
        $statusFiltro = $this->request->getGet('status');

        $builder = $emprestimoModel->builder();

        if ($nomeRecebedorFiltro !== null && $nomeRecebedorFiltro !== '') {
            $builder->where('nome_recebedor', $nomeRecebedorFiltro);
        }

        if ($nomeResponsavelFiltro !== null && $nomeResponsavelFiltro !== '') {
            $builder->where('nome_responsavel', $nomeResponsavelFiltro);
        }

        if ($dataRecebimentoFiltro !== null && $dataRecebimentoFiltro !== '') {
            $builder->where('DATE(data_emprestimo)', $dataRecebimentoFiltro);
        }

        if ($dataDevolucaoFiltro !== null && $dataDevolucaoFiltro !== '') {
            $builder->where('DATE(data_devolucao)', $dataDevolucaoFiltro);
        }

        if ($secaoFiltro !== null && $secaoFiltro !== '') {
            $builder->where('secao', $secaoFiltro);
        }

        if ($statusFiltro !== null && $statusFiltro !== '') {
            $builder->where('status_equipamento', $statusFiltro);
        }

        $db = \Config\Database::connect();
        $kits = $db->table('kits')
            ->select('id_kit')
            ->orderBy('id_kit', 'ASC')
            ->get()
            ->getResultArray();

        $emprestimosBase = $emprestimoModel->orderBy('data_emprestimo', 'DESC')->get()->getResultArray();
        $emprestimos = $builder->orderBy('data_emprestimo', 'DESC')->get()->getResultArray();
        $sessoes     = $secaoModel->orderBy('secaoID', 'ASC')->findAll();
        $servicos    = $servicoModel->orderBy('servicoId', 'ASC')->findAll();
        $servidores  = $servidoresModel->orderBy('nome', 'ASC')->findAll();

        $nomeRecebedores = $emprestimoModel->select('nome_recebedor')->distinct()->orderBy('nome_recebedor')->findColumn('nome_recebedor');
        $nomeResponsaveis = $emprestimoModel->select('nome_responsavel')->distinct()->orderBy('nome_responsavel')->findColumn('nome_responsavel');

        $emprestimosAtivos = $emprestimoModel->select('numero_mochila, status_equipamento')->where('status_equipamento', 'emprestado')->findAll();
        $activeKitIds = [];
        foreach ($emprestimosAtivos as $emprestimoAtivo) {
            $kitId = (int) ($emprestimoAtivo['numero_mochila'] ?? 0);
            if ($kitId > 0) {
                $activeKitIds[] = $kitId;
            }
        }
        $activeKitIds = array_unique($activeKitIds);

        $availableMochilas = [];
        foreach ($kits as $kit) {
            $kitId = (int) ($kit['id_kit'] ?? 0);
            if ($kitId <= 0) {
                continue;
            }

            if (!in_array($kitId, $activeKitIds, true)) {
                $availableMochilas[] = $kitId;
            }
        }

        sort($availableMochilas);

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

        foreach ($emprestimos as &$e) {
            if (!isset($e['id_emprestimo']) || $e['id_emprestimo'] === null || $e['id_emprestimo'] === '') {
                $e['id_emprestimo'] = $e['numero_mochila'] ?? '-';
            }

            $e['setor_display'] = $this->formatSetorDisplay($e['secao'] ?? null, $e['servico'] ?? null, $e['outro_setor'] ?? null, $secaoNomePorId, $servicoNomePorId);
            $e['duracao_emprestimo'] = $this->formatDuration($e['data_emprestimo'], $e['data_devolucao'] ?? null);
        }
        unset($e);

        $resumoMochilas = [];
        foreach ($kits as $kit) {
            $numeroMochilaInt = (int) ($kit['id_kit'] ?? 0);
            if ($numeroMochilaInt <= 0) {
                continue;
            }

            $resumoMochilas[$numeroMochilaInt] = [
                'numero' => $numeroMochilaInt,
                'status' => 'disponível para empréstimo',
                'data_emprestimo' => null,
                'data_devolucao' => null,
                'duracao_emprestimo' => '-',
            ];
        }

        $ultimoEmprestimoPorMochila = [];
        foreach ($emprestimosBase as $emprestimoBase) {
            $numeroMochila = $emprestimoBase['numero_mochila'] ?? null;
            if ($numeroMochila === null || $numeroMochila === '') {
                continue;
            }

            $numeroMochilaInt = (int) $numeroMochila;
            if (!isset($resumoMochilas[$numeroMochilaInt])) {
                continue;
            }

            $statusEquipamento = $emprestimoBase['status_equipamento'] ?? '';
            $dataDevolucao = $emprestimoBase['data_devolucao'] ?? null;
            $dataEmprestimo = $emprestimoBase['data_emprestimo'] ?? null;
            $statusAtivo = $statusEquipamento === 'emprestado' || $statusEquipamento === 'chamado aberto' || $this->isDevolucaoPending($dataDevolucao);

            if (!$statusAtivo) {
                continue;
            }

            $dataEmprestimoTimestamp = strtotime((string) $dataEmprestimo);
            $dataResumoTimestamp = $ultimoEmprestimoPorMochila[$numeroMochilaInt]['data_emprestimo_timestamp'] ?? null;

            if ($dataEmprestimoTimestamp === false || ($dataResumoTimestamp !== null && $dataEmprestimoTimestamp < $dataResumoTimestamp)) {
                continue;
            }

            $ultimoEmprestimoPorMochila[$numeroMochilaInt] = [
                'data_emprestimo' => $dataEmprestimo,
                'data_devolucao' => $dataDevolucao,
                'status' => $statusEquipamento !== '' ? $statusEquipamento : 'emprestado',
                'data_emprestimo_timestamp' => $dataEmprestimoTimestamp,
            ];
        }

        foreach ($ultimoEmprestimoPorMochila as $numeroMochilaInt => $ultimoEmprestimo) {
            $resumoMochilas[$numeroMochilaInt]['status'] = $ultimoEmprestimo['status'];
            $resumoMochilas[$numeroMochilaInt]['data_emprestimo'] = $ultimoEmprestimo['data_emprestimo'];
            $resumoMochilas[$numeroMochilaInt]['data_devolucao'] = $ultimoEmprestimo['data_devolucao'];
            $resumoMochilas[$numeroMochilaInt]['duracao_emprestimo'] = $this->formatDuration($ultimoEmprestimo['data_emprestimo'], $ultimoEmprestimo['data_devolucao']);
        }

        ksort($resumoMochilas);
        $resumoMochilas = array_values($resumoMochilas);

        $setorOptions = [];
        foreach ($sessoes as $s) {
            $setorOptions[] = [
                'value' => 'secao:' . ($s['secaoID'] ?? ''),
                'label' => ($s['nomeSecao'] ?? $s['nome'] ?? 'Seção')
            ];
        }

        foreach ($servicos as $servico) {
            $setorOptions[] = [
                'value' => 'servico:' . ($servico['servicoId'] ?? ''),
                'label' => $servico['nome'] ?? 'Serviço'
            ];
        }

        $servidoresFormatados = [];
        foreach ($servidores as $servidor) {
            $nomeCompleto = trim(($servidor['nome'] ?? '') . ' ' . ($servidor['ultimoNome'] ?? ''));
            if ($nomeCompleto === '') {
                continue;
            }

            $servidoresFormatados[] = [
                'nome_completo' => $nomeCompleto,
                'secao' => $servidor['secao'] ?? null,
                'servico' => $servidor['servico'] ?? null,
                'secao_nome' => $secaoNomePorId[$servidor['secao']] ?? null,
                'servico_nome' => $servicoNomePorId[$servidor['servico']] ?? null,
            ];
        }

        $servidoresSolicitante = $servidoresFormatados;
        $servidoresResponsavel = array_values(array_filter($servidoresFormatados, function ($servidor) {
            return ($servidor['secao'] ?? null) == 8 || ($servidor['servico'] ?? null) == 5;
        }));

        $data['emprestimos'] = $emprestimos;
        $data['resumoMochilas'] = $resumoMochilas;
        $data['sessoes']     = $sessoes;
        $data['setorOptions'] = $setorOptions;
        $data['servidores'] = $servidoresFormatados;
        // Load supervisors and field technicians to include in suggestions
        $supervisoresModel = new SupervisoresModelGab();
        $fieldsModel = new FieldsModel();

        $supervisores = $supervisoresModel->orderBy('Nome', 'ASC')->findAll();
        $fields = $fieldsModel->orderBy('nome', 'ASC')->findAll();

        $supervisoresFormatados = [];
        foreach ($supervisores as $sup) {
            $nome = trim($sup['Nome'] ?? $sup['nome'] ?? '');
            if ($nome === '') {
                continue;
            }

            $supervisoresFormatados[] = [
                'nome_completo' => $nome,
                'tipo' => 'supervisor'
            ];
        }

        $fieldsFormatados = [];
        foreach ($fields as $f) {
            $nome = trim($f['nome'] ?? $f['Nome'] ?? '');
            if ($nome === '') {
                continue;
            }

            $fieldsFormatados[] = [
                'nome_completo' => $nome,
                'tipo' => 'field'
            ];
        }

        $data['supervisoresExtras'] = $supervisoresFormatados;
        $data['fieldsExtras'] = $fieldsFormatados;
        $data['servidoresSolicitante'] = $servidoresSolicitante;
        $data['servidoresResponsavel'] = $servidoresResponsavel;
        $data['availableMochilas'] = $availableMochilas;
        $data['nomeRecebedores'] = $nomeRecebedores;
        $data['nomeResponsaveis'] = $nomeResponsaveis;
        $data['filtros']     = [
            'nome_recebedor' => $nomeRecebedorFiltro,
            'nome_responsavel' => $nomeResponsavelFiltro,
            'data_emprestimo' => $dataRecebimentoFiltro,
            'data_devolucao' => $dataDevolucaoFiltro,
            'secao'  => $secaoFiltro,
            'status' => $statusFiltro,
        ];
        $data['statusOptions'] = ['disponível para empréstimo', 'emprestado', 'chamado aberto'];

        echo view('templates/header');
        echo view('emprestimos', $data);
        echo view('templates/footer');
    }

    public function salvar()
    {
        $emprestimoModel = new EmprestimosModel();
        // Support batch insert when form fields are arrays (multiple groups)
        $post = $this->request->getPost();

        // If single record (not arrays), keep original behavior
        if (!is_array($post['numero_mochila'] ?? null)) {
            $dados = $post;

            if (!isset($dados['numero_chamado']) || ($dados['status_equipamento'] ?? '') !== 'chamado aberto' || trim((string) $dados['numero_chamado']) === '') {
                $dados['numero_chamado'] = null;
            }

            $dados['data_emprestimo'] = Time::now()->format('Y-m-d H:i:s');
            $dados['data_devolucao'] = $this->normalizeDataDevolucao($dados['data_devolucao'] ?? null);
            $this->applySetorSelection($dados);
            $this->applyServerMappingFallback($dados);
            $dados['status_equipamento'] = $this->determineStatus($dados['status_equipamento'] ?? '', $dados['data_devolucao']);

            $lastRecord = $emprestimoModel->select('MAX(id_emprestimo) as max_id')
                ->get()->getRowArray();
            $nextId = 1001;
            if (!empty($lastRecord['max_id']) && is_numeric($lastRecord['max_id'])) {
                $nextId = max(1001, (int) $lastRecord['max_id'] + 1);
            }
            $dados['id_emprestimo'] = $nextId;

            $emprestimoModel->insert($dados);

            return redirect()->back()->with('alert', 'successCreate');
        }

        // Prepare arrays (ensure indexes exist)
        $numeros = $this->request->getPost('numero_mochila') ?? [];
        $nomes = $this->request->getPost('nome_recebedor') ?? [];
        $emails = $this->request->getPost('email_recebedor') ?? [];
        $responsaveis = $this->request->getPost('nome_responsavel') ?? [];
        $statusArr = $this->request->getPost('status_equipamento') ?? [];
        $numeroChamados = $this->request->getPost('numero_chamado') ?? [];
        $setores = $this->request->getPost('setor') ?? [];
        $outros = $this->request->getPost('outro_setor') ?? [];
        $obsArr = $this->request->getPost('obs') ?? [];
        $dataDevolucaoArr = $this->request->getPost('data_devolucao') ?? [];

        $count = count($numeros);
        if ($count <= 0) {
            return redirect()->back()->with('alert', 'error');
        }

        // Shared timestamp for all inserted records
        $sharedTimestamp = Time::now()->format('Y-m-d H:i:s');

        // Determine starting id
        $lastRecord = $emprestimoModel->select('MAX(id_emprestimo) as max_id')
            ->get()->getRowArray();
        $nextId = 1001;
        if (!empty($lastRecord['max_id']) && is_numeric($lastRecord['max_id'])) {
            $nextId = max(1001, (int) $lastRecord['max_id'] + 1);
        }

        $batch = [];
        for ($i = 0; $i < $count; $i++) {
            $entry = [];
            $entry['numero_mochila'] = $numeros[$i] ?? '';
            $entry['nome_recebedor'] = $nomes[$i] ?? '';
            $entry['email_recebedor'] = $emails[$i] ?? '';
            $entry['nome_responsavel'] = $responsaveis[$i] ?? '';
            $entry['status_equipamento'] = $statusArr[$i] ?? '';
            $entry['numero_chamado'] = (isset($entry['status_equipamento']) && $entry['status_equipamento'] === 'chamado aberto' && isset($numeroChamados[$i]) && trim((string) $numeroChamados[$i]) !== '') ? $numeroChamados[$i] : null;
            $entry['data_emprestimo'] = $sharedTimestamp;
            $entry['data_devolucao'] = $this->normalizeDataDevolucao($dataDevolucaoArr[$i] ?? null);
            $entry['setor'] = $setores[$i] ?? null;
            $entry['outro_setor'] = $outros[$i] ?? '';
            $entry['obs'] = $obsArr[$i] ?? '';
            $entry['id_emprestimo'] = $nextId++;

            // Apply mapping logic per-entry
            $this->applySetorSelection($entry);
            $this->applyServerMappingFallback($entry);
            $entry['status_equipamento'] = $this->determineStatus($entry['status_equipamento'] ?? '', $entry['data_devolucao']);

            $batch[] = $entry;
        }

        if (!empty($batch)) {
            $emprestimoModel->insertBatch($batch);
        }

        return redirect()->back()->with('alert', 'successCreate');
    }

    public function editar()
    {
        $dados = $this->request->getPost();

        if (!isset($dados['numero_chamado']) || ($dados['status_equipamento'] ?? '') !== 'chamado aberto' || trim((string) $dados['numero_chamado']) === '') {
            $dados['numero_chamado'] = null;
        }

        $dados['data_devolucao'] = $this->normalizeDataDevolucao($dados['data_devolucao'] ?? null);
        $this->applySetorSelection($dados);
        $this->applyServerMappingFallback($dados);
        $dados['status_equipamento'] = $this->determineStatus($dados['status_equipamento'] ?? '', $dados['data_devolucao']);

        $emprestimoModel = new EmprestimosModel();
        $emprestimoModel->update($dados['id_emprestimo'], $dados);

        return redirect()->back()->with('alert', 'successCreate');
    }

    public function salvarDataDevolucao()
    {
        $idEmprestimo = $this->request->getPost('id_emprestimo');
        $dataDevolucao = $this->request->getPost('data_devolucao');

        if (empty($idEmprestimo) || empty($dataDevolucao)) {
            return redirect()->back();
        }

        $emprestimoModel = new EmprestimosModel();
        $emprestimoAtual = $emprestimoModel->find($idEmprestimo);

        if (empty($emprestimoAtual)) {
            return redirect()->back();
        }

        $dataDevolucaoNormalizada = $this->normalizeDataDevolucao($dataDevolucao);
        $status = $emprestimoAtual['status_equipamento'] ?? '';
        $novoStatus = $this->determineStatus($status, $dataDevolucaoNormalizada);

        $emprestimoModel->update($idEmprestimo, [
            'data_devolucao' => $dataDevolucaoNormalizada,
            'status_equipamento' => $novoStatus,
        ]);

        return redirect()->back();
    }

    public function salvarDataDevolucaoMultiplo()
    {
        $ids = $this->request->getPost('id_emprestimo') ?? [];
        $dataDevolucao = $this->request->getPost('data_devolucao');

        if (empty($ids) || empty($dataDevolucao)) {
            return redirect()->back();
        }

        $dataDevolucaoNormalizada = $this->normalizeDataDevolucao($dataDevolucao);
        $emprestimoModel = new EmprestimosModel();

        foreach ($ids as $idEmprestimo) {
            $emprestimoAtual = $emprestimoModel->find($idEmprestimo);
            if (empty($emprestimoAtual)) {
                continue;
            }

            if (! $this->isDevolucaoPending($emprestimoAtual['data_devolucao'] ?? null)) {
                // Preserve existing returns; do not overwrite already released loans.
                continue;
            }

            $status = $emprestimoAtual['status_equipamento'] ?? '';
            $novoStatus = $this->determineStatus($status, $dataDevolucaoNormalizada);

            $emprestimoModel->update($idEmprestimo, [
                'data_devolucao' => $dataDevolucaoNormalizada,
                'status_equipamento' => $novoStatus,
            ]);
        }

        return redirect()->back()->with('alert', 'successCreate');
    }

    public function excluirMultiplo()
    {
        $ids = $this->request->getPost('id_emprestimo') ?? [];

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back();
        }

        $emprestimoModel = new EmprestimosModel();
        $emprestimoModel->whereIn('id_emprestimo', $ids)->delete();

        return redirect()->back()->with('alert', 'successDelete');
    }

    public function excluir($id)
    {
        if (empty($id)) {
            return redirect()->back();
        }

        $emprestimoModel = new EmprestimosModel();
        $emprestimoModel->delete($id);

        return redirect()->back()->with('alert', 'successDelete');
    }

    public function editarMultiplo()
    {
        $ids = $this->request->getPost('id_emprestimo') ?? [];
        $numeros = $this->request->getPost('numero_mochila') ?? [];
        $nomes = $this->request->getPost('nome_recebedor') ?? [];
        $emails = $this->request->getPost('email_recebedor') ?? [];
        $responsaveis = $this->request->getPost('nome_responsavel') ?? [];
        $statusArr = $this->request->getPost('status_equipamento') ?? [];
        $numeroChamados = $this->request->getPost('numero_chamado') ?? [];
        $setores = $this->request->getPost('setor') ?? [];
        $outros = $this->request->getPost('outro_setor') ?? [];
        $obsArr = $this->request->getPost('obs') ?? [];
        $dataEmprestimoArr = $this->request->getPost('data_emprestimo') ?? [];
        $dataDevolucaoArr = $this->request->getPost('data_devolucao') ?? [];

        $count = count($ids);
        if ($count === 0) {
            return redirect()->back();
        }

        $emprestimoModel = new EmprestimosModel();

        for ($i = 0; $i < $count; $i++) {
            $idEmprestimo = $ids[$i] ?? null;
            if (empty($idEmprestimo)) {
                continue;
            }

            $dados = [
                'numero_mochila' => $numeros[$i] ?? '',
                'nome_recebedor' => $nomes[$i] ?? '',
                'email_recebedor' => $emails[$i] ?? '',
                'nome_responsavel' => $responsaveis[$i] ?? '',
                'status_equipamento' => $statusArr[$i] ?? '',
                'numero_chamado' => (isset($statusArr[$i]) && $statusArr[$i] === 'chamado aberto' && isset($numeroChamados[$i]) && trim((string) $numeroChamados[$i]) !== '') ? $numeroChamados[$i] : null,
                'data_emprestimo' => $dataEmprestimoArr[$i] ?? '',
                'data_devolucao' => $this->normalizeDataDevolucao($dataDevolucaoArr[$i] ?? null),
                'setor' => $setores[$i] ?? null,
                'outro_setor' => $outros[$i] ?? '',
                'obs' => $obsArr[$i] ?? '',
            ];

            $this->applySetorSelection($dados);
            $this->applyServerMappingFallback($dados);
            $dados['status_equipamento'] = $this->determineStatus($dados['status_equipamento'] ?? '', $dados['data_devolucao']);

            $emprestimoModel->update($idEmprestimo, $dados);
        }

        return redirect()->back()->with('alert', 'successCreate');
    }

    private function applySetorSelection(array &$dados)
    {
        $setorSelecionado = $dados['setor'] ?? '';

        // If an explicit "outro_setor" was provided (e.g. Supervisor / Field),
        // prefer it and don't attempt to map setor to secao/servico.
        if (!empty($dados['outro_setor'])) {
            $dados['secao'] = null;
            $dados['servico'] = null;
            return;
        }

        if (empty($setorSelecionado)) {
            $dados['secao'] = null;
            $dados['servico'] = null;
            return;
        }

        $secaoModel = new SecaoModel();
        $servicoModel = new ServicoModel();

        if (strpos($setorSelecionado, 'servico:') === 0) {
            $servicoId = filter_var(substr($setorSelecionado, 8), FILTER_VALIDATE_INT);
            if ($servicoId !== false && $servicoId >= 0 && $servicoModel->where('servicoId', $servicoId)->countAllResults() > 0) {
                $dados['servico'] = $servicoId;
                $dados['secao'] = null;
                return;
            }

            $dados['servico'] = null;
            $dados['secao'] = null;
            return;
        }

        if (strpos($setorSelecionado, 'secao:') === 0) {
            $secaoId = filter_var(substr($setorSelecionado, 5), FILTER_VALIDATE_INT);
            if ($secaoId !== false && $secaoId > 0 && $secaoModel->where('secaoID', $secaoId)->countAllResults() > 0) {
                $dados['secao'] = $secaoId;
                $dados['servico'] = null;
                return;
            }
        }

        $dados['secao'] = null;
        $dados['servico'] = null;
    }

    private function applyServerMappingFallback(array &$dados)
    {
        // If outro_setor is provided (e.g. Supervisor/Field selection), do not map servers to secao/servico
        if (!empty($dados['outro_setor'])) {
            return;
        }
        $nomeRecebedor = trim((string) ($dados['nome_recebedor'] ?? ''));
        if ($nomeRecebedor === '') {
            return;
        }

        $temSecaoInformada = ($dados['secao'] ?? null) !== null && ($dados['secao'] ?? null) !== '';
        $temServicoInformado = ($dados['servico'] ?? null) !== null && ($dados['servico'] ?? null) !== '';

        if ($temSecaoInformada || $temServicoInformado) {
            return;
        }

        // Check if the selected requester is a supervisor or field technician by exact name.
        $supervisoresModel = new SupervisoresModelGab();
        $lowerNomeRecebedor = mb_strtolower($nomeRecebedor, 'UTF-8');
        $supervisor = $supervisoresModel->where('LOWER(Nome)', $lowerNomeRecebedor)->first();
        if (empty($supervisor)) {
            $supervisor = $supervisoresModel->where('Nome', $nomeRecebedor)->first();
        }

        if (!empty($supervisor)) {
            $dados['outro_setor'] = 'Supervisor';
            $dados['secao'] = null;
            $dados['servico'] = null;
            return;
        }

        $fieldsModel = new FieldsModel();
        $field = $fieldsModel->where('LOWER(nome)', $lowerNomeRecebedor)->first();
        if (empty($field)) {
            $field = $fieldsModel->where('nome', $nomeRecebedor)->first();
        }

        if (!empty($field)) {
            $dados['outro_setor'] = 'Field';
            $dados['secao'] = null;
            $dados['servico'] = null;
            return;
        }

        $servidoresModel = new ServidoresModel();
        $servidor = $servidoresModel->where('nome', $nomeRecebedor)
            ->orWhere('ultimoNome', $nomeRecebedor)
            ->first();

        if (empty($servidor)) {
            $partesNome = preg_split('/\s+/', $nomeRecebedor);
            if (!empty($partesNome)) {
                $primeiroNome = $partesNome[0] ?? '';
                $ultimoNome = implode(' ', array_slice($partesNome, 1));
                $servidor = $servidoresModel->groupStart()
                    ->where('nome', $primeiroNome)
                    ->orWhere('ultimoNome', $ultimoNome)
                    ->groupEnd()
                    ->first();
            }
        }

        if (empty($servidor)) {
            return;
        }

        $secao = $servidor['secao'] ?? null;
        $servico = $servidor['servico'] ?? null;

        if ($secao !== null && $secao !== '' && $secao !== '0') {
            $dados['secao'] = (int) $secao;
            $dados['servico'] = null;
            return;
        }

        if ($servico !== null && $servico !== '') {
            $dados['servico'] = (int) $servico;
            $dados['secao'] = null;
        }
    }

    private function formatSetorDisplay($secaoId, $servicoId, $outroSetor, array $secaoNomePorId, array $servicoNomePorId)
    {
        if (!empty($outroSetor)) {
            return $outroSetor;
        }

        $hasSecao = $secaoId !== null && $secaoId !== '';
        $hasServico = $servicoId !== null && $servicoId !== '';

        if ($hasSecao) {
            return $secaoNomePorId[$secaoId] ?? ('Seção ' . $secaoId);
        }

        if ($hasServico) {
            return $servicoNomePorId[(int) $servicoId] ?? ('Serviço ' . $servicoId);
        }

        return '-';
    }

    private function normalizeDataDevolucao($dataDevolucao)
    {
        if ($dataDevolucao === null || $dataDevolucao === '' || $dataDevolucao === '0000-00-00' || $dataDevolucao === '0000-00-00 00:00:00') {
            return '0000-00-00 00:00:00';
        }

        return $dataDevolucao;
    }

    private function isDevolucaoPending($dataDevolucao)
    {
        return $dataDevolucao === null || $dataDevolucao === '' || $dataDevolucao === '0000-00-00' || $dataDevolucao === '0000-00-00 00:00:00';
    }

    private function determineStatus($statusAtual, $dataDevolucao)
    {
        if ($statusAtual === 'chamado aberto') {
            return 'chamado aberto';
        }

        return $this->isDevolucaoPending($dataDevolucao) ? 'emprestado' : 'disponível para empréstimo';
    }

    private function formatDuration($startDate, $endDate = null)
    {
        $startValue = trim((string) ($startDate ?? ''));
        if ($startValue === '' || $startValue === '-') {
            return '-';
        }

        $start = $this->buildDurationDateTime($startValue);
        if ($start === null) {
            return '-';
        }

        if ($this->isDevolucaoPending($endDate)) {
            $end = new \DateTimeImmutable('now');
        } else {
            $endValue = trim((string) $endDate);
            $end = $this->buildDurationDateTime($endValue);
            if ($end === null) {
                $end = new \DateTimeImmutable('now');
            }
        }

        if ($end < $start) {
            $end = $start;
        }

        $diffInSeconds = max(0, $end->getTimestamp() - $start->getTimestamp());
        $parts = [];

        $totalMinutes = intdiv($diffInSeconds, 60);
        $remainingSeconds = $diffInSeconds % 60;

        if ($totalMinutes >= 60) {
            $hours = intdiv($totalMinutes, 60);
            $minutes = $totalMinutes % 60;

            if ($hours > 0) {
                $parts[] = $hours . ' hora' . ($hours > 1 ? 's' : '');
            }

            if ($minutes > 0) {
                $parts[] = $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
            }
        } elseif ($totalMinutes > 0) {
            $parts[] = $totalMinutes . ' minuto' . ($totalMinutes > 1 ? 's' : '');
        } elseif ($remainingSeconds > 0) {
            return 'menos de 1 minuto';
        }

        if (empty($parts)) {
            return 'menos de 1 minuto';
        }

        return implode(' ', $parts);
    }

    private function buildDurationDateTime($value)
    {
        $value = trim((string) $value);
        if ($value === '' || $value === '-') {
            return null;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $value)) {
            return null;
        }

        [$year, $month, $day, $hour, $minute, $second] = array_map('intval', explode(' ', str_replace('-', ' ', str_replace(':', ' ', $value))));

        if ($year < 1 || $month < 1 || $month > 12 || $day < 1 || $day > 31 || $hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $second < 0 || $second > 59) {
            return null;
        }

        $daysInMonth = (int) cal_days_in_month(CAL_GREGORIAN, $month, $year);
        if ($day > $daysInMonth) {
            return null;
        }

        return new \DateTimeImmutable($value);
    }
}
