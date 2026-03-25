
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Termogab/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Novo Termo de Visita</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Processo SEI</label>
                                  <input type="text" class="form-control" name="Observacoes">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                 <label for="">Supervisores</label>
                                    <select id="supervisorSelect" name="SupervisorId" class="form-control">
    <option value="">Selecione</option>
    <?php foreach($supervisores as $s): ?>
        <option value="<?= $s['SupervisorId'] ?>">
            <?= $s['nome'] ?>
        </option>
    <?php endforeach; ?>
</select>
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                         <label for="">Setor</label>
                                        <select id="setorSelect" name="SetorId" class="form-control" disabled>
</select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                 <label>Escola</label>

        <!-- nome digitável -->
        <input type="text"
               id="inputEscola"
               class="form-control"
               autocomplete="off"
               placeholder="Digite o nome da escola">

        <!-- ID real que vai pro banco -->
        <input type="hidden" name="EscolaId" id="EscolaId">

        <!-- lista autocomplete -->
        <div id="listaEscolas"
             class="list-group position-absolute w-100"
             style="z-index:999"></div>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Tipo</label>
                                  <input type="text" class="form-control" name="Tipo">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data</label>
                                  <input type="date" class="form-control" name="Data">
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

  <div class="modal fade" id="modal-editar-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Termogab/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Editar Termo de visita</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Processo SEI</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Processosei" name="Observacoes">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
              <select id="supervisorSelect" name="SupervisorId" class="form-control">
    <option value="">Selecione</option>
    <?php foreach($supervisores as $s): ?>
        <option value="<?= $s['SupervisorId'] ?>">
            <?= $s['nome'] ?>
        </option>
    <?php endforeach; ?>
</select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Escola</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-EscolaId" name="EscolaId">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                <select id="setorSelect" name="SetorId" class="form-control" disabled>
</select>

                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <select id="escolaSelect" name="EscolaId" class="form-control">
</select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Tipo</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Tipo" name="Tipo">
                              </div>
                          </div>
                           <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Data" name="Data">
                              </div>
                          </div>
                        <input type="hidden" id="modal-editar-produto-VisitaId" name="VisitaId">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0">Termos de visitas</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Starter Page</li>
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-body">
                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-novo-produto">
                                  <i class="fas fa-plus-circle"></i> Novo Termo de Visita
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
              <?php if (isset($_GET['alert']) && $_GET['alert'] == "successCreate") : ?>
                  <div class="row">
                      <div class="col-12">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                              Agendamento cadastrado com sucesso!
                          </div>
                      </div>
                  </div>
              <?php endif; ?>
              <?php if (isset($_GET['alert']) && $_GET['alert'] == "successDelete") : ?>
                  <div class="row">
                      <div class="col-12">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                              Agendamento excluido com sucesso!
                          </div>
                      </div>
                  </div>
              <?php endif; ?>
              <?php if (isset($_GET['alert']) && $_GET['alert'] == "successEdit") : ?>
                  <div class="row">
                      <div class="col-12">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                              Agendamento editado com sucesso!
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
                                          <th>CÓD.:</th>
                                          <th>PROCESSO SEI</th>
                                          <th>SUPERVISOR</th>
                                          <th>SETOR</th>
                                          <th>ESCOLA</th>
                                          <th>TIPO</th>
                                          <th>DATA</th>
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($termogabs as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['VisitaId'] ?></td>
                                              <td><?= $agend['Processosei'] ?></td>
                                              <td><?= $agend['Supervisor'] ?></td>
                                              <td><?= $agend['Setor'] ?></td>
                                              <td><?= $agend['Escola'] ?></td>
                                              <td><?= $agend['Tipo'] ?></td>
                                              <td><?= $agend['Data'] ?></td>
                                             
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto"
                                                  onclick="prepararDados(
                                                    '<?= $agend['VisitaId'] ?>',
                                                    '<?= $agend['Processosei'] ?>',
                                                    '<?= $agend['SupervisorId'] ?>',
                                                    '<?= $agend['SetorId'] ?>',
                                                    '<?= $agend['EscolaId'] ?>',
                                                    '<?= $agend['Escola'] ?>',
                                                    '<?= $agend['Tipo'] ?>',
                                                    '<?= $agend['Data'] ?>'
                                                        )"><i class="fas fa-edit"></i></button>
                                                  <a href="/Termogab/excluir/<?= $agend['VisitaId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                              </td>
                                          </tr>
                                      <?php endforeach; ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
      function prepararDados(VisitaId, Processosei, SupervisorId, SetorId, EscolaId, EscolaNome, Tipo, Data) {

    document.getElementById('modal-editar-produto-VisitaId').value = VisitaId;
    document.getElementById('modal-editar-produto-Processosei').value = Processosei;

    // SELECT supervisor
    document.querySelector('#modal-editar-produto select[name="SupervisorId"]').value = SupervisorId;

    // Escola (input + hidden se quiser manter padrão)
    document.getElementById('modal-editar-produto-EscolaId').value = EscolaId;

    // Tipo
    document.getElementById('modal-editar-produto-Tipo').value = Tipo;

    // Data
    document.getElementById('modal-editar-produto-Data').value = Data;

    $('#modal-editar-produto').modal('show');
}
  </script>
<script>
const escolas = <?= json_encode($escolas) ?>;
const setores  = <?= json_encode($setores) ?>;
const supervisorSelect = document.getElementById('supervisorSelect');
const inputEscola   = document.getElementById('inputEscola');
const listaEscolas  = document.getElementById('listaEscolas');
const escolaIdInput = document.getElementById('EscolaId');
const setorSelect   = document.getElementById('setorSelect');

supervisorSelect.addEventListener('change', function(){

    const supId = this.value;

    setorSelect.innerHTML = '';

    const setor = setores.find(s => s.SupervisorId == supId);

    if (!setor) return;

    const opt = document.createElement('option');
    opt.value = setor.SetorId;
    opt.textContent = setor.nome;

    setorSelect.appendChild(opt);
    setorSelect.disabled = false;
});

/* =============================
   AUTOCOMPLETE ESCOLAS
============================= */
inputEscola.addEventListener('input', function () {

    const texto = this.value.toLowerCase();
    listaEscolas.innerHTML = '';

    if (!texto) return;

    const filtradas = escolas.filter(e =>
        e.nome.toLowerCase().includes(texto)
    );

    filtradas.forEach(e => {

        const item = document.createElement('a');
        item.className = 'list-group-item list-group-item-action';
        item.textContent = e.nome;

        item.onclick = () => selecionarEscola(e);

        listaEscolas.appendChild(item);
    });
});


/* =============================
   SELECIONA ESCOLA
============================= */
function selecionarEscola(escola){

    // escola
    inputEscola.value = escola.nome;
    escolaIdInput.value = escola.EscolaId;
    listaEscolas.innerHTML = '';
}


/* fecha lista ao clicar fora */
document.addEventListener('click', function(e){
    if (!inputEscola.contains(e.target))
        listaEscolas.innerHTML = '';
});
</script>

</html>
