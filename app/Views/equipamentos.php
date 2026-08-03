
<div class="modal fade" id="modal-novo-equipamento">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/equipamentos/salvar" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Equipamento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <input type="text" class="form-control" id="tipo" name="tipo" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marca_modelo">Marca e Modelo</label>
                                <input type="text" class="form-control" id="marca_modelo" name="marca_modelo" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patrimonio">Nº de Patrimônio</label>
                                <input type="text" class="form-control" id="patrimonio" name="patrimonio" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serial">Nº de Serial</label>
                                <input type="text" class="form-control" id="serial" name="serial" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado_conservacao">Estado de Conservação</label>
                                <select class="form-control" id="estado_conservacao" name="estado_conservacao" required>
                                    <option value="">Selecione</option>
                                    <option value="Excelente">Excelente</option>
                                    <option value="Bom">Bom</option>
                                    <option value="Ruim">Ruim</option>
                                    <option value="Péssimo">Péssimo</option>
                                    <option value="Chamado Aberto">Chamado Aberto</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="andar">Nº do Andar</label>
                                <input type="text" class="form-control" id="andar" name="andar" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sala">Nome da Sala</label>
                                <input type="text" class="form-control" id="sala" name="sala" value="">
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-novo-equipamento" onclick="resetarModalEquipamento()">
                                <i class="fas fa-plus-circle"></i> Novo Equipamento
                            </button>
                        </div>
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
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Marca e Modelo</th>
                                        <th>Nº de Patrimônio</th>
                                        <th>Nº de Serial</th>
                                        <th>Estado de Conservação</th>
                                        <th>Nº do Andar</th>
                                        <th>Nome da Sala</th>
                                        <th>Data Registro</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($itens)) : ?>
                                        <?php foreach ($itens as $item) : ?>
                                            <tr>
                                                <td><?= esc($item['id_item'] ?? '-') ?></td>
                                                <td><?= esc($item['tipo'] ?? '-') ?></td>
                                                <td><?= esc($item['marca_modelo'] ?? '-') ?></td>
                                                <td><?= esc($item['patrimonio'] ?? '-') ?></td>
                                                <td><?= esc($item['serial'] ?? '-') ?></td>
                                                <td><?= esc($item['estado_conservacao'] ?? '-') ?></td>
                                                <td><?= esc($item['andar'] ?? '-') ?></td>
                                                <td><?= esc($item['sala'] ?? '-') ?></td>
                                                <td><?= esc($item['data_registro'] ?? '-') ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-novo-equipamento" onclick="prepararDadosEquipamento(
                                                        '<?= esc($item['id_item'] ?? '', 'js') ?>',
                                                        '<?= esc($item['tipo'] ?? '', 'js') ?>',
                                                        '<?= esc($item['marca_modelo'] ?? '', 'js') ?>',
                                                        '<?= esc($item['patrimonio'] ?? '', 'js') ?>',
                                                        '<?= esc($item['serial'] ?? '', 'js') ?>',
                                                        '<?= esc($item['estado_conservacao'] ?? '', 'js') ?>',
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
                                            <td colspan="10" class="text-center">Nenhum equipamento registrado ainda.</td>
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
        form.action = '/equipamentos/salvar';
        document.querySelector('#modal-novo-equipamento .modal-title').textContent = 'Registrar Equipamento';
        document.querySelector('#modal-novo-equipamento .btn-primary').innerHTML = '<i class="fas fa-save"></i> Cadastrar';
    }

    function prepararDadosEquipamento(idItem, tipo, marcaModelo, patrimonio, serial, estadoConservacao, andar, sala) {
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

        form.querySelector('[name="tipo"]').value = tipo || '';
        form.querySelector('[name="marca_modelo"]').value = marcaModelo || '';
        form.querySelector('[name="patrimonio"]').value = patrimonio || '';
        form.querySelector('[name="serial"]').value = serial || '';
        form.querySelector('[name="estado_conservacao"]').value = estadoConservacao || '';
        form.querySelector('[name="andar"]').value = andar || '';
        form.querySelector('[name="sala"]').value = sala || '';
        form.action = '/equipamentos/editar';
        document.querySelector('#modal-novo-equipamento .modal-title').textContent = 'Editar Equipamento';
        document.querySelector('#modal-novo-equipamento .btn-primary').innerHTML = '<i class="fas fa-save"></i> Atualizar';
    }
</script>
