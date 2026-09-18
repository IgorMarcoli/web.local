<style>
    .proati-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }
    .proati-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        color: inherit;
    }
    .proati-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e9ecef;
    }
    .proati-avatar-fallback {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 3px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f1f3f5;
        color: #adb5bd;
        font-size: 2.6rem;
        margin: 0 auto;
    }
    .proati-badge-perfil {
        font-size: 0.72rem;
        letter-spacing: 0.03em;
    }
    .proati-info-line {
        font-size: 0.85rem;
        color: #6c757d;
    }
    .empty-state {
        padding: 45px 15px;
        text-align: center;
    }
    .empty-state i {
        font-size: 3.2rem;
        color: #ced4da;
        margin-bottom: 12px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-user-shield text-info mr-2"></i> PROATIs
                    </h1>
                </div>
                <div class="col-auto">
                    <span class="badge badge-info badge-pill px-3 py-2">
                        <?= count($proatis) ?> <?= (count($proatis) === 1) ? 'PROATI' : 'PROATIs' ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row mb-3">
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" id="pesquisarProati" placeholder="Nome ou escola...">
                    </div>
                </div>
            </div>

            <div class="row" id="grid-proatis">
                <?php if (!empty($proatis)) : ?>
                    <?php foreach ($proatis as $p) : ?>
                        <div class="col-6 col-md-4 col-lg-3 mb-4 item-proati">
                            <a href="/proatis/escola/<?= esc($p['EscolaId'] ?? '', 'url') ?>"
                               class="card proati-card shadow-sm"
                               title="Ver detalhes da escola (em breve)">
                                <div class="card-body text-center">

                                    <?php if (!empty($p['Foto'])) : ?>
                                        <img src="<?= esc($p['Foto']) ?>" alt="Foto de <?= esc($p['Nome'] ?? '') ?>" class="proati-avatar mb-2">
                                    <?php else : ?>
                                        <div class="proati-avatar-fallback mb-2">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                    <?php endif; ?>

                                    <h6 class="font-weight-bold text-dark mb-1 mt-2">
                                        <?= esc($p['nome'] ?? '-') ?>
                                    </h6>

                                    <span class="badge badge-info proati-badge-perfil mb-2">
                                        <?= esc($p['perfil'] ?? 'PROATI') ?>
                                    </span>

                                    <div class="proati-info-line text-truncate">
                                        <i class="fas fa-school mr-1"></i>
                                        <?= esc($p['NomeEscola'] ?? 'Escola não vinculada') ?>
                                    </div>

                                    <?php if (!empty($p['email'])) : ?>
                                        <div class="proati-info-line text-truncate">
                                            <i class="fas fa-envelope mr-1"></i><?= esc($p['email']) ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($p['telefone'])) : ?>
                                        <div class="proati-info-line">
                                            <i class="fas fa-phone mr-1"></i><?= esc($p['telefone']) ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="empty-state">
                                <i class="fas fa-user-slash"></i>
                                <h5 class="text-secondary font-weight-bold">Nenhum PROATI encontrado</h5>
                                <p class="text-muted mb-0">Não há usuários com perfil PROATI cadastrados na tabela login.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('pesquisarProati');
        if (input) {
            input.addEventListener('keyup', function () {
                const filtro = this.value.toLowerCase().trim();
                document.querySelectorAll('#grid-proatis .item-proati').forEach(function (item) {
                    const texto = item.textContent.toLowerCase();
                    item.style.display = texto.includes(filtro) ? '' : 'none';
                });
            });
        }
    });
</script>