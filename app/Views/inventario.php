<div class="modal fade" id="modal-editar-kit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="/inventario/salvar" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kit" value="">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Kit de Equipamentos</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row font-weight-bold border-bottom pb-2 mb-2">
                        <div class="col-3"></div>
                        <div class="col-3">Marca e Modelo</div>
                        <div class="col-2">Nº de Serial</div>
                        <div class="col-2">Nº de Patrimônio</div>
                        <div class="col-2">Estado de Conservação</div>
                    </div>

                    <?php $items = [
                        'notebook' => ['label' => 'Notebook', 'required' => true],
                        'mouse' => ['label' => 'Mouse', 'required' => true],
                        'carregador' => ['label' => 'Carregador', 'required' => true],
                        'adaptador' => ['label' => 'Adaptador USB VGA', 'required' => false],
                        'locker' => ['label' => 'Locker', 'required' => false],
                    ]; ?>
                    <?php foreach ($items as $key => $config): ?>
                        <div class="row align-items-end mb-2">
                            <div class="col-3">
                                <label class="font-weight-bold"><?= esc($config['label']) ?></label>
                            </div>
                            <div class="col-3">
                                <input type="text" name="items[<?= esc($key) ?>][marca_modelo]" class="form-control" <?= $config['required'] ? 'required' : '' ?>>
                            </div>
                            <div class="col-2">
                                <input type="text" name="items[<?= esc($key) ?>][serial]" class="form-control" <?= $config['required'] ? 'required' : '' ?>>
                            </div>
                            <div class="col-2">
                                <input type="text" name="items[<?= esc($key) ?>][patrimonio]" class="form-control" <?= $config['required'] ? 'required' : '' ?>>
                            </div>
                            <div class="col-2">
                                <select name="items[<?= esc($key) ?>][estado_conservacao]" class="form-control" <?= $config['required'] ? 'required' : '' ?>>
                                    <option value="">Selecione</option>
                                    <option value="Excelente">Excelente</option>
                                    <option value="Bom">Bom</option>
                                    <option value="Ruim">Ruim</option>
                                    <option value="Péssimo">Péssimo</option>
                                    <option value="Chamado Aberto">Chamado Aberto</option>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php $extraColumns = $extra_columns ?? []; ?>

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Kit</th>
                                        <th>Número Mochila</th>
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
                                            <tr>
                                                <td><?= esc($kit['id_kit'] ?? '-') ?></td>
                                                <td><?= esc($kit['numero_mochila'] ?? '-') ?></td>
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
                                                    <form action="/inventario/excluir/<?= esc($kit['id_kit'] ?? '', 'url') ?>" method="post" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir os equipamentos deste kit?');">
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
                                            <td colspan="9" class="text-center">Nenhum kit registrado ainda.</td>
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

    function prepararDadosKit(idKit, notebookMarcaModelo, notebookSerial, notebookPatrimonio, notebookEstado, mouseMarcaModelo, mouseSerial, mousePatrimonio, mouseEstado, carregadorMarcaModelo, carregadorSerial, carregadorPatrimonio, carregadorEstado, adaptadorMarcaModelo, adaptadorSerial, adaptadorPatrimonio, adaptadorEstado, lockerMarcaModelo, lockerSerial, lockerPatrimonio, lockerEstado) {
        const form = document.querySelector('#modal-editar-kit form');
        if (!form) {
            return;
        }

        form.querySelector('input[name="id_kit"]').value = idKit || '';

        const setFieldValue = (name, value) => {
            const field = form.querySelector(`[name="${name}"]`);
            if (field) {
                field.value = value || '';
            }
        };

        setFieldValue('items[notebook][marca_modelo]', notebookMarcaModelo);
        setFieldValue('items[notebook][serial]', notebookSerial);
        setFieldValue('items[notebook][patrimonio]', notebookPatrimonio);
        setFieldValue('items[notebook][estado_conservacao]', notebookEstado);

        setFieldValue('items[mouse][marca_modelo]', mouseMarcaModelo);
        setFieldValue('items[mouse][serial]', mouseSerial);
        setFieldValue('items[mouse][patrimonio]', mousePatrimonio);
        setFieldValue('items[mouse][estado_conservacao]', mouseEstado);

        setFieldValue('items[carregador][marca_modelo]', carregadorMarcaModelo);
        setFieldValue('items[carregador][serial]', carregadorSerial);
        setFieldValue('items[carregador][patrimonio]', carregadorPatrimonio);
        setFieldValue('items[carregador][estado_conservacao]', carregadorEstado);

        setFieldValue('items[adaptador][marca_modelo]', adaptadorMarcaModelo);
        setFieldValue('items[adaptador][serial]', adaptadorSerial);
        setFieldValue('items[adaptador][patrimonio]', adaptadorPatrimonio);
        setFieldValue('items[adaptador][estado_conservacao]', adaptadorEstado);

        setFieldValue('items[locker][marca_modelo]', lockerMarcaModelo);
        setFieldValue('items[locker][serial]', lockerSerial);
        setFieldValue('items[locker][patrimonio]', lockerPatrimonio);
        setFieldValue('items[locker][estado_conservacao]', lockerEstado);
    }
</script>
