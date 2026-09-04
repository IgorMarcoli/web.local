
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard GABINETE DA DIRIGENTE</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
         <section action="/dashboard" method="get"></section>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $totalSupervisores ?></h3>

                <p>Supervisores Ativos</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $totalEscolas ?></h3>

                <p>Escolas</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $visitasMes ?></h3>

                <p>Visitas no Mês</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $totalVisitas ?></h3>

                <p>Visitas técnicas realizadas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
       <div class="row">
  <!-- Left col -->
  <section class="col-lg-7 connectedSortable">

    <div class="card">

      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-pie mr-1"></i>
          Atendimentos
        </h3>

        <!-- DROPDOWN no canto direito -->
        <div class="card-tools" style="width:220px;">
          <select id="filtroSupervisor" class="form-control form-control-sm">
            <option value="todos">Todos os supervisores</option>
          </select>
        </div>
      </div>

      <div class="card-body">
        <div class="tab-content p-0">
          <div class="chart tab-pane active"
               style="position: relative; height:300px;">

            <canvas id="chartSupervisor"></canvas>

          </div>
        </div>
      </div>
    </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
          <div class="card">

      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-chart-pie mr-1"></i>
         Visitas por Escolas do Setor
        </h3>

        <!-- DROPDOWN no canto direito -->
        <div class="card-tools" style="width:220px;">
          <select id="filtroSupervisor2" class="form-control form-control-sm">
            <option value="todos">Todos os supervisores</option>
          </select>
        </div>
      </div>

      <div class="card-body">
        <div class="tab-content p-0">
          <div class="chart tab-pane active"
               style="position: relative; height:300px;">

            <canvas id="chartEscolasSupervisor"></canvas>

          </div>
        </div>
      </div>
    </div>
    </section><!-- /.right col -->
  </div>
  <!-- /.row (gráficos supervisores) -->

  <!-- NOVA LINHA: Ouvidoria - Tipo x Responsável -->
  <div class="row mt-3">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-headset mr-1"></i>
            Ouvidoria — Tipo de Manifestação por Responsável pela Resposta
          </h3>
          <div class="card-tools" style="width:230px;">
            <select id="filtroTipoOuvidoria" class="form-control form-control-sm">
              <option value="todos">Todos os tipos</option>
            </select>
          </div>
        </div>
        <div class="card-body">
          <div style="position: relative; height:320px;">
            <canvas id="chartOuvidoriaTipoResp"></canvas>
          </div>
        </div>
        <div class="card-footer text-muted text-sm">
          <i class="fas fa-info-circle mr-1"></i>
          Registros sem responsável definido não são exibidos.
        </div>
      </div>
    </div>
  </div>
  <!-- /NOVA LINHA Ouvidoria -->

</div><!-- /.container-fluid -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
const supervisores = <?= json_encode($porSupervisor) ?>;

// =======================
// Monta dados iniciais
// =======================

const labels = supervisores.map(s => s.nome);
const valores = supervisores.map(s => Number(s.total));

const ctx = document.getElementById('chartSupervisor');

let chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Atendimentos',
            data: valores
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});


// =======================
// DROPDOWN
// =======================

const selectSupervisor = document.getElementById('filtroSupervisor');

supervisores.forEach(s => {
    const option = document.createElement('option');
    option.value = s.nome;
    option.textContent = s.nome;
    selectSupervisor.appendChild(option);
});


// =======================
// FILTRO
// =======================

selectSupervisor.addEventListener('change', function () {

    if (this.value === 'todos') {
        chart.data.labels = labels;
        chart.data.datasets[0].data = valores;
    } else {
        const sup = supervisores.find(s => s.nome === this.value);

        chart.data.labels = [sup.nome];
        chart.data.datasets[0].data = [Number(sup.total)];
    }

    chart.update();
});
</script>


<script>
const dados = <?= json_encode($porSupervisorEscolas) ?>;

const select = document.getElementById('filtroSupervisor2');
const ctxE = document.getElementById('chartEscolasSupervisor');

// =======================
// lista supervisores únicos
// =======================

const supervisoresUnicos = [...new Set(dados.map(d => d.supervisor))];

supervisoresUnicos.forEach(nome => {
    const opt = document.createElement('option');
    opt.value = nome;
    opt.textContent = nome;
    select.appendChild(opt);
});

