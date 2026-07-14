
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
<div class="d-flex flex-wrap align-items-center mt-2">

    <!-- Filtro de mês/ano -->
    <form id="form-filtro-mes" method="get" action="/agenda/agenda" class="form-inline mr-3">
        <label class="mr-2 mb-0">Mês:</label>
        <select name="mes" id="filtro-mes" class="form-control form-control-sm mr-2">
            <?php
            $meses = [
                1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril',
                5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto',
                9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro'
            ];
            foreach ($meses as $num => $nome) :
            ?>
                <option value="<?= $num ?>" <?= ($mesAtual == $num) ? 'selected' : '' ?>>
                    <?= $nome ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="ano" id="filtro-ano" class="form-control form-control-sm mr-2">
            <?php for ($a = date('Y'); $a >= date('Y') - 3; $a--) : ?>
                <option value="<?= $a ?>" <?= ($anoAtual == $a) ? 'selected' : '' ?>>
                    <?= $a ?>
                </option>
            <?php endfor; ?>
        </select>

        <!-- preserva o status atual ao trocar o mês/ano -->
        <input type="hidden" name="status" id="filtro-status-hidden" value="<?= esc($statusAtual ?? '') ?>">

        <button type="submit" class="btn btn-sm btn-outline-primary">Filtrar</button>
        <a href="<?= base_url('agenda/agenda') ?>" class="btn btn-sm btn-outline-secondary ml-2">Limpar filtros</a>
    </form>
<a href="/agenda/agenda?periodo=todos<?= $statusAtual ? '&status='.urlencode($statusAtual) : '' ?>"
   class="btn btn-sm btn-outline-dark mr-2 <?= ($periodoAtual === 'todos') ? 'active' : '' ?>">
    Ver todos os períodos
</a>
    <!-- Filtros de status -->
    <div id="filtros-status">
        <a href="/agenda/agenda" data-status="" class="btn btn-infor btn-sm filtro-status-link <?= empty($statusAtual) ? 'active' : '' ?>">Todos</a>
        <a href="/agenda/agenda?status=concluido" data-status="concluido" class="btn btn-success btn-sm filtro-status-link <?= $statusAtual == 'concluido' ? 'active' : '' ?>">Concluido</a>
        <a href="/agenda/agenda?status=pendente" data-status="pendente" class="btn btn-warning btn-sm filtro-status-link <?= $statusAtual == 'pendente' ? 'active' : '' ?>">Pendente</a>
        <a href="/agenda/agenda?status=Em atendimento" data-status="Em atendimento" class="btn btn-primary btn-sm filtro-status-link <?= $statusAtual == 'Em atendimento' ? 'active' : '' ?>">Em Atendimento</a>
        <a href="/agenda/agenda?status=suspenso" data-status="suspenso" class="btn btn-secondary btn-sm filtro-status-link <?= $statusAtual == 'suspenso' ? 'active' : '' ?>">Suspenso</a>
    </div>
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

    // monta a URL combinando mes, ano e status
document.querySelectorAll('.filtro-status-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const status = this.getAttribute('data-status');
        const mes = document.getElementById('filtro-mes').value;
        const ano = document.getElementById('filtro-ano').value;

        let url = '/agenda/agenda?mes=' + mes + '&ano=' + ano;
        if (status) {
            url += '&status=' + encodeURIComponent(status);
        }
        window.location.href = url;
    });
});
  </script>


</html>
