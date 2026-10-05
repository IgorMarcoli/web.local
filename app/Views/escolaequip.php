<div class="content-wrapper">
    <!-- Cabeçalho -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-school mr-2 text-primary"></i>Inventário por Escola
                    </h1>
                    <p class="text-muted small mb-0">Gestão e acompanhamento de equipamentos alocados nas 76 unidades escolares</p>
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

            <!-- Cards de Indicadores Gerais -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['total_escolas'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Escolas Cadastradas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-school" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['total_equipamentos'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Total de Equipamentos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-laptop" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)($stats['total_disponivel'] ?? 0), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Equipamentos Disponíveis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 12px;">
                        <div class="inner">
                            <h3 class="font-weight-bold mb-1"><?= number_format((int)(($stats['total_manutencao'] ?? 0) + ($stats['total_inservivel'] ?? 0)), 0, ',', '.') ?></h3>
                            <p class="mb-0 text-white-50 font-weight-bold text-uppercase" style="font-size: .8rem;">Manutenção / Inservíveis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools" style="opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                $totalInventario = (int)($stats['total_equipamentos'] ?? 0);
                $disponiveis = (int)($stats['total_disponivel'] ?? 0);
                $manutencao = (int)($stats['total_manutencao'] ?? 0);
                $inserviveis = (int)($stats['total_inservivel'] ?? 0);
                $outros = max(0, $totalInventario - $disponiveis - $manutencao - $inserviveis);
                $escolasGrafico = array_slice($escolas ?? [], 0, 10);
            ?>
            <div class="row mb-4">
                <div class="col-xl-5 mb-3 mb-xl-0">
                    <div class="card shadow-sm h-100" style="border:0;border-radius:14px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h3 class="card-title font-weight-bold text-dark mb-1">Condição do inventário</h3>
                            <div class="text-muted small">Distribuição dos <?= number_format($totalInventario, 0, ',', '.') ?> equipamentos cadastrados</div>
                        </div>
                        <div class="card-body px-4 pt-2">
                            <div class="inventory-chart-doughnut"><canvas id="graficoStatusInventario" aria-label="Distribuição de equipamentos por status" role="img"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="card shadow-sm h-100" style="border:0;border-radius:14px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h3 class="card-title font-weight-bold text-dark mb-1">Escolas com maior inventário</h3>
                            <div class="text-muted small">Comparativo dos 10 maiores acervos por condição dos equipamentos</div>
                        </div>
                        <div class="card-body px-4 pt-2">
                            <?php if (!empty($escolasGrafico)): ?>
                                <div class="inventory-chart-bars"><canvas id="graficoEscolasInventario" aria-label="Equipamentos por status nas escolas com maior inventário" role="img"></canvas></div>
                            <?php else: ?>
                                <div class="text-center text-muted py-5">Sem dados de escolas para exibir.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela e Filtros de Escolas -->
            <div class="card card-outline card-primary shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title font-weight-bold text-dark mb-1">
                                <i class="fas fa-list mr-2 text-primary"></i>Relação de Unidades Escolares
                            </h3>
                            <div class="text-muted small">Clique em uma escola para abrir a ficha completa e todos os equipamentos presentes</div>
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
                                        data-ure="<?= esc(mb_strtolower($esc['ure_diretoria'] ?? '', 'UTF-8')) ?>">
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
    .inventory-chart-doughnut { position: relative; height: 260px; }
    .inventory-chart-bars { position: relative; height: 330px; }
    @media (max-width: 767.98px) {
        .inventory-chart-doughnut { height: 230px; }
        .inventory-chart-bars { height: 360px; }
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
    if (typeof Chart !== 'undefined') {
        const chartFont = "'Source Sans Pro', sans-serif";
        const statusCanvas = document.getElementById('graficoStatusInventario');
        if (statusCanvas) {
            new Chart(statusCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Disponíveis', 'Em manutenção', 'Inservíveis', 'Outros / sem classificação'],
                    datasets: [{
                        data: <?= json_encode([$disponiveis, $manutencao, $inserviveis, $outros]) ?>,
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#94a3b8'],
                        borderColor: '#fff', borderWidth: 3, hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutoutPercentage: 70,
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 18, fontFamily: chartFont } },
                    tooltips: { callbacks: { label: function (item, data) {
                        const values = data.datasets[0].data;
                        const total = values.reduce((sum, value) => sum + Number(value), 0);
                        const value = Number(values[item.index]);
                        const percent = total ? Math.round(value / total * 100) : 0;
                        return ' ' + data.labels[item.index] + ': ' + value.toLocaleString('pt-BR') + ' (' + percent + '%)';
                    } } }
                }
            });
        }

        const schoolsCanvas = document.getElementById('graficoEscolasInventario');
        if (schoolsCanvas) {
            const chartSchools = <?= json_encode(array_map(static function ($school) {
                return [
                    'label' => (string)($school['escola_nome'] ?? 'Escola'),
                    'disponiveis' => (int)($school['total_disponivel'] ?? 0),
                    'manutencao' => (int)($school['total_manutencao'] ?? 0),
                    'inserviveis' => (int)($school['total_inservivel'] ?? 0),
                ];
            }, $escolasGrafico), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
            new Chart(schoolsCanvas.getContext('2d'), {
                type: 'horizontalBar',
                data: {
                    labels: chartSchools.map(school => school.label),
                    datasets: [
                        { label: 'Disponíveis', data: chartSchools.map(school => school.disponiveis), backgroundColor: '#10b981' },
                        { label: 'Em manutenção', data: chartSchools.map(school => school.manutencao), backgroundColor: '#f59e0b' },
                        { label: 'Inservíveis', data: chartSchools.map(school => school.inserviveis), backgroundColor: '#ef4444' }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16, fontFamily: chartFont } },
                    tooltips: { mode: 'index', intersect: false },
                    scales: {
                        xAxes: [{ stacked: true, ticks: { beginAtZero: true, precision: 0 }, gridLines: { color: '#edf2f7' } }],
                        yAxes: [{ stacked: true, gridLines: { display: false }, barPercentage: 0.72, categoryPercentage: 0.78 }]
                    }
                }
            });
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

            if (termo === '' || cie.includes(termo) || nome.includes(termo) || ure.includes(termo)) {
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
            if (termo === '') {
                contador.innerHTML = `Exibindo <strong>${totalInicial}</strong> escolas cadastradas`;
            } else {
                contador.innerHTML = `Filtradas <strong>${visiveis}</strong> de <strong>${totalInicial}</strong> escolas`;
            }
        }
    }

    inputBusca.addEventListener('input', filtrar);
    btnLimpar.addEventListener('click', function () {
        inputBusca.value = '';
        filtrar();
        inputBusca.focus();
    });
});
</script>
