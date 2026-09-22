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

    .visita-compact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-bottom: 1px solid #f1f3f5;
        transition: background-color 0.2s ease, opacity 0.3s ease, max-height 0.3s ease;
    }
    .visita-compact-item:last-child { border-bottom: none; }
    .visita-compact-item:hover { background-color: #f8fafc; }
    .visita-compact-item.saindo {
        opacity: 0;
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        overflow: hidden;
    }
    .visita-compact-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 10px;
        background: #fff7ed;
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
    }
    .visita-compact-info { flex: 1; min-width: 0; }
    .visita-compact-nome {
        font-weight: 600;
        font-size: 0.88rem;
        color: #212529;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .visita-compact-meta {
        font-size: 0.75rem;
        color: #868e96;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .visita-compact-acoes {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }
    .status-select-badge {
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 20px;
        padding: 4px 10px;
        border: 1px solid #ced4da;
        outline: none;
        cursor: pointer;
        max-width: 140px;
    }
    .status-select-badge.status-concluido    { background-color: #d1fae5; color: #065f46; border-color: #10b981; }
    .status-select-badge.status-pendente     { background-color: #fef3c7; color: #92400e; border-color: #f59e0b; }
    .status-select-badge.status-atendimento  { background-color: #fee2e2; color: #991b1b; border-color: #ef4444; }
    .status-select-badge.status-suspenso     { background-color: #f1f5f9; color: #475569; border-color: #94a3b8; }
    .btn-rota-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
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

            <!-- ===== GRÁFICO ATENDIMENTOS POR TÉCNICO ===== -->
            <?php if (!empty($porTecnico)) : ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-modern">
                        <div class="card-header d-flex align-items-center justify-content-between py-3 px-4"
                             style="background: linear-gradient(135deg,#7c3aed 0%,#5b21b6 100%); color:#fff; border-radius: 14px 14px 0 0;">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mr-3 shadow-sm"
                                     style="width:38px;height:38px;min-width:38px;font-size:1.1rem;">
                                    <i class="fas fa-user-cog" style="color:#7c3aed;"></i>
                                </div>
                                <div>
                                    <div class="font-weight-bold" style="font-size:1rem;">Atendimentos por Técnico Field</div>
                                    <small style="opacity:.8;">Produtividade individual da equipe</small>
                                </div>
                            </div>
                            <span class="badge badge-light text-dark px-3 py-1" style="font-size:.8rem;">
                                <i class="fas fa-users mr-1"></i><?= count($porTecnico) ?> técnico<?= count($porTecnico) !== 1 ? 's' : '' ?>
                            </span>
                        </div>

                        <div class="card-body p-4">
                            <div class="row">

                                <!-- Gráfico Barras Horizontal — Todos os períodos -->
                                <div class="col-lg-7 mb-4 mb-lg-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="font-weight-bold text-dark" style="font-size:.9rem;">
                                            <i class="fas fa-chart-bar mr-1 text-purple" style="color:#7c3aed;"></i>
                                            Total geral de agendamentos
                                        </span>
                                    </div>
                                    <div style="position:relative; height:<?= max(160, count($porTecnico) * 44) ?>px;">
                                        <canvas id="chart-por-tecnico"></canvas>
                                    </div>
                                </div>

                                <!-- Donut — Mês atual + Ranking -->
                                <div class="col-lg-5">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="font-weight-bold text-dark" style="font-size:.9rem;">
                                            <i class="fas fa-trophy mr-1" style="color:#f59e0b;"></i>
                                            Ranking —
                                            <?php
                                                $mesesNomes = [1=>'Jan',2=>'Fev',3=>'Mar',4=>'Abr',5=>'Mai',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Set',10=>'Out',11=>'Nov',12=>'Dez'];
                                                echo ($mesesNomes[(int)date('m')] ?? '') . '/' . date('Y');
                                            ?>
                                        </span>
                                    </div>

                                    <?php if (!empty($porTecnicoMes)) : ?>
                                        <!-- Donut do mês -->
                                        <div class="text-center mb-3">
                                            <div style="position:relative; height:170px; max-width:220px; margin:0 auto;">
                                                <canvas id="chart-donut-tecnico"></canvas>
                                            </div>
                                        </div>

                                        <!-- Ranking list -->
                                        <div class="mt-2">
                                            <?php
                                            $totalMes = array_sum(array_column($porTecnicoMes, 'total'));
                                            $medalhas = ['🥇','🥈','🥉'];
                                            foreach ($porTecnicoMes as $i => $tec) :
                                                $pct = $totalMes > 0 ? round(($tec['total'] / $totalMes) * 100) : 0;
                                                $barColors = ['#7c3aed','#0284c7','#10b981','#f59e0b','#ef4444','#94a3b8'];
                                                $cor = $barColors[$i % count($barColors)];
                                                $medalha = $medalhas[$i] ?? '·';
                                            ?>
                                            <div class="mb-2">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span style="font-size:.82rem; font-weight:600; color:#1e1b4b;">
                                                        <?= $medalha ?> <?= esc($tec['tecnico']) ?>
                                                    </span>
                                                    <span class="badge" style="background:<?= $cor ?>22; color:<?= $cor ?>; font-size:.75rem; font-weight:700; padding:2px 8px; border-radius:20px;">
                                                        <?= (int)$tec['total'] ?>
                                                    </span>
                                                </div>
                                                <div class="progress" style="height:6px; border-radius:10px;">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width:<?= $pct ?>%; background:<?= $cor ?>; border-radius:10px;"
                                                         aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="empty-mini">
                                            <i class="fas fa-inbox mb-2 d-block" style="font-size:1.8rem;"></i>
                                            Sem atendimentos neste mês
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div><!-- /.row -->

                            <!-- Tabela resumo compacta -->
                            <hr class="mt-2 mb-3">
                            <div class="row">
                                <?php
                                $totalGeral = array_sum(array_column($porTecnico, 'total'));
                                $barColorsAll = ['#7c3aed','#0284c7','#10b981','#f59e0b','#ef4444','#94a3b8'];
                                foreach ($porTecnico as $idx => $tec) :
                                    $pctGeral = $totalGeral > 0 ? round(($tec['total'] / $totalGeral) * 100) : 0;
                                    $cor2 = $barColorsAll[$idx % count($barColorsAll)];
                                    $iniciais = mb_strtoupper(mb_substr($tec['tecnico'], 0, 2), 'UTF-8');
                                ?>
                                <div class="col-6 col-md-4 col-lg-3 mb-3">
                                    <div class="d-flex align-items-center p-2 rounded" style="background:#f8fafc; border:1px solid #e9ecef;">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 font-weight-bold text-white"
                                             style="width:34px;height:34px;min-width:34px;background:<?= $cor2 ?>;font-size:.78rem;">
                                            <?= $iniciais ?>
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <div style="font-size:.78rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                <?= esc($tec['tecnico']) ?>
                                            </div>
                                            <div style="font-size:.72rem;color:#64748b;">
                                                <?= (int)$tec['total'] ?> total · <?= (int)($tec['concluidos'] ?? 0) ?> <span style="color:#10b981;">✓</span>
                                            </div>
                                        </div>
                                        <div style="font-size:.85rem;font-weight:700;color:<?= $cor2 ?>; margin-left:4px;">
                                            <?= $pctGeral ?>%
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- ===== /GRÁFICO ATENDIMENTOS POR TÉCNICO ===== -->
            <?php endif; ?>

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
                            <span class="badge badge-light text-dark" id="contador-visitas-pendentes">
                                <?= count($visitasPendentes ?? []) ?>
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div id="lista-visitas-pendentes">
                                <?php if (empty($visitasPendentes)) : ?>
                                    <div class="empty-mini py-4" id="empty-visitas-pendentes">
                                        <i class="fas fa-check-circle mb-2 d-block" style="font-size: 1.8rem; color:#10b981;"></i>
                                        Nenhuma visita pendente
                                    </div>
                                <?php else : ?>
                                    <?php foreach ($visitasPendentes as $v) :
                                        // NOTA: ajuste 'VisitaId' abaixo se a PK real da tabela visitas tiver outro nome
                                        $visitaId = $v['VisitaId'] ?? $v['id'] ?? 0;
                                        $stVisita = mb_strtolower(trim($v['Status'] ?? 'Pendente'), 'UTF-8');
                                        $badgeVisita = 'status-pendente';
                                        if ($stVisita === 'concluido' || $stVisita === 'concluída' || $stVisita === 'concluida') { $badgeVisita = 'status-concluido'; }
                                        elseif ($stVisita === 'em_atendimento') { $badgeVisita = 'status-atendimento'; }
                                        elseif ($stVisita === 'suspenso' || $stVisita === 'suspensa') { $badgeVisita = 'status-suspenso'; }

                                        $dataVisitaTxt = '';
                                        if (!empty($v['Data'])) {
                                            try { $dataVisitaTxt = (new DateTime($v['Data']))->format('d/m'); }
                                            catch (\Exception $e) { $dataVisitaTxt = $v['Data']; }
                                        }
                                    ?>
                                        <div class="visita-compact-item" data-visita-id="<?= (int)$visitaId ?>">
                                            <div class="visita-compact-icon">
                                                <i class="fas fa-school"></i>
                                            </div>
                                            <div class="visita-compact-info">
                                                <div class="visita-compact-nome" title="<?= htmlspecialchars($v['nome'] ?? '-') ?>">
                                                    <?= htmlspecialchars($v['nome'] ?? '-') ?>
                                                </div>
                                                <div class="visita-compact-meta" title="<?= htmlspecialchars($v['escola_endereco'] ?? '') ?>">
                                                    <i class="fas fa-map-marker-alt mr-1"></i><?= htmlspecialchars($v['escola_endereco'] ?? '-') ?>
                                                    <?php if ($dataVisitaTxt) : ?>
                                                        &middot; <i class="far fa-calendar-alt mr-1"></i><?= htmlspecialchars($dataVisitaTxt) ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="visita-compact-acoes">
                                                <!-- NOTA: confirme os valores exatos de Status usados na tabela visitas -->
                                                <select class="status-select-badge <?= $badgeVisita ?>"
                                                        onchange="alterarStatusVisita(this, <?= (int)$visitaId ?>)">
                                                    <option value="Pendente" <?= $stVisita === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                                    <option value="Concluida" <?= ($stVisita === 'concluido' || $stVisita === 'concluída' || $stVisita === 'concluida') ? 'selected' : '' ?>>Concluída</option>
                                                    <option value="Em_atendimento" <?= $stVisita === 'em_atendimento' ? 'selected' : '' ?>>Em atendimento</option>
                                                    <option value="Suspensa" <?= ($stVisita === 'suspenso' || $stVisita === 'suspensa') ? 'selected' : '' ?>>Suspensa</option>
                                                </select>
                                                <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($v['escola_endereco'] ?? '') ?>"
                                                   target="_blank" class="btn btn-outline-primary btn-sm btn-rota-icon" title="Ver rota">
                                                    <i class="fas fa-route"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
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
    // ===== GRÁFICO POR TÉCNICO — Barra Horizontal =====
    <?php if (!empty($porTecnico)) : ?>
    (function() {
        const labelsTec  = <?= json_encode(array_column($porTecnico, 'tecnico')) ?>;
        const totalTec   = <?= json_encode(array_map('intval', array_column($porTecnico, 'total'))) ?>;
        const concTec    = <?= json_encode(array_map('intval', array_column($porTecnico, 'concluidos'))) ?>;
        const allColors  = ['#7c3aed','#0284c7','#10b981','#f59e0b','#ef4444','#94a3b8'];
        const bgColors   = labelsTec.map((_, i) => allColors[i % allColors.length]);
        const bgColorsC  = labelsTec.map((_, i) => allColors[i % allColors.length] + '88');

        const ctxTec = document.getElementById('chart-por-tecnico');
        if (ctxTec) {
            new Chart(ctxTec, {
                type: 'bar',
                data: {
                    labels: labelsTec,
                    datasets: [
                        {
                            label: 'Total',
                            data: totalTec,
                            backgroundColor: bgColors,
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Concluídos',
                            data: concTec,
                            backgroundColor: bgColorsC,
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: { boxWidth: 12, font: { size: 11 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    return ' ' + ctx.dataset.label + ': ' + ctx.raw + ' atendimento' + (ctx.raw !== 1 ? 's' : '');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { precision: 0, font: { size: 11 } },
                            grid: { color: '#f1f5f9' }
                        },
                        y: {
                            ticks: { font: { size: 11, weight: '600' } },
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    })();
    <?php endif; ?>

    // ===== DONUT TÉCNICO — Mês atual =====
    <?php if (!empty($porTecnicoMes)) : ?>
    (function() {
        const labelsDonut  = <?= json_encode(array_column($porTecnicoMes, 'tecnico')) ?>;
        const valoresDonut = <?= json_encode(array_map('intval', array_column($porTecnicoMes, 'total'))) ?>;
        const donutColors  = ['#7c3aed','#0284c7','#10b981','#f59e0b','#ef4444','#94a3b8'];

        const ctxDonut = document.getElementById('chart-donut-tecnico');
        if (ctxDonut) {
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: labelsDonut,
                    datasets: [{
                        data: valoresDonut,
                        backgroundColor: donutColors.slice(0, labelsDonut.length),
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? Math.round((ctx.raw / total) * 100) : 0;
                                    return ' ' + ctx.label + ': ' + ctx.raw + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }
    })();
    <?php endif; ?>

}); // fim DOMContentLoaded

function alterarStatusVisita(selectElem, visitaId) {
    const novoStatus = selectElem.value;
    const stLower = novoStatus.toLowerCase();

    selectElem.classList.remove('status-concluido', 'status-pendente', 'status-atendimento', 'status-suspenso');
    if (stLower === 'concluida' || stLower === 'concluído' || stLower === 'concluido') {
        selectElem.classList.add('status-concluido');
    } else if (stLower === 'em_atendimento') {
        selectElem.classList.add('status-atendimento');
    } else if (stLower === 'suspensa' || stLower === 'suspenso') {
        selectElem.classList.add('status-suspenso');
    } else {
        selectElem.classList.add('status-pendente');
    }

    fetch('/dashboard/alterarStatusVisita', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'VisitaId=' + visitaId + '&status=' + encodeURIComponent(novoStatus)
    })
    .then(function (response) { return response.text(); })
    .then(function () {
        // A partir do momento em que deixa de ser "pendente", some da lista deste card
        if (stLower !== 'pendente') {
            const item = selectElem.closest('.visita-compact-item');
            if (item) {
                item.classList.add('saindo');
                setTimeout(function () {
                    item.remove();
                    atualizarContadorVisitas();
                }, 320);
            }
        }
    })
    .catch(function (err) { console.error('Erro ao atualizar status da visita:', err); });
}

function atualizarContadorVisitas() {
    const lista = document.getElementById('lista-visitas-pendentes');
    const restantes = lista.querySelectorAll('.visita-compact-item').length;
    const contador = document.getElementById('contador-visitas-pendentes');
    if (contador) contador.textContent = restantes;

    if (restantes === 0 && !document.getElementById('empty-visitas-pendentes')) {
        lista.innerHTML = '<div class="empty-mini py-4" id="empty-visitas-pendentes">' +
            '<i class="fas fa-check-circle mb-2 d-block" style="font-size: 1.8rem; color:#10b981;"></i>' +
            'Nenhuma visita pendente</div>';
    }
    
}
</script>