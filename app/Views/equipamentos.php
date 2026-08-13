
<div class="modal fade" id="modal-novo-equipamento">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/equipamentos/salvarMultiplo" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Equipamento</h4>
                    <button type="button" id="btn-add-equipamento" class="btn btn-sm btn-success ml-3">Adicionar</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height:60vh; overflow:auto;">
                    <div id="equipamento-groups">
                        <div class="equipamento-group" data-index="0">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipo</label>
                                                <input type="text" class="form-control" name="tipo[]" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Marca e Modelo</label>
                                                <input type="text" class="form-control" name="marca_modelo[]" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nº de Patrimônio</label>
                                                <input type="text" class="form-control" name="patrimonio[]" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nº de Serial</label>
                                                <input type="text" class="form-control" name="serial[]" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Estado de Conservação</label>
                                                <select class="form-control" name="estado_conservacao[]" required>
                                                    <option value="">Selecione</option>
                                                    <option value="Excelente">Excelente</option>
                                                    <option value="Bom">Bom</option>
                                                    <option value="Ruim">Ruim</option>
                                                    <option value="Péssimo">Péssimo</option>
                                                    <option value="Chamado Aberto">Chamado Aberto</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Categoria</label>
                                                <select class="form-control" name="categoria[]" required>
                                                    <option value="">Selecione</option>
                                                    <?php if (!empty($categorias)) : ?>
                                                        <?php foreach ($categorias as $categoriaOpcao) : ?>
                                                            <option value="<?= esc($categoriaOpcao['nome'] ?? '') ?>"><?= esc($categoriaOpcao['nome'] ?? '-') ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome da Sala</label>
                                                <select class="form-control" name="sala[]">
                                                    <option value="">Selecione</option>
                                                    <?php if (!empty($salas)) : ?>
                                                        <?php foreach ($salas as $salaOpcao) : ?>
                                                            <option value="<?= esc($salaOpcao['id_sala'] ?? '') ?>"><?= esc($salaOpcao['nome_sala'] ?? '-') ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-equipamento-group">Remover</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-equipamentos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/equipamentos/editarMultiplo" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h4 class="modal-title">Editar Equipamentos Selecionados</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="editar-equipamento-groups"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="bulk-delete-equipamentos" action="/equipamentos/excluirMultiplo" method="post" class="d-none">
    <?= csrf_field() ?>
