  <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/produtos/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Novo Atendimento</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Nome</label>
                                  <input type="text" class="form-control" name="Nome">
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
                                  <label for="">Atendido por</label>
                                  <input type="text" class="form-control" name="Atendidopor">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Status</label>
                                  <input type="text" class="form-control" name="Status">
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
              <form action="/produtos/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Editar Atendimento</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Nome</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Nome" name="Nome">
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
                                  <input type="text" class="form-control" id="modal-editar-produto-Atendidopor" name="Atendidopor">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Status</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Status" name="Status">
                              </div>
                          </div>

                          <input type="hidden" id="modal-editar-produto-ProdutoId" name="ProdutoId">
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
                      <h1 class="m-0">Atendimentos</h1>
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
                                  <i class="fas fa-plus-circle"></i> Novo Atendimento
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
                              Produto cadastrado com sucesso!
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
                              Produto excluido com sucesso!
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
                              Produto editado com sucesso!
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
                                          <th>NOME</th>
                                          <th>DATA</th>
                                          <th>TIPO</th>
                                          <th>DESCRIÇÃO</th>
                                          <th>ATENDIDO POR</th>
                                          <th>STATUS</th>
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($produtos as $prod) : ?>
                                          <tr>
                                              <td><?= $prod['ProdutoId'] ?></td>
                                              <td><?= $prod['Nome'] ?></td>
                                              <td><?= $prod['Data'] ?></td>
                                              <td><?= $prod['Tipo'] ?></td>
                                              <td><?= $prod['Descricao'] ?></td>
                                              <td><?= $prod['Atendidopor'] ?></td>
                                              <td><?= $prod['Status'] ?></td>
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $prod['ProdutoId'] ?>', '<?= $prod['Nome'] ?>', '<?= $prod['Data'] ?>', '<?= $prod['Tipo'] ?>', '<?= $prod['Descricao'] ?>', '<?= $prod['Atendidopor'] ?>', '<?= $prod['Status'] ?>')"><i class="fas fa-edit"></i></button>
                                                  <a href="/produtos/excluir/<?= $prod['ProdutoId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(ProdutoId, Nome, Data, Tipo, Descricao, Atendidopor, Status) {
          document.getElementById('modal-editar-produto-ProdutoId').value = ProdutoId;
          document.getElementById('modal-editar-produto-Nome').value = Nome;
          document.getElementById('modal-editar-produto-Data').value = Data;
          document.getElementById('modal-editar-produto-Tipo').value = Tipo;
           document.getElementById('modal-editar-produto-Descricao').value = Descricao;
          document.getElementById('modal-editar-produto-Atendidopor').value = Atendidopor;
          document.getElementById('modal-editar-produto-Status').value = Status;

          $('#modal-editar-produto').modal('show');
      }
  </script>