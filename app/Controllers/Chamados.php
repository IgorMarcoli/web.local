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
            'feedback' => session()->getFlashdata('chamado_feedback'), 'abrirChamado' => (int) $this->request->getGet('abrir'),
            'abertos' => $model->whereIn('status', ['Aberto', 'Em atendimento', 'Aguardando'])->countAllResults(),
            'atrasados' => $model->whereIn('status', ['Aberto', 'Em atendimento', 'Aguardando'])->where('prazo <', date('Y-m-d'))->countAllResults()]);
        echo view('templates/footer');
    }

    public function criar()
    {
        if ($redirect = $this->permissao()) return $redirect;
        $d = $this->dadosPost();
        if ($d['escola'] === '' || $d['solicitante'] === '' || $d['descricao'] === '') {
            return redirect()->to('/chamados')->with('chamado_feedback', ['tipo' => 'danger', 'texto' => 'Preencha escola, solicitante e descrição.']);
        }
        $model = new ChamadoModel();
        $id = $model->insert($d);
        if (!$id) return redirect()->to('/chamados')->with('chamado_feedback', ['tipo' => 'danger', 'texto' => 'Não foi possível registrar o chamado. Confira os dados e tente novamente.']);
        $this->historico((int) $id, 'Criação', 'Chamado registrado.');
        return redirect()->to('/chamados')->with('chamado_feedback', ['tipo' => 'success', 'texto' => 'Chamado registrado com sucesso.']);
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
        if ($id < 1 || !in_array($status, $validos, true)) {
            return redirect()->to('/chamados')->with('chamado_feedback', ['tipo' => 'danger', 'texto' => 'O status enviado é inválido. Atualize a página e tente novamente.']);
        }
        if ($prazo !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $prazo)) {
            return redirect()->to('/chamados?abrir=' . $id)->with('chamado_feedback', ['tipo' => 'danger', 'texto' => 'O prazo informado não é uma data válida.']);
        }
        if (in_array($status, ['Resolvido', 'Fechado'], true) && $solucao === '') {
            return redirect()->to('/chamados?abrir=' . $id)->with('chamado_feedback', ['tipo' => 'warning', 'texto' => 'Para concluir o chamado, preencha a solução ou o resultado.']);
        }
        $model = new ChamadoModel();
        $antes = $model->find($id);
        if (!$antes) return redirect()->to('/chamados')->with('chamado_feedback', ['tipo' => 'danger', 'texto' => 'Esse chamado não foi encontrado.']);
        $db = db_connect();
        $db->transBegin();
        try {
            $atualizado = $model->update($id, ['status' => $status, 'responsavel' => $responsavel ?: null, 'prazo' => $prazo ?: null, 'solucao' => $solucao ?: null, 'updated_at' => date('Y-m-d H:i:s')]);
            if (!$atualizado || $db->transStatus() === false) throw new \RuntimeException('update_failed');
            if ($antes['status'] !== $status) $this->historico($id, 'Status', $antes['status'] . ' → ' . $status);
            if (($antes['responsavel'] ?? '') !== $responsavel) $this->historico($id, 'Responsável', $responsavel ?: 'Removido');
            if ($comentario !== '') $this->historico($id, 'Comentário', $comentario);
            if (($antes['prazo'] ?? '') !== $prazo) $this->historico($id, 'Prazo', $prazo ?: 'Removido');
            if (($antes['solucao'] ?? '') !== $solucao && $solucao !== '') $this->historico($id, 'Solução', $solucao);
            if ($db->transStatus() === false) throw new \RuntimeException('history_failed');
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Falha ao atualizar chamado {id}: {erro}; banco: {dbError}', ['id' => $id, 'erro' => $e->getMessage(), 'dbError' => json_encode($db->error())]);
            return redirect()->to('/chamados?abrir=' . $id)->with('chamado_feedback', ['tipo' => 'danger', 'texto' => 'A atualização não foi gravada. Confira os campos e a estrutura das tabelas, e tente novamente.']);
        }
        return redirect()->to('/chamados')->with('chamado_feedback', ['tipo' => 'success', 'texto' => 'Chamado atualizado com sucesso.']);
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