// =======================
// gráfico vazio inicial
// =======================

let chart2 = new Chart(ctxE, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Visitas por escola',
            data: []
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true }
        }
    }
});

// =======================
// função de atualizar
// =======================

function atualizarGrafico(nomeSupervisor){

    let filtrado;

    if(nomeSupervisor === 'todos'){
        filtrado = dados;
    } else {
        filtrado = dados.filter(d => d.supervisor === nomeSupervisor);
    }

    const labels = filtrado.map(d => d.escola);
    const valores = filtrado.map(d => Number(d.total));

    chart2.data.labels = labels;
    chart2.data.datasets[0].data = valores;
    chart2.data.datasets[0].label = `Visitas por escola - ${nomeSupervisor}`;

    chart2.update();
}

// inicial
atualizarGrafico('todos');

// evento
select.addEventListener('change', e => {
    atualizarGrafico(e.target.value);
});

</script>

<!-- =====================================================
     GRÁFICO OUVIDORIA: Tipo de Manifestação x Responsável
     ===================================================== -->
<script>
(function() {
    const dadosOuvidoria = <?= json_encode($ouvidoriaTipoResp ?? []) ?>;

    if (!dadosOuvidoria || dadosOuvidoria.length === 0) {
        const canvas = document.getElementById('chartOuvidoriaTipoResp');
        if (canvas) {
            canvas.style.display = 'none';
            const msg = document.createElement('div');
            msg.className = 'text-center text-muted py-4';
            msg.innerHTML = '<i class="fas fa-inbox fa-2x mb-2 d-block"></i>Nenhum registro de ouvidoria com responsável definido.';
            canvas.parentNode.appendChild(msg);
        }
        return;
    }

    // Paleta de cores por tipo de manifestação
    const coresTipo = {
        'reclamacao':  'rgba(255, 193, 7,  0.85)',
        'denuncia':    'rgba(220, 53,  69,  0.85)',
        'solicitacao': 'rgba(23,  162, 184, 0.85)',
        'elogio':      'rgba(40,  167, 69,  0.85)',
        'sugestao':    'rgba(0,   123, 255, 0.85)',
        'outros':      'rgba(108, 117, 125, 0.85)',
    };

    // Extrai listas únicas de responsáveis e tipos
    const responsaveis = [...new Set(dadosOuvidoria.map(d => d.responsavel_resposta))].sort();
    const tipos        = [...new Set(dadosOuvidoria.map(d => d.tipo_manifestacao))].sort();

    // Monta datasets: um por tipo, eixo X = responsável
    function buildDatasets(filtroTipo) {
        const tiposFiltrados = filtroTipo === 'todos' ? tipos : [filtroTipo];
        return tiposFiltrados.map(tipo => {
            const cor = coresTipo[tipo.toLowerCase()] || 'rgba(150,150,150,0.8)';
            return {
                label: tipo.charAt(0).toUpperCase() + tipo.slice(1),
                backgroundColor: cor,
                borderColor:     cor.replace('0.85', '1'),
                borderWidth: 1,
                data: responsaveis.map(resp => {
                    const row = dadosOuvidoria.find(
                        d => d.responsavel_resposta === resp && d.tipo_manifestacao === tipo
                    );
                    return row ? Number(row.total) : 0;
                })
            };
        });
    }

    const ctxO = document.getElementById('chartOuvidoriaTipoResp');
    let chartOuvidoria = new Chart(ctxO, {
        type: 'bar',
        data: {
            labels: responsaveis,
            datasets: buildDatasets('todos')
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        title: ctx => 'Responsável: ' + ctx[0].label
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    title: { display: true, text: 'Responsável pela Resposta' }
                },
                y: {
                    stacked: false,
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    title: { display: true, text: 'Quantidade' }
                }
            }
        }
    });

    // Popula o select de filtro
    const selectTipo = document.getElementById('filtroTipoOuvidoria');
    tipos.forEach(tipo => {
        const opt = document.createElement('option');
        opt.value = tipo;
        opt.textContent = tipo.charAt(0).toUpperCase() + tipo.slice(1);
        selectTipo.appendChild(opt);
    });

    // Evento de filtro
    selectTipo.addEventListener('change', function () {
        chartOuvidoria.data.datasets = buildDatasets(this.value);
        chartOuvidoria.update();
    });
})();
</script>
