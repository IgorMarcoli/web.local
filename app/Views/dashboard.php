
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard SEINTEC / SETEC</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
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
                <h3><?= 0 ?></h3>

                <p>Equipamentos cadastrados</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="Views/equipamentos.php" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $percentResolvido ?><sup style="font-size: 20px">%</sup></h3>

                <p>Chamados resolvidos</p>
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
                <h3><?= $totalChamados ?></h3>

                <p>Total de chamados no mês</p>
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
          <section class="col-lg-5 connectedSortable" >
           

             <div class="" >
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendário
                </h3>
                <!-- tools card -->
               
              <div id="calendar" style="width: 500px;">


                </div>
        <!-- Calendar -->                               
            </div>
            <!-- Custom tabs (Charts with tabs)-->
           
            <!-- /.card -->
</section>
            <!-- DIRECT CHAT -->
               
           
            <!-- /.card -->

         
                <!-- Calendar -->
         
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-7 connectedSortable ">
     <div class="card">
              <div class="card-header" >
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Atendimemtos
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Telefônicos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-chart" data-toggle="tab">Presenciais</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                     <canvas id="line-chart"></canvas>
                   </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- Map card -->
            <div class="card bg-gradient-primary" >
              <div class="card-header border-0" >
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitas ténicas
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
             <div class="card-body p-0">

    <?php if(empty($visitasPendentes)): ?>
        <div class="p-3 text-center text-white">
            Nenhuma visita pendente 🎉
        </div>
    <?php else: ?>

    <table class="table table-striped table-hover mb-0 text-white">
        <thead>
            <tr>
                <th>Escola</th>
                <th>Endereço</th>
                <th width="120">Ação</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($visitasPendentes as $e): ?>
                <tr>
                    <td><?=htmlspecialchars($e['Nome']) ?></td>
                    <td><?= htmlspecialchars($e['Endereco'])?></td>
                    <td>
                        <a
                          href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($e['Endereco']) ?>"
                          target="_blank"
                          class="btn btn-light btn-sm">
                            <i class="fas fa-route"></i> Rota
                        </a>


                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php endif; ?>

</div>
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
           

           
   
              <!-- /.card-header -->
        
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->
        
          </section>
          
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
     
  </div>

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<!-- jQuery -->
<script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
const labels = <?= json_encode(array_column($statusChamados, 'status')) ?>;
const valores = <?= json_encode(array_column($statusChamados, 'total')) ?>;

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: 'agenda/json'
      
    });

    calendar.render();
});
</script>

                      <style>
    /* Cor do cabeçalho */
    .fc .fc-toolbar-title {
        color: #ffffff;
    }

    /* Fundo do topo */
    .fc-header-toolbar {
        background-color: #343a40;
        padding: 10px;
        border-radius: 5px;
    }

    /* Cor dos botões */
    .fc .fc-button {
        background-color: black;
        border: none;
    }

    .fc .fc-button:hover {
        background-color: black;
    }

    /* Dia atual */
    .fc-day-today {
        background-color: #FFBE70 !important;
    }
</style>