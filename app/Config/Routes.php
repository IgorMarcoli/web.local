<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->get('ajax/escolas', 'Termogab::buscarEscolas');
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->get('login', 'Login::login');
$routes->post('login/autenticar', 'Login::autenticar');
$routes->get('logingab', 'Logingab::logingab');
$routes->post('logingab/autenticar', 'Logingab::autenticar');
$routes->get('agenda/agenda', 'Agenda::agenda');
$routes->post('agenda/cadastrar', 'Agenda::cadastrar');
$routes->post('agenda/editar', 'Agenda::editar');
$routes->post('agenda/excluir/(:num)', 'Agenda::excluir/$1');
$routes->post('agenda/agenda/alterarStatus', 'Agenda::alterarStatus');
$routes->post('agenda/alterarAtendidoPor', 'Agenda::alterarAtendidoPor');
$routes->post('dashboard/alterarStatusVisita', 'Dashboard::alterarStatusVisita');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('Dashboard', 'Dashboard::index');
$routes->get('dashboardgab', 'Dashboardgab::index');
$routes->get('atendimentogab/atendimentogab', 'Atendimentogab::Atendimentogab');
$routes->post('atendimentogab/cadastrar', 'Atendimentogab::cadastrar');
$routes->post('atendimentogab/editar', 'Atendimentogab::editar');
$routes->post('atendimentogab/excluir/(:num)', 'Atendimentogab::excluir/$1');
$routes->get('agendagab/agendagab', 'Agendagab::Agendagab');
$routes->post('agendagab/cadastrar', 'Agendagab::cadastrar');
$routes->post('agendagab/editar', 'Agendagab::editar');
$routes->post('agendagab/excluir/(:num)', 'Agendagab::excluir/$1');
$routes->get('ouvidoriagab/exportar', 'Ouvidoriagab::exportar');
$routes->get('Ouvidoriagab/exportar', 'Ouvidoriagab::exportar');
$routes->post('bancogab/bancogab/alterarStatusBanco', 'Bancogab::alterarStatusBanco');
$routes->get('bancogab/bancogab', 'Bancogab::Bancogab');
$routes->post('bancogab/cadastrar', 'Bancogab::cadastrar');
$routes->post('bancogab/editar', 'Bancogab::editar');
$routes->post('bancogab/excluir/(:num)', 'Bancogab::excluir/$1');
$routes->post('bancogab/alterarStatusBanco', 'Bancogab::alterarStatusBanco');
$routes->get('/bancogab/buscarPessoas', 'Bancogab::buscarPessoas');
$routes->get('agenda/json', 'Agenda::json');
$routes->get('/perfil', 'Login::perfil');
$routes->post('/perfil/atualizar', 'Login::atualizarPerfil');
$routes->get('/perfil/foto/(:segment)', 'Login::foto/$1');
// All application endpoints are explicitly mapped below; legacy auto-routing is disabled.
$routes->setAutoRoute(false);
$routes->post('login/sair', 'Login::sair');
$routes->get('gabinete', 'Gabinete::index');
$routes->get('setec', 'Setec::index');
$routes->get('fluxos', 'Fluxos::index');
$routes->get('manuais', 'Manuais::index');
$routes->get('manutencao', 'Manutencao::index');
$routes->get('escoladash', 'Escoladash::index');
$routes->get('escolaequip', 'Escolaequip::index');
$routes->get('escolaequip/escola/(:segment)', 'Escolaequip::escola/$1');
$routes->get('escolaequip/exportar/(:segment)', 'Escolaequip::exportarCsv/$1');
$routes->get('painel', 'Painel::index');
$routes->get('painel/dados', 'Painel::dados');
$routes->get('juridico', 'Juridico::index');
$routes->get('juridico/juridico', 'Juridico::Juridico');
$routes->post('juridico/cadastrar', 'Juridico::cadastrar');
$routes->post('juridico/editar', 'Juridico::editar');
$routes->post('juridico/excluir/(:num)', 'Juridico::excluir/$1');
$routes->get('nova', 'Nova::index');
$routes->get('nova/nova', 'Nova::Nova');
$routes->post('nova/cadastrar', 'Nova::cadastrar');
$routes->post('nova/editar', 'Nova::editar');
$routes->post('nova/excluir/(:num)', 'Nova::excluir/$1');
$routes->get('ouvidoriagab/ouvidoriagab', 'Ouvidoriagab::Ouvidoriagab');
$routes->post('ouvidoriagab/cadastrar', 'Ouvidoriagab::cadastrar');
$routes->post('ouvidoriagab/editar', 'Ouvidoriagab::editar');
$routes->post('ouvidoriagab/excluir/(:num)', 'Ouvidoriagab::excluir/$1');
$routes->get('processo/processo', 'Processo::Processo');
$routes->post('processo/cadastrar', 'Processo::cadastrar');
$routes->post('processo/editar', 'Processo::editar');
$routes->post('processo/excluir/(:num)', 'Processo::excluir/$1');
$routes->get('produtos/listar', 'Produtos::listar');
$routes->post('produtos/cadastrar', 'Produtos::cadastrar');
$routes->post('produtos/editar', 'Produtos::editar');
$routes->post('produtos/excluir/(:num)', 'Produtos::excluir/$1');
$routes->get('termogab/termogab', 'Termogab::termogab');
$routes->post('termogab/cadastrar', 'Termogab::cadastrar');
$routes->post('termogab/editar', 'Termogab::editar');
$routes->post('termogab/excluir/(:num)', 'Termogab::excluir/$1');
$routes->get('visita/visita', 'Visita::Visita');
$routes->post('visita/cadastrar', 'Visita::cadastrar');
$routes->post('visita/editar', 'Visita::editar');
$routes->post('visita/excluir/(:num)', 'Visita::excluir/$1');
$routes->get('emprestimos', 'Emprestimos::index');
$routes->get('emprestimo', 'Emprestimos::index');
$routes->get('emprestimoequi', 'Emprestimos::index');
$routes->get('equipamentos', 'Equipamentos::index');
$routes->post('equipamentos/salvar', 'Equipamentos::salvar');
$routes->post('equipamentos/salvarMultiplo', 'Equipamentos::salvarMultiplo');
$routes->post('equipamentos/editar', 'Equipamentos::editar');
$routes->post('equipamentos/editarMultiplo', 'Equipamentos::editarMultiplo');
$routes->post('equipamentos/excluir/(:num)', 'Equipamentos::excluir/$1');
$routes->post('equipamentos/excluirMultiplo', 'Equipamentos::excluirMultiplo');
$routes->get('equipamentos/getServidorDetalhes', 'Equipamentos::getServidorDetalhes');
$routes->get('proatis', 'Proatis::index');
$routes->get('proatis/escola/(:any)', 'Proatis::escola/$1');
$routes->get('inventario', 'Inventario::index');
$routes->post('inventario/salvar', 'Inventario::salvar');
$routes->post('inventario/salvarMultiplo', 'Inventario::salvarMultiplo');
$routes->post('inventario/editar', 'Inventario::editar');
$routes->post('inventario/editarMultiplo', 'Inventario::editarMultiplo');
$routes->post('inventario/excluir/(:num)', 'Inventario::excluir/$1');
$routes->post('inventario/excluirMultiplo', 'Inventario::excluirMultiplo');
$routes->post('emprestimos/salvar', 'Emprestimos::salvar');
$routes->post('emprestimos/editar', 'Emprestimos::editar');
$routes->post('emprestimos/salvarDataDevolucao', 'Emprestimos::salvarDataDevolucao');
$routes->post('emprestimos/salvarDataDevolucaoMultiplo', 'Emprestimos::salvarDataDevolucaoMultiplo');
$routes->post('emprestimos/excluirMultiplo', 'Emprestimos::excluirMultiplo');
$routes->post('emprestimos/editarMultiplo', 'Emprestimos::editarMultiplo');
$routes->post('emprestimos/excluir/(:num)', 'Emprestimos::excluir/$1');
$routes->get('emprestimos/getServidorDetalhes', 'Emprestimos::getServidorDetalhes');

// Conexão App - Escolas / URE
$routes->get('conexao/escolas/dashboard', 'Escoladash::index');
$routes->get('conexao/escolas/equipamentos', 'Escolaequip::index');
$routes->get('conexao/ure/manutencao', 'Manutencao::index');
$routes->get('conexao/escolas/proatis', 'Proatis::index');
$routes->get('conexao/contatos', 'Contatos::index');
$routes->post('conexao/contatos', 'Contatos::acao');

// Friendly short paths
$routes->get('proatis', 'Proatis::index');
$routes->get('contatos', 'Contatos::index');
$routes->post('contatos', 'Contatos::acao');

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
