<style>
    /* Estilos responsivos e limpos */
    .kpi-box {
        border-radius: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }
    .kpi-box .inner h3 {
        font-size: clamp(1.4rem, 2.5vw, 2rem);
        font-weight: 700;
        margin-bottom: 4px;
    }
    .kpi-box .inner p {
        font-size: clamp(0.75rem, 1.2vw, 0.9rem);
        margin-bottom: 0;
        opacity: 0.9;
    }
    .table td, .table th {
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

<!-- Modal Único de Equipamento (Cadastro e Edição) -->
<div class="modal fade" id="modal-equipamento" tabindex="-1" role="dialog" aria-labelledby="modalEquipamentoTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <form id="form-equipamento" action="/equipamentos/salvar" method="post">
                <?= csrf_field() ?>
                <input type="hidden" id="equip-id-item" name="id_item" value="">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="modalEquipamentoTitulo">
                        <i class="fas fa-laptop mr-2"></i>Novo Equipamento
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold">Tipo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equip-tipo" name="tipo" placeholder="Ex: Computador, Monitor, Nobreak..." required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold">Marca e Modelo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equip-marca-modelo" name="marca_modelo" placeholder="Ex: Dell OptiPlex 3080..." required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold">Nº de Patrimônio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equip-patrimonio" name="patrimonio" placeholder="Ex: PAT-10492" required>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="font-weight-bold">Nº de Serial <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equip-serial" name="serial" placeholder="Ex: BRJ1234XYZ" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label class="font-weight-bold">Estado de Conservação <span class="text-danger">*</span></label>
                            <select class="form-control" id="equip-estado" name="estado_conservacao" required>
                                <option value="">Selecione...</option>
                                <option value="Excelente">Excelente</option>
                                <option value="Bom" selected>Bom</option>
                                <option value="Ruim">Ruim</option>
                                <option value="Péssimo">Péssimo</option>
                                <option value="Chamado Aberto">Chamado Aberto</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label class="font-weight-bold">Categoria <span class="text-danger">*</span></label>
                            <select class="form-control" id="equip-categoria" name="categoria" required>
                                <option value="">Selecione...</option>
                                <?php if (!empty($categorias)) : ?>
                                    <?php foreach ($categorias as $cat) : ?>
                                        <option value="<?= esc($cat['nome'] ?? '') ?>"><?= esc($cat['nome'] ?? '-') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label class="font-weight-bold">Sala</label>
                            <select class="form-control" id="equip-sala" name="sala">
                                <option value="">Selecione...</option>
                                <?php if (!empty($salas)) : ?>
                                    <?php foreach ($salas as $sala) : ?>
                                        <option value="<?= esc($sala['id_sala'] ?? '') ?>"><?= esc($sala['nome_sala'] ?? '-') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="font-weight-bold"><i class="fas fa-user-tag text-info mr-1"></i> Com quem está / Responsável</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="equip-responsavel" name="responsavel"
                                       autocomplete="off" placeholder="Digite o nome do servidor responsável...">
                                <div class="list-group position-absolute w-100 shadow-sm lista-responsaveis-equip"
                                     style="z-index:1100; max-height:200px; overflow:auto; top:100%; left:0;"></div>
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>Busca servidores cadastrados na tabela de servidores.</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-salvar-equipamento">
                        <i class="fas fa-save mr-1"></i> Cadastrar
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
                        <i class="fas fa-desktop text-primary mr-2"></i> Equipamentos
                    </h1>
                </div>
                <div class="col-auto d-flex align-items-center flex-wrap no-print">
                    <button type="button" class="btn btn-success shadow-sm font-weight-bold mr-2 my-1" onclick="abrirModalNovo()">
                        <i class="fas fa-plus mr-1"></i> Novo Equipamento
                    </button>
                    <button type="button" class="btn btn-outline-secondary shadow-sm my-1" onclick="window.print()" title="Imprimir Relatório">
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
            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successCreate') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Equipamento registrado com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'successEdit') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Equipamento atualizado com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'successDelete') : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> Equipamento excluído com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php elseif (isset($_GET['alert']) && in_array($_GET['alert'], ['errorCreate', 'errorEdit', 'errorDelete'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Ocorreu um erro ao processar a solicitação.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar" onclick="removerParametroAlerta()">&times;</button>
                </div>
            <?php endif; ?>

            <!-- Cards Indicadores (KPIs) Responsivos -->
            <div class="row no-print mb-2">
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-info kpi-box shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $stats['total'] ?? count($itens) ?></h3>
                            <p>Total Geral</p>
                        </div>
                        <div class="icon"><i class="fas fa-laptop"></i></div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-success kpi-box shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $stats['excelenteBom'] ?? 0 ?></h3>
                            <p>Em Bom Estado</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-warning kpi-box shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $stats['atencaoProblema'] ?? 0 ?></h3>
                            <p>Ruim / Péssimo</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="small-box bg-danger kpi-box shadow-sm mb-0">
                        <div class="inner p-3">
                            <h3><?= $stats['chamadosAbertos'] ?? 0 ?></h3>
                            <p>Chamados Abertos</p>
                        </div>
                        <div class="icon"><i class="fas fa-headset"></i></div>
                    </div>
                </div>
            </div>

            <!-- Filtros de Pesquisa Simplificados e Responsivos -->
            <div class="card card-outline card-primary shadow-sm no-print mb-3">
                <div class="card-body p-3">
                    <form action="/equipamentos" method="get">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-4 col-lg-4 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">Pesquisa rápida:</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="busca" id="input-busca-geral"
                                           placeholder="Tipo, modelo, serial ou patrimônio..."
                                           value="<?= esc($filtros['busca'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">Estado:</label>
                                <select class="form-control form-control-sm" name="estado">
                                    <option value="">Todos</option>
                                    <option value="Excelente" <?= (($filtros['estado'] ?? '') === 'Excelente') ? 'selected' : '' ?>>Excelente</option>
                                    <option value="Bom" <?= (($filtros['estado'] ?? '') === 'Bom') ? 'selected' : '' ?>>Bom</option>
                                    <option value="Ruim" <?= (($filtros['estado'] ?? '') === 'Ruim') ? 'selected' : '' ?>>Ruim</option>
                                    <option value="Péssimo" <?= (($filtros['estado'] ?? '') === 'Péssimo') ? 'selected' : '' ?>>Péssimo</option>
                                    <option value="Chamado Aberto" <?= (($filtros['estado'] ?? '') === 'Chamado Aberto') ? 'selected' : '' ?>>Chamado Aberto</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">Categoria:</label>
                                <select class="form-control form-control-sm" name="categoria">
                                    <option value="">Todas</option>
                                    <?php if (!empty($categorias)): ?>
                                        <?php foreach ($categorias as $cat): ?>
                                            <?php $nomeCat = $cat['nome'] ?? ''; ?>
                                            <option value="<?= esc($nomeCat) ?>" <?= (($filtros['categoria'] ?? '') === $nomeCat) ? 'selected' : '' ?>>
                                                <?= esc($nomeCat) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-2 col-lg-2 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">Sala:</label>
                                <select class="form-control form-control-sm" name="sala">
                                    <option value="">Todas</option>
                                    <?php if (!empty($salas)): ?>
                                        <?php foreach ($salas as $sl): ?>
                                            <?php $idSl = $sl['id_sala'] ?? ''; $nomeSl = $sl['nome_sala'] ?? ''; ?>
                                            <option value="<?= esc($idSl) ?>" <?= (($filtros['sala'] ?? '') == $idSl) ? 'selected' : '' ?>>
                                                <?= esc($nomeSl) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-12 col-lg-2 d-flex">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill mr-1" title="Aplicar Filtros">
                                    <i class="fas fa-filter mr-1"></i> Filtrar
                                </button>
                                <?php if (!empty($filtros['busca']) || !empty($filtros['estado']) || !empty($filtros['categoria']) || !empty($filtros['sala'])): ?>
                                    <a href="/equipamentos" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela Principal Limpa e 100% Responsiva -->
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title font-weight-bold text-dark mb-0 small text-uppercase">
                        <i class="fas fa-list mr-1"></i> Lista de Equipamentos
                    </h3>
                    <span class="badge badge-primary badge-pill px-2 py-1">
                        <?= count($itens) ?> <?= (count($itens) === 1) ? 'item' : 'itens' ?>
                    </span>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0 text-nowrap" id="tabela-equipamentos">
                        <thead class="thead-light">
                            <tr>
                                <th>Tipo</th>
                                <th>Marca e Modelo</th>
                                <th>Nº Patrimônio</th>
                                <th>Nº Serial</th>
                                <th>Estado</th>
                                <th>Categoria</th>
                                <th>Sala / Andar</th>
                                <th><i class="fas fa-user-tag mr-1 text-info"></i>Responsável</th>
                                <th>Data</th>
                                <th class="text-center no-print" style="width: 100px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($itens)) : ?>
                                <?php foreach ($itens as $item) : ?>
                                    <?php
                                        $st = trim((string)($item['estado_conservacao'] ?? ''));
                                        $stLower = mb_strtolower($st, 'UTF-8');
                                        $badgeClass = 'badge-secondary';
                                        if (strpos($stLower, 'excelente') !== false) {
                                            $badgeClass = 'badge-success';
                                        } elseif (strpos($stLower, 'bom') !== false) {
                                            $badgeClass = 'badge-info';
                                        } elseif (strpos($stLower, 'ruim') !== false) {
                                            $badgeClass = 'badge-warning';
                                        } elseif (strpos($stLower, 'péssimo') !== false || strpos($stLower, 'pessimo') !== false) {
                                            $badgeClass = 'badge-danger';
                                        } elseif (strpos($stLower, 'chamado') !== false) {
                                            $badgeClass = 'badge-danger';
                                        }
                                    ?>
                                    <tr class="linha-equipamento">
                                        <td class="font-weight-bold text-dark">
                                            <i class="fas fa-desktop text-primary mr-1"></i><?= esc($item['tipo'] ?? '-') ?>
                                        </td>
                                        <td><?= esc($item['marca_modelo'] ?? '-') ?></td>
                                        <td>
                                            <?php if (!empty($item['patrimonio'])): ?>
                                                <span class="code-tag"><?= esc($item['patrimonio']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['serial'])): ?>
                                                <span class="code-tag"><?= esc($item['serial']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-status <?= $badgeClass ?>">
                                                <?= esc($st ?: '-') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light border"><?= esc($item['categoria'] ?? '-') ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['nome_sala'] ?? $item['sala'])): ?>
                                                <i class="fas fa-door-open text-muted mr-1"></i><?= esc($item['nome_sala'] ?? $item['sala']) ?>
                                                <?php if (!empty($item['andar'])): ?>
                                                    <small class="text-muted d-block"><?= esc($item['andar']) ?>º andar</small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['responsavel'])): ?>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-info font-weight-bold btn-abrir-servidor-equip shadow-sm"
                                                        data-nome="<?= esc($item['responsavel']) ?>"
                                                        title="Clique para ver informações do servidor responsável"
                                                        style="border-radius: 20px; padding: 2px 10px; border-width: 2px;">
                                                    <i class="fas fa-user-circle mr-1 text-info"></i><?= esc($item['responsavel']) ?>
                                                </button>
                                            <?php else: ?>
                                                <span class="text-muted font-italic">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><small class="text-muted"><?= esc($item['data_registro'] ?? '-') ?></small></td>
                                        <td class="text-center no-print">
                                            <button type="button" class="btn btn-sm btn-outline-primary" title="Editar" 
                                                    onclick="abrirModalEditar(
                                                        '<?= esc($item['id_item'] ?? '', 'js') ?>',
                                                        '<?= esc($item['tipo'] ?? '', 'js') ?>',
                                                        '<?= esc($item['marca_modelo'] ?? '', 'js') ?>',
                                                        '<?= esc($item['patrimonio'] ?? '', 'js') ?>',
                                                        '<?= esc($item['serial'] ?? '', 'js') ?>',
                                                        '<?= esc($item['estado_conservacao'] ?? '', 'js') ?>',
                                                        '<?= esc($item['categoria'] ?? '', 'js') ?>',
                                                        '<?= esc($item['sala'] ?? '', 'js') ?>',
                                                        '<?= esc($item['responsavel'] ?? '', 'js') ?>'
                                                    )">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="/equipamentos/excluir/<?= esc($item['id_item'] ?? '', 'url') ?>" method="post" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este equipamento?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger ml-1" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fas fa-box-open"></i>
                                            <h5 class="text-secondary font-weight-bold">Nenhum equipamento encontrado</h5>
                                            <p class="text-muted mb-3">Não há equipamentos cadastrados ou correspondentes aos filtros.</p>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="abrirModalNovo()">
                                                <i class="fas fa-plus mr-1"></i> Cadastrar Equipamento
                                            </button>
                                            <?php if (!empty($filtros['busca']) || !empty($filtros['estado']) || !empty($filtros['categoria']) || !empty($filtros['sala'])): ?>
                                                <a href="/equipamentos" class="btn btn-sm btn-outline-secondary ml-2">
                                                    <i class="fas fa-undo mr-1"></i> Limpar Filtros
                                                </a>
                                            <?php endif; ?>
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

