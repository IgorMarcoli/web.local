
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/JUridico/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">NOVA APURAÇÃO INICIAL</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">FATO</label>
                                  <input type="text" class="form-control" name="fato">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">DILIGENCIA</label>
                                  <input type="text" class="form-control" name="diligencia">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">DATA INICIO</label>
                                  <input type="text" class="form-control" name="datainicio">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">RDATA TERMINO</label>
                                  <input type="text" class="form-control" name="datatermino">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">COMISSÃO</label>
                                  <input type="text" class="form-control" name="comissao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">AP</label>
                                  <input type="text" class="form-control" name="ap">
                              </div>
                          </div>
                           <div class="col-3">
                              <div class="form-group">
                                  <label for="">DATA</label>
                                  <input type="text" class="form-control" name="data">
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
              <form action="/Juridico/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">EDITAR APURAÇÃO INICIAL</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">FATO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-fato" name="fato">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">DILIGENCIA</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-diligencia" name="diligencia">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">DATA INICIO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-datainicio" name="datainicio">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">DATA TERMINO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-datatermino" name="datatermino">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">COMISSÃO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-comissao" name="comissao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">AP</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-ap" name="ap">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data </label>
                                  <input type="text" class="form-control" id="modal-editar-produto-data" name="data">
                              </div>
                          </div>
                        <input type="hidden" id="modal-editar-produto-juridicoId" name="juridicoId">
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
                      <h1 class="m-0">Apuração inicial</h1>
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
                                  <i class="fas fa-plus-circle"></i> Nova Apuração inicial
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
                                          <th>FATO</th>
                                          <th>DILIGENCIA</th>
                                          <th>DATA INICIO</th>
                                          <th>DATA TERMINO</th>
                                          <th>COMISSÃO</th>
                                          <th>AP</th>
                                          <th>DATA</th>
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($juridicos as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['juridicoId'] ?></td>
                                              <td><?= $agend['fato'] ?></td>
                                              <td><?= $agend['diligencia'] ?></td>
                                              <td><?= $agend['datainicio'] ?></td>
                                              <td><?= $agend['datatermino'] ?></td>
                                              <td><?= $agend['comissao'] ?></td>
                                              <td><?= $agend['ap'] ?></td>
                                              <td><?= $agend['data'] ?></td>
                                             
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $agend['juridicoId'] ?>', '<?= $agend['fato'] ?>', '<?= $agend['diligencia'] ?>', '<?= $agend['datainicio'] ?>', '<?= $agend['datatermino'] ?>', '<?= $agend['comissao'] ?>', '<?= $agend['ap'] ?>', '<?= $agend['data'] ?>')"><i class="fas fa-edit"></i></button>
                                                  <a href="/Juridico/excluir/<?= $agend['juridicoId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(juridicoId, fato, diligencia, datainicio, datatermino, comissao, ap, data) {
          document.getElementById('modal-editar-produto-juridicoId').value = juridicoId;
          document.getElementById('modal-editar-produto-fato').value = fato;
          document.getElementById('modal-editar-produto-diligencia').value = diligencia;
          document.getElementById('modal-editar-produto-datainicio').value = datainicio;
          document.getElementById('modal-editar-produto-datatermino').value = datatermino;
          document.getElementById('modal-editar-produto-comissao').value = comissao;
          document.getElementById('modal-editar-produto-ap').value = ap;
          document.getElementById('modal-editar-produto-data').value = data;
         

          $('#modal-editar-produto').modal('show');
      }
  </script>

  

</html>
