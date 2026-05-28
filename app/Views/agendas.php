
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
                              <label for="">Local</label>
                              <input type="text" class="form-control" name="Nomelocal">
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label for="">Data</label>
                                  <input type="date" class="form-control" name="Data">
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

                               <label class="ml-3">Pesquisar</label>
                            <input type="text" placeholder="Escola" id="pesquisarAgenda">
                          </div>

                          <div>
                            <a href="/agenda/agenda" class="btn btn-infor">Todos</a>
                            <a href="/agenda/agenda?status=concluido" class="btn btn-success">Concluido</a>
                            <a href="/agenda/agenda?status=pendente" class="btn btn-warning">pendente</a>
                            <a href="/agenda/agenda?status=Em atendimento" class="btn btn-primary">Em Atendimento</a>
                            <a href="/agenda/agenda?status=suspenso" class="btn btn-secondary">Suspenso</a>
                          </div>
                          
                      </div>
                      <button type="button" class="btn btn-success" onclick="exportarExcel()">
                
                                  <i class="fas fa-file-excel"></i> Exportar Dados
                              </button>
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
                                          <th>Status</th>
                                          <th>AÇÕES</th>
                                          
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach ($agendas as $agend) : ?>
                                          <tr>
                                              <td><?= $agend['AgendaId'] ?></td>
                                              <td><?= $agend['Nomelocal'] ?></td>
                                              <td><?= $agend['Data'] ?></td>
                                              <td><?= $agend['Tipo'] ?></td>
                                              <td><?= $agend['Descricao'] ?></td>
                                              <td><?= $agend['Solicitadopor'] ?></td>
                                              <td><?= $agend['Atendidopor'] ?></td>
                                              <td><select class="form-control form-control-sm"
                                            onchange="alterarStatus(this.value, <?= $agend['AgendaId'] ?>)">
                                           <option value="pendente" <?= $agend['status'] == 'pendente' ? 'selected' : '' ?>>
                                            pendente
                                        </option>
                                        <option value="concluido" <?= $agend['status'] == 'concluido' ? 'selected' : '' ?>>
                                            concluido
                                        </option>
                                        <option value="Em Atendimento" <?= $agend['status'] == 'Em Atendimento' ? 'selected' : '' ?>>
                                            Em atendimento
                                        </option>
                                        <option value="Suspenso" <?= $agend['status'] == 'Suspenso' ? 'selected' : '' ?>>
                                            Suspenso
                                        </option>
                                        </select>
                                        </td>
    
                                              <td>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-editar-produto" onclick="prepararDados('<?= $agend['AgendaId'] ?>', '<?= $agend['Nomelocal'] ?>', '<?= $agend['Data'] ?>', '<?= $agend['Tipo'] ?>', '<?= $agend['Descricao'] ?>', '<?= $agend['Solicitadopor'] ?>', '<?= $agend['Atendidopor'] ?>', '<?= $agend['status'] ?>')"><i class="fas fa-edit"></i></button>
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

  <script src=https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js></script>
  <script>
     function prepararDados(AgendaId, Nomelocal, Data, Tipo, Descricao, Solicitadopor, Atendidopor, status) {

    document.getElementById('modal-editar-produto-AgendaId').value = AgendaId;
    document.getElementById('modal-editar-produto-Nomelocal').value = Nomelocal;
    document.getElementById('modal-editar-produto-Data').value = Data;
    document.getElementById('modal-editar-produto-Tipo').value = Tipo;
    document.getElementById('modal-editar-produto-Descricao').value = Descricao;
    document.getElementById('modal-editar-produto-Solicitadopor').value = Solicitadopor;
    document.getElementById('modal-editar-produto-Atendidopor').value = Atendidopor;

    $('#modal-editar-produto').modal('show');
}

      function alterarStatus(novoStatus, id){
        fetch('/agenda/agenda/alterarStatus', {
            method:'POST',
            headers:{
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body:'AgendaId=' + id + '&status='+ novoStatus
            
        })
        
        .then(response => response.text())
        .then(data => {
            console.log('Status atualizado');
            
      });
                                        
      }

     function exportarExcel() {
    // Pega a tabela da página
    const tabela = document.querySelector('.table');

    // Converte a tabela HTML para uma planilha
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(tabela);

    // Remove a coluna "AÇÕES" (última coluna) — opcional
    // Se quiser manter, basta apagar as linhas abaixo
    const range = XLSX.utils.decode_range(ws['!ref']);
    for (let row = range.s.r; row <= range.e.r; row++) {
        const cellAddress = XLSX.utils.encode_cell({ r: row, c: range.e.c });
        delete ws[cellAddress];
    }
    range.e.c -= 1;
    ws['!ref'] = XLSX.utils.encode_range(range);

    // Define a largura das colunas
    ws['!cols'] = [
        { wch: 6 },  // CÓD
        { wch: 20 }, // NOME/LOCAL
        { wch: 12 }, // DATA
        { wch: 15 }, // TIPO
        { wch: 30 }, // DESCRIÇÃO
        { wch: 18 }, // SOLICITADO POR
        { wch: 18 }, // ATENDIDO POR
        { wch: 14 }, // STATUS
    ];

    XLSX.utils.book_append_sheet(wb, ws, 'Agendamentos');

    // Gera o nome do arquivo com a data atual
    const hoje = new Date().toLocaleDateString('pt-BR').replace(/\//g, '-');
    XLSX.writeFile(wb, `agendamentos_${hoje}.xlsx`);
}

  document.getElementById("pesquisarAgenda").addEventListener("keyup", function() {
        let filtro = this.value.toLowerCase();
        let linhas = document.querySelectorAll("table tbody tr");

        linhas.forEach(function(linha) {
            let nome = linha.children[1].textContent.toLowerCase();
            linha.style.display = nome.includes(filtro) ? "" : "none";
        });
    });
  </script>


</html>
