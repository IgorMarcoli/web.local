<div class="content-wrapper">
    <!-- Cabeçalho da Escola -->
    <div class="content-header bg-white border-bottom shadow-sm mb-3 py-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <a href="/escolaequip" class="btn btn-outline-secondary btn-sm mr-3 font-weight-bold" title="Voltar ao Diretório de Escolas">
                        <i class="fas fa-arrow-left mr-1"></i> Voltar
                    </a>
                    <div>
                        <div class="d-flex align-items-center flex-wrap">
                            <h2 class="m-0 font-weight-bold text-dark mr-3" style="font-size: 1.45rem;">
                                <?= esc($escola['escola_nome']) ?>
                            </h2>
                            <span class="badge badge-primary px-3 py-1 font-weight-bold mr-2" style="font-size: .85rem;">
                                CIE: <?= esc($escola['escola_cie']) ?>
                            </span>
                            <span class="badge badge-light border text-muted px-2 py-1" style="font-size: .8rem;">
                                <i class="fas fa-map-marker-alt text-danger mr-1"></i><?= esc($escola['ure_diretoria'] ?: 'SAO VICENTE') ?>
                            </span>
                        </div>
                        <p class="text-muted small mb-0 mt-1">
                            Visualizando todos os equipamentos alocados nesta unidade escolar
                        </p>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="d-flex align-items-center">
                    <a href="/escolaequip/exportar/<?= urlencode($escola['escola_cie']) ?>" class="btn btn-success btn-sm font-weight-bold shadow-sm px-3" title="Baixar planilha completa em formato CSV/Excel">
                        <i class="fas fa-file-excel mr-1"></i> Exportar CSV
                    </a>
                    <button type="button" class="btn btn-outline-primary btn-sm font-weight-bold ml-2 shadow-sm" onclick="window.print();" title="Imprimir relatório">
                        <i class="fas fa-print mr-1"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <div class="container-fluid">

            <!-- Cards de Indicadores da Escola -->
            <?php
                $totalEsc = (int)($escola['total_equipamentos'] ?? 0);
                $dispEsc  = (int)($escola['total_disponivel'] ?? 0);
                $manutEsc = (int)($escola['total_manutencao'] ?? 0);
                $insEsc   = (int)($escola['total_inservivel'] ?? 0);

                $pctDisp  = $totalEsc > 0 ? round(($dispEsc / $totalEsc) * 100) : 0;
                $pctManut = $totalEsc > 0 ? round(($manutEsc / $totalEsc) * 100) : 0;
                $pctIns   = $totalEsc > 0 ? round(($insEsc / $totalEsc) * 100) : 0;
            ?>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format($totalEsc, 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Total de Equipamentos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format($dispEsc, 0, ',', '.') ?> <small style="font-size: .95rem; opacity: .85;">(<?= $pctDisp ?>%)</small></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Disponíveis para Uso</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format($manutEsc, 0, ',', '.') ?> <small style="font-size: .95rem; opacity: .85;">(<?= $pctManut ?>%)</small></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Em Manutenção / Chamado</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format($insEsc, 0, ',', '.') ?> <small style="font-size: .95rem; opacity: .85;">(<?= $pctIns ?>%)</small></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Inservíveis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-ban" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categorias Resumo (Pills de Acesso Rápido) -->
            <?php if (!empty($categoriasResumo)): ?>
                <div class="card shadow-sm mb-3" style="border-radius: 12px;">
                    <div class="card-body py-2 px-3">
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="font-weight-bold text-dark small mr-2">
                                <i class="fas fa-filter text-primary mr-1"></i> Categorias presentes:
                            </span>
                            <button type="button" class="btn btn-xs btn-outline-secondary font-weight-bold mr-1 mb-1 btn-filtro-categoria active" data-categoria="">
                                Todas (<?= $totalEsc ?>)
                            </button>
                            <?php foreach ($categoriasResumo as $cr): ?>
                                <button type="button" class="btn btn-xs btn-outline-info font-weight-bold mr-1 mb-1 btn-filtro-categoria" data-categoria="<?= esc($cr['categoria']) ?>">
                                    <?= esc($cr['categoria']) ?> <span class="badge badge-light ml-1"><?= (int)$cr['total'] ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Painel de Filtros e Busca de Equipamentos -->
            <div class="card card-outline card-primary shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" id="filtroTexto" class="form-control bg-light"
                                       placeholder="Buscar por Hostname, Nº Série, Modelo, Chamado...">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <!-- Filtro Categoria -->
                                <div class="col-sm-4 mb-2 mb-sm-0">
                                    <select id="filtroCategoriaSelect" class="form-control form-control-sm bg-light">
                                        <option value="">— Todas as Categorias —</option>
                                        <?php foreach ($filtrosDisponiveis['categorias'] as $cat): ?>
                                            <option value="<?= esc($cat) ?>"><?= esc($cat) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Filtro Status -->
                                <div class="col-sm-4 mb-2 mb-sm-0">
                                    <select id="filtroStatusSelect" class="form-control form-control-sm bg-light">
                                        <option value="">— Todos os Status —</option>
                                        <?php foreach ($filtrosDisponiveis['status'] as $st): ?>
                                            <option value="<?= esc($st) ?>"><?= esc($st) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Filtro Ambiente -->
                                <div class="col-sm-4">
                                    <select id="filtroAmbienteSelect" class="form-control form-control-sm bg-light">
                                        <option value="">— Todos os Ambientes —</option>
                                        <?php foreach ($filtrosDisponiveis['ambientes'] as $amb): ?>
                                            <option value="<?= esc($amb) ?>"><?= esc($amb) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Equipamentos -->
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0 text-sm align-middle" id="tabelaEquipamentos">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;" class="text-center">#</th>
                                <th>Categoria</th>
                                <th>Fabricante / Modelo</th>
                                <th>Hostname / Nº de Série</th>
                                <th>Ambiente / Local</th>
                                <th style="width: 130px;" class="text-center">Status</th>
                                <th style="width: 100px;">Avaliação</th>
                                <th>Chamado / Visita</th>
                                <th style="width: 80px;" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="corpoTabelaEquipamentos">
                            <?php if (!empty($equipamentos) && is_array($equipamentos)): ?>
                                <?php foreach ($equipamentos as $idx => $eq): ?>
                                    <?php
                                        $st = mb_strtolower(trim($eq['status_equipamento'] ?? ''), 'UTF-8');
                                        $badgeClass = 'badge-secondary';
                                        if (in_array($st, ['disponível', 'disponivel'])) {
                                            $badgeClass = 'badge-success';
                                        } elseif (in_array($st, ['inservível', 'inservivel'])) {
                                            $badgeClass = 'badge-danger';
                                        } elseif (strpos($st, 'manuten') !== false || strpos($st, 'chamado') !== false || strpos($st, 'peça') !== false) {
                                            $badgeClass = 'badge-warning text-dark';
                                        } elseif (strpos($st, 'danificad') !== false || strpos($st, 'físico') !== false) {
                                            $badgeClass = 'badge-danger';
                                        }

                                        // Ícone por categoria
                                        $catLow = mb_strtolower($eq['categoria'] ?? '', 'UTF-8');
                                        $iconCat = 'fa-desktop';
                                        if (strpos($catLow, 'notebook') !== false) $iconCat = 'fa-laptop';
                                        elseif (strpos($catLow, 'tablet') !== false) $iconCat = 'fa-tablet-alt';
                                        elseif (strpos($catLow, 'tv') !== false) $iconCat = 'fa-tv';
                                        elseif (strpos($catLow, 'switch') !== false || strpos($catLow, 'rack') !== false) $iconCat = 'fa-network-wired';
                                        elseif (strpos($catLow, 'ap') !== false || strpos($catLow, 'acess') !== false) $iconCat = 'fa-wifi';
                                        elseif (strpos($catLow, 'smartphone') !== false) $iconCat = 'fa-mobile-alt';
                                    ?>
                                    <tr class="equip-row"
                                        data-categoria="<?= esc(trim($eq['categoria'] ?? '')) ?>"
                                        data-status="<?= esc(trim($eq['status_equipamento'] ?? '')) ?>"
                                        data-ambiente="<?= esc(trim($eq['ambiente'] ?? '')) ?>"
                                        data-search="<?= esc(mb_strtolower(($eq['hostname'] ?? '') . ' ' . ($eq['numero_serie'] ?? '') . ' ' . ($eq['modelo'] ?? '') . ' ' . ($eq['fabricante'] ?? '') . ' ' . ($eq['categoria'] ?? '') . ' ' . ($eq['id_controle_ue'] ?? '') . ' ' . ($eq['numero_chamado'] ?? '') . ' ' . ($eq['tecnico_responsavel'] ?? '') . ' ' . ($eq['descricao'] ?? ''), 'UTF-8')) ?>"
                                        data-json='<?= htmlspecialchars(json_encode($eq, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>'>

                                        <td class="text-center align-middle font-weight-bold text-muted" style="font-size: .78rem;">
                                            <?= $idx + 1 ?>
                                        </td>

                                        <td class="align-middle">
                                            <div class="font-weight-bold text-dark d-flex align-items-center">
                                                <i class="fas <?= $iconCat ?> text-info mr-2" style="font-size: .95rem;"></i>
                                                <?= esc($eq['categoria'] ?: 'Outro') ?>
                                            </div>
                                            <?php if (!empty($eq['id_controle_ue']) && trim($eq['id_controle_ue']) !== 'S/N'): ?>
                                                <small class="badge badge-light border text-muted">UE: <?= esc($eq['id_controle_ue']) ?></small>
                                            <?php endif; ?>
                                        </td>

                                        <td class="align-middle">
                                            <div class="font-weight-bold text-dark"><?= esc($eq['fabricante']) ?></div>
                                            <div class="text-muted small"><?= esc($eq['modelo']) ?></div>
                                        </td>

                                        <td class="align-middle">
                                            <?php if (!empty($eq['hostname'])): ?>
                                                <div class="font-weight-bold text-primary" style="font-family: monospace; font-size: .85rem;">
                                                    <i class="fas fa-server mr-1"></i><?= esc($eq['hostname']) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="text-muted small" style="font-family: monospace;">
                                                S/N: <?= esc($eq['numero_serie'] ?: '-') ?>
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <div class="font-weight-bold text-secondary">
                                                <i class="fas fa-door-open mr-1 text-muted"></i><?= esc($eq['ambiente'] ?: '-') ?>
                                            </div>
                                            <?php if (!empty($eq['descricao'])): ?>
                                                <div class="text-muted small"><?= esc($eq['descricao']) ?></div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center align-middle">
                                            <span class="badge <?= $badgeClass ?> px-2 py-1" style="font-size: .75rem; border-radius: 12px; font-weight: 600;">
                                                <?= esc($eq['status_equipamento'] ?: 'Indefinido') ?>
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="small font-weight-bold text-muted"><?= esc($eq['avaliacao_tecnica'] ?: '-') ?></span>
                                        </td>

                                        <td class="align-middle text-muted small">
                                            <?php if (!empty($eq['numero_chamado'])): ?>
                                                <div class="font-weight-bold text-dark">
                                                    <i class="fas fa-ticket-alt text-warning mr-1"></i><?= esc($eq['numero_chamado']) ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($eq['tecnico_responsavel'])): ?>
                                                <div><i class="fas fa-user-cog mr-1"></i><?= esc($eq['tecnico_responsavel']) ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($eq['data_visita'])): ?>
                                                <div><i class="far fa-calendar-alt mr-1"></i><?= date('d/m/Y', strtotime($eq['data_visita'])) ?></div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-xs btn-outline-info btn-detalhes font-weight-bold px-2 py-1 shadow-sm"
                                                    title="Ver ficha completa">
                                                <i class="fas fa-info-circle mr-1"></i> Detalhes
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="fas fa-laptop-code fa-3x mb-3 text-secondary d-block"></i>
                                        Nenhum equipamento cadastrado para esta escola.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr id="semEquipamentos" style="display: none;">
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-search fa-2x mb-2 text-secondary d-block"></i>
                                    Nenhum equipamento encontrado com os filtros selecionados.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Rodapé da Tabela com Paginação e Contadores -->
                <div class="card-footer bg-white py-3 border-top d-flex flex-wrap justify-content-between align-items-center">
                    <div class="text-muted small mb-2 mb-md-0" id="contadorEquipamentos">
                        Mostrando <strong><?= count($equipamentos) ?></strong> equipamentos
                    </div>

                    <div class="d-flex align-items-center">
                        <label class="small text-muted mr-2 mb-0">Itens por página:</label>
                        <select id="itensPorPagina" class="form-control form-control-sm mr-3" style="width: 80px;">
                            <option value="25">25</option>
                            <option value="50" selected>50</option>
                            <option value="100">100</option>
                            <option value="all">Todos</option>
                        </select>
                        <ul class="pagination pagination-sm m-0" id="paginacaoNav"></ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal de Ficha Técnica Completa do Equipamento -->
