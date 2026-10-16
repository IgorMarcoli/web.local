<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comprovante de Atendimento - <?= esc($atendimento['numero_protocolo']) ?></title>
    <link rel="stylesheet" href="<?= base_url('tema/dist/css/adminlte.min.css') ?>">
    <style>
        body { background: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; }
        .comprovante {
            max-width: 780px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }
        .header-print {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 20px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .num-protocolo {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #0284c7;
            font-family: monospace;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 25px;
        }
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 16px;
        }
        .info-box label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            margin-bottom: 4px;
            display: block;
            font-weight: 700;
        }
        .info-box span {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }
        .campo-descricao {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 40px;
        }
        .assinaturas {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            padding-top: 20px;
        }
        .linha-assinatura {
            text-align: center;
            width: 45%;
            border-top: 1px solid #0f172a;
            padding-top: 8px;
            font-size: 13px;
            color: #334155;
            font-weight: 600;
        }
        @media print {
            body { background: #fff; }
            .comprovante { box-shadow: none; border: none; margin: 0; padding: 20px; }
            .btn-imprimir { display: none; }
        }
    </style>
</head>
<body>

<div class="comprovante">
    <div class="header-print">
        <div>
            <h4 class="mb-1 font-weight-bold text-dark">GOVERNO DO ESTADO DE SÃO PAULO</h4>
            <div class="text-muted font-weight-bold">UNIDADE REGIONAL DE ENSINO DE SÃO VICENTE — URE SVI</div>
            <div class="text-muted small">SETOR DE PROTOCOLO E ATENDIMENTO AO PÚBLICO</div>
        </div>
        <div class="text-right">
            <span class="d-block small text-muted font-weight-bold">COMPROVANTE DE PROTOCOLO</span>
            <span class="num-protocolo"><?= esc($atendimento['numero_protocolo']) ?></span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <label>Solicitante</label>
            <span><?= esc($atendimento['nome_solicitante']) ?></span>
        </div>
        <div class="info-box">
            <label>Documento (RG / CPF)</label>
            <span><?= esc($atendimento['documento'] ?: 'Não informado') ?></span>
        </div>
        <div class="info-box">
            <label>Telefone / Contato</label>
            <span><?= esc($atendimento['telefone'] ?: 'Não informado') ?></span>
        </div>
        <div class="info-box">
            <label>E-mail</label>
            <span><?= esc($atendimento['email'] ?: 'Não informado') ?></span>
        </div>
        <div class="info-box">
            <label>Assunto / Motivo</label>
            <span><?= esc($atendimento['assunto']) ?></span>
        </div>
        <div class="info-box">
            <label>Setor de Encaminhamento / Destino</label>
            <span><?= esc($atendimento['setor_destino'] ?: 'Protocolo Geral') ?></span>
        </div>
        <div class="info-box">
            <label>Data e Horário</label>
            <span><?= esc($atendimento['data_atendimento'] ?: date('d/m/Y H:i', strtotime($atendimento['created_at'] ?? 'now'))) ?></span>
        </div>
        <div class="info-box">
            <label>Atendido Por (Servidor Responsável)</label>
            <span><?= esc($atendimento['atendido_por'] ?: 'Protocolo') ?></span>
        </div>
    </div>

    <div class="campo-descricao">
        <label class="d-block text-muted small text-uppercase font-weight-bold mb-2">Descrição / Observações Registradas</label>
        <div style="font-size: 14px; color: #1e293b; min-height: 50px;">
            <?= nl2br(esc($atendimento['descricao'] ?: 'Atendimento protocolado e registrado para as devidas providências.')) ?>
        </div>
    </div>

    <div class="assinaturas">
        <div class="linha-assinatura">
            Assinatura do Solicitante
        </div>
        <div class="linha-assinatura">
            <?= esc($atendimento['atendido_por'] ?: 'Protocolo URE - SVI') ?><br>
            <span class="text-muted small">Responsável pelo Atendimento</span>
        </div>
    </div>

    <div class="text-center mt-5 btn-imprimir">
        <button type="button" class="btn btn-primary px-4 shadow" onclick="window.print()">
            <i class="fas fa-print mr-1"></i> Imprimir Comprovante
        </button>
        <button type="button" class="btn btn-secondary px-3 ml-2" onclick="window.close()">
            Fechar Janela
        </button>
    </div>
</div>

</body>
</html>

