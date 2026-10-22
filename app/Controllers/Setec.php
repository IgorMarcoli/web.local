<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\EmprestimosModel;
use App\Controllers\BaseController;

class Setec extends BaseController
{
    public function index()
    {
        $dados = $this->request->getVar();
        
        $login_model = new LoginModel();
        $login_nome = $login_model->select('Nomeuser');

        $usuarioSetor = strtoupper(trim((string)(session()->get('usuario_setor') ?? '')));
        $emprestimosAbertos = [];

        // Busca empréstimos em aberto apenas para usuários SETEC e SEINTEC
        if ($usuarioSetor === 'SETEC' || $usuarioSetor === 'SEINTEC' || $usuarioSetor === '') {
            $emprestimosModel = new EmprestimosModel();
            $emprestimosAbertos = $emprestimosModel->where('data_devolucao IS NULL', null, false)
                ->orderBy('id_emprestimo', 'DESC')
                ->findAll();
        }

        $mostrarPopup = (bool) (session()->getFlashdata('mostrar_popup_emprestimos') || $this->request->getGet('login') === '1');

        $data = [
            'loginNome'          => $login_nome,
            'emprestimosAbertos' => $emprestimosAbertos,
            'mostrarPopup'       => $mostrarPopup,
        ];

        echo View('templates/header');     
        echo View('setec', $data);
        echo View('templates/footer');
    }
}
