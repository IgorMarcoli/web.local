<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <?php $usuarioSetor = strtoupper(trim(session()->get('usuario_setor') ?? '')); ?>
                    <h1 class="font-weight-bold text-dark">
                        <i class="fas fa-desktop text-primary mr-2"></i>Bem-vindo ao <?= $usuarioSetor ? esc($usuarioSetor) : 'SEINTEC / SETEC' ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/setec">Início</a></li>
                        <li class="breadcrumb-item active"><?= $usuarioSetor ?: 'SETEC' ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <?php if (session()->getFlashdata('alert') === 'successDevolucao' || (isset($_GET['alert']) && $_GET['alert'] === 'successDevolucao')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0" role="alert" style="border-radius: 10px;">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>Devolução registrada com sucesso!</strong> Os equipamentos foram conferidos e a mochila foi liberada no sistema.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (!empty($emprestimosAbertos)): ?>
                <!-- Banner de Alerta de Mochilas em Aberto -->
                <div class="alert shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 6px solid #f59e0b !important; border-radius: 12px;">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex align-items-center my-1">
                            <div class="rounded-circle bg-warning text-dark p-2 mr-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; min-width: 48px; font-size: 1.4rem;">
                                <i class="fas fa-exclamation-triangle text-dark"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-0">
                                    Atenção: <?= count($emprestimosAbertos) ?> mochila(s) com empréstimo em aberto!
                                </h5>
                                <span class="text-muted" style="font-size: 0.92rem;">
                                    Lembre-se: os equipamentos <strong>devem ser rigorosamente conferidos no momento da devolução</strong> para ver se está tudo certo e voltou do jeito que saiu.
                                </span>
                            </div>
                        </div>
                        <div class="my-1 d-flex flex-wrap align-items-center">
                            <button type="button" class="btn btn-warning shadow-sm font-weight-bold mr-2 my-1" data-toggle="modal" data-target="#modal-aviso-emprestimos-abertos">
                                <i class="fas fa-clipboard-check mr-1"></i> Verificar Devoluções
                            </button>
                            <a href="/emprestimos" class="btn btn-outline-dark shadow-sm my-1">
                                <i class="fas fa-list mr-1"></i> Controle de Empréstimos
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card shadow-sm border-0" style="border-radius: 12px;">
                        <div class="card-header bg-white border-bottom-0 pt-3">
                            <h3 class="card-title font-weight-bold text-dark">
                                <i class="fas fa-th-large text-info mr-2"></i>Painel Rápido de Acesso
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                Selecione uma das opções abaixo ou utilize o menu lateral para gerenciar as rotinas do setor:
                            </p>
                            <div class="row">
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <a href="/emprestimos" class="card text-decoration-none border shadow-sm h-100 p-3 hover-shadow" style="border-radius: 10px; transition: all 0.2s;">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info text-white p-3 mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas fa-handshake"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold text-dark mb-0">Empréstimos</h6>
                                                <small class="text-muted">Kits, mochilas e controle</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <a href="/equipamentos" class="card text-decoration-none border shadow-sm h-100 p-3 hover-shadow" style="border-radius: 10px; transition: all 0.2s;">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white p-3 mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas fa-laptop"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold text-dark mb-0">Equipamentos</h6>
                                                <small class="text-muted">Inventário e ativos</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-md-4 mb-3">
                                    <a href="/dashboard" class="card text-decoration-none border shadow-sm h-100 p-3 hover-shadow" style="border-radius: 10px; transition: all 0.2s;">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success text-white p-3 mr-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <i class="fas fa-chart-pie"></i>
                                            </div>
                                            <div>
                                                <h6 class="font-weight-bold text-dark mb-0">Dashboard Geral</h6>
                                                <small class="text-muted">Visão de atendimentos</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-light text-muted small" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                            Tenha um excelente dia de trabalho! Qualquer dúvida, consulte a equipe do SEINTEC / SETEC.
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if (!empty($emprestimosAbertos)): ?>
<!-- Modal Alerta de Empréstimos em Aberto -->
<div class="modal fade" id="modal-aviso-emprestimos-abertos" tabindex="-1" role="dialog" aria-labelledby="modalAvisoEmprestimosTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
            
            <!-- Header vibrante de alerta com contraste nítido -->
            <div class="modal-header py-3 px-4 d-flex align-items-center" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); color: #ffffff; border-bottom: none;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white p-2 mr-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 46px; height: 46px; min-width: 46px; font-size: 1.4rem; color: #b45309;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-white mb-0" id="modalAvisoEmprestimosTitle" style="letter-spacing: 0.3px;">
                            Atenção: Empréstimos de Mochilas em Aberto!
                        </h5>
                        <small class="text-white-50 font-weight-light">
                            Verificação de devoluções e conferência obrigatória dos equipamentos
                        </small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar" style="opacity: 0.9; text-shadow: none; font-size: 1.8rem; line-height: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background-color: #f8fafc; max-height: 68vh; overflow-y: auto;">
                
                <!-- Caixa de Atenção / Conferência Obrigatória -->
                <div class="alert shadow-sm border-0 mb-4 p-3" style="background: #fffbeb; border-left: 6px solid #f59e0b !important; border-radius: 12px;">
                    <div class="d-flex align-items-start">
                        <div class="mr-3 mt-1" style="font-size: 1.8rem; color: #d97706;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-1" style="color: #92400e; font-size: 1.05rem;">
                                REGRA OBRIGATÓRIA DE CONFERÊNCIA DE EQUIPAMENTOS:
                            </h6>
                            <p class="mb-0 text-dark" style="font-size: 0.95rem; line-height: 1.5;">
                                Quando a pessoa for devolver ou já tiver devolvido a mochila, <strong>todos os equipamentos devem ser rigorosamente conferidos</strong> para verificar se <strong>está tudo certo, completo (notebook, carregador/fonte, cabos, mouse, etc.) e se voltou exatamente do jeito que saiu</strong>. Não libere no sistema sem realizar a checagem física de todos os itens!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Título da lista de empréstimos em aberto -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-uppercase text-muted font-weight-bold mb-0" style="font-size: 0.82rem; letter-spacing: 0.5px;">
                        <i class="fas fa-box-open mr-1 text-warning"></i> Mochilas atualmente em posse de servidores (<?= count($emprestimosAbertos) ?>):
                    </h6>
                    <span class="badge badge-warning px-3 py-1 font-weight-bold" style="border-radius: 20px; font-size: 0.8rem;">
                        <?= count($emprestimosAbertos) ?> pendente(s)
                    </span>
                </div>

                <!-- Lista de Cards -->
                <div class="row">
                    <?php foreach ($emprestimosAbertos as $item): ?>
                        <?php
                            $dataEmpFormatada = '-';
                            if (!empty($item['data_emprestimo'])) {
                                $ts = strtotime($item['data_emprestimo']);
                                $dataEmpFormatada = $ts ? date('d/m/Y H:i', $ts) : esc($item['data_emprestimo']);
                                if (str_ends_with($dataEmpFormatada, '00:00')) {
                                    $dataEmpFormatada = date('d/m/Y', $ts);
                                }
                            }
                        ?>
                        <div class="col-12 mb-3">
                            <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #ffffff; border-left: 5px solid #2563eb !important;">
                                <div class="card-body p-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="badge badge-dark px-3 py-1 font-weight-bold mr-2 shadow-sm" style="font-size: 0.9rem; border-radius: 20px;">
                                                <i class="fas fa-briefcase text-warning mr-1"></i> Mochila #<?= esc($item['numero_mochila']) ?>
                                            </span>
                                            <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold" style="font-size: 0.8rem; border-radius: 20px;">
                                                <i class="fas fa-clock mr-1"></i> Em aberto
                                            </span>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt mr-1"></i> Emprestado em: <strong><?= $dataEmpFormatada ?></strong>
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="text-dark font-weight-bold" style="font-size: 1.15rem;">
                                            <i class="fas fa-user text-primary mr-2"></i> <?= esc($item['nome_recebedor']) ?>
                                        </div>
                                        <?php if (!empty($item['email_recebedor'])): ?>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-envelope mr-1"></i> <?= esc($item['email_recebedor']) ?>
                                            </small>
                                        <?php endif; ?>
                                        <?php if (!empty($item['nome_responsavel'])): ?>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-user-shield mr-1"></i> Entregue por: <strong><?= esc($item['nome_responsavel']) ?></strong>
                                            </small>
                                        <?php endif; ?>
                                        <?php if (!empty($item['obs'])): ?>
                                            <small class="text-secondary d-block mt-1 font-italic">
                                                <i class="fas fa-comment-alt mr-1"></i> Observações: <?= esc($item['obs']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Área de Pergunta e Ação -->
                                    <div class="p-3 rounded bg-light border d-flex flex-wrap justify-content-between align-items-center" style="border-radius: 8px;">
                                        <div class="mr-2 mb-2 mb-md-0">
                                            <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                                                <i class="fas fa-question-circle text-info mr-1"></i> <strong><?= esc($item['nome_recebedor']) ?></strong> já devolveu esta mochila?
                                            </span>
                                            <div class="text-muted small mt-1">
                                                Conferiu se o notebook, carregador e mouse estão completos e em ordem?
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success btn-sm font-weight-bold btn-devolver-modal shadow-sm px-3 py-2" 
                                                    data-id="<?= esc($item['id_emprestimo']) ?>"
                                                    data-mochila="<?= esc($item['numero_mochila']) ?>"
                                                    data-recebedor="<?= esc($item['nome_recebedor']) ?>">
                                                <i class="fas fa-check-circle mr-1"></i> Sim, já devolveu (Conferir e Liberar)
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class="modal-footer py-3 px-4 bg-light d-flex justify-content-between align-items-center">
                <a href="/emprestimos" class="btn btn-outline-primary btn-sm font-weight-bold">
                    <i class="fas fa-external-link-alt mr-1"></i> Ir para Controle de Empréstimos
                </a>
                <button type="button" class="btn btn-secondary btn-sm px-4 font-weight-bold" data-dismiss="modal">
                    Entendido / Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulário oculto para processar devolução rápida com CSRF nativo -->
<form id="form-devolucao-rapida" method="post" action="/emprestimos/salvarDataDevolucao" style="display:none;">
    <?= csrf_field() ?>
    <input type="hidden" name="id_emprestimo" id="devolucao-rapida-id" value="">
    <input type="hidden" name="data_devolucao" id="devolucao-rapida-data" value="">
</form>

<script>
window.addEventListener('load', function() {
    // 1. Limpa o parâmetro 'login=1' da URL para não reabrir o popup em recarregamentos manuais
    if (window.history.replaceState && window.location.search.includes('login=1')) {
        const url = new URL(window.location.href);
        url.searchParams.delete('login');
        const novaUrl = url.pathname + (url.search ? url.search : '');
        window.history.replaceState({}, document.title, novaUrl);
    }

    // 2. Disparo automático do popup caso o usuário acabou de logar
    <?php if (!empty($mostrarPopup)): ?>
    if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
        window.$('#modal-aviso-emprestimos-abertos').modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        });
    }
    <?php endif; ?>

    // 3. Ação do botão "Já devolveu (Conferir e Liberar)"
    document.querySelectorAll('.btn-devolver-modal').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const mochila = this.getAttribute('data-mochila');
            const recebedor = this.getAttribute('data-recebedor');

            const mensagem = 
                "⚠️ CONFIRMAÇÃO OBRIGATÓRIA DE CONFERÊNCIA:\n\n" +
                "Você conferiu TODOS os equipamentos da Mochila #" + mochila + " devolvida por " + recebedor + "?\n\n" +
                "✔ Notebook testado e funcionando\n" +
                "✔ Fonte / carregador presente e em bom estado\n" +
                "✔ Cabos, mouse e acessórios conferidos\n" +
                "✔ Mochila sem danos e voltou do mesmo jeito que saiu\n\n" +
                "Deseja confirmar a devolução e liberar a mochila no sistema agora?";

            if (confirm(mensagem)) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const dataDevolucaoFormatada = `${year}-${month}-${day} ${hours}:${minutes}:00`;

                document.getElementById('devolucao-rapida-id').value = id;
                document.getElementById('devolucao-rapida-data').value = dataDevolucaoFormatada;
                document.getElementById('form-devolucao-rapida').submit();
            }
        });
    });
});
</script>
<?php endif; ?>
