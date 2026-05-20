<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="theme-color" content="#081320" />
  <title>Principal — Reporta Residuos Cusco</title>

  <link rel="stylesheet" href="{{ asset('css/principal.css') }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Syne:wght@400;700;800&display=swap" rel="stylesheet"/>
</head>

<body>

  <div class="app-layout">

    <!-- =========================================================
         SIDEBAR
         ========================================================= -->
    <aside class="sidebar">
      <div class="sidebar-content">

        <!-- Marca -->
        <div class="brand-section">
          <div class="brand-logo">♻️</div>
          <div class="brand-text">
            <h1>Reporta Residuos Cusco</h1>
            <p>Plataforma ciudadana ambiental</p>
          </div>
        </div>

        <!-- Estado -->
        <div class="system-status">
          <span class="status-dot"></span>
          Sistema activo en tiempo real
        </div>

        <!-- Buscador -->
        <div class="topbar-inner">
          <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Buscar zonas o direcciones...">
          </div>
          <button class="loc-btn" id="locBtn">📍 Mi ubicación</button>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
          <div class="stat-card">
            <span class="stat-value">24</span>
            <span class="stat-label">Reportes hoy</span>
          </div>
          <div class="stat-card">
            <span class="stat-value">7</span>
            <span class="stat-label">Zonas críticas</span>
          </div>
          <div class="stat-card">
            <span class="stat-value">89%</span>
            <span class="stat-label">Atendidos</span>
          </div>
          <div class="stat-card">
            <span class="stat-value">12</span>
            <span class="stat-label">Denuncias</span>
          </div>
        </div>

        <!-- Filtros -->
        <div class="filter-section">
          <div class="section-title">FILTRAR REPORTES</div>
          <div class="filter-row" id="filterRow">
            <button class="chip chip-all" data-filter="all" onclick="filtrar(this)">Todos</button>
            <button class="chip chip-red" data-filter="critico" onclick="filtrar(this)">🔴 Crítico</button>
            <button class="chip chip-amber" data-filter="moderado" onclick="filtrar(this)">🟡 Moderado</button>
            <button class="chip chip-green" data-filter="limpio" onclick="filtrar(this)">✅ Limpio</button>
            <button class="chip chip-purple" data-filter="conducta" onclick="filtrar(this)">🚨 Conducta ciudadana</button>
          </div>
        </div>

        <!-- Información -->
        <div class="info-box">
          <div class="info-title">💡 Participación ciudadana</div>
          <div class="info-desc">
            También puedes reportar vecinos que dejan residuos fuera del horario establecido por la municipalidad.
          </div>
        </div>

        <!-- Navegación Desktop -->
        <nav class="desktop-nav">
          <a href="{{ url("/principal") }}" class="desktop-nav-item active">
            <span class="desktop-nav-icon">🗺️</span>
            <span>Principal</span>
          </a>
          <a href="{{ url("/reporte-residuos") }}" class="desktop-nav-item">
            <span class="desktop-nav-icon">➕</span>
            <span>Reportar</span>
          </a>
          <a href="{{ url("/historial") }}" class="desktop-nav-item">
            <span class="desktop-nav-icon">📋</span>
            <span>Historial</span>
          </a>
          <a href="{{ url("/perfil") }}" class="desktop-nav-item">
            <span class="desktop-nav-icon">👤</span>
            <span>Perfil</span>
          </a>
        </nav>

      </div>
    </aside>

    <!-- =========================================================
         MAIN CONTENT
         ========================================================= -->
    <main class="main-content">

      <!-- Mapa (viñeta en móvil, fullscreen en desktop) -->
      <div class="map-wrapper">
        <div id="map"></div>

        <!-- Leyenda -->
        <div class="map-legend">
          <div class="legend-title">Estado de zonas</div>
          <div class="legend-row">
            <div class="legend-dot" style="background:#EF4444"></div> Crítico
          </div>
          <div class="legend-row">
            <div class="legend-dot" style="background:#F59E0B"></div> Moderado
          </div>
          <div class="legend-row">
            <div class="legend-dot" style="background:#1DB954"></div> Limpio
          </div>
          <div class="legend-row">
            <div class="legend-dot" style="background:#A855F7"></div> Conducta ciudadana
          </div>
        </div>
      </div>

      <!-- Alertas -->
      <div class="bottom-sheet" id="bottomSheet">
        <div class="sheet-handle-wrap" id="sheetHandle">
          <div class="sheet-handle"></div>
        </div>
        <div class="sheet-header">
          <div>
            <div class="sheet-subtitle">ACTIVIDAD RECIENTE</div>
            <div class="sheet-title">Alertas cercanas</div>
          </div>
          <span class="sheet-count" id="alertCount">4 zonas</span>
        </div>
        <div class="alert-list" id="alertList">
          <!-- generado por JS -->
        </div>
      </div>

      <!-- FAB -->
      <a href="{{ url("/reporte-residuos") }}" class="fab" title="Nuevo reporte">➕</a>

    </main>

    <!-- =========================================================
         BOTTOM NAV (solo móvil)
         ========================================================= -->
    <nav class="bottom-nav">
      <div class="nav-item active">
        <span class="nav-icon">🗺️</span>
        <span class="nav-label">Principal</span>
        <div class="nav-active-dot"></div>
      </div>
      <a href="{{ url("/reporte-residuos") }}" class="nav-item" style="text-decoration:none">
        <span class="nav-icon">➕</span>
        <span class="nav-label">Reportar</span>
      </a>
      <a href="{{ url("/historial") }}" class="nav-item" style="text-decoration:none">
        <span class="nav-icon">📋</span>
        <span class="nav-label">Historial</span>
      </a>
      <a href="{{ url("/perfil") }}" class="nav-item" style="text-decoration:none">
        <span class="nav-icon">👤</span>
        <span class="nav-label">Perfil</span>
      </a>
    </nav>

  </div>

  <!-- Toast -->
  <div id="toast"></div>

  <!-- =========================================================
       JAVASCRIPT
       ========================================================= -->
  <script>
    // =========================================================
    // DATOS
    // =========================================================
    const zonas = [
      {
        id: 1,
        nombre: 'Mercado Central',
        direccion: 'Av. Ejército 800, Cusco',
        lat: -13.5183,
        lng: -71.9784,
        nivel: 'critico',
        reportes: 8,
        distancia: '230 m',
      },
      {
        id: 2,
        nombre: 'Parque Los Pinos',
        direccion: 'Jr. Las Flores 240, Cusco',
        lat: -13.5220,
        lng: -71.9750,
        nivel: 'moderado',
        reportes: 3,
        distancia: '510 m',
      },
      {
        id: 3,
        nombre: 'Plaza San Martín',
        direccion: 'Centro Histórico, Cusco',
        lat: -13.5150,
        lng: -71.9820,
        nivel: 'limpio',
        reportes: 0,
        distancia: '1.2 km',
      },
      {
        id: 4,
        nombre: 'Av. La Cultura',
        direccion: 'Tramo norte',
        lat: -13.5210,
        lng: -71.9700,
        nivel: 'critico',
        reportes: 12,
        distancia: '900 m',
      },
      {
        id: 5,
        nombre: 'Vecinos dejando basura fuera de horario',
        direccion: 'Urb. Magisterio',
        lat: -13.5160,
        lng: -71.9720,
        nivel: 'conducta',
        reportes: 5,
        distancia: '300 m',
      }
    ];

    const colores = {
      critico: '#EF4444',
      moderado: '#F59E0B',
      limpio: '#1DB954',
      conducta: '#A855F7'
    };

    const labels = {
      critico: 'CRÍTICO',
      moderado: 'MODERADO',
      limpio: 'LIMPIO',
      conducta: 'CONDUCTA'
    };

    const emojis = {
      critico: '🗑️',
      moderado: '⚠️',
      limpio: '✅',
      conducta: '🚨'
    };

    // =========================================================
    // MAPA
    // =========================================================
    const map = L.map('map', {
      zoomControl: false
    }).setView([-13.5183, -71.9784], 15);

    L.tileLayer(
      'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      {
        attribution: '© OpenStreetMap contributors'
      }
    ).addTo(map);

    L.control.zoom({
      position: 'bottomright'
    }).addTo(map);

    const markers = [];

    function crearIcono(nivel) {
      return L.divIcon({
        className: '',
        html: `
          <div style="
            width:42px;
            height:42px;
            background:${colores[nivel]};
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            display:flex;
            align-items:center;
            justify-content:center;
            border:2px solid rgba(255,255,255,0.25);
            box-shadow:0 10px 20px rgba(0,0,0,0.35);
          ">
            <span style="
              transform:rotate(45deg);
              font-size:16px;
            ">
              ${emojis[nivel]}
            </span>
          </div>
        `,
        iconSize: [42, 42],
        iconAnchor: [21, 42],
        popupAnchor: [0, -38],
      });
    }

    zonas.forEach(zona => {
      const marker = L.marker(
        [zona.lat, zona.lng],
        {
          icon: crearIcono(zona.nivel)
        }
      );

      marker.bindPopup(`
        <div style="
          min-width:220px;
          font-family:'DM Sans',sans-serif;
        ">
          <div style="
            font-size:1rem;
            font-weight:700;
            color:#fff;
            margin-bottom:6px;
          ">
            ${zona.nombre}
          </div>
          <div style="
            color:#9FB3C8;
            font-size:0.75rem;
            margin-bottom:12px;
          ">
            📍 ${zona.direccion}
          </div>
          <div style="
            display:flex;
            gap:8px;
            align-items:center;
            margin-bottom:12px;
          ">
            <span style="
              background:${colores[zona.nivel]}22;
              color:${colores[zona.nivel]};
              padding:4px 10px;
              border-radius:10px;
              font-size:0.65rem;
              font-weight:700;
            ">
              ${labels[zona.nivel]}
            </span>
            <span style="
              font-size:0.7rem;
              color:#9FB3C8;
            ">
              ${zona.reportes} reportes
            </span>
          </div>
          <a href="detalle-zona.html?id=${zona.id}"
             style="
               display:block;
               background:#1DB954;
               color:#fff;
               text-align:center;
               padding:10px;
               border-radius:12px;
               font-weight:700;
               text-decoration:none;
             ">
             Ver detalle →
          </a>
        </div>
      `);

      marker.zonaData = zona;
      marker.addTo(map);
      markers.push(marker);
    });

    // =========================================================
    // FILTRAR
    // =========================================================
    let filtroActivo = 'all';

    function filtrar(btn) {
      filtroActivo = btn.dataset.filter;

      document.querySelectorAll('.chip').forEach(chip => {
        chip.style.opacity = '0.5';
        chip.style.transform = 'scale(0.95)';
      });

      btn.style.opacity = '1';
      btn.style.transform = 'scale(1)';

      markers.forEach(marker => {
        const visible =
          filtroActivo === 'all' ||
          marker.zonaData.nivel === filtroActivo;

        if (visible) {
          map.addLayer(marker);
        } else {
          map.removeLayer(marker);
        }
      });

      renderAlertList();
    }

    document.querySelectorAll('.chip').forEach(chip => {
      if (!chip.classList.contains('chip-all')) {
        chip.style.opacity = '0.7';
      }
    });

    // =========================================================
    // ALERTAS
    // =========================================================
    function renderAlertList() {
      const lista = document.getElementById('alertList');
      const filtradas =
        filtroActivo === 'all'
          ? zonas
          : zonas.filter(z => z.nivel === filtroActivo);

      document.getElementById('alertCount').textContent =
        `${filtradas.length} zonas`;

      lista.innerHTML = filtradas.map(zona => `
        <a href="detalle-zona.html?id=${zona.id}"
           class="alert-card">
          <div class="alert-indicator"
               style="background:${colores[zona.nivel]}">
          </div>
          <div class="alert-info">
            <div class="alert-name">
              ${zona.nombre}
            </div>
            <div class="alert-meta">
              📍 ${zona.direccion} · ${zona.distancia}
            </div>
          </div>
          <div class="alert-badge"
               style="
                 background:${colores[zona.nivel]}22;
                 color:${colores[zona.nivel]};
               ">
            ${labels[zona.nivel]}
          </div>
        </a>
      `).join('');
    }

    renderAlertList();

    // =========================================================
    // GPS
    // =========================================================
    document
      .getElementById('locBtn')
      .addEventListener('click', () => {

        if (!navigator.geolocation) {
          mostrarToast('GPS no disponible');
          return;
        }

        mostrarToast('Obteniendo ubicación...');

        navigator.geolocation.getCurrentPosition(pos => {
          const {
            latitude,
            longitude
          } = pos.coords;

          map.setView(
            [latitude, longitude],
            16
          );

          L.circleMarker(
            [latitude, longitude],
            {
              radius: 10,
              fillColor: '#3B82F6',
              color: '#fff',
              weight: 3,
              fillOpacity: 1,
            }
          )
          .addTo(map)
          .bindPopup('📍 Estás aquí')
          .openPopup();

          mostrarToast('Ubicación encontrada');
        });

      });

    // =========================================================
    // TOAST
    // =========================================================
    function mostrarToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => {
        t.classList.remove('show');
      }, 2600);
    }

    // =========================================================
    // REDIMENSIONAR MAPA
    // =========================================================
    window.addEventListener('resize', () => {
      map.invalidateSize();
    });

    window.addEventListener('load', () => {
      map.invalidateSize();
    });
  </script>

</body>
</html>