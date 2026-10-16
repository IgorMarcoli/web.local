<?php

namespace App\Controllers;

use App\Models\AtendimentoProtocoloModel;

class Protocolo extends BaseController
{
    /**
     * Valida se o usuário tem permissão de acesso ao setor PROTOCOLO.
     */
    private function checarPermissaoProtocolo()
    {
        $setor = strtoupper(trim((string)(session()->get('usuario_setor') ?? '')));
        if ($setor !== 'PROTOCOLO') {
            $destino = ($setor === 'GABINETE') ? '/gabinete' : '/setec';
            return redirect()->to($destino . '?alert=acessoNegado');
        }
        return null;
    }

    /**
     * Painel de Boas-Vindas e Gestão de Atendimentos do Protocolo.
     */
    public function index()
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $model = new AtendimentoProtocoloModel();

        // Filtros de busca
        $busca  = trim((string)$this->request->getGet('busca'));
        $status = trim((string)$this->request->getGet('status'));
        $data   = trim((string)$this->request->getGet('data'));

        $builder = $model->orderBy('id', 'DESC');

        if ($busca !== '') {
            $builder->groupStart()
                ->like('numero_protocolo', $busca)
                ->orLike('nome_solicitante', $busca)
                ->orLike('documento', $busca)
                ->orLike('assunto', $busca)
                ->orLike('setor_destino', $busca)
                ->groupEnd();
        }

        if ($status !== '' && $status !== 'todos') {
            $builder->where('status', $status);
        }

        if ($data !== '') {
            $builder->like('data_atendimento', $data);
        }

        $atendimentos = $builder->findAll();
        $stats = $model->getEstatisticas();
        $proximoProtocolo = $model->gerarNumeroProtocolo();

        $dados = [
            'atendimentos'      => $atendimentos,
            'stats'             => $stats,
            'proximoProtocolo'  => $proximoProtocolo,
            'busca'             => $busca,
            'statusFiltro'      => $status,
            'dataFiltro'        => $data,
            'usuarioNome'       => session()->get('usuario_nome') ?? 'Colaborador',
            'usuarioSetor'      => session()->get('usuario_setor') ?? 'PROTOCOLO',
        ];

        echo view('templates/header');
        echo view('protocolo/index', $dados);
        echo view('templates/footer');
    }

    /**
     * Registra um novo atendimento no Protocolo.
     */
    public function cadastrar()
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $model = new AtendimentoProtocoloModel();

        $numeroProtocolo = trim((string)$this->request->getPost('numero_protocolo'));
        if ($numeroProtocolo === '') {
            $numeroProtocolo = $model->gerarNumeroProtocolo();
        }

        $dataAtendimento = trim((string)$this->request->getPost('data_atendimento'));
        if ($dataAtendimento === '') {
            $dataAtendimento = date('d/m/Y H:i');
        }

        $atendidoPor = trim((string)$this->request->getPost('atendido_por'));
        if ($atendidoPor === '') {
            $atendidoPor = (string)(session()->get('usuario_nome') ?? 'Protocolo');
        }

        $dados = [
            'numero_protocolo' => $numeroProtocolo,
            'nome_solicitante' => trim((string)$this->request->getPost('nome_solicitante')),
            'documento'        => trim((string)$this->request->getPost('documento')),
            'telefone'         => trim((string)$this->request->getPost('telefone')),
            'email'            => trim((string)$this->request->getPost('email')),
            'assunto'          => trim((string)$this->request->getPost('assunto')),
            'setor_destino'    => trim((string)$this->request->getPost('setor_destino')),
            'descricao'        => trim((string)$this->request->getPost('descricao')),
            'atendido_por'     => $atendidoPor,
            'status'           => trim((string)$this->request->getPost('status')) ?: 'Pendente',
            'data_atendimento' => $dataAtendimento,
        ];

        if ($dados['nome_solicitante'] === '' || $dados['assunto'] === '') {
            return redirect()->to('/protocolo?alert=errorValidation');
        }

        $model->insert($dados);

        return redirect()->to('/protocolo?alert=successCreate');
    }

    /**
     * Atualiza um atendimento existente.
     */
    public function editar()
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $id = (int)$this->request->getPost('id');
        if ($id <= 0) {
            return redirect()->to('/protocolo?alert=errorNotFound');
        }

        $model = new AtendimentoProtocoloModel();

        $dados = [
            'nome_solicitante' => trim((string)$this->request->getPost('nome_solicitante')),
            'documento'        => trim((string)$this->request->getPost('documento')),
            'telefone'         => trim((string)$this->request->getPost('telefone')),
            'email'            => trim((string)$this->request->getPost('email')),
            'assunto'          => trim((string)$this->request->getPost('assunto')),
            'setor_destino'    => trim((string)$this->request->getPost('setor_destino')),
            'descricao'        => trim((string)$this->request->getPost('descricao')),
            'status'           => trim((string)$this->request->getPost('status')) ?: 'Pendente',
        ];

        $model->update($id, $dados);

        return redirect()->to('/protocolo?alert=successEdit');
    }

    /**
     * Altera o status rapidamente (Pendente, Em Andamento, Concluído).
     */
    public function alterarStatus()
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $id = (int)$this->request->getPost('id');
        $novoStatus = trim((string)$this->request->getPost('status'));

        $statusValidos = ['Pendente', 'Em Andamento', 'Concluído'];
        if ($id > 0 && in_array($novoStatus, $statusValidos, true)) {
            $model = new AtendimentoProtocoloModel();
            $model->update($id, ['status' => $novoStatus]);

            return redirect()->to('/protocolo?alert=successStatus');
        }

        return redirect()->to('/protocolo');
    }

    /**
     * Remove um registro de atendimento.
     */
    public function excluir(int $id)
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $model = new AtendimentoProtocoloModel();
        $model->delete($id);

        return redirect()->to('/protocolo?alert=successDelete');
    }

    /**
     * Comprovante de atendimento formatado para impressão.
     */
    public function imprimir(int $id)
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $model = new AtendimentoProtocoloModel();
        $atendimento = $model->find($id);

        if (!$atendimento) {
            return redirect()->to('/protocolo?alert=errorNotFound');
        }

        return view('protocolo/comprovante', ['atendimento' => $atendimento]);
    }
}

