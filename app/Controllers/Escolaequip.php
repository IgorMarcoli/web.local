<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventarioEscolasModel;

class Escolaequip extends BaseController
{
    /**
     * Diretório geral de escolas do inventário (76 escolas e métricas consolidadas).
     */
    public function index()
    {
        $model = new InventarioEscolasModel();

        $busca = $this->request->getGet('busca');
        $escolas = $model->getListaEscolas($busca);
        $estatisticas = $model->getEstatisticasGerais();

        $data = [
            'escolas'      => $escolas,
            'stats'        => $estatisticas,
            'buscaAtual'   => $busca ?? '',
        ];

        echo view('templates/header');
        echo view('escolaequip', $data);
        echo view('templates/footer');
    }

    /**
     * Página exclusiva de uma escola com todos os seus equipamentos e indicadores.
     *
     * @param string $cie Código CIE da escola
     */
    public function escola(string $cie)
    {
        $model = new InventarioEscolasModel();

        $cie = trim($cie);
        $escola = $model->getDadosEscola($cie);

        if (!$escola) {
            return redirect()->to('/escolaequip')->with('erro', 'Escola não encontrada no inventário.');
        }

        $filtros = [
            'categoria' => $this->request->getGet('categoria'),
            'status'    => $this->request->getGet('status'),
            'ambiente'  => $this->request->getGet('ambiente'),
            'busca'     => $this->request->getGet('busca'),
        ];

        $equipamentos       = $model->getEquipamentosPorEscola($cie, $filtros);
        $filtrosDisponiveis = $model->getFiltrosDisponiveis($cie);
        $categoriasResumo   = $model->getCategoriasResumo($cie);

        $data = [
            'escola'             => $escola,
            'equipamentos'       => $equipamentos,
            'filtrosDisponiveis' => $filtrosDisponiveis,
            'categoriasResumo'   => $categoriasResumo,
            'filtrosAtivos'      => $filtros,
        ];

        echo view('templates/header');
        echo view('escolaequip_detalhes', $data);
        echo view('templates/footer');
    }

    /**
     * Exporta os equipamentos de uma escola em formato CSV com codificação UTF-8 (compatível com Excel).
     *
     * @param string $cie Código CIE da escola
     */
    public function exportarCsv(string $cie)
    {
        $model = new InventarioEscolasModel();
        $cie = trim($cie);
        $escola = $model->getDadosEscola($cie);

        if (!$escola) {
            return redirect()->to('/escolaequip');
        }

        $equipamentos = $model->getEquipamentosPorEscola($cie);

        $nomeArquivo = 'Inventario_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $escola['escola_nome']) . '_CIE_' . $cie . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // BOM UTF-8 para abertura perfeita de acentos no Microsoft Excel
        fputs($out, "\xEF\xBB\xBF");

        // Cabeçalho CSV
        fputcsv($out, [
            'ID',
            'CIE',
            'Escola',
            'Diretoria',
            'Ambiente',
            'Categoria',
            'Fabricante',
            'Modelo',
            'Hostname',
            'Nº Série',
            'Controle UE',
            'Status Equipamento',
            'Avaliação Técnica',
            'Descrição / Local',
            'Data Abertura Chamado',
            'Nº Chamado',
            'Data Visita',
            'Técnico Responsável',
            'Status Visita',
            'Observações'
        ], ';');

        foreach ($equipamentos as $e) {
            fputcsv($out, [
                $e['id'],
                $e['escola_cie'],
                $e['escola_nome'],
                $e['ure_diretoria'],
                $e['ambiente'],
                $e['categoria'],
                $e['fabricante'],
                $e['modelo'],
                $e['hostname'],
                $e['numero_serie'],
                $e['id_controle_ue'],
                $e['status_equipamento'],
                $e['avaliacao_tecnica'],
                $e['descricao'],
                $e['data_abertura_chamado'],
                $e['numero_chamado'],
                $e['data_visita'],
                $e['tecnico_responsavel'],
                $e['status_visita'],
                $e['observacoes'],
            ], ';');
        }

        fclose($out);
        exit;
    }
}
