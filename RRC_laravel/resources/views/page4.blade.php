<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle de Zona — Reporta Residuos Cusco</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('css/page4.css') }}">
</head>
<body>

  <!-- ===== HERO MAPA ===== -->
  <div class="zone-hero">
    <div id="mini-map"></div>
    <div class="hero-overlay">
      <div class="hero-top">
        <a href="{{ url("/principal") }}" class="back-btn">←</a>
        <div class="zone-status-badge status-critical" id="heroBadge">🔴 ZONA CRÍTICA</div>
      </div>
      <div class="hero-bottom">
        <div class="report-count-pill">
          <strong id="heroReportes">8</strong> reportes ciudadanos
        </div>
      </div>
    </div>
  </div>

  <!-- ===== CUERPO ===== -->
  <div class="zone-body">

    <!-- Meta -->
    <div class="zone-meta">
      <span class="cat-pill pill-red" id="metaTipo">Residuos Sólidos</span>
      <span class="zone-date" id="metaFecha">Hace 2 horas · 8 reportes</span>
    </div>

    <!-- Título y descripción -->
    <h1 class="zone-title" id="zonaTitle">Plaza San Jerónimo — Zona afectada</h1>
    <p class="zone-desc" id="zonaDesc">
      Acumulación crítica de desechos sólidos en San Jerónimo. Se reportan bolsas, cartones y restos orgánicos afectando la vía pública.
    </p>

    <!-- Estadísticas -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number" id="statReportes" style="color:var(--red)">8</div>
        <div class="stat-label">Reportes</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" id="statDias" style="color:var(--amber)">3</div>
        <div class="stat-label">Días activo</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" id="statUrgencia" style="color:var(--green)">72%</div>
        <div class="stat-label">Urgencia</div>
      </div>
    </div>

    <!-- Ubicación -->
    <div class="location-strip">
      <span class="loc-pin">📍</span>
      <div class="loc-details">
        <div class="loc-address" id="locAddress">Av. Los Arces s/n, San Jerónimo, Cusco</div>
        <div class="loc-coords" id="locCoords">-13.52680°, -71.96280°</div>
      <button class="navigate-btn" id="navBtn" onclick="navegarZona()">
        🗺️ Navegar
      </button>
    </div>

    <!-- Reportes de otros usuarios -->
    <div>
      <div class="reports-section-title">
        <span>Reportes de ciudadanos</span>
        <span style="font-size:0.7rem;color:var(--gray)" id="reportCount">8 reportes</span>
      </div>
      <div id="reportesList">
        <!-- generado por JS -->
      </div>
    </div>

    <!-- Espacio para los botones fijos -->
    <div style="height: 80px;"></div>
  </div>

  <!-- ===== BOTONES FIJOS ===== -->
  <div class="action-row">
    <button class="btn-share" onclick="compartirZona()">🔗 Compartir</button>
    <a href="{{ url('/reporte-residuos') }}" class="btn-report">🚨 Reportar también</a>
  </div>

  <!-- ===== NAV INFERIOR ===== -->
  <nav class="bottom-nav">
    <a href="{{ url("/principal") }}" class="nav-item active" style="text-decoration:none">
      <span class="nav-icon">🗺️</span>
      <span class="nav-label" style="color:var(--green)">Mapa</span>
      <div class="nav-active-dot"></div>
    </a>
    <a href="{{ url('/reporte-residuos') }}" class="nav-item" style="text-decoration:none">
      <span class="nav-icon">➕</span>
      <span class="nav-label">Reportar</span>
    </a>
    <a href="{{ url('/historial') }}" class="nav-item" style="text-decoration:none">
      <span class="nav-icon">📋</span>
      <span class="nav-label">Historial</span>
    </a>
    <a href="{{ url("/perfil") }}" class="nav-item" style="text-decoration:none">
      <span class="nav-icon">👤</span>
      <span class="nav-label">Perfil</span>
    </a>
  </nav>

  <!-- Toast -->
  <div id="toast"></div>

  <script>
    // ============================================================
    // DATOS DE ZONAS (mismo array que page2 — en producción: fetch PHP)
    // ============================================================
    const zonas = [
      {
        id: 1,
        nombre: 'Plaza San Jerónimo',
        sector: 'Zona Centro',
        direccion: 'Plazoleta San Jerónimo, San Jerónimo, Cusco',
        lat: -13.5268, lng: -71.9628,
        nivel: 'critico',
        tipo: 'Residuos Sólidos Domésticos',
        reportes: 9,
        diasActivo: 3,
        urgencia: 72,
        descripcion: 'Acumulación crítica de desechos sólidos en el sector. Se reportan bolsas, cartones y restos orgánicos bloqueando la vía y generando olores.',
        ultReportes: [
          { usuario: 'María C.', tiempo: 'Hace 1 hora',  texto: 'El olor es insoportable, hay bolsas apiladas desde hace 3 días.', emoji: '👩' },
          { usuario: 'Juan P.', tiempo: 'Hace 3 horas', texto: 'Toman fotos pero no recogen. Necesitan intervención urgente.', emoji: '👨' },
          { usuario: 'Rosa M.', tiempo: 'Hace 5 horas', texto: 'Los comerciantes piden que vengan hoy.', emoji: '👩' },
        ],
      },
      {
        id: 2,
        nombre: 'Mercado Vinocanchon',
        sector: '',
        direccion: 'Jr. Vinocanchon 456, San Jerónimo, Cusco',
        lat: -13.5275, lng: -71.9615,
        nivel: 'moderado',
        tipo: 'Residuos Sólidos',
        reportes: 5,
        diasActivo: 1,
        urgencia: 45,
        descripcion: 'Bolsas de basura acumuladas cerca de los puestos. Afecta el flujo de clientes y la zona de ventas.',
        ultReportes: [
          { usuario: 'Luis T.', tiempo: 'Hace 2 horas', texto: 'Los clientes no pueden caminar bien entre la basura.', emoji: '👨' },
          { usuario: 'Ana G.', tiempo: 'Ayer',          texto: 'Segunda vez que reporto el mismo lugar.', emoji: '👩' },
        ],
      },
      {
        id: 3,
        nombre: 'Parque Infantil San Jerónimo',
        sector: 'San Jerónimo',
        direccion: 'Jr. Los Nevados 45, San Jerónimo, Cusco',
        lat: -13.5290, lng: -71.9620,
        nivel: 'limpio',
        tipo: 'Sin incidencias',
        reportes: 0,
        diasActivo: 0,
        urgencia: 0,
        descripcion: 'Zona limpia y monitoreada. Ideal para actividades recreativas familiares.',
        ultReportes: [],
      },
      {
        id: 4,
        nombre: 'Centro Av. San Jerónimo',
        sector: '',
        direccion: 'Av. San Jerónimo 710, San Jerónimo, Cusco',
        lat: -13.5252, lng: -71.9640,
        nivel: 'critico',
        tipo: 'Desmonte / Residuos de Construcción',
        reportes: 14,
        diasActivo: 5,
        urgencia: 88,
        descripcion: 'Residuos de construcción y escombros invadiendo la vía pública. Hay riesgo para peatones y vehículos.',
        ultReportes: [
          { usuario: 'Pedro V.', tiempo: 'Hace 30 min', texto: 'Casi choco porque los materiales están en la pista.', emoji: '👨' },
          { usuario: 'Carmen R.', tiempo: 'Hace 2 horas', texto: 'Ya van 5 días con esto, necesitan actuar.', emoji: '👩' },
          { usuario: 'Víctor H.', tiempo: 'Ayer', texto: 'Hay polvo en el aire que afecta la visibilidad.', emoji: '👨' },
        ],
      },
    ];

    // ============================================================
    // LEER ID de la URL (?id=1)
    // ============================================================
    const params = new URLSearchParams(window.location.search);
    const zonaId = parseInt(params.get('id')) || 1;
    const zona = zonas.find(z => z.id === zonaId) || zonas[0];

    // ============================================================
    // POBLAR LA PÁGINA
    // ============================================================
    const niveles = {
      critico:  { badge: '🔴 ZONA CRÍTICA', badgeClass: 'status-critical', pillClass: 'pill-red' },
      moderado: { badge: '🟡 ZONA MODERADA', badgeClass: 'status-moderate', pillClass: 'pill-amber' },
      limpio:   { badge: '✅ ZONA LIMPIA', badgeClass: 'status-clean', pillClass: 'pill-red' },
    };

    const info = niveles[zona.nivel];
    document.getElementById('heroBadge').textContent  = info.badge;
    document.getElementById('heroBadge').className    = `zone-status-badge ${info.badgeClass}`;
    document.getElementById('heroReportes').textContent = zona.reportes;
    document.getElementById('metaTipo').textContent    = zona.tipo;
    document.getElementById('metaTipo').className      = `cat-pill ${info.pillClass}`;
    document.getElementById('metaFecha').textContent   = zona.diasActivo > 0
      ? `Hace ${zona.diasActivo * 24}h · ${zona.reportes} reportes`
      : `Sin incidencias activas`;
    document.getElementById('zonaTitle').textContent   = zona.sector ? `${zona.nombre} — ${zona.sector}` : zona.nombre;
    document.getElementById('zonaDesc').textContent    = zona.descripcion;
    document.getElementById('statReportes').textContent = zona.reportes;
    document.getElementById('statDias').textContent    = zona.diasActivo;
    document.getElementById('statUrgencia').textContent = `${zona.urgencia}%`;
    document.getElementById('locAddress').textContent  = zona.direccion;
    document.getElementById('locCoords').textContent   = `${zona.lat.toFixed(5)}°, ${zona.lng.toFixed(5)}°`;
    document.getElementById('reportCount').textContent = `${zona.reportes} reportes`;
    document.title = `${zona.nombre} — Reporta Residuos Cusco`;

    // Renderizar reportes ciudadanos
    const listEl = document.getElementById('reportesList');
    if (zona.ultReportes.length === 0) {
      listEl.innerHTML = `<p style="font-size:0.78rem;color:var(--gray);text-align:center;padding:16px 0">Sin reportes ciudadanos aún</p>`;
    } else {
      listEl.innerHTML = zona.ultReportes.map(r => `
        <div class="mini-report-card">
          <div class="mini-avatar">${r.emoji}</div>
          <div>
            <div class="mini-user">${r.usuario} <span style="color:var(--slate)">·</span> <span class="mini-time">${r.tiempo}</span></div>
            <div class="mini-text">${r.texto}</div>
          </div>
        </div>
      `).join('');
    }

    // ============================================================
    // MAPA MINI con Leaflet
    // ============================================================
    const miniMap = L.map('mini-map', {
      zoomControl: false,
      scrollWheelZoom: false,
      dragging: false,
      touchZoom: false,
      doubleClickZoom: false,
    }).setView([zona.lat, zona.lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(miniMap);

    const col = { critico: '#EF4444', moderado: '#F59E0B', limpio: '#1DB954' }[zona.nivel];

    L.circleMarker([zona.lat, zona.lng], {
      radius: 14,
      fillColor: col,
      color: '#fff',
      weight: 3,
      fillOpacity: 0.85,
    }).addTo(miniMap);

    // ============================================================
    // NAVEGAR
    // ============================================================
    function navegarZona() {
      const url = `https://maps.google.com/?q=${zona.lat},${zona.lng}`;
      window.open(url, '_blank');
    }

    // ============================================================
    // COMPARTIR
    // ============================================================
    async function compartirZona() {
      const text = `🚨 Zona contaminada en Cusco: ${zona.nombre}\n📍 ${zona.direccion}\n⚠️ Nivel: ${zona.nivel.toUpperCase()}\n${window.location.href}`;
      if (navigator.share) {
        try { await navigator.share({ title: zona.nombre, text }); }
        catch {}
      } else {
        await navigator.clipboard.writeText(text);
        mostrarToast('🔗 Enlace copiado al portapapeles');
      }
    }

    // ============================================================
    // TOAST
    // ============================================================
    function mostrarToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 2600);
    }
  </script>
</body>
</html>
