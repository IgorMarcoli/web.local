  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Modal Nova Ouvidoria -->
  <div class="modal fade" id="modal-novo-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Ouvidoriagab/cadastrar" method="post">
                  <?= csrf_field() ?>
                  <div class="modal-header bg-primary text-white">
                      <h4 class="modal-title"><i class="fas fa-plus-circle mr-1"></i> Nova Ouvidoria</h4>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Nº de Protocolo</label>
                              <input type="text" class="form-control" name="numero_protocolo" placeholder="Ex: OUV-2026-001 (ou deixe vazio para gerar)">
                              <small class="text-muted">Se vazio, o sistema gera um protocolo automaticamente.</small>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Tipo de manifestação <span class="text-danger">*</span></label>
                              <select name="tipo_manifestacao" class="form-control" required>
                                  <option value="">Selecione...</option>
                                  <option value="reclamacao">Reclamação</option>
                                  <option value="denuncia">Denúncia</option>
                                  <option value="solicitacao">Solicitação</option>
                                  <option value="elogio">Elogio</option>
                                  <option value="sugestao">Sugestão</option>
                                  <option value="outros">Outros</option>
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Setor / Escola</label>
                              <select name="escola_id" class="form-control">
                                  <option value="">Selecione...</option>
                                  <?php foreach ($escolas as $escola): ?>
                                      <option value="<?= esc($escola['id'] ?? '') ?>">
                                          <?= esc($escola['nome'] ?? '-') ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Responsável pela resposta</label>
                              <input type="text" class="form-control" name="responsavel_resposta" placeholder="Nome de quem responderá...">
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Data de criação <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" name="data_criacao" value="<?= date('Y-m-d') ?>" required>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Data da resposta</label>
                              <input type="date" class="form-control" name="data_resposta">
                          </div>
                          <div class="col-12 mb-3">
                              <label class="font-weight-bold">Envolvidos <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" name="envolvidos" placeholder="Nomes das partes envolvidas ou interessados..." required>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Cadastrar</button>
                  </div>
              </form>
          </div>
      </div>
  </div>

  <!-- Modal Editar Ouvidoria -->
  <div class="modal fade" id="modal-editar-produto">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <form action="/Ouvidoriagab/editar" method="post">
                  <?= csrf_field() ?>
                  <input type="hidden" id="modal-editar-ouvidoriaid" name="ouvidoria_id">
                  <div class="modal-header bg-warning">
                      <h4 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Editar Ouvidoria</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Nº de Protocolo</label>
                              <input type="text" class="form-control" id="modal-editar-protocolo" name="numero_protocolo" required>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Tipo de manifestação <span class="text-danger">*</span></label>
                              <select name="tipo_manifestacao" id="modal-editar-tipodemanifestacao" class="form-control" required>
                                  <option value="">Selecione...</option>
                                  <option value="reclamacao">Reclamação</option>
                                  <option value="denuncia">Denúncia</option>
                                  <option value="solicitacao">Solicitação</option>
                                  <option value="elogio">Elogio</option>
                                  <option value="sugestao">Sugestão</option>
                                  <option value="outros">Outros</option>
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Setor / Escola</label>
                              <select name="escola_id" id="modal-editar-setorescola" class="form-control">
                                  <option value="">Selecione...</option>
                                  <?php foreach ($escolas as $escola): ?>
                                      <option value="<?= esc($escola['id'] ?? '') ?>">
                                          <?= esc($escola['nome'] ?? '-') ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Responsável pela resposta</label>
                              <input type="text" class="form-control" id="modal-editar-responsavelresposta" name="responsavel_resposta" placeholder="Nome do responsável...">
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Data de criação <span class="text-danger">*</span></label>
                              <input type="date" class="form-control" id="modal-editar-datacriacao" name="data_criacao" required>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label class="font-weight-bold">Data da resposta</label>
                              <input type="date" class="form-control" id="modal-editar-dataresposta" name="data_resposta">
                          </div>
                          <div class="col-12 mb-3">
                              <label class="font-weight-bold">Envolvidos <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="modal-editar-envolvidos" name="envolvidos" required>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Atualizar</button>
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
                      <h1 class="m-0 font-weight-bold text-dark"><i class="fas fa-headset mr-2 text-primary"></i> Ouvidoria</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="/">Home</a></li>
                          <li class="breadcrumb-item active">Ouvidoria</li>
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
          <div class="container-fluid">
              <?php
              $alert = isset($_GET['alert']) ? $_GET['alert'] : '';
              if ($alert === 'successCreate') {
              ?>
                  <div class="row">
                      <div class="col-12">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                              Ouvidoria cadastrada com sucesso!
                          </div>
                      </div>
                  </div>
              <?php } else if ($alert === 'successDelete') { ?>
                  <div class="row">
                      <div class="col-12">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                              Ouvidoria excluída com sucesso!
                          </div>
                      </div>
                  </div>
              <?php } else if ($alert === 'successEdit') { ?>
                  <div class="row">
                      <div class="col-12">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                              Ouvidoria editada com sucesso!
                          </div>
                      </div>
                  </div>
              <?php } ?>
              <div class="row mb-3">
                  <div class="col-12 d-flex flex-wrap align-items-center">
                      <button type="button" class="btn btn-primary font-weight-bold shadow-sm mr-2 mb-2" data-toggle="modal" data-target="#modal-novo-produto">
                          <i class="fas fa-plus-circle mr-1"></i> Nova Ouvidoria
                      </button>
                      <button type="button" class="btn btn-success font-weight-bold shadow-sm mb-2" onclick="exportarExcel()">
                          <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                      </button>
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                      <div class="card card-outline card-secondary shadow-sm">
                          <div class="card-header bg-light d-flex justify-content-between align-items-center">
                              <h3 class="card-title font-weight-bold text-dark mb-0">
                                  <i class="fas fa-list mr-1"></i> Registros de Ouvidoria
                              </h3>
                              <div class="d-flex align-items-center">
                                  <span class="badge badge-primary badge-pill px-3 py-1 mr-2">
                                      <?= count($ouvidoria) ?> registro(s)
                                  </span>
                                  <button type="button" class="btn btn-success btn-sm font-weight-bold shadow-sm" onclick="exportarExcel()" title="Baixar planilha Excel">
                                      <i class="fas fa-file-excel mr-1"></i> Planilha
                                  </button>
                              </div>
                          </div>
                          <div class="card-body p-0 table-responsive">
                              <table id="tabela-ouvidoria" class="table table-striped table-hover mb-0 text-nowrap">
                                  <thead class="thead-light">
                                      <tr>
                                          <th>Protocolo</th>
                                          <th>Tipo</th>
                                          <th>Setor / Escola</th>
                                          <th>Envolvidos</th>
                                          <th>Data Criação</th>
                                          <th>Data Resposta</th>
                                          <th>Responsável Resposta</th>
                                          <th class="text-center" style="width: 110px;">Ações</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php if (!empty($ouvidoria)): ?>
                                          <?php foreach ($ouvidoria as $agend) : ?>
                                              <?php
                                                  $tipo = mb_strtolower((string) ($agend['tipo_manifestacao'] ?? ''));
                                                  $tipoBadge = 'badge-secondary';
                                                  if ($tipo === 'reclamacao') $tipoBadge = 'badge-warning';
                                                  elseif ($tipo === 'denuncia') $tipoBadge = 'badge-danger';
                                                  elseif ($tipo === 'solicitacao') $tipoBadge = 'badge-info';
                                                  elseif ($tipo === 'elogio') $tipoBadge = 'badge-success';
                                                  elseif ($tipo === 'sugestao') $tipoBadge = 'badge-primary';
                                              ?>
                                              <tr>
                                                  <td>
                                                      <span class="badge badge-dark px-2 py-1" style="font-family: monospace; font-size: 0.85rem;">
                                                          <i class="fas fa-hashtag mr-1"></i><?= esc($agend['numero_protocolo'] ?? ('OUV-' . $agend['ouvidoria_id'])) ?>
                                                      </span>
                                                  </td>
                                                  <td>
                                                      <span class="badge <?= $tipoBadge ?> px-2 py-1 text-uppercase font-weight-bold">
                                                          <?= esc($agend['tipo_manifestacao'] ?? '-') ?>
                                                      </span>
                                                  </td>
                                                  <td>
                                                      <?php if (!empty($agend['nome_escola'] ?? $agend['escola_id'])): ?>
                                                          <i class="fas fa-school text-muted mr-1"></i><?= esc($agend['nome_escola'] ?? $agend['escola_id']) ?>
                                                      <?php else: ?>
                                                          <span class="text-muted">-</span>
                                                      <?php endif; ?>
                                                  </td>
                                                  <td>
                                                      <?= esc($agend['envolvidos'] ?? '-') ?>
                                                  </td>
                                                  <td>
                                                      <small class="text-muted"><i class="far fa-calendar-alt mr-1"></i><?= esc($agend['data_criacao'] ?? '-') ?></small>
                                                  </td>
                                                  <td>
                                                      <?php if (!empty($agend['data_resposta'])): ?>
                                                          <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i><?= esc($agend['data_resposta']) ?></span>
                                                      <?php else: ?>
                                                          <span class="badge badge-light border text-muted">Pendente</span>
                                                      <?php endif; ?>
                                                  </td>
                                                  <td>
                                                      <?php if (!empty($agend['responsavel_resposta'])): ?>
                                                          <i class="fas fa-user-check text-success mr-1"></i><?= esc($agend['responsavel_resposta']) ?>
                                                      <?php else: ?>
                                                          <span class="text-muted">-</span>
                                                      <?php endif; ?>
                                                  </td>
                                                  <td class="text-center">
                                                      <button type="button" class="btn btn-warning btn-sm" title="Editar" data-toggle="modal" data-target="#modal-editar-produto" 
                                                              onclick="prepararDados(
                                                                  '<?= esc($agend['ouvidoria_id'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['numero_protocolo'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['tipo_manifestacao'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['escola_id'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['envolvidos'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['data_criacao'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['data_resposta'] ?? '', 'js') ?>',
                                                                  '<?= esc($agend['responsavel_resposta'] ?? '', 'js') ?>'
                                                              )">
                                                          <i class="fas fa-edit"></i>
                                                      </button>
                                                      <a href="/Ouvidoriagab/excluir/<?= esc($agend['ouvidoria_id'] ?? '', 'url') ?>" class="btn btn-danger btn-sm" title="Excluir" onclick="return confirm('Deseja realmente excluir este registro?');">
                                                          <i class="fas fa-trash"></i>
                                                      </a>
                                                  </td>
                                              </tr>
                                          <?php endforeach; ?>
                                      <?php else: ?>
                                          <tr>
                                              <td colspan="8" class="text-center py-4 text-muted">
                                                  <i class="fas fa-box-open fa-2x mb-2 d-block text-secondary"></i>
                                                  Nenhum registro de ouvidoria encontrado.
                                              </td>
                                          </tr>
                                      <?php endif; ?>
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
      function prepararDados(ouvidoria_id, numero_protocolo, tipo_manifestacao, escola_id, envolvidos, data_criacao, data_resposta, responsavel_resposta) {
          document.getElementById('modal-editar-ouvidoriaid').value = ouvidoria_id || '';
          document.getElementById('modal-editar-protocolo').value = numero_protocolo || '';
          document.getElementById('modal-editar-tipodemanifestacao').value = tipo_manifestacao || '';
          document.getElementById('modal-editar-setorescola').value = escola_id || '';
          document.getElementById('modal-editar-envolvidos').value = envolvidos || '';
          document.getElementById('modal-editar-datacriacao').value = data_criacao || '';
          document.getElementById('modal-editar-dataresposta').value = data_resposta || '';
          document.getElementById('modal-editar-responsavelresposta').value = responsavel_resposta || '';

          $('#modal-editar-produto').modal('show');
      }

      function exportarExcel() {
          const tabela = document.getElementById('tabela-ouvidoria');
          if (!tabela) return;

          const linhas = tabela.querySelectorAll('tbody tr');
          if (linhas.length === 1 && linhas[0].querySelector('td[colspan]')) {
              alert('Não há registros de ouvidoria para exportar.');
              return;
          }

          if (typeof XLSX !== 'undefined') {
              // Cria uma cópia da tabela para manipular sem alterar o DOM da página
              const tabelaClone = tabela.cloneNode(true);

              // Remove a última coluna (Ações) do cabeçalho
              const cabecalho = tabelaClone.querySelector('thead tr');
              if (cabecalho && cabecalho.lastElementChild) {
                  cabecalho.removeChild(cabecalho.lastElementChild);
              }

              // Remove a última coluna (Ações) de cada linha do corpo
              const todasLinhas = tabelaClone.querySelectorAll('tbody tr');
              todasLinhas.forEach(function(tr) {
                  if (tr.lastElementChild) {
                      tr.removeChild(tr.lastElementChild);
                  }
              });

              // Converte a tabela filtrada para a planilha do Excel
              const wb = XLSX.utils.book_new();
              const ws = XLSX.utils.table_to_sheet(tabelaClone);

              // Define as larguras das colunas para visualização legível no Excel
              ws['!cols'] = [
                  { wch: 22 }, // Protocolo
                  { wch: 20 }, // Tipo
                  { wch: 35 }, // Setor / Escola
                  { wch: 30 }, // Envolvidos
                  { wch: 16 }, // Data Criação
                  { wch: 16 }, // Data Resposta
                  { wch: 28 }, // Responsável Resposta
              ];

              XLSX.utils.book_append_sheet(wb, ws, 'Ouvidorias');

              // Gera o nome do arquivo com a data atual
              const hoje = new Date().toLocaleDateString('pt-BR').replace(/\//g, '-');
              XLSX.writeFile(wb, `ouvidorias_${hoje}.xlsx`);
          } else {
              // Fallback automático para download direto gerado pelo backend
              window.location.href = '/Ouvidoriagab/exportar';
          }
      }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</html>
