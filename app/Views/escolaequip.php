<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Equipamentos de Escolas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Conexão App</li>
                        <li class="breadcrumb-item">Escolas</li>
                        <li class="breadcrumb-item active">Equipamentos de Escolas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Cartões de Estatísticas -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= esc($stats['total']) ?></h3>
                            <p>Total de Equipamentos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= esc($stats['funcional']) ?></h3>
                            <p>Em Funcionamento</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= esc($stats['emprestado']) ?></h3>
                            <p>Emprestados</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= esc($stats['manutencao']) ?></h3>
                            <p>Em Manutenção</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Equipamentos -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped" id="equip-table">
                                <thead>
                                    <tr>
                                        <th>ID Equipamento</th>
                                        <th>Nome</th>
                                        <th>Código QR</th>
                                        <th>Categoria</th>
                                        <th>Estado de Conservação</th>
                                        <th>Status</th>
                                        <th>Escola de Alocação</th>
                                        <th>Marca e Modelo</th>
                                        <th>Nº de Série</th>
                                        <th>Sala</th>
                                        <th>Lote</th>
                                        <th>Observações</th>
                                        <th>Data de Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items) && is_array($items)): ?>
                                        <?php foreach ($items as $it): ?>
                                            <tr>
                                                <td><?= esc($it['id']) ?></td>
                                                <td><?= esc($it['nome']) ?></td>
                                                <td><?= esc($it['codigo_qr']) ?></td>
                                                <td><?= esc($it['categoria']) ?></td>
                                                <td><?= esc($it['conservacao']) ?></td>
                                                <td><?= esc($it['id_status']) ?></td>
                                                <td><?= esc($it['escola_id']) ?></td>
                                                <td><?= esc($it['marca']) ?> <?= esc($it['modelo']) ?></td>
                                                <td><?= esc($it['numero_serie']) ?></td>
                                                <td><?= esc($it['local']) ?></td>
                                                <td><?= esc($it['lote_id']) ?></td>
                                                <td><?= esc($it['observacao']) ?></td>
                                                <td><?= esc($it['created_at']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="13">Nenhum equipamento encontrado.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
