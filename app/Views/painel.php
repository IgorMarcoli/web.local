<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="referrer" content="no-referrer">
  <title>Painel de Inventário Escolar - SVI</title>
  <style>
    :root {
      color-scheme: dark;
      --bg: #090d16;
      --card: #151e2e;
      --line: #263248;
      --text: #f8fafc;
      --muted: #94a3b8;
      --blue: #38bdf8;
      --green: #10b981;
      --orange: #f59e0b;
      --red: #ef4444;
      --purple: #a855f7;
    }
    * { box-sizing: border-box; }
    html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      background: radial-gradient(circle at 50% 0, #172554 0, var(--bg) 62%);
      color: var(--text);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
      overflow: hidden;
      user-select: none;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    .topo {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 4vw;
      border-bottom: 1px solid rgba(255, 255, 255, 0.09);
      background: rgba(9, 13, 22, 0.85);
      backdrop-filter: blur(12px);
      height: 80px;
      flex-shrink: 0;
    }
    .marca { display: flex; gap: 14px; align-items: center; }
    .tag {
      padding: 6px 14px;
      border-radius: 8px;
      background: linear-gradient(135deg, #2563eb, var(--blue));
      font-weight: 800;
      font-size: 15px;
      letter-spacing: 1px;
    }
    .titulo { font-size: clamp(18px, 2vw, 26px); font-weight: 750; }
    .status { display: flex; gap: 18px; align-items: center; color: var(--muted); font-size: 17px; }
    .aviso { color: var(--orange); font-weight: 650; }
    main {
      flex: 1;
      position: relative;
      overflow: hidden;
    }
    .slide {
      display: none;
      height: 100%;
      padding: 24px 4vw 36px;
      flex-direction: column;
      gap: 20px;
      opacity: 0;
      transition: opacity 0.35s ease-in-out;
    }
    .slide.ativo {
      display: flex;
      opacity: 1;
    }
    .slide-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      gap: 16px;
      flex-shrink: 0;
    }
    h1 { margin: 0; font-size: clamp(24px, 2.6vw, 36px); letter-spacing: -.5px; }
    .subtitulo { margin: 0; color: var(--muted); font-size: 16px; }
    .cards {
      display: grid;
      grid-template-columns: repeat(5, minmax(0, 1fr));
      gap: 18px;
    }
    .card, .painel {
      background: linear-gradient(145deg, #182337, var(--card));
      border: 1px solid var(--line);
      border-radius: 18px;
      box-shadow: 0 14px 36px rgba(0, 0, 0, 0.35);
    }
    .card {
      min-height: 165px;
      padding: 24px;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .card:before {
      content: "";
      position: absolute;
      inset: 0 auto 0 0;
      width: 6px;
      background: var(--accent, var(--blue));
    }
    .label {
      color: var(--muted);
      text-transform: uppercase;
      font-size: 14px;
      letter-spacing: .8px;
      font-weight: 700;
    }
    .valor {
      margin: 12px 0 6px;
      font-size: clamp(38px, 4.2vw, 64px);
      font-weight: 850;
      line-height: 1;
      font-variant-numeric: tabular-nums;
    }
    .detalhe { color: #cbd5e1; font-size: 15px; font-weight: 500; }
    .indicadores {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
    }
    .indicador {
      padding: 20px 26px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 14px;
    }
    .indicador strong { font-size: clamp(22px, 2.5vw, 32px); font-weight: 800; }
    .indicador span { color: var(--muted); font-size: 17px; }
    .grafico-container {
      flex: 1;
      min-height: 0;
      padding: 20px 28px;
      position: relative;
    }
    .grafico-container canvas {
      width: 100% !important;
      height: 100% !important;
    }
    .pos {
      border: 1px solid #334155;
      border-radius: 999px;
      padding: 6px 16px;
      white-space: nowrap;
      font-size: 16px;
      font-weight: 600;
      color: var(--blue);
    }
    .barra {
      position: fixed;
      left: 0;
      bottom: 0;
      height: 7px;
      width: 0;
      z-index: 100;
      background: linear-gradient(90deg, #2563eb, var(--blue));
    }
  </style>
</head>
<body>
  <header class="topo">
    <div class="marca">
      <span class="tag">SVI</span>
      <span class="titulo">Inventário Geral das Escolas</span>
    </div>
    <div class="status">
      <span id="aviso" class="aviso" aria-live="polite"></span>
      <span>Atualizado às <strong id="hora" style="color: #fff;">--:--</strong></span>
      <strong class="pos" id="pos">Slide 1 de 3</strong>
    </div>
  </header>

  <main>
    <!-- Slide 0: Resumo Geral -->
    <section class="slide ativo" id="s0">
      <div class="slide-header">
        <div>
          <h1>Visão Geral do Parque Tecnológico</h1>
          <p class="subtitulo">Condição atual do inventário em todas as escolas</p>
        </div>
      </div>
      <div class="cards">
        <article class="card" style="--accent: var(--purple)">
          <div class="label">Escolas 🏫</div>
          <div class="valor" id="c-escolas" style="color: #c084fc;">—</div>
          <div class="detalhe">unidades cadastradas</div>
        </article>
        <article class="card" style="--accent: var(--blue)">
          <div class="label">Equipamentos 💻</div>
          <div class="valor" id="c-total" style="color: #60a5fa;">—</div>
          <div class="detalhe">total catalogado</div>
        </article>
        <article class="card" style="--accent: var(--green)">
          <div class="label">Disponíveis ✅</div>
          <div class="valor" id="c-disp" style="color: var(--green);">—</div>
          <div class="detalhe" id="c-disp-pct">—</div>
        </article>
        <article class="card" style="--accent: var(--orange)">
          <div class="label">Em Manutenção 🔧</div>
          <div class="valor" id="c-manu" style="color: var(--orange);">—</div>
          <div class="detalhe" id="c-manu-pct">—</div>
        </article>
        <article class="card" style="--accent: var(--red)">
          <div class="label">Inservíveis ⛔</div>
          <div class="valor" id="c-inserv" style="color: var(--red);">—</div>
          <div class="detalhe" id="c-inserv-pct">—</div>
        </article>
      </div>
      <div class="indicadores">
        <article class="painel indicador">
          <span>Taxa de Disponibilidade Geral</span>
          <strong id="taxa-disponibilidade" style="color: var(--green);">—</strong>
        </article>
        <article class="painel indicador">
          <span>Equipamentos que Exigem Ação</span>
          <strong id="total-atencao" style="color: var(--orange);">—</strong>
        </article>
        <article class="painel indicador">
          <span>Média por Escola</span>
          <strong id="media-escola" style="color: #fff;">—</strong>
        </article>
      </div>
    </section>

    <!-- Slide 1: Escolas Críticas -->
    <section class="slide" id="s1">
      <div class="slide-header">
        <div>
          <h1>Top 10 Escolas Prioritárias</h1>
          <p class="subtitulo">Maior percentual de equipamentos em manutenção ou inservíveis</p>
        </div>
        <span class="pos">Prioridade de Atendimento</span>
      </div>
      <div class="painel grafico-container">
        <canvas id="g-criticas" role="img" aria-label="Ranking de escolas com maior percentual de problemas"></canvas>
      </div>
    </section>

    <!-- Slide 2: Condição por Categoria -->
    <section class="slide" id="s2">
      <div class="slide-header">
        <div>
          <h1>Equipamentos por Categoria × Condição</h1>
          <p class="subtitulo">Distribuição proporcional dos principais tipos</p>
        </div>
        <span class="pos">Planejamento e Manutenção</span>
      </div>
      <div class="painel grafico-container">
        <canvas id="g-tipos" role="img" aria-label="Equipamentos por categoria e condição"></canvas>
      </div>
    </section>
  </main>

  <div class="barra" id="barra" aria-hidden="true"></div>

  <!-- Chart.js 4 Local -->
  <script src="<?= base_url('assets/js/chart.umd.min.js') ?>"></script>
  <script>
    const TEMPO_SLIDE = 15000;
    const TEMPO_DADOS = 180000;
    const TEMPO_RELOAD = 43200000;

    // Resolução flexível do Token (Query string ?t=, Fragmento #t=, ou injetado pelo backend)
    const tokenUrl = new URLSearchParams(window.location.search).get('t');
    const tokenHash = new URLSearchParams((window.location.hash || '').replace(/^#/, '')).get('t');
    const tokenInjetado = <?= json_encode((string)($token ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const token = tokenUrl || tokenHash || tokenInjetado || '';

    // Dados iniciais já calculados pelo PHP (Server-Side Rendering)
    const dadosIniciais = <?= json_encode($dadosIniciais ?? null, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

    const baseApi = <?= json_encode(base_url('painel/dados'), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    const urlDados = token ? (baseApi + '?t=' + encodeURIComponent(token)) : baseApi;

    const slides = Array.from(document.querySelectorAll('.slide'));
    const charts = {};
    const fmt = value => (Number(value) || 0).toLocaleString('pt-BR');
    const num = value => Number(value) || 0;
    let current = 0;

    Chart.defaults.color = '#cbd5e1';
    Chart.defaults.font.family = 'system-ui, -apple-system, "Segoe UI", Roboto, sans-serif';
    Chart.defaults.font.size = 17;

    function setChart(id, config) {
      if (charts[id]) charts[id].destroy();
      const canvas = document.getElementById(id);
      if (canvas) charts[id] = new Chart(canvas, config);
    }

    function render(data) {
      if (!data) return;
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
      document.getElementById('total-atencao').textContent = fmt(maintenance + unusable) + ' equip. (' + (total ? ((maintenance + unusable) / total * 100).toFixed(1) : 0) + '%)';
      document.getElementById('media-escola').textContent = schools ? fmt(Math.round(total / schools)) + ' equip./unidade' : '0';
      document.getElementById('hora').textContent = data.atualizado || '--:--';

      // Gráfico 1: Escolas mais críticas
      const critical = Array.isArray(data.criticas) ? data.criticas : [];
      setChart('g-criticas', {
        type: 'bar',
        data: {
          labels: critical.map(row => {
            const nome = row.nome || 'Escola';
            return nome.length > 36 ? nome.substring(0, 34) + '...' : nome;
          }),
          datasets: [{
            label: 'Equipamentos com problema (%)',
            data: critical.map(row => num(row.pct)),
            backgroundColor: critical.map(row => num(row.pct) >= 50 ? '#ef4444' : (num(row.pct) >= 25 ? '#f59e0b' : '#38bdf8')),
            borderRadius: 8,
            maxBarThickness: 32
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          animation: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: item => ' ' + item.formattedValue + '% (' + fmt(critical[item.dataIndex].problema) + ' de ' + fmt(critical[item.dataIndex].total) + ' equipamentos)'
              }
            }
          },
          scales: {
            x: {
              min: 0,
              max: 100,
              ticks: { callback: value => value + '%', color: '#94a3b8' },
              grid: { color: 'rgba(255, 255, 255, 0.08)' }
            },
            y: {
              grid: { display: false },
              ticks: { color: '#e2e8f0', font: { size: 16 } }
            }
          }
        }
      });

      // Gráfico 2: Categorias x Condição
      const types = Array.isArray(data.tipos) ? data.tipos : [];
      setChart('g-tipos', {
        type: 'bar',
        data: {
          labels: types.map(row => row.tipo || 'Sem categoria'),
          datasets: [
            { label: 'Disponíveis', data: types.map(row => num(row.disponiveis)), backgroundColor: '#10b981', borderRadius: 6 },
            { label: 'Em manutenção', data: types.map(row => num(row.manutencao)), backgroundColor: '#f59e0b', borderRadius: 6 },
            { label: 'Inservíveis', data: types.map(row => num(row.inserviveis)), backgroundColor: '#ef4444', borderRadius: 6 },
            { label: 'Outros/Sem classificação', data: types.map(row => num(row.outros)), backgroundColor: '#64748b', borderRadius: 6 }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                color: '#f8fafc',
                font: { size: 17, weight: 'bold' },
                padding: 18,
                boxWidth: 18
              }
            },
            tooltip: {
              callbacks: {
                afterBody: items => items.length ? 'Total da categoria: ' + fmt(types[items[0].dataIndex].total) : ''
              }
            }
          },
          scales: {
            x: {
              stacked: true,
              grid: { display: false },
              ticks: { color: '#e2e8f0', font: { size: 16 } }
            },
            y: {
              stacked: true,
              grid: { color: 'rgba(255, 255, 255, 0.08)' },
              ticks: { color: '#94a3b8', callback: value => fmt(value) }
            }
          }
        }
      });
    }

    async function carregar() {
      const aviso = document.getElementById('aviso');
      try {
        const headers = {};
        if (token) {
          headers['Authorization'] = 'Bearer ' + token;
          headers['X-Painel-Token'] = token;
        }
        const response = await fetch(urlDados, { cache: 'no-store', headers });
        if (!response.ok) throw new Error('HTTP ' + response.status);
        const data = await response.json();
        render(data);
        aviso.textContent = '';
      } catch (error) {
        aviso.textContent = '⚠ Sem conexão ·';
        console.warn('Erro ao atualizar dados do painel:', error);
      }
    }

    function mostrar(index) {
      slides.forEach((slide, i) => slide.classList.toggle('ativo', i === index));
      document.getElementById('pos').textContent = `Slide ${index + 1} de ${slides.length}`;
      const bar = document.getElementById('barra');
      bar.style.transition = 'none';
      bar.style.width = '0%';
      void bar.offsetWidth;
      bar.style.transition = `width ${TEMPO_SLIDE}ms linear`;
      bar.style.width = '100%';
    }

    // 1. Renderização instantânea dos dados pré-carregados (sem tela em branco)
    if (dadosIniciais) {
      render(dadosIniciais);
    } else {
      carregar();
    }

    mostrar(0);

    // Ciclo de slides e atualizações
    setInterval(() => {
      current = (current + 1) % slides.length;
      mostrar(current);
    }, TEMPO_SLIDE);

    setInterval(carregar, TEMPO_DADOS);
    setTimeout(() => location.reload(), TEMPO_RELOAD);
  </script>
</body>
</html>