<script>
    function removerParametroAlerta() {
        const url = new URL(window.location.href);
        url.searchParams.delete('alert');
        window.history.replaceState({}, document.title, url.pathname + (url.search ? url.search : ''));
    }

    function abrirModalNovo() {
        document.getElementById('form-equipamento').reset();
        document.getElementById('equip-id-item').value = '';
        document.getElementById('modalEquipamentoTitulo').innerHTML = '<i class="fas fa-plus-circle mr-2"></i>Novo Equipamento';
        document.getElementById('btn-salvar-equipamento').innerHTML = '<i class="fas fa-save mr-1"></i>Cadastrar';
        $('#modal-equipamento').modal('show');
    }

    function abrirModalEditar(id, tipo, marcaModelo, patrimonio, serial, estado, categoria, sala) {
        document.getElementById('equip-id-item').value = id || '';
        document.getElementById('equip-tipo').value = tipo || '';
        document.getElementById('equip-marca-modelo').value = marcaModelo || '';
        document.getElementById('equip-patrimonio').value = patrimonio || '';
        document.getElementById('equip-serial').value = serial || '';
        document.getElementById('equip-estado').value = estado || '';
        document.getElementById('equip-categoria').value = categoria || '';
        document.getElementById('equip-sala').value = sala || '';

        document.getElementById('modalEquipamentoTitulo').innerHTML = '<i class="fas fa-edit mr-2"></i>Editar Equipamento';
        document.getElementById('btn-salvar-equipamento').innerHTML = '<i class="fas fa-check mr-1"></i>Atualizar';
        $('#modal-equipamento').modal('show');
    }

    // Filtro instantâneo em tempo real na tabela
    document.addEventListener('DOMContentLoaded', function () {
        var inputBusca = document.getElementById('input-busca-geral');
        if (inputBusca) {
            inputBusca.addEventListener('keyup', function () {
                var termo = this.value.toLowerCase().trim();
                var linhas = document.querySelectorAll('#tabela-equipamentos tbody tr.linha-equipamento');

                linhas.forEach(function (linha) {
                    var texto = linha.textContent.toLowerCase();
                    linha.style.display = (texto.indexOf(termo) > -1) ? '' : 'none';
                });
            });
        }

        // Auto-fechar alertas após 5 segundos
        setTimeout(function () {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
