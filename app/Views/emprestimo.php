<div class="modal fade" id="modal-novo-emprestimo">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="/Emprestimo/salvar" method="post">

<div class="modal-header">
<h4 class="modal-title">Novo Empréstimo</h4>
<button type="button" class="close" data-dismiss="modal">
<span>&times;</span>
</button>
</div>

<div class="modal-body">

<div class="row">

<div class="col-4">
<div class="form-group">
<label>Servidor</label>
<select name="servidor_id" class="form-control" required>

<option value="">Selecione</option>

<?php foreach($servidores as $s): ?>
<option value="<?= $s['servidorID'] ?>">
<?= htmlspecialchars($s['nome']) ?>
</option>
<?php endforeach; ?>

</select>
</div>
</div>


<div class="col-4">
<div class="form-group">
<label>Item</label>
<select name="item_id" class="form-control">

<option value="">Nenhum</option>

<?php foreach($itens as $i): ?>
<option value="<?= $i['id'] ?>">
<?= $i['tipo'] ?> <?= $i['numero'] ?>
</option>
<?php endforeach; ?>

</select>
</div>
</div>


<div class="col-4">
<div class="form-group">
<label>Kit</label>
<select name="kit_id" class="form-control">

<option value="">Nenhum</option>

<?php foreach($kits as $k): ?>
<option value="<?= $k['id'] ?>">
Kit <?= $k['numero'] ?>
</option>
<?php endforeach; ?>

</select>
</div>
</div>

</div>
</div>


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">
Cancelar
</button>

<button type="submit" class="btn btn-primary">
<i class="fas fa-save"></i> Registrar
</button>
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
                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-novo-Emprestimo">
<i class="fas fa-plus-circle"></i> Novo Empréstimo
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

            <th>ID</th>
            <th>Servidor</th>
            <th>Item</th>
            <th>Kit</th>
            <th>Data</th>
            <th>Ações</th>

        </tr>
    </thead>

    <tbody>

        <?php foreach($emprestimos as $e): ?>
        <tr>
        <td><?= $e['id'] ?></td>
        <td><?= $e['nome'] ?></td>
        <td><?= $e['tipo'] ?? '-' ?><?= $e['numero'] ?? '' ?></td>
        <td><?= $e['kit_numero'] ?? '-' ?></td>
        <td><?= $e['data_emprestimo'] ?></td>
        <td><?php if($e['data_devolucao'] == null): ?></td>
        <a href="/Emprestimo/devolver/<?= $e['id'] ?>" class="btn btn-success">
        <i class="fas fa-undo"></i>
        </a>

<?php else: ?>

<span class="badge badge-secondary">Devolvido</span>

<?php endif; ?>

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
      function prepararDados(TermoId, Processosei, Supervisor, Setor, Escola, Tipo, Data) {
          document.getElementById('modal-editar-produto-TermoId').value = TermoId;
          document.getElementById('modal-editar-produto-Processosei').value = Processosei;
          document.getElementById('modal-editar-produto-Supervisor').value = Supervisor;
          document.getElementById('modal-editar-produto-Setor').value = Setor;
          document.getElementById('modal-editar-produto-Escola').value = Escola;
          document.getElementById('modal-editar-produto-Tipo').value = Tipo;
          document.getElementById('modal-editar-produto-Data').value = Data;
         
         

          $('#modal-editar-produto').modal('show');
      }
  </script>
</html>
