<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="referrer" content="no-referrer">
  <title>Painel de Inventário Escolar</title>
  <style>
    :root { color-scheme: dark; --bg:#090d16; --card:#151e2e; --line:#263248; --text:#f8fafc; --muted:#94a3b8; --blue:#38bdf8; --green:#10b981; --orange:#f59e0b; --red:#ef4444; }
    * { box-sizing:border-box; }
    html,body { width:100%; min-height:100%; margin:0; background:radial-gradient(circle at 50% 0,#172554 0,var(--bg) 62%); color:var(--text); font-family:system-ui,-apple-system,"Segoe UI",sans-serif; }
    body { min-height:100vh; }
    .topo { display:flex; align-items:center; justify-content:space-between; padding:20px 4vw; border-bottom:1px solid #ffffff16; background:#090d16bb; }
    .marca { display:flex; gap:16px; align-items:center; }
    .tag { padding:7px 14px; border-radius:9px; background:linear-gradient(135deg,#2563eb,var(--blue)); font-weight:800; letter-spacing:1px; }
    .titulo { font-size:clamp(18px,2vw,28px); font-weight:750; }
    .status { display:flex; gap:18px; align-items:center; color:var(--muted); }
    .aviso { color:var(--orange); font-weight:650; }
    .slide { display:none; min-height:calc(100vh - 86px); padding:28px 4vw 42px; flex-direction:column; gap:22px; }
    .slide.ativo { display:flex; }
    .slide-header { display:flex; justify-content:space-between; align-items:end; gap:18px; }
    h1 { margin:0; font-size:clamp(24px,3vw,38px); letter-spacing:-.5px; }
    .subtitulo { margin:0; color:var(--muted); font-size:16px; }
    .cards { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:16px; }
    .card,.painel { background:linear-gradient(145deg,#182337,var(--card)); border:1px solid var(--line); border-radius:18px; box-shadow:0 14px 36px #0005; }
    .card { min-height:176px; padding:22px; position:relative; overflow:hidden; }
    .card:before { content:""; position:absolute; inset:0 auto 0 0; width:5px; background:var(--accent,var(--blue)); }
    .label { color:var(--muted); text-transform:uppercase; font-size:13px; letter-spacing:.7px; font-weight:700; }
    .valor { margin:17px 0 7px; font-size:clamp(34px,4vw,58px); font-weight:850; line-height:1; font-variant-numeric:tabular-nums; }
    .detalhe { color:#cbd5e1; font-size:14px; }
    .indicadores { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:16px; }
    .indicador { padding:18px 22px; display:flex; justify-content:space-between; align-items:center; gap:12px; }
    .indicador strong { font-size:clamp(20px,2.5vw,30px); }
    .indicador span { color:var(--muted); }
    .grafico { flex:1; min-height:420px; padding:22px 26px; }
    .grafico canvas { width:100%!important; height:100%!important; }
    .pos { border:1px solid #334155; border-radius:999px; padding:6px 14px; white-space:nowrap; }
    .barra { position:fixed; left:0; bottom:0; height:6px; width:0; z-index:3; background:linear-gradient(90deg,#2563eb,var(--blue)); }
    @media(max-width:900px) { .cards { grid-template-columns:repeat(2,minmax(0,1fr)); } .card:last-child { grid-column:span 2; } .slide { padding:22px 4vw 32px; } .grafico { min-height:55vh; } .indicadores { grid-template-columns:1fr; } }
    @media(max-width:600px) { .topo { padding:14px 4vw; align-items:flex-start; gap:10px; } .status { align-items:flex-end; flex-direction:column; gap:4px; font-size:12px; } .titulo { max-width:45vw; } .cards { gap:10px; } .card { padding:16px; min-height:140px; } .valor { font-size:36px; } .slide-header { align-items:flex-start; flex-direction:column; } .grafico { padding:14px; min-height:58vh; } }
  </style>
</head>
<body>
  <header class="topo">
    <div class="marca"><span class="tag">SVI</span><span class="titulo">Inventário Geral das Escolas</span></div>
    <div class="status"><span id="aviso" class="aviso" aria-live="polite"></span><span>Atualizado às <strong id="hora">--:--</strong></span><strong class="pos" id="pos">Slide 1 de 3</strong></div>
  </header>

  <main>
    <section class="slide ativo" id="s0">
      <div class="slide-header"><h1>Visão geral</h1><p class="subtitulo">Condição atual do inventário escolar</p></div>
      <div class="cards">
        <article class="card" style="--accent:#a855f7"><div class="label">Escolas</div><div class="valor" id="c-escolas">—</div><div class="detalhe">com equipamentos cadastrados</div></article>
        <article class="card" style="--accent:var(--blue)"><div class="label">Equipamentos</div><div class="valor" id="c-total">—</div><div class="detalhe">total no inventário</div></article>
        <article class="card" style="--accent:var(--green)"><div class="label">Disponíveis</div><div class="valor" id="c-disp">—</div><div class="detalhe" id="c-disp-pct">—</div></article>
        <article class="card" style="--accent:var(--orange)"><div class="label">Manutenção</div><div class="valor" id="c-manu">—</div><div class="detalhe" id="c-manu-pct">—</div></article>
        <article class="card" style="--accent:var(--red)"><div class="label">Inservíveis</div><div class="valor" id="c-inserv">—</div><div class="detalhe" id="c-inserv-pct">—</div></article>
      </div>
      <div class="indicadores">
        <article class="painel indicador"><span>Disponibilidade</span><strong id="taxa-disponibilidade">—</strong></article>
        <article class="painel indicador"><span>Equipamentos que exigem ação</span><strong id="total-atencao">—</strong></article>
        <article class="painel indicador"><span>Média por escola</span><strong id="media-escola">—</strong></article>
      </div>
    </section>

    <section class="slide" id="s1">
      <div class="slide-header"><div><h1>Escolas prioritárias</h1><p class="subtitulo">Maior percentual de equipamentos em manutenção ou inservíveis</p></div><span class="pos">Prioridade de atendimento</span></div>
      <div class="painel grafico"><canvas id="g-criticas" role="img" aria-label="Ranking de escolas com maior percentual de equipamentos problemáticos"></canvas></div>
    </section>

    <section class="slide" id="s2">
      <div class="slide-header"><div><h1>Condição por categoria</h1><p class="subtitulo">Equipamentos disponíveis, em manutenção, inservíveis e sem classificação</p></div><span class="pos">Planejamento de renovação</span></div>
      <div class="painel grafico"><canvas id="g-tipos" role="img" aria-label="Equipamentos por categoria e condição"></canvas></div>
    </section>
  </main>
  <div class="barra" id="barra" aria-hidden="true"></div>

  <script src="<?= base_url('assets/js/chart.umd.min.js') ?>"></script>
  <script>
    const TEMPO_SLIDE = 15000;
    const TEMPO_DADOS = 180000;
    const TEMPO_RELOAD = 43200000;
    const token = new URLSearchParams(location.hash.slice(1)).get('t') || '';
    window.history.replaceState(null, '', window.location.pathname);
    const urlDados = <?= json_encode(base_url('painel/dados'), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const slides = Array.from(document.querySelectorAll('.slide'));
    const charts = {};
    const fmt = value => (Number(value) || 0).toLocaleString('pt-BR');
    const num = value => Number(value) || 0;
    let current = 0;

    Chart.defaults.color = '#cbd5e1';
    Chart.defaults.font.family = 'system-ui,-apple-system,"Segoe UI",sans-serif';
    Chart.defaults.font.size = 15;

    function setChart(id, config) {
      if (charts[id]) charts[id].destroy();
      const canvas = document.getElementById(id);
      if (canvas) charts[id] = new Chart(canvas, config);
    }

    function render(data) {
      const summary = data.resumo || {};
      const total = num(summary.total);
      const schools = num(summary.escolas);
      const available = num(summary.disponiveis);
      const maintenance = num(summary.manutencao);
      const unusable = num(summary.inserviveis);
      document.getElementById('c-escolas').textContent = fmt(schools);
      document.getElementById('c-total').textContent = fmt(total);
      document.getElementById('c-disp').textContent = fmt(available);
      document.getElementById('c-manu').textContent = fmt(maintenance);
      document.getElementById('c-inserv').textContent = fmt(unusable);
      document.getElementById('c-disp-pct').textContent = total ? (available / total * 100).toFixed(1) + '% do total' : '0% do total';
      document.getElementById('c-manu-pct').textContent = total ? (maintenance / total * 100).toFixed(1) + '% do total' : '0% do total';
      document.getElementById('c-inserv-pct').textContent = total ? (unusable / total * 100).toFixed(1) + '% do total' : '0% do total';
      document.getElementById('taxa-disponibilidade').textContent = total ? (available / total * 100).toFixed(1) + '%' : '0%';
      document.getElementById('total-atencao').textContent = fmt(maintenance + unusable);
      document.getElementById('media-escola').textContent = schools ? fmt(Math.round(total / schools)) : '0';
      document.getElementById('hora').textContent = data.atualizado || '--:--';

      const critical = Array.isArray(data.criticas) ? data.criticas : [];
      setChart('g-criticas', {
        type: 'bar',
        data: {
          labels: critical.map(row => row.nome || 'Escola'),
          datasets: [{ label: 'Equipamentos com problema (%)', data: critical.map(row => num(row.pct)), backgroundColor: critical.map(row => num(row.pct) >= 50 ? '#ef4444' : (num(row.pct) >= 25 ? '#f59e0b' : '#38bdf8')), borderRadius: 7, maxBarThickness: 34 }]
        },
        options: {
          indexAxis: 'y', responsive: true, maintainAspectRatio: false,
          plugins: { legend: { display: false }, tooltip: { callbacks: { label: item => item.formattedValue + '% (' + fmt(critical[item.dataIndex].problema) + ' equipamentos)' } } },
          scales: { x: { min: 0, max: 100, ticks: { callback: value => value + '%' }, grid: { color: '#ffffff12' } }, y: { grid: { display: false } } }
        }
      });

      const types = Array.isArray(data.tipos) ? data.tipos : [];
      setChart('g-tipos', {
        type: 'bar',
        data: {
          labels: types.map(row => row.tipo || 'Sem categoria'),
          datasets: [
            { label: 'Disponíveis', data: types.map(row => num(row.disponiveis)), backgroundColor: '#10b981', borderRadius: 5 },
            { label: 'Manutenção', data: types.map(row => num(row.manutencao)), backgroundColor: '#f59e0b', borderRadius: 5 },
            { label: 'Inservíveis', data: types.map(row => num(row.inserviveis)), backgroundColor: '#ef4444', borderRadius: 5 },
            { label: 'Sem classificação/outros', data: types.map(row => num(row.outros)), backgroundColor: '#64748b', borderRadius: 5 }
          ]
        },
        options: {
          indexAxis: 'y', responsive: true, maintainAspectRatio: false,
          plugins: { legend: { display: true, position: 'top' }, tooltip: { callbacks: { afterBody: items => items.length ? 'Total: ' + fmt(types[items[0].dataIndex].total) : '' } } },
          scales: { x: { stacked: true, ticks: { callback: value => fmt(value) }, grid: { color: '#ffffff12' } }, y: { stacked: true, grid: { display: false } } }
        }
      });
    }

    async function carregar() {
      const aviso = document.getElementById('aviso');
      if (!token) {
        aviso.textContent = 'Acesso: informe o segredo no fragmento #t= da URL';
        return;
      }
      try {
        const response = await fetch(urlDados, { cache: 'no-store', credentials: 'omit', headers: { Authorization: 'Bearer ' + token } });
        if (!response.ok) throw new Error('request failed');
        render(await response.json());
        aviso.textContent = '';
      } catch (error) {
        aviso.textContent = 'Sem acesso ou conexão';
      }
    }

    function mostrar(index) {
      slides.forEach((slide, i) => slide.classList.toggle('ativo', i === index));
      document.getElementById('pos').textContent = 'Slide ' + (index + 1) + ' de ' + slides.length;
      const bar = document.getElementById('barra');
      bar.style.transition = 'none';
      bar.style.width = '0%';
      void bar.offsetWidth;
      bar.style.transition = 'width ' + TEMPO_SLIDE + 'ms linear';
      bar.style.width = '100%';
    }

    carregar();
    mostrar(0);
    setInterval(() => { current = (current + 1) % slides.length; mostrar(current); }, TEMPO_SLIDE);
    setInterval(carregar, TEMPO_DADOS);
    setTimeout(() => location.reload(), TEMPO_RELOAD);
  </script>
</body>
</html>