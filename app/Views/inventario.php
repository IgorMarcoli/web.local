<div class="modal fade" id="modal-editar-kit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="/inventario/salvarMultiplo" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar Kit de Equipamentos</h4>
                    <button type="button" id="btn-add-kit-group" class="btn btn-sm btn-success ml-3">Adicionar</button>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="kit-create-groups">
                        <div class="kit-group" data-index="0">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <input type="hidden" name="id_kit[]" value="">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Número da Mochila</label>
                                            <input type="text" class="form-control numero-mochila-input" name="numero_mochila[]" value="">
                                            <div class="invalid-feedback numero-mochila-feedback" style="display:none;">Esse número ou ID de kit já está registrado. Favor insira outro.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Categoria</label>
                                            <select class="form-control" name="categoria[]" required>
                                                <option value="">Selecione</option>
                                                <?php if (!empty($categorias)): ?>
                                                    <?php foreach ($categorias as $categoriaOpcao): ?>
                                                        <option value="<?= esc($categoriaOpcao['nome'] ?? '') ?>"><?= esc($categoriaOpcao['nome'] ?? '-') ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row font-weight-bold border-bottom pb-2 mb-2">
                                        <div class="col-3"></div>
                                        <div class="col-3">Marca e Modelo</div>
                                        <div class="col-2">Nº de Serial</div>
                                        <div class="col-2">Nº de Patrimônio</div>
                                        <div class="col-2">Estado de Conservação</div>
                                    </div>

                                    <?php $items = [
                                        'notebook' => ['label' => 'Notebook', 'required' => true, 'checkbox' => false],
                                        'mouse' => ['label' => 'Mouse', 'required' => true, 'checkbox' => true],
                                        'carregador' => ['label' => 'Carregador', 'required' => true, 'checkbox' => true],
                                        'adaptador' => ['label' => 'Adaptador USB VGA', 'required' => false, 'checkbox' => true],
                                        'locker' => ['label' => 'Locker', 'required' => false, 'checkbox' => true],
                                    ]; ?>
                                    <?php foreach ($items as $key => $config): ?>
                                        <div class="row align-items-end mb-2 item-row" data-item-key="<?= esc($key) ?>">
                                            <div class="col-3">
                                                <?php if (!empty($config['checkbox'])): ?>
                                                    <div class="d-flex align-items-center">
                                                        <label class="font-weight-bold mb-0"><?= esc($config['label']) ?></label>
                                                        <div class="custom-control custom-checkbox ml-2">
                                                            <input type="checkbox" class="custom-control-input item-checkbox" id="skip-create-0-<?= esc($key) ?>" name="items[<?= esc($key) ?>][skip][0]" value="1" data-required="<?= $config['required'] ? 'true' : 'false' ?>">
                                                            <label class="custom-control-label" for="skip-create-0-<?= esc($key) ?>"></label>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <label class="font-weight-bold"><?= esc($config['label']) ?></label>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-9 item-fields">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="text" name="items[<?= esc($key) ?>][marca_modelo][]" class="form-control item-input" <?= $config['required'] ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="text" name="items[<?= esc($key) ?>][serial][]" class="form-control item-input" <?= $config['required'] ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="text" name="items[<?= esc($key) ?>][patrimonio][]" class="form-control item-input" <?= $config['required'] ? 'required' : '' ?>>
                                                    </div>
                                                    <div class="col-3">
                                                        <select name="items[<?= esc($key) ?>][estado_conservacao][]" class="form-control item-input" <?= $config['required'] ? 'required' : '' ?>>
                                                            <option value="">Selecione</option>
                                                            <option value="Excelente">Excelente</option>
                                                            <option value="Bom">Bom</option>
                                                            <option value="Ruim">Ruim</option>
                                                            <option value="Péssimo">Péssimo</option>
                                                            <option value="Chamado Aberto">Chamado Aberto</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-kit-group">Remover</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="bulk-delete-kits" action="/inventario/excluirMultiplo" method="post" class="d-none">
    <?= csrf_field() ?>
