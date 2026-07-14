<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="modal fade" id="modal-novo-processo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/Nova/cadastrar" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">NOVO PROCESSO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nº SEI</label>
                                <input type="text" class="form-control" name="numeroSEI">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Assunto</label>
                                <input type="text" class="form-control" name="assunto">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Escola</label>
                                <select class="form-control" name="escola" required>
                                    <option value="">Selecione uma escola</option>
                                    <?php if (!empty($escolas)) : ?>
                                        <?php foreach ($escolas as $escola) : ?>
                                            <option value="<?= esc($escola['EscolaId']) ?>"><?= esc($escola['Nome']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Data de entrada</label>
                                <input type="date" class="form-control" name="dataEntrada">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Data de saída</label>
                                <input type="date" class="form-control" name="dataSaida">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Mesa de destino</label>
                                <input type="text" class="form-control" name="mesaDestino">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Comarca</label>
                                <input type="text" class="form-control" name="comarca">
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

<div class="modal fade" id="modal-editar-processo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/Nova/editar" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR PROCESSO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nº SEI</label>
                                <input type="text" class="form-control" id="modal-editar-processo-numeroSEI" name="numeroSEI">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Assunto</label>
                                <input type="text" class="form-control" id="modal-editar-processo-assunto" name="assunto">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Escola</label>
                                <select class="form-control" id="modal-editar-processo-escola" name="escola" required>
                                    <option value="">Selecione uma escola</option>
                                    <?php if (!empty($escolas)) : ?>
                                        <?php foreach ($escolas as $escola) : ?>
                                            <option value="<?= esc($escola['EscolaId']) ?>"><?= esc($escola['Nome']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Data de entrada</label>
                                <input type="date" class="form-control" id="modal-editar-processo-dataEntrada" name="dataEntrada">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Data de saída</label>
                                <input type="date" class="form-control" id="modal-editar-processo-dataSaida" name="dataSaida">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Mesa de destino</label>
                                <input type="text" class="form-control" id="modal-editar-processo-mesaDestino" name="mesaDestino">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Comarca</label>
                                <input type="text" class="form-control" id="modal-editar-processo-comarca" name="comarca">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Atualizar</button>
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
                    <h1 class="m-0">Processos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Processos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-novo-processo">
                                <i class="fas fa-plus-circle"></i> Novo processo
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successCreate') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Processo cadastrado com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successDelete') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Processo excluído com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successEdit') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Processo editado com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'errorMissingSei') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                            O número do SEI é obrigatório para salvar ou editar o processo.
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nº SEI</th>
                                        <th>Assunto</th>
                                        <th>Escola</th>
                                        <th>Data entrada</th>
                                        <th>Data saída</th>
                                        <th>Mesa de destino</th>
                                        <th>Comarca</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items)) : ?>
                                        <?php foreach ($items as $item) : ?>
                                            <tr>
                                                <td><?= esc($item['numeroSEI']) ?></td>
                                                <td><?= esc($item['assunto']) ?></td>
                                                <td><?= esc($item['nomeEscola']) ?></td>
                                                <td><?= esc($item['dataEntrada']) ?></td>
                                                <td><?= esc($item['dataSaida']) ?></td>
                                                <td><?= esc($item['mesaDestino']) ?></td>
                                                <td><?= esc($item['comarca']) ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-processo" onclick="prepararDados('<?= esc($item['numeroSEI'], 'js') ?>', '<?= esc($item['assunto'], 'js') ?>', '<?= esc($item['escolaId'], 'js') ?>', '<?= esc($item['dataEntrada'], 'js') ?>', '<?= esc($item['dataSaida'], 'js') ?>', '<?= esc($item['mesaDestino'], 'js') ?>', '<?= esc($item['comarca'], 'js') ?>')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="/Nova/excluir/<?= esc($item['numeroSEI'], 'url') ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir este processo (SEI: <?= esc($item['numeroSEI']) ?>)?')"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Nenhum processo encontrado.</td>
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
    function prepararDados(numeroSEI, assunto, escolaId, dataEntrada, dataSaida, mesaDestino, comarca) {
        document.getElementById('modal-editar-processo-numeroSEI').value = numeroSEI;
        document.getElementById('modal-editar-processo-assunto').value = assunto;
        document.getElementById('modal-editar-processo-escola').value = escolaId || '';
        document.getElementById('modal-editar-processo-dataEntrada').value = dataEntrada;
        document.getElementById('modal-editar-processo-dataSaida').value = dataSaida;
        document.getElementById('modal-editar-processo-mesaDestino').value = mesaDestino;
        document.getElementById('modal-editar-processo-comarca').value = comarca;

        $('#modal-editar-processo').modal('show');
    }
</script>