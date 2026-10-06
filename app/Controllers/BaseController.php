<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Autenticação e permissões são aplicadas pelos filtros do framework.
    }

    /**
     * Garante que apenas usuários do SEINTEC acessem o recurso.
     */
    protected function permitirApenasSeintec()
    {
        $usuarioSetor = strtoupper(trim(session()->get('usuario_setor') ?? ''));
        if ($usuarioSetor === 'SETEC') {
            return redirect()->to('/Dashboard')->with('alert', 'acessoNegado');
        }
        return null;
    }

    /**
     * Limita tentativas repetidas para o mesmo usuário vindas do mesmo IP.
     */
    protected function loginAttemptAllowed(string $username): bool
    {
        $key = 'login_' . hash(
            'sha256',
            mb_strtolower(trim($username), 'UTF-8') . "\0" . $this->request->getIPAddress()
        );

        return service('throttler')->check($key, 8, 60);
    }
}
