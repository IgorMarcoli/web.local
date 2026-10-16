<div class="content-wrapper">
    <!-- Cabeçalho / Breadcrumbs -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-chart-pie mr-2 text-info"></i>Dashboard do Protocolo
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/protocolo"><i class="fas fa-home mr-1"></i>Início</a></li>
                        <li class="breadcrumb-item active">Dashboard Protocolo</li>
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
                    <i class="fas fa-info-circle mr-2"></i>Status do atendimento atualizado com sucesso.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successDelete') : ?>
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-trash-alt mr-2"></i>Atendimento excluído com sucesso.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php endif; ?>

            <!-- Card de Boas-Vindas Personalizado -->
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff; border-radius: 14px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <span class="badge badge-info px-3 py-2 text-uppercase mb-2" style="letter-spacing: 0.8px; font-weight: 700;">
                                <i class="fas fa-id-badge mr-1"></i>Setor de Protocolo
                            </span>
                            <h2 class="font-weight-bold mb-2">Bem-vindo(a), <?= esc($usuarioNome) ?>! 👋</h2>
                            <p class="text-white-50 mb-0 font-weight-normal" style="font-size: 1.05rem;">
                                Unidade Regional de Ensino de São Vicente (URE - SVI). Monitore em tempo real o fluxo de protocolos, demandas e atendimentos ao público.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <a href="/protocolo/registrar" class="btn btn-primary btn-lg shadow px-4 mr-2 mb-2 mb-sm-0">
                                <i class="fas fa-plus-circle mr-1"></i> Registrar Atendimento
                            </a>
                            <a href="/perfil" class="btn btn-outline-light btn-lg shadow px-3">
                                <i class="fas fa-user-cog mr-1"></i> Trocar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards com Indicadores Consolidados (KPIs) -->
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <div class="small-box shadow-sm mb-0 h-100" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border-radius: 12px;">
                        <div class="inner p-3">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['total'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Total Registrado</p>
                            <small class="text-white font-weight-bold mt-2 d-inline-block">
                                <i class="fas fa-calendar-check mr-1"></i>Hoje: <?= (int)($stats['hoje'] ?? 0) ?> atendimentos
                            </small>
                        </div>
                        <div class="icon"><i class="fas fa-folder-open" style="opacity: 0.25;"></i></div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <div class="small-box shadow-sm mb-0 h-100" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 12px;">
                        <div class="inner p-3">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['pendentes'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Pendentes</p>
                            <small class="text-white font-weight-bold mt-2 d-inline-block">
                                <i class="fas fa-hourglass-half mr-1"></i>Aguardando encaminhamento
                            </small>
                        </div>
                        <div class="icon"><i class="fas fa-clock" style="opacity: 0.25;"></i></div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <div class="small-box shadow-sm mb-0 h-100" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: #fff; border-radius: 12px;">
                        <div class="inner p-3">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['em_andamento'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Em Andamento</p>
                            <small class="text-white font-weight-bold mt-2 d-inline-block">
                                <i class="fas fa-spinner fa-spin mr-1"></i>Em processamento no setor
                            </small>
                        </div>
                        <div class="icon"><i class="fas fa-tasks" style="opacity: 0.25;"></i></div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-12 mb-3">
                    <div class="small-box shadow-sm mb-0 h-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border-radius: 12px;">
                        <div class="inner p-3">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['concluidos'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Concluídos</p>
                            <small class="text-white font-weight-bold mt-2 d-inline-block">
                                <i class="fas fa-check-circle mr-1"></i>Taxa de resolução: <?= $stats['taxa_conclusao'] ?? 0 ?>%
                            </small>
                        </div>
                        <div class="icon"><i class="fas fa-check-double" style="opacity: 0.25;"></i></div>
                    </div>
                </div>
            </div>

            <!-- Gráficos do Dashboard -->
            <div class="row my-2">
                <!-- Gráfico 1: Status dos Atendimentos -->
                <div class="col-lg-4 mb-4">
                    <div class="card card-outline card-info shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title font-weight-bold text-dark m-0">
                                <i class="fas fa-chart-pie text-info mr-2"></i>Status dos Atendimentos
                            </h3>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <div style="position: relative; height: 220px; width: 100%;">
                                <canvas id="chart-status"></canvas>
                            </div>
                            <div class="mt-3 text-center small text-muted">
                                <span class="mr-3"><i class="fas fa-circle text-warning mr-1"></i>Pendente (<?= (int)($graficos['status']['Pendente'] ?? 0) ?>)</span>
                                <span class="mr-3"><i class="fas fa-circle text-primary mr-1"></i>Em Andamento (<?= (int)($graficos['status']['Em Andamento'] ?? 0) ?>)</span>
                                <span><i class="fas fa-circle text-success mr-1"></i>Concluído (<?= (int)($graficos['status']['Concluído'] ?? 0) ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico 2: Atendimentos por Setor de Destino -->
                <div class="col-lg-4 mb-4">
                    <div class="card card-outline card-primary shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title font-weight-bold text-dark m-0">
                                <i class="fas fa-building text-primary mr-2"></i>Demandas por Setor de Destino
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 250px; width: 100%;">
                                <canvas id="chart-setores"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico 3: Evolução dos Atendimentos (Últimos 7 dias) -->
                <div class="col-lg-4 mb-4">
                    <div class="card card-outline card-success shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title font-weight-bold text-dark m-0">
                                <i class="fas fa-chart-line text-success mr-2"></i>Volume Diário (Últimos 7 Dias)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; height: 250px; width: 100%;">
                                <canvas id="chart-evolucao"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela e Filtros de Atendimentos -->
            <div class="card card-outline card-secondary shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-dark m-0">
                            <i class="fas fa-list-alt text-secondary mr-2"></i>Atendimentos Registrados no Protocolo
                            <span class="badge badge-light border ml-2"><?= count($atendimentos) ?> registros</span>
                        </h3>
                        <div>
                            <a href="/protocolo/registrar" class="btn btn-primary btn-sm font-weight-bold shadow-sm">
                                <i class="fas fa-plus mr-1"></i> Novo Atendimento
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Formulário de Filtro e Busca -->
                    <form method="get" action="/protocolo" class="mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Buscar por termo:</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                                    </div>
                                    <input type="text" name="busca" class="form-control" placeholder="Protocolo, solicitante, documento ou assunto..." value="<?= esc($busca ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-md-2 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Status:</label>
                                <select name="status" class="form-control form-control-sm custom-select">
                                    <option value="todos">Todos os Status</option>
                                    <option value="Pendente" <?= ($statusFiltro ?? '') === 'Pendente' ? 'selected' : '' ?>>⏳ Pendente</option>
                                    <option value="Em Andamento" <?= ($statusFiltro ?? '') === 'Em Andamento' ? 'selected' : '' ?>>🔄 Em Andamento</option>
                                    <option value="Concluído" <?= ($statusFiltro ?? '') === 'Concluído' ? 'selected' : '' ?>>✅ Concluído</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Setor de Destino:</label>
                                <select name="setor" class="form-control form-control-sm custom-select">
                                    <option value="todos">Todos os Setores</option>
                                    <?php foreach ($setoresRegistrados as $set): ?>
                                        <option value="<?= esc($set) ?>" <?= ($setorFiltro ?? '') === $set ? 'selected' : '' ?>><?= esc($set) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-2 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Data:</label>
                                <input type="date" name="data" class="form-control form-control-sm" value="<?= esc($dataFiltro ?? '') ?>">
                            </div>

                            <div class="col-md-1 mb-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-info btn-sm btn-block" title="Aplicar Filtros">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <?php if (!empty($busca) || (!empty($statusFiltro) && $statusFiltro !== 'todos') || (!empty($setorFiltro) && $setorFiltro !== 'todos') || !empty($dataFiltro)) : ?>
                                    <a href="/protocolo" class="btn btn-outline-secondary btn-sm ml-1" title="Limpar Filtros">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <!-- Listagem de Atendimentos -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle border text-nowrap" id="tabela-atendimentos">
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
                                            <td class="font-weight-bold">
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
                                            <td style="white-space: normal; max-width: 260px;">
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
                                            <td class="text-muted small">
                                                <?= esc($at['data_atendimento'] ?: date('d/m/Y H:i', strtotime($at['created_at'] ?? 'now'))) ?>
                                            </td>
                                            <td class="small text-muted">
                                                <i class="fas fa-user-edit mr-1 text-secondary"></i><?= esc($at['atendido_por'] ?: 'Protocolo') ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?= $badgeStatus ?> px-2 py-1 font-weight-bold" style="font-size: 0.85rem;">
                                                    <?= esc($at['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <!-- Ver Detalhes -->
                                                <button type="button" class="btn btn-sm btn-outline-info mr-1 btn-ver-detalhes" 
                                                        title="Ver Detalhes do Atendimento"
                                                        data-id="<?= esc($at['id']) ?>"
                                                        data-protocolo="<?= esc($at['numero_protocolo']) ?>"
                                                        data-solicitante="<?= esc($at['nome_solicitante']) ?>"
                                                        data-documento="<?= esc($at['documento'] ?? '') ?>"
                                                        data-telefone="<?= esc($at['telefone'] ?? '') ?>"
                                                        data-email="<?= esc($at['email'] ?? '') ?>"
                                                        data-assunto="<?= esc($at['assunto']) ?>"
                                                        data-destino="<?= esc($at['setor_destino'] ?? '') ?>"
                                                        data-descricao="<?= esc($at['descricao'] ?? '') ?>"
                                                        data-status="<?= esc($at['status']) ?>"
                                                        data-data="<?= esc($at['data_atendimento'] ?? '') ?>"
                                                        data-atendente="<?= esc($at['atendido_por'] ?? '') ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Imprimir Comprovante -->
                                                <a href="/protocolo/imprimir/<?= esc($at['id']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary mr-1" title="Imprimir Comprovante Oficial">
                                                    <i class="fas fa-print"></i>
                                                </a>

                                                <!-- Alterar Status Rápido -->
                                                <button type="button" class="btn btn-sm btn-outline-primary mr-1 btn-alterar-status"
                                                        title="Alterar Status"
                                                        data-id="<?= esc($at['id']) ?>"
                                                        data-status="<?= esc($at['status']) ?>"
                                                        data-protocolo="<?= esc($at['numero_protocolo']) ?>">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>

                                                <!-- Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning mr-1 btn-editar-atendimento" 
                                                        title="Editar Dados"
                                                        data-id="<?= esc($at['id']) ?>"
                                                        data-solicitante="<?= esc($at['nome_solicitante']) ?>"
                                                        data-documento="<?= esc($at['documento'] ?? '') ?>"
                                                        data-telefone="<?= esc($at['telefone'] ?? '') ?>"
                                                        data-email="<?= esc($at['email'] ?? '') ?>"
                                                        data-assunto="<?= esc($at['assunto']) ?>"
                                                        data-destino="<?= esc($at['setor_destino'] ?? '') ?>"
                                                        data-descricao="<?= esc($at['descricao'] ?? '') ?>"
                                                        data-status="<?= esc($at['status']) ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Excluir -->
                                                <form action="/protocolo/excluir/<?= esc($at['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir o atendimento <?= esc($at['numero_protocolo']) ?>?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Atendimento">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                                            <h5>Nenhum atendimento encontrado.</h5>
                                            <p class="small mb-3">Você pode registrar novos atendimentos clicando no botão abaixo.</p>
                                            <a href="/protocolo/registrar" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus mr-1"></i> Registrar Primeiro Atendimento
                                            </a>
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

<!-- ================= MODAL: VISUALIZAR DETALHES ================= -->
<div class="modal fade" id="modal-detalhes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-clipboard-check text-info mr-2"></i>Detalhes do Atendimento
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <div>
                        <span class="text-muted small text-uppercase font-weight-bold d-block">Número de Protocolo</span>
                        <h4 class="font-weight-bold text-primary m-0" id="det-protocolo" style="font-family: monospace;"></h4>
                    </div>
                    <div>
                        <span id="det-status-badge" class="badge badge-secondary px-3 py-2 font-weight-bold" style="font-size: 1rem;"></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Solicitante</label>
                        <span class="font-weight-bold text-dark" id="det-solicitante" style="font-size: 1.1rem;"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Documento (CPF / RG)</label>
                        <span class="font-weight-bold text-dark" id="det-documento"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Telefone / WhatsApp</label>
                        <span class="font-weight-bold text-dark" id="det-telefone"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">E-mail</label>
                        <span class="font-weight-bold text-dark" id="det-email"></span>
                    </div>
                </div>

                <div class="row mb-3 pb-3 border-top pt-3">
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Assunto</label>
                        <span class="font-weight-bold text-dark" id="det-assunto"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Setor de Destino</label>
                        <span class="badge badge-info px-2 py-1 font-weight-normal" id="det-destino" style="font-size: 0.95rem;"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Data e Hora do Atendimento</label>
                        <span class="text-dark" id="det-data"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="text-muted small text-uppercase font-weight-bold d-block">Atendido Por</label>
                        <span class="text-dark font-weight-bold" id="det-atendente"></span>
                    </div>
                </div>

                <div class="border-top pt-3">
                    <label class="text-muted small text-uppercase font-weight-bold d-block">Descrição Detalhada / Observações</label>
                    <div class="p-3 bg-light rounded text-dark" id="det-descricao" style="min-height: 80px; white-space: pre-wrap;"></div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <a href="#" id="det-btn-imprimir" target="_blank" class="btn btn-outline-secondary font-weight-bold">
                    <i class="fas fa-print mr-1"></i> Imprimir Comprovante
                </a>
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL: ALTERAR STATUS RÁPIDO ================= -->
<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow border-0">
            <form action="/protocolo/alterarStatus" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="status-atendimento-id">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-exchange-alt mr-2"></i>Alterar Status do Atendimento
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">
                        Atualize a situação do protocolo <strong class="text-dark" id="status-protocolo-num"></strong>:
                    </p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Novo Status:</label>
                        <select name="status" id="select-novo-status" class="form-control form-control-lg custom-select font-weight-bold">
                            <option value="Pendente" class="text-warning">⏳ Pendente</option>
                            <option value="Em Andamento" class="text-primary">🔄 Em Andamento</option>
                            <option value="Concluído" class="text-success">✅ Concluído</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i>Salvar Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL: EDITAR ATENDIMENTO ================= -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow border-0">
            <form action="/protocolo/editar" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fas fa-edit text-warning mr-2"></i>Editar Atendimento
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nome do Solicitante <span class="text-danger">*</span></label>
                        <input type="text" name="nome_solicitante" id="edit-solicitante" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Documento (CPF / RG)</label>
                            <input type="text" name="documento" id="edit-documento" class="form-control">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Telefone / WhatsApp</label>
                            <input type="text" name="telefone" id="edit-telefone" class="form-control">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">E-mail</label>
                        <input type="email" name="email" id="edit-email" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Assunto <span class="text-danger">*</span></label>
                            <input type="text" name="assunto" id="edit-assunto" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Setor de Destino</label>
                            <input type="text" name="setor_destino" id="edit-destino" class="form-control">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" id="edit-status" class="form-control custom-select">
                            <option value="Pendente">⏳ Pendente</option>
                            <option value="Em Andamento">🔄 Em Andamento</option>
                            <option value="Concluído">✅ Concluído</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Descrição / Observações</label>
                        <textarea name="descricao" id="edit-descricao" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-save mr-1"></i>Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts do Dashboard e Chart.js -->
<script src="<?= base_url('tema/plugins/chart.js/Chart.bundle.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. Gráfico de Rosca: Status dos Atendimentos
    const ctxStatus = document.getElementById('chart-status');
    if (ctxStatus) {
        const statusData = [
            <?= (int)($graficos['status']['Pendente'] ?? 0) ?>,
            <?= (int)($graficos['status']['Em Andamento'] ?? 0) ?>,
            <?= (int)($graficos['status']['Concluído'] ?? 0) ?>
        ];

        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Pendente', 'Em Andamento', 'Concluído'],
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#f59e0b', '#6366f1', '#10b981'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                cutoutPercentage: 65,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            const dataset = data.datasets[tooltipItem.datasetIndex];
                            const total = dataset.data.reduce((acc, curr) => acc + curr, 0);
                            const currentValue = dataset.data[tooltipItem.index];
                            const percentage = total > 0 ? Math.round((currentValue / total) * 100) : 0;
                            return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }

    // 2. Gráfico de Barras: Demandas por Setor
    const ctxSetores = document.getElementById('chart-setores');
    if (ctxSetores) {
        const setoresLabels = <?= json_encode($graficos['setoresLabels'] ?? []) ?>;
        const setoresValores = <?= json_encode($graficos['setoresValores'] ?? []) ?>;

        new Chart(ctxSetores, {
            type: 'horizontalBar',
            data: {
                labels: setoresLabels.length > 0 ? setoresLabels : ['Sem registros'],
                datasets: [{
                    label: 'Atendimentos',
                    data: setoresValores.length > 0 ? setoresValores : [0],
                    backgroundColor: '#0284c7',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    xAxes: [{
                        ticks: { beginAtZero: true, precision: 0 }
                    }]
                }
            }
        });
    }

    // 3. Gráfico de Linha: Evolução dos Últimos 7 Dias
    const ctxEvolucao = document.getElementById('chart-evolucao');
    if (ctxEvolucao) {
        const diasLabels = <?= json_encode($graficos['diasLabels'] ?? []) ?>;
        const diasValores = <?= json_encode($graficos['diasValores'] ?? []) ?>;

        new Chart(ctxEvolucao, {
            type: 'line',
            data: {
                labels: diasLabels,
                datasets: [{
                    label: 'Atendimentos',
                    data: diasValores,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    pointBackgroundColor: '#10b981',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2,
                    fill: true,
                    lineTension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, precision: 0 }
                    }]
                }
            }
        });
    }

    // ================= MODAL DETALHES =================
    $('.btn-ver-detalhes').on('click', function () {
        const btn = $(this);
        $('#det-protocolo').text(btn.data('protocolo'));
        $('#det-solicitante').text(btn.data('solicitante'));
        $('#det-documento').text(btn.data('documento') || 'Não informado');
        $('#det-telefone').text(btn.data('telefone') || 'Não informado');
        $('#det-email').text(btn.data('email') || 'Não informado');
        $('#det-assunto').text(btn.data('assunto'));
        $('#det-destino').text(btn.data('destino') || 'Geral / Recepção');
        $('#det-data').text(btn.data('data'));
        $('#det-atendente').text(btn.data('atendente') || 'Protocolo');
        $('#det-descricao').text(btn.data('descricao') || 'Nenhuma observação ou descrição adicional registrada.');

        const st = btn.data('status');
        const badge = $('#det-status-badge');
        badge.removeClass('badge-warning badge-primary badge-success badge-secondary');
        if (st === 'Pendente') badge.addClass('badge-warning').text('⏳ ' + st);
        else if (st === 'Em Andamento') badge.addClass('badge-primary').text('🔄 ' + st);
        else if (st === 'Concluído') badge.addClass('badge-success').text('✅ ' + st);
        else badge.addClass('badge-secondary').text(st);

        $('#det-btn-imprimir').attr('href', '/protocolo/imprimir/' + btn.data('id'));

        $('#modal-detalhes').modal('show');
    });

    // ================= MODAL STATUS RÁPIDO =================
    $('.btn-alterar-status').on('click', function () {
        const btn = $(this);
        $('#status-atendimento-id').val(btn.data('id'));
        $('#status-protocolo-num').text(btn.data('protocolo'));
        $('#select-novo-status').val(btn.data('status'));
        $('#modal-status').modal('show');
    });

    // ================= MODAL EDITAR =================
    $('.btn-editar-atendimento').on('click', function () {
        const btn = $(this);
        $('#edit-id').val(btn.data('id'));
        $('#edit-solicitante').val(btn.data('solicitante'));
        $('#edit-documento').val(btn.data('documento'));
        $('#edit-telefone').val(btn.data('telefone'));
        $('#edit-email').val(btn.data('email'));
        $('#edit-assunto').val(btn.data('assunto'));
        $('#edit-destino').val(btn.data('destino'));
        $('#edit-descricao').val(btn.data('descricao'));
        $('#edit-status').val(btn.data('status'));
        $('#modal-editar').modal('show');
    });

});
</script>
