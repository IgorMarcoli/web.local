<style>
    :root {
        --grad-blue-a: #0284c7;
        --grad-blue-b: #0369a1;
        --grad-green-a: #10b981;
        --grad-green-b: #059669;
        --grad-amber-a: #f59e0b;
        --grad-amber-b: #d97706;
        --grad-red-a: #ef4444;
        --grad-red-b: #b91c1c;
    }

    .stat-card {
        border: none;
        border-radius: 14px;
        color: #fff;
        padding: 22px 20px;
        position: relative;
        overflow: hidden;
        min-height: 110px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: block;
        text-decoration: none;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.18);
        color: #fff;
        text-decoration: none;
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.1;
    }
    .stat-card .stat-label {
        font-size: 0.85rem;
        opacity: 0.92;
        margin-top: 2px;
    }
    .stat-card .stat-icon {
        position: absolute;
        right: 16px;
        top: 16px;
        font-size: 2.4rem;
        opacity: 0.25;
    }
    .stat-card .stat-footer {
        font-size: 0.75rem;
        opacity: 0.85;
        margin-top: 10px;
    }
    .grad-blue  { background: linear-gradient(135deg, var(--grad-blue-a), var(--grad-blue-b)); }
    .grad-green { background: linear-gradient(135deg, var(--grad-green-a), var(--grad-green-b)); }
    .grad-amber { background: linear-gradient(135deg, var(--grad-amber-a), var(--grad-amber-b)); }
    .grad-red   { background: linear-gradient(135deg, var(--grad-red-a), var(--grad-red-b)); }

    .card-modern {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .card-modern .card-header {
        border-bottom: none;
        font-weight: 600;
    }
    .card-header-blue  { background: linear-gradient(135deg, var(--grad-blue-a), var(--grad-blue-b)); color: #fff; }
    .card-header-amber { background: linear-gradient(135deg, var(--grad-amber-a), var(--grad-amber-b)); color: #fff; }

    #calendar { width: 100%; }

    .agendamento-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 4px;
        border-bottom: 1px solid #f1f3f5;
    }
    .agendamento-item:last-child { border-bottom: none; }
    .agendamento-nome { font-weight: 600; font-size: 0.9rem; color: #212529; }
    .agendamento-meta { font-size: 0.78rem; color: #868e96; }

    .badge-dash-status {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .badge-dash-concluido    { background: #d1fae5; color: #065f46; }
    .badge-dash-pendente     { background: #fef3c7; color: #92400e; }
    .badge-dash-atendimento  { background: #fee2e2; color: #991b1b; }
    .badge-dash-suspenso     { background: #f1f5f9; color: #475569; }

    .empty-mini {
        text-align: center;
        color: #adb5bd;
        padding: 24px 10px;
        font-size: 0.9rem;
    }

    .visita-row td { vertical-align: middle; }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold">Dashboard SEINTEC / SETEC</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">

            <!-- KPIs -->
            <div class="row">
                <div class="col-lg-3 col-6 mb-3">
                    <a href="/equipamentos" class="stat-card grad-blue">
                        <div class="stat-icon"><i class="fas fa-network-wired"></i></div>
                        <div class="stat-value"><?= $totalEquipamentos ?? 0 ?></div>
                        <div class="stat-label">Equipamentos cadastrados</div>
                        <div class="stat-footer">Ver todos <i class="fas fa-arrow-circle-right ml-1"></i></div>
                    </a>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <div class="stat-card grad-green">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-value"><?= $percentResolvido ?? 0 ?><sup style="font-size: 1rem;">%</sup></div>
                        <div class="stat-label">Chamados resolvidos</div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <div class="stat-card grad-amber">
                        <div class="stat-icon"><i class="fas fa-headset"></i></div>
                        <div class="stat-value"><?= $totalChamados ?? 0 ?></div>
                        <div class="stat-label">Chamados no mês</div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-3">
                    <div class="stat-card grad-red">
                        <div class="stat-icon"><i class="fas fa-route"></i></div>
                        <div class="stat-value"><?= $totalVisitas ?? 0 ?></div>
                        <div class="stat-label">Visitas técnicas realizadas</div>
                    </div>
                </div>
            </div>
            <!-- /.KPIs -->

            <div class="row">
                <!-- Coluna esquerda -->
                <div class="col-lg-5">
                    <div class="card card-modern mb-4">
                        <div class="card-header card-header-blue">
                            <i class="far fa-calendar-alt mr-1"></i> Calendário
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <div class="card card-modern mb-4">
                        <div class="card-header bg-white border-bottom">
                            <i class="fas fa-list-ul mr-1 text-info"></i> Próximos agendamentos
                        </div>
                        <div class="card-body p-2">
                            <?php if (!empty($proximosAgendamentos)) : ?>
                                <?php foreach ($proximosAgendamentos as $ag) :
                                    $stAg = mb_strtolower(trim($ag['status'] ?? ''), 'UTF-8');
                                    $badgeAg = 'badge-dash-suspenso';
                                    $labelAg = ucfirst($stAg ?: '-');
                                    if ($stAg === 'concluido' || $stAg === 'concluído') { $badgeAg = 'badge-dash-concluido'; $labelAg = 'Concluído'; }
                                    elseif ($stAg === 'pendente') { $badgeAg = 'badge-dash-pendente'; $labelAg = 'Pendente'; }
                                    elseif ($stAg === 'em_atendimento') { $badgeAg = 'badge-dash-atendimento'; $labelAg = 'Em atendimento'; }
                                    elseif ($stAg === 'suspenso') { $labelAg = 'Suspenso'; }

                                    $dataAgTxt = $ag['Data'] ?? '-';
                                    try {
                                        if (!empty($ag['Data'])) {
                                            $dataAgTxt = (new DateTime($ag['Data']))->format('d/m');
                                        }
                                    } catch (\Exception $e) {}
                                ?>
                                    <div class="agendamento-item">
                                        <div>
                                            <div class="agendamento-nome"><?= esc($ag['Nomelocal'] ?? '-') ?></div>
                                            <div class="agendamento-meta">
                                                <i class="far fa-calendar-alt mr-1"></i><?= esc($dataAgTxt) ?>
                                                <?php if (!empty($ag['Tipo'])) : ?>
                                                    &middot; <?= esc($ag['Tipo']) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span class="badge-dash-status <?= $badgeAg ?>"><?= esc($labelAg) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="empty-mini">
                                    <i class="fas fa-calendar-check mb-2 d-block" style="font-size: 1.8rem;"></i>
                                    Nenhum agendamento próximo
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- /Coluna esquerda -->

                <!-- Coluna direita -->
                <div class="col-lg-7">
                    <div class="card card-modern mb-4">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-chart-bar mr-1 text-info"></i> Atendimentos por status</span>
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab-telefonicos" data-toggle="tab">Telefônicos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-presenciais" data-toggle="tab">Presenciais</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="chart tab-pane active" id="tab-telefonicos" style="position: relative; height: 280px;">
                                    <?php if (!empty($statusChamados)) : ?>
                                        <canvas id="chart-telefonicos"></canvas>
                                    <?php else : ?>
                                        <div class="empty-mini">Sem dados de chamados telefônicos ainda</div>
                                    <?php endif; ?>
                                </div>
                                <div class="chart tab-pane" id="tab-presenciais" style="position: relative; height: 280px;">
                                    <?php if (!empty($statusChamadosPresenciais)) : ?>
                                        <canvas id="chart-presenciais"></canvas>
                                    <?php else : ?>
                                        <div class="empty-mini">Sem dados de atendimentos presenciais ainda</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-modern">
                        <div class="card-header card-header-amber d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-map-marker-alt mr-1"></i> Visitas técnicas pendentes</span>
                            <span class="badge badge-light text-dark"><?= count($visitasPendentes ?? []) ?></span>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($visitasPendentes)) : ?>
                                <div class="empty-mini py-4">
                                    <i class="fas fa-check-circle mb-2 d-block" style="font-size: 1.8rem; color:#10b981;"></i>
                                    Nenhuma visita pendente
                                </div>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Escola</th>
                                                <th>Endereço</th>
                                                <th width="110" class="text-center">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($visitasPendentes as $e) : ?>
                                                <tr class="visita-row">
                                                    <td class="font-weight-bold text-dark">
                                                        <i class="fas fa-school text-muted mr-1"></i><?= htmlspecialchars($e['Nome']) ?>
                                                    </td>
                                                    <td class="text-muted"><?= htmlspecialchars($e['Endereco']) ?></td>
                                                    <td class="text-center">
                                                        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($e['Endereco']) ?>"
                                                           target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-route"></i> Rota
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- /Coluna direita -->
            </div>

        </div>
    </section>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .fc .fc-toolbar-title { color: #ffffff; }
    .fc-header-toolbar { background-color: #343a40; padding: 10px; border-radius: 8px; }
    .fc .fc-button { background-color: #212529; border: none; }
    .fc .fc-button:hover { background-color: #000; }
    .fc-day-today { background-color: #ffe8cc !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Calendário
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: 480,
        events: 'agenda/json'
    });
    calendar.render();

    // Gráfico - Telefônicos
    <?php if (!empty($statusChamados)) : ?>
    const labelsTel = <?= json_encode(array_column($statusChamados, 'status')) ?>;
    const valoresTel = <?= json_encode(array_column($statusChamados, 'total')) ?>;
    const ctxTel = document.getElementById('chart-telefonicos');
    if (ctxTel) {
        new Chart(ctxTel, {
            type: 'bar',
            data: {
                labels: labelsTel,
                datasets: [{
                    label: 'Chamados',
                    data: valoresTel,
                    backgroundColor: ['#0284c7', '#10b981', '#f59e0b', '#ef4444', '#94a3b8']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }
    <?php endif; ?>

    // Gráfico - Presenciais
    <?php if (!empty($statusChamadosPresenciais)) : ?>
    const labelsPres = <?= json_encode(array_column($statusChamadosPresenciais, 'status')) ?>;
    const valoresPres = <?= json_encode(array_column($statusChamadosPresenciais, 'total')) ?>;
    const ctxPres = document.getElementById('chart-presenciais');
    if (ctxPres) {
        new Chart(ctxPres, {
            type: 'bar',
            data: {
                labels: labelsPres,
                datasets: [{
                    label: 'Atendimentos presenciais',
                    data: valoresPres,
                    backgroundColor: ['#0284c7', '#10b981', '#f59e0b', '#ef4444', '#94a3b8']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }
    <?php endif; ?>
});
</script>