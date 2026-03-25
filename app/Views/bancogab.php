<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="modal fade" id="modal-novo-produto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/Bancogab/cadastrar" method="post" onsubmit="return validarPessoaSelecionada()">
                <div class="modal-header">
                    <h4 class="modal-title">Novo Banco de Horas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group position-relative">
                                <label for="nomePessoa">Servidor / Supervisor</label>
                                <input type="text" id="nomePessoa" class="form-control" placeholder="Digite o nome" autocomplete="off">
                                <input type="hidden" name="servidor_id" id="servidor_id">
                                <input type="hidden" name="supervisor_id" id="supervisor_id">
                                <div id="sugestoes" class="list-group position-absolute w-100" style="z-index:1050;"></div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="setorServidor">Tipo</label>
                                <input type="text" class="form-control" id="setorServidor" readonly>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Data</label>
                                <input type="date" class="form-control" name="Data" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Horas</label>
                                <input type="text" class="form-control" name="Horas" placeholder="Ex: 02:30" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-produto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/Bancogab/editar" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Banco de Horas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" class="form-control" id="modal-editar-produto-Nome" readonly>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Tipo</label>
                                <input type="text" class="form-control" id="modal-editar-produto-Setor" readonly>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Data</label>
                                <input type="date" class="form-control" id="modal-editar-produto-Data" name="Data">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Horas</label>
                                <input type="text" class="form-control" id="modal-editar-produto-Horas" name="Horas">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <select class="form-control" id="modal-editar-produto-Status" name="Status">
                                    <option value="Disponivel">Disponivel</option>
                                    <option value="Usado">Usado</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="modal-editar-produto-BancoId" name="BancoId">
                        <input type="hidden" id="modal-editar-produto-servidor_id" name="servidor_id">
                        <input type="hidden" id="modal-editar-produto-supervisor_id" name="supervisor_id">
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Atualizar
                    </button>
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
                    <h1 class="m-0">Banco de Horas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Banco de Horas</li>
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
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-novo-produto">
                                <i class="fas fa-plus-circle"></i> Novo Banco de Horas
                            </button>

                            <label class="ml-3">Pesquisar</label>
                            <input type="text" placeholder="Nome" id="pesquisarBanco">
                        </div>

                        <div class="px-3 pb-3">
                            <a href="/bancogab/bancogab" class="btn btn-info">Todos</a>
                            <a href="/bancogab/bancogab?Status=Usado" class="btn btn-success">Usado</a>
                            <a href="/bancogab/bancogab?Status=Disponivel" class="btn btn-warning">Disponivel</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == "successCreate") : ?>
                <div class="alert alert-success">Banco de horas cadastrado com sucesso!</div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == "successDelete") : ?>
                <div class="alert alert-success">Banco de horas excluído com sucesso!</div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == "successEdit") : ?>
                <div class="alert alert-success">Banco de horas editado com sucesso!</div>
            <?php endif; ?>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == "errorPessoa") : ?>
                <div class="alert alert-danger">Selecione um servidor ou supervisor da lista.</div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>CÓD.</th>
                                        <th>NOME</th>
                                        <th>TIPO</th>
                                        <th>DATA</th>
                                        <th>HORAS</th>
                                        <th>STATUS</th>
                                        <th>AÇÕES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($bancogabs)) : ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Nenhum registro encontrado.</td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php foreach ($bancogabs as $agend) : ?>
                                        <tr>
                                            <td><?= $agend['BancoId'] ?></td>
                                            <td><?= $agend['nome_exibicao'] ?? '' ?></td>
                                            <td><?= $agend['lotacao'] ?? 'Não informado' ?></td>
                                            <td><?= $agend['Data'] ?></td>
                                            <td><?= $agend['Horas'] ?></td>
                                            <td>
                                                <select class="form-control form-control-sm"
                                                    onchange="alterarStatusBanco(this.value, <?= $agend['BancoId'] ?>)">
                                                    <option value="Disponivel" <?= $agend['Status'] == 'Disponivel' ? 'selected' : '' ?>>
                                                        Disponivel
                                                    </option>
                                                    <option value="Usado" <?= $agend['Status'] == 'Usado' ? 'selected' : '' ?>>
                                                        Usado
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-warning"
                                                    onclick="prepararDados(
                                                        '<?= $agend['BancoId'] ?>',
                                                        '<?= $agend['nome_exibicao'] ?? '' ?>',
                                                        '<?= $agend['lotacao'] ?? '' ?>',
                                                        '<?= $agend['Data'] ?>',
                                                        '<?= $agend['Horas'] ?>',
                                                        '<?= $agend['Status'] ?>',
                                                        '<?= $agend['servidor_id'] ?? '' ?>',
                                                        '<?= $agend['supervisor_id'] ?? '' ?>'
                                                    )">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a href="/Bancogab/excluir/<?= $agend['BancoId'] ?>"
                                                   class="btn btn-danger"
                                                   onclick="return confirm('Deseja realmente excluir este registro?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
    function prepararDados(BancoId, Nome, Setor, Data, Horas, Status, servidor_id, supervisor_id) {
        document.getElementById('modal-editar-produto-BancoId').value = BancoId;
        document.getElementById('modal-editar-produto-Nome').value = Nome;
        document.getElementById('modal-editar-produto-Setor').value = Setor;
        document.getElementById('modal-editar-produto-Data').value = Data;
        document.getElementById('modal-editar-produto-Horas').value = Horas;
        document.getElementById('modal-editar-produto-Status').value = Status;
        document.getElementById('modal-editar-produto-servidor_id').value = servidor_id ?? '';
        document.getElementById('modal-editar-produto-supervisor_id').value = supervisor_id ?? '';

        $('#modal-editar-produto').modal('show');
    }

    function validarPessoaSelecionada() {
        let servidorId = document.getElementById('servidor_id').value;
        let supervisorId = document.getElementById('supervisor_id').value;

        if (!servidorId && !supervisorId) {
            alert('Selecione um servidor ou supervisor da lista.');
            return false;
        }

        return true;
    }

    document.getElementById("pesquisarBanco").addEventListener("keyup", function() {
        let filtro = this.value.toLowerCase();
        let linhas = document.querySelectorAll("table tbody tr");

        linhas.forEach(function(linha) {
            let nome = linha.children[1].textContent.toLowerCase();
            linha.style.display = nome.includes(filtro) ? "" : "none";
        });
    });

    function alterarStatusBanco(novoStatus, id) {
        fetch('/bancogab/alterarStatusBanco', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'BancoId=' + encodeURIComponent(id) + '&Status=' + encodeURIComponent(novoStatus)
        })
        .then(response => response.text())
        .then(data => {
            console.log('Status atualizado');
        });
    }

    document.getElementById('nomePessoa').addEventListener('keyup', function () {
        let termo = this.value;
        let lista = document.getElementById('sugestoes');

        if (termo.length < 2) {
            lista.innerHTML = '';
            return;
        }

        fetch('/bancogab/buscarPessoas?term=' + encodeURIComponent(termo))
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';

                data.forEach(pessoa => {
                    let item = document.createElement('a');
                    item.href = 'javascript:void(0)';
                    item.classList.add('list-group-item', 'list-group-item-action');

                    if (pessoa.tipo === 'servidor') {
                        item.textContent = `${pessoa.nome} ${pessoa.ultimoNome ?? ''} - Servidor`;
                    } else {
                        item.textContent = `${pessoa.nome} - Supervisor`;
                    }

                    item.onclick = function () {
                        document.getElementById('nomePessoa').value = item.textContent;

                        if (pessoa.tipo === 'servidor') {
                            document.getElementById('servidor_id').value = pessoa.id;
                            document.getElementById('supervisor_id').value = '';
                            document.getElementById('setorServidor').value = pessoa.lotacao ?? 'Servidor';
                        } else {
                            document.getElementById('supervisor_id').value = pessoa.id;
                            document.getElementById('servidor_id').value = '';
                            document.getElementById('setorServidor').value = pessoa.lotacao ?? 'Supervisor';
                        }

                        lista.innerHTML = '';
                    };

                    lista.appendChild(item);
                });
            });
    });

    document.addEventListener('click', function(e) {
        let sugestoes = document.getElementById('sugestoes');
        let nomePessoa = document.getElementById('nomePessoa');

        if (!sugestoes.contains(e.target) && e.target !== nomePessoa) {
            sugestoes.innerHTML = '';
        }
    });
</script>