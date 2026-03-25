
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Visita/cadastrar" method="post" id="formVisita">
                  <div class="modal-header">
                      <h4 class="modal-title">Nova Visita técnica</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                            <div class="col-3">
                              <div class="form-group">
                                  <label for="">Escola</label>
                                  <select name="EscolaId" class="form-control" required>
    <option value="">Selecione a escola</option>

    <?php foreach($escolas as $e): ?>
        <option value="<?= $e['EscolaId'] ?>">
            <?= htmlspecialchars($e['Nome']) ?>
        </option>
    <?php endforeach; ?>
</select>

                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">DESCRIÇÃO</label>
                                  <input type="text" class="form-control" name="Tipo">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">SOLICITADO POR</label>
                                  <input type="text" class="form-control" name="Descricao">
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
              <form action="/Visita/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Editar Visita técnica</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">LOCAL</label>
                                  <select name="EscolaId" id="modal-editar-produto-EscolaId" class="form-control">
    <?php foreach($escolas as $e): ?>
        <option value="<?= $e['EscolaId'] ?>">
            <?= htmlspecialchars($e['Nome']) ?>
        </option>
    <?php endforeach; ?>
</select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">DESCRIÇÃO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Tipo" name="Tipo">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">SOLICITADO POR</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Descricao" name="Descricao">
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
                      <h1 class="m-0">Visita técnica</h1>
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
                                  <i class="fas fa-plus-circle"></i> Nova Visita técnica
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
                              Visita técnica cadastrado com sucesso!
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
                              Visita técnica excluido com sucesso!
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
                              Visita técnica editado com sucesso!
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
                                          <th>ESCOLA</th>
                                          <th>ENDEREÇO</th>
                                          <th>DESCRIÇÃO</th>
                                          <th>SOLICITADO POR</th>                                                                                   
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($visitas as $visited) : ?>
                                          <tr>
                                              <td><?= $visited['VisitaId'] ?></td>                                              
                                              <td><?= $visited['Nome'] ?></td>
                                              <td><?= $visited['Endereco'] ?></td>
                                              <td><?= $visited['Tipo'] ?></td>
                                              <td><?= $visited['Descricao'] ?></td>
                                             
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto"onclick="prepararDados(
                                                        '<?= $visited['VisitaId'] ?>',
                                                        '<?= $visited['EscolaId'] ?>',
                                                        '<?= $visited['Tipo'] ?>',
                                                        '<?= $visited['Descricao'] ?>'
                                                        )"><i class="fas fa-edit"></i></button>
                                                  <a href="/Visita/excluir/<?= $visited['VisitaId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
     function prepararDados(VisitaId, EscolaId, Tipo, Descricao) {
    document.getElementById('modal-editar-produto-VisitaId').value = VisitaId;
    document.getElementById('modal-editar-produto-EscolaId').value = EscolaId;
    document.getElementById('modal-editar-produto-Tipo').value = Tipo;
    document.getElementById('modal-editar-produto-Descricao').value = Descricao;

    $('#modal-editar-produto').modal('show');
}
  </script>
</html>