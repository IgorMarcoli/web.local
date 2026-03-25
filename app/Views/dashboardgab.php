
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
