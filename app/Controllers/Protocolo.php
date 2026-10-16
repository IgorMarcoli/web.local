<?php

namespace App\Controllers;

use App\Models\AtendimentoProtocoloModel;

class Protocolo extends BaseController
{
    /**
     * Setores padrão da URE - SVI para encaminhamento no Protocolo
     */
    private array $setoresPadrao = [
        'SEINTEC - Informações e Tecnologia',
        'SETEC - Suporte Técnico de TI',
        'Gabinete do Dirigente Regional',
        'Recursos Humanos (Vida Funcional / Pagamento)',
        'Supervisão / Inspeção Escolar',
        'Núcleo Pedagógico',
        'Núcleo de Apoio Administrativo',
        'Núcleo de Finanças',
        'Outro Setor',
    ];

    /**
     * Assuntos comuns no atendimento ao público do Protocolo
     */
    private array $assuntosPadrao = [
        'Requerimento de 2ª via de Histórico / Certificado',
        'Entrega de Documentação Escolar',
        'Certidão de Tempo de Contribuição / Serviço',
        'Solicitação de Aposentadoria / Abono',
        'Transferência ou Matrícula Escolar',
        'Ofício ou Correspondência Oficial',
        'Dúvidas / Atendimento Geral',
        'Outro Assunto',
    ];

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
     * Dashboard interativo de Atendimentos do Protocolo.
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
        $setor  = trim((string)$this->request->getGet('setor'));
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

        if ($setor !== '' && $setor !== 'todos') {
            $builder->where('setor_destino', $setor);
        }

        if ($data !== '') {
            // Suporta YYYY-MM-DD e DD/MM/YYYY
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
                $dataIso = $data;
                $partes  = explode('-', $data);
                $dataBr  = "{$partes[2]}/{$partes[1]}/{$partes[0]}";
            } else {
                // Assume DD/MM/YYYY — converte para ISO para o cast de data
                $dataBr  = $data;
                $partes  = explode('/', $data);
                $dataIso = count($partes) === 3 ? "{$partes[2]}-{$partes[1]}-{$partes[0]}" : $data;
            }

            // PostgreSQL não aceita LIKE em coluna timestamp; usa ::date para comparar
            $builder->groupStart()
                ->like('data_atendimento', $dataBr)
                ->orWhere("created_at::date = '{$dataIso}'::date")
                ->groupEnd();
        }

        $atendimentos = $builder->findAll();
        $stats = $model->getEstatisticas();
        $graficos = $model->getDadosGraficos();
        $proximoProtocolo = $model->gerarNumeroProtocolo();

        // Lista de setores registrados no banco para o filtro
        $setoresRegistrados = $model->select('setor_destino')
            ->where("setor_destino IS NOT NULL AND setor_destino != ''")
            ->distinct()
            ->orderBy('setor_destino', 'ASC')
            ->findColumn('setor_destino') ?? [];

        $dados = [
            'atendimentos'       => $atendimentos,
            'stats'              => $stats,
            'graficos'           => $graficos,
            'proximoProtocolo'   => $proximoProtocolo,
            'busca'              => $busca,
            'statusFiltro'       => $status,
            'setorFiltro'        => $setor,
            'dataFiltro'         => $data,
            'setoresPadrao'      => $this->setoresPadrao,
            'setoresRegistrados' => $setoresRegistrados,
            'usuarioNome'        => session()->get('usuario_nome') ?? 'Colaborador',
            'usuarioSetor'       => session()->get('usuario_setor') ?? 'PROTOCOLO',
        ];

        echo view('templates/header');
        echo view('protocolo/index', $dados);
        echo view('templates/footer');
    }

    /**
     * Tela dedicada para registrar um novo atendimento no Protocolo.
     */
    public function registrar()
    {
        if ($redirect = $this->checarPermissaoProtocolo()) {
            return $redirect;
        }

        $model = new AtendimentoProtocoloModel();

        $dados = [
            'proximoProtocolo' => $model->gerarNumeroProtocolo(),
            'dataAtual'        => date('d/m/Y H:i'),
            'usuarioNome'      => session()->get('usuario_nome') ?? 'Protocolo',
            'usuarioSetor'     => session()->get('usuario_setor') ?? 'PROTOCOLO',
            'setoresPadrao'    => $this->setoresPadrao,
            'assuntosPadrao'   => $this->assuntosPadrao,
        ];

        echo view('templates/header');
        echo view('protocolo/registrar', $dados);
        echo view('templates/footer');
    }

    /**
     * Grava o novo atendimento no Protocolo.
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

        $setorDestino = trim((string)$this->request->getPost('setor_destino'));
        if ($setorDestino === 'Outro' || $setorDestino === 'Outro Setor') {
            $outroSetor = trim((string)$this->request->getPost('outro_setor'));
            if ($outroSetor !== '') {
                $setorDestino = $outroSetor;
            }
        }

        $assunto = trim((string)$this->request->getPost('assunto'));
        if ($assunto === 'Outro' || $assunto === 'Outro Assunto') {
            $outroAssunto = trim((string)$this->request->getPost('outro_assunto'));
            if ($outroAssunto !== '') {
                $assunto = $outroAssunto;
            }
        }

        $dados = [
            'numero_protocolo' => $numeroProtocolo,
            'nome_solicitante' => trim((string)$this->request->getPost('nome_solicitante')),
            'documento'        => trim((string)$this->request->getPost('documento')),
            'telefone'         => trim((string)$this->request->getPost('telefone')),
            'email'            => trim((string)$this->request->getPost('email')),
            'assunto'          => $assunto,
            'setor_destino'    => $setorDestino,
            'descricao'        => trim((string)$this->request->getPost('descricao')),
            'atendido_por'     => $atendidoPor,
            'status'           => trim((string)$this->request->getPost('status')) ?: 'Pendente',
            'data_atendimento' => $dataAtendimento,
        ];

        if ($dados['nome_solicitante'] === '' || $dados['assunto'] === '') {
            return redirect()->back()->withInput()->with('alert', 'errorValidation');
        }

        $novoId = $model->insert($dados);

        // Se o operador clicou em "Salvar e Imprimir Comprovante"
        $acao = trim((string)$this->request->getPost('acao'));
        if ($acao === 'salvar_e_imprimir' && !empty($novoId)) {
            return redirect()->to('/protocolo/imprimir/' . $novoId);
        }

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