</form>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inventário de Kits</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Inventário</li>
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
                            Kit registrado com sucesso.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'errorCreate') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Erro</h5>
                            Falha ao registrar o kit. Verifique os campos e tente novamente.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'successDelete') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Equipamentos do kit removidos com sucesso.
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_GET['alert']) && $_GET['alert'] === 'errorDelete') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Erro</h5>
                            Falha ao excluir os equipamentos do kit.
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-12 d-flex align-items-center flex-wrap">
                    <?php $extraColumns = $extra_columns ?? []; ?>
                    <button type="button" class="btn btn-info mr-2 mb-2" data-toggle="modal" data-target="#modal-editar-kit" onclick="resetarModalKit()">
                        <i class="fas fa-plus-circle"></i> Adicionar Kit
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div id="bulk-actions-inventario" class="d-none align-items-center mb-2">
                        <span id="bulk-selected-count-inventario" class="mr-3 font-weight-bold"></span>
                        <button type="button" class="btn btn-warning btn-sm mr-2" id="btn-bulk-editar-inventario">Editar</button>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-bulk-apagar-inventario">Apagar</button>
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
                                        <th class="text-center"><input type="checkbox" id="select-all-inventario"></th>
                                        <th>ID Kit</th>
                                        <th>Número Mochila</th>
                                        <th>Categoria</th>
                                        <th>Notebook</th>
                                        <th>Mouse</th>
                                        <th>Carregador</th>
                                        <th>Adaptador USB VGA</th>
                                        <th>Locker</th>
                                        <th>Data Registro</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($kits)): ?>
                                        <?php foreach ($kits as $kit): ?>
                                            <tr data-id="<?= esc($kit['id_kit'] ?? '', 'attr') ?>"
                                                data-numero="<?= esc($kit['numero_mochila'] ?? '', 'attr') ?>"
                                                data-categoria="<?= esc($kit['categoria'] ?? 'Individual', 'attr') ?>"
                                                data-notebook-marca="<?= esc($kit['notebook_marca_modelo'] ?? '', 'attr') ?>"
                                                data-notebook-serial="<?= esc($kit['notebook_serial'] ?? '', 'attr') ?>"
                                                data-notebook-patrimonio="<?= esc($kit['notebook_patrimonio'] ?? '', 'attr') ?>"
                                                data-notebook-estado="<?= esc($kit['notebook_estado_conservacao'] ?? '', 'attr') ?>"
                                                data-mouse-marca="<?= esc($kit['mouse_marca_modelo'] ?? '', 'attr') ?>"
                                                data-mouse-serial="<?= esc($kit['mouse_serial'] ?? '', 'attr') ?>"
                                                data-mouse-patrimonio="<?= esc($kit['mouse_patrimonio'] ?? '', 'attr') ?>"
                                                data-mouse-estado="<?= esc($kit['mouse_estado_conservacao'] ?? '', 'attr') ?>"
                                                data-carregador-marca="<?= esc($kit['carregador_marca_modelo'] ?? '', 'attr') ?>"
                                                data-carregador-serial="<?= esc($kit['carregador_serial'] ?? '', 'attr') ?>"
                                                data-carregador-patrimonio="<?= esc($kit['carregador_patrimonio'] ?? '', 'attr') ?>"
                                                data-carregador-estado="<?= esc($kit['carregador_estado_conservacao'] ?? '', 'attr') ?>"
                                                data-adaptador-marca="<?= esc($kit['adaptador_marca_modelo'] ?? '', 'attr') ?>"
                                                data-adaptador-serial="<?= esc($kit['adaptador_serial'] ?? '', 'attr') ?>"
                                                data-adaptador-patrimonio="<?= esc($kit['adaptador_patrimonio'] ?? '', 'attr') ?>"
                                                data-adaptador-estado="<?= esc($kit['adaptador_estado_conservacao'] ?? '', 'attr') ?>"
                                                data-locker-marca="<?= esc($kit['locker_marca_modelo'] ?? '', 'attr') ?>"
                                                data-locker-serial="<?= esc($kit['locker_serial'] ?? '', 'attr') ?>"
                                                data-locker-patrimonio="<?= esc($kit['locker_patrimonio'] ?? '', 'attr') ?>"
                                                data-locker-estado="<?= esc($kit['locker_estado_conservacao'] ?? '', 'attr') ?>">
                                                <td class="text-center"><input type="checkbox" class="row-select-inventario"></td>
                                                <td><?= esc($kit['id_kit'] ?? '-') ?></td>
                                                <td><?= esc($kit['numero_mochila'] ?? '-') ?></td>
                                                <td><?= esc($kit['categoria'] ?? '-') ?></td>
                                                <td><?= esc($kit['notebook_serial'] ?? '-') ?></td>
                                                <td><?= esc($kit['mouse_serial'] ?? '-') ?></td>
                                                <td><?= esc($kit['carregador_serial'] ?? '-') ?></td>
                                                <td><?= esc($kit['adaptador_serial'] ?? '-') ?></td>
                                                <td><?= esc($kit['locker_serial'] ?? '-') ?></td>
                                                <td><?= esc($kit['data_registro'] ?? '-') ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-editar-kit"
                                                        onclick="prepararDadosKit(
                                                            '<?= esc($kit['id_kit'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['numero_mochila'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['categoria'] ?? 'Individual', 'js') ?>',
                                                            '<?= esc($kit['notebook_marca_modelo'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['notebook_serial'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['notebook_patrimonio'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['notebook_estado_conservacao'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['mouse_marca_modelo'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['mouse_serial'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['mouse_patrimonio'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['mouse_estado_conservacao'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['carregador_marca_modelo'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['carregador_serial'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['carregador_patrimonio'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['carregador_estado_conservacao'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['adaptador_marca_modelo'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['adaptador_serial'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['adaptador_patrimonio'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['adaptador_estado_conservacao'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['locker_marca_modelo'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['locker_serial'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['locker_patrimonio'] ?? '', 'js') ?>',
                                                            '<?= esc($kit['locker_estado_conservacao'] ?? '', 'js') ?>'
                                                        )">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="/inventario/excluir/<?= esc($kit['id_kit'] ?? '', 'url') ?>" method="post" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir todo este kit?');">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">Nenhum kit registrado ainda.</td>
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
    let inventarioModalMode = 'add';

    function removerParametroAlerta() {
        const url = new URL(window.location.href);
        url.searchParams.delete('alert');
        const newUrl = url.pathname + (url.search ? url.search : '');
        window.history.replaceState({}, document.title, newUrl);
    }

    function setFieldsDisabled(container, disabled) {
        if (!container) {
            return;
        }

        container.querySelectorAll('input, select, textarea').forEach((field) => {
            field.disabled = disabled;
        });
    }

    function setModalModeInventario(mode, action = null) {
        const form = document.querySelector('#modal-editar-kit form');
        const addButton = document.getElementById('btn-add-kit-group');

        if (!form || !addButton) {
            return;
        }

        inventarioModalMode = mode === 'edit' ? 'edit' : 'add';
        addButton.style.display = inventarioModalMode === 'edit' ? 'none' : 'inline-block';

        form.action = action || (inventarioModalMode === 'edit' ? '/inventario/editarMultiplo' : '/inventario/salvarMultiplo');
    }

    function atualizarIdsCheckboxKit() {
        document.querySelectorAll('#kit-create-groups .kit-group').forEach((group, groupIndex) => {
            group.dataset.index = String(groupIndex);
            group.querySelectorAll('.item-row').forEach((row) => {
                const checkbox = row.querySelector('.item-checkbox');
                const label = row.querySelector('.custom-control-label');
                const itemKey = row.dataset.itemKey || 'item';
                if (!checkbox || !label) {
                    return;
                }

                const uniqueId = `skip-create-${groupIndex}-${itemKey}`;
                checkbox.id = uniqueId;
                checkbox.dataset.checkboxId = uniqueId;
                label.setAttribute('for', uniqueId);
                label.htmlFor = uniqueId;

                if (checkbox.name && checkbox.name.includes('[skip]')) {
                    checkbox.name = `items[${itemKey}][skip][${groupIndex}]`;
                }
            });
        });

    }

    function atualizarVisibilidadeItem(row) {
        const checkbox = row.querySelector('.item-checkbox');
        const fieldsContainer = row.querySelector('.item-fields');
        const fields = row.querySelectorAll('input, select');

        if (!checkbox || !fieldsContainer) {
            return;
        }

        const checked = checkbox.checked;
        fieldsContainer.style.display = checked ? 'none' : '';

        fields.forEach((field) => {
            if (field.name.includes('[skip]')) {
                return;
            }

            field.disabled = checked;

            if (checked) {
                field.removeAttribute('required');
                field.value = '';
            } else if (checkbox.dataset.required === 'true') {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }

    function validarNumeroMochila(field) {
        const modalInputs = Array.from(document.querySelectorAll('#kit-create-groups input[name="numero_mochila[]"]'));
        const selectedRowIds = Array.from(document.querySelectorAll('.row-select-inventario:checked'))
            .map((checkbox) => checkbox.closest('tr')?.dataset.id?.trim() || '')
            .filter((id) => id !== '');

        const modalIds = modalInputs
            .map((input) => input.closest('.kit-group')?.querySelector('input[name="id_kit[]"]')?.value?.trim() || '')
            .filter((id) => id !== '');

        // Fetch all existing rows from the table (including selected rows). We'll perform
        // per-input exclusion of the current group's own id when validating.
        const existingValuesAll = Array.from(document.querySelectorAll('table tbody tr[data-id]')).map((row) => ({
            id: String(row.dataset.id ?? '').trim(),
            numero: String(row.dataset.numero ?? '').trim(),
        })).filter((item) => item.id !== '');

        const valueCounts = modalInputs.reduce((acc, input) => {
            const inputValue = (input.value || '').trim();
            if (inputValue !== '') {
                acc[inputValue] = (acc[inputValue] || 0) + 1;
            }
            return acc;
        }, {});

        modalInputs.forEach((input) => {
            const value = (input.value || '').trim();
            const feedback = input.parentElement ? input.parentElement.querySelector('.numero-mochila-feedback') : null;
            const idInput = input.closest('.kit-group')?.querySelector('input[name="id_kit[]"]');
            const idx = parseInt(input.closest('.kit-group')?.dataset.index || '0', 10) || 0;

            if (value === '') {
                if (idInput && !idInput.value) {
                    idInput.value = String(100 + idx + 1);
                }
                input.classList.remove('is-invalid');
                input.classList.remove('is-valid');
                input.setCustomValidity('');
                if (feedback) {
                    feedback.style.display = 'none';
                }
                return;
            }

            const duplicateInGroup = valueCounts[value] > 1;
            const currentKitId = idInput && idInput.value ? String(idInput.value).trim() : '';
            const duplicateExisting = existingValuesAll.some((item) => item.numero === value && item.id !== currentKitId);
            const duplicateIdExisting = value !== '' && existingValuesAll.some((item) => item.id === value && item.id !== currentKitId);
            const isInvalid = duplicateInGroup || duplicateExisting || duplicateIdExisting;

            if (isInvalid) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                input.setCustomValidity('Esse número ou ID de kit já está registrado. Favor insira outro.');
                if (feedback) {
                    feedback.style.display = 'block';
                    feedback.textContent = 'Esse número ou ID de kit já está registrado. Favor insira outro.';
                }
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                input.setCustomValidity('');
                if (feedback) {
                    feedback.style.display = 'none';
                }
            }
        });
    }

    function configurarLinhasItens() {
        atualizarIdsCheckboxKit();

        document.querySelectorAll('#kit-create-groups .item-row').forEach((row) => {
            if (row.dataset.checkboxListener !== 'true') {
                const checkbox = row.querySelector('.item-checkbox');
                if (checkbox) {
                    checkbox.addEventListener('change', () => atualizarVisibilidadeItem(row));
                }
                row.dataset.checkboxListener = 'true';
            }
            atualizarVisibilidadeItem(row);
        });

        document.querySelectorAll('#kit-create-groups input[name="numero_mochila[]"]').forEach((input) => {
            if (!input.dataset.numeroValidated) {
                input.addEventListener('input', () => {
                    validarNumeroMochila(input);

                    // Se o número for removido, atribui um id temporário > 100 apenas para novos grupos
                    const val = (input.value || '').trim();
                    const group = input.closest('.kit-group');
                    const idInput = group ? group.querySelector('input[name="id_kit[]"]') : null;
                    const idx = parseInt(group?.dataset.index || '0', 10) || 0;
                    if (idInput && !idInput.value.trim() && val === '') {
                        idInput.value = String(100 + idx + 1);
                    }
                });
                input.addEventListener('blur', () => validarNumeroMochila(input));
                input.dataset.numeroValidated = 'true';
            }
            validarNumeroMochila(input);
        });
    }

    function resetarModalKit() {
        const form = document.querySelector('#modal-editar-kit form');
        if (!form) {
            return;
        }

        form.reset();
        form.querySelectorAll('input[name="id_kit[]"]').forEach((input) => {
            input.value = '';
        });

        setModalModeInventario('add');

        form.querySelectorAll('.numero-mochila-input').forEach((input) => {
            input.classList.remove('is-invalid');
            input.classList.remove('is-valid');
            input.setCustomValidity('');
            const feedback = input.parentElement ? input.parentElement.querySelector('.numero-mochila-feedback') : null;
            if (feedback) {
                feedback.style.display = 'none';
            }
        });

        const container = document.getElementById('kit-create-groups');
        if (container) {
            const groups = Array.from(container.querySelectorAll('.kit-group'));
            groups.forEach((group, index) => {
                if (index > 0) {
                    group.remove();
                }
            });
        }

        configurarLinhasItens();
        updateRemoveButtonsKit();
        document.querySelector('#modal-editar-kit .modal-title').textContent = 'Adicionar Kit de Equipamentos';
        document.querySelector('#modal-editar-kit .btn-primary').innerHTML = '<i class="fas fa-save"></i> Salvar Kit';
    }

    function updateRemoveButtonsKit() {
        const groups = document.querySelectorAll('#kit-create-groups .kit-group');
        groups.forEach((group, index) => {
            const button = group.querySelector('.btn-remove-kit-group');
            if (button) {
                button.style.display = index === 0 ? 'none' : 'inline-block';
            }
        });
    }

    function groupHasFilledFields(group) {
        if (!group) {
            return false;
        }

        const fields = Array.from(group.querySelectorAll('input, textarea, select'));
        return fields.some((field) => {
            if (field.name && field.name.includes('[skip]')) {
                return false;
            }

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

    function isKitGroupFilled(group) {
        const numeroField = group.querySelector('input[name="numero_mochila[]"]');
        const categoriaField = group.querySelector('select[name="categoria[]"]');
        if (numeroField && numeroField.value.trim() !== '') {
            return true;
        }
        if (categoriaField && categoriaField.value.trim() !== '') {
            return true;
        }

        const fields = Array.from(group.querySelectorAll('input, select, textarea'));
        return fields.some((field) => {
            if (field.name && field.name.includes('[skip]')) {
                return false;
            }
            const tag = field.tagName.toLowerCase();
            if (tag === 'select') {
                return field.value && field.value.trim() !== '';
            }
            if (field.type === 'checkbox' || field.type === 'radio') {
                return field.checked;
            }
            return field.value && String(field.value).trim() !== '';
        });
    }

    function criarGrupoKit() {
        const container = document.getElementById('kit-create-groups');
        if (!container) {
            return;
        }

        const template = container.querySelector('.kit-group');
        if (!template) {
            return;
        }

        const clone = template.cloneNode(true);
        const nextIndex = container.querySelectorAll('.kit-group').length;
        clone.dataset.index = String(nextIndex);
        clone.querySelectorAll('input, select').forEach((field) => {
            if (field.type === 'checkbox') {
                field.checked = false;
                field.value = '1';
                if (field.name && field.name.includes('[skip]')) {
                    field.name = field.name.replace(/\[skip\]\[\d*\]$/, `[skip][${nextIndex}]`);
                }
                return;
            }
            field.value = '';
            field.removeAttribute('data-numero-validated');
            if (field.classList.contains('numero-mochila-input')) {
                field.classList.remove('is-invalid');
                field.classList.remove('is-valid');
                field.setCustomValidity('');
                const feedback = field.parentElement ? field.parentElement.querySelector('.numero-mochila-feedback') : null;
                if (feedback) {
                    feedback.style.display = 'none';
                }
            }
            if (field.name && field.name.includes('[skip]')) {
                field.name = field.name.replace(/\[skip\]\[\d*\]$/, `[skip][${nextIndex}]`);
            }
        });

        clone.querySelectorAll('.item-row').forEach((row) => {
            row.dataset.checkboxListener = 'false';
            const checkbox = row.querySelector('.item-checkbox');
            const label = row.querySelector('.custom-control-label');
            if (checkbox && label) {
                const itemKey = row.dataset.itemKey || 'item';
                const nextCheckboxId = `skip-create-${nextIndex}-${itemKey}`;
                checkbox.id = nextCheckboxId;
                checkbox.dataset.checkboxId = nextCheckboxId;
                label.setAttribute('for', nextCheckboxId);
                label.htmlFor = nextCheckboxId;
                checkbox.checked = false;
            }
            row.querySelectorAll('input, select').forEach((field) => {
                if (field.name && field.name.includes('[skip]')) {
                    field.checked = false;
                    return;
                }
                field.disabled = false;
                field.removeAttribute('required');
                field.value = '';
            });
        });

        container.appendChild(clone);
        updateRemoveButtonsKit();
        configurarLinhasItens();

        const modalBody = document.querySelector('#modal-editar-kit .modal-body');
        if (modalBody) {
            modalBody.scrollTop = modalBody.scrollHeight;
        }
    }

    function prepararDadosKit(idKit, numeroMochila, categoria, notebookMarcaModelo, notebookSerial, notebookPatrimonio, notebookEstado, mouseMarcaModelo, mouseSerial, mousePatrimonio, mouseEstado, carregadorMarcaModelo, carregadorSerial, carregadorPatrimonio, carregadorEstado, adaptadorMarcaModelo, adaptadorSerial, adaptadorPatrimonio, adaptadorEstado, lockerMarcaModelo, lockerSerial, lockerPatrimonio, lockerEstado) {
        resetarModalKit();
        setModalModeInventario('edit', '/inventario/editarMultiplo');

        const group = document.querySelector('#kit-create-groups .kit-group');
        if (!group) {
            return;
        }

        group.dataset.kitId = String(idKit || '');
        const idKitInput = group.querySelector('input[name="id_kit[]"]');
        if (idKitInput) {
            idKitInput.value = idKit || '';
        }

        const numeroField = group.querySelector('input[name="numero_mochila[]"]');
        if (numeroField) {
            numeroField.value = numeroMochila || '';
        }

        const categoriaField = group.querySelector('select[name="categoria[]"]');
        if (categoriaField) {
            categoriaField.value = categoria || '';
        }

        const items = {
            notebook: { marca_modelo: notebookMarcaModelo, serial: notebookSerial, patrimonio: notebookPatrimonio, estado_conservacao: notebookEstado },
            mouse: { marca_modelo: mouseMarcaModelo, serial: mouseSerial, patrimonio: mousePatrimonio, estado_conservacao: mouseEstado },
            carregador: { marca_modelo: carregadorMarcaModelo, serial: carregadorSerial, patrimonio: carregadorPatrimonio, estado_conservacao: carregadorEstado },
            adaptador: { marca_modelo: adaptadorMarcaModelo, serial: adaptadorSerial, patrimonio: adaptadorPatrimonio, estado_conservacao: adaptadorEstado },
            locker: { marca_modelo: lockerMarcaModelo, serial: lockerSerial, patrimonio: lockerPatrimonio, estado_conservacao: lockerEstado },
        };

        group.querySelectorAll('.item-row').forEach((row) => {
            const itemKey = row.dataset.itemKey;
            const itemValues = items[itemKey] || { marca_modelo: '', serial: '', patrimonio: '', estado_conservacao: '' };
            const checkbox = row.querySelector('.item-checkbox');
            const marcaInput = row.querySelector(`input[name="items[${itemKey}][marca_modelo][]"]`);
            const serialInput = row.querySelector(`input[name="items[${itemKey}][serial][]"]`);
            const patrimonioInput = row.querySelector(`input[name="items[${itemKey}][patrimonio][]"]`);
            const estadoSelect = row.querySelector(`select[name="items[${itemKey}][estado_conservacao][]"]`);

            if (marcaInput) {
                marcaInput.value = itemValues.marca_modelo || '';
            }
            if (serialInput) {
                serialInput.value = itemValues.serial || '';
            }
            if (patrimonioInput) {
                patrimonioInput.value = itemValues.patrimonio || '';
            }
            if (estadoSelect) {
                estadoSelect.value = itemValues.estado_conservacao || '';
            }

            const itemEmpty = !itemValues.marca_modelo && !itemValues.serial && !itemValues.patrimonio && !itemValues.estado_conservacao;
            if (checkbox) {
                checkbox.checked = itemEmpty;
            }
            atualizarVisibilidadeItem(row);
        });

        document.querySelector('#modal-editar-kit .modal-title').textContent = 'Editar Kit de Equipamentos';
        document.querySelector('#modal-editar-kit .btn-primary').innerHTML = '<i class="fas fa-save"></i> Salvar Alterações';
        configurarLinhasItens();
    }

    function updateBulkActionsInventario() {
        const checked = document.querySelectorAll('.row-select-inventario:checked');
        const bar = document.getElementById('bulk-actions-inventario');
        const count = document.getElementById('bulk-selected-count-inventario');
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

    document.getElementById('btn-add-kit-group')?.addEventListener('click', criarGrupoKit);

    // Delegated handler: garante que inputs dinamicamente adicionados disparem validação e atualização de id
    document.querySelector('#modal-editar-kit')?.addEventListener('input', function (e) {
        const target = e.target;
        if (!(target instanceof HTMLElement)) return;
        if (target.name === 'numero_mochila[]') {
            try {
                validarNumeroMochila(target);
            } catch (err) {
                // ignore
            }

            const val = (target.value || '').trim();
            const group = target.closest('.kit-group');
            const idInput = group ? group.querySelector('input[name="id_kit[]"]') : null;
            const idx = parseInt(group?.dataset.index || '0', 10) || 0;
            if (idInput && !idInput.value.trim() && val === '') {
                idInput.value = String(100 + idx + 1);
            }
        }
    });

    document.querySelector('#modal-editar-kit form')?.addEventListener('submit', function (event) {
        const form = event.target;
        if (inventarioModalMode !== 'edit') {
            const groups = Array.from(form.querySelectorAll('#kit-create-groups .kit-group'));
            groups.forEach((group) => {
                if (!isKitGroupFilled(group)) {
                    group.remove();
                }
            });

            const remainingGroups = form.querySelectorAll('#kit-create-groups .kit-group');
            if (remainingGroups.length === 0) {
                event.preventDefault();
                alert('Nenhum kit preenchido para salvar.');
            }
        }
    });

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.btn-remove-kit-group');
        if (!button) {
            return;
        }

        const group = button.closest('.kit-group');
        if (!group) {
            return;
        }

        const groups = document.querySelectorAll('#kit-create-groups .kit-group');
        if (groups.length <= 1) {
            return;
        }

        if (groupHasFilledFields(group) && !confirm('Esta caixa contém campos preenchidos. Tem certeza que deseja remover e perder estes dados?')) {
            return;
        }

        group.remove();
        updateRemoveButtonsKit();
    });

    document.getElementById('select-all-inventario')?.addEventListener('change', function () {
        document.querySelectorAll('.row-select-inventario').forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsInventario();
    });

    document.querySelectorAll('.row-select-inventario').forEach((checkbox) => {
        checkbox.addEventListener('change', updateBulkActionsInventario);
    });

    document.getElementById('btn-bulk-apagar-inventario')?.addEventListener('click', function () {
        const ids = Array.from(document.querySelectorAll('.row-select-inventario:checked')).map((checkbox) => {
            const row = checkbox.closest('tr');
            return row?.dataset?.id || '';
        }).filter(Boolean);

        if (!ids.length) {
            return;
        }

        if (!confirm('Tem certeza que deseja excluir os kits selecionados?')) {
            return;
        }

        const form = document.getElementById('bulk-delete-kits');
        if (!form) {
            return;
        }

        form.querySelectorAll('input[name="id_kit[]"]').forEach((field) => field.remove());
        ids.forEach((id) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_kit[]';
            input.value = id;
            form.appendChild(input);
        });
        form.submit();
    });

    document.getElementById('btn-bulk-editar-inventario')?.addEventListener('click', function () {
        const rows = Array.from(document.querySelectorAll('.row-select-inventario:checked')).map((checkbox) => checkbox.closest('tr')).filter(Boolean);
        if (!rows.length) {
            return;
        }

        resetarModalKit();
        setModalModeInventario('edit', '/inventario/editarMultiplo');

        const container = document.getElementById('kit-create-groups');
        if (!container) {
            return;
        }

        const template = container.querySelector('.kit-group');
        if (!template) {
            return;
        }

        rows.forEach((row, rowIndex) => {
            const group = rowIndex === 0 ? template : template.cloneNode(true);
            if (rowIndex > 0) {
                container.appendChild(group);

                // Limpa flags de validação nos inputs clonados para anexar listeners novamente
                group.querySelectorAll('.numero-mochila-input').forEach((input) => {
                    input.removeAttribute('data-numero-validated');
                    input.classList.remove('is-invalid');
                    input.classList.remove('is-valid');
                    input.setCustomValidity('');
                    const feedback = input.parentElement ? input.parentElement.querySelector('.numero-mochila-feedback') : null;
                    if (feedback) {
                        feedback.style.display = 'none';
                    }
                });
            }

            group.dataset.index = String(rowIndex);
            const idKitInput = group.querySelector('input[name="id_kit[]"]');
            if (idKitInput) {
                idKitInput.value = row.dataset.id || '';
            }

            const numeroField = group.querySelector('input[name="numero_mochila[]"]');
            const categoriaField = group.querySelector('select[name="categoria[]"]');
            if (numeroField) {
                numeroField.value = row.dataset.numero || '';
            }
            if (categoriaField) {
                categoriaField.value = row.dataset.categoria || '';
            }

            const itemData = {
                notebook: { marca_modelo: row.dataset.notebookMarca || '', serial: row.dataset.notebookSerial || '', patrimonio: row.dataset.notebookPatrimonio || '', estado_conservacao: row.dataset.notebookEstado || '' },
                mouse: { marca_modelo: row.dataset.mouseMarca || '', serial: row.dataset.mouseSerial || '', patrimonio: row.dataset.mousePatrimonio || '', estado_conservacao: row.dataset.mouseEstado || '' },
                carregador: { marca_modelo: row.dataset.carregadorMarca || '', serial: row.dataset.carregadorSerial || '', patrimonio: row.dataset.carregadorPatrimonio || '', estado_conservacao: row.dataset.carregadorEstado || '' },
                adaptador: { marca_modelo: row.dataset.adaptadorMarca || '', serial: row.dataset.adaptadorSerial || '', patrimonio: row.dataset.adaptadorPatrimonio || '', estado_conservacao: row.dataset.adaptadorEstado || '' },
                locker: { marca_modelo: row.dataset.lockerMarca || '', serial: row.dataset.lockerSerial || '', patrimonio: row.dataset.lockerPatrimonio || '', estado_conservacao: row.dataset.lockerEstado || '' },
            };

            group.querySelectorAll('.item-row').forEach((rowElement) => {
                rowElement.dataset.checkboxListener = 'false';
                const itemKey = rowElement.dataset.itemKey;
                const values = itemData[itemKey] || { marca_modelo: '', serial: '', patrimonio: '', estado_conservacao: '' };
                const marcaInput = rowElement.querySelector(`input[name="items[${itemKey}][marca_modelo][]"]`);
                const serialInput = rowElement.querySelector(`input[name="items[${itemKey}][serial][]"]`);
                const patrimonioInput = rowElement.querySelector(`input[name="items[${itemKey}][patrimonio][]"]`);
                const estadoSelect = rowElement.querySelector(`select[name="items[${itemKey}][estado_conservacao][]"]`);
                const checkbox = rowElement.querySelector('.item-checkbox');

                if (marcaInput) {
                    marcaInput.value = values.marca_modelo;
                }
                if (serialInput) {
                    serialInput.value = values.serial;
                }
                if (patrimonioInput) {
                    patrimonioInput.value = values.patrimonio;
                }
                if (estadoSelect) {
                    estadoSelect.value = values.estado_conservacao;
                }

                const itemEmpty = !values.marca_modelo && !values.serial && !values.patrimonio && !values.estado_conservacao;
                if (checkbox) {
                    checkbox.checked = itemEmpty;
                }
            });
        });

        atualizarIdsCheckboxKit();
        updateRemoveButtonsKit();
        configurarLinhasItens();

        if (window.$) {
            $('#modal-editar-kit').modal('show');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        configurarLinhasItens();
        updateRemoveButtonsKit();
    });
    updateBulkActionsInventario();
</script>
