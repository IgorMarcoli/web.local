<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Meu Perfil</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'success') : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                    Perfil atualizado com sucesso!
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">

                        <!-- foto atual -->
                        <div class="card-body text-center">
<?php if (!empty($usuario['foto'])) : ?>
    <img src="<?= esc($usuario['foto']) ?>"
         class="img-circle elevation-2"
         style="width:120px; height:120px; object-fit:cover;">
<?php else : ?>
    <img src="<?= base_url('tema/dist/img/user2-160x160.jpg') ?>"
         class="img-circle elevation-2"
         style="width:120px; height:120px; object-fit:cover;">
<?php endif; ?>
                            <h4 class="mt-2"><?= esc($usuario['Nomeuser']) ?></h4>
                            <p class="text-muted"><?= esc($usuario['Usuario']) ?></p>
                        </div>

                        <!-- formulário -->
                        <div class="card-footer">
                            <form action="/perfil/atualizar" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>Foto de perfil</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto"
                                                   id="inputFoto" accept="image/*">
                                            <label class="custom-file-label" for="inputFoto">
                                                Escolher foto
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control"
                                           name="Nomeuser" value="<?= esc($usuario['Nomeuser']) ?>">
                                </div>

                                <div class="form-group">
                                    <label>Nova senha</label>
                                    <input type="password" class="form-control"
                                           name="Senha" placeholder="Deixe em branco para não alterar">
                                </div>

                                <div class="form-group">
                                    <label>Confirmar nova senha</label>
                                    <input type="password" class="form-control"
                                           id="confirmarSenha" placeholder="Repita a nova senha">
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Salvar alterações
                                </button>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// preview da foto antes de enviar
document.getElementById('inputFoto').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.img-circle').src = e.target.result;
        };
        reader.readAsDataURL(file);
        // atualiza label do input
        document.querySelector('.custom-file-label').textContent = file.name;
    }
});

// valida se as senhas batem antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    const senha = document.querySelector('[name="Senha"]').value;
    const confirmar = document.getElementById('confirmarSenha').value;

    if (senha && senha !== confirmar) {
        e.preventDefault();
        alert('As senhas não coincidem!');
    }
});
</script>