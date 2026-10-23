<div class="modal fade" id="modal-novo-emprestimos">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="/emprestimos/salvar" method="post">
<?= csrf_field() ?>

<div class="modal-header">
<h4 class="modal-title">Novo Empréstimo</h4>
<button type="button" id="btn-add-group" class="btn btn-sm btn-success ml-3">Adicionar</button>
<button type="button" class="close" data-dismiss="modal">
<span>&times;</span>
</button>
</div>

<!-- make modal body scrollable when many groups are added -->
<div class="modal-body" style="max-height:60vh; overflow:auto;">
    <div id="emprestimo-groups">
        <div class="emprestimo-group" data-index="0">
            <div class="emprestimo-card">
            <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>ID do Kit</label>
                    <select name="numero_mochila[]" class="form-control numero-mochila" required>
                        <option value="">Selecione</option>
                        <?php foreach ($availableMochilas as $mochila): ?>
                            <option value="<?= esc($mochila) ?>"><?= esc($mochila) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Nome do Solicitante</label>
                    <input type="text" class="form-control nome-solicitante" name="nome_recebedor[]" required autocomplete="off">
                    <div class="list-group position-absolute w-100 lista-solicitantes" style="z-index:999; max-height:180px; overflow:auto;"></div>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label>Email do Solicitante</label>
                    <input type="email" name="email_recebedor[]" class="form-control" required>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label>Setor</label>
                    <input type="text" class="form-control setor-display" readonly placeholder="Será preenchido automaticamente">
                    <input type="hidden" name="setor[]" class="setor" value="">
                    <input type="hidden" name="outro_setor[]" class="outro-setor" value="">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label>Nome do Responsável SEITEC/SETEC</label>
                    <input type="text" class="form-control nome-responsavel" name="nome_responsavel[]" required autocomplete="off">
                    <div class="list-group position-absolute w-100 lista-responsaveis" style="z-index:999; max-height:180px; overflow:auto;"></div>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <div class="d-flex align-items-center" style="height: 38px;">
                        <label class="mb-0 mr-2">Chamado aberto?</label>
                        <div class="custom-control custom-checkbox custom-control-inline mb-0">
                            <input type="hidden" name="status_equipamento[]" class="status-equipamento-hidden" value="">
                            <input type="checkbox" class="custom-control-input status-equipamento" id="status-equipamento-0" value="chamado aberto">
                            <label class="custom-control-label" for="status-equipamento-0"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 container-numero-chamado" style="display:none;">
                <div class="form-group">
                    <label>Número do Chamado</label>
                    <input type="number" name="numero_chamado[]" class="form-control numero-chamado">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="obs-label">Observações</label>
                    <textarea name="obs[]" class="form-control" rows="3"></textarea>
                </div>
            </div>
            </div> <!-- /.row inside card -->

            <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove-group">Remover</button>
            </div>

            </div> <!-- /.emprestimo-card -->
        </div>
    </div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
</div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="modal-editar-emprestimos">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<form action="/emprestimos/editarMultiplo" method="post" id="form-editar-multiplo">
<?= csrf_field() ?>
<div class="modal-header">
<h4 class="modal-title">Editar Empréstimos Selecionados</h4>
<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">

    <div id="editar-emprestimo-groups"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Salvar alterações</button>
</div>
</form>
</div>
</div>
</div>

<!-- Modal Detalhes do Servidor / Supervisor -->
<div class="modal fade" id="modal-detalhes-servidor" tabindex="-1" role="dialog" aria-labelledby="modalServidorTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">

            <!-- Header vibrante com gradiente azul/índigo de alto contraste -->
            <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #3b82f6 100%); color: #ffffff; border-bottom: none;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white text-primary p-2 mr-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; min-width: 44px; font-size: 1.3rem;">
                        <i class="fas fa-id-badge text-primary"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-white mb-0" id="modalServidorTitle" style="letter-spacing: 0.5px;">Dados do Servidor</h5>
                        <small class="text-white-50 font-weight-light">Informações oficiais da tabela servidores</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar" style="opacity: 0.9; text-shadow: none; font-size: 1.8rem; line-height: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background-color: #f8fafc;">

                <!-- Card Principal com Avatar e Nome -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div id="modal-servidor-avatar" class="rounded-circle mr-3 d-flex align-items-center justify-content-center font-weight-bold shadow-sm" 
                             style="width: 60px; height: 60px; min-width: 60px; background: linear-gradient(135deg, #0284c7, #0ea5e9); color: #ffffff; font-size: 1.4rem;">
                            SB
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex align-items-center flex-wrap mb-1">
                                <span id="modal-servidor-tipo" class="badge badge-pill badge-primary px-3 py-1 font-weight-bold mr-2 mb-1" style="background-color: #2563eb; font-size: 0.8rem; letter-spacing: 0.5px;">SERVIDOR</span>
                                <span id="modal-servidor-badge-id" class="badge badge-pill badge-dark px-3 py-1 font-weight-bold mb-1" style="background-color: #0f172a; font-size: 0.8rem;">
                                    <i class="fas fa-hashtag text-warning mr-1"></i>ID: <span id="modal-servidor-id">--</span>
                                </span>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-0 text-truncate" id="modal-servidor-nome-completo" style="color: #0f172a !important;">
                                Nome do Servidor
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Grid de Informações Acessível com Cores Vivas -->
                <div class="row">

                    <!-- Card Ramal (Verde Esmeralda Vibrante) -->
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 12px; background: #ecfdf5; border-left: 5px solid #10b981 !important;">
                            <div class="d-flex align-items-center mb-1">
                                <div class="rounded-circle p-2 mr-2 d-flex align-items-center justify-content-center" style="background: #10b981; color: #fff; width: 32px; height: 32px; font-size: 0.9rem;">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <span class="font-weight-bold" style="color: #065f46; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Ramal Telefônico</span>
                            </div>
                            <div class="mt-2">
                                <span id="modal-servidor-ramal" class="font-weight-bold text-dark" style="font-size: 1.25rem; color: #064e3b !important;">--</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Primeiro / Último Nome (Azul Celeste) -->
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 12px; background: #eff6ff; border-left: 5px solid #3b82f6 !important;">
                            <div class="d-flex align-items-center mb-1">
                                <div class="rounded-circle p-2 mr-2 d-flex align-items-center justify-content-center" style="background: #3b82f6; color: #fff; width: 32px; height: 32px; font-size: 0.9rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="font-weight-bold" style="color: #1e40af; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Primeiro / Sobrenome</span>
                            </div>
                            <div class="mt-2 text-dark font-weight-bold" style="font-size: 1.05rem;">
                                <span id="modal-servidor-primeiro-nome">--</span> / <span id="modal-servidor-ultimo-nome">--</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Seção / Setor (Roxo Vibrante) -->
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 12px; background: #faf5ff; border-left: 5px solid #8b5cf6 !important;">
                            <div class="d-flex align-items-center mb-1">
                                <div class="rounded-circle p-2 mr-2 d-flex align-items-center justify-content-center" style="background: #8b5cf6; color: #fff; width: 32px; height: 32px; font-size: 0.9rem;">
                                    <i class="fas fa-building"></i>
                                </div>
                                <span class="font-weight-bold" style="color: #5b21b6; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Seção / Lotação</span>
                            </div>
                            <div class="mt-2 font-weight-bold" style="font-size: 1.05rem; color: #3b0764 !important;">
                                <span id="modal-servidor-secao">Não informado</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Serviço (Âmbar / Laranja Vibrante) -->
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 12px; background: #fffbeb; border-left: 5px solid #f59e0b !important;">
                            <div class="d-flex align-items-center mb-1">
                                <div class="rounded-circle p-2 mr-2 d-flex align-items-center justify-content-center" style="background: #f59e0b; color: #fff; width: 32px; height: 32px; font-size: 0.9rem;">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <span class="font-weight-bold" style="color: #92400e; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Serviço</span>
                            </div>
                            <div class="mt-2 font-weight-bold" style="font-size: 1.05rem; color: #78350f !important;">
                                <span id="modal-servidor-servico">Não informado</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Aviso caso não encontrado -->
                <div id="modal-servidor-alerta-nao-encontrado" class="alert alert-warning border-0 shadow-sm mt-2 mb-0 d-none" style="border-radius: 10px; background-color: #fef3c7; color: #92400e;">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Servidor não localizado na tabela servidores. Exibindo dados informados.
                </div>

            </div>

            <div class="modal-footer py-2 px-4 bg-white border-top d-flex justify-content-between">
                <small class="text-muted"><i class="fas fa-check-circle text-success mr-1"></i> Informações da Tabela Servidores</small>
                <button type="button" class="btn btn-secondary font-weight-bold px-4 shadow-sm" data-dismiss="modal" style="border-radius: 8px;">Fechar</button>
            </div>

        </div>
    </div>
</div>

<form id="bulk-release-form" action="/emprestimos/salvarDataDevolucaoMultiplo" method="post" class="d-none">
<?= csrf_field() ?>

</form>
<form id="bulk-delete-form" action="/emprestimos/excluirMultiplo" method="post" class="d-none">
<?= csrf_field() ?>

</form>

