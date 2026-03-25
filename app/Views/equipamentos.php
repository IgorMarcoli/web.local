
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Maquinas/cadastrar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Nova Equipamento</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                            <div class="col-3">
                              <div class="form-group">
                                  <label for="">MODELO</label>
                                  <input type="text" class="form-control" name="Modelo">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">MARCA</label>
                                  <input type="text" class="form-control" name="Marca">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">QTDE</label>
                                  <input type="text" class="form-control" name="Qtde">
                              </div>
                          </div> 
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">EST DE CONSERVAÇÃO</label>
                                  <input type="text" class="form-control" name="Estadodeconservacao">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">LOCALIZAÇÃO</label>
                                  <input type="text" class="form-control" name="Localizacao">
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
              <form action="/Maquinas/editar" method="post">
                  <div class="modal-header">
                      <h4 class="modal-title">Editar Equipamentos</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">MODELO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Modelo" name="Modelo">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">MARCA</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Marca" name="Marca">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">QTDE</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Qtde" name="Qtde">
                              </div>
                          </div> 
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">EST DE CONSERVAÇÃO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Estadodeconservacao" name="Estadodeconservacao">
                              </div>
                          </div>   
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">LOCALIZAÇÃO</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Localizacao" name="Localizacao">
                              </div>
                          </div>                            
                        <input type="hidden" id="modal-editar-produto-MaquinaId" name="MaquinaId">
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
                      <h1 class="m-0">Equipamentos</h1>
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
                                  <i class="fas fa-plus-circle"></i> Novo Equipamento
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
                                          <th>MODELO</th>
                                          <th>MARCA</th>
                                          <th>QTDE</th> 
                                          <th>ESTADO DE CONSERVAÇÃO</th>
                                          <th>LOCALIZAÇÃO</th>                                                                                    
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($maquinas as $mac) : ?>
                                          <tr>
                                              <td><?= $mac['MaquinaId'] ?></td>                                              
                                              <td><?= $mac['Modelo'] ?></td>
                                              <td><?= $mac['Marca'] ?></td>
                                              <td><?= $mac['Qtde'] ?></td>
                                              <td><?= $mac['Estadodeconservacao'] ?></td>
                                              <td><?= $mac['Localizacao'] ?></td>                                            
                                                                                          
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $mac['MaquinaId'] ?>', '<?= $mac['Modelo'] ?>', '<?= $mac['Marca'] ?>', '<?= $mac['Qtde'] ?>', '<?= $mac['Estadodeconservacao'] ?>', '<?= $mac['Localizacao'] ?>', )"><i class="fas fa-edit"></i></button>
                                                  <a href="/Maquinas/excluir/<?= $mac['MaquinaId'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(VisitaId, Data, Tipo, Descricao) {
          document.getElementById('modal-editar-produto-MaquinaId).value = MaquinasId;
          document.getElementById('modal-editar-produto-Modelo').value = Modelo;
          document.getElementById('modal-editar-produto-Marca').value = Marca;
          document.getElementById('modal-editar-produto-Qtde').value = Qtde;
          document.getElementById('modal-editar-produto-Estadodeconservacao').value = Estadodeconservacao;
          document.getElementById('modal-editar-produto-Localizacao').value = Localizacao;
          
                   

          $('#modal-editar-produto').modal('show');
      }
  </script>

  

</html>
