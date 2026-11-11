<?php

namespace App\Controllers;

use App\Models\ChamadoModel;

class Chamados extends BaseController
{
    public function index()
    {
        if ($redirect = $this->permissao()) return $redirect;
        $model = new ChamadoModel();
        $status = trim((string) $this->request->getGet('status'));
        $busca = trim((string) $this->request->getGet('busca'));
        $query = $model;
        if ($status !== '' && $status !== 'Todos') $query->where('status', $status);
        if ($busca !== '') $query->groupStart()->like('numero', $busca)->orLike('escola', $busca)->orLike('solicitante', $busca)->orLike('categoria', $busca)->groupEnd();
        $chamados = $query->orderBy('created_at', 'DESC')->findAll();
        $historicos = [];
        if ($chamados) {
            $ids = array_column($chamados, 'id');
            $historicos = db_connect()->table('chamados_historico')->whereIn('chamado_id', $ids)->orderBy('created_at', 'ASC')->get()->getResultArray();
        }
        echo view('templates/header');
        echo view('chamados/index', ['chamados' => $chamados, 'historicos' => $historicos, 'statusFiltro' => $status, 'busca' => $busca,
            'abertos' => $model->whereIn('status', ['Aberto', 'Em atendimento', 'Aguardando'])->countAllResults(),
            'atrasados' => $model->whereIn('status', ['Aberto', 'Em atendimento', 'Aguardando'])->where('prazo <', date('Y-m-d'))->countAllResults()]);
        echo view('templates/footer');
    }

    public function criar()
    {
        if ($redirect = $this->permissao()) return $redirect;
        $d = $this->dadosPost();
        if ($d['escola'] === '' || $d['solicitante'] === '' || $d['descricao'] === '') return redirect()->back()->withInput()->with('alert', 'errorValidation');
        $model = new ChamadoModel();
        $id = $model->insert($d);
        if ($id) $this->historico((int) $id, 'Criação', 'Chamado registrado.');
        return redirect()->to('/chamados?alert=successCreate');
    }

    public function atualizar()
    {
        if ($redirect = $this->permissao()) return $redirect;
        $id = (int) $this->request->getPost('id');
        $status = trim((string) $this->request->getPost('status'));
        $responsavel = trim((string) $this->request->getPost('responsavel'));
        $solucao = trim((string) $this->request->getPost('solucao'));
        $comentario = trim((string) $this->request->getPost('comentario'));
        $prazo = trim((string) $this->request->getPost('prazo'));
        $validos = ['Aberto', 'Em atendimento', 'Aguardando', 'Resolvido', 'Fechado'];
        if ($id < 1 || !in_array($status, $validos, true)) return redirect()->to('/chamados?alert=errorValidation');
        if (in_array($status, ['Resolvido', 'Fechado'], true) && $solucao === '') return redirect()->to('/chamados?alert=errorSolution');
        $model = new ChamadoModel();
        $antes = $model->find($id);
        if (!$antes) return redirect()->to('/chamados?alert=errorNotFound');
        $model->update($id, ['status' => $status, 'responsavel' => $responsavel ?: null, 'prazo' => $prazo ?: null, 'solucao' => $solucao ?: null, 'updated_at' => date('Y-m-d H:i:s')]);
        if ($antes['status'] !== $status) $this->historico($id, 'Status', $antes['status'] . ' → ' . $status);
        if (($antes['responsavel'] ?? '') !== $responsavel) $this->historico($id, 'Responsável', $responsavel ?: 'Removido');
        if ($comentario !== '') $this->historico($id, 'Comentário', $comentario);
        if (($antes['prazo'] ?? '') !== $prazo) $this->historico($id, 'Prazo', $prazo ?: 'Removido');
        if (($antes['solucao'] ?? '') !== $solucao && $solucao !== '') $this->historico($id, 'Solução', $solucao);
        return redirect()->to('/chamados?alert=successEdit');
    }

    private function dadosPost(): array
    {
        $prioridade = trim((string) $this->request->getPost('prioridade'));
        if (!in_array($prioridade, ['Baixa', 'Normal', 'Alta', 'Crítica'], true)) $prioridade = 'Normal';
        return ['numero' => 'CH-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(2))), 'escola' => trim((string) $this->request->getPost('escola')),
            'solicitante' => trim((string) $this->request->getPost('solicitante')), 'contato' => trim((string) $this->request->getPost('contato')) ?: null,
            'categoria' => trim((string) $this->request->getPost('categoria')) ?: 'Geral', 'prioridade' => $prioridade,
            'descricao' => trim((string) $this->request->getPost('descricao')), 'status' => 'Aberto',
            'responsavel' => trim((string) $this->request->getPost('responsavel')) ?: null, 'prazo' => trim((string) $this->request->getPost('prazo')) ?: null,
            'criado_por' => (string) (session()->get('usuario_nome') ?? 'Usuário'), 'created_at' => date('Y-m-d H:i:s')];
    }

    private function historico(int $id, string $tipo, string $detalhe): void
    {
        db_connect()->table('chamados_historico')->insert(['chamado_id' => $id, 'autor' => (string) (session()->get('usuario_nome') ?? 'Usuário'), 'tipo' => $tipo, 'detalhe' => $detalhe, 'created_at' => date('Y-m-d H:i:s')]);
    }

    private function permissao()
    {
        $setor = strtoupper(trim((string) session()->get('usuario_setor')));
        if (!in_array($setor, ['SEINTEC', 'SETEC'], true)) return redirect()->to('/setec?alert=acessoNegado');
        return null;
    }
}
