<style>
    /* Estilos responsivos e limpos */
    .kpi-box-agenda {
        border-radius: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-box-agenda:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
    }
    .kpi-box-agenda .inner h3 {
        font-size: clamp(1.4rem, 2.5vw, 2rem);
        font-weight: 700;
        margin-bottom: 4px;
    }
    .kpi-box-agenda .inner p {
        font-size: clamp(0.75rem, 1.2vw, 0.9rem);
        margin-bottom: 0;
        opacity: 0.9;
    }
    #tabela-agendas td, #tabela-agendas th {
        vertical-align: middle;
    }
    .badge-status {
        font-size: 0.8rem;
        padding: 0.4em 0.65em;
        font-weight: 600;
        border-radius: 6px;
    }
    .code-tag {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.82rem;
        background-color: #f1f3f5;
        border: 1px solid #e9ecef;
        padding: 0.2em 0.45em;
        border-radius: 4px;
        color: #343a40;
    }
    .empty-state {
        padding: 45px 15px;
        text-align: center;
    }
    .empty-state i {
        font-size: 3.2rem;
        color: #ced4da;
        margin-bottom: 12px;
    }
    .status-select-badge {
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: 20px;
        padding: 3px 10px;
        border: 1px solid #ced4da;
        outline: none;
        cursor: pointer;
    }
    .status-select-badge.status-concluido {
        background-color: #d1fae5;
        color: #065f46;
        border-color: #10b981;
    }
    .status-select-badge.status-pendente {
        background-color: #fef3c7;
        color: #92400e;
        border-color: #f59e0b;
    }
    .status-select-badge.status-atendimento {
        background-color: #fee2e2;
        color: #991b1b;
        border-color: #ef4444;
    }
    .status-select-badge.status-suspenso {
        background-color: #f1f5f9;
        color: #475569;
        border-color: #94a3b8;
    }
    @media (max-width: 767.98px) {
        .content-header h1 {
            font-size: 1.35rem;
        }
    }
    @media print {
        .main-sidebar, .main-header, .main-footer, .no-print, .btn, .modal {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Modal Novo Agendamento -->
<div class="modal fade" id="modal-novo-produto" tabindex="-1" role="dialog" aria-labelledby="modalNovoTitulo" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="/agenda/cadastrar" method="post">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; border-bottom: none;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white text-info p-2 mr-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; min-width: 40px; font-size: 1.15rem;">
                            <i class="fas fa-calendar-plus text-info"></i>
                        </div>
                        <div>
                            <h5 class="modal-title font-weight-bold text-white mb-0" id="modalNovoTitulo">Novo Agendamento</h5>
                            <small class="text-white-50">Preencha os dados do agendamento ou visita</small>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; text-shadow: none; font-size: 1.6rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8fafc;">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-school mr-1 text-info"></i> Escola / Local</label>
                            <input type="text" class="form-control" name="Nomelocal" required placeholder="Ex: E.M. Prof. Exemplo...">
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-calendar-alt mr-1 text-info"></i> Data</label>
                            <input type="date" class="form-control" name="Data" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-tag mr-1 text-info"></i> Tipo</label>
                            <input type="text" class="form-control" name="Tipo" placeholder="Ex: Manutenção, Visita...">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-align-left mr-1 text-info"></i> Descrição</label>
                            <input type="text" class="form-control" name="Descricao" placeholder="Breve descrição da atividade solicitada...">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-user mr-1 text-info"></i> Solicitado por</label>
                            <input type="text" class="form-control" name="Solicitadopor" placeholder="Nome do solicitante...">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-user-check mr-1 text-info"></i> Atendido por</label>
                            <input type="text" class="form-control" name="Atendidopor" placeholder="Técnico ou responsável...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white py-3 px-4 d-flex justify-content-between border-top">
                    <button type="button" class="btn btn-secondary font-weight-bold shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-info font-weight-bold shadow-sm">
                        <i class="fas fa-save mr-1"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Agendamento -->
<div class="modal fade" id="modal-editar-produto" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitulo" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="/agenda/editar" method="post">
                <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; border-bottom: none;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white text-warning p-2 mr-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; min-width: 40px; font-size: 1.15rem;">
                            <i class="fas fa-edit text-warning"></i>
                        </div>
                        <div>
                            <h5 class="modal-title font-weight-bold text-white mb-0" id="modalEditarTitulo">Editar Agendamento</h5>
                            <small class="text-white-50">Atualize as informações do agendamento</small>
                        </div>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9; text-shadow: none; font-size: 1.6rem;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8fafc;">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-school mr-1 text-warning"></i> Escola / Local</label>
                            <input type="text" class="form-control" id="modal-editar-produto-Nomelocal" name="Nomelocal" required>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-calendar-alt mr-1 text-warning"></i> Data</label>
                            <input type="text" class="form-control" id="modal-editar-produto-Data" name="Data" required>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-tag mr-1 text-warning"></i> Tipo</label>
                            <input type="text" class="form-control" id="modal-editar-produto-Tipo" name="Tipo">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-align-left mr-1 text-warning"></i> Descrição</label>
                            <input type="text" class="form-control" id="modal-editar-produto-Descricao" name="Descricao">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-user mr-1 text-warning"></i> Solicitado por</label>
                            <input type="text" class="form-control" id="modal-editar-produto-Solicitadopor" name="Solicitadopor">
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold small text-muted"><i class="fas fa-user-check mr-1 text-warning"></i> Atendido por</label>
                            <input type="text" class="form-control" id="modal-editar-produto-Atendidopor" name="Atendidopor">
                        </div>
                        <input type="hidden" id="modal-editar-produto-AgendaId" name="AgendaId">
                    </div>
                </div>
                <div class="modal-footer bg-white py-3 px-4 d-flex justify-content-between border-top">
                    <button type="button" class="btn btn-secondary font-weight-bold shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning font-weight-bold text-dark shadow-sm">
                        <i class="fas fa-check mr-1"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Header da Página -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between mb-2">
                <div class="col-auto">
                    <h1 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <i class="fas fa-calendar-alt text-info mr-2"></i> Agendamentos
                    </h1>
                </div>
                <div class="col-auto d-flex align-items-center flex-wrap no-print">
                    <button type="button" class="btn btn-info shadow-sm font-weight-bold mr-2 my-1" data-toggle="modal" data-target="#modal-novo-produto">
                        <i class="fas fa-plus-circle mr-1"></i> Novo Agendamento
                    </button>
                    <button type="button" class="btn btn-success shadow-sm font-weight-bold mr-2 my-1" onclick="exportarExcel()" title="Exportar para Excel">
                        <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                    </button>
                    <button type="button" class="btn btn-outline-secondary shadow-sm my-1" onclick="window.print()" title="Imprimir">
                        <i class="fas fa-print mr-1"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <div class="container-fluid">

            <!-- Alertas de Feedback -->
            <?php if (isset($_GET['alert']) && $_GET['alert'] == "successCreate") : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Agendamento cadastrado com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == "successDelete") : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Agendamento excluído com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == "successEdit") : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Agendamento editado com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>

            <!-- KPI Cards Indicadores Responsivos -->
            <div class="row no-print mb-3">
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-info kpi-box-agenda shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $statsAgenda['total'] ?? count($agendas) ?></h3>
                            <p>Total de Registros</p>
                        </div>
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-success kpi-box-agenda shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $statsAgenda['concluido'] ?? 0 ?></h3>
                            <p>Concluídos</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-warning kpi-box-agenda shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $statsAgenda['pendente'] ?? 0 ?></h3>
                            <p>Pendentes</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-danger kpi-box-agenda shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $statsAgenda['emAtendimento'] ?? 0 ?></h3>
                            <p>Em Atendimento</p>
                        </div>
                        <div class="icon"><i class="fas fa-headset"></i></div>
                    </div>
                </div>
            </div>

            <!-- Filtros Modernos e Responsivos -->
            <div class="card card-outline card-info shadow-sm no-print mb-3">
                <div class="card-header py-2 bg-transparent border-bottom-0">
                    <h3 class="card-title font-weight-bold text-dark small text-uppercase mb-0">
                        <i class="fas fa-filter mr-1 text-info"></i> Filtros de Pesquisa
                    </h3>
                </div>
                <div class="card-body pt-0 pb-3">
                    <form id="form-filtro-mes" method="get" action="/agenda/agenda">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-4 col-lg-3 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Pesquisa rápida:</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Escola, tipo ou solicitante..." id="pesquisarAgenda">
                                </div>
                            </div>

                            <div class="col-6 col-md-3 col-lg-2 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Mês:</label>
                                <select name="mes" id="filtro-mes" class="form-control form-control-sm">
                                    <?php
                                    $meses = [
                                        1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril',
                                        5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto',
                                        9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro'
                                    ];
                                    foreach ($meses as $num => $nome) :
                                    ?>
                                        <option value="<?= $num ?>" <?= ($mesAtual == $num) ? 'selected' : '' ?>>
                                            <?= $nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-6 col-md-3 col-lg-2 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Ano:</label>
                                <select name="ano" id="filtro-ano" class="form-control form-control-sm">
                                    <?php for ($a = date('Y'); $a >= date('Y') - 3; $a--) : ?>
                                        <option value="<?= $a ?>" <?= ($anoAtual == $a) ? 'selected' : '' ?>>
                                            <?= $a ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- preserva o status atual ao trocar o mês/ano -->
                            <input type="hidden" name="status" id="filtro-status-hidden" value="<?= esc($statusAtual ?? '') ?>">

                            <div class="col-12 col-md-2 col-lg-2 mb-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-info btn-sm flex-fill mr-1" title="Aplicar Filtros">
                                    <i class="fas fa-filter mr-1"></i> Filtrar
                                </button>
                                <a href="/agenda/agenda" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros">
                                    <i class="fas fa-undo"></i>
                                </a>
                            </div>

                            <div class="col-12 col-lg-3 mb-2 d-flex align-items-end justify-content-lg-end">
                                <a href="/agenda/agenda?periodo=todos<?= $statusAtual ? '&status='.urlencode($statusAtual) : '' ?>"
                                   class="btn btn-sm <?= ($periodoAtual === 'todos') ? 'btn-dark' : 'btn-outline-dark' ?> shadow-sm">
                                    <i class="fas fa-calendar mr-1"></i> Ver todos os períodos
                                </a>
                            </div>
                        </div>

                        <!-- Filtros rápidos de Status por Botões/Pills -->
                        <div class="row mt-2 pt-2 border-top">
                            <div class="col-12 d-flex align-items-center flex-wrap" id="filtros-status">
                                <span class="small font-weight-bold text-muted mr-2 my-1">Status:</span>
                                <a href="/agenda/agenda" data-status="" class="btn btn-sm filtro-status-link mr-1 my-1 <?= empty($statusAtual) ? 'btn-primary' : 'btn-outline-secondary' ?>">
                                    Todos
                                </a>
                                <a href="/agenda/agenda?status=concluido" data-status="concluido" class="btn btn-sm filtro-status-link mr-1 my-1 <?= $statusAtual == 'concluido' ? 'btn-success' : 'btn-outline-success' ?>">
                                    <i class="fas fa-check-circle mr-1"></i> Concluído
                                </a>
                                <a href="/agenda/agenda?status=pendente" data-status="pendente" class="btn btn-sm filtro-status-link mr-1 my-1 <?= $statusAtual == 'pendente' ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-warning' ?>">
                                    <i class="fas fa-clock mr-1"></i> Pendente
                                </a>
                                <a href="/agenda/agenda?status=Em atendimento" data-status="Em atendimento" class="btn btn-sm filtro-status-link mr-1 my-1 <?= $statusAtual == 'Em atendimento' ? 'btn-danger' : 'btn-outline-danger' ?>">
                                    <i class="fas fa-headset mr-1"></i> Em Atendimento
                                </a>
                                <a href="/agenda/agenda?status=suspenso" data-status="suspenso" class="btn btn-sm filtro-status-link my-1 <?= $statusAtual == 'suspenso' ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                                    <i class="fas fa-pause-circle mr-1"></i> Suspenso
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela Principal Estilizada e 100% Responsiva -->
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title font-weight-bold text-dark mb-0 small text-uppercase">
                        <i class="fas fa-list mr-1"></i> Lista de Agendamentos
                    </h3>
                    <span class="badge badge-info badge-pill px-2 py-1">
                        <?= count($agendas) ?> <?= (count($agendas) === 1) ? 'registro' : 'registros' ?>
                    </span>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0 text-nowrap" id="tabela-agendas">
                        <thead class="thead-light">
                            <tr>
                                <th>Nome / Local</th>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Descrição</th>
                                <th>Solicitado por</th>
                                <th>Atendido por</th>
                                <th>Status</th>
                                <th class="text-center no-print" style="width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agendas)) : ?>
                                <?php foreach ($agendas as $agend) : ?>
                                    <?php
                                    $stRaw = mb_strtolower(trim($agend['status'] ?? ''), 'UTF-8');
                                    $badgeClass = 'status-suspenso';
                                    if ($stRaw === 'concluido' || $stRaw === 'concluído') {
                                        $badgeClass = 'status-concluido';
                                    } elseif ($stRaw === 'pendente') {
                                        $badgeClass = 'status-pendente';
                                    } elseif ($stRaw === 'em atendimento') {
                                        $badgeClass = 'status-atendimento';
                                    }
                                    ?>
                                    <tr class="linha-agenda">
                                        <td class="font-weight-bold text-dark">
                                            <i class="fas fa-school text-muted mr-1"></i><?= esc($agend['Nomelocal'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <span class="text-muted"><i class="far fa-calendar-alt mr-1"></i><?= esc($agend['Data'] ?? '-') ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($agend['Tipo'])): ?>
                                                <span class="badge badge-light border text-dark"><?= esc($agend['Tipo']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= esc($agend['Descricao'] ?? '') ?>">
                                            <?= esc($agend['Descricao'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($agend['Solicitadopor'])): ?>
                                                <i class="fas fa-user-tag text-muted mr-1"></i><?= esc($agend['Solicitadopor']) ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($agend['Atendidopor'])): ?>
                                                <i class="fas fa-user-check text-muted mr-1"></i><?= esc($agend['Atendidopor']) ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm status-select-badge <?= $badgeClass ?>"
                                                    onchange="alterarStatus(this.value, <?= (int)$agend['AgendaId'] ?>, this)">
                                                <option value="pendente" <?= ($stRaw === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                                                <option value="concluido" <?= ($stRaw === 'concluido' || $stRaw === 'concluído') ? 'selected' : '' ?>>Concluído</option>
                                                <option value="Em Atendimento" <?= ($stRaw === 'em atendimento') ? 'selected' : '' ?>>Em Atendimento</option>
                                                <option value="Suspenso" <?= ($stRaw === 'suspenso') ? 'selected' : '' ?>>Suspenso</option>
                                            </select>
                                        </td>
                                        <td class="text-center no-print">
                                            <button type="button" class="btn btn-sm btn-outline-primary" title="Editar"
                                                    data-toggle="modal" data-target="#modal-editar-produto"
                                                    onclick="prepararDados('<?= esc($agend['AgendaId'] ?? '', 'js') ?>', '<?= esc($agend['Nomelocal'] ?? '', 'js') ?>', '<?= esc($agend['Data'] ?? '', 'js') ?>', '<?= esc($agend['Tipo'] ?? '', 'js') ?>', '<?= esc($agend['Descricao'] ?? '', 'js') ?>', '<?= esc($agend['Solicitadopor'] ?? '', 'js') ?>', '<?= esc($agend['Atendidopor'] ?? '', 'js') ?>', '<?= esc($agend['status'] ?? '', 'js') ?>')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="/agenda/excluir/<?= esc($agend['AgendaId'] ?? '', 'url') ?>"
                                               class="btn btn-sm btn-outline-danger ml-1"
                                               title="Excluir"
                                               onclick="return confirm('Deseja realmente excluir este agendamento?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <h5 class="text-secondary font-weight-bold">Nenhum agendamento encontrado</h5>
                                            <p class="text-muted mb-3">Não há registros para o período ou filtros selecionados.</p>
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-novo-produto">
                                                <i class="fas fa-plus-circle mr-1"></i> Criar Agendamento
                                            </button>
                                            <a href="/agenda/agenda" class="btn btn-sm btn-outline-secondary ml-2">
                                                <i class="fas fa-undo mr-1"></i> Limpar Filtros
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div><!-- /.content -->
</div><!-- /.content-wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function removerParametroAlerta() {
        const url = new URL(window.location.href);
        url.searchParams.delete('alert');
        window.history.replaceState({}, document.title, url.pathname + (url.search ? url.search : ''));
    }

    function prepararDados(AgendaId, Nomelocal, Data, Tipo, Descricao, Solicitadopor, Atendidopor, status) {
        document.getElementById('modal-editar-produto-AgendaId').value = AgendaId || '';
        document.getElementById('modal-editar-produto-Nomelocal').value = Nomelocal || '';
        document.getElementById('modal-editar-produto-Data').value = Data || '';
        document.getElementById('modal-editar-produto-Tipo').value = Tipo || '';
        document.getElementById('modal-editar-produto-Descricao').value = Descricao || '';
        document.getElementById('modal-editar-produto-Solicitadopor').value = Solicitadopor || '';
        document.getElementById('modal-editar-produto-Atendidopor').value = Atendidopor || '';

        $('#modal-editar-produto').modal('show');
    }

    function alterarStatus(novoStatus, id, selectElem) {
        if (selectElem) {
            selectElem.classList.remove('status-concluido', 'status-pendente', 'status-atendimento', 'status-suspenso');
            const st = (novoStatus || '').toLowerCase();
            if (st === 'concluido' || st === 'concluído') {
                selectElem.classList.add('status-concluido');
            } else if (st === 'pendente') {
                selectElem.classList.add('status-pendente');
            } else if (st === 'em atendimento') {
                selectElem.classList.add('status-atendimento');
            } else {
                selectElem.classList.add('status-suspenso');
            }
        }

        fetch('/agenda/agenda/alterarStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'AgendaId=' + id + '&status=' + encodeURIComponent(novoStatus)
        })
        .then(response => response.text())
        .then(data => {
            console.log('Status atualizado:', novoStatus);
        })
        .catch(err => console.error('Erro ao atualizar status:', err));
    }

    function exportarExcel() {
        const tabela = document.getElementById('tabela-agendas') || document.querySelector('.table');
        if (!tabela) return;

        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.table_to_sheet(tabela);

        // Remove a coluna de ações se existir
        const range = XLSX.utils.decode_range(ws['!ref']);
        for (let row = range.s.r; row <= range.e.r; row++) {
            const cellAddress = XLSX.utils.encode_cell({ r: row, c: range.e.c });
            delete ws[cellAddress];
        }
        range.e.c -= 1;
        ws['!ref'] = XLSX.utils.encode_range(range);

        ws['!cols'] = [
            { wch: 26 }, // NOME/LOCAL
            { wch: 14 }, // DATA
            { wch: 16 }, // TIPO
            { wch: 32 }, // DESCRIÇÃO
            { wch: 20 }, // SOLICITADO POR
            { wch: 20 }, // ATENDIDO POR
            { wch: 16 }, // STATUS
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Agendamentos');
        const hoje = new Date().toLocaleDateString('pt-BR').replace(/\//g, '-');
        XLSX.writeFile(wb, `agendamentos_${hoje}.xlsx`);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Pesquisa instantânea na tabela
        const inputPesquisa = document.getElementById("pesquisarAgenda");
        if (inputPesquisa) {
            inputPesquisa.addEventListener("keyup", function() {
                const filtro = this.value.toLowerCase().trim();
                const linhas = document.querySelectorAll("#tabela-agendas tbody tr.linha-agenda");

                linhas.forEach(function(linha) {
                    const texto = linha.textContent.toLowerCase();
                    linha.style.display = texto.includes(filtro) ? "" : "none";
                });
            });
        }

        // Filtros rápidos por status mantendo mês/ano
        document.querySelectorAll('.filtro-status-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const status = this.getAttribute('data-status');
                const mes = document.getElementById('filtro-mes') ? document.getElementById('filtro-mes').value : '';
                const ano = document.getElementById('filtro-ano') ? document.getElementById('filtro-ano').value : '';

                let url = '/agenda/agenda?mes=' + mes + '&ano=' + ano;
                if (status) {
                    url += '&status=' + encodeURIComponent(status);
                }
                window.location.href = url;
            });
        });

        // Auto-fechar alertas após 5 segundos
        setTimeout(function () {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
