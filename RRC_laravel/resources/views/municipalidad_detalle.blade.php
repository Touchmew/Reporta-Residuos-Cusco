<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle de Reporte — Panel Municipal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('css/page4.css') }}">
  <link rel="stylesheet" href="{{ asset('css/municipalidad.css') }}">
  <style>
    /* Override citizen bottom-nav spacing */
    body { padding-bottom: 0 !important; }
    .action-row { bottom: 0; }

    /* Municipal state buttons */
    .muni-estado-row {
      display: flex;
      gap: 8px;
      margin-top: 16px;
    }
    .muni-estado-btn {
      flex: 1;
      padding: 12px 10px;
      border-radius: 12px;
      font-size: 0.78rem;
      font-weight: 700;
      border: 1px solid rgba(255,255,255,0.1);
      background: rgba(255,255,255,0.04);
      color: #8b949e;
      cursor: pointer;
      transition: all 0.2s;
      text-align: center;
    }
    .muni-estado-btn:hover { background: rgba(255,255,255,0.08); }
    .muni-estado-btn.active-red {
      background: rgba(239,68,68,0.15);
      border-color: rgba(239,68,68,0.4);
      color: #FDA4AF;
    }
    .muni-estado-btn.active-amber {
      background: rgba(245,158,11,0.15);
      border-color: rgba(245,158,11,0.4);
      color: #FCD34D;
    }
    .muni-estado-btn.active-green {
      background: rgba(29,185,84,0.15);
      border-color: rgba(29,185,84,0.4);
      color: #6EE7B7;
    }

    /* Volver al panel button */
    .btn-volver-panel {
      flex: 1;
      background: linear-gradient(135deg, #3B82F6, #1D4ED8);
      border: none;
      border-radius: 16px;
      padding: 15px;
      color: #fff;
      font-size: 0.82rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      text-decoration: none;
      transition: all 0.2s;
      box-shadow: 0 6px 20px rgba(59,130,246,0.3);
    }
    .btn-volver-panel:hover {
      box-shadow: 0 10px 28px rgba(59,130,246,0.45);
      transform: translateY(-1px);
    }
  </style>
</head>
<body>

  <!-- ===== HERO MAPA ===== -->
  <div class="zone-hero">
    <div id="mini-map"></div>
    <div class="hero-overlay">
      <div class="hero-top">
        <a href="{{ url('/municipalidad') }}" class="back-btn">←</a>
        <div class="zone-status-badge status-critical" id="heroBadge">🔴 ZONA CRÍTICA</div>
      </div>
      <div class="hero-bottom">
        <div class="report-count-pill">
          <strong id="heroReportes">0</strong> reportes ciudadanos
        </div>
      </div>
    </div>
  </div>

  <!-- ===== CUERPO ===== -->
  <div class="zone-body">

    <!-- Meta -->
    <div class="zone-meta">
      <span class="cat-pill pill-red" id="metaTipo">Residuos Sólidos</span>
      <span class="zone-date" id="metaFecha"></span>
    </div>

    <!-- Título y descripción -->
    <h1 class="zone-title" id="zonaTitle"></h1>
    <p class="zone-desc" id="zonaDesc"></p>

    <!-- Evidencia fotográfica -->
    @if($evidencia)
    <div style="margin: 20px 0;">
      <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: #3B82F6; font-weight: 700; margin-bottom: 10px;">
        📷 Evidencia fotográfica
      </div>
      <div style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2);">
        <img
          src="{{ asset('storage/' . $evidencia->ruta_imagen) }}"
          alt="Evidencia del reporte"
          style="width: 100%; max-width: 100%; display: block; border-radius: 16px; object-fit: cover; max-height: 400px;"
        />
      </div>
    </div>
    @endif

    <!-- Estadísticas -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number" id="statReportes" style="color:#3B82F6">0</div>
        <div class="stat-label">Reportes</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" id="statDias" style="color:#F59E0B">0</div>
        <div class="stat-label">Días activo</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" id="statUrgencia" style="color:#1DB954">0%</div>
        <div class="stat-label">Urgencia</div>
      </div>
    </div>

    <!-- Ubicación -->
    <div class="location-strip">
      <span class="loc-pin">📍</span>
      <div class="loc-details">
        <div class="loc-address" id="locAddress"></div>
        <div class="loc-coords" id="locCoords"></div>
      <button class="navigate-btn" id="navBtn" onclick="navegarZona()">
        🗺️ Navegar
      </button>
    </div>

    <!-- Gestión de estado -->
    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 14px; padding: 16px;">
      <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: #3B82F6; font-weight: 700; margin-bottom: 12px;">
        🏛️ Gestión municipal — Cambiar estado
      </div>
      <form method="POST" action="/municipalidad/reporte/{{ $reporte->id }}/estado" class="muni-estado-row">
        @csrf
        <button type="submit" name="estado" value="pendiente" class="muni-estado-btn {{ $reporte->estado == 'pendiente' ? 'active-red' : '' }}">
          🔴 Pendiente
        </button>
        <button type="submit" name="estado" value="en_proceso" class="muni-estado-btn {{ $reporte->estado == 'en_proceso' ? 'active-amber' : '' }}">
          🟡 En Proceso
        </button>
        <button type="submit" name="estado" value="resuelto" class="muni-estado-btn {{ $reporte->estado == 'resuelto' ? 'active-green' : '' }}">
          ✅ Resuelto
        </button>
      </form>
    </div>

    <!-- Reportes de otros usuarios -->
    <div>
      <div class="reports-section-title">
        <span>Reportes de ciudadanos</span>
        <span style="font-size:0.7rem;color:var(--gray)" id="reportCount">0 reportes</span>
      </div>
      <div id="reportesList">
        <!-- generado por JS -->
      </div>
    </div>

    <!-- Espacio para los botones fijos -->
    <div style="height: 80px;"></div>
  </div>

  <!-- ===== BOTÓN FIJO — VOLVER AL PANEL ===== -->
  <div class="action-row">
    <a href="{{ url('/municipalidad') }}" class="btn-volver-panel">
      ← Volver al panel municipal
    </a>
  </div>

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
    document.title = `${zona.nombre} — Panel Municipal`;

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
