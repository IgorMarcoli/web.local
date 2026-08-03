<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmprestimosModel;
use App\Models\SecaoModel;
use App\Models\ServicoModel;
use App\Models\ServidoresModel;
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

        $emprestimosAtivos = $emprestimoModel->select('numero_mochila, status_equipamento, data_devolucao')->findAll();
        $activeMochilas = [];
        foreach ($emprestimosAtivos as $emprestimoAtivo) {
            $status = $emprestimoAtivo['status_equipamento'] ?? '';
            $dataDevolucao = $emprestimoAtivo['data_devolucao'] ?? '';

            if ($status === 'chamado aberto' || $status === 'emprestado' || $this->isDevolucaoPending($dataDevolucao)) {
                $activeMochilas[] = (int) $emprestimoAtivo['numero_mochila'];
            }
        }
        $activeMochilas = array_unique($activeMochilas);

        $availableMochilas = [];
        for ($i = 0; $i <= 15; $i++) {
            if (!in_array($i, $activeMochilas, true)) {
                $availableMochilas[] = $i;
            }
        }

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

            $e['setor_display'] = $this->formatSetorDisplay($e['secao'] ?? null, $e['servico'] ?? null, $secaoNomePorId, $servicoNomePorId);
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
        $dados = $this->request->getPost();

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

    private function applySetorSelection(array &$dados)
    {
        $setorSelecionado = $dados['setor'] ?? '';

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
        $nomeRecebedor = trim((string) ($dados['nome_recebedor'] ?? ''));
        if ($nomeRecebedor === '') {
            return;
        }

        $temSecaoInformada = ($dados['secao'] ?? null) !== null && ($dados['secao'] ?? null) !== '';
        $temServicoInformado = ($dados['servico'] ?? null) !== null && ($dados['servico'] ?? null) !== '';

        if ($temSecaoInformada || $temServicoInformado) {
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

    private function formatSetorDisplay($secaoId, $servicoId, array $secaoNomePorId, array $servicoNomePorId)
    {
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