<style>
    /* Estilos Modernos - Tela de Empréstimos */
    .modern-kpi-card {
        border-radius: 14px;
        border: none;
        padding: 1.15rem 1.25rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .modern-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
    }
    .modern-kpi-card .kpi-num {
        font-size: clamp(1.4rem, 2.2vw, 2rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 0.2rem;
    }
    .modern-kpi-card .kpi-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
        margin-bottom: 0;
    }
    .modern-kpi-card .kpi-icon-bg {
        position: absolute;
        right: 14px;
        bottom: 8px;
        font-size: 3.2rem;
        opacity: 0.18;
        pointer-events: none;
    }

    .emp-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0284c7, #0ea5e9);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
    }

    .badge-qtd-kits {
        font-size: 0.85rem;
        padding: 0.38rem 0.7rem;
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
    }

    .badge-kit-pill {
        font-size: 0.76rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        font-weight: 600;
        margin-right: 4px;
        margin-bottom: 4px;
        display: inline-flex;
        align-items: center;
        transition: background 0.15s ease;
    }
    .badge-kit-pill:hover {
        background: #e2e8f0;
    }

    .group-master-row {
        transition: background-color 0.15s ease;
    }
    .group-master-row:hover {
        background-color: #f8fafc !important;
    }
    .group-master-row td {
        vertical-align: middle !important;
    }

    .group-detail-row td {
        background-color: #f8fafc !important;
        border-top: none !important;
    }
    .group-detail-card {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.02);
    }

    .btn-toggle-group-detail {
        transition: transform 0.2s ease;
    }
    .btn-toggle-group-detail.expanded i {
        transform: rotate(180deg);
    }

    .view-toggle-btn.active {
        background-color: #0284c7 !important;
        border-color: #0284c7 !important;
        color: #fff !important;
        font-weight: 700;
    }

    #tabela-emprestimos td, #tabela-emprestimos th {
        vertical-align: middle;
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between mb-2">
                <div class="col-auto">
                    <h1 class="m-0 font-weight-bold text-dark d-flex align-items-center">
                        <i class="fas fa-handshake text-info mr-2"></i> Controle de Empréstimos
                    </h1>
                </div>
                <div class="col-auto d-flex align-items-center flex-wrap">
                    <button type="button" class="btn btn-info shadow-sm font-weight-bold mr-2 my-1" data-toggle="modal" data-target="#modal-novo-emprestimos">
                        <i class="fas fa-plus-circle mr-1"></i> Novo Empréstimo
                    </button>
                    <button type="button" class="btn btn-outline-secondary shadow-sm my-1" id="btn-toggle-resumo">
                        <i class="fas fa-eye mr-1"></i> Exibir Resumo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successCreate') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Empréstimo cadastrado com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successEdit') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Empréstimo editado com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successDevolucao') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Devolução registrada com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successDelete') : ?>
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-trash-alt mr-2"></i> Registro(s) excluído(s) com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>

            <?php
            // Calcular KPIs a partir dos dados
            $totalEmp = count($emprestimosBase ?? $emprestimos ?? []);
            $empAtivos = 0; $empChamados = 0;
            foreach (($emprestimosBase ?? $emprestimos ?? []) as $eKpi) {
                $st = mb_strtolower($eKpi['status_equipamento'] ?? '', 'UTF-8');
                if ($st === 'emprestado') { $empAtivos++; }
                elseif (strpos($st, 'chamado') !== false) { $empChamados++; }
            }
            $totalKitsDisponiveis = count($availableMochilas ?? []);
            $totalSolicitacoes = count($emprestimosAgrupados ?? []);
            ?>

            <!-- KPI Cards Modernos -->
            <div class="row no-print mb-3">
                <div class="col-6 col-md-3 mb-3">
                    <div class="modern-kpi-card" style="background: linear-gradient(135deg, #1e293b, #334155);">
                        <div class="kpi-num"><?= esc($totalSolicitacoes) ?> <small style="font-size: 0.95rem; font-weight: normal; opacity: 0.85;">(<?= esc($totalEmp) ?> kits)</small></div>
                        <p class="kpi-label">Solicitações Registradas</p>
                        <i class="fas fa-layer-group kpi-icon-bg"></i>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="modern-kpi-card" style="background: linear-gradient(135deg, #d97706, #b45309);">
                        <div class="kpi-num"><?= esc($empAtivos) ?></div>
                        <p class="kpi-label">Kits em Aberto (Ativos)</p>
                        <i class="fas fa-laptop kpi-icon-bg"></i>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="modern-kpi-card" style="background: linear-gradient(135deg, #059669, #047857);">
                        <div class="kpi-num"><?= esc($totalKitsDisponiveis) ?></div>
                        <p class="kpi-label">Kits Disponíveis</p>
                        <i class="fas fa-check-circle kpi-icon-bg"></i>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="modern-kpi-card" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                        <div class="kpi-num"><?= esc($empChamados) ?></div>
                        <p class="kpi-label">Chamados Abertos</p>
                        <i class="fas fa-headset kpi-icon-bg"></i>
                    </div>
                </div>
            </div>

            <!-- Filtros Modernos e Compactos -->
            <div class="card card-outline card-info shadow-sm no-print mb-3" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header py-2.5 bg-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark small text-uppercase mb-0">
                        <i class="fas fa-filter mr-1.5 text-info"></i> Filtros de Pesquisa
                    </h3>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Recolher filtros">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="card-body pt-3 pb-3">
                    <form method="get" action="/emprestimos">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-4 col-lg-3 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Solicitante:</label>
                                <select name="nome_recebedor" class="form-control form-control-sm">
                                    <option value="">Todos os solicitantes</option>
                                    <?php foreach ($nomeRecebedores as $nome): ?>
                                        <option value="<?= esc($nome) ?>" <?= ($filtros['nome_recebedor'] ?? '') === $nome ? 'selected' : '' ?>><?= esc($nome) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Responsável SEINTEC/SETEC:</label>
                                <select name="nome_responsavel" class="form-control form-control-sm">
                                    <option value="">Todos os responsáveis</option>
                                    <?php foreach ($nomeResponsaveis as $nome): ?>
                                        <option value="<?= esc($nome) ?>" <?= ($filtros['nome_responsavel'] ?? '') === $nome ? 'selected' : '' ?>><?= esc($nome) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-3 col-lg-1 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Recebimento:</label>
                                <input type="date" name="data_emprestimo" class="form-control form-control-sm" value="<?= esc($filtros['data_emprestimo'] ?? '') ?>">
                            </div>
                            <div class="col-6 col-md-3 col-lg-1 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Devolução:</label>
                                <input type="date" name="data_devolucao" class="form-control form-control-sm" value="<?= esc($filtros['data_devolucao'] ?? '') ?>">
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Seção:</label>
                                <select name="secao" class="form-control form-control-sm">
                                    <option value="">Todas</option>
                                    <?php foreach ($sessoes as $s): ?>
                                        <option value="<?= esc($s['secaoID'], 'attr') ?>" <?= ($filtros['secao'] ?? '') == $s['secaoID'] ? 'selected' : '' ?>><?= esc($s['nomeSecao']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-2">
                                <label class="small text-muted font-weight-bold mb-1">Status:</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    <?php foreach ($statusOptions as $status): ?>
                                        <option value="<?= esc($status) ?>" <?= ($filtros['status'] ?? '') == $status ? 'selected' : '' ?>><?= esc($status) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-2 col-lg-1 mb-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-info btn-sm flex-fill mr-1 shadow-xs" title="Aplicar Filtros">
                                    <i class="fas fa-filter mr-1"></i>Filtrar
                                </button>
                                <a href="/emprestimos" class="btn btn-outline-secondary btn-sm shadow-xs" title="Limpar Filtros">
                                    <i class="fas fa-undo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ações em Massa (Bulk Actions) -->
            <div class="row mb-2">
                <div class="col-12">
                    <div id="bulk-actions" class="d-none align-items-center mb-2 p-2 bg-white rounded shadow-sm border">
                        <span id="bulk-selected-count" class="mr-3 font-weight-bold badge badge-primary px-3 py-2"></span>
                        <button type="button" class="btn btn-success btn-sm mr-2 shadow-xs font-weight-bold" id="btn-bulk-liberar"><i class="fas fa-check mr-1"></i>Liberar Devolução</button>
                        <button type="button" class="btn btn-warning btn-sm mr-2 shadow-xs font-weight-bold" id="btn-bulk-editar"><i class="fas fa-edit mr-1"></i>Editar Selecionados</button>
                        <button type="button" class="btn btn-danger btn-sm shadow-xs font-weight-bold" id="btn-bulk-apagar"><i class="fas fa-trash mr-1"></i>Excluir Selecionados</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-12" id="emprestimos-list-col">
                    <div class="card card-outline card-secondary shadow-sm" style="border-radius: 12px; overflow: hidden;">
                        
                        <!-- Header com seletor de visualização (Agrupado vs Detalhado) -->
                        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap py-2.5 border-bottom">
                            <div class="d-flex align-items-center flex-wrap mr-2 my-1">
                                <h3 class="card-title font-weight-bold text-dark mb-0 small text-uppercase mr-3">
                                    <i class="fas fa-list text-info mr-1"></i> Lista de Empréstimos
                                </h3>
                                <span class="badge badge-light border text-muted px-2.5 py-1 font-weight-bold mr-2">
                                    <?= count($emprestimosAgrupados ?? []) ?> <?= (count($emprestimosAgrupados ?? []) === 1) ? 'solicitação' : 'solicitações' ?>
                                </span>
                                <span class="badge badge-info badge-pill px-2.5 py-1 font-weight-bold">
                                    <?= count($emprestimos) ?> <?= (count($emprestimos) === 1) ? 'kit' : 'kits no total' ?>
                                </span>
                            </div>

                            <div class="d-flex align-items-center flex-wrap my-1">
                                <!-- Filtro rápido de digitação -->
                                <div class="input-group input-group-sm mr-2 my-1" style="width: 230px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                                    </div>
                                    <input type="text" id="filtro-rapido-tabela" class="form-control border-left-0" placeholder="Busca rápida...">
                                </div>

                                <!-- Botões de alternância de visão -->
                                <div class="btn-group btn-group-sm shadow-xs my-1" role="group">
                                    <button type="button" class="btn btn-primary font-weight-bold view-toggle-btn active" id="btn-view-agrupada" title="Visualização agrupada por solicitante (sem redundância)">
                                        <i class="fas fa-layer-group mr-1"></i> Agrupado por Solicitante
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary font-weight-bold view-toggle-btn" id="btn-view-detalhada" title="Visualização item a item">
                                        <i class="fas fa-bars mr-1"></i> Detalhado (Kit a Kit)
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 1. TABELA AGRUPADA (SEM REDUNDÂNCIA DE NOMES) -->
                        <div id="view-agrupada" class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="tabela-emprestimos-agrupados">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width: 40px;">
                                                <input type="checkbox" id="select-all-agrupados" title="Selecionar todos os grupos">
                                            </th>
                                            <th style="min-width: 220px;">Solicitante</th>
                                            <th style="min-width: 170px;">Setor & Responsável</th>
                                            <th style="min-width: 250px;">Mochilas / Kits Pegos</th>
                                            <th style="min-width: 150px;">Retirada / Duração</th>
                                            <th style="min-width: 130px;">Status</th>
                                            <th class="text-center" style="min-width: 170px;">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($emprestimosAgrupados)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                                    Nenhum registro de empréstimo encontrado.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($emprestimosAgrupados as $grp): ?>
                                                <?php
                                                    $initials = mb_strtoupper(mb_substr(trim($grp['nome_recebedor'] ?? 'SB'), 0, 2));
                                                    $allIdsStr = implode(',', $grp['ids_emprestimo']);
                                                    $pendingIdsStr = implode(',', $grp['ids_pendentes']);
                                                ?>
                                                <tr class="group-master-row" data-group-id="<?= esc($grp['group_id']) ?>" data-search-text="<?= esc(mb_strtolower($grp['nome_recebedor'] . ' ' . $grp['email_recebedor'] . ' ' . $grp['setor_display'] . ' ' . $grp['nome_responsavel'] . ' ' . implode(' ', $grp['kits_numeros']))) ?>">
                                                    <td class="text-center">
                                                        <input type="checkbox" class="row-select-group" data-ids="<?= esc($allIdsStr) ?>" data-group-id="<?= esc($grp['group_id']) ?>">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="emp-avatar mr-2.5">
                                                                <?= esc($initials) ?>
                                                            </div>
                                                            <div class="overflow-hidden">
                                                                <div class="font-weight-bold text-dark d-flex align-items-center">
                                                                    <span class="text-truncate"><?= esc($grp['nome_recebedor']) ?></span>
                                                                    <?php if (!empty($grp['nome_recebedor'])): ?>
                                                                        <button type="button" class="btn btn-xs btn-link text-info p-0 ml-1.5 btn-abrir-servidor" data-nome="<?= esc($grp['nome_recebedor']) ?>" title="Ver informações do servidor">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="small text-muted text-truncate" style="max-width: 210px;" title="<?= esc($grp['email_recebedor']) ?>">
                                                                    <i class="far fa-envelope text-secondary mr-1"></i><?= esc($grp['email_recebedor'] ?: 'Não informado') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="badge badge-light border text-dark font-weight-bold px-2 py-1 mb-1 d-inline-block text-truncate" style="max-width: 190px;" title="<?= esc($grp['setor_display']) ?>">
                                                                <i class="fas fa-building text-info mr-1"></i><?= esc($grp['setor_display']) ?>
                                                            </span>
                                                            <div class="small text-muted d-flex align-items-center" title="Responsável SEINTEC">
                                                                <i class="fas fa-user-shield text-secondary mr-1"></i>
                                                                <span class="text-truncate" style="max-width: 170px;"><?= esc($grp['nome_responsavel']) ?></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center flex-wrap mb-1">
                                                            <!-- QUANTIDADE DE KITS PEGOS EM DESTAQUE -->
                                                            <span class="badge badge-primary badge-qtd-kits shadow-xs mr-1 mb-1">
                                                                <i class="fas fa-laptop mr-1.5"></i>
                                                                <?= $grp['total_kits'] ?> <?= ($grp['total_kits'] === 1) ? 'Kit / Notebook' : 'Kits / Notebooks' ?>
                                                            </span>
                                                            <?php if ($grp['total_kits'] > 1): ?>
                                                                <button type="button" class="btn btn-xs btn-outline-info rounded-pill py-0 px-2 mb-1 btn-toggle-group-detail font-weight-bold" data-target="#detail-<?= esc($grp['group_id']) ?>" title="Ver cada kit individualmente">
                                                                    <i class="fas fa-chevron-down mr-1"></i> Ver detalhes
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="d-flex flex-wrap align-items-center">
                                                            <?php foreach ($grp['itens'] as $it): ?>
                                                                <?php
                                                                    $dtDevCheck = $it['data_devolucao'] ?? '';
                                                                    $itPending = empty($dtDevCheck) || $dtDevCheck === '0000-00-00 00:00:00' || $dtDevCheck === '0000-00-00' || ($it['status_equipamento'] ?? '') === 'emprestado';
                                                                    $itChamado = strpos(mb_strtolower($it['status_equipamento'] ?? ''), 'chamado') !== false;
                                                                ?>
                                                                <span class="badge-kit-pill" title="Mochila/Kit #<?= esc($it['numero_mochila']) ?> (ID: <?= esc($it['id_emprestimo']) ?>) - <?= esc($it['status_equipamento']) ?>">
                                                                    <i class="fas fa-box text-muted mr-1"></i>Kit #<?= esc($it['numero_mochila']) ?>
                                                                    <?php if ($itChamado): ?>
                                                                        <span class="text-danger font-weight-bold ml-1" title="Chamado aberto">⚠️</span>
                                                                    <?php elseif ($itPending): ?>
                                                                        <span class="text-warning font-weight-bold ml-1" title="Em aberto">●</span>
                                                                    <?php else: ?>
                                                                        <span class="text-success font-weight-bold ml-1" title="Devolvido">✓</span>
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-bold text-dark small">
                                                            <i class="far fa-calendar-alt text-muted mr-1"></i><?= date('d/m/Y H:i', strtotime($grp['data_emprestimo'])) ?>
                                                        </div>
                                                        <div class="small mt-0.5">
                                                            <span class="badge badge-light border text-muted font-weight-normal duracao-emprestimo" data-start="<?= esc($grp['data_emprestimo']) ?>" data-end="<?= esc($grp['ultima_devolucao'] ?? '') ?>">
                                                                <?= esc($grp['duracao_emprestimo']) ?>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if ($grp['todos_devolvidos']): ?>
                                                            <span class="badge badge-success px-2 py-1 font-weight-bold shadow-xs">
                                                                <i class="fas fa-check-circle mr-1"></i> Devolvido
                                                            </span>
                                                            <?php if (!empty($grp['ultima_devolucao'])): ?>
                                                                <div class="small text-muted mt-1" style="font-size: 0.75rem;" title="Data da última devolução">
                                                                    <i class="fas fa-calendar-check text-success mr-1"></i><?= date('d/m/Y H:i', strtotime($grp['ultima_devolucao'])) ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php elseif ($grp['chamados_count'] > 0): ?>
                                                            <span class="badge badge-danger px-2 py-1 font-weight-bold shadow-xs">
                                                                <i class="fas fa-headset mr-1"></i> <?= $grp['chamados_count'] ?> Chamado(s)
                                                            </span>
                                                            <?php if ($grp['pendentes_count'] > $grp['chamados_count']): ?>
                                                                <div class="mt-1">
                                                                    <span class="badge badge-warning text-dark px-1.5 py-0.5 font-weight-bold" style="font-size: 0.72rem;">
                                                                        <?= ($grp['pendentes_count'] - $grp['chamados_count']) ?> Ativo(s)
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold shadow-xs">
                                                                <i class="fas fa-clock mr-1"></i> <?= $grp['pendentes_count'] ?> Emprestado(s)
                                                            </span>
                                                            <?php if ($grp['devolvidos_count'] > 0): ?>
                                                                <div class="mt-1">
                                                                    <span class="badge badge-success px-1.5 py-0.5 font-weight-bold" style="font-size: 0.72rem;">
                                                                        <?= $grp['devolvidos_count'] ?> Devolvido(s)
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <?php if ($grp['pendentes_count'] > 0): ?>
                                                                <button type="button" class="btn btn-success btn-sm mr-1 shadow-xs font-weight-bold btn-liberar-grupo" data-ids="<?= esc($pendingIdsStr) ?>" data-count="<?= esc($grp['pendentes_count']) ?>" title="Liberar devolução de <?= esc($grp['pendentes_count']) ?> kit(s) pendente(s)">
                                                                    <i class="fas fa-check mr-1"></i>Liberar
                                                                </button>
                                                            <?php endif; ?>
                                                            <button type="button" class="btn btn-warning btn-sm mr-1 shadow-xs btn-editar-grupo" data-group-id="<?= esc($grp['group_id']) ?>" title="Editar empréstimo deste solicitante">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-info btn-sm mr-1 shadow-xs btn-toggle-group-detail" data-target="#detail-<?= esc($grp['group_id']) ?>" title="Expandir/Recolher detalhes dos kits">
                                                                <i class="fas fa-chevron-down"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm shadow-xs btn-excluir-grupo" data-ids="<?= esc($allIdsStr) ?>" data-count="<?= esc($grp['total_kits']) ?>" title="Excluir empréstimo(s)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Sublinha de Detalhes dos Kits -->
                                                <tr id="detail-<?= esc($grp['group_id']) ?>" class="group-detail-row d-none">
                                                    <td colspan="7" class="p-3">
                                                        <div class="group-detail-card p-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                                                <span class="font-weight-bold text-dark small text-uppercase">
                                                                    <i class="fas fa-laptop text-info mr-1"></i> Detalhes dos <?= $grp['total_kits'] ?> kits de <?= esc($grp['nome_recebedor']) ?>
                                                                </span>
                                                                <small class="text-muted"><i class="fas fa-tag mr-1"></i>Lote: <?= esc($grp['group_id']) ?></small>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-bordered table-striped mb-0 text-nowrap">
                                                                    <thead class="bg-light">
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>ID do Kit / Mochila</th>
                                                                            <th>Pertence a</th>
                                                                            <th>Chamado</th>
                                                                            <th>Observações</th>
                                                                            <th>Data Recebimento</th>
                                                                            <th>Data Devolução</th>
                                                                            <th>Duração</th>
                                                                            <th>Status</th>
                                                                            <th class="text-center">Ações do Kit</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($grp['itens'] as $it): ?>
                                                                            <?php
                                                                                $dtDevCheck = $it['data_devolucao'] ?? '';
                                                                    $itPending = empty($dtDevCheck) || $dtDevCheck === '0000-00-00 00:00:00' || $dtDevCheck === '0000-00-00' || ($it['status_equipamento'] ?? '') === 'emprestado';
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= esc($it['id_emprestimo'] ?? '-') ?></td>
                                                                                <td class="font-weight-bold text-primary">Kit #<?= esc($it['numero_mochila']) ?></td>
                                                                                <td><?= esc($it['pertence_a'] ?: '-') ?></td>
                                                                                <td>
                                                                                    <?php if (!empty($it['numero_chamado'])): ?>
                                                                                        <span class="badge badge-danger">#<?= esc($it['numero_chamado']) ?></span>
                                                                                    <?php else: ?>
                                                                                        <span class="text-muted">-</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td style="max-width: 250px;" class="text-truncate" title="<?= esc($it['obs'] ?? '') ?>"><?= esc($it['obs'] ?: '-') ?></td>
                                                                                <td><?= esc($it['data_emprestimo']) ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                        $dtDev = $it['data_devolucao'] ?? '';
                                                                                        $dtDevDefault = $dtDev === '0000-00-00 00:00:00' || $dtDev === '0000-00-00';
                                                                                    ?>
                                                                                    <?php if (!empty($dtDev) && !$dtDevDefault): ?>
                                                                                        <?= esc($dtDev) ?>
                                                                                    <?php else: ?>
                                                                                        <button type="button" class="btn btn-success btn-xs btn-liberar-individual" data-id="<?= esc($it['id_emprestimo']) ?>">
                                                                                            <i class="fas fa-check mr-1"></i>Liberar
                                                                                        </button>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td class="duracao-emprestimo" data-start="<?= esc($it['data_emprestimo']) ?>" data-end="<?= esc($it['data_devolucao'] ?? '') ?>"><?= esc($it['duracao_emprestimo']) ?></td>
                                                                                <td>
                                                                                    <?php if (($it['status_equipamento'] ?? '') === 'chamado aberto'): ?>
                                                                                        <span class="badge badge-danger">Chamado aberto</span>
                                                                                    <?php elseif ($itPending): ?>
                                                                                        <span class="badge badge-warning text-dark font-weight-bold">Emprestado</span>
                                                                                    <?php else: ?>
                                                                                        <span class="badge badge-success">Devolvido</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <button type="button" class="btn btn-warning btn-xs mr-1 btn-editar-item-individual" data-id="<?= esc($it['id_emprestimo']) ?>" title="Editar este kit">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </button>
                                                                                    <a href="/emprestimos/excluir/<?= esc($it['id_emprestimo']) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Deseja excluir o empréstimo deste kit?')" title="Excluir este kit">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 2. TABELA DETALHADA ITEM A ITEM (MANTIDA PARA QUEM PREFERIR VER KIT POR KIT) -->
                        <div id="view-detalhada" class="card-body p-0" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0 text-nowrap" id="tabela-emprestimos">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center"><input type="checkbox" id="select-all-emprestimos"></th>
                                            <th>ID</th>
                                            <th>ID do Kit</th>
                                            <th>Setor</th>
                                            <th>Nome Solicitante</th>
                                            <th>Email Solicitante</th>
                                            <th>Responsável SEINTEC/SETEC</th>
                                            <th>Status</th>
                                            <th>Número Chamado</th>
                                            <th>Data Recebimento</th>
                                            <th>Data Devolução</th>
                                            <th>Duração de Empréstimo</th>
                                            <th>Obs</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($emprestimos as $e): ?>
                                            <tr
                                                data-id="<?= esc($e['id_emprestimo'] ?? '') ?>"
                                                data-numero-mochila="<?= esc($e['numero_mochila']) ?>"
                                                data-pertence-a="<?= esc($e['pertence_a'] ?? '') ?>"
                                                data-nome-recebedor="<?= esc($e['nome_recebedor']) ?>"
                                                data-email-recebedor="<?= esc($e['email_recebedor']) ?>"
                                                data-setor="<?= esc($e['setor'] ?? '') ?>"
                                                data-setor-display="<?= esc($e['setor_display'] ?? '') ?>"
                                                data-outro-setor="<?= esc($e['outro_setor'] ?? '') ?>"
                                                data-nome-responsavel="<?= esc($e['nome_responsavel']) ?>"
                                                data-status-equipamento="<?= esc($e['status_equipamento']) ?>"
                                                data-numero-chamado="<?= esc($e['numero_chamado'] ?? '') ?>"
                                                data-data-emprestimo="<?= esc($e['data_emprestimo']) ?>"
                                                data-data-devolucao="<?= esc($e['data_devolucao'] ?? '') ?>"
                                                data-obs="<?= esc($e['obs'] ?? '') ?>"
                                            >
                                                <td class="text-center">
                                                    <input type="checkbox" class="row-select-emprestimo" data-id="<?= esc($e['id_emprestimo'] ?? '') ?>">
                                                </td>
                                                <td><?= esc($e['id_emprestimo'] ?? '-') ?></td>
                                                <td><span class="badge badge-light border font-weight-bold">Kit #<?= esc($e['numero_mochila']) ?></span></td>
                                                <td><?= esc($e['setor_display'] ?? '-') ?></td>
                                                <td>
                                                    <?= esc($e['nome_recebedor']) ?>
                                                    <?php if (!empty($e['nome_recebedor'])): ?>
                                                        <button type="button" class="btn btn-xs btn-link text-info p-0 ml-1 btn-abrir-servidor" data-nome="<?= esc($e['nome_recebedor']) ?>" title="Ver informações do servidor">
                                                            <i class="fas fa-info-circle"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($e['email_recebedor']) ?></td>
                                                <td>
                                                    <?= esc($e['nome_responsavel']) ?>
                                                    <?php if (!empty($e['nome_responsavel'])): ?>
                                                        <button type="button" class="btn btn-xs btn-link text-info p-0 ml-1 btn-abrir-servidor" data-nome="<?= esc($e['nome_responsavel']) ?>" title="Ver informações do servidor">
                                                            <i class="fas fa-info-circle"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (($e['status_equipamento'] ?? '') === 'chamado aberto'): ?>
                                                        <span class="badge badge-danger">Chamado aberto</span>
                                                    <?php elseif (($e['status_equipamento'] ?? '') === 'emprestado'): ?>
                                                        <span class="badge badge-warning text-dark font-weight-bold">Emprestado</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">Devolvido</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($e['numero_chamado']) ?></td>
                                                <td><?= esc($e['data_emprestimo']) ?></td>
                                                <td>
                                                    <?php $dataDevolucao = $e['data_devolucao'] ?? '';
                                                    $devolucaoEhPadrao = $dataDevolucao === '0000-00-00 00:00:00' || $dataDevolucao === '0000-00-00';
                                                    if (!empty($dataDevolucao) && !$devolucaoEhPadrao): ?>
                                                        <?= esc($dataDevolucao) ?>
                                                    <?php else: ?>
                                                        <form method="post" action="/emprestimos/salvarDataDevolucao" class="d-flex align-items-center">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="id_emprestimo" value="<?= esc($e['id_emprestimo'] ?? '') ?>">
                                                            <input type="hidden" name="data_devolucao" class="data-devolucao-valor" value="">
                                                            <button type="submit" class="btn btn-success btn-sm btn-liberar-devolucao" data-id="<?= esc($e['id_emprestimo'] ?? '') ?>">
                                                                Liberar
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="duracao-emprestimo" data-start="<?= esc($e['data_emprestimo']) ?>" data-end="<?= esc($e['data_devolucao'] ?? '') ?>"><?= esc($e['duracao_emprestimo']) ?></td>
                                                <td><?= esc($e['obs']) ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" class="btn btn-warning btn-sm mr-1" onclick="openIndividualEditModal(this)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="/emprestimos/excluir/<?= esc($e['id_emprestimo']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este empréstimo?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Painel Lateral de Resumo por Mochila -->
                <div class="col-lg-3 col-12 d-none" id="resumo-mochila-panel">
                    <div class="card shadow-sm" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header bg-light py-2">
                            <h5 class="card-title font-weight-bold text-dark small text-uppercase mb-0">
                                <i class="fas fa-boxes mr-1 text-info"></i> Resumo por Mochila
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Número</th>
                                            <th>Status</th>
                                            <th>Duração</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($resumoMochilas)): ?>
                                            <?php foreach ($resumoMochilas as $resumo): ?>
                                                <tr>
                                                    <td class="font-weight-bold">Kit #<?= esc($resumo['numero'] ?? '-') ?></td>
                                                    <td>
                                                        <?php $stRes = $resumo['status'] ?? '-'; ?>
                                                        <?php if ($stRes === 'emprestado'): ?>
                                                            <span class="badge badge-warning text-dark font-weight-bold">Emprestado</span>
                                                        <?php elseif (strpos($stRes, 'chamado') !== false): ?>
                                                            <span class="badge badge-danger">Chamado</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-success">Disponível</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="duracao-emprestimo" data-start="<?= esc($resumo['data_emprestimo'] ?? '') ?>" data-end="<?= esc($resumo['data_devolucao'] ?? '') ?>"><?= esc($resumo['duracao_emprestimo'] ?? '-') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-3 text-muted">Nenhuma mochila encontrada.</td>
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
    </div>
