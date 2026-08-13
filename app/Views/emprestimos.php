<div class="modal fade" id="modal-novo-emprestimos">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="/emprestimos/salvar" method="post">

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
            <div class="col-4">
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

            <div class="col-4">
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
                            <input type="checkbox" class="custom-control-input status-equipamento" value="chamado aberto">
                            <label class="custom-control-label"></label>
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
<div class="modal-header">
<h4 class="modal-title">Editar Empréstimos Selecionados</h4>
<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">
    <?= csrf_field() ?>
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

<form id="bulk-release-form" action="/emprestimos/salvarDataDevolucaoMultiplo" method="post" class="d-none">
    <?= csrf_field() ?>
</form>
<form id="bulk-delete-form" action="/emprestimos/excluirMultiplo" method="post" class="d-none">
    <?= csrf_field() ?>
</form>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Empréstimos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Empréstimos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <button type="button" class="btn btn-info mr-2 mb-2" data-toggle="modal" data-target="#modal-novo-emprestimos">
                        <i class="fas fa-plus-circle"></i> Novo Empréstimo
                    </button>
                    <button type="button" class="btn btn-secondary mb-2" id="btn-toggle-resumo">
                        <i class="fas fa-eye"></i> Exibir Resumo
                    </button>
                </div>
            </div>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successCreate') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Empréstimo cadastrado com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successEdit') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Empréstimo editado com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-12">
                    <form method="get" action="/emprestimos" class="form-inline flex-wrap">
                        <select name="nome_recebedor" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todos os solicitantes</option>
                            <?php foreach ($nomeRecebedores as $nome): ?>
                                <option value="<?= esc($nome) ?>" <?= ($filtros['nome_recebedor'] ?? '') === $nome ? 'selected' : '' ?>><?= esc($nome) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="nome_responsavel" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todos os responsáveis</option>
                            <?php foreach ($nomeResponsaveis as $nome): ?>
                                <option value="<?= esc($nome) ?>" <?= ($filtros['nome_responsavel'] ?? '') === $nome ? 'selected' : '' ?>><?= esc($nome) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="date" name="data_emprestimo" class="form-control form-control-sm mr-2 mb-2" value="<?= esc($filtros['data_emprestimo'] ?? '') ?>" title="Data de recebimento">
                        <input type="date" name="data_devolucao" class="form-control form-control-sm mr-2 mb-2" value="<?= esc($filtros['data_devolucao'] ?? '') ?>" title="Data de devolução">

                        <select name="secao" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todas as seções</option>
                            <?php foreach ($sessoes as $s): ?>
                                <option value="<?= $s['secaoID'] ?>" <?= ($filtros['secao'] ?? '') == $s['secaoID'] ? 'selected' : '' ?>><?= esc($s['nomeSecao']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="status" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todos os status</option>
                            <?php foreach ($statusOptions as $status): ?>
                                <option value="<?= esc($status) ?>" <?= ($filtros['status'] ?? '') == $status ? 'selected' : '' ?>><?= esc($status) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn btn-sm btn-primary mr-2 mb-2">Filtrar</button>
                        <a href="/emprestimos" class="btn btn-sm btn-outline-secondary mb-2">Limpar</a>
                    </form>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div id="bulk-actions" class="d-none align-items-center mb-2">
                        <span id="bulk-selected-count" class="mr-3 font-weight-bold"></span>
                        <button type="button" class="btn btn-success btn-sm mr-2" id="btn-bulk-liberar">Liberar</button>
                        <button type="button" class="btn btn-warning btn-sm mr-2" id="btn-bulk-editar">Editar</button>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-bulk-apagar">Apagar</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-12" id="emprestimos-list-col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
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
                                                <td><?= esc($e['numero_mochila']) ?></td>
                                                <td><?= esc($e['setor_display'] ?? '-') ?></td>
                                                <td><?= esc($e['nome_recebedor']) ?></td>
                                                <td><?= esc($e['email_recebedor']) ?></td>
                                                <td><?= esc($e['nome_responsavel']) ?></td>
                                                <td><?= esc($e['status_equipamento']) ?></td>
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

                <div class="col-lg-3 col-12 d-none" id="resumo-mochila-panel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Resumo por mochila</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered mb-0">
                                    <thead>
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
                                                    <td><?= esc($resumo['numero'] ?? '-') ?></td>
                                                    <td><?= esc($resumo['status'] ?? '-') ?></td>
                                                    <td class="duracao-emprestimo" data-start="<?= esc($resumo['data_emprestimo'] ?? '') ?>" data-end="<?= esc($resumo['data_devolucao'] ?? '') ?>"><?= esc($resumo['duracao_emprestimo'] ?? '-') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Nenhuma mochila encontrada.</td>
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

        const servidoresData = <?= json_encode($servidores, JSON_UNESCAPED_UNICODE) ?>;
        const servidoresResponsavel = <?= json_encode($servidoresResponsavel, JSON_UNESCAPED_UNICODE) ?>;
        const supervisoresExtras = <?= json_encode($supervisoresExtras ?? [], JSON_UNESCAPED_UNICODE) ?>;
        const fieldsExtras = <?= json_encode($fieldsExtras ?? [], JSON_UNESCAPED_UNICODE) ?>;

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
            document.querySelectorAll('.lista-solicitantes, .lista-responsaveis').forEach(function (lista) {
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

        function buildKitOptionsHtml(currentValue) {
            let html = '<option value="">Selecione</option>';
            allKits.forEach(function (kit) {
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
                            <div class="col-4">
                                <div class="form-group">
                                    <label>ID do Kit</label>
                                    <input type="hidden" name="id_emprestimo[]" value="${escapeHtml(id)}">
                                    <select name="numero_mochila[]" class="form-control numero-mochila" required>
                                        ${buildKitOptionsHtml(numeroMochila)}
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
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

        const allKits = <?= json_encode($availableMochilas ?? [], JSON_UNESCAPED_UNICODE) ?>;
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
            const existing = groupsContainer.querySelector('.emprestimo-group');
            if (!existing) return;

            const clone = existing.cloneNode(true);
            clone.dataset.index = String(Date.now());

            clone.querySelectorAll('input, textarea').forEach(function (el) {
                if (el.id) el.removeAttribute('id');
                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = false;
                } else {
                    el.value = '';
                }
            });

            clone.querySelectorAll('select').forEach(function (sel) {
                if (sel.id) sel.removeAttribute('id');
                sel.value = '';
            });

            clone.querySelectorAll('.list-group').forEach(function (lg) {
                lg.innerHTML = '';
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
                document.querySelectorAll('.lista-solicitantes, .lista-responsaveis').forEach(function (lista) {
                    lista.innerHTML = '';
                });
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