<div class="modal fade" id="modalDetalhesEquipamento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 14px;">
            <div class="modal-header py-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff;">
                <h5 class="modal-title font-weight-bold" id="modalTitulo">
                    <i class="fas fa-laptop mr-2"></i>Ficha Detalhada do Equipamento
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="modalConteudo">
                <!-- Preenchido dinamicamente via JS -->
            </div>
            <div class="modal-footer bg-light py-2 px-4 border-top">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold px-3" data-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .table td, .table th { vertical-align: middle; }
    .btn-filtro-categoria.active {
        background-color: #0284c7 !important;
        color: #fff !important;
        border-color: #0284c7 !important;
    }
    @media print {
        .main-sidebar, .main-header, .main-footer, .btn, .breadcrumb, #modalDetalhesEquipamento { display: none !important; }
        .content-wrapper { margin-left: 0 !important; background: #fff !important; }
        .card { border: 1px solid #ccc !important; box-shadow: none !important; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputTexto = document.getElementById('filtroTexto');
    const selectCategoria = document.getElementById('filtroCategoriaSelect');
    const selectStatus = document.getElementById('filtroStatusSelect');
    const selectAmbiente = document.getElementById('filtroAmbienteSelect');
    const selectItensPorPagina = document.getElementById('itensPorPagina');
    const paginacaoNav = document.getElementById('paginacaoNav');
    const contador = document.getElementById('contadorEquipamentos');
    const msgSemItens = document.getElementById('semEquipamentos');
    const todasLinhas = Array.from(document.querySelectorAll('.equip-row'));
    const btnsPills = document.querySelectorAll('.btn-filtro-categoria');

    let linhasFiltradas = [...todasLinhas];
    let paginaAtual = 1;
    let itensPorPagina = parseInt(selectItensPorPagina.value, 10);

    function aplicarFiltros() {
        const termoTexto = (inputTexto.value || '').toLowerCase().trim();
        const catFiltro = (selectCategoria.value || '').trim();
        const statusFiltro = (selectStatus.value || '').trim();
        const ambFiltro = (selectAmbiente.value || '').trim();

        linhasFiltradas = todasLinhas.filter(function (linha) {
            const rowCat = linha.getAttribute('data-categoria') || '';
            const rowStatus = linha.getAttribute('data-status') || '';
            const rowAmb = linha.getAttribute('data-ambiente') || '';
            const rowSearch = linha.getAttribute('data-search') || '';

            if (catFiltro && rowCat !== catFiltro) return false;
            if (statusFiltro && rowStatus !== statusFiltro) return false;
            if (ambFiltro && rowAmb !== ambFiltro) return false;
            if (termoTexto && !rowSearch.includes(termoTexto)) return false;

            return true;
        });

        paginaAtual = 1;
        renderizar();
    }

    function renderizar() {
        const total = linhasFiltradas.length;
        const totalPaginas = itensPorPagina === 'all' ? 1 : Math.ceil(total / itensPorPagina);

        todasLinhas.forEach(r => r.style.display = 'none');

        if (total === 0) {
            msgSemItens.style.display = '';
            contador.innerHTML = 'Nenhum equipamento encontrado';
            paginacaoNav.innerHTML = '';
            return;
        }

        msgSemItens.style.display = 'none';

        let inicio = 0;
        let fim = total;

        if (itensPorPagina !== 'all') {
            inicio = (paginaAtual - 1) * itensPorPagina;
            fim = Math.min(inicio + itensPorPagina, total);
        }

        for (let i = inicio; i < fim; i++) {
            linhasFiltradas[i].style.display = '';
        }

        contador.innerHTML = `Mostrando <strong>${inicio + 1}</strong> a <strong>${fim}</strong> de <strong>${total}</strong> equipamentos (${todasLinhas.length} no total)`;

        // Renderizar paginação
        renderizarPaginacao(totalPaginas);
    }

    function renderizarPaginacao(totalPaginas) {
        paginacaoNav.innerHTML = '';
        if (totalPaginas <= 1) return;

        const maxButtons = 5;
        let startPage = Math.max(1, paginaAtual - Math.floor(maxButtons / 2));
        let endPage = Math.min(totalPaginas, startPage + maxButtons - 1);

        if (endPage - startPage < maxButtons - 1) {
            startPage = Math.max(1, endPage - maxButtons + 1);
        }

        // Botão anterior
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${paginaAtual === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
        prevLi.onclick = function (e) {
            e.preventDefault();
            if (paginaAtual > 1) { paginaAtual--; renderizar(); }
        };
        paginacaoNav.appendChild(prevLi);

        for (let p = startPage; p <= endPage; p++) {
            const li = document.createElement('li');
            li.className = `page-item ${p === paginaAtual ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${p}</a>`;
            li.onclick = (function (pag) {
                return function (e) {
                    e.preventDefault();
                    paginaAtual = pag;
                    renderizar();
                };
            })(p);
            paginacaoNav.appendChild(li);
        }

        // Botão próximo
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${paginaAtual === totalPaginas ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
        nextLi.onclick = function (e) {
            e.preventDefault();
            if (paginaAtual < totalPaginas) { paginaAtual++; renderizar(); }
        };
        paginacaoNav.appendChild(nextLi);
    }

    inputTexto.addEventListener('input', aplicarFiltros);
    selectCategoria.addEventListener('change', function () {
        const val = this.value;
        btnsPills.forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-categoria') === val);
        });
        aplicarFiltros();
    });
    selectStatus.addEventListener('change', aplicarFiltros);
    selectAmbiente.addEventListener('change', aplicarFiltros);

    selectItensPorPagina.addEventListener('change', function () {
        itensPorPagina = this.value === 'all' ? 'all' : parseInt(this.value, 10);
        paginaAtual = 1;
        renderizar();
    });

    // Filtros rápidos via Pills de Categoria
    btnsPills.forEach(btn => {
        btn.addEventListener('click', function () {
            btnsPills.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectCategoria.value = this.getAttribute('data-categoria') || '';
            aplicarFiltros();
        });
    });

    // Modal de Detalhes
    document.querySelectorAll('.btn-detalhes').forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('.equip-row');
            const data = JSON.parse(row.getAttribute('data-json') || '{}');

            let html = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="p-3 rounded bg-light border">
                            <h6 class="font-weight-bold text-primary mb-2"><i class="fas fa-laptop mr-1"></i> Identificação do Equipamento</h6>
                            <p class="mb-1"><strong>Categoria:</strong> ${data.categoria || '-'}</p>
                            <p class="mb-1"><strong>Fabricante:</strong> ${data.fabricante || '-'}</p>
                            <p class="mb-1"><strong>Modelo:</strong> ${data.modelo || '-'}</p>
                            <p class="mb-1"><strong>Hostname:</strong> <code class="text-primary">${data.hostname || '-'}</code></p>
                            <p class="mb-1"><strong>Nº de Série:</strong> <code>${data.numero_serie || '-'}</code></p>
                            <p class="mb-0"><strong>ID Controle UE:</strong> ${data.id_controle_ue || '-'}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="p-3 rounded bg-light border">
                            <h6 class="font-weight-bold text-success mb-2"><i class="fas fa-map-marker-alt mr-1"></i> Localização & Estado</h6>
                            <p class="mb-1"><strong>Ambiente:</strong> ${data.ambiente || '-'}</p>
                            <p class="mb-1"><strong>Descrição / Detalhe:</strong> ${data.descricao || '-'}</p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge badge-info">${data.status_equipamento || '-'}</span></p>
                            <p class="mb-1"><strong>Avaliação Técnica:</strong> ${data.avaliacao_tecnica || '-'}</p>
                            <p class="mb-0"><strong>Aba / Origem:</strong> ${data.aba || '-'}</p>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-3 rounded bg-light border">
                            <h6 class="font-weight-bold text-warning mb-2"><i class="fas fa-wrench mr-1"></i> Chamado & Visita Técnica</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Nº Chamado:</strong> ${data.numero_chamado || '-'}</p>
                                    <p class="mb-1"><strong>Data Abertura:</strong> ${data.data_abertura_chamado || '-'}</p>
                                    <p class="mb-0"><strong>Data da Visita:</strong> ${data.data_visita || '-'}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Técnico Responsável:</strong> ${data.tecnico_responsavel || '-'}</p>
                                    <p class="mb-1"><strong>Status da Visita:</strong> ${data.status_visita || '-'}</p>
                                    <p class="mb-0"><strong>Observações:</strong> ${data.observacoes || 'Nenhuma observação registrada.'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('modalConteudo').innerHTML = html;
            $('#modalDetalhesEquipamento').modal('show');
        });
    });

    renderizar();
});
</script>

