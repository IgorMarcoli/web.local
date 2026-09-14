<?php

// ===================== CONEXÃO COM O BANCO =====================
$host = "localhost";
$banco = "sistema_web";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8",
        $usuario,
        $senha
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    if (isset($_POST['acao'])) {
        header('Content-Type: application/json');
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro de conexão: ' . $e->getMessage()]);
        exit;
    }
    die("Erro de conexão: " . $e->getMessage());
}

// ===================== CAMPOS =====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {

    header('Content-Type: application/json');
    $acao = $_POST['acao'];

    switch ($acao) {

        case 'inserir':
            $nome  = trim($_POST['nome'] ?? '');
            $setor = trim($_POST['setor'] ?? '');
            $ramal = trim($_POST['ramal'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if ($nome === '') {
                echo json_encode(['sucesso' => false, 'mensagem' => 'O nome é obrigatório.']);
                exit;
            }

            $stmt = $pdo->prepare(
                "INSERT INTO contatos (nome, setor, ramal, email) VALUES (:nome, :setor, :ramal, :email)"
            );
            $stmt->execute([
                ':nome'  => $nome,
                ':setor' => $setor,
                ':ramal' => $ramal,
                ':email' => $email
            ]);

            echo json_encode(['sucesso' => true, 'mensagem' => 'Contato adicionado com sucesso.']);
            exit;

        case 'alterar':
            $id    = $_POST['id'] ?? 0;
            $nome  = trim($_POST['nome'] ?? '');
            $setor = trim($_POST['setor'] ?? '');
            $ramal = trim($_POST['ramal'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!$id || $nome === '') {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos.']);
                exit;
            }

            $stmt = $pdo->prepare(
                "UPDATE contatos SET nome = :nome, setor = :setor, ramal = :ramal, email = :email WHERE id = :id"
            );
            $stmt->execute([
                ':nome'  => $nome,
                ':setor' => $setor,
                ':ramal' => $ramal,
                ':email' => $email,
                ':id'    => $id
            ]);

            echo json_encode(['sucesso' => true, 'mensagem' => 'Contato atualizado com sucesso.']);
            exit;

        case 'excluir':
            $id = $_POST['id'] ?? 0;

            if (!$id) {
                echo json_encode(['sucesso' => false, 'mensagem' => 'ID inválido.']);
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM contatos WHERE id = :id");
            $stmt->execute([':id' => $id]);

            echo json_encode(['sucesso' => true, 'mensagem' => 'Contato excluído com sucesso.']);
            exit;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
            exit;
    }
}

// ===================== BUSCA OS CONTATOS PARA EXIBIR =====================
$sql = "SELECT * FROM contatos ORDER BY nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<style>

.main-sidebar{
    position: fixed !important;
    top: 0;
    left: 0;
    bottom: 0;
    min-height: 100vh !important;
    height: 100vh !important;
}

.content-wrapper{
    min-height: 100vh !important;
}

.content-header h1{
    text-align:center;
    font-weight:normal;
}

.bloco-pesquisa{
    width:80%;
    margin:0 auto 20px auto;
}

#tabelaContatos th,
#tabelaContatos td{
    text-align:center;
    vertical-align:middle;
}

/* ===== MODAL PRÓPRIO (sem depender do JS do Bootstrap) ===== */
.modal-custom-overlay{
    display:none;
    position:fixed;
    top:0; left:0; right:0; bottom:0;
    background:rgba(0,0,0,0.5);
    z-index:1050;
    align-items:center;
    justify-content:center;
}
.modal-custom-overlay.show{
    display:flex;
}
.modal-custom-box{
    background:#fff;
    border-radius:6px;
    width:100%;
    max-width:500px;
    margin:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.3);
}
.modal-custom-header,
.modal-custom-footer{
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.modal-custom-header{
    border-bottom:1px solid #dee2e6;
}
.modal-custom-footer{
    border-top:1px solid #dee2e6;
    justify-content:flex-end;
    gap:8px;
}
.modal-custom-body{
    padding:20px;
}
.modal-custom-close{
    background:none;
    border:none;
    font-size:22px;
    line-height:1;
    cursor:pointer;
}

</style>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1>Contatos dos Funcionários da URE</h1>
        </div>
    </section>

    <section class="content">

        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <label for="pesquisarContato">
                    <strong>Pesquisar Contato</strong>
                </label>
                <div class="input-group">
                    <input
                        type="text"
                        id="pesquisarContato"
                        class="form-control"
                        placeholder="Digite o nome, setor, ramal ou e-mail">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" id="btnPesquisar">
                            🔍 Pesquisar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-8 text-right">
                <button type="button" class="btn btn-success" id="btnNovoContato">
                    + Adicionar Contato
                </button>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover" id="tabelaContatos">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Setor</th>
                    <th>Ramal</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($contatos as $contato): ?>
                <tr data-id="<?= $contato['id'] ?>">
                    <td class="col-nome"><?= htmlspecialchars($contato['nome']) ?></td>
                    <td class="col-setor"><?= htmlspecialchars($contato['setor']) ?></td>
                    <td class="col-ramal"><?= htmlspecialchars($contato['ramal']) ?></td>
                    <td class="col-email"><?= htmlspecialchars($contato['email']) ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning btnEditar">✏️</button>
                        <button type="button" class="btn btn-sm btn-danger btnExcluir">🗑️</button>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </section>

</div>

<!-- MODAL PRÓPRIO -->
<div class="modal-custom-overlay" id="modalContato">
    <div class="modal-custom-box">
        <form id="formContato">

            <div class="modal-custom-header">
                <h5 id="modalContatoTitulo" style="margin:0;">Adicionar Contato</h5>
                <button type="button" class="modal-custom-close" id="btnFecharModal">&times;</button>
            </div>

            <div class="modal-custom-body">
                <input type="hidden" id="contatoId" name="id">

                <div class="form-group">
                    <label for="inputNome">Nome</label>
                    <input type="text" class="form-control" id="inputNome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="inputSetor">Setor</label>
                    <input type="text" class="form-control" id="inputSetor" name="setor">
                </div>

                <div class="form-group">
                    <label for="inputRamal">Ramal</label>
                    <input type="text" class="form-control" id="inputRamal" name="ramal">
                </div>

                <div class="form-group">
                    <label for="inputEmail">E-mail</label>
                    <input type="email" class="form-control" id="inputEmail" name="email">
                </div>
            </div>

            <div class="modal-custom-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelarModal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

        </form>
    </div>
</div>

<script>
// ===== JAVASCRIPT  =====
document.addEventListener('DOMContentLoaded', function () {

    var urlAcoes   = window.location.pathname;
    var modal      = document.getElementById('modalContato');
    var form       = document.getElementById('formContato');
    var tituloModal = document.getElementById('modalContatoTitulo');
    var tabela     = document.getElementById('tabelaContatos');

    function abrirModal() {
        modal.classList.add('show');
    }
    function fecharModal() {
        modal.classList.remove('show');
    }

    // ===== PESQUISA =====
    function filtrarTabela() {
        var termo = document.getElementById('pesquisarContato').value.toLowerCase();
        var linhas = tabela.querySelectorAll('tbody tr');
        linhas.forEach(function (linha) {
            var texto = linha.textContent.toLowerCase();
            linha.style.display = texto.indexOf(termo) > -1 ? '' : 'none';
        });
    }
    document.getElementById('btnPesquisar').addEventListener('click', filtrarTabela);
    document.getElementById('pesquisarContato').addEventListener('keyup', filtrarTabela);

    // ===== NOVO CONTATO =====
    document.getElementById('btnNovoContato').addEventListener('click', function () {
        form.reset();
        document.getElementById('contatoId').value = '';
        tituloModal.textContent = 'Adicionar Contato';
        abrirModal();
    });

    // ===== FECHAR MODAL =====
    document.getElementById('btnFecharModal').addEventListener('click', fecharModal);
    document.getElementById('btnCancelarModal').addEventListener('click', fecharModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) fecharModal(); // clicou fora da caixa
    });

    // ===== EDITAR (delegação de evento) =====
    tabela.addEventListener('click', function (e) {
        var btn = e.target.closest('.btnEditar');
        if (!btn) return;

        var linha = btn.closest('tr');

        document.getElementById('contatoId').value = linha.dataset.id;
        document.getElementById('inputNome').value  = linha.querySelector('.col-nome').textContent;
        document.getElementById('inputSetor').value = linha.querySelector('.col-setor').textContent;
        document.getElementById('inputRamal').value = linha.querySelector('.col-ramal').textContent;
        document.getElementById('inputEmail').value = linha.querySelector('.col-email').textContent;

        tituloModal.textContent = 'Editar Contato';
        abrirModal();
    });

    // ===== EXCLUIR (delegação de evento) =====
    tabela.addEventListener('click', function (e) {
        var btn = e.target.closest('.btnExcluir');
        if (!btn) return;

        var linha = btn.closest('tr');
        var id = linha.dataset.id;

        if (!confirm('Tem certeza que deseja excluir este contato?')) return;

        var dados = new URLSearchParams();
        dados.append('acao', 'excluir');
        dados.append('id', id);

        fetch(urlAcoes, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: dados
        })
        .then(function (resp) { return resp.json(); })
        .then(function (resposta) {
            if (resposta.sucesso) {
                linha.remove();
            } else {
                alert(resposta.mensagem);
            }
        })
        .catch(function () {
            alert('Erro ao comunicar com o servidor.');
        });
    });

    // ===== SALVAR (INSERIR OU ALTERAR) =====
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var id = document.getElementById('contatoId').value;
        var acao = id ? 'alterar' : 'inserir';

        var dados = new URLSearchParams(new FormData(form));
        dados.append('acao', acao);

        fetch(urlAcoes, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: dados
        })
        .then(function (resp) { return resp.json(); })
        .then(function (resposta) {
            if (resposta.sucesso) {
                fecharModal();
                location.reload();
            } else {
                alert(resposta.mensagem);
            }
        })
        .catch(function () {
            alert('Erro ao comunicar com o servidor.');
        });
    });

});
</script>