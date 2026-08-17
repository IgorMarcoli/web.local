<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../" class="brand-link">
        <img src="<?= base_url('tema/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Intranet - SVI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('tema/dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
             
                <a href="#" class="d-block" >Nome do usuário</a>
                
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/Dashboard" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Conexão App
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Escolas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/escoladash" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Dashboard Escolas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/escolaequip" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Equipamentos de Escolas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    URE
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/manutencao" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Dados de Manutenção</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
               <li class="nav-item">
                    <a href="/produtos/listar" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Atendimento
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/agenda/agenda" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Agenda
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/equipamentos" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Equipamentos
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/inventario" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Inventário
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/emprestimos" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Empréstimos
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/proatis" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            PROATIs
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manuais#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Manuais
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="fluxos#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Fluxos
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/contatos" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Contatos
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>