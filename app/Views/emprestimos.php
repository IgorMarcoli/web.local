<div class="modal fade" id="modal-novo-emprestimos">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form action="/emprestimos/salvar" method="post">

<div class="modal-header">
<h4 class="modal-title">Novo Empréstimo</h4>
<button type="button" class="close" data-dismiss="modal">
<span>&times;</span>
</button>
</div>

<div class="modal-body">
<div class="row">

<div class="col-4">
<div class="form-group">
<label>ID do Kit</label>
<select name="numero_mochila" class="form-control" required>
<option value="">Selecione</option>
<?php foreach ($availableMochilas as $mochila): ?>
<option value="<?= esc($mochila) ?>"><?= esc($mochila) ?></option>
<?php endforeach; ?>
</select>
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Nome do Solicitante</label>
<input type="text" id="nome-solicitante" name="nome_recebedor" class="form-control" required autocomplete="off">
<div id="lista-solicitantes" class="list-group position-absolute w-100" style="z-index:999; max-height:180px; overflow:auto;"></div>
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Email do Solicitante</label>
<input type="email" name="email_recebedor" class="form-control" required>
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Setor</label>
<input type="text" id="setor-display" class="form-control" readonly placeholder="Será preenchido automaticamente">
<input type="hidden" name="setor" id="setor" value="">
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Nome do Responsável SEITEC/SETEC</label>
<input type="text" id="nome-responsavel" name="nome_responsavel" class="form-control" required autocomplete="off">
<div id="lista-responsaveis" class="list-group position-absolute w-100" style="z-index:999; max-height:180px; overflow:auto;"></div>
</div>
</div>

<div class="col-4">
<div class="form-group">
<div class="d-flex align-items-center" style="height: 38px;">
<label class="mb-0 mr-2">Chamado aberto?</label>
<div class="custom-control custom-checkbox custom-control-inline mb-0">
<input type="checkbox" class="custom-control-input" id="status-equipamento" name="status_equipamento" value="chamado aberto">
<label class="custom-control-label" for="status-equipamento"></label>
</div>
</div>
</div>
</div>

<div class="col-4" id="container-numero-chamado" style="display:none;">
<div class="form-group">
<label>Número do Chamado</label>
<input type="number" name="numero_chamado" id="numero-chamado" class="form-control">
</div>
</div>

<div class="col-12">
<div class="form-group">
<label id="obs-label">Observações</label>
<textarea name="obs" class="form-control" rows="3"></textarea>
</div>
</div>

</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
</div>
</form>
</div>
</div>
</div>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Empréstimos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Empréstimos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-novo-emprestimos">
                        <i class="fas fa-plus-circle"></i> Novo Empréstimo
                    </button>
                </div>
            </div>

            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successCreate') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Empréstimo cadastrado com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['alert']) && $_GET['alert'] == 'successEdit') : ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="removerParametroAlerta()">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                            Empréstimo editado com sucesso!
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="col-12">
                    <form method="get" action="/emprestimos" class="form-inline flex-wrap">
                        <select name="nome_recebedor" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todos os solicitantes</option>
                            <?php foreach ($nomeRecebedores as $nome): ?>
                                <option value="<?= esc($nome) ?>" <?= ($filtros['nome_recebedor'] ?? '') === $nome ? 'selected' : '' ?>><?= esc($nome) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="nome_responsavel" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todos os responsáveis</option>
                            <?php foreach ($nomeResponsaveis as $nome): ?>
                                <option value="<?= esc($nome) ?>" <?= ($filtros['nome_responsavel'] ?? '') === $nome ? 'selected' : '' ?>><?= esc($nome) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="date" name="data_emprestimo" class="form-control form-control-sm mr-2 mb-2" value="<?= esc($filtros['data_emprestimo'] ?? '') ?>" title="Data de recebimento">
                        <input type="date" name="data_devolucao" class="form-control form-control-sm mr-2 mb-2" value="<?= esc($filtros['data_devolucao'] ?? '') ?>" title="Data de devolução">

                        <select name="secao" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todas as seções</option>
                            <?php foreach ($sessoes as $s): ?>
                                <option value="<?= $s['secaoID'] ?>" <?= ($filtros['secao'] ?? '') == $s['secaoID'] ? 'selected' : '' ?>><?= esc($s['nomeSecao']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="status" class="form-control form-control-sm mr-2 mb-2">
                            <option value="">Todos os status</option>
                            <?php foreach ($statusOptions as $status): ?>
                                <option value="<?= esc($status) ?>" <?= ($filtros['status'] ?? '') == $status ? 'selected' : '' ?>><?= esc($status) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn btn-sm btn-primary mr-2 mb-2">Filtrar</button>
                        <a href="/emprestimos" class="btn btn-sm btn-outline-secondary mb-2">Limpar</a>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ID do Kit</th>
                                            <th>Setor</th>
                                            <th>Nome Solicitante</th>
                                            <th>Email Solicitante</th>
                                            <th>Responsável SEINTEC/SETEC</th>
                                            <th>Status</th>
                                            <th>Número Chamado</th>
                                            <th>Data Recebimento</th>
                                            <th>Data Devolução</th>
                                            <th>Duração de Empréstimo</th>
                                            <th>Obs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($emprestimos as $e): ?>
                                            <tr>
                                                <td><?= esc($e['id_emprestimo'] ?? '-') ?></td>
                                                <td><?= esc($e['numero_mochila']) ?></td>
                                                <td><?= esc($e['setor_display'] ?? '-') ?></td>
                                                <td><?= esc($e['nome_recebedor']) ?></td>
                                                <td><?= esc($e['email_recebedor']) ?></td>
                                                <td><?= esc($e['nome_responsavel']) ?></td>
                                                <td><?= esc($e['status_equipamento']) ?></td>
                                                <td><?= esc($e['numero_chamado']) ?></td>
                                                <td><?= esc($e['data_emprestimo']) ?></td>
                                                <td>
                                                    <?php $dataDevolucao = $e['data_devolucao'] ?? '';
                                                    $devolucaoEhPadrao = $dataDevolucao === '0000-00-00 00:00:00' || $dataDevolucao === '0000-00-00';
                                                    if (!empty($dataDevolucao) && !$devolucaoEhPadrao): ?>
                                                        <?= esc($dataDevolucao) ?>
                                                    <?php else: ?>
                                                        <form method="post" action="/emprestimos/salvarDataDevolucao" class="d-flex align-items-center">
                                                            <?= csrf_field() ?>
                                                            <input type="hidden" name="id_emprestimo" value="<?= esc($e['id_emprestimo'] ?? '') ?>">
                                                            <input type="hidden" name="data_devolucao" class="data-devolucao-valor" value="">
                                                            <button type="submit" class="btn btn-success btn-sm btn-liberar-devolucao" data-id="<?= esc($e['id_emprestimo'] ?? '') ?>">
                                                                Liberar
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="duracao-emprestimo" data-start="<?= esc($e['data_emprestimo']) ?>" data-end="<?= esc($e['data_devolucao'] ?? '') ?>"><?= esc($e['duracao_emprestimo']) ?></td>
                                                <td><?= esc($e['obs']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Resumo por mochila</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Status</th>
                                            <th>Duração</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($resumoMochilas)): ?>
                                            <?php foreach ($resumoMochilas as $resumo): ?>
                                                <tr>
                                                    <td><?= esc($resumo['numero'] ?? '-') ?></td>
                                                    <td><?= esc($resumo['status'] ?? '-') ?></td>
                                                    <td class="duracao-emprestimo" data-start="<?= esc($resumo['data_emprestimo'] ?? '') ?>" data-end="<?= esc($resumo['data_devolucao'] ?? '') ?>"><?= esc($resumo['duracao_emprestimo'] ?? '-') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Nenhuma mochila encontrada.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function removerParametroAlerta() {
        const url = new URL(window.location.href);
        url.searchParams.delete('alert');
        const newUrl = url.pathname + (url.search ? url.search : '');
        window.history.replaceState({}, document.title, newUrl);
    }

    window.removerParametroAlerta = removerParametroAlerta;

    document.addEventListener('DOMContentLoaded', function () {
        function atualizarLabelObservacoes(checkboxId, labelId) {
            const checkbox = document.getElementById(checkboxId);
            const label = document.getElementById(labelId);

            if (label) {
                label.textContent = checkbox && checkbox.checked ? 'Descrição do problema' : 'Observações';
            }
        }

        function toggleChamado(checkboxId, containerId, inputId, labelId) {
            const checkbox = document.getElementById(checkboxId);
            const container = document.getElementById(containerId);
            const input = document.getElementById(inputId);

            if (checkbox && checkbox.checked) {
                if (container) {
                    container.style.display = 'block';
                }
                if (input) {
                    input.required = true;
                }
            } else {
                if (container) {
                    container.style.display = 'none';
                }
                if (input) {
                    input.required = false;
                    input.value = '';
                }
            }

            atualizarLabelObservacoes(checkboxId, labelId);
        }

        const statusEquipamento = document.getElementById('status-equipamento');
        if (statusEquipamento) {
            statusEquipamento.addEventListener('change', function () {
                toggleChamado('status-equipamento', 'container-numero-chamado', 'numero-chamado', 'obs-label');
            });
        }

        toggleChamado('status-equipamento', 'container-numero-chamado', 'numero-chamado', 'obs-label');

        const servidoresData = <?= json_encode($servidores, JSON_UNESCAPED_UNICODE) ?>;
        const servidoresResponsavel = <?= json_encode($servidoresResponsavel, JSON_UNESCAPED_UNICODE) ?>;
        const nomeSolicitanteInput = document.getElementById('nome-solicitante');
        const nomeResponsavelInput = document.getElementById('nome-responsavel');
        const listaSolicitantes = document.getElementById('lista-solicitantes');
        const listaResponsaveis = document.getElementById('lista-responsaveis');
        const setorInput = document.getElementById('setor');
        const setorDisplayInput = document.getElementById('setor-display');

        function preencherSetor(servidor) {
            if (!setorInput || !setorDisplayInput) {
                return;
            }

            const secaoValor = servidor && servidor.secao !== undefined && servidor.secao !== null ? String(servidor.secao) : '';
            const servicoValor = servidor && servidor.servico !== undefined && servidor.servico !== null ? String(servidor.servico) : '';
            const secaoId = Number.parseInt(secaoValor, 10);
            const servicoId = Number.parseInt(servicoValor, 10);

            if (Number.isInteger(secaoId) && secaoId > 0 && servidor && servidor.secao_nome) {
                setorInput.value = 'secao:' + secaoId;
                setorDisplayInput.value = servidor.secao_nome;
            } else if (Number.isInteger(servicoId) && servicoId >= 0 && servidor && servidor.servico_nome) {
                setorInput.value = 'servico:' + servicoId;
                setorDisplayInput.value = servidor.servico_nome;
            } else {
                setorInput.value = '';
                setorDisplayInput.value = '';
            }
        }

        function preencherCamposServidor(servidor, campo) {
            if (!servidor) {
                return;
            }

            if (campo === 'solicitante' && nomeSolicitanteInput) {
                nomeSolicitanteInput.value = servidor.nome_completo || '';
                preencherSetor(servidor);
            }

            if (campo === 'responsavel' && nomeResponsavelInput) {
                nomeResponsavelInput.value = servidor.nome_completo || '';
            }
        }

        function mostrarSugestoes(texto, listaElemento, tipo) {
            if (!listaElemento) {
                return;
            }

            listaElemento.innerHTML = '';

            if (!texto) {
                return;
            }

            const fonte = tipo === 'responsavel' ? servidoresResponsavel : servidoresData;
            const filtradas = fonte.filter(function (item) {
                const nomeCompleto = (item.nome_completo || '').toLowerCase();
                return nomeCompleto.indexOf(texto) !== -1;
            });

            filtradas.slice(0, 8).forEach(function (item) {
                const itemLista = document.createElement('a');
                itemLista.className = 'list-group-item list-group-item-action';
                itemLista.href = '#';
                itemLista.textContent = item.nome_completo || '';
                itemLista.onclick = function (event) {
                    event.preventDefault();
                    preencherCamposServidor(item, tipo === 'responsavel' ? 'responsavel' : 'solicitante');
                    listaElemento.innerHTML = '';
                };
                listaElemento.appendChild(itemLista);
            });
        }

        if (nomeSolicitanteInput) {
            nomeSolicitanteInput.addEventListener('input', function () {
                const texto = this.value.trim().toLowerCase();
                mostrarSugestoes(texto, listaSolicitantes, 'solicitante');
                if (!texto) {
                    if (setorInput) {
                        setorInput.value = '';
                    }
                    if (setorDisplayInput) {
                        setorDisplayInput.value = '';
                    }
                    return;
                }

                if (setorInput) {
                    setorInput.value = '';
                }
                if (setorDisplayInput) {
                    setorDisplayInput.value = '';
                }
            });
        }

        if (nomeResponsavelInput) {
            nomeResponsavelInput.addEventListener('input', function () {
                const texto = this.value.trim().toLowerCase();
                mostrarSugestoes(texto, listaResponsaveis, 'responsavel');
            });
        }

        document.addEventListener('click', function (event) {
            if (nomeSolicitanteInput && listaSolicitantes && !nomeSolicitanteInput.contains(event.target) && !listaSolicitantes.contains(event.target)) {
                listaSolicitantes.innerHTML = '';
            }

            if (nomeResponsavelInput && listaResponsaveis && !nomeResponsavelInput.contains(event.target) && !listaResponsaveis.contains(event.target)) {
                listaResponsaveis.innerHTML = '';
            }
        });

        function formatarDataHoraParaInput(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}:00`;
        }

        document.querySelectorAll('.btn-liberar-devolucao').forEach(function (button) {
            button.addEventListener('click', function () {
                const form = button.closest('form');
                const hiddenInput = form ? form.querySelector('.data-devolucao-valor') : null;
                if (hiddenInput) {
                    hiddenInput.value = formatarDataHoraParaInput(new Date());
                }
            });
        });

        function formatarDuracao(totalSeconds) {
            if (totalSeconds < 60) {
                return 'menos de 1 minuto';
            }

            const totalMinutes = Math.floor(totalSeconds / 60);
            const years = Math.floor(totalMinutes / (365 * 24 * 60));
            let remainingMinutes = totalMinutes % (365 * 24 * 60);
            const months = Math.floor(remainingMinutes / (30 * 24 * 60));
            remainingMinutes = remainingMinutes % (30 * 24 * 60);
            const weeks = Math.floor(remainingMinutes / (7 * 24 * 60));
            remainingMinutes = remainingMinutes % (7 * 24 * 60);
            const days = Math.floor(remainingMinutes / (24 * 60));
            remainingMinutes = remainingMinutes % (24 * 60);
            const hours = Math.floor(remainingMinutes / 60);
            const minutes = remainingMinutes % 60;

            const parts = [];
            if (years > 0) {
                parts.push(years + ' ano' + (years > 1 ? 's' : ''));
            }
            if (months > 0) {
                parts.push(months + ' mês' + (months > 1 ? 'es' : ''));
            }
            if (weeks > 0) {
                parts.push(weeks + ' semana' + (weeks > 1 ? 's' : ''));
            }
            if (days > 0) {
                parts.push(days + ' dia' + (days > 1 ? 's' : ''));
            }
            if (hours > 0) {
                parts.push(hours + ' hora' + (hours > 1 ? 's' : ''));
            }
            if (minutes > 0) {
                parts.push(minutes + ' minuto' + (minutes > 1 ? 's' : ''));
            }

            if (parts.length === 0) {
                return '1 minuto';
            }

            return parts.join(' ');
        }

        function isLeapYear(year) {
            return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
        }

        function daysInMonth(year, month) {
            const map = [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            return map[month - 1];
        }

        function isValidCalendarDate(year, month, day, hour, minute, second) {
            if (year < 1 || month < 1 || month > 12 || day < 1 || day > 31 || hour < 0 || hour > 23 || minute < 0 || minute > 59 || second < 0 || second > 59) {
                return false;
            }

            if (day > daysInMonth(year, month)) {
                return false;
            }

            return true;
        }

        function toJulianDayNumber(year, month, day) {
            let a = Math.floor((14 - month) / 12);
            let y = year + 4800 - a;
            let m = month + 12 * a - 3;
            return day + Math.floor((153 * m + 2) / 5) + 365 * y + Math.floor(y / 4) - Math.floor(y / 100) + Math.floor(y / 400) - 32045;
        }

        function datePartsToSeconds(parts) {
            const jd = toJulianDayNumber(parts.year, parts.month, parts.day);
            return (jd * 86400) + (parts.hour * 3600) + (parts.minute * 60) + parts.second;
        }

        function parseDateTime(value) {
            if (!value) {
                return null;
            }

            const rawValue = String(value).trim();
            if (!rawValue) {
                return null;
            }

            if (rawValue === '0000-00-00 00:00:00' || rawValue === '0000-00-00') {
                return null;
            }

            const isoMatch = rawValue.match(/^\s*(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2}):(\d{2})(?:\.\d+)?(?:Z|[+-]\d{2}:?\d{2})?\s*$/);
            if (isoMatch) {
                const year = Number(isoMatch[1]);
                const month = Number(isoMatch[2]);
                const day = Number(isoMatch[3]);
                const hour = Number(isoMatch[4]);
                const minute = Number(isoMatch[5]);
                const second = Number(isoMatch[6]);

                if (!isValidCalendarDate(year, month, day, hour, minute, second)) {
                    return null;
                }

                return { year, month, day, hour, minute, second };
            }

            const brasilMatch = rawValue.match(/^\s*(\d{2})\/(\d{2})\/(\d{4})(?:\s+(\d{2}):(\d{2}):?(\d{2})?)?\s*$/);
            if (brasilMatch) {
                const day = Number(brasilMatch[1]);
                const month = Number(brasilMatch[2]);
                const year = Number(brasilMatch[3]);
                const hour = Number(brasilMatch[4] || 0);
                const minute = Number(brasilMatch[5] || 0);
                const second = Number(brasilMatch[6] || 0);

                if (!isValidCalendarDate(year, month, day, hour, minute, second)) {
                    return null;
                }

                return { year, month, day, hour, minute, second };
            }

            return null;
        }

        function atualizarDuracoes() {
            const now = new Date();
            const nowParts = {
                year: now.getFullYear(),
                month: now.getMonth() + 1,
                day: now.getDate(),
                hour: now.getHours(),
                minute: now.getMinutes(),
                second: now.getSeconds()
            };

            document.querySelectorAll('.duracao-emprestimo').forEach(function (cell) {
                const startValue = cell.getAttribute('data-start');
                const endValue = cell.getAttribute('data-end');
                const start = parseDateTime(startValue);
                const end = parseDateTime(endValue) || nowParts;

                if (!start) {
                    cell.textContent = '-';
                    return;
                }

                const diffSeconds = Math.max(0, datePartsToSeconds(end) - datePartsToSeconds(start));
                cell.textContent = formatarDuracao(diffSeconds);
            });
        }

        atualizarDuracoes();
        setInterval(atualizarDuracoes, 1000);
    });
</script>