</form>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Registro de Equipamentos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Equipamentos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php if (isset($_GET['alert']) && $_GET['alert'] === 'successCreate') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Equipamento registrado com sucesso.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'errorCreate') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Erro</h5>
                            Falha ao registrar o equipamento.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'successEdit') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Equipamento atualizado com sucesso.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'errorEdit') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Erro</h5>
                            Falha ao atualizar o equipamento.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'successDelete') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Equipamento removido com sucesso.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'errorDelete') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Erro</h5>
                            Falha ao remover o equipamento.
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <button type="button" class="btn btn-info mr-2 mb-2" data-toggle="modal" data-target="#modal-novo-equipamento" onclick="resetarModalEquipamento()">
                        <i class="fas fa-plus-circle"></i> Novo Equipamento
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div id="bulk-actions-equipamentos" class="d-none align-items-center mb-2">
                        <span id="bulk-selected-count-equipamentos" class="mr-3 font-weight-bold"></span>
                        <button type="button" class="btn btn-warning btn-sm mr-2" id="btn-bulk-editar-equipamentos">Editar</button>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-bulk-apagar-equipamentos">Apagar</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="select-all-equipamentos"></th>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Marca e Modelo</th>
                                        <th>Nº de Patrimônio</th>
                                        <th>Nº de Serial</th>
                                        <th>Estado de Conservação</th>
                                        <th>Categoria</th>
                                        <th>Nº do Andar</th>
                                        <th>Nome da Sala</th>
                                        <th>Data Registro</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($itens)) : ?>
                                        <?php foreach ($itens as $item) : ?>
                                            <tr data-id="<?= esc($item['id_item'] ?? '', 'attr') ?>"
                                                data-tipo="<?= esc($item['tipo'] ?? '', 'attr') ?>"
                                                data-marca="<?= esc($item['marca_modelo'] ?? '', 'attr') ?>"
                                                data-patrimonio="<?= esc($item['patrimonio'] ?? '', 'attr') ?>"
                                                data-serial="<?= esc($item['serial'] ?? '', 'attr') ?>"
                                                data-estado="<?= esc($item['estado_conservacao'] ?? '', 'attr') ?>"
                                                data-categoria="<?= esc($item['categoria'] ?? '', 'attr') ?>"
                                                data-sala="<?= esc($item['sala'] ?? '', 'attr') ?>">
                                                <td class="text-center"><input type="checkbox" class="row-select-equipamento"></td>
                                                <td><?= esc($item['id_item'] ?? '-') ?></td>
                                                <td><?= esc($item['tipo'] ?? '-') ?></td>
                                                <td><?= esc($item['marca_modelo'] ?? '-') ?></td>
                                                <td><?= esc($item['patrimonio'] ?? '-') ?></td>
                                                <td><?= esc($item['serial'] ?? '-') ?></td>
                                                <td><?= esc($item['estado_conservacao'] ?? '-') ?></td>
                                                <td><?= esc($item['categoria'] ?? '-') ?></td>
                                                <td><?= esc($item['andar'] ?? '-') ?></td>
                                                <td><?= esc($item['nome_sala'] ?? $item['sala'] ?? '-') ?></td>
                                                <td><?= esc($item['data_registro'] ?? '-') ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-novo-equipamento" onclick="prepararDadosEquipamento(
                                                        '<?= esc($item['id_item'] ?? '', 'js') ?>',
                                                        '<?= esc($item['tipo'] ?? '', 'js') ?>',
                                                        '<?= esc($item['marca_modelo'] ?? '', 'js') ?>',
                                                        '<?= esc($item['patrimonio'] ?? '', 'js') ?>',
                                                        '<?= esc($item['serial'] ?? '', 'js') ?>',
                                                        '<?= esc($item['estado_conservacao'] ?? '', 'js') ?>',
                                                        '<?= esc($item['categoria'] ?? '', 'js') ?>',
                                                        '<?= esc($item['andar'] ?? '', 'js') ?>',
                                                        '<?= esc($item['sala'] ?? '', 'js') ?>'
                                                    )">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="/equipamentos/excluir/<?= esc($item['id_item'] ?? '', 'url') ?>" method="post" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este equipamento?');">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="12" class="text-center">Nenhum equipamento registrado ainda.</td>
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

<script>
    function removerParametroAlerta() {
        const url = new URL(window.location.href);
        url.searchParams.delete('alert');
        const newUrl = url.pathname + (url.search ? url.search : '');
        window.history.replaceState({}, document.title, newUrl);
    }

    function resetarModalEquipamento() {
        const form = document.querySelector('#modal-novo-equipamento form');
        if (!form) {
            return;
        }

        const existingHiddenId = form.querySelector('input[name="id_item"]');
        if (existingHiddenId) {
            existingHiddenId.remove();
        }

        form.reset();
        form.action = '/equipamentos/salvarMultiplo';
        document.querySelector('#modal-novo-equipamento .modal-title').textContent = 'Registrar Equipamento';
        document.querySelector('#modal-novo-equipamento .btn-primary').innerHTML = '<i class="fas fa-save"></i> Cadastrar';
    }

    function prepararDadosEquipamento(idItem, tipo, marcaModelo, patrimonio, serial, estadoConservacao, categoria, andar, sala) {
        const form = document.querySelector('#modal-novo-equipamento form');
        if (!form) {
            return;
        }

        const existingHiddenId = form.querySelector('input[name="id_item"]');
        if (existingHiddenId) {
            existingHiddenId.remove();
        }

        const hiddenId = document.createElement('input');
        hiddenId.type = 'hidden';
        hiddenId.name = 'id_item';
        hiddenId.value = idItem || '';
        form.appendChild(hiddenId);

        form.querySelector('[name="tipo[]"]').value = tipo || '';
        form.querySelector('[name="marca_modelo[]"]').value = marcaModelo || '';
        form.querySelector('[name="patrimonio[]"]').value = patrimonio || '';
        form.querySelector('[name="serial[]"]').value = serial || '';
        form.querySelector('[name="estado_conservacao[]"]').value = estadoConservacao || '';
        form.querySelector('[name="categoria[]"]').value = categoria || '';
        form.querySelector('[name="sala[]"]').value = sala || '';
        form.action = '/equipamentos/editar';
        document.querySelector('#modal-novo-equipamento .modal-title').textContent = 'Editar Equipamento';
        document.querySelector('#modal-novo-equipamento .btn-primary').innerHTML = '<i class="fas fa-save"></i> Atualizar';
    }

    function updateBulkActionsEquipamentos() {
        const checked = document.querySelectorAll('.row-select-equipamento:checked');
        const bar = document.getElementById('bulk-actions-equipamentos');
        const count = document.getElementById('bulk-selected-count-equipamentos');
        if (!bar || !count) {
            return;
        }

        if (checked.length > 0) {
            bar.classList.remove('d-none');
            bar.classList.add('d-flex');
            count.textContent = checked.length + ' selecionado(s)';
        } else {
            bar.classList.add('d-none');
            bar.classList.remove('d-flex');
            count.textContent = '';
        }
    }

    function criarGrupoEquipamento() {
        const container = document.getElementById('equipamento-groups');
        if (!container) {
            return;
        }

        const grupo = container.querySelector('.equipamento-group');
        if (!grupo) {
            return;
        }

        const clone = grupo.cloneNode(true);
        clone.querySelectorAll('input, select').forEach((field) => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                field.checked = false;
            } else {
                field.value = '';
            }
        });
        container.appendChild(clone);
        updateRemoveButtonsEquipamento();
    }

    function updateRemoveButtonsEquipamento() {
        const groups = document.querySelectorAll('#equipamento-groups .equipamento-group');
        groups.forEach((group, index) => {
            const btn = group.querySelector('.btn-remove-equipamento-group');
            if (btn) {
                btn.style.display = index === 0 ? 'none' : 'inline-block';
            }
        });
    }

    function groupHasFilledFields(group) {
        if (!group) return false;
        const fields = Array.from(group.querySelectorAll('input, textarea, select'));
        return fields.some((field) => {
            const tag = field.tagName.toLowerCase();
            if (tag === 'select') {
                return field.value && field.value !== '';
            }
            if (field.type === 'checkbox' || field.type === 'radio') {
                return field.checked;
            }
            return field.value && String(field.value).trim() !== '';
        });
    }

    document.getElementById('btn-add-equipamento')?.addEventListener('click', function () {
        criarGrupoEquipamento();
        const modalBody = document.querySelector('#modal-novo-equipamento .modal-body');
        if (modalBody) {
            modalBody.scrollTop = modalBody.scrollHeight;
        }
    });

    // Delegated handler for remove buttons so it works for dynamically added groups
    document.addEventListener('click', function (event) {
        const button = event.target.closest('.btn-remove-equipamento-group');
        if (!button) return;

        const group = button.closest('.equipamento-group');
        if (!group) return;

        const groups = document.querySelectorAll('#equipamento-groups .equipamento-group');
        if (groups.length <= 1) return;

        if (groupHasFilledFields(group) && !confirm('Esta caixa contém campos preenchidos. Tem certeza que deseja remover e perder estes dados?')) {
            return;
        }

        group.remove();
        updateRemoveButtonsEquipamento();
    });

    document.getElementById('select-all-equipamentos')?.addEventListener('change', function () {
        document.querySelectorAll('.row-select-equipamento').forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsEquipamentos();
    });

    document.querySelectorAll('.row-select-equipamento').forEach((checkbox) => {
        checkbox.addEventListener('change', updateBulkActionsEquipamentos);
    });

    document.getElementById('btn-bulk-apagar-equipamentos')?.addEventListener('click', function () {
        const ids = Array.from(document.querySelectorAll('.row-select-equipamento:checked')).map((checkbox) => {
            const row = checkbox.closest('tr');
            return row?.dataset?.id || '';
        }).filter(Boolean);

        if (!ids.length) {
            return;
        }

        if (!confirm('Tem certeza que deseja excluir os equipamentos selecionados?')) {
            return;
        }

        const form = document.getElementById('bulk-delete-equipamentos');
        if (!form) {
            return;
        }

        form.querySelectorAll('input[name="id_item[]"]').forEach((field) => field.remove());
        ids.forEach((id) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_item[]';
            input.value = id;
            form.appendChild(input);
        });
        form.submit();
    });

    document.getElementById('btn-bulk-editar-equipamentos')?.addEventListener('click', function () {
        const rows = Array.from(document.querySelectorAll('.row-select-equipamento:checked')).map((checkbox) => checkbox.closest('tr')).filter(Boolean);
        if (!rows.length) {
            return;
        }

        const container = document.getElementById('editar-equipamento-groups');
        if (!container) {
            return;
        }

        container.innerHTML = '';
        rows.forEach((row) => {
            const group = document.createElement('div');
            group.className = 'card mb-3';
            group.innerHTML = `
                <div class="card-body">
                    <input type="hidden" name="id_item[]" value="${row.dataset.id || ''}">
                    <div class="row">
                        <div class="col-md-6"><div class="form-group"><label>Tipo</label><input type="text" class="form-control" name="tipo[]" value="${row.dataset.tipo || ''}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Marca e Modelo</label><input type="text" class="form-control" name="marca_modelo[]" value="${row.dataset.marca || ''}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Nº de Patrimônio</label><input type="text" class="form-control" name="patrimonio[]" value="${row.dataset.patrimonio || ''}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Nº de Serial</label><input type="text" class="form-control" name="serial[]" value="${row.dataset.serial || ''}" required></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Estado de Conservação</label><select class="form-control" name="estado_conservacao[]" required><option value="">Selecione</option><option value="Excelente" ${row.dataset.estado === 'Excelente' ? 'selected' : ''}>Excelente</option><option value="Bom" ${row.dataset.estado === 'Bom' ? 'selected' : ''}>Bom</option><option value="Ruim" ${row.dataset.estado === 'Ruim' ? 'selected' : ''}>Ruim</option><option value="Péssimo" ${row.dataset.estado === 'Péssimo' ? 'selected' : ''}>Péssimo</option><option value="Chamado Aberto" ${row.dataset.estado === 'Chamado Aberto' ? 'selected' : ''}>Chamado Aberto</option></select></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Categoria</label><select class="form-control" name="categoria[]" required><option value="">Selecione</option><?php foreach ($categorias as $categoriaOpcao) : ?><option value="<?= esc($categoriaOpcao['nome'] ?? '') ?>"><?= esc($categoriaOpcao['nome'] ?? '-') ?></option><?php endforeach; ?></select></div></div>
                        <div class="col-md-6"><div class="form-group"><label>Nome da Sala</label><select class="form-control" name="sala[]"><option value="">Selecione</option><?php foreach ($salas as $salaOpcao) : ?><option value="<?= esc($salaOpcao['id_sala'] ?? '') ?>"><?= esc($salaOpcao['nome_sala'] ?? '-') ?></option><?php endforeach; ?></select></div></div>
                    </div>
                </div>
            `;
            const categoriaField = group.querySelector('[name="categoria[]"]');
            if (categoriaField) {
                categoriaField.value = row.dataset.categoria || '';
            }
            const salaField = group.querySelector('[name="sala[]"]');
            if (salaField) {
                salaField.value = row.dataset.sala || '';
            }
            container.appendChild(group);
        });

        if (window.$) {
            $('#modal-editar-equipamentos').modal('show');
        }
    });

    updateBulkActionsEquipamentos();
    updateRemoveButtonsEquipamento();
</script>
