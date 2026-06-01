<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="theme-color" content="#081320" />
  <title>Panel Municipal — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Syne:wght@400;700;800&display=swap" rel="stylesheet"/>

  <!-- Estilos base reutilizados -->
  <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
  <!-- Estilos específicos del panel municipal -->
  <link rel="stylesheet" href="{{ asset('css/municipalidad.css') }}">
</head>

<body>

  <div class="app-layout">
    
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-content">
        
        <!-- Marca -->
        <div class="brand-section">
          <div class="brand-logo" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8); box-shadow: 0 8px 20px rgba(59,130,246,0.35);">🏛️</div>
          <div class="brand-text">
            <h1>Reporta Residuos Cusco</h1>
            <p>Panel municipal</p>
          </div>
        </div>

        <!-- Usuario -->
        <div class="info-box" style="display:flex; align-items:center; gap: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
           <div class="brand-logo" style="width: 32px; height: 32px; font-size: 16px; border-radius: 8px; background: linear-gradient(135deg, #3B82F6, #1D4ED8); box-shadow: none;">🏛️</div>
           <div>
               <div style="color: #fff; font-weight: 700; font-size: 0.85rem;">{{ session('nombre', 'Almir Ticona') }}</div>
               <div style="color: #1DB954; font-size: 0.7rem; font-weight: 700;">🌱 Municipal</div>
           </div>
        </div>

        <!-- Estado -->
        <div class="system-status">
          <span class="status-dot"></span>
          Sistema activo en tiempo real
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
          <div class="stat-card">
            <span class="stat-value">{{ $estadisticas['total'] ?? 0 }}</span>
            <span class="stat-label">Total Reportes</span>
          </div>
          <div class="stat-card">
            <span class="stat-value" style="color: #EF4444;">{{ $estadisticas['pendientes'] ?? 0 }}</span>
            <span class="stat-label">Pendientes</span>
          </div>
          <div class="stat-card">
            <span class="stat-value" style="color: #F59E0B;">{{ $estadisticas['proceso'] ?? 0 }}</span>
            <span class="stat-label">En Proceso</span>
          </div>
          <div class="stat-card">
            <span class="stat-value" style="color: #1DB954;">{{ $estadisticas['resueltos'] ?? 0 }}</span>
            <span class="stat-label">Resueltos</span>
          </div>
        </div>

        <!-- Desktop Nav -->
        <nav class="desktop-nav">
          <a href="{{ url('/municipalidad/perfil') }}" class="desktop-nav-item">
            <span class="desktop-nav-icon">👤</span>
            <span>Perfil Municipal</span>
          </a>
        </nav>

      </div>
    </aside>

    <!-- MAIN CONTENT (MAP) -->
    <main class="main-content relative">
      <div class="map-wrapper" style="height: 100vh; position: absolute; inset: 0; right: 380px;">
        <div id="map"></div>
      </div>
    </main>

    <!-- RIGHT PANEL: GESTIÓN DE REPORTES -->
    <aside class="right-panel panel-gestion">
      <div class="panel-header">
         <h2 class="form-title" style="color: #fff; font-family: 'Syne', sans-serif; margin:0; font-size:1.2rem; font-weight: 800;">Gestión de Reportes</h2>
         <p class="form-sub" style="color: #8b949e; font-size: 0.8rem; margin-top: 4px;">Listado en tiempo real</p>
      </div>

      <div class="reportes-list" id="reportesList">
         @foreach($reportes as $reporte)
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
                <span class="chip {{ $color }}" style="font-size: 0.6rem; padding: 4px 8px;">{{ $label }}</span>
            </div>
            <div class="report-address">📍 {{ $reporte->zona }}</div>
            <div class="report-date">📅 {{ $reporte->fecha_reporte ?? $reporte->created_at ?? 'N/A' }}</div>
            
            <form method="POST" action="/municipalidad/reporte/{{ $reporte->id }}/estado" class="report-actions">
                @csrf
                <button type="submit" name="estado" value="pendiente" class="btn-action {{ $reporte->estado == 'pendiente' ? 'active-red' : '' }}">Pendiente</button>
                <button type="submit" name="estado" value="en_proceso" class="btn-action {{ $reporte->estado == 'en_proceso' ? 'active-amber' : '' }}">En Proceso</button>
                <button type="submit" name="estado" value="resuelto" class="btn-action {{ $reporte->estado == 'resuelto' ? 'active-green' : '' }}">Resuelto</button>
            </form>
         </div>
         @endforeach
      </div>
    </aside>

    <!-- BOTTOM NAV (Móvil) -->
    <nav class="bottom-nav">
      <a href="{{ url('/municipalidad') }}" class="nav-item active">
        <span class="nav-icon">🗺️</span>
        <span class="nav-label">Mapa</span>
        <div class="nav-active-dot"></div>
      </a>
      <a href="{{ url('/municipalidad/perfil') }}" class="nav-item" style="text-decoration:none">
        <span class="nav-icon">👤</span>
        <span class="nav-label">Perfil</span>
      </a>
    </nav>
  </div>

  <script>
    const map = L.map('map', { zoomControl: false }).setView([-13.5437, -71.8879], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    const reportes = @json($reportes);

    function getMarkerColor(estado) {
        if (estado === 'pendiente') return '#EF4444';
        if (estado === 'en_proceso') return '#F59E0B';
        if (estado === 'resuelto') return '#1DB954';
        return '#A855F7';
    }

    reportes.forEach(r => {
        if (!r.latitud || !r.longitud) return;
        const color = getMarkerColor(r.estado);
        const icon = L.divIcon({
            className: '',
            html: `<div style="width:20px;height:20px;background:${color};border-radius:50%;border:2px solid rgba(255,255,255,0.8);box-shadow:0 0 10px rgba(0,0,0,0.5);"></div>`,
            iconSize: [20, 20]
        });
        
        L.marker([r.latitud, r.longitud], { icon })
         .addTo(map)
         .bindPopup(`<div style="font-family:'DM Sans',sans-serif;font-weight:bold;">${r.titulo ?? r.categoria}</div><div style="font-size:12px;">${r.zona}</div>`);
    });
  </script>
</body>
</html>