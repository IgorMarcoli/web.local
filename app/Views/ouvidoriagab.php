
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Agenda/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Nova Ouvidoria</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Tipo de manufestação</label>
                                  <input type="text" class="form-control" name="Tipodemanufestacao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Setor / Escola</label>
                                  <input type="text" class="form-control" name="Setorescola">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do recebimento</label>
                                  <input type="text" class="form-control" name="Datarecebimento">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Responsável</label>
                                  <input type="text" class="form-control" name="Responsavel">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do envio</label>
                                  <input type="text" class="form-control" name="Datadoenvio">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Prazo</label>
                                  <input type="text" class="form-control" name="Prazo">
                              </div>
                          </div>
                           <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data da volutiva</label>
                                  <input type="text" class="form-control" name="Datadevolutiva">
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
                      <h4 class="modal-title">Editar Ouvidoria</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Tipo de manufestação</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Tipodemanufestacao" name="Tipodemanufestacao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Setor / Escola</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Data" name="Setorescola">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do recebimento</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Datarecebimento" name="Datarecebimento">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Responsável</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Responsavel" name="Responsavel">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do envio</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Datadoenvio" name="Datadoenvio">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Prazo</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Prazo" name="Prazo">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data da devolutiva</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Datadevolutiva" name="Datadevolutiva">
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
                      <h1 class="m-0">Ouvidoria</h1>
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
                                  <i class="fas fa-plus-circle"></i> Nova Ouvidoria
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
                                          <th>TIPO DE MANISFESTAÇÃO</th>
                                          <th>SETOR / ESCOLA</th>
                                          <th>DATA DO RECEBIMENTO</th>
                                          <th>RESPONSÁVEL</th>
                                          <th>DATA DO ENVIO</th>
                                          <th>PRAZO</th>
                                          <th>DATADA DEVOLUTIVA</th>
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($ouvidoriagabs as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['OuvidoriaId'] ?></td>
                                              <td><?= $agend['Tipodemanufestacao'] ?></td>
                                              <td><?= $agend['Setorescola'] ?></td>
                                              <td><?= $agend['Datarecebimento'] ?></td>
                                              <td><?= $agend['Responsavel'] ?></td>
                                              <td><?= $agend['Datadoenvio'] ?></td>
                                              <td><?= $agend['Prazo'] ?></td>
                                              <td><?= $agend['Datadevolutiva'] ?></td>
                                             
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $agend['OuvidoriaId'] ?>', '<?= $agend['Tipodemanufestacao'] ?>', '<?= $agend['Setorescola'] ?>', '<?= $agend['Datarecebimento'] ?>', '<?= $agend['Responsavel'] ?>', '<?= $agend['Datadoenvio'] ?>', '<?= $agend['Prazo'] ?>', '<?= $agend['Datadevolutiva'] ?>')"><i class="fas fa-edit"></i></button>
                                                  <a href="/Ouvidoriagab/excluir/<?= $agend['OuvidoriaId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(OuvidoriaId, Nome, Data, Tipo, Descricao, Atendidopor) {
          document.getElementById('modal-editar-produto-OuvidoriaId').value = OuvidoriaId;
          document.getElementById('modal-editar-produto-Tipodemanufestacao').value = Tipodemanufestacao;
          document.getElementById('modal-editar-produto-Setorescola').value = Setorescola;
          document.getElementById('modal-editar-produto-Datarecebimento').value = Datarecebimento;
          document.getElementById('modal-editar-produto-Responsavel').value = Responsavel;
          document.getElementById('modal-editar-produto-Datadoenvio').value = Datadoenvio;
          document.getElementById('modal-editar-produto-Prazo').value = Prazo;
          document.getElementById('modal-editar-produto-Datadevolutiva').value = Datadevolutiva;
         

          $('#modal-editar-produto').modal('show');
      }
  </script>

  

</html>
