<?php
$statusOptions = ['Aberto', 'Em atendimento', 'Aguardando', 'Resolvido', 'Fechado'];
$statusClass = ['Aberto' => 'open', 'Em atendimento' => 'working', 'Aguardando' => 'waiting', 'Resolvido' => 'resolved', 'Fechado' => 'closed'];
$prioridadeClass = ['Baixa' => 'low', 'Normal' => 'normal', 'Alta' => 'high', 'Crítica' => 'critical'];
?>
<style>
    .tickets-page { --ink:#172033; --muted:#718096; --line:#e8edf4; --blue:#3559e0; color:var(--ink); }
    .tickets-page .content-header { padding:24px 0 18px; }
    .tickets-hero { position:relative; overflow:hidden; border:0; border-radius:18px; padding:26px 30px; color:#fff; background:linear-gradient(115deg,#172554 0%,#263f9e 58%,#4269ed 100%); box-shadow:0 14px 34px rgba(35,58,133,.17); }
    .tickets-hero:after { content:""; position:absolute; width:250px; height:250px; right:7%; top:-150px; border:1px solid rgba(255,255,255,.13); border-radius:50%; box-shadow:0 0 0 28px rgba(255,255,255,.035),0 0 0 58px rgba(255,255,255,.025); }
    .tickets-kicker { color:#c7d5ff; font-size:.72rem; font-weight:700; letter-spacing:.13em; text-transform:uppercase; }
    .tickets-hero h1 { margin:6px 0 5px; font-size:1.75rem; font-weight:700; }
    .tickets-hero p { margin:0; color:#dbe5ff; }
    .tickets-hero .btn { position:relative; z-index:1; border:0; border-radius:10px; padding:11px 17px; color:#233b91; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,.12); }
    .ticket-stat { height:100%; border:1px solid var(--line); border-radius:15px; background:#fff; box-shadow:0 5px 18px rgba(29,45,75,.035); }
    .ticket-stat .card-body { display:flex; align-items:center; padding:17px 19px; }
    .ticket-stat-icon { display:grid; place-items:center; width:44px; height:44px; margin-right:13px; border-radius:13px; font-size:1rem; }
    .ticket-stat-label { color:var(--muted); font-size:.78rem; font-weight:600; }
    .ticket-stat-value { margin-top:1px; font-size:1.55rem; font-weight:750; line-height:1.1; }
    .ticket-stat.total .ticket-stat-icon { color:#3559e0; background:#edf1ff; }
    .ticket-stat.open .ticket-stat-icon { color:#147d91; background:#e8f8fb; }
    .ticket-stat.late .ticket-stat-icon { color:#c53d52; background:#fff0f1; }
    .ticket-toolbar { margin:4px 0 15px; padding:13px; border:1px solid var(--line); border-radius:14px; background:#fff; }
    .ticket-search { position:relative; flex:1; min-width:220px; }
    .ticket-search i { position:absolute; top:12px; left:13px; color:#9aa6b8; }
    .ticket-search input { height:40px; padding-left:37px; border:1px solid #e4e9f1; border-radius:9px; }
    .ticket-toolbar select,.ticket-toolbar .btn { height:40px; border-radius:9px; }
    .ticket-list-head { display:flex; align-items:center; justify-content:space-between; margin:23px 2px 11px; }
    .ticket-list-head h2 { margin:0; font-size:1.05rem; font-weight:700; }
    .ticket-list-head span { color:var(--muted); font-size:.84rem; }
    .ticket-card { position:relative; margin-bottom:11px; overflow:hidden; border:1px solid var(--line); border-radius:14px; background:#fff; box-shadow:0 4px 15px rgba(29,45,75,.035); transition:transform .16s ease,box-shadow .16s ease; }
    .ticket-card:hover { transform:translateY(-1px); box-shadow:0 10px 25px rgba(29,45,75,.08); }
    .ticket-card:before { position:absolute; inset:0 auto 0 0; width:4px; background:#93a1b5; content:""; }
    .ticket-card.is-late:before { background:#e04f61; }
    .ticket-card .card-body { display:grid; grid-template-columns:minmax(0,1fr) auto; gap:18px; align-items:center; padding:18px 20px 18px 23px; }
    .ticket-number { color:#536176; font-size:.76rem; font-weight:700; letter-spacing:.04em; }
    .ticket-school { margin:3px 0 6px; font-size:1.03rem; font-weight:700; }
    .ticket-description { max-width:780px; margin:0; color:#566276; font-size:.9rem; line-height:1.5; white-space:pre-line; }
    .ticket-meta { display:flex; flex-wrap:wrap; gap:8px 15px; margin-top:11px; color:#7b8798; font-size:.78rem; }
    .ticket-meta i { width:14px; color:#9aa6b8; text-align:center; }
    .ticket-side { min-width:175px; text-align:right; }
    .ticket-badges { display:flex; justify-content:flex-end; flex-wrap:wrap; gap:6px; margin-bottom:12px; }
    .ticket-pill { display:inline-flex; align-items:center; min-height:25px; padding:4px 9px; border-radius:20px; font-size:.72rem; font-weight:700; white-space:nowrap; }
    .ticket-pill.status-open { color:#3157c8; background:#edf2ff; }
    .ticket-pill.status-working { color:#087b90; background:#e6f7fa; }
    .ticket-pill.status-waiting { color:#a1630b; background:#fff5df; }
    .ticket-pill.status-resolved { color:#147c54; background:#e7f7ef; }
    .ticket-pill.status-closed { color:#647084; background:#eef1f5; }
    .ticket-pill.priority-low { color:#647084; background:#f0f3f6; }
    .ticket-pill.priority-normal { color:#43556e; background:#edf1f7; }
    .ticket-pill.priority-high { color:#b56b06; background:#fff3db; }
    .ticket-pill.priority-critical { color:#c3374b; background:#ffeaed; }
    .ticket-due { margin-bottom:10px; color:#7b8798; font-size:.78rem; }
    .ticket-due.late { color:#c3374b; font-weight:700; }
    .ticket-open-btn { border:1px solid #dce4f2; border-radius:8px; color:#3559e0; font-size:.82rem; font-weight:700; }
    .ticket-open-btn:hover { color:#fff; border-color:#3559e0; background:#3559e0; }
    .ticket-empty { padding:58px 20px; border:1px dashed #d9e0eb; border-radius:15px; background:#fff; text-align:center; }
    .ticket-empty-icon { display:grid; place-items:center; width:56px; height:56px; margin:0 auto 13px; border-radius:17px; color:#6379d8; background:#edf1ff; font-size:1.3rem; }
    .ticket-modal .modal-content { overflow:hidden; border:0; border-radius:16px; box-shadow:0 22px 65px rgba(16,27,55,.22); }
    .ticket-modal .modal-header { padding:20px 24px; color:#fff; border:0; background:linear-gradient(115deg,#1d2c58,#3f5ed0); }
    .ticket-modal .modal-header .close { color:#fff; opacity:.8; text-shadow:none; }
    .ticket-modal .modal-body { padding:22px 24px; }
    .ticket-modal .form-control { min-height:40px; border-color:#dfe5ee; border-radius:8px; }
    .ticket-modal textarea.form-control { min-height:80px; }
    .ticket-modal label { color:#43516a; font-size:.82rem; font-weight:700; }
    .ticket-history { max-height:210px; overflow:auto; padding-left:0; list-style:none; }
    .ticket-history li { position:relative; margin:0 0 12px 7px; padding:0 0 0 17px; border-left:1px solid #dce4f2; }
    .ticket-history li:before { position:absolute; top:4px; left:-4px; width:7px; height:7px; border-radius:50%; background:#5270df; content:""; }
    .ticket-history-meta { color:#8490a2; font-size:.74rem; }
    @media(max-width:767.98px) { .tickets-hero { padding:21px; } .tickets-hero .btn { margin-top:17px; } .ticket-card .card-body { grid-template-columns:1fr; gap:12px; } .ticket-side { display:flex; min-width:0; align-items:center; justify-content:space-between; text-align:left; } .ticket-badges { justify-content:flex-start; margin:0; } .ticket-due { margin:0 10px 0 auto; } }
</style>
<div class="content-wrapper tickets-page">
    <section class="content-header"><div class="container-fluid"><div class="tickets-hero d-md-flex align-items-center justify-content-between"><div><div class="tickets-kicker">SEINTEC · SETEC</div><h1>Central de chamados</h1><p>Acompanhe solicitações, responsáveis e prazos em um só lugar.</p></div><button class="btn btn-light" data-toggle="modal" data-target="#novoChamado"><i class="fas fa-plus mr-2"></i>Abrir chamado</button></div></div></section>
    <section class="content"><div class="container-fluid pb-4">
        <?php if (!empty($feedback)) : ?>
            <div class="alert alert-<?= esc($feedback['tipo'] ?? 'info', 'attr') ?> alert-dismissible fade show" role="alert"><i class="fas fa-<?= ($feedback['tipo'] ?? '') === 'success' ? 'check-circle' : 'info-circle' ?> mr-2"></i><?= esc($feedback['texto'] ?? '') ?><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">&times;</span></button></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4 mb-2"><div class="ticket-stat total"><div class="card-body"><div class="ticket-stat-icon"><i class="fas fa-layer-group"></i></div><div><div class="ticket-stat-label">Chamados encontrados</div><div class="ticket-stat-value"><?= count($chamados) ?></div></div></div></div></div>
            <div class="col-md-4 mb-2"><div class="ticket-stat open"><div class="card-body"><div class="ticket-stat-icon"><i class="fas fa-inbox"></i></div><div><div class="ticket-stat-label">Em andamento</div><div class="ticket-stat-value"><?= (int) $abertos ?></div></div></div></div></div>
            <div class="col-md-4 mb-2"><div class="ticket-stat late"><div class="card-body"><div class="ticket-stat-icon"><i class="far fa-clock"></i></div><div><div class="ticket-stat-label">Prazo vencido</div><div class="ticket-stat-value"><?= (int) $atrasados ?></div></div></div></div></div>
        </div>

        <form class="ticket-toolbar d-flex flex-wrap align-items-center" method="get">
            <div class="ticket-search mr-md-2 mb-2 mb-md-0"><i class="fas fa-search"></i><input class="form-control" type="search" name="busca" value="<?= esc($busca) ?>" placeholder="Buscar número, escola, solicitante ou categoria"></div>
            <select class="form-control mr-md-2 mb-2 mb-md-0" name="status" aria-label="Filtrar por status"><option value="">Todos os status</option><?php foreach ($statusOptions as $s) : ?><option value="<?= esc($s, 'attr') ?>" <?= $statusFiltro === $s ? 'selected' : '' ?>><?= esc($s) ?></option><?php endforeach; ?></select>
            <button class="btn btn-primary mr-2 mb-2 mb-md-0" type="submit"><i class="fas fa-filter mr-1"></i>Filtrar</button>
            <?php if ($busca !== '' || $statusFiltro !== '') : ?><a class="btn btn-light mb-2 mb-md-0" href="/chamados">Limpar</a><?php endif; ?>
        </form>

        <div class="ticket-list-head"><h2>Solicitações</h2><span><?= count($chamados) ?> registro(s)</span></div>
        <?php if (empty($chamados)) : ?>
            <div class="ticket-empty"><div class="ticket-empty-icon"><i class="fas fa-inbox"></i></div><h5 class="font-weight-bold">Nenhum chamado por aqui</h5><p class="text-muted mb-3"><?= $busca !== '' || $statusFiltro !== '' ? 'Tente mudar os filtros para encontrar o que procura.' : 'Registre a primeira solicitação para começar o acompanhamento.' ?></p><?php if ($busca === '' && $statusFiltro === '') : ?><button class="btn btn-primary" data-toggle="modal" data-target="#novoChamado"><i class="fas fa-plus mr-1"></i>Abrir chamado</button><?php endif; ?></div>
        <?php else : ?>
            <?php foreach ($chamados as $c) :
                $id = (int) $c['id'];
                $encerrado = in_array($c['status'], ['Resolvido', 'Fechado'], true);
                $atrasado = !empty($c['prazo']) && $c['prazo'] < date('Y-m-d') && !$encerrado;
                $hist = array_values(array_filter($historicos, static fn ($h) => (int) $h['chamado_id'] === $id));
                $created = !empty($c['created_at']) ? date('d/m/Y · H:i', strtotime($c['created_at'])) : '';
            ?>
                <article class="ticket-card <?= $atrasado ? 'is-late' : '' ?>">
                    <div class="card-body">
                        <div>
                            <div class="ticket-number"><?= esc($c['numero']) ?><?php if ($created !== '') : ?> <span class="text-muted font-weight-normal">· <?= esc($created) ?></span><?php endif; ?></div>
                            <h3 class="ticket-school"><?= esc($c['escola']) ?></h3>
                            <p class="ticket-description"><?= esc($c['descricao']) ?></p>
                            <div class="ticket-meta"><span><i class="fas fa-tag"></i><?= esc($c['categoria']) ?></span><span><i class="fas fa-user"></i><?= esc($c['solicitante']) ?></span><span><i class="fas fa-user-cog"></i><?= esc($c['responsavel'] ?: 'Não atribuído') ?></span></div>
                        </div>
                        <div class="ticket-side">
                            <div class="ticket-badges"><span class="ticket-pill status-<?= esc($statusClass[$c['status']] ?? 'closed', 'attr') ?>"><?= esc($c['status']) ?></span><span class="ticket-pill priority-<?= esc($prioridadeClass[$c['prioridade']] ?? 'normal', 'attr') ?>"><?= esc($c['prioridade']) ?></span></div>
                            <div class="ticket-due <?= $atrasado ? 'late' : '' ?>"><?php if (!empty($c['prazo'])) : ?><i class="far fa-calendar-alt mr-1"></i><?= esc(date('d/m/Y', strtotime($c['prazo']))) ?><?= $atrasado ? ' · vencido' : '' ?><?php else : ?>Sem prazo definido<?php endif; ?></div>
                            <button type="button" class="btn btn-sm ticket-open-btn" data-toggle="modal" data-target="#editar<?= $id ?>"><i class="fas fa-external-link-alt mr-1"></i>Acompanhar</button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div></section>
</div>

<?php foreach ($chamados as $c) : $id = (int) $c['id']; $hist = array_values(array_filter($historicos, static fn ($h) => (int) $h['chamado_id'] === $id)); ?>
<div class="modal fade ticket-modal" id="editar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="tituloChamado<?= $id ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document"><div class="modal-content">
        <form method="post" action="/chamados/atualizar"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $id ?>">
            <div class="modal-header"><div><div class="tickets-kicker">ACOMPANHAMENTO</div><h5 class="modal-title" id="tituloChamado<?= $id ?>"><?= esc($c['numero']) ?> <span class="mx-1">·</span> <?= esc($c['escola']) ?></h5></div><button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button></div>
            <div class="modal-body">
                <div class="p-3 mb-4 rounded" style="background:#f5f7fb;color:#536176;white-space:pre-line"><?= esc($c['descricao']) ?></div>
                <div class="row">
                    <div class="form-group col-md-4"><label for="status<?= $id ?>">Status</label><select id="status<?= $id ?>" class="form-control" name="status" required><?php foreach ($statusOptions as $s) : ?><option value="<?= esc($s, 'attr') ?>" <?= $c['status'] === $s ? 'selected' : '' ?>><?= esc($s) ?></option><?php endforeach; ?></select></div>
                    <div class="form-group col-md-4"><label for="responsavel<?= $id ?>">Responsável</label><input id="responsavel<?= $id ?>" class="form-control" name="responsavel" maxlength="160" value="<?= esc($c['responsavel'] ?? '') ?>" placeholder="Atribuir à equipe"></div>
                    <div class="form-group col-md-4"><label for="prazo<?= $id ?>">Prazo</label><input id="prazo<?= $id ?>" type="date" class="form-control" name="prazo" value="<?= esc($c['prazo'] ?? '') ?>"></div>
                </div>
                <div class="form-group"><label for="solucao<?= $id ?>">Solução ou resultado</label><textarea id="solucao<?= $id ?>" class="form-control" name="solucao" rows="3" placeholder="Descreva a solução ao concluir o atendimento"><?= esc($c['solucao'] ?? '') ?></textarea><small class="form-text text-muted">Obrigatória para marcar como resolvido ou fechado.</small></div>
                <div class="form-group"><label for="comentario<?= $id ?>">Adicionar comentário</label><textarea id="comentario<?= $id ?>" class="form-control" name="comentario" rows="2" placeholder="Registre uma atualização para o histórico"></textarea></div>
                <div class="d-flex justify-content-between align-items-center mb-2"><strong>Histórico</strong><span class="text-muted small"><?= count($hist) ?> atualização(ões)</span></div>
                <?php if ($hist) : ?><ul class="ticket-history"><?php foreach (array_reverse($hist) as $h) : ?><li><div class="ticket-history-meta"><?= esc(date('d/m/Y H:i', strtotime($h['created_at']))) ?> · <?= esc($h['autor']) ?> · <?= esc($h['tipo']) ?></div><div><?= nl2br(esc($h['detalhe'])) ?></div></li><?php endforeach; ?></ul><?php else : ?><p class="text-muted small mb-0">Ainda não há atualizações registradas.</p><?php endif; ?>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Salvar atualização</button></div>
        </form>
    </div></div>
</div>
<?php endforeach; ?>

<div class="modal fade ticket-modal" id="novoChamado" tabindex="-1" role="dialog" aria-labelledby="tituloNovoChamado" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document"><div class="modal-content">
        <form method="post" action="/chamados/criar"><?= csrf_field() ?>
            <div class="modal-header"><div><div class="tickets-kicker">NOVA SOLICITAÇÃO</div><h5 class="modal-title" id="tituloNovoChamado">Abrir chamado</h5></div><button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button></div>
            <div class="modal-body"><div class="row">
                <div class="form-group col-md-6"><label for="novaEscola">Escola ou unidade <span class="text-danger">*</span></label><input id="novaEscola" class="form-control" name="escola" required maxlength="180" placeholder="Nome da unidade"></div>
                <div class="form-group col-md-6"><label for="novoSolicitante">Solicitante <span class="text-danger">*</span></label><input id="novoSolicitante" class="form-control" name="solicitante" required maxlength="160" placeholder="Quem reportou o problema"></div>
                <div class="form-group col-md-6"><label for="novoContato">Contato</label><input id="novoContato" class="form-control" name="contato" maxlength="160" placeholder="Telefone ou e-mail"></div>
                <div class="form-group col-md-3"><label for="novaCategoria">Categoria</label><select id="novaCategoria" class="form-control" name="categoria"><?php foreach (['Internet / rede', 'Computador', 'Impressora', 'Sistema / acesso', 'Equipamento', 'Outro'] as $s) : ?><option><?= esc($s) ?></option><?php endforeach; ?></select></div>
                <div class="form-group col-md-3"><label for="novaPrioridade">Prioridade</label><select id="novaPrioridade" class="form-control" name="prioridade"><option>Normal</option><option>Baixa</option><option>Alta</option><option>Crítica</option></select></div>
                <div class="form-group col-md-6"><label for="novoResponsavel">Responsável inicial</label><input id="novoResponsavel" class="form-control" name="responsavel" maxlength="160" placeholder="Opcional"></div>
                <div class="form-group col-md-6"><label for="novoPrazo">Prazo desejado</label><input id="novoPrazo" class="form-control" type="date" name="prazo"></div>
                <div class="form-group col-12"><label for="novaDescricao">Descrição do problema <span class="text-danger">*</span></label><textarea id="novaDescricao" class="form-control" name="descricao" rows="4" required placeholder="Explique o problema e o impacto para a unidade"></textarea></div>
            </div><small class="text-muted">Os campos com <span class="text-danger">*</span> são obrigatórios.</small></div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button><button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"></i>Registrar chamado</button></div>
        </form>
    </div></div>
</div>
<?php if (!empty($abrirChamado)) : ?><script>document.addEventListener('DOMContentLoaded', function () { $('#editar<?= (int) $abrirChamado ?>').modal('show'); });</script><?php endif; ?>
