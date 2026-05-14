
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Ouvidoriagab/cadastrar" method="post">
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
                                  <label for="">Tipo de manifestação</label>
                                 <select name="tipo_manifestacao" class="form-control" required>
            <option value="">Selecione</option>
            <option value="reclamacao">Reclamação</option>
            <option value="denuncia">Denúncia</option>
            <option value="solicitacao">Solicitação</option>
            <option value="outros">Outros</option>
        </select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                 <select name="escola_id" required>
    <option value="">Selecione</option>
    <?php foreach ($escolas as $escola): ?>
        <option value="<?= $escola['EscolaId'] ?>">
            <?= $escola['Nome'] ?>
        </option>
    <?php endforeach; ?>
</select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do recebimento</label>
                                  <input type="date" class="form-control" name="data_recebimento">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Responsável</label>
                                  <input type="text" class="form-control" name="responsavel">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do envio</label>
                                  <input type="date" class="form-control" name="data_devolutiva">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Prazo</label>
                                  <input type="text" class="form-control" name="prazo">
                              </div>
                          </div>
                           <div class="col-3">
                              <div class="form-group">
                                  <label for="">Nº do Processo</label>
                                  <input type="text" class="form-control" name="numero_Ouvidoria">
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
              <form action="/Ouvidoriagab/editar" method="post">
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
                                  <label for="">Tipo de manifestação</label>
                                        <select name="tipo_manifestacao"  id="modal-editar-produto-Tipodemanifestacao" class="form-control" required>
            <option value="">Selecione</option>
            <option value="reclamacao">Reclamação</option>
            <option value="denuncia">Denúncia</option>
            <option value="solicitacao">Solicitação</option>
            <option value="outros">Outros</option>
        </select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Setor / Escola</label>
                                   <select name="escola_id" required id="modal-editar-produto-Setorescola">
    <option value="">Selecione</option>
    <?php foreach ($escolas as $escola): ?>
        <option value="<?= $escola['EscolaId'] ?>">
            <?= $escola['Nome'] ?>
        </option>
    <?php endforeach; ?>
</select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do recebimento</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Datarecebimento" name="data_recebimento">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="">Responsável</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Responsavel" name="responsavel">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data do envio</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Datadoenvio" name="data_devolutiva">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Prazo</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-Prazo" name="prazo">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Nº Processo</label>
                                  <input type="text" class="form-control" id="modal-editar-produto-NumeroProcesso" name="numero_Ouvidoria">
                              </div>
                          </div>
                        <input type="hidden" id="modal-editar-produto-OuvidoriaId" name="ouvidoria_id">
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
                                          <th>Nº Processo</th>
                                          <th>TIPO DE MANISFESTAÇÃO</th>
                                          <th>SETOR / ESCOLA</th>
                                          <th>DATA DO RECEBIMENTO</th>
                                          <th>RESPONSÁVEL</th>
                                          <th>DATA DE DEVOLUTIVA</th>
                                          <th>PRAZO</th>
                                          <th>AÇÕES</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($ouvidoria as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['ouvidoria_id'] ?></td>
                                              <td><?= $agend['tipo_manifestacao'] ?></td>
                                              <td><?= $agend['numero_Ouvidoria'] ?></td>
                                              <td><?= $agend['Nome'] ?></td>
                                              <td><?= $agend['data_recebimento'] ?></td>
                                              <td><?= $agend['responsavel'] ?></td>
                                              <td><?= $agend['data_devolutiva'] ?></td>
                                              <td><?= $agend['prazo'] ?></td>
                                             
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $agend['ouvidoria_id'] ?>', '<?= $agend['tipo_manifestacao'] ?>', '<?= $agend['escola_id'] ?>', '<?= $agend['data_recebimento'] ?>', '<?= $agend['responsavel'] ?>', '<?= $agend['data_devolutiva'] ?>', '<?= $agend['prazo'] ?>', '<?= $agend['numero_Ouvidoria'] ?>')"><i class="fas fa-edit"></i></button>
                                                  <a href="/Ouvidoriagab/excluir/<?= $agend['ouvidoria_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
      function prepararDados(ouvidoria_id , tipo_manifestacao, escola_id , data_recebimento, responsavel, data_envio,prazo,numero_Processo) {
          document.getElementById('modal-editar-produto-OuvidoriaId').value = ouvidoria_id;
          document.getElementById('modal-editar-produto-Tipodemanifestacao').value = tipo_manifestacao;
          document.getElementById('modal-editar-produto-Setorescola').value = escola_id;
          document.getElementById('modal-editar-produto-Datarecebimento').value = data_recebimento;
          document.getElementById('modal-editar-produto-Responsavel').value = responsavel;
          document.getElementById('modal-editar-produto-Datadoenvio').value = data_envio;
          document.getElementById('modal-editar-produto-Prazo').value = prazo;
          document.getElementById('modal-editar-produto-NumeroProcesso').value = numero_Processo;
         

          $('#modal-editar-produto').modal('show');
      }
  </script>

  

</html>
