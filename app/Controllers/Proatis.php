<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProatiModel;
use App\Models\EscolasModel;

class Proatis extends BaseController
{
    /**
     * Lista todos os usuários com perfil PROATI em formato de cards.
     */
    public function index()
    {
        $proati_model = new ProatiModel();

        $proatis = $proati_model->getProatis();

        $data = [
            'proatis' => $proatis,
        ];

        echo view('templates/header');
        echo view('proatis', $data);
        echo view('templates/footer');
    }

    /**
     * PLACEHOLDER: futura página de detalhes da escola, acessada ao clicar
     * em um PROATI. Aqui entrarão futuramente as informações da escola e
     * a atualização em tempo real dos APs (conectados/desconectados,
     * status de internet).
     *
     * Já deixado pronto para não ser necessário mexer nos links dos
     * cards quando essa parte for implementada.
     */
    public function escola($escolaId)
    {
        $escola_model = new EscolasModel();

        $escola = $escola_model->find($escolaId); // ajuste o nome da PK se necessário

        $data = [
            'escola'   => $escola,
            'escolaId' => $escolaId,
        ];

        echo view('templates/header');
        echo view('proatis_escola', $data); // view a ser criada quando essa etapa for implementada
        echo view('templates/footer');
    }
}