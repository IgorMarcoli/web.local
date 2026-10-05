<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Equipamentos de Escolas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Conexão App</li>
                        <li class="breadcrumb-item">Escolas</li>
                        <li class="breadcrumb-item active">Equipamentos de Escolas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner"><h3><?= esc($stats['total']) ?></h3><p>Total de equipamentos</p></div>
                        <div class="icon"><i class="fas fa-laptop"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner"><h3><?= esc($stats['ativos']) ?></h3><p>Ativos</p></div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner"><h3><?= esc($stats['inserviveis']) ?></h3><p>Inservíveis</p></div>
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner"><h3><?= esc($stats['manutencao']) ?></h3><p>Em manutenção</p></div>
                        <div class="icon"><i class="fas fa-tools"></i></div>
                    </div>
                </div>
            </div>

            <?php
                $chartLabels = ['Ativos', 'Inservíveis', 'Em manutenção'];
                $chartValues = [(int) $stats['ativos'], (int) $stats['inserviveis'], (int) $stats['manutencao']];
                $chartColors = ['#28a745', '#dc3545', '#ffc107'];
                if ($stats['outros'] > 0) {
                    $chartLabels[] = 'Outros status';
                    $chartValues[] = (int) $stats['outros'];
                    $chartColors[] = '#6c757d';
                }
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header"><h3 class="card-title">Distribuição por situação</h3></div>
                        <div class="card-body">
                            <?php if ($stats['total'] > 0): ?>
                                <div style="height: 300px"><canvas id="equipamentosSituacaoChart" role="img" aria-label="Gráfico de equipamentos ativos, inservíveis e em manutenção"></canvas></div>
                            <?php else: ?>
                                <p class="text-muted text-center mb-0">Ainda não há equipamentos cadastrados.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header"><h3 class="card-title">Quantidade por situação</h3></div>
                        <div class="card-body">
                            <?php if ($stats['total'] > 0): ?>
                                <div style="height: 300px"><canvas id="equipamentosQuantidadeChart" role="img" aria-label="Comparação da quantidade de equipamentos por situação"></canvas></div>
                            <?php else: ?>
                                <p class="text-muted text-center mb-0">Os gráficos serão exibidos quando houver equipamentos cadastrados.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5 ml-auto">
                    <label for="pesquisarEquipamento">Pesquisar por escola</label>
                    <input type="text" class="form-control" placeholder="Digite o nome da escola" id="pesquisarEquipamento">
                </div>
            </div>

            <!-- Tabela de Equipamentos -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped" id="equip-table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Código QR</th>
                                        <th>Categoria</th>
                                        <th>Status</th>
                                        <th>Escola de Alocação</th>
                                        <th>Marca e Modelo</th>
                                        <th>Nº de Série</th>
                                        <th>Sala</th>
                                        <th>Lote</th>
                                        <th>Observações</th>
                                        <th>Data de Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items) && is_array($items)): ?>
                                        <?php foreach ($items as $it): ?>
                                            <tr>
                                                <td><?= esc($it['nome']) ?></td>
                                                <td><?= esc($it['codigo_qr']) ?></td>
                                                <td><?= esc($it['categoria']) ?></td>
                                                <td><?= esc($it['status']) ?></td>
                                                <td><?= esc($it['escola_nome']) ?></td>
                                                <td><?= esc($it['marca']) ?> <?= esc($it['modelo']) ?></td>
                                                <td><?= esc($it['numero_serie']) ?></td>
                                                <td><?= esc($it['local']) ?></td>
                                                <td><?= esc($it['lote_id']) ?></td>
                                                <td><?= esc($it['observacao']) ?></td>
                                                <td><?= esc($it['created_at']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="12">Nenhum equipamento encontrado.</td></tr>
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


<script src="<?= base_url('tema/plugins/chart.js/Chart.bundle.min.js') ?>"></script>
<script>
    (function () {
        const labels = <?= json_encode($chartLabels, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const values = <?= json_encode($chartValues, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const colors = <?= json_encode($chartColors, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const total = <?= (int) $stats['total'] ?>;

        if (typeof Chart === 'undefined' || total === 0) return;

        new Chart(document.getElementById('equipamentosSituacaoChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{ data: values, backgroundColor: colors, borderWidth: 1 }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { position: 'bottom' },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            const value = data.datasets[item.datasetIndex].data[item.index];
                            const percent = total ? Math.round((value / total) * 100) : 0;
                            return data.labels[item.index] + ': ' + value + ' (' + percent + '%)';
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('equipamentosQuantidadeChart').getContext('2d'), {
            type: 'horizontalBar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Equipamentos',
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                scales: {
                    xAxes: [{ ticks: { beginAtZero: true, precision: 0 } }],
                    yAxes: [{ gridLines: { display: false } }]
                }
            }
        });
    })();
</script>
<script>
    document.getElementById("pesquisarEquipamento").addEventListener("keyup", function() {
        let filtro = this.value.toLowerCase();
        let linhas = document.querySelectorAll("table tbody tr");

        linhas.forEach(function(linha) {
            let nome = linha.children[4].textContent.toLowerCase();
            linha.style.display = nome.includes(filtro) ? "" : "none";
        });
    });
</script>