</div>

<script>
    function removerParametroAlerta() {
        const url = new URL(window.location.href);
        url.searchParams.delete('alert');
        const newUrl = url.pathname + (url.search ? url.search : '');
        window.history.replaceState({}, document.title, newUrl);
    }

    window.removerParametroAlerta = removerParametroAlerta;

    document.addEventListener('DOMContentLoaded', function () {
        // group-scoped handlers are attached below for each cloned box

        const servidoresData = <?= json_encode($servidores, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const servidoresResponsavel = <?= json_encode($servidoresResponsavel, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const supervisoresExtras = <?= json_encode($supervisoresExtras ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const fieldsExtras = <?= json_encode($fieldsExtras ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

        function preencherSetor(servidor, group) {
            const setorInput = group.querySelector('.setor');
            const setorDisplayInput = group.querySelector('.setor-display');
            if (!setorInput || !setorDisplayInput) {
                return;
            }

            const secaoValor = servidor && servidor.secao !== undefined && servidor.secao !== null ? String(servidor.secao) : '';
            const servicoValor = servidor && servidor.servico !== undefined && servidor.servico !== null ? String(servidor.servico) : '';
            const secaoId = Number.parseInt(secaoValor, 10);
            const servicoId = Number.parseInt(servicoValor, 10);

            if (Number.isInteger(secaoId) && secaoId > 0 && servidor && servidor.secao_nome) {
                setorInput.value = 'secao:' + secaoId;
                setorDisplayInput.value = servidor.secao_nome;
            } else if (Number.isInteger(servicoId) && servicoId >= 0 && servidor && servidor.servico_nome) {
                setorInput.value = 'servico:' + servicoId;
                setorDisplayInput.value = servidor.servico_nome;
            } else {
                setorInput.value = '';
                setorDisplayInput.value = '';
            }
        }

        function preencherCamposServidor(servidor, tipo, group) {
            if (!servidor || !group) {
                return;
            }

            const nomeSolicitanteInput = group.querySelector('.nome-solicitante');
            const nomeResponsavelInput = group.querySelector('.nome-responsavel');
            const outroSetorInput = group.querySelector('.outro-setor');

            if (tipo === 'solicitante' && nomeSolicitanteInput) {
                nomeSolicitanteInput.value = servidor.nome_completo || '';
                if (!servidor.tipo || servidor.tipo === 'servidor') {
                    preencherSetor(servidor, group);
                    if (outroSetorInput) outroSetorInput.value = '';
                }
            }

            if (tipo === 'responsavel' && nomeResponsavelInput) {
                nomeResponsavelInput.value = servidor.nome_completo || '';
            }
        }

        function mostrarSugestoes(texto, listaElemento, tipo, group) {
            if (!listaElemento || !group) {
                return;
            }

            listaElemento.innerHTML = '';

            if (!texto) {
                return;
            }

            if (tipo === 'pertencente') {
                const filtradas = (typeof servidoresData !== 'undefined' ? servidoresData : []).filter(function (item) {
                    const nomeCompleto = (item.nome_completo || '').toLowerCase();
                    const pNome = (item.nome || '').toLowerCase();
                    const uNome = (item.ultimoNome || '').toLowerCase();
                    return nomeCompleto.indexOf(texto) !== -1 || pNome.indexOf(texto) !== -1 || uNome.indexOf(texto) !== -1;
                });

                filtradas.slice(0, 8).forEach(function (item) {
                    const itemLista = document.createElement('a');
                    itemLista.className = 'list-group-item list-group-item-action py-2 d-flex justify-content-between align-items-center';
                    itemLista.href = '#';
                    itemLista.style.cursor = 'pointer';
                    const ramalInfo = item.ramal ? `<span class="badge badge-success font-weight-normal"><i class="fas fa-phone-alt mr-1"></i>Ramal ${escapeHtml(item.ramal)}</span>` : '';
                    itemLista.innerHTML = `<div><i class="fas fa-user-circle text-info mr-2"></i><strong>${escapeHtml(item.nome_completo || '')}</strong></div> ${ramalInfo}`;
                    itemLista.onclick = function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        const pertencenteInput = group.querySelector('.nome-pertencente');
                        if (pertencenteInput) {
                            pertencenteInput.value = item.nome_completo || '';
                            pertencenteInput.focus();
                        }
                        listaElemento.innerHTML = '';
                    };
                    listaElemento.appendChild(itemLista);
                });
                return;
            }

            const baseServidores = (tipo === 'responsavel') ? servidoresResponsavel : servidoresData;
            const normalizedServidores = baseServidores.map(function (s) {
                return Object.assign({}, s, { tipo: s.tipo || 'servidor' });
            });

            const normalizedSupervisores = (tipo === 'solicitante' ? (supervisoresExtras || []).map(function (s) {
                return { nome_completo: s.nome_completo || s.Nome || '', tipo: 'supervisor' };
            }) : []);

            const normalizedFields = (tipo === 'solicitante' ? (fieldsExtras || []).map(function (f) {
                return { nome_completo: f.nome_completo || f.nome || '', tipo: 'field' };
            }) : []);

            const fonteCombinada = normalizedSupervisores.concat(normalizedFields, normalizedServidores);

            const filtradas = fonteCombinada.filter(function (item) {
                const nomeCompleto = (item.nome_completo || '').toLowerCase();
                return nomeCompleto.indexOf(texto) !== -1;
            });

            filtradas.slice(0, 8).forEach(function (item) {
                const itemLista = document.createElement('a');
                itemLista.className = 'list-group-item list-group-item-action';
                itemLista.href = '#';
                const tipoLabel = item.tipo === 'supervisor' ? ' (Supervisor)' : item.tipo === 'field' ? ' (Field)' : '';
                itemLista.textContent = (item.nome_completo || '') + tipoLabel;
                itemLista.onclick = function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const outro = group.querySelector('.outro-setor');
                    const setorInputEl = group.querySelector('.setor');
                    const setorDisplayEl = group.querySelector('.setor-display');

                    if (item.tipo === 'supervisor') {
                        if (outro) outro.value = 'Supervisor';
                        if (setorInputEl) setorInputEl.value = '';
                        if (setorDisplayEl) setorDisplayEl.value = 'Supervisor';
                    } else if (item.tipo === 'field') {
                        if (outro) outro.value = 'Field';
                        if (setorInputEl) setorInputEl.value = '';
                        if (setorDisplayEl) setorDisplayEl.value = 'Field';
                    } else {
                        if (outro) outro.value = '';
                    }

                    preencherCamposServidor(item, tipo === 'responsavel' ? 'responsavel' : 'solicitante', group);
                    listaElemento.innerHTML = '';

                    // move focus back to the input field
                    const inputField = group.querySelector(tipo === 'responsavel' ? '.nome-responsavel' : '.nome-solicitante');
                    if (inputField) inputField.focus();
                };
                listaElemento.appendChild(itemLista);
            });
        }

        function resetGroupSetor(group) {
            const setorInput = group.querySelector('.setor');
            const setorDisplayInput = group.querySelector('.setor-display');
            const outroSetorInput = group.querySelector('.outro-setor');
            if (setorInput) setorInput.value = '';
            if (setorDisplayInput) setorDisplayInput.value = '';
            if (outroSetorInput) outroSetorInput.value = '';
        }

        function clearAllSuggestions() {
            document.querySelectorAll('.lista-solicitantes, .lista-responsaveis, .lista-pertencentes').forEach(function (lista) {
                lista.innerHTML = '';
            });
        }

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.emprestimo-group')) {
                clearAllSuggestions();
            }
        });

        function formatarDataHoraParaInput(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}:00`;
        }

        document.querySelectorAll('.btn-liberar-devolucao').forEach(function (button) {
            button.addEventListener('click', function () {
                const form = button.closest('form');
                const hiddenInput = form ? form.querySelector('.data-devolucao-valor') : null;
                if (hiddenInput) {
                    hiddenInput.value = formatarDataHoraParaInput(new Date());
                }
            });
        });

        const bulkActions = document.getElementById('bulk-actions');
        const bulkSelectedCount = document.getElementById('bulk-selected-count');
        const selectAllCheckbox = document.getElementById('select-all-emprestimos');
        const bulkReleaseButton = document.getElementById('btn-bulk-liberar');
        const bulkEditButton = document.getElementById('btn-bulk-editar');
        const bulkDeleteButton = document.getElementById('btn-bulk-apagar');
        const bulkReleaseForm = document.getElementById('bulk-release-form');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const editGroupsContainer = document.getElementById('editar-emprestimo-groups');
        const editModal = document.getElementById('modal-editar-emprestimos');

        function escapeHtml(text) {
            return String(text || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function buildKitOptionsHtml(currentValue, kitList) {

            kitList = kitList || allKits;
            let html = '<option value="">Selecione</option>';
            kitList.forEach(function (kit) {
                html += '<option value="' + escapeHtml(kit) + '"' + (String(kit) === String(currentValue) ? ' selected' : '') + '>' + escapeHtml(kit) + '</option>';
            });
            return html;
        }

        const ZERO_DATE = '0000-00-00 00:00:00';

        function getSelectedRows() {
            return Array.from(document.querySelectorAll('.row-select-emprestimo:checked')).map(function (checkbox) {
                return checkbox.closest('tr');
            }).filter(function (row) {
                return row !== null;
            });
        }

        function isPendingDevolucaoValue(value) {
            return value === ZERO_DATE || value === '' || value === null || value === undefined;
        }

        function getPendingSelectedRows() {
            return getSelectedRows().filter(function (row) {
                return isPendingDevolucaoValue(row.dataset.dataDevolucao || '');
            });
        }

        function updateBulkActions() {
            const selectedRows = getSelectedRows();
            if (selectedRows.length > 0) {
                bulkActions.classList.remove('d-none');
                bulkSelectedCount.textContent = selectedRows.length + ' selecionado(s)';
            } else {
                bulkActions.classList.add('d-none');
                bulkSelectedCount.textContent = '';
            }

            const allCheckboxes = Array.from(document.querySelectorAll('.row-select-emprestimo'));
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allCheckboxes.length > 0 && allCheckboxes.every(function (checkbox) {
                    return checkbox.checked;
                });
            }
        }

        function clearBulkHiddenInputs(form) {
            Array.from(form.querySelectorAll('.bulk-hidden-input')).forEach(function (input) {
                input.parentNode.removeChild(input);
            });
        }

        function appendBulkHiddenInput(form, name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            input.className = 'bulk-hidden-input';
            form.appendChild(input);
        }

        function createEditGroupMarkup(row) {
            const id = row.dataset.id || '';
            const numeroMochila = row.dataset.numeroMochila || '';
            const pertenceA = row.dataset.pertenceA || '';
            const nomeRecebedor = row.dataset.nomeRecebedor || '';
            const emailRecebedor = row.dataset.emailRecebedor || '';
            const setor = row.dataset.setor || '';
            const setorDisplay = row.dataset.setorDisplay || '';
            const outroSetor = row.dataset.outroSetor || '';
            const nomeResponsavel = row.dataset.nomeResponsavel || '';
            const status = row.dataset.statusEquipamento || '';
            const numeroChamado = row.dataset.numeroChamado || '';
            const dataEmprestimo = row.dataset.dataEmprestimo || '';
            const dataDevolucao = row.dataset.dataDevolucao || '';
            const obs = row.dataset.obs || '';
            const chamadoChecked = status === 'chamado aberto' ? 'checked' : '';
            const chamadoStyle = status === 'chamado aberto' ? 'block' : 'none';
            const obsLabelText = status === 'chamado aberto' ? 'Descrição do problema' : 'Observações';

            return `
                <div class="emprestimo-group" data-id="${escapeHtml(id)}">
                    <div class="emprestimo-card">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>ID do Kit</label>
                                    <input type="hidden" name="id_emprestimo[]" value="${escapeHtml(id)}">
                                    <input type="hidden" name="pertence_a[]" value="${escapeHtml(pertenceA)}">
                                    <select name="numero_mochila[]" class="form-control numero-mochila" required>
                                        ${buildKitOptionsHtml(numeroMochila, allKitsForEdit)}
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nome do Solicitante</label>
                                    <input type="text" name="nome_recebedor[]" class="form-control nome-solicitante" required autocomplete="off" value="${escapeHtml(nomeRecebedor)}">
                                    <div class="list-group position-absolute w-100 lista-solicitantes" style="z-index:999; max-height:180px; overflow:auto;"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Email do Solicitante</label>
                                    <input type="email" name="email_recebedor[]" class="form-control" required value="${escapeHtml(emailRecebedor)}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Setor</label>
                                    <input type="text" class="form-control setor-display" readonly placeholder="Será preenchido automaticamente" value="${escapeHtml(setorDisplay)}">
                                    <input type="hidden" name="setor[]" class="setor" value="${escapeHtml(setor)}">
                                    <input type="hidden" name="outro_setor[]" class="outro-setor" value="${escapeHtml(outroSetor)}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nome do Responsável SEITEC/SETEC</label>
                                    <input type="text" name="nome_responsavel[]" class="form-control nome-responsavel" required autocomplete="off" value="${escapeHtml(nomeResponsavel)}">
                                    <div class="list-group position-absolute w-100 lista-responsaveis" style="z-index:999; max-height:180px; overflow:auto;"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="d-flex align-items-center" style="height: 38px;">
                                        <label class="mb-0 mr-2">Chamado aberto?</label>
                                        <div class="custom-control custom-checkbox custom-control-inline mb-0">
                                            <input type="hidden" name="status_equipamento[]" class="status-equipamento-hidden" value="${escapeHtml(status === 'chamado aberto' ? 'chamado aberto' : '')}">
                                            <input type="checkbox" class="custom-control-input status-equipamento" value="chamado aberto" ${chamadoChecked}>
                                            <label class="custom-control-label"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 container-numero-chamado" style="display:${chamadoStyle};">
                                <div class="form-group">
                                    <label>Número do Chamado</label>
                                    <input type="number" name="numero_chamado[]" class="form-control numero-chamado" value="${escapeHtml(numeroChamado)}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Data de Recebimento</label>
                                    <input type="text" name="data_emprestimo[]" class="form-control" value="${escapeHtml(dataEmprestimo)}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Data de Devolução</label>
                                    <div class="input-group">
                                        <input type="text" name="data_devolucao[]" class="form-control data-devolucao-input" value="${escapeHtml(dataDevolucao)}">
                                        <div class="input-group-append">
                                            <button type="button" class="btn ${dataDevolucao === ZERO_DATE ? 'btn-secondary disabled' : 'btn-danger'} btn-clear-data-devolucao" ${dataDevolucao === ZERO_DATE ? 'disabled' : ''}>Limpar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="obs-label">${escapeHtml(obsLabelText)}</label>
                                    <textarea name="obs[]" class="form-control" rows="3">${escapeHtml(obs)}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function updateClearButtonState(input, button) {
            const isZero = input.value === ZERO_DATE;
            button.disabled = isZero;
            button.classList.toggle('btn-secondary', isZero);
            button.classList.toggle('btn-danger', !isZero);
        }

        function initDevolucaoControls(group) {
            const input = group.querySelector('.data-devolucao-input');
            const button = group.querySelector('.btn-clear-data-devolucao');
            if (!input || !button) {
                return;
            }

            updateClearButtonState(input, button);

            input.addEventListener('input', function () {
                updateClearButtonState(input, button);
            });

            button.addEventListener('click', function () {
                if (button.disabled) {
                    return;
                }
                if (!confirm('Tem certeza que deseja limpar a data de devolução?')) {
                    return;
                }
                input.value = ZERO_DATE;
                updateClearButtonState(input, button);
            });
        }

        function populateEditModal(rows) {
            if (!editGroupsContainer) {
                return;
            }
            editGroupsContainer.innerHTML = '';
            rows.forEach(function (row) {
                editGroupsContainer.insertAdjacentHTML('beforeend', createEditGroupMarkup(row));
            });
            bindAllGroupHandlers();
            Array.from(editGroupsContainer.querySelectorAll('.emprestimo-group')).forEach(function (group) {
                initDevolucaoControls(group);
            });
        }

        function openBulkEditModal() {
            const rows = getSelectedRows();
            if (rows.length === 0) {
                return;
            }
            populateEditModal(rows);
            if (window.$ && typeof window.$ === 'function') {
                window.$(editModal).modal('show');
            }
        }

        window.openIndividualEditModal = function (button) {
            const row = button.closest('tr');
            if (!row) {
                return;
            }
            populateEditModal([row]);
            if (window.$ && typeof window.$ === 'function') {
                window.$(editModal).modal('show');
            }
        };

        function submitBulkRelease() {
            const rows = getPendingSelectedRows();
            if (rows.length === 0) {
                return;
            }
            clearBulkHiddenInputs(bulkReleaseForm);
            rows.forEach(function (row) {
                appendBulkHiddenInput(bulkReleaseForm, 'id_emprestimo[]', row.dataset.id || '');
            });
            appendBulkHiddenInput(bulkReleaseForm, 'data_devolucao', formatarDataHoraParaInput(new Date()));
            bulkReleaseForm.submit();
        }

        function submitBulkDelete() {
            const rows = getSelectedRows();
            if (rows.length === 0) {
                return;
            }
            if (!confirm('Tem certeza que deseja excluir os empréstimos selecionados?')) {
                return;
            }
            clearBulkHiddenInputs(bulkDeleteForm);
            rows.forEach(function (row) {
                appendBulkHiddenInput(bulkDeleteForm, 'id_emprestimo[]', row.dataset.id || '');
            });
            bulkDeleteForm.submit();
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                const checked = selectAllCheckbox.checked;
                document.querySelectorAll('.row-select-emprestimo').forEach(function (checkbox) {
                    checkbox.checked = checked;
                });
                updateBulkActions();
            });
        }

        document.querySelectorAll('.row-select-emprestimo').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                updateBulkActions();
            });
        });

        if (bulkReleaseButton) {
            bulkReleaseButton.addEventListener('click', submitBulkRelease);
        }
        if (bulkEditButton) {
            bulkEditButton.addEventListener('click', openBulkEditModal);
        }
        if (bulkDeleteButton) {
            bulkDeleteButton.addEventListener('click', submitBulkDelete);
        }

        updateBulkActions();

        function formatarDuracao(totalSeconds) {
            if (totalSeconds < 60) {
                return 'menos de 1 minuto';
            }

            const totalMinutes = Math.floor(totalSeconds / 60);
            const years = Math.floor(totalMinutes / (365 * 24 * 60));
            let remainingMinutes = totalMinutes % (365 * 24 * 60);
            const months = Math.floor(remainingMinutes / (30 * 24 * 60));
            remainingMinutes = remainingMinutes % (30 * 24 * 60);
            const weeks = Math.floor(remainingMinutes / (7 * 24 * 60));
            remainingMinutes = remainingMinutes % (7 * 24 * 60);
            const days = Math.floor(remainingMinutes / (24 * 60));
            remainingMinutes = remainingMinutes % (24 * 60);
            const hours = Math.floor(remainingMinutes / 60);
            const minutes = remainingMinutes % 60;

            const parts = [];
            if (years > 0) {
                parts.push(years + ' ano' + (years > 1 ? 's' : ''));
            }
            if (months > 0) {
                parts.push(months + ' mês' + (months > 1 ? 'es' : ''));
            }
            if (weeks > 0) {
                parts.push(weeks + ' semana' + (weeks > 1 ? 's' : ''));
            }
            if (days > 0) {
                parts.push(days + ' dia' + (days > 1 ? 's' : ''));
            }
            if (hours > 0) {
                parts.push(hours + ' hora' + (hours > 1 ? 's' : ''));
            }
            if (minutes > 0) {
                parts.push(minutes + ' minuto' + (minutes > 1 ? 's' : ''));
            }

            if (parts.length === 0) {
                return '1 minuto';
            }

            return parts.join(' ');
        }

        function isLeapYear(year) {
            return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
        }

        function daysInMonth(year, month) {
            const map = [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            return map[month - 1];
        }

        function isValidCalendarDate(year, month, day, hour, minute, second) {
            if (year < 1 || month < 1 || month > 12 || day < 1 || day > 31 || hour < 0 || hour > 23 || minute < 0 || minute > 59 || second < 0 || second > 59) {
                return false;
            }

            if (day > daysInMonth(year, month)) {
                return false;
            }

            return true;
        }

        function toJulianDayNumber(year, month, day) {
            let a = Math.floor((14 - month) / 12);
            let y = year + 4800 - a;
            let m = month + 12 * a - 3;
            return day + Math.floor((153 * m + 2) / 5) + 365 * y + Math.floor(y / 4) - Math.floor(y / 100) + Math.floor(y / 400) - 32045;
        }

        function datePartsToSeconds(parts) {
            const jd = toJulianDayNumber(parts.year, parts.month, parts.day);
            return (jd * 86400) + (parts.hour * 3600) + (parts.minute * 60) + parts.second;
        }

        function parseDateTime(value) {
            if (!value) {
                return null;
            }

            const rawValue = String(value).trim();
            if (!rawValue) {
                return null;
            }

            if (rawValue === '0000-00-00 00:00:00' || rawValue === '0000-00-00') {
                return null;
            }

            const isoMatch = rawValue.match(/^\s*(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2}):(\d{2})(?:\.\d+)?(?:Z|[+-]\d{2}:?\d{2})?\s*$/);
            if (isoMatch) {
                const year = Number(isoMatch[1]);
                const month = Number(isoMatch[2]);
                const day = Number(isoMatch[3]);
                const hour = Number(isoMatch[4]);
                const minute = Number(isoMatch[5]);
                const second = Number(isoMatch[6]);

                if (!isValidCalendarDate(year, month, day, hour, minute, second)) {
                    return null;
                }

                return { year, month, day, hour, minute, second };
            }

            const brasilMatch = rawValue.match(/^\s*(\d{2})\/(\d{2})\/(\d{4})(?:\s+(\d{2}):(\d{2}):?(\d{2})?)?\s*$/);
            if (brasilMatch) {
                const day = Number(brasilMatch[1]);
                const month = Number(brasilMatch[2]);
                const year = Number(brasilMatch[3]);
                const hour = Number(brasilMatch[4] || 0);
                const minute = Number(brasilMatch[5] || 0);
                const second = Number(brasilMatch[6] || 0);

                if (!isValidCalendarDate(year, month, day, hour, minute, second)) {
                    return null;
                }

                return { year, month, day, hour, minute, second };
            }

            return null;
        }

        function atualizarDuracoes() {
            const now = new Date();
            const nowParts = {
                year: now.getFullYear(),
                month: now.getMonth() + 1,
                day: now.getDate(),
                hour: now.getHours(),
                minute: now.getMinutes(),
                second: now.getSeconds()
            };

            document.querySelectorAll('.duracao-emprestimo').forEach(function (cell) {
                const startValue = cell.getAttribute('data-start');
                const endValue = cell.getAttribute('data-end');
                const start = parseDateTime(startValue);
                const end = parseDateTime(endValue) || nowParts;

                if (!start) {
                    cell.textContent = '-';
                    return;
                }

                const diffSeconds = Math.max(0, datePartsToSeconds(end) - datePartsToSeconds(start));
                cell.textContent = formatarDuracao(diffSeconds);
            });
        }

        atualizarDuracoes();
        setInterval(atualizarDuracoes, 1000);

        const allKits = <?= json_encode($availableMochilas ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const allKitsForEdit = <?= json_encode($allKits ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const groupsContainer = document.getElementById('emprestimo-groups');
        const btnAdd = document.getElementById('btn-add-group');
        const resumoPanel = document.getElementById('resumo-mochila-panel');
        const emprestimosListCol = document.getElementById('emprestimos-list-col');
        const btnToggleResumo = document.getElementById('btn-toggle-resumo');

        function updateResumoLayout(showResumo, forceUpdate) {
            if (!resumoPanel || !emprestimosListCol || !btnToggleResumo) {
                return;
            }

            if (showResumo) {
                resumoPanel.classList.remove('d-none');
                emprestimosListCol.classList.remove('col-lg-12');
                emprestimosListCol.classList.add('col-lg-9');
                btnToggleResumo.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar Resumo';
                btnToggleResumo.classList.remove('btn-secondary');
                btnToggleResumo.classList.add('btn-outline-secondary');
            } else {
                resumoPanel.classList.add('d-none');
                emprestimosListCol.classList.remove('col-lg-9');
                emprestimosListCol.classList.add('col-lg-12');
                btnToggleResumo.innerHTML = '<i class="fas fa-eye"></i> Exibir Resumo';
                btnToggleResumo.classList.remove('btn-outline-secondary');
                btnToggleResumo.classList.add('btn-secondary');
            }

            if (forceUpdate) {
                // trigger a layout recalculation to avoid initial compressed state
                // when the page loads and the panel starts hidden
                document.body.offsetHeight;
            }
        }

        if (btnToggleResumo) {
            btnToggleResumo.addEventListener('click', function () {
                const shouldShow = resumoPanel.classList.contains('d-none');
                updateResumoLayout(shouldShow, true);
            });
        }

        // Ensure the emprestimos list column starts at full width when the summary panel is hidden
        updateResumoLayout(false, true);

        function getNumeroSelects() {
            return Array.from(groupsContainer.querySelectorAll('select.numero-mochila'));
        }

        function rebuildKitOptions() {
            const selects = getNumeroSelects();
            const selected = selects.map(function (s) {
                return s.value;
            }).filter(function (value) {
                return value !== '';
            });

            selects.forEach(function (sel) {
                const current = sel.value;
                while (sel.firstChild) {
                    sel.removeChild(sel.firstChild);
                }

                const emptyOpt = document.createElement('option');
                emptyOpt.value = '';
                emptyOpt.textContent = 'Selecione';
                sel.appendChild(emptyOpt);

                allKits.forEach(function (kit) {
                    if (current === String(kit) || selected.indexOf(String(kit)) === -1) {
                        const opt = document.createElement('option');
                        opt.value = kit;
                        opt.textContent = kit;
                        sel.appendChild(opt);
                    }
                });

                sel.value = current;
            });
        }

        function updateRemoveButtons() {
            const groups = Array.from(groupsContainer.querySelectorAll('.emprestimo-group'));
            groups.forEach(function (g, idx) {
                const btn = g.querySelector('.btn-remove-group');
                if (!btn) return;
                btn.style.display = idx === 0 ? 'none' : '';
            });
        }

        function attachRemoveHandlers() {
            const buttons = Array.from(groupsContainer.querySelectorAll('.btn-remove-group'));
            buttons.forEach(function (btn) {
                btn.onclick = function (e) {
                    e.preventDefault();
                    const card = btn.closest('.emprestimo-card');
                    if (!card) return;

                    const inputs = Array.from(card.querySelectorAll('input, textarea, select'));
                    let hasValue = false;
                    inputs.forEach(function (field) {
                        const tag = field.tagName.toLowerCase();
                        if (tag === 'select') {
                            if (field.value && field.value !== '') hasValue = true;
                        } else if (field.type === 'checkbox' || field.type === 'radio') {
                            if (field.checked) hasValue = true;
                        } else if (field.value && String(field.value).trim() !== '') {
                            hasValue = true;
                        }
                    });

                    if (hasValue && !confirm('Esta caixa contém campos preenchidos. Tem certeza que deseja remover e perder esses dados?')) {
                        return;
                    }

                    const group = card.closest('.emprestimo-group');
                    if (group && group.parentNode) {
                        group.parentNode.removeChild(group);
                        rebuildKitOptions();
                        updateRemoveButtons();
                    }
                };
            });
        }

        function bindGroupHandlers(group) {
            if (!group) return;

            const nomePertencenteInput = group.querySelector('.nome-pertencente');
            const listaPertencentes = group.querySelector('.lista-pertencentes');
            const nomeSolicitanteInput = group.querySelector('.nome-solicitante');
            const nomeResponsavelInput = group.querySelector('.nome-responsavel');
            const listaSolicitantes = group.querySelector('.lista-solicitantes');
            const listaResponsaveis = group.querySelector('.lista-responsaveis');
            const statusCheckbox = group.querySelector('.status-equipamento');
            const chamadoContainer = group.querySelector('.container-numero-chamado');
            const numeroChamadoInput = group.querySelector('.numero-chamado');
            const obsLabel = group.querySelector('.obs-label');

            function toggleChamado() {
                if (!statusCheckbox || !chamadoContainer || !numeroChamadoInput || !obsLabel) return;

                if (statusCheckbox.checked) {
                    chamadoContainer.style.display = 'block';
                    numeroChamadoInput.required = true;
                    obsLabel.textContent = 'Descrição do problema';
                } else {
                    chamadoContainer.style.display = 'none';
                    numeroChamadoInput.required = false;
                    numeroChamadoInput.value = '';
                    obsLabel.textContent = 'Observações';
                }

                const hiddenStatus = group.querySelector('.status-equipamento-hidden');
                if (hiddenStatus) {
                    hiddenStatus.value = statusCheckbox.checked ? 'chamado aberto' : '';
                }
            }

            if (statusCheckbox) {
                statusCheckbox.addEventListener('change', toggleChamado);
                toggleChamado();
            }

            if (nomePertencenteInput && listaPertencentes) {
                nomePertencenteInput.addEventListener('input', function () {
                    const texto = this.value.trim().toLowerCase();
                    mostrarSugestoes(texto, listaPertencentes, 'pertencente', group);
                });
            }

            if (nomeSolicitanteInput) {
                nomeSolicitanteInput.addEventListener('input', function () {
                    const texto = this.value.trim().toLowerCase();
                    mostrarSugestoes(texto, listaSolicitantes, 'solicitante', group);
                    resetGroupSetor(group);
                });
            }

            if (nomeResponsavelInput) {
                nomeResponsavelInput.addEventListener('input', function () {
                    const texto = this.value.trim().toLowerCase();
                    mostrarSugestoes(texto, listaResponsaveis, 'responsavel', group);
                });
            }
        }

        function bindAllGroupHandlers() {
            document.querySelectorAll('.emprestimo-group').forEach(function (group) {
                bindGroupHandlers(group);
            });
        }

        function addGroup() {
            const allGroups = groupsContainer.querySelectorAll('.emprestimo-group');
            if (allGroups.length === 0) return;
            const lastGroup = allGroups[allGroups.length - 1];

            const clone = lastGroup.cloneNode(true);
            const newIndex = Date.now();
            clone.dataset.index = String(newIndex);

            // 1. Nome do Solicitante
            const srcNome = lastGroup.querySelector('.nome-solicitante');
            const cloneNome = clone.querySelector('.nome-solicitante');
            if (srcNome && cloneNome) cloneNome.value = srcNome.value;

            // 2. Email do Solicitante
            const srcEmail = lastGroup.querySelector('input[name="email_recebedor[]"]');
            const cloneEmail = clone.querySelector('input[name="email_recebedor[]"]');
            if (srcEmail && cloneEmail) cloneEmail.value = srcEmail.value;

            // 3. Setor (display e inputs hidden)
            const srcSetorDisp = lastGroup.querySelector('.setor-display');
            const cloneSetorDisp = clone.querySelector('.setor-display');
            if (srcSetorDisp && cloneSetorDisp) cloneSetorDisp.value = srcSetorDisp.value;

            const srcSetor = lastGroup.querySelector('.setor');
            const cloneSetor = clone.querySelector('.setor');
            if (srcSetor && cloneSetor) cloneSetor.value = srcSetor.value;

            const srcOutroSetor = lastGroup.querySelector('.outro-setor');
            const cloneOutroSetor = clone.querySelector('.outro-setor');
            if (srcOutroSetor && cloneOutroSetor) cloneOutroSetor.value = srcOutroSetor.value;

            // 4. Nome do Responsável SEITEC/SETEC
            const srcResp = lastGroup.querySelector('.nome-responsavel');
            const cloneResp = clone.querySelector('.nome-responsavel');
            if (srcResp && cloneResp) cloneResp.value = srcResp.value;

            // 5. Chamado Aberto (checkbox e hidden)
            const srcStatusCb = lastGroup.querySelector('.status-equipamento');
            const cloneStatusCb = clone.querySelector('.status-equipamento');
            const srcStatusHidden = lastGroup.querySelector('.status-equipamento-hidden');
            const cloneStatusHidden = clone.querySelector('.status-equipamento-hidden');
            if (srcStatusCb && cloneStatusCb) {
                cloneStatusCb.checked = srcStatusCb.checked;
            }
            if (srcStatusHidden && cloneStatusHidden) {
                cloneStatusHidden.value = srcStatusHidden.value;
            }

            // 6. Número do Chamado
            const srcNumChamado = lastGroup.querySelector('.numero-chamado');
            const cloneNumChamado = clone.querySelector('.numero-chamado');
            if (srcNumChamado && cloneNumChamado) {
                cloneNumChamado.value = srcNumChamado.value;
            }

            // 7. Observações
            const srcObs = lastGroup.querySelector('textarea[name="obs[]"]');
            const cloneObs = clone.querySelector('textarea[name="obs[]"]');
            if (srcObs && cloneObs) {
                cloneObs.value = srcObs.value;
            }

            // 8. ID do Kit: Este é o ÚNICO campo que não é copiado (vem em branco para seleção)
            const cloneKitSelect = clone.querySelector('select.numero-mochila');
            if (cloneKitSelect) {
                cloneKitSelect.value = '';
            }

            // 9. Limpar listas de autocompletes / sugestões
            clone.querySelectorAll('.list-group').forEach(function (lg) {
                lg.innerHTML = '';
            });

            // 10. Atualizar IDs para evitar duplicação no DOM
            const newCbId = 'status-equipamento-' + newIndex;
            if (cloneStatusCb) {
                cloneStatusCb.id = newCbId;
            }
            const cloneStatusLabel = clone.querySelector('.custom-control-label');
            if (cloneStatusLabel) {
                cloneStatusLabel.setAttribute('for', newCbId);
            }
            clone.querySelectorAll('[id]').forEach(function (el) {
                if (el !== cloneStatusCb) {
                    el.removeAttribute('id');
                }
            });

            groupsContainer.appendChild(clone);
            rebuildKitOptions();

            getNumeroSelects().forEach(function (s) {
                s.removeEventListener('change', rebuildKitOptions);
                s.addEventListener('change', rebuildKitOptions);
            });

            bindGroupHandlers(clone);
            attachRemoveHandlers();
            updateRemoveButtons();

            // Focar automaticamente no select do ID do Kit para o usuário só selecionar o próximo kit
            if (cloneKitSelect) {
                setTimeout(function () {
                    cloneKitSelect.focus();
                }, 100);
            }
        }

        if (btnAdd) {
            btnAdd.addEventListener('click', function (e) {
                e.preventDefault();
                addGroup();
                const modalBody = btnAdd.closest('.modal-content').querySelector('.modal-body');
                if (modalBody) modalBody.scrollTop = modalBody.scrollHeight;
            });
        }

        getNumeroSelects().forEach(function (s) {
            s.addEventListener('change', rebuildKitOptions);
        });

        attachRemoveHandlers();
        updateRemoveButtons();
        bindAllGroupHandlers();
        rebuildKitOptions();

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.emprestimo-group')) {
                document.querySelectorAll('.lista-solicitantes, .lista-responsaveis, .lista-pertencentes').forEach(function (lista) {
                    lista.innerHTML = '';
                });
            }
        });

        // ===============================================
        // MODAL DE DETALHES DO SERVIDOR / SUPERVISOR
        // ===============================================
        window.abrirModalServidor = function (nomeBuscado) {
            if (!nomeBuscado) return;
            nomeBuscado = String(nomeBuscado).trim();
            if (!nomeBuscado) return;

            const modalEl = $('#modal-detalhes-servidor');
            const alertNaoEncontrado = document.getElementById('modal-servidor-alerta-nao-encontrado');
            if (alertNaoEncontrado) alertNaoEncontrado.classList.add('d-none');

            // Valores iniciais de placeholder
            document.getElementById('modal-servidor-nome-completo').textContent = nomeBuscado;
            document.getElementById('modal-servidor-avatar').textContent = nomeBuscado.substring(0, 2).toUpperCase();
            document.getElementById('modal-servidor-id').textContent = '--';
            document.getElementById('modal-servidor-primeiro-nome').textContent = '--';
            document.getElementById('modal-servidor-ultimo-nome').textContent = '--';
            document.getElementById('modal-servidor-ramal').textContent = '--';
            document.getElementById('modal-servidor-secao').textContent = '--';
            document.getElementById('modal-servidor-servico').textContent = '--';

            const lowerBuscado = nomeBuscado.toLowerCase();

            // 1. Busca local na lista de servidores
            let servidor = (typeof servidoresData !== 'undefined' ? servidoresData : []).find(function (item) {
                if (!item) return false;
                const nc = (item.nome_completo || '').toLowerCase();
                const p = (item.nome || '').toLowerCase();
                const u = (item.ultimoNome || '').toLowerCase();
                return nc === lowerBuscado || p === lowerBuscado || nc.includes(lowerBuscado) || lowerBuscado.includes(nc);
            });

            if (servidor) {
                preencherModalComServidor(servidor);
                modalEl.modal('show');
                return;
            }

            // 2. Busca local na lista de supervisores
            let supervisor = (typeof supervisoresExtras !== 'undefined' ? supervisoresExtras : []).find(function (item) {
                if (!item) return false;
                const nc = (item.nome_completo || item.nome || '').toLowerCase();
                return nc === lowerBuscado || nc.includes(lowerBuscado) || lowerBuscado.includes(nc);
            });

            if (supervisor) {
                preencherModalComSupervisor(supervisor);
                modalEl.modal('show');
                return;
            }

            // 3. Fallback AJAX para buscar dinamicamente na rota do servidor
            fetch('/emprestimos/getServidorDetalhes?nome=' + encodeURIComponent(nomeBuscado))
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data && data.encontrado && data.dados) {
                        if (data.tipo === 'supervisor') {
                            preencherModalComSupervisor(data.dados);
                        } else {
                            preencherModalComServidor(data.dados);
                        }
                    } else {
                        if (alertNaoEncontrado) alertNaoEncontrado.classList.remove('d-none');
                        const tipoBadge = document.getElementById('modal-servidor-tipo');
                        tipoBadge.textContent = 'NÃO LOCALIZADO';
                        tipoBadge.className = 'badge badge-pill badge-secondary px-3 py-1 font-weight-bold mr-2 mb-1';
                    }
                    modalEl.modal('show');
                })
                .catch(function () {
                    if (alertNaoEncontrado) alertNaoEncontrado.classList.remove('d-none');
                    modalEl.modal('show');
                });
        };

        function preencherModalComServidor(s) {
            const nomeCompleto = s.nome_completo || (trim((s.nome || '') + ' ' + (s.ultimoNome || '')));
            document.getElementById('modal-servidor-nome-completo').textContent = nomeCompleto;
            const pChar = (s.nome ? s.nome.charAt(0) : '');
            const uChar = (s.ultimoNome ? s.ultimoNome.charAt(0) : (nomeCompleto.length > 1 ? nomeCompleto.charAt(1) : ''));
            document.getElementById('modal-servidor-avatar').textContent = (pChar + uChar).toUpperCase() || 'SV';
            document.getElementById('modal-servidor-id').textContent = s.servidorID || s.id || '--';
            document.getElementById('modal-servidor-primeiro-nome').textContent = s.nome || '-';
            document.getElementById('modal-servidor-ultimo-nome').textContent = s.ultimoNome || '-';
            document.getElementById('modal-servidor-ramal').textContent = s.ramal || 'Não informado';
            document.getElementById('modal-servidor-secao').textContent = s.secao_nome || (s.secao ? 'Seção #' + s.secao : 'Não informada');
            document.getElementById('modal-servidor-servico').textContent = s.servico_nome || (s.servico ? 'Serviço #' + s.servico : 'Não informado');

            const tipoBadge = document.getElementById('modal-servidor-tipo');
            tipoBadge.textContent = 'SERVIDOR';
            tipoBadge.className = 'badge badge-pill badge-primary px-3 py-1 font-weight-bold mr-2 mb-1';
            tipoBadge.style.backgroundColor = '#2563eb';
        }

        function preencherModalComSupervisor(sup) {
            const nomeCompleto = sup.nome_completo || sup.nome || '';
            document.getElementById('modal-servidor-nome-completo').textContent = nomeCompleto;
            document.getElementById('modal-servidor-avatar').textContent = nomeCompleto.substring(0, 2).toUpperCase() || 'SP';
            document.getElementById('modal-servidor-id').textContent = sup.id || sup.SupervisorId || '--';
            document.getElementById('modal-servidor-primeiro-nome').textContent = sup.nome || nomeCompleto;
            document.getElementById('modal-servidor-ultimo-nome').textContent = '-';
            document.getElementById('modal-servidor-ramal').textContent = sup.ramal || 'Não informado';
            document.getElementById('modal-servidor-secao').textContent = sup.setor_nome || (sup.setor_id ? 'Setor ' + sup.setor_id : 'Supervisão de Ensino');
            document.getElementById('modal-servidor-servico').textContent = sup.servico_nome || 'Supervisão';

            const tipoBadge = document.getElementById('modal-servidor-tipo');
            tipoBadge.textContent = 'SUPERVISOR';
            tipoBadge.className = 'badge badge-pill badge-success px-3 py-1 font-weight-bold mr-2 mb-1';
            tipoBadge.style.backgroundColor = '#10b981';
        }


        // ===============================================
        // CONTROLE DA VISUALIZAÇÃO (AGRUPADA VS DETALHADA)
        // ===============================================
        const btnViewAgrupada = document.getElementById('btn-view-agrupada');
        const btnViewDetalhada = document.getElementById('btn-view-detalhada');
        const viewAgrupada = document.getElementById('view-agrupada');
        const viewDetalhada = document.getElementById('view-detalhada');

        if (btnViewAgrupada && btnViewDetalhada && viewAgrupada && viewDetalhada) {
            btnViewAgrupada.addEventListener('click', function () {
                btnViewAgrupada.classList.add('active', 'btn-primary');
                btnViewAgrupada.classList.remove('btn-outline-primary', 'btn-outline-secondary');
                btnViewDetalhada.classList.remove('active', 'btn-primary');
                btnViewDetalhada.classList.add('btn-outline-secondary');
                viewAgrupada.style.display = 'block';
                viewDetalhada.style.display = 'none';
            });

            btnViewDetalhada.addEventListener('click', function () {
                btnViewDetalhada.classList.add('active', 'btn-primary');
                btnViewDetalhada.classList.remove('btn-outline-primary', 'btn-outline-secondary');
                btnViewAgrupada.classList.remove('active', 'btn-primary');
                btnViewAgrupada.classList.add('btn-outline-secondary');
                viewAgrupada.style.display = 'none';
                viewDetalhada.style.display = 'block';
            });
        }

        // ===============================================
        // FILTRO RÁPIDO CLIENT-SIDE (BUSCA EM TEMPO REAL)
        // ===============================================
        const fastSearchInput = document.getElementById('filtro-rapido-tabela');
        if (fastSearchInput) {
            fastSearchInput.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();

                // 1. Filtrar linhas na tabela agrupada
                document.querySelectorAll('.group-master-row').forEach(function (row) {
                    const text = (row.getAttribute('data-search-text') || '').toLowerCase();
                    const match = query === '' || text.indexOf(query) !== -1;
                    row.style.display = match ? '' : 'none';
                    const targetDetailId = '#detail-' + row.getAttribute('data-group-id');
                    const detailRow = document.querySelector(targetDetailId);
                    if (!match && detailRow) {
                        detailRow.classList.add('d-none');
                    }
                });

                // 2. Filtrar linhas na tabela detalhada
                document.querySelectorAll('#tabela-emprestimos tbody tr').forEach(function (row) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = (query === '' || text.indexOf(query) !== -1) ? '' : 'none';
                });
            });
        }

        // ===============================================
        // EXPANDIR / RECOLHER DETALHES DO GRUPO (ACCORDION)
        // ===============================================
        document.querySelectorAll('.btn-toggle-group-detail').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const targetSelector = btn.getAttribute('data-target');
                const targetRow = document.querySelector(targetSelector);
                if (targetRow) {
                    targetRow.classList.toggle('d-none');
                    const isNowOpen = !targetRow.classList.contains('d-none');
                    btn.classList.toggle('expanded', isNowOpen);
                }
            });
        });

        // ===============================================
        // LIBERAR GRUPO DE KITS PENDENTES
        // ===============================================
        document.querySelectorAll('.btn-liberar-grupo').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const ids = (btn.getAttribute('data-ids') || '').split(',').filter(Boolean);
                const count = btn.getAttribute('data-count') || ids.length;
                if (ids.length === 0) return;

                if (!confirm('Deseja registrar a devolução de ' + count + ' kit(s) pendente(s) deste solicitante agora?')) {
                    return;
                }

                clearBulkHiddenInputs(bulkReleaseForm);
                ids.forEach(function (id) {
                    appendBulkHiddenInput(bulkReleaseForm, 'id_emprestimo[]', id);
                });
                appendBulkHiddenInput(bulkReleaseForm, 'data_devolucao', formatarDataHoraParaInput(new Date()));
                bulkReleaseForm.submit();
            });
        });

        // ===============================================
        // LIBERAR KIT INDIVIDUAL NA SUBTABELA
        // ===============================================
        document.querySelectorAll('.btn-liberar-individual').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const id = btn.getAttribute('data-id');
                if (!id) return;

                if (!confirm('Confirmar a devolução deste kit agora?')) {
                    return;
                }

                clearBulkHiddenInputs(bulkReleaseForm);
                appendBulkHiddenInput(bulkReleaseForm, 'id_emprestimo[]', id);
                appendBulkHiddenInput(bulkReleaseForm, 'data_devolucao', formatarDataHoraParaInput(new Date()));
                bulkReleaseForm.submit();
            });
        });

        // ===============================================
        // EDITAR GRUPO DE KITS (MODAL DE EDIÇÃO MÚLTIPLA)
        // ===============================================
        document.querySelectorAll('.btn-editar-grupo').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const masterRow = btn.closest('.group-master-row');
                const checkbox = masterRow ? masterRow.querySelector('.row-select-group') : null;
                const ids = checkbox ? (checkbox.getAttribute('data-ids') || '').split(',').filter(Boolean) : [];

                const matchingRows = [];
                ids.forEach(function (id) {
                    const r = document.querySelector('#tabela-emprestimos tr[data-id="' + id + '"]');
                    if (r) matchingRows.push(r);
                });

                if (matchingRows.length > 0) {
                    populateEditModal(matchingRows);
                    if (window.$ && typeof window.$ === 'function') {
                        window.$(editModal).modal('show');
                    }
                }
            });
        });

        // ===============================================
        // EDITAR ITEM INDIVIDUAL NA SUBTABELA
        // ===============================================
        document.querySelectorAll('.btn-editar-item-individual').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const id = btn.getAttribute('data-id');
                const r = document.querySelector('#tabela-emprestimos tr[data-id="' + id + '"]');
                if (r) {
                    populateEditModal([r]);
                    if (window.$ && typeof window.$ === 'function') {
                        window.$(editModal).modal('show');
                    }
                }
            });
        });

        // ===============================================
        // EXCLUIR GRUPO DE KITS
        // ===============================================
        document.querySelectorAll('.btn-excluir-grupo').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const ids = (btn.getAttribute('data-ids') || '').split(',').filter(Boolean);
                const count = btn.getAttribute('data-count') || ids.length;
                if (ids.length === 0) return;

                if (!confirm('Tem certeza que deseja excluir o empréstimo deste(s) ' + count + ' kit(s)? Esta ação não pode ser desfeita.')) {
                    return;
                }

                clearBulkHiddenInputs(bulkDeleteForm);
                ids.forEach(function (id) {
                    appendBulkHiddenInput(bulkDeleteForm, 'id_emprestimo[]', id);
                });
                bulkDeleteForm.submit();
            });
        });

        // ===============================================
        // SELEÇÃO DE CHECKBOXES EM GRUPO
        // ===============================================
        const selectAllAgrupados = document.getElementById('select-all-agrupados');
        if (selectAllAgrupados) {
            selectAllAgrupados.addEventListener('change', function () {
                const checked = selectAllAgrupados.checked;
                document.querySelectorAll('.row-select-group').forEach(function (cb) {
                    cb.checked = checked;
                });
                document.querySelectorAll('.row-select-emprestimo').forEach(function (cb) {
                    cb.checked = checked;
                });
                updateBulkActions();
            });
        }

        document.querySelectorAll('.row-select-group').forEach(function (cb) {
            cb.addEventListener('change', function () {
                const ids = (cb.getAttribute('data-ids') || '').split(',').filter(Boolean);
                const checked = cb.checked;
                ids.forEach(function (id) {
                    const itemCb = document.querySelector('.row-select-emprestimo[data-id="' + id + '"]');
                    if (itemCb) {
                        itemCb.checked = checked;
                    }
                });
                updateBulkActions();
            });
        });

        // Delegação de evento de clique em .btn-abrir-servidor
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-abrir-servidor');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                const nome = btn.getAttribute('data-nome') || btn.dataset.nome;
                if (nome) {
                    abrirModalServidor(nome);
                }
            }
        });
    });
</script>

    <style>
    .emprestimo-card { border:1px solid #ccc; border-radius:4px; padding:15px; padding-bottom:22px; margin-bottom:12px; position:relative; background:#fff; box-sizing:border-box; width:100%; }
    /* Keep default Bootstrap row/col spacing inside the card so fields align as before */
    .emprestimo-card .row { /* no override, use Bootstrap defaults */ }
    .emprestimo-card .col-4 { /* use Bootstrap padding */ }
    .emprestimo-card .col-12 { /* use Bootstrap padding */ }
    .btn-remove-group { position:relative; display:inline-block; margin-top:12px; float:right; }
    </style>

