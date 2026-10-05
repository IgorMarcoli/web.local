<?php

namespace App\Controllers;

use App\Models\ContatoModel;

class Contatos extends BaseController
{
    public function index()
    {
        $contatos = (new ContatoModel())->orderBy('nome', 'ASC')->findAll();
        echo View('templates/header');
        echo View('contatos', ['contatos' => $contatos]);
        echo View('templates/footer');
    }

    public function acao()
    {
        $acaoPostada = $this->request->getPost('acao');
        $acao = is_string($acaoPostada) ? $acaoPostada : '';
        $model = new ContatoModel();

        if ($acao === 'excluir') {
            $id = $this->validarId($this->request->getPost('id'));
            if ($id === null) {
                return $this->respostaJson(false, 'ID inválido.', 422);
            }
            if (!$model->find($id)) {
                return $this->respostaJson(false, 'Contato não encontrado.', 404);
            }

            try {
                if (!$model->delete($id)) {
                    return $this->respostaJson(false, 'Não foi possível excluir o contato.', 500);
                }
                return $this->respostaJson(true, 'Contato excluído com sucesso.');
            } catch (\Throwable $exception) {
                log_message('error', 'Falha ao excluir contato ({exceptionType}).', ['exceptionType' => get_class($exception)]);
                return $this->respostaJson(false, 'Não foi possível excluir o contato.', 500);
            }
        }

        if (!in_array($acao, ['inserir', 'alterar'], true)) {
            return $this->respostaJson(false, 'Ação inválida.', 400);
        }

        $dados = [];
        foreach (['nome', 'setor', 'ramal', 'email'] as $campo) {
            $valor = $this->request->getPost($campo);
            if ($valor !== null && !is_string($valor)) {
                return $this->respostaJson(false, 'Dados inválidos.', 422);
            }
            $dados[$campo] = trim((string) ($valor ?? ''));
        }

        if ($dados['nome'] === '' || mb_strlen($dados['nome'], 'UTF-8') > 120) {
            return $this->respostaJson(false, 'Informe um nome com até 120 caracteres.', 422);
        }
        if (mb_strlen($dados['setor'], 'UTF-8') > 120 || mb_strlen($dados['ramal'], 'UTF-8') > 30) {
            return $this->respostaJson(false, 'Setor ou ramal excede o tamanho permitido.', 422);
        }
        if (mb_strlen($dados['email'], 'UTF-8') > 254 || ($dados['email'] !== '' && filter_var($dados['email'], FILTER_VALIDATE_EMAIL) === false)) {
            return $this->respostaJson(false, 'Informe um e-mail válido.', 422);
        }
        try {
            if ($acao === 'inserir') {
                if ($model->insert($dados) === false) {
                    return $this->respostaJson(false, 'Não foi possível salvar o contato.', 500);
                }
                return $this->respostaJson(true, 'Contato adicionado com sucesso.');
            }

            $id = $this->validarId($this->request->getPost('id'));
            if ($id === null) {
                return $this->respostaJson(false, 'Dados inválidos.', 422);
            }
            if (!$model->find($id)) {
                return $this->respostaJson(false, 'Contato não encontrado.', 404);
            }

            if (!$model->update($id, $dados)) {
                return $this->respostaJson(false, 'Não foi possível salvar o contato.', 500);
            }
            return $this->respostaJson(true, 'Contato atualizado com sucesso.');
        } catch (\Throwable $exception) {
            log_message('error', 'Falha ao salvar contato ({exceptionType}).', ['exceptionType' => get_class($exception)]);
            return $this->respostaJson(false, 'Não foi possível salvar o contato.', 500);
        }
    }

    private function validarId($valor): ?int
    {
        if ((!is_string($valor) && !is_int($valor)) || !ctype_digit((string) $valor) || (int) $valor < 1) {
            return null;
        }

        return (int) $valor;
    }

    private function respostaJson(bool $sucesso, string $mensagem, int $status = 200)
    {
        return $this->response->setStatusCode($status)->setJSON([
            'sucesso' => $sucesso,
            'mensagem' => $mensagem,
        ]);
    }
}
