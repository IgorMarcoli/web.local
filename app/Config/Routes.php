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
$routes->get('agenda/agenda', 'Agenda::agenda');
$routes->post('agenda/cadastrar', 'Agenda::cadastrar');
$routes->post('agenda/editar', 'Agenda::editar');
$routes->get('agenda/excluir/(:num)', 'Agenda::excluir/$1');
$routes->post('agenda/agenda/alterarStatus', 'Agenda::alterarStatus');
$routes->get('agendagab/agendagab', 'Agendagab::Agendagab');
$routes->post('agendagab/cadastrar', 'Agendagab::cadastrar');
$routes->post('agendagab/editar', 'Agendagab::editar');
$routes->get('agendagab/excluir/(:num)', 'Agendagab::excluir/$1');
$routes->post('bancogab/bancogab/alterarStatusBanco', 'Bancogab::alterarStatusBanco');
$routes->get('/bancogab/buscarPessoas', 'Bancogab::buscarPessoas');
$routes->get('agenda/json', 'Agenda::json');
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);
$routes->get('emprestimos', 'Emprestimos::index');
$routes->get('emprestimo', 'Emprestimos::index');
$routes->get('emprestimoequi', 'Emprestimos::index');
$routes->get('equipamentos', 'Equipamentos::index');
$routes->post('equipamentos/salvar', 'Equipamentos::salvar');
$routes->post('equipamentos/salvarMultiplo', 'Equipamentos::salvarMultiplo');
$routes->post('equipamentos/editar', 'Equipamentos::editar');
$routes->post('equipamentos/editarMultiplo', 'Equipamentos::editarMultiplo');
$routes->get('equipamentos/excluir/(:num)', 'Equipamentos::excluir/$1');
$routes->post('equipamentos/excluir/(:num)', 'Equipamentos::excluir/$1');
$routes->post('equipamentos/excluirMultiplo', 'Equipamentos::excluirMultiplo');
$routes->post('inventario/salvar', 'Inventario::salvar');
$routes->post('inventario/salvarMultiplo', 'Inventario::salvarMultiplo');
$routes->post('inventario/editar', 'Inventario::editar');
$routes->post('inventario/editarMultiplo', 'Inventario::editarMultiplo');
$routes->get('inventario/excluir/(:num)', 'Inventario::excluir/$1');
$routes->post('inventario/excluir/(:num)', 'Inventario::excluir/$1');
$routes->post('inventario/excluirMultiplo', 'Inventario::excluirMultiplo');
$routes->post('emprestimos/salvar', 'Emprestimos::salvar');
$routes->post('emprestimos/editar', 'Emprestimos::editar');
$routes->post('emprestimos/salvarDataDevolucao', 'Emprestimos::salvarDataDevolucao');
$routes->post('emprestimos/salvarDataDevolucaoMultiplo', 'Emprestimos::salvarDataDevolucaoMultiplo');
$routes->post('emprestimos/excluirMultiplo', 'Emprestimos::excluirMultiplo');
$routes->post('emprestimos/editarMultiplo', 'Emprestimos::editarMultiplo');
$routes->post('emprestimos/excluir/(:num)', 'Emprestimos::excluir/$1');

// Conexão App - Escolas / URE
$routes->get('conexao/escolas/dashboard', 'Escoladash::index');
$routes->get('conexao/escolas/equipamentos', 'Escolaequip::index');
$routes->get('conexao/ure/manutencao', 'Manutencao::index');
$routes->get('conexao/escolas/proatis', 'Proatis::index');
$routes->get('conexao/contatos', 'Contatos::index');

// Friendly short paths
$routes->get('proatis', 'Proatis::index');
$routes->get('contatos', 'Contatos::index');

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
