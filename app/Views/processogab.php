
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Processo/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Novo Processo Administrativo</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">                        
                          
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Nº do processo</label>
                                  <input type="text" class="form-control" name="Nprocesso">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Servidor</label>
                                  <input type="text" class="form-control" name="Servidor">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Comissão</label>
                                  <input type="text" class="form-control" name="Comissao">
                              </div>
                          </div>
                           <div class="col-3">
                              <div class="form-group">
                                  <label for="">Andamento</label>
                                  <input type="text" class="form-control" name="Andamento">
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
              <form action="/Processo/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Editar Processo Administrativo</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                           <div class="col-6">
                              <div class="form-group">
                                  <label for="">Nº do processo</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Nprocesso" name="Nprocesso">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Servidor</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Servidor" name="Servidor">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Comissão</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Comissao" name="Comissao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Andamento </label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Andamento" name="Andamento">
                              </div>
                          </div>
                        <input type="hidden" id="modal-editar-produto-ProcessoId" name="ProcessoId">
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
                      <h1 class="m-0">Processo Administrativo</h1>
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
                                  <i class="fas fa-plus-circle"></i> Nova Processo administrativo
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
                                          <th>Nº do processo</th>
                                          <th>Servidor</th>
                                          <th>Comissão</th>
                                          <th>Andamento</th>                                          
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($processos as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['ProcessoId'] ?></td>
                                              <td><?= $agend['Nprocesso'] ?></td>
                                              <td><?= $agend['Servidor'] ?></td>
                                              <td><?= $agend['Comissao'] ?></td>
                                              <td><?= $agend['Andamento'] ?></td>
                                                                                           
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $agend['ProcessoId'] ?>', '<?= $agend['Nprocesso'] ?>', '<?= $agend['Servidor'] ?>', '<?= $agend['Comissao'] ?>', '<?= $agend['Andamento'] ?>')"><i class="fas fa-edit"></i></button>
                                                  <a href="/Processo/excluir/<?= $agend['ProcessoId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(ProcessoId, Nprocesso, Servidor, Comissao, Andamento) {
          document.getElementById('modal-editar-produto-ProcessoId').value = ProcessoId;
          document.getElementById('modal-editar-produto-Nprocesso').value = Nprocesso;
          document.getElementById('modal-editar-produto-Servidor').value = Servidor;
          document.getElementById('modal-editar-produto-Comissao').value = Comissao;
          document.getElementById('modal-editar-produto-Andamento').value = Andamento;
                   

          $('#modal-editar-produto').modal('show');
      }
  </script>

  

</html>
