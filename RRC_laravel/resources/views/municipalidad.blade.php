<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="theme-color" content="#081320" />
  <title>Panel Municipal — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

  <!-- Leaflet para el mapa -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Chart.js para gráficos -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Estilos específicos del panel municipal -->
  <link rel="stylesheet" href="{{ asset('css/municipalidad.css') }}">
</head>

<body style="background: #081320; margin: 0; padding: 0; overflow: hidden;">

  <div class="app-layout">
    
    <!-- ═══════════════════════════════════════════════════════════════════════════════
         SIDEBAR IZQUIERDA — NAVEGACIÓN Y USUARIO
         ═══════════════════════════════════════════════════════════════════════════════ -->
    <aside class="sidebar">
      <div class="sidebar-content">
        
        <!-- Marca -->
        <div class="brand-section">
          <div class="brand-logo">🏛️</div>
          <div class="brand-text">
            <h1>Reporta Residuos Cusco</h1>
            <p>Panel municipal</p>
          </div>
        </div>

        <!-- Usuario -->
        <div class="info-box">
           <div class="brand-logo" style="width: 32px; height: 32px; font-size: 16px;">🏛️</div>
           <div>
               <div style="color: #fff; font-weight: 700; font-size: 0.85rem;">{{ session('nombre', 'Municipalidad') }}</div>
               <div style="color: #1DB954; font-size: 0.7rem; font-weight: 700;">🌱 Municipal</div>
           </div>
        </div>

        <!-- Estado -->
        <div class="system-status">
          <span class="status-dot"></span>
          Sistema activo
        </div>


        <!-- Navegación Principal -->
        <nav class="desktop-nav">
          <a href="{{ url('/municipalidad') }}" class="desktop-nav-item" id="navDashboard" onclick="mostrarPanel('dashboard'); return false;">
            <span class="desktop-nav-icon">📊</span>
            <span>Dashboard</span>
          </a>
          <a href="#reportes" class="desktop-nav-item" id="navReportes" onclick="mostrarPanel('reportes'); return false;">
            <span class="desktop-nav-icon">📋</span>
            <span>Reportes</span>
          </a>
          <a href="{{ url('/municipalidad/perfil') }}" class="desktop-nav-item">
            <span class="desktop-nav-icon">👤</span>
            <span>Perfil</span>
          </a>
          <a href="{{ url('/municipalidad/estadisticas') }}" class="desktop-nav-item">
            <span class="desktop-nav-icon">📈</span>
            <span>Estadísticas</span>
          </a>
          <a href="#" class="desktop-nav-item">
            <span class="desktop-nav-icon">⚙️</span>
            <span>Configuración</span>
          </a>
        </nav>

        <!-- Separator -->
        <div class="nav-separator"></div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" class="logout-btn">
            <span class="desktop-nav-icon">🚪</span>
            <span>Cerrar Sesión</span>
          </button>
        </form>

      </div>
    </aside>

    <!-- ═══════════════════════════════════════════════════════════════════════════════
         CONTENIDO PRINCIPAL — DASHBOARD (Lista de Reportes)
         ═══════════════════════════════════════════════════════════════════════════════ -->
    <div class="main-container">

      <!-- ── PANEL DASHBOARD: Lista de reportes ── -->
      <div id="panelDashboard" class="panel-full">
        <aside class="right-panel">
           <div class="panel-header">
             <h2 class="form-title">Gestión de Reportes</h2>
             <p class="form-sub">Listado en tiempo real y estadísticas de atención</p>
          </div>

          <div class="dashboard-content-grid">
             <!-- Listado de reportes (Columna Izquierda) -->
             <div class="reportes-list" id="reportesList">
                @forelse($reportes as $reporte)
                <div class="report-card">
                   <div class="report-header">
                       <div class="report-title">{{ $reporte->titulo ?? $reporte->categoria }}</div>
                       @php
                           $color = match($reporte->estado) {
                               'pendiente' => 'chip-red',
                               'en_proceso' => 'chip-amber',
                               'resuelto' => 'chip-green',
                               default => 'chip-purple'
                           };
                           
                           $label = match($reporte->estado) {
                               'pendiente' => '🔴 CRÍTICO',
                               'en_proceso' => '🟡 MODERADO',
                               'resuelto' => '✅ LIMPIO',
                               default => 'ESTADO'
                           };
                       @endphp
                       <span class="chip {{ $color }}">{{ $label }}</span>
                   </div>
                   <div class="report-address">📍 {{ $reporte->zona }}</div>
                   <div class="report-date">📅 {{ date('d/m/Y', strtotime($reporte->fecha_reporte ?? $reporte->created_at)) }}</div>
                   
                   <form method="POST" action="/municipalidad/reporte/{{ $reporte->id }}/estado" class="report-actions">
                       @csrf
                       <button type="submit" name="estado" value="pendiente" class="btn-action {{ $reporte->estado == 'pendiente' ? 'active-red' : '' }}">Pendiente</button>
                       <button type="submit" name="estado" value="en_proceso" class="btn-action {{ $reporte->estado == 'en_proceso' ? 'active-amber' : '' }}">Proceso</button>
                       <button type="submit" name="estado" value="resuelto" class="btn-action {{ $reporte->estado == 'resuelto' ? 'active-green' : '' }}">Resuelto</button>
                   </form>
                </div>
                @empty
                <div style="padding: 24px; text-align: center; color: #8b949e;">
                    No hay reportes disponibles
                </div>
                @endforelse
             </div>

             <!-- Panel del Gráfico Estadístico (Columna Derecha) -->
             <div class="dashboard-chart-panel">
                <div class="chart-card">
                   <h3 class="chart-card-title">Distribución por Estado</h3>
                   <p class="chart-card-sub">Resumen de atención de reportes</p>
                   
                   <div class="chart-wrapper">
                      <canvas id="reportesChart"></canvas>
                      <div class="chart-center-text">
                         <span class="chart-center-num">{{ $estadisticas['total'] ?? 0 }}</span>
                         <span class="chart-center-lbl">Total</span>
                      </div>
                   </div>
                   
                   <div class="chart-legend">
                      <div class="legend-item">
                         <span class="legend-bullet" style="background-color: #EF4444; color: #EF4444;"></span>
                         <span class="legend-label">Pendientes</span>
                         <span class="legend-val">{{ $estadisticas['pendientes'] ?? 0 }}</span>
                      </div>
                      <div class="legend-item">
                         <span class="legend-bullet" style="background-color: #F59E0B; color: #F59E0B;"></span>
                         <span class="legend-label">En Proceso</span>
                         <span class="legend-val">{{ $estadisticas['proceso'] ?? 0 }}</span>
                      </div>
                      <div class="legend-item">
                         <span class="legend-bullet" style="background-color: #1DB954; color: #1DB954;"></span>
                         <span class="legend-label">Resueltos</span>
                         <span class="legend-val">{{ $estadisticas['resueltos'] ?? 0 }}</span>
                      </div>
                   </div>
                </div>
             </div>
          </div>
        </aside>
      </div>

      <!-- ── PANEL REPORTES: Mapa con puntos ── -->
      <div id="panelReportes" class="panel-full" style="display: none;">
        <!-- Cabecera del mapa -->
        <div class="map-panel-header">
          <div>
            <h2 class="form-title">🗺️ Mapa de Reportes</h2>
            <p class="form-sub">Puntos georeferenciados en tiempo real · {{ $estadisticas['total'] ?? 0 }} reportes activos</p>
          </div>
          <!-- Filtros rápidos -->
          <div class="map-filters" id="mapFilters">
            <button class="map-chip map-chip-all active" data-filter="all" onclick="filtrarMapa(this)">Todos</button>
            <button class="map-chip map-chip-red"    data-filter="critico"   onclick="filtrarMapa(this)">🔴 Crítico</button>
            <button class="map-chip map-chip-amber"  data-filter="moderado"  onclick="filtrarMapa(this)">🟡 Moderado</button>
            <button class="map-chip map-chip-green"  data-filter="limpio"    onclick="filtrarMapa(this)">✅ Limpio</button>
            <button class="map-chip map-chip-purple" data-filter="conducta"  onclick="filtrarMapa(this)">🚨 Conducta</button>
          </div>
        </div>

        <!-- Contenedor del mapa -->
        <div class="mapa-contenedor">
          <div id="mapaReportes"></div>

          <!-- Leyenda flotante -->
          <div class="mapa-leyenda">
            <div class="leyenda-titulo">Estado de zonas</div>
            <div class="leyenda-fila"><div class="leyenda-dot" style="background:#EF4444"></div> Crítico</div>
            <div class="leyenda-fila"><div class="leyenda-dot" style="background:#F59E0B"></div> Moderado</div>
            <div class="leyenda-fila"><div class="leyenda-dot" style="background:#1DB954"></div> Limpio</div>
            <div class="leyenda-fila"><div class="leyenda-dot" style="background:#A855F7"></div> Conducta</div>
          </div>

          <!-- Contador flotante -->
          <div class="mapa-contador" id="mapaContador">
            📍 <span id="contadorNum">{{ $estadisticas['total'] ?? 0 }}</span> reportes visibles
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- Toast -->
  <div id="toast"></div>

  <script>
    // ═══════════════════════════════════════════════════════════════════════
    // DATOS DE ZONAS/REPORTES (con coordenadas)
    // ═══════════════════════════════════════════════════════════════════════
    const zonasData = @json($zonas);

    const coloresMapa = {
      critico:  '#EF4444',
      moderado: '#F59E0B',
      limpio:   '#1DB954',
      conducta: '#A855F7'
    };

    const labelsMapa = {
      critico:  'CRÍTICO',
      moderado: 'MODERADO',
      limpio:   'LIMPIO',
      conducta: 'CONDUCTA'
    };

    const emojisMapa = {
      critico:  '🗑️',
      moderado: '⚠️',
      limpio:   '✅',
      conducta: '🚨'
    };

    // ═══════════════════════════════════════════════════════════════════════
    // ESTADO DEL PANEL ACTIVO
    // ═══════════════════════════════════════════════════════════════════════
    let mapaInicializado = false;
    let mapaLeaflet = null;
    let marcadoresMapa = [];
    let filtroMapaActivo = 'all';

    function mostrarPanel(panel) {
      const panelDash    = document.getElementById('panelDashboard');
      const panelReport  = document.getElementById('panelReportes');
      const navDash      = document.getElementById('navDashboard');
      const navReportes  = document.getElementById('navReportes');

      // Quitar clase active de todos los nav
      document.querySelectorAll('.desktop-nav-item').forEach(el => {
        el.classList.remove('active');
      });

      if (panel === 'reportes') {
        panelDash.style.display   = 'none';
        panelReport.style.display = 'flex';
        navReportes.classList.add('active');
        inicializarMapa();
      } else {
        panelReport.style.display = 'none';
        panelDash.style.display   = 'flex';
        navDash.classList.add('active');
      }
    }

    // Iniciar en Dashboard
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('navDashboard').classList.add('active');

      // Inicializar Gráfico de Reportes
      const ctx = document.getElementById('reportesChart');
      if (ctx) {
        const total = {{ $estadisticas['total'] ?? 0 }};
        const pendientes = {{ $estadisticas['pendientes'] ?? 0 }};
        const proceso = {{ $estadisticas['proceso'] ?? 0 }};
        const resueltos = {{ $estadisticas['resueltos'] ?? 0 }};

        const hasData = total > 0;
        const dataValues = hasData ? [pendientes, proceso, resueltos] : [1];
        const bgColors = hasData ? ['#EF4444', '#F59E0B', '#1DB954'] : ['#21262d'];
        const labels = hasData ? ['Pendientes', 'En Proceso', 'Resueltos'] : ['Sin reportes'];

        new Chart(ctx.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: labels,
            datasets: [{
              data: dataValues,
              backgroundColor: bgColors,
              borderColor: '#161b22',
              borderWidth: 2,
              hoverOffset: hasData ? 6 : 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                enabled: hasData,
                callbacks: {
                  label: function(context) {
                    let label = context.label || '';
                    if (label) {
                      label += ': ';
                    }
                    if (context.parsed !== null) {
                      label += context.parsed;
                    }
                    const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                    label += ` (${pct}%)`;
                    return label;
                  }
                }
              }
            }
          }
        });
      }
    });

    // ═══════════════════════════════════════════════════════════════════════
    // MAPA LEAFLET
    // ═══════════════════════════════════════════════════════════════════════
    function crearIconoMapa(nivel) {
      return L.divIcon({
        className: '',
        html: `
          <div style="
            width:42px;
            height:42px;
            background:${coloresMapa[nivel]};
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            display:flex;
            align-items:center;
            justify-content:center;
            border:2px solid rgba(255,255,255,0.3);
            box-shadow:0 8px 20px rgba(0,0,0,0.4);
          ">
            <span style="transform:rotate(45deg); font-size:15px;">${emojisMapa[nivel]}</span>
          </div>
        `,
        iconSize:     [42, 42],
        iconAnchor:   [21, 42],
        popupAnchor:  [0, -44],
      });
    }

    function inicializarMapa() {
      if (mapaInicializado) {
        setTimeout(() => mapaLeaflet.invalidateSize(), 100);
        return;
      }

      mapaLeaflet = L.map('mapaReportes', {
        zoomControl: false
      }).setView([-13.5437, -71.8879], 14);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(mapaLeaflet);

      L.control.zoom({ position: 'bottomright' }).addTo(mapaLeaflet);

      // Agregar marcadores
      zonasData.forEach(zona => {
        if (!zona.lat || !zona.lng) return;

        const marker = L.marker(
          [zona.lat, zona.lng],
          { icon: crearIconoMapa(zona.nivel) }
        );

        marker.bindPopup(`
          <div style="
            min-width:230px;
            font-family:'Poppins',sans-serif;
            background:#161b22;
            border-radius:14px;
            overflow:hidden;
          ">
            <div style="
              background: linear-gradient(135deg, ${coloresMapa[zona.nivel]}22, ${coloresMapa[zona.nivel]}11);
              border-bottom: 1px solid ${coloresMapa[zona.nivel]}33;
              padding: 14px 16px 10px;
            ">
              <div style="font-size:0.95rem; font-weight:800; color:#fff; margin-bottom:4px;">
                ${zona.nombre || 'Reporte'}
              </div>
              <div style="color:#9FB3C8; font-size:0.72rem;">
                📍 ${zona.direccion || 'Cusco'}
              </div>
            </div>
            <div style="padding: 12px 16px;">
              <div style="display:flex; gap:8px; align-items:center; margin-bottom:12px;">
                <span style="
                  background:${coloresMapa[zona.nivel]}22;
                  color:${coloresMapa[zona.nivel]};
                  padding:4px 10px;
                  border-radius:8px;
                  font-size:0.65rem;
                  font-weight:700;
                  border: 1px solid ${coloresMapa[zona.nivel]}44;
                ">
                  ${labelsMapa[zona.nivel]}
                </span>
                <span style="font-size:0.7rem; color:#9FB3C8;">
                  ${zona.reportes} reporte(s)
                </span>
              </div>
              <a href="/page4?id=${zona.id}"
                 style="
                   display:block;
                   background: linear-gradient(135deg, #3B82F6, #1D4ED8);
                   color:#fff;
                   text-align:center;
                   padding:10px;
                   border-radius:10px;
                   font-weight:700;
                   font-size:0.8rem;
                   text-decoration:none;
                   transition: opacity 0.2s;
                 "
                 onmouseover="this.style.opacity='0.85'"
                 onmouseout="this.style.opacity='1'"
              >
                Ver detalle →
              </a>
            </div>
          </div>
        `, {
          maxWidth: 260,
          className: 'mapa-popup-muni'
        });

        marker.zonaData = zona;
        marker.addTo(mapaLeaflet);
        marcadoresMapa.push(marker);
      });

      // Forzar invalidateSize tras renderizar
      setTimeout(() => mapaLeaflet.invalidateSize(), 200);

      mapaInicializado = true;
      actualizarContador();
    }

    // ═══════════════════════════════════════════════════════════════════════
    // FILTROS DEL MAPA
    // ═══════════════════════════════════════════════════════════════════════
    function filtrarMapa(btn) {
      filtroMapaActivo = btn.dataset.filter;

      document.querySelectorAll('.map-chip').forEach(chip => {
        chip.classList.remove('active');
      });
      btn.classList.add('active');

      if (!mapaLeaflet) return;

      marcadoresMapa.forEach(marker => {
        const visible =
          filtroMapaActivo === 'all' ||
          marker.zonaData.nivel === filtroMapaActivo;

        if (visible) {
          mapaLeaflet.addLayer(marker);
        } else {
          mapaLeaflet.removeLayer(marker);
        }
      });

      actualizarContador();
    }

    function actualizarContador() {
      const visibles = filtroMapaActivo === 'all'
        ? zonasData.length
        : zonasData.filter(z => z.nivel === filtroMapaActivo).length;
      document.getElementById('contadorNum').textContent = visibles;
    }

    // ═══════════════════════════════════════════════════════════════════════
    // TOAST
    // ═══════════════════════════════════════════════════════════════════════
    function mostrarToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 2600);
    }

    // Redimensionar mapa al cambiar ventana
    window.addEventListener('resize', () => {
      if (mapaLeaflet) mapaLeaflet.invalidateSize();
    });
  </script>

</body>
</html>