
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Agenda/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Novo Agendamento</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Nome / local</label>
                                  <input type="text" class="form-control" name="Nomelocal">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data</label>
                                  <input type="text" class="form-control" name="Data">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Tipo</label>
                                  <input type="text" class="form-control" name="Tipo">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Descrição</label>
                                  <input type="text" class="form-control" name="Descricao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Solicitado por</label>
                                  <input type="text" class="form-control" name="Solicitadopor">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Atendido por</label>
                                  <input type="text" class="form-control" name="Atendidopor">
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
              <form action="/Agenda/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Editar Agendamento</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Nome / local</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Nomelocal" name="Nomelocal">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Data" name="Data">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Tipo</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Tipo" name="Tipo">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Descrição</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Descricao" name="Descricao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Atendido por</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Solicitadopor" name="Solicitadopor">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Atendido por</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Atendidopor" name="Atendidopor">
                              </div>
                          </div>
                        <input type="hidden" id="modal-editar-produto-AgendaId" name="AgendaId">
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
                      <h1 class="m-0">Agendamentos</h1>
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
                                  <i class="fas fa-plus-circle"></i> Novo Agendamento
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
                                          <th>NOME / LOCAL</th>
                                          <th>DATA</th>
                                          <th>TIPO</th>
                                          <th>DESCRIÇÃO</th>
                                          <th>SOLICITADO POR</th>
                                          <th>ATENDIDO POR</th>
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($agendagabs as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['AgendaId'] ?></td>
                                              <td><?= $agend['Nomelocal'] ?></td>
                                              <td><?= $agend['Data'] ?></td>
                                              <td><?= $agend['Tipo'] ?></td>
                                              <td><?= $agend['Descricao'] ?></td>
                                              <td><?= $agend['Solicitadopor'] ?></td>
                                              <td><?= $agend['Atendidopor'] ?></td>
                                             
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $agend['AgendaId'] ?>', '<?= $agend['Nomelocal'] ?>', '<?= $agend['Data'] ?>', '<?= $agend['Tipo'] ?>', '<?= $agend['Descricao'] ?>', '<?= $agend['Solicitadopor'] ?>', '<?= $agend['Atendidopor'] ?>')"><i class="fas fa-edit"></i></button>
                                                  <a href="/Agenda/excluir/<?= $agend['AgendaId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(AgendaId, Nome, Data, Tipo, Descricao, Atendidopor) {
          document.getElementById('modal-editar-produto-AgendaId').value = AgendaId;
          document.getElementById('modal-editar-produto-Nomelocal').value = Nomelocal;
          document.getElementById('modal-editar-produto-Data').value = Data;
          document.getElementById('modal-editar-produto-Tipo').value = Tipo;
          document.getElementById('modal-editar-produto-Descricao').value = Descricao;
          document.getElementById('modal-editar-produto-Solicitadopor').value = Solicitadopor;
          document.getElementById('modal-editar-produto-Atendidopor').value = Atendidopor;
         

          $('#modal-editar-produto').modal('show');
      }
  </script>

  

</html>
