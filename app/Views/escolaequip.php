<div class="content-wrapper">
    <!-- Cabeçalho -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-school mr-2 text-primary"></i>Inventário por Escola
                    </h1>
                    <p class="text-muted small mb-0">Gestão e acompanhamento dos equipamentos das <?= number_format((int)($stats['total_escolas'] ?? 0), 0, ',', '.') ?> escolas cadastradas</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home mr-1"></i>Home</a></li>
                        <li class="breadcrumb-item">Conexão App</li>
                        <li class="breadcrumb-item">Escolas</li>
                        <li class="breadcrumb-item active">Inventário por Escola</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="content">
        <div class="container-fluid">

            <!-- Mensagem de erro / feedback -->
            <?php if (session()->getFlashdata('erro')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i><?= esc(session()->getFlashdata('erro')) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php
                $totalInventario = (int)($stats['total_equipamentos'] ?? 0);
                $disponiveis = (int)($stats['total_disponivel'] ?? 0);
                $manutencao = (int)($stats['total_manutencao'] ?? 0);
                $inserviveis = (int)($stats['total_inservivel'] ?? 0);
                $semStatus = (int)($stats['total_sem_status'] ?? 0);
                $cardsIndicadores = [
                    ['Escolas cadastradas', (int)($stats['total_escolas'] ?? 0), 'fa-school', '#0284c7', '#0369a1'],
                    ['Equipamentos', $totalInventario, 'fa-laptop', '#4f46e5', '#3730a3'],
                    ['Disponíveis', $disponiveis, 'fa-check-circle', '#10b981', '#059669'],
                    ['Em manutenção', $manutencao, 'fa-tools', '#f59e0b', '#d97706'],
                    ['Inservíveis', $inserviveis, 'fa-ban', '#ef4444', '#b91c1c'],
                    ['Sem status definido', $semStatus, 'fa-question-circle', '#64748b', '#475569'],
                ];
                $categoriasGrafico = $resumoCategorias ?? [];
                $escolasGrafico = $escolasCriticas ?? [];
                $alturaGraficoCategorias = max(340, count($categoriasGrafico) * 38);
                $totalEscolasCriticasGrafico = count($escolasGrafico);
            ?>
            <div class="row">
                <?php foreach ($cardsIndicadores as [$rotulo, $valor, $icone, $corInicio, $corFim]): ?>
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="small-box shadow-sm" style="background: linear-gradient(135deg, <?= $corInicio ?> 0%, <?= $corFim ?> 100%); color: #fff; border-radius: 12px;">
                            <div class="inner">
                                <h3 class="font-weight-bold mb-1"><?= number_format($valor, 0, ',', '.') ?></h3>
                                <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .75rem;"><?= esc($rotulo) ?></p>
                            </div>
                            <div class="icon"><i class="fas <?= esc($icone) ?>" style="opacity: 0.25;"></i></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row mb-4">
                <div class="col-xl-7 mb-3 mb-xl-0">
                    <div class="card inventory-chart-card h-100">
                        <div class="card-header inventory-chart-header inventory-chart-header--categories">
                            <div class="inventory-chart-icon"><i class="fas fa-layer-group"></i></div>
                            <div class="inventory-chart-heading">
                                <h3>Tipos de equipamento por condição</h3>
                                <div>Percentual por condição em cada categoria. Clique em uma condição para filtrar as escolas.</div>
                            </div>
                            <span class="inventory-chart-badge"><?= count($categoriasGrafico) ?> categorias</span>
                        </div>
                        <div class="card-body px-3 px-md-4 pt-3">
                            <?php if (!empty($categoriasGrafico)): ?>
                                <div class="inventory-chart-categories" style="height: <?= (int)$alturaGraficoCategorias ?>px;"><canvas id="graficoCategoriasCondicao" aria-label="Categorias de equipamentos empilhadas por condição" role="img"></canvas></div>
                            <?php else: ?>
                                <div class="text-center text-muted py-5">Sem categorias de equipamentos para comparar.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card inventory-chart-card h-100">
                        <div class="card-header inventory-chart-header inventory-chart-header--schools">
                            <div class="inventory-chart-icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="inventory-chart-heading">
                                <h3>Escolas mais críticas</h3>
                                <div>Percentual em manutenção ou inservível. Clique numa barra para ver a escola.</div>
                            </div>
                            <span class="inventory-chart-badge"><?= $totalEscolasCriticasGrafico ?> prioritárias</span>
                        </div>
                        <div class="card-body px-3 px-md-4 pt-3">
                            <?php if (!empty($escolasGrafico)): ?>
                                <div class="inventory-chart-bars"><canvas id="graficoEscolasCriticas" aria-label="Percentual de equipamentos com problema por escola" role="img"></canvas></div>
                            <?php else: ?>
                                <div class="text-center text-muted py-5"><i class="fas fa-check-circle text-success fa-2x d-block mb-2"></i>Nenhuma escola possui equipamentos em manutenção ou inservíveis.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="filtroGraficoAtivo" class="alert alert-primary py-2 justify-content-between align-items-center" role="status" style="display:none;">
                <span><i class="fas fa-filter mr-2"></i><span id="descricaoFiltroGrafico"></span></span>
                <button id="limparFiltroGrafico" type="button" class="btn btn-sm btn-outline-primary">Limpar filtro</button>
            </div>

            <!-- Tabela e Filtros de Escolas -->
            <div class="card card-outline card-primary shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="inventory-card-heading">
                            <h3 class="card-title font-weight-bold text-dark mb-1">
                                <i class="fas fa-list mr-2 text-primary"></i>Relação de Unidades Escolares
                            </h3>
                            <div class="text-muted small mt-1">Abra uma escola para ver seus equipamentos.</div>
                        </div>

                        <!-- Barra de Busca Instantânea -->
                        <div class="mt-2 mt-md-0" style="min-width: 320px;">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                                </div>
                                <input type="text" id="filtroEscolaInput" class="form-control border-left-0 bg-light"
                                       placeholder="Buscar escola por Nome ou CIE..." autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-light" type="button" id="btnLimparBusca" title="Limpar busca">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0" id="tabelaEscolas">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 100px;" class="text-center">CIE</th>
                                <th>Unidade Escolar</th>
                                <th>Diretoria / URE</th>
                                <th style="width: 160px;" class="text-center">Total Equipamentos</th>
                                <th style="width: 250px;">Distribuição de Status</th>
                                <th style="width: 170px;" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="corpoTabelaEscolas">
                            <?php if (!empty($escolas) && is_array($escolas)): ?>
                                <?php foreach ($escolas as $esc): ?>
                                    <?php
                                        $total = (int)$esc['total_equipamentos'];
                                        $disp  = (int)$esc['total_disponivel'];
                                        $manut = (int)$esc['total_manutencao'];
                                        $ins   = (int)$esc['total_inservivel'];

                                        $pctDisp  = $total > 0 ? round(($disp / $total) * 100) : 0;
                                        $pctManut = $total > 0 ? round(($manut / $total) * 100) : 0;
                                        $pctIns   = $total > 0 ? round(($ins / $total) * 100) : 0;
                                    ?>
                                    <tr class="escola-item"
                                        data-cie="<?= esc($esc['escola_cie']) ?>"
                                        data-nome="<?= esc(mb_strtolower($esc['escola_nome'], 'UTF-8')) ?>"
                                        data-ure="<?= esc(mb_strtolower($esc['ure_diretoria'] ?? '', 'UTF-8')) ?>"
                                        data-status-disponivel="<?= $disp ?>"
                                        data-status-manutencao="<?= $manut ?>"
                                        data-status-inservivel="<?= $ins ?>"
                                        data-status-outros="<?= (int)($esc['total_outros'] ?? 0) ?>"
                                        data-status-sem_status="<?= (int)($esc['total_sem_status'] ?? 0) ?>">
                                        <td class="text-center align-middle font-weight-bold">
                                            <span class="badge badge-secondary px-2 py-1" style="font-size: .85rem; letter-spacing: .5px;">
                                                <?= esc($esc['escola_cie']) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="/escolaequip/escola/<?= urlencode($esc['escola_cie']) ?>" class="font-weight-bold text-dark text-decoration-none d-flex align-items-center link-escola">
                                                <i class="fas fa-graduation-cap text-primary mr-2" style="font-size: 1.1rem;"></i>
                                                <span style="font-size: .95rem;"><?= esc($esc['escola_nome']) ?></span>
                                            </a>
                                        </td>
                                        <td class="align-middle text-muted small">
                                            <i class="fas fa-map-marker-alt text-danger mr-1"></i><?= esc($esc['ure_diretoria'] ?: 'SAO VICENTE') ?>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge badge-primary px-3 py-1 font-weight-bold" style="font-size: .9rem; border-radius: 20px;">
                                                <i class="fas fa-boxes mr-1"></i><?= number_format($total, 0, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <!-- Mini barra de progresso -->
                                            <div class="progress" style="height: 8px; border-radius: 6px; background-color: #e2e8f0;" title="Disp: <?= $disp ?> | Manut: <?= $manut ?> | Inserv: <?= $ins ?>">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $pctDisp ?>%;" title="Disponível: <?= $disp ?> (<?= $pctDisp ?>%)"></div>
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pctManut ?>%;" title="Em Manutenção: <?= $manut ?> (<?= $pctManut ?>%)"></div>
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $pctIns ?>%;" title="Inservível: <?= $ins ?> (<?= $pctIns ?>%)"></div>
                                            </div>
                                            <div class="d-flex justify-content-between text-muted" style="font-size: .72rem; margin-top: 3px;">
                                                <span class="text-success"><i class="fas fa-check-circle mr-1"></i><?= $disp ?></span>
                                                <span class="text-warning"><i class="fas fa-tools mr-1"></i><?= $manut ?></span>
                                                <span class="text-danger"><i class="fas fa-ban mr-1"></i><?= $ins ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="/escolaequip/escola/<?= urlencode($esc['escola_cie']) ?>" class="btn btn-sm btn-info font-weight-bold px-3 shadow-sm" style="border-radius: 20px;">
                                                <i class="fas fa-eye mr-1"></i>Ver Itens
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 text-secondary d-block"></i>
                                        Nenhuma escola encontrada no inventário.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr id="semResultados" style="display: none;">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-search fa-2x mb-2 text-secondary d-block"></i>
                                    Nenhuma escola corresponde à pesquisa digitada.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" id="contadorEscolasVisiveis">
                        Exibindo <strong><?= count($escolas) ?></strong> escolas cadastradas
                    </span>
                    <a href="#filtroEscolaInput" class="small text-primary font-weight-bold" onclick="document.getElementById('filtroEscolaInput').focus();">
                        <i class="fas fa-arrow-up mr-1"></i>Voltar ao topo
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .inventory-chart-card {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 3px 14px rgba(15, 23, 42, .08);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .inventory-chart-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 24px rgba(15, 23, 42, .12);
    }
    .inventory-chart-header {
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 104px;
        padding: 17px 20px;
        border: 0;
        color: #fff;
    }
    .inventory-chart-header--categories { background: linear-gradient(120deg, #2563eb 0%, #4f46e5 55%, #6d28d9 100%); }
    .inventory-chart-header--schools { background: linear-gradient(120deg, #f97316 0%, #ea580c 48%, #be123c 100%); }
    .inventory-chart-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        min-width: 42px;
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 12px;
        background: rgba(255,255,255,.16);
        font-size: 1.05rem;
    }
    .inventory-chart-heading { flex: 1; min-width: 0; }
    .inventory-chart-heading h3 { margin: 0 0 5px; color: #fff; font-size: 1rem; font-weight: 700; }
    .inventory-chart-heading div { color: rgba(255,255,255,.84); font-size: .78rem; line-height: 1.4; }
    .inventory-chart-badge {
        flex-shrink: 0;
        padding: 6px 10px;
        border: 1px solid rgba(255,255,255,.32);
        border-radius: 20px;
        background: rgba(255,255,255,.15);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .inventory-card-heading .card-title { float: none; display: block; }
    .inventory-chart-categories { position: relative; min-height: 340px; }
    .inventory-chart-bars { position: relative; height: 390px; }
    @media (max-width: 767.98px) {
        .inventory-chart-bars { height: 410px; }
        .inventory-chart-header { flex-wrap: wrap; gap: 10px; padding: 15px; }
        .inventory-chart-icon { width: 36px; height: 36px; min-width: 36px; }
        .inventory-chart-badge { margin-left: 46px; }
    }
    .link-escola:hover span {
        color: #0284c7 !important;
        text-decoration: underline;
    }
    .escola-item {
        transition: background-color 0.15s ease;
    }
    .table td, .table th {
        vertical-align: middle;
    }
</style>

<script src="<?= base_url('tema/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let filtroGrafico = null;
    if (typeof Chart !== 'undefined') {
        const chartFont = "'Source Sans Pro', sans-serif";
        const statusDatasets = [
            { key: 'disponivel', label: 'Disponíveis', color: '#10b981' },
            { key: 'manutencao', label: 'Em manutenção', color: '#f59e0b' },
            { key: 'inservivel', label: 'Inservíveis', color: '#ef4444' },
            { key: 'outros', label: 'Outro status', color: '#64748b' },
            { key: 'sem_status', label: 'Sem status definido', color: '#cbd5e1' }
        ];
        const categoriesCanvas = document.getElementById('graficoCategoriasCondicao');
        if (categoriesCanvas) {
            const categories = <?= json_encode(array_map(static function ($category) {
                return [
                    'label' => (string)($category['categoria'] ?? 'Sem categoria'),
                    'total' => (int)($category['total_equipamentos'] ?? 0),
                    'disponivel' => (int)($category['total_disponivel'] ?? 0),
                    'manutencao' => (int)($category['total_manutencao'] ?? 0),
                    'inservivel' => (int)($category['total_inservivel'] ?? 0),
                    'outros' => (int)($category['total_outros'] ?? 0),
                    'sem_status' => (int)($category['total_sem_status'] ?? 0),
                ];
            }, $categoriasGrafico), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
            const chartCategorias = new Chart(categoriesCanvas.getContext('2d'), {
                type: 'horizontalBar',
                data: {
                    labels: categories.map(category => category.label),
                    datasets: statusDatasets.map(status => ({
                        label: status.label,
                        data: categories.map(category => category.total ? category[status.key] / category.total * 100 : 0),
                        backgroundColor: status.color,
                        borderColor: '#ffffff',
                        borderWidth: 1
                    }))
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    animation: { duration: 850, easing: 'easeOutQuart' },
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18, fontFamily: chartFont, fontColor: '#475569', fontSize: 11 } },
                    tooltips: { mode: 'index', intersect: false, backgroundColor: '#0f172a', titleFontFamily: chartFont, bodyFontFamily: chartFont, cornerRadius: 8, xPadding: 12, yPadding: 10, callbacks: { label: function (item) {
                        const category = categories[item.index];
                        const status = statusDatasets[item.datasetIndex];
                        const quantity = category[status.key];
                        const percent = category.total ? Math.round(quantity / category.total * 100) : 0;
                        return ' ' + status.label + ': ' + quantity.toLocaleString('pt-BR') + ' (' + percent + '%)';
                    } } },
                    scales: {
                        xAxes: [{ stacked: true, ticks: { beginAtZero: true, max: 100, callback: value => value + '%', fontColor: '#64748b', fontFamily: chartFont }, gridLines: { color: '#eef2f7', drawBorder: false } }],
                        yAxes: [{ stacked: true, ticks: { fontColor: '#334155', fontFamily: chartFont, fontSize: 11 }, gridLines: { display: false }, barPercentage: 0.68, categoryPercentage: 0.78 }]
                    },
                    onClick: function (event, activeElements) {
                        if (!activeElements.length) return;
                        const status = statusDatasets[activeElements[0]._datasetIndex];
                        definirFiltroGrafico({ tipo: 'status', chave: status.key, descricao: 'Escolas com equipamentos ' + status.label.toLowerCase() });
                    }
                }
            });
        }

        const schoolsCanvas = document.getElementById('graficoEscolasCriticas');
        if (schoolsCanvas) {
            const schools = <?= json_encode(array_map(static function ($school) {
                return [
                    'label' => (string)($school['escola_nome'] ?? 'Escola'),
                    'cie' => (string)($school['escola_cie'] ?? ''),
                    'problemas' => (int)($school['total_com_problema'] ?? 0),
                    'total' => (int)($school['total_equipamentos'] ?? 0),
                    'percentual' => (float)($school['percentual_com_problema'] ?? 0),
                ];
            }, $escolasGrafico), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
            new Chart(schoolsCanvas.getContext('2d'), {
                type: 'horizontalBar',
                data: {
                    labels: schools.map(school => school.label),
                    datasets: [{
                        label: 'Equipamentos com problema',
                        data: schools.map(school => school.percentual),
                        backgroundColor: schools.map(school => school.percentual >= 50 ? '#dc2626' : (school.percentual >= 25 ? '#f59e0b' : '#0ea5e9')),
                        hoverBackgroundColor: schools.map(school => school.percentual >= 50 ? '#b91c1c' : (school.percentual >= 25 ? '#d97706' : '#0284c7')),
                        barThickness: 20,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    legend: { display: false },
                    animation: { duration: 850, easing: 'easeOutQuart' },
                    tooltips: { backgroundColor: '#0f172a', titleFontFamily: chartFont, bodyFontFamily: chartFont, cornerRadius: 8, xPadding: 12, yPadding: 10, callbacks: { label: function (item) {
                        const school = schools[item.index];
                        return ' ' + school.percentual.toLocaleString('pt-BR') + '% — ' + school.problemas.toLocaleString('pt-BR') + ' de ' + school.total.toLocaleString('pt-BR') + ' equipamentos';
                    } } },
                    scales: {
                        xAxes: [{ ticks: { beginAtZero: true, max: 100, callback: value => value + '%', fontColor: '#64748b', fontFamily: chartFont }, gridLines: { color: '#eef2f7', drawBorder: false } }],
                        yAxes: [{ ticks: { fontColor: '#334155', fontFamily: chartFont, fontSize: 11 }, gridLines: { display: false }, barPercentage: 0.68, categoryPercentage: 0.78 }]
                    },
                    onClick: function (event, activeElements) {
                        if (!activeElements.length) return;
                        const school = schools[activeElements[0]._index];
                        definirFiltroGrafico({ tipo: 'escola', cie: school.cie, descricao: 'Escola: ' + school.label });
                    }
                }
            });
        }

        function definirFiltroGrafico(filtro) {
            if (filtroGrafico && filtroGrafico.tipo === filtro.tipo &&
                (filtro.tipo === 'escola' ? filtroGrafico.cie === filtro.cie : filtroGrafico.chave === filtro.chave)) {
                filtroGrafico = null;
            } else {
                filtroGrafico = filtro;
            }
            const aviso = document.getElementById('filtroGraficoAtivo');
            aviso.style.display = filtroGrafico ? 'flex' : 'none';
            document.getElementById('descricaoFiltroGrafico').textContent = filtroGrafico ? filtroGrafico.descricao : '';
            filtrar();
        }
    }

    const inputBusca = document.getElementById('filtroEscolaInput');
    const btnLimpar = document.getElementById('btnLimparBusca');
    const linhas = document.querySelectorAll('.escola-item');
    const msgSemResultados = document.getElementById('semResultados');
    const contador = document.getElementById('contadorEscolasVisiveis');
    const totalInicial = linhas.length;

    function filtrar() {
        const termo = (inputBusca.value || '').toLowerCase().trim();
        let visiveis = 0;

        linhas.forEach(function (linha) {
            const cie = linha.getAttribute('data-cie') || '';
            const nome = linha.getAttribute('data-nome') || '';
            const ure = linha.getAttribute('data-ure') || '';

            const correspondeBusca = termo === '' || cie.includes(termo) || nome.includes(termo) || ure.includes(termo);
            const correspondeGrafico = !filtroGrafico || (filtroGrafico.tipo === 'escola'
                ? cie === filtroGrafico.cie
                : Number(linha.getAttribute('data-status-' + filtroGrafico.chave) || 0) > 0);

            if (correspondeBusca && correspondeGrafico) {
                linha.style.display = '';
                visiveis++;
            } else {
                linha.style.display = 'none';
            }
        });

        if (visiveis === 0) {
            msgSemResultados.style.display = '';
        } else {
            msgSemResultados.style.display = 'none';
        }

        if (contador) {
            if (termo === '' && !filtroGrafico) {
                contador.innerHTML = `Exibindo <strong>${totalInicial}</strong> escolas cadastradas`;
            } else {
                contador.innerHTML = `Filtradas <strong>${visiveis}</strong> de <strong>${totalInicial}</strong> escolas`;
            }
        }
    }

    inputBusca.addEventListener('input', filtrar);
    document.getElementById('limparFiltroGrafico').addEventListener('click', function () {
        filtroGrafico = null;
        document.getElementById('filtroGraficoAtivo').style.display = 'none';
        filtrar();
    });
    btnLimpar.addEventListener('click', function () {
        inputBusca.value = '';
        filtrar();
        inputBusca.focus();
    });
});
</script>
