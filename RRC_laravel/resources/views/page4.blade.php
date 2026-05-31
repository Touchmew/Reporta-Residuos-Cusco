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
    const zona = @json($zona);

    const niveles = {
      critico:  { badge: '🔴 ZONA CRÍTICA', badgeClass: 'status-critical', pillClass: 'pill-red' },
      moderado: { badge: '🟡 ZONA MODERADA', badgeClass: 'status-moderate', pillClass: 'pill-amber' },
      limpio:   { badge: '✅ ZONA LIMPIA', badgeClass: 'status-clean', pillClass: 'pill-green' },
      conducta: { badge: '🚨 CONDUCTA CIUDADANA', badgeClass: 'status-critical', pillClass: 'pill-purple' },
    };

    const info = niveles[zona.nivel] || niveles.critico;
    document.getElementById('heroBadge').textContent  = info.badge;
    document.getElementById('heroBadge').className    = `zone-status-badge ${info.badgeClass}`;
    document.getElementById('heroReportes').textContent = zona.reportes;
    document.getElementById('metaTipo').textContent    = zona.tipo;
    document.getElementById('metaTipo').className      = `cat-pill ${info.pillClass}`;
    document.getElementById('metaFecha').textContent   = zona.diasActivo > 0
      ? `Hace ${zona.diasActivo} día${zona.diasActivo !== 1 ? 's' : ''} · ${zona.reportes} reportes`
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

    const miniMap = L.map('mini-map', {
      zoomControl: false,
      scrollWheelZoom: false,
      dragging: false,
      touchZoom: false,
      doubleClickZoom: false,
    }).setView([zona.lat, zona.lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(miniMap);

    const col = { critico: '#EF4444', moderado: '#F59E0B', limpio: '#1DB954', conducta: '#A855F7' }[zona.nivel] || '#EF4444';

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
