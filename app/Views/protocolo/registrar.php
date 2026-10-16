<div class="content-wrapper">
    <!-- Cabeçalho / Breadcrumbs -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-plus-circle mr-2 text-primary"></i>Registrar Atendimento
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/protocolo"><i class="fas fa-tachometer-alt mr-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item active">Registrar Atendimento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <div class="container-fluid">

            <!-- Alertas -->
            <?php if (session()->getFlashdata('alert') === 'errorValidation') : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i><strong>Atenção:</strong> Por favor, preencha todos os campos obrigatórios (Nome do Solicitante e Assunto).
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <!-- Formulário de Registro -->
            <form action="/protocolo/cadastrar" method="post" id="form-registrar-atendimento">
                <?= csrf_field() ?>
                <input type="hidden" name="acao" id="input-acao-form" value="salvar">

                <!-- Header Banner com Dados do Protocolo -->
                <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff; border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-7 mb-3 mb-md-0">
                                <span class="badge badge-info px-3 py-2 text-uppercase mb-2" style="letter-spacing: 0.8px; font-weight: 700;">
                                    <i class="fas fa-id-badge mr-1"></i>Setor de Protocolo
                                </span>
                                <h3 class="font-weight-bold mb-1">Novo Atendimento ao Cidadão</h3>
                                <p class="text-white-50 mb-0">Preencha os dados abaixo para gerar o protocolo oficial de atendimento e encaminhamento.</p>
                            </div>
                            <div class="col-md-5 text-md-right">
                                <div class="d-inline-block bg-white text-dark p-3 rounded shadow-sm text-left border">
                                    <small class="text-muted text-uppercase font-weight-bold d-block" style="font-size: 0.72rem; letter-spacing: 0.5px;">Nº de Protocolo Gerado</small>
                                    <span class="font-weight-bold text-primary" style="font-size: 1.35rem; font-family: monospace; letter-spacing: 1px;">
                                        <?= esc($proximoProtocolo) ?>
                                    </span>
                                    <input type="hidden" name="numero_protocolo" value="<?= esc($proximoProtocolo) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Coluna Principal (Dados do Solicitante e Demanda) -->
                    <div class="col-lg-8">
                        <!-- Card 1: Identificação do Solicitante -->
                        <div class="card card-outline card-primary shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h3 class="card-title font-weight-bold text-dark m-0">
                                    <i class="fas fa-user-edit text-primary mr-2"></i>1. Identificação do Solicitante
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark">Nome Completo do Solicitante <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                        </div>
                                        <input type="text" name="nome_solicitante" class="form-control form-control-lg" placeholder="Ex: Maria de Souza Silva" required autofocus value="<?= old('nome_solicitante') ?>">
                                    </div>
                                    <small class="text-muted">Informe o nome completo do solicitante ou interessado.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-bold text-dark">Documento (CPF ou RG)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light"><i class="fas fa-id-card text-muted"></i></span>
                                            </div>
                                            <input type="text" name="documento" class="form-control" placeholder="000.000.000-00 ou RG" value="<?= old('documento') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-bold text-dark">Telefone / WhatsApp</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light"><i class="fas fa-phone-alt text-muted"></i></span>
                                            </div>
                                            <input type="text" name="telefone" class="form-control" placeholder="(13) 99999-9999" value="<?= old('telefone') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark">E-mail para Contato</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                                        </div>
                                        <input type="email" name="email" class="form-control" placeholder="solicitante@email.com" value="<?= old('email') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Informações da Demanda / Protocolo -->
                        <div class="card card-outline card-info shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h3 class="card-title font-weight-bold text-dark m-0">
                                    <i class="fas fa-file-alt text-info mr-2"></i>2. Informações da Solicitação / Demanda
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark">Assunto Principal <span class="text-danger">*</span></label>
                                    <select name="assunto" id="select-assunto" class="form-control custom-select" required>
                                        <option value="">Selecione o assunto ou tipo de demanda...</option>
                                        <?php foreach ($assuntosPadrao as $assuntoItem) : ?>
                                            <option value="<?= esc($assuntoItem) ?>" <?= old('assunto') === $assuntoItem ? 'selected' : '' ?>>
                                                <?= esc($assuntoItem) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3" id="container-outro-assunto" style="display: none;">
                                    <label class="font-weight-bold text-info">Descreva o Assunto Específico <span class="text-danger">*</span></label>
                                    <input type="text" name="outro_assunto" id="input-outro-assunto" class="form-control" placeholder="Digite o assunto específico da solicitação...">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark">Setor de Destino / Encaminhamento</label>
                                    <select name="setor_destino" id="select-setor" class="form-control custom-select">
                                        <option value="">Selecione o setor de destino...</option>
                                        <?php foreach ($setoresPadrao as $setorItem) : ?>
                                            <option value="<?= esc($setorItem) ?>" <?= old('setor_destino') === $setorItem ? 'selected' : '' ?>>
                                                <?= esc($setorItem) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3" id="container-outro-setor" style="display: none;">
                                    <label class="font-weight-bold text-info">Nome do Setor / Destino Específico</label>
                                    <input type="text" name="outro_setor" id="input-outro-setor" class="form-control" placeholder="Informe o setor de destino...">
                                </div>

                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark">Descrição Detalhada / Documentos Apresentados</label>
                                    <textarea name="descricao" class="form-control" rows="4" placeholder="Descreva os detalhes da solicitação, documentos entregues, número de processo ou observações pertinentes..."><?= old('descricao') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Lateral (Metadados e Ações) -->
                    <div class="col-lg-4">
                        <!-- Card 3: Dados Operacionais -->
                        <div class="card card-outline card-secondary shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h3 class="card-title font-weight-bold text-dark m-0">
                                    <i class="fas fa-cog text-secondary mr-2"></i>3. Dados do Atendimento
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark">Status Inicial</label>
                                    <select name="status" class="form-control custom-select font-weight-bold">
                                        <option value="Pendente" selected class="text-warning">⏳ Pendente</option>
                                        <option value="Em Andamento" class="text-primary">🔄 Em Andamento</option>
                                        <option value="Concluído" class="text-success">✅ Concluído no Ato</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">Marque 'Concluído' caso a demanda tenha sido finalizada imediatamente na recepção.</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark">Data e Hora do Registro</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-muted"></i></span>
                                        </div>
                                        <input type="text" name="data_atendimento" class="form-control" value="<?= esc($dataAtual) ?>">
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark">Atendente Responsável</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-user-tie text-muted"></i></span>
                                        </div>
                                        <input type="text" name="atendido_por" class="form-control bg-light" readonly value="<?= esc($usuarioNome) ?>">
                                    </div>
                                    <small class="text-muted">Operador autenticado no sistema.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Botões de Ação -->
                        <div class="card shadow-sm border-0 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="card-body p-3">
                                <button type="button" class="btn btn-primary btn-block btn-lg font-weight-bold shadow-sm mb-2" id="btn-salvar-imprimir">
                                    <i class="fas fa-print mr-2"></i>Salvar e Imprimir Comprovante
                                </button>
                                
                                <button type="button" class="btn btn-success btn-block font-weight-bold mb-2" id="btn-salvar-apenas">
                                    <i class="fas fa-save mr-2"></i>Salvar Atendimento
                                </button>

                                <a href="/protocolo" class="btn btn-outline-secondary btn-block font-weight-bold">
                                    <i class="fas fa-arrow-left mr-2"></i>Voltar ao Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAssunto = document.getElementById('select-assunto');
    const containerOutroAssunto = document.getElementById('container-outro-assunto');
    const inputOutroAssunto = document.getElementById('input-outro-assunto');

    const selectSetor = document.getElementById('select-setor');
    const containerOutroSetor = document.getElementById('container-outro-setor');
    const inputOutroSetor = document.getElementById('input-outro-setor');

    const form = document.getElementById('form-registrar-atendimento');
    const inputAcao = document.getElementById('input-acao-form');
    const btnSalvarImprimir = document.getElementById('btn-salvar-imprimir');
    const btnSalvarApenas = document.getElementById('btn-salvar-apenas');

    // Toggle campo customizado para Assunto
    if (selectAssunto && containerOutroAssunto) {
        selectAssunto.addEventListener('change', function () {
            if (this.value === 'Outro Assunto') {
                containerOutroAssunto.style.display = 'block';
                inputOutroAssunto.setAttribute('required', 'required');
                inputOutroAssunto.focus();
            } else {
                containerOutroAssunto.style.display = 'none';
                inputOutroAssunto.removeAttribute('required');
            }
        });
    }

    // Toggle campo customizado para Setor
    if (selectSetor && containerOutroSetor) {
        selectSetor.addEventListener('change', function () {
            if (this.value === 'Outro Setor') {
                containerOutroSetor.style.display = 'block';
                inputOutroSetor.focus();
            } else {
                containerOutroSetor.style.display = 'none';
            }
        });
    }

    // Submissão com "Salvar e Imprimir"
    if (btnSalvarImprimir && form) {
        btnSalvarImprimir.addEventListener('click', function () {
            inputAcao.value = 'salvar_e_imprimir';
            if (form.reportValidity()) {
                form.submit();
            }
        });
    }

    // Submissão simples "Salvar Atendimento"
    if (btnSalvarApenas && form) {
        btnSalvarApenas.addEventListener('click', function () {
            inputAcao.value = 'salvar';
            if (form.reportValidity()) {
                form.submit();
            }
        });
    }
});
</script>

