<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="theme-color" content="#081320" />
  <title>Panel Municipal — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

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

        <!-- Estadísticas -->
        <div class="stats-grid">
          <div class="stat-card">
            <span class="stat-value">{{ $estadisticas['total'] ?? 0 }}</span>
            <span class="stat-label">Total</span>
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

        <!-- Navegación Principal -->
        <nav class="desktop-nav">
          <a href="{{ url('/municipalidad') }}" class="desktop-nav-item active">
            <span class="desktop-nav-icon">📊</span>
            <span>Dashboard</span>
          </a>
          <a href="{{ url('/municipalidad#reportes') }}" class="desktop-nav-item">
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
         CONTENIDO PRINCIPAL — DASHBOARD
         ═══════════════════════════════════════════════════════════════════════════════ -->
    <div class="main-container">
      
      <!-- Panel de reportes: Gestión central -->
      <aside class="right-panel">
         <div class="panel-header">
           <h2 class="form-title">Gestión de Reportes</h2>
           <p class="form-sub">Listado en tiempo real</p>
        </div>

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
      </aside>

    </div>

  </div>




</body>
</html>