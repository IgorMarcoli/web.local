<div class="content-wrapper">
    <!-- Cabeçalho / Breadcrumbs -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-clipboard-list mr-2 text-info"></i>Setor de Protocolo
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/protocolo"><i class="fas fa-home mr-1"></i>Início</a></li>
                        <li class="breadcrumb-item active">Protocolo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <div class="container-fluid">

            <!-- Alertas e Feedbacks -->
            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'acessoNegado') : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-ban mr-2"></i><strong>Acesso Restrito:</strong> Você não possui permissão para acessar áreas externas ao seu setor.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successCreate') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i><strong>Sucesso!</strong> Atendimento registrado com sucesso no Protocolo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successEdit') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i><strong>Atualizado!</strong> Dados do atendimento atualizados com sucesso.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successStatus') : ?>
                <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>Status do atendimento atualizado.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successDelete') : ?>
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-trash-alt mr-2"></i>Atendimento excluído com sucesso.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'errorValidation') : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i><strong>Atenção:</strong> Preencha os campos obrigatórios (Nome do Solicitante e Assunto).
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <!-- Card de Boas-Vindas Personalizado -->
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; border-radius: 14px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <span class="badge badge-info px-3 py-2 text-uppercase mb-2" style="letter-spacing: 0.8px; font-weight: 700;">
                                <i class="fas fa-id-badge mr-1"></i>Setor de Protocolo
                            </span>
                            <h2 class="font-weight-bold mb-2">Bem-vindo(a), <?= esc($usuarioNome) ?>! 👋</h2>
                            <p class="text-white-50 mb-0 font-weight-normal" style="font-size: 1.05rem;">
                                Unidade Regional de Ensino de São Vicente (URE - SVI). Aqui você gerencia o registro e encaminhamento de todos os atendimentos e protocolos da recepção.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <button type="button" class="btn btn-primary btn-lg shadow px-4 mr-2" data-toggle="modal" data-target="#modal-novo-atendimento">
                                <i class="fas fa-plus-circle mr-1"></i> Novo Atendimento
                            </button>
                            <a href="/perfil" class="btn btn-outline-light btn-lg shadow px-3">
                                <i class="fas fa-user-cog mr-1"></i> Trocar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards com Indicadores Consolidados -->
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['total'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Total Registrado</p>
                        </div>
                        <div class="icon"><i class="fas fa-folder-open" style="opacity: 0.25;"></i></div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['pendentes'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Pendentes</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock" style="opacity: 0.25;"></i></div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['em_andamento'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Em Andamento</p>
                        </div>
                        <div class="icon"><i class="fas fa-spinner" style="opacity: 0.25;"></i></div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['concluidos'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Concluídos</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-double" style="opacity: 0.25;"></i></div>
                    </div>
                </div>
            </div>

            <!-- Tabela e Filtros de Atendimentos -->
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-dark m-0">
                            <i class="fas fa-list-alt text-info mr-2"></i>Registro de Atendimentos do Protocolo
                        </h3>
                        <div>
                            <button type="button" class="btn btn-success btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#modal-novo-atendimento">
                                <i class="fas fa-plus mr-1"></i> Registrar Novo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Formulário de Filtro e Busca -->
                    <form method="get" action="/protocolo" class="mb-4">
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                                    </div>
                                    <input type="text" name="busca" class="form-control" placeholder="Buscar por protocolo, solicitante, documento ou assunto..." value="<?= esc($busca ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <select name="status" class="form-control custom-select">
                                    <option value="todos">Todos os Status</option>
                                    <option value="Pendente" <?= ($statusFiltro ?? '') === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                    <option value="Em Andamento" <?= ($statusFiltro ?? '') === 'Em Andamento' ? 'selected' : '' ?>>Em Andamento</option>
                                    <option value="Concluído" <?= ($statusFiltro ?? '') === 'Concluído' ? 'selected' : '' ?>>Concluído</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2 d-flex">
                                <button type="submit" class="btn btn-info mr-2 flex-grow-1">
                                    <i class="fas fa-filter mr-1"></i> Filtrar
                                </button>
                                <?php if (!empty($busca) || (!empty($statusFiltro) && $statusFiltro !== 'todos') || !empty($dataFiltro)) : ?>
                                    <a href="/protocolo" class="btn btn-outline-secondary">
                                        <i class="fas fa-times mr-1"></i> Limpar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <!-- Listagem de Atendimentos -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle border">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 140px;">Nº Protocolo</th>
                                    <th>Solicitante</th>
                                    <th>Assunto</th>
                                    <th>Destino</th>
                                    <th>Data / Hora</th>
                                    <th>Atendido Por</th>
                                    <th class="text-center" style="width: 130px;">Status</th>
                                    <th class="text-right" style="width: 180px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($atendimentos)) : ?>
                                    <?php foreach ($atendimentos as $at) : ?>
                                        <?php
                                            $badgeStatus = 'badge-secondary';
                                            if ($at['status'] === 'Pendente') $badgeStatus = 'badge-warning';
                                            elseif ($at['status'] === 'Em Andamento') $badgeStatus = 'badge-primary';
                                            elseif ($at['status'] === 'Concluído') $badgeStatus = 'badge-success';
                                        ?>
                                        <tr>
                                            <td class="font-weight-bold text-nowrap">
                                                <span class="badge badge-light border px-2 py-1" style="font-size: 0.9rem; font-family: monospace;">
                                                    <?= esc($at['numero_protocolo'] ?: 'PROT-' . $at['id']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold text-dark"><?= esc($at['nome_solicitante']) ?></div>
                                                <?php if (!empty($at['documento']) || !empty($at['telefone'])) : ?>
                                                    <small class="text-muted">
                                                        <?= esc($at['documento'] ?? '') ?>
                                                        <?= (!empty($at['documento']) && !empty($at['telefone'])) ? ' • ' : '' ?>
                                                        <?= esc($at['telefone'] ?? '') ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold"><?= esc($at['assunto']) ?></div>
                                                <?php if (!empty($at['descricao'])) : ?>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                                        <?= esc($at['descricao']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary px-2 py-1 font-weight-normal">
                                                    <?= esc($at['setor_destino'] ?: 'Geral / Recepção') ?>
                                                </span>
                                            </td>
                                            <td class="text-nowrap text-muted small">
                                                <?= esc($at['data_atendimento'] ?: date('d/m/Y', strtotime($at['created_at'] ?? 'now'))) ?>
                                            </td>
                                            <td class="text-nowrap small text-muted">
                                                <i class="fas fa-user-edit mr-1 text-secondary"></i><?= esc($at['atendido_por'] ?: 'Protocolo') ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?= $badgeStatus ?> px-2 py-1" style="font-size: 0.85rem;">
                                                    <?= esc($at['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-right text-nowrap">
                                                <!-- Visualizar Detalhes -->
                                                <button type="button" class="btn btn-sm btn-info btn-ver-detalhes" 
                                                    title="Ver Detalhes"
                                                    data-toggle="modal" 
                                                    data-target="#modal-detalhes-atendimento"
                                                    data-protocolo="<?= esc($at['numero_protocolo']) ?>"
                                                    data-solicitante="<?= esc($at['nome_solicitante']) ?>"
                                                    data-documento="<?= esc($at['documento']) ?>"
                                                    data-telefone="<?= esc($at['telefone']) ?>"
                                                    data-email="<?= esc($at['email']) ?>"
                                                    data-assunto="<?= esc($at['assunto']) ?>"
                                                    data-destino="<?= esc($at['setor_destino']) ?>"
                                                    data-descricao="<?= esc($at['descricao']) ?>"
                                                    data-atendidopor="<?= esc($at['atendido_por']) ?>"
                                                    data-status="<?= esc($at['status']) ?>"
                                                    data-data="<?= esc($at['data_atendimento']) ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Editar -->
                                                <button type="button" class="btn btn-sm btn-warning text-white btn-editar-atendimento" 
                                                    title="Editar Atendimento"
                                                    data-toggle="modal" 
                                                    data-target="#modal-editar-atendimento"
                                                    data-id="<?= $at['id'] ?>"
                                                    data-protocolo="<?= esc($at['numero_protocolo']) ?>"
                                                    data-solicitante="<?= esc($at['nome_solicitante']) ?>"
                                                    data-documento="<?= esc($at['documento']) ?>"
                                                    data-telefone="<?= esc($at['telefone']) ?>"
                                                    data-email="<?= esc($at['email']) ?>"
                                                    data-assunto="<?= esc($at['assunto']) ?>"
                                                    data-destino="<?= esc($at['setor_destino']) ?>"
                                                    data-descricao="<?= esc($at['descricao']) ?>"
                                                    data-status="<?= esc($at['status']) ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Imprimir Comprovante -->
                                                <a href="/protocolo/imprimir/<?= $at['id'] ?>" target="_blank" class="btn btn-sm btn-secondary" title="Imprimir Comprovante">
                                                    <i class="fas fa-print"></i>
                                                </a>

                                                <!-- Excluir -->
                                                <form action="/protocolo/excluir/<?= $at['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir o atendimento <?= esc($at['numero_protocolo']) ?>?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir Atendimento">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 text-black-50 d-block"></i>
                                            Nenhum atendimento encontrado<?= !empty($busca) ? ' com os filtros aplicados' : '' ?>.
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-novo-atendimento">
                                                    <i class="fas fa-plus mr-1"></i> Registrar o primeiro atendimento
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL NOVO ATENDIMENTO ================= -->
<div class="modal fade" id="modal-novo-atendimento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg border-0">
            <form action="/protocolo/cadastrar" method="post">
                <?= csrf_field() ?>
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-plus-circle mr-2"></i>Novo Atendimento - Protocolo
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Nº de Protocolo</label>
                            <input type="text" class="form-control" name="numero_protocolo" value="<?= esc($proximoProtocolo ?? '') ?>" placeholder="Gerado automaticamente se vazio">
                            <small class="form-text text-muted">Deixe como está ou digite um número específico se necessário.</small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Data / Hora</label>
                            <input type="text" class="form-control" name="data_atendimento" value="<?= date('d/m/Y H:i') ?>">
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Nome do Solicitante <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="nome_solicitante" required placeholder="Nome completo do cidadão ou servidor">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Documento (RG / CPF)</label>
                            <input type="text" class="form-control" name="documento" placeholder="00.000.000-0">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Telefone / WhatsApp</label>
                            <input type="text" class="form-control" name="telefone" placeholder="(13) 99999-9999">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>E-mail</label>
                            <input type="email" class="form-control" name="email" placeholder="email@exemplo.com">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Assunto / Tipo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="assunto" required placeholder="Ex: Entrega de Documentos, Ofício, Requerimento, Dúvida...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Setor de Destino</label>
                            <input type="text" class="form-control" name="setor_destino" placeholder="Ex: Recursos Humanos, Gabinete, Supervisão, Núcleo Pedagógico...">
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Descrição / Observações</label>
                            <textarea class="form-control" name="descricao" rows="3" placeholder="Detalhes do atendimento, documentos entregues, orientações prestadas..."></textarea>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Atendido Por</label>
                            <input type="text" class="form-control" name="atendido_por" value="<?= esc($usuarioNome) ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Status Inicial</label>
                            <select name="status" class="form-control custom-select">
                                <option value="Pendente" selected>Pendente</option>
                                <option value="Em Andamento">Em Andamento</option>
                                <option value="Concluído">Concluído</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Salvar Atendimento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL EDITAR ATENDIMENTO ================= -->
<div class="modal fade" id="modal-editar-atendimento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg border-0">
            <form action="/protocolo/editar" method="post">
                <?= csrf_field() ?>
                <input type="hidden" id="edit-id" name="id">

                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-edit mr-2"></i>Editar Atendimento — <span id="edit-protocolo-badge"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Nome do Solicitante <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="edit-solicitante" name="nome_solicitante" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Documento</label>
                            <input type="text" class="form-control" id="edit-documento" name="documento">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Telefone</label>
                            <input type="text" class="form-control" id="edit-telefone" name="telefone">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>E-mail</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Assunto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-assunto" name="assunto" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Setor de Destino</label>
                            <input type="text" class="form-control" id="edit-destino" name="setor_destino">
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="font-weight-bold">Descrição</label>
                            <textarea class="form-control" id="edit-descricao" name="descricao" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Status</label>
                            <select id="edit-status" name="status" class="form-control custom-select">
                                <option value="Pendente">Pendente</option>
                                <option value="Em Andamento">Em Andamento</option>
                                <option value="Concluído">Concluído</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Atualizar Dados
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL DETALHES DO ATENDIMENTO ================= -->
<div class="modal fade" id="modal-detalhes-atendimento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-info-circle mr-2 text-info"></i>Detalhes do Atendimento
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3 pb-3 border-bottom">
                    <span class="badge badge-light border px-3 py-2" id="det-protocolo" style="font-size: 1.1rem; font-family: monospace;"></span>
                    <div class="mt-2"><span id="det-status-badge"></span></div>
                </div>

                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Solicitante:</dt>
                    <dd class="col-sm-8 font-weight-bold" id="det-solicitante"></dd>

                    <dt class="col-sm-4 text-muted">Documento:</dt>
                    <dd class="col-sm-8" id="det-documento">—</dd>

                    <dt class="col-sm-4 text-muted">Telefone:</dt>
                    <dd class="col-sm-8" id="det-telefone">—</dd>

                    <dt class="col-sm-4 text-muted">E-mail:</dt>
                    <dd class="col-sm-8" id="det-email">—</dd>

                    <dt class="col-sm-4 text-muted">Assunto:</dt>
                    <dd class="col-sm-8 font-weight-bold" id="det-assunto"></dd>

                    <dt class="col-sm-4 text-muted">Destino:</dt>
                    <dd class="col-sm-8" id="det-destino">—</dd>

                    <dt class="col-sm-4 text-muted">Data / Hora:</dt>
                    <dd class="col-sm-8" id="det-data">—</dd>

                    <dt class="col-sm-4 text-muted">Atendido Por:</dt>
                    <dd class="col-sm-8" id="det-atendidopor">—</dd>

                    <dt class="col-sm-4 text-muted">Descrição:</dt>
                    <dd class="col-sm-8 text-break" id="det-descricao">—</dd>
                </dl>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal de Edição
    $('.btn-editar-atendimento').on('click', function () {
        const btn = $(this);
        $('#edit-id').val(btn.data('id'));
        $('#edit-protocolo-badge').text(btn.data('protocolo'));
        $('#edit-solicitante').val(btn.data('solicitante'));
        $('#edit-documento').val(btn.data('documento'));
        $('#edit-telefone').val(btn.data('telefone'));
        $('#edit-email').val(btn.data('email'));
        $('#edit-assunto').val(btn.data('assunto'));
        $('#edit-destino').val(btn.data('destino'));
        $('#edit-descricao').val(btn.data('descricao'));
        $('#edit-status').val(btn.data('status'));
    });

    // Modal de Detalhes
    $('.btn-ver-detalhes').on('click', function () {
        const btn = $(this);
        const status = btn.data('status');
        let badgeClass = 'badge-secondary';
        if (status === 'Pendente') badgeClass = 'badge-warning';
        else if (status === 'Em Andamento') badgeClass = 'badge-primary';
        else if (status === 'Concluído') badgeClass = 'badge-success';

        $('#det-protocolo').text(btn.data('protocolo'));
        $('#det-status-badge').html(`<span class="badge ${badgeClass} px-3 py-1 font-weight-bold">${status}</span>`);
        $('#det-solicitante').text(btn.data('solicitante') || '—');
        $('#det-documento').text(btn.data('documento') || '—');
        $('#det-telefone').text(btn.data('telefone') || '—');
        $('#det-email').text(btn.data('email') || '—');
        $('#det-assunto').text(btn.data('assunto') || '—');
        $('#det-destino').text(btn.data('destino') || '—');
        $('#det-data').text(btn.data('data') || '—');
        $('#det-atendidopor').text(btn.data('atendidopor') || '—');
        $('#det-descricao').text(btn.data('descricao') || 'Sem observações adicionais.');
    });
});
</script>

