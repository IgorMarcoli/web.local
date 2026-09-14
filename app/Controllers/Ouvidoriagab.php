<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OuvidoriaModel;
use App\Models\EscolasModel;
class Ouvidoriagab extends BaseController
{
    public function Ouvidoriagab()
    {
    $agendas_model = new OuvidoriaModel();
    $escolaModel = new EscolasModel();

    $agendas = $agendas_model->getComEscola(); // <-- troca aqui

    $escolas = $escolaModel->findAll();
    $data = [
        'ouvidoria' => $agendas,
        'escolas' => $escolas
    ];

    echo View('templates/headergabinete');
    echo View('ouvidoria', $data);
    echo View('templates/footer');
    }

    public function cadastrar()
    {
        $dados = $this->request->getPost();

        // Número de protocolo: se deixado em branco, gera formato OUV-ANO-XXXXX
        if (empty(trim((string) ($dados['numero_protocolo'] ?? '')))) {
            $dados['numero_protocolo'] = 'OUV-' . date('Y') . '-' . str_pad((string) mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }

        // Sanitização de datas e chaves estrangeiras para PostgreSQL
        if (empty($dados['data_criacao'])) {
            $dados['data_criacao'] = date('Y-m-d');
        }
        if (empty($dados['data_resposta'])) {
            $dados['data_resposta'] = null;
        }
        if (empty($dados['escola_id'])) {
            $dados['escola_id'] = null;
        }

        $agendas_model = new OuvidoriaModel();
        $agendas_model->insert($dados);

        return redirect()->to('/ouvidoriagab/Ouvidoriagab?alert=successCreate');
    }

    public function excluir($ouvidoria_id)
    {
        $agenda_model = new OuvidoriaModel();
        $agenda_model->where('ouvidoria_id', $ouvidoria_id)->delete();

        return redirect()->to('/ouvidoriagab/Ouvidoriagab?alert=successDelete');
    }

    public function editar()
    {
        $dados = $this->request->getPost();
        $agenda_model = new OuvidoriaModel();

        if (empty($dados['data_criacao'])) {
            $dados['data_criacao'] = null;
        }
        if (empty($dados['data_resposta'])) {
            $dados['data_resposta'] = null;
        }
        if (empty($dados['escola_id'])) {
            $dados['escola_id'] = null;
        }

        $agenda_model->where('ouvidoria_id', $dados['ouvidoria_id'])->set($dados)->update();

        return redirect()->to('/ouvidoriagab/Ouvidoriagab?alert=successEdit'); 
    }

    public function exportar()
    {
        $agendas_model = new OuvidoriaModel();
        $registros = $agendas_model->getComEscola();

        $nomeArquivo = 'ouvidorias_' . date('d-m-Y_His') . '.csv';

        // Headers para download direto compatível com Excel
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // BOM UTF-8 para o Excel no Windows reconhecer a acentuação perfeitamente
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Cabeçalhos das colunas (delimitador ponto e vírgula padrão pt-BR para Excel)
        fputcsv($output, [
            'Protocolo',
            'Tipo de Manifestação',
            'Setor / Escola',
            'Envolvidos',
            'Data de Criação',
            'Data da Resposta',
            'Responsável pela Resposta'
        ], ';');

        if (!empty($registros)) {
            foreach ($registros as $row) {
                $tipo = ucfirst(mb_strtolower((string) ($row['tipo_manifestacao'] ?? '')));
                $escola = $row['nome_escola'] ?? $row['escola_id'] ?? '-';
                $envolvidos = $row['envolvidos'] ?? '-';

                $dataCriacao = !empty($row['data_criacao']) 
                    ? date('d/m/Y', strtotime($row['data_criacao'])) 
                    : '-';

                $dataResposta = !empty($row['data_resposta']) 
                    ? date('d/m/Y', strtotime($row['data_resposta'])) 
                    : 'Pendente';

                $responsavel = $row['responsavel_resposta'] ?? '-';
                $protocolo = $row['numero_protocolo'] ?? ('OUV-' . ($row['ouvidoria_id'] ?? ''));

                fputcsv($output, [
                    $protocolo,
                    $tipo,
                    $escola,
                    $envolvidos,
                    $dataCriacao,
                    $dataResposta,
                    $responsavel
                ], ';');
            }
        }

        fclose($output);
        exit;
    }
}

