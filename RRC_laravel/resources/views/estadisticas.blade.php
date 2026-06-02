<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="theme-color" content="#081320" />
  <title>Estadísticas — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

  <!-- Estilos específicos del panel municipal -->
  <link rel="stylesheet" href="{{ asset('css/municipalidad.css') }}">
  <style>
    .chart-container {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 16px;
      padding: 24px;
      margin-bottom: 24px;
    }
    .stat-large {
      text-align: center;
      padding: 20px;
    }
    .stat-large-value {
      font-size: 2.5rem;
      font-weight: 800;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .stat-large-label {
      color: #8b949e;
      font-size: 0.95rem;
      margin-top: 8px;
    }
    .table-stats {
      width: 100%;
      border-collapse: collapse;
    }
    .table-stats th {
      background: rgba(255, 255, 255, 0.03);
      padding: 12px;
      text-align: left;
      color: #8b949e;
      font-size: 0.85rem;
      font-weight: 700;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
    .table-stats td {
      padding: 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
      color: #fff;
    }
    .badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 700;
    }
  </style>
</head>

<body style="background: #081320; margin: 0; padding: 0; overflow-x: hidden;">

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
          <a href="{{ url('/municipalidad') }}" class="desktop-nav-item">
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
          <a href="{{ url('/municipalidad/estadisticas') }}" class="desktop-nav-item active">
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
         CONTENIDO PRINCIPAL — ESTADÍSTICAS
         ═══════════════════════════════════════════════════════════════════════════════ -->
    <div class="main-container" style="flex-direction: column; background: #0d1117; overflow-y: auto;">
      
      <div style="padding: 32px; max-width: 1400px; width: 100%;">
        
        <!-- Título -->
        <div style="margin-bottom: 32px;">
          <h1 style="color: #fff; font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 800; margin: 0; margin-bottom: 8px;">📈 Estadísticas</h1>
          <p style="color: #8b949e; margin: 0;">Análisis detallado de reportes de residuos en Cusco</p>
        </div>

        <!-- Cards principales -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 32px;">
          
          <div class="chart-container">
            <div style="color: #8b949e; font-size: 0.85rem; margin-bottom: 12px; font-weight: 700;">TOTAL DE REPORTES</div>
            <div class="stat-large">
              <div class="stat-large-value" style="color: #3B82F6;">{{ $estadisticas['total'] }}</div>
              <div class="stat-large-label">Reportes registrados</div>
            </div>
          </div>

          <div class="chart-container">
            <div style="color: #8b949e; font-size: 0.85rem; margin-bottom: 12px; font-weight: 700;">PENDIENTES</div>
            <div class="stat-large">
              <div class="stat-large-value" style="color: #EF4444;">{{ $estadisticas['pendientes'] }}</div>
              <div class="stat-large-label">Esperando atención</div>
            </div>
          </div>

          <div class="chart-container">
            <div style="color: #8b949e; font-size: 0.85rem; margin-bottom: 12px; font-weight: 700;">EN PROCESO</div>
            <div class="stat-large">
              <div class="stat-large-value" style="color: #F59E0B;">{{ $estadisticas['proceso'] }}</div>
              <div class="stat-large-label">En gestión</div>
            </div>
          </div>

          <div class="chart-container">
            <div style="color: #8b949e; font-size: 0.85rem; margin-bottom: 12px; font-weight: 700;">RESUELTOS</div>
            <div class="stat-large">
              <div class="stat-large-value" style="color: #1DB954;">{{ $estadisticas['resueltos'] }}</div>
              <div class="stat-large-label">Completados</div>
            </div>
          </div>

        </div>

        <!-- Reporte por zonas -->
        @if($reportesPorZona->count() > 0)
        <div class="chart-container">
          <h2 style="color: #fff; font-family: 'Poppins', sans-serif; font-size: 1.3rem; font-weight: 800; margin: 0 0 16px 0;">📍 Estadísticas por Zona</h2>
          <table class="table-stats">
            <thead>
              <tr>
                <th>Zona</th>
                <th style="text-align: center;">Total</th>
                <th style="text-align: center;">Pendientes</th>
                <th style="text-align: center;">En Proceso</th>
                <th style="text-align: center;">Resueltos</th>
              </tr>
            </thead>
            <tbody>
              @foreach($reportesPorZona as $zona)
              <tr>
                <td>{{ $zona['zona'] ?? 'N/A' }}</td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6;">{{ $zona['total'] }}</span>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">{{ $zona['pendientes'] }}</span>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">{{ $zona['proceso'] }}</span>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(29, 185, 84, 0.15); color: #1DB954;">{{ $zona['resueltos'] }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

        <!-- Reporte por categorías -->
        @if($reportesPorCategoria->count() > 0)
        <div class="chart-container">
          <h2 style="color: #fff; font-family: 'Poppins', sans-serif; font-size: 1.3rem; font-weight: 800; margin: 0 0 16px 0;">🏷️ Estadísticas por Categoría</h2>
          <table class="table-stats">
            <thead>
              <tr>
                <th>Categoría</th>
                <th style="text-align: center;">Total</th>
                <th style="text-align: center;">Pendientes</th>
                <th style="text-align: center;">En Proceso</th>
                <th style="text-align: center;">Resueltos</th>
              </tr>
            </thead>
            <tbody>
              @foreach($reportesPorCategoria as $cat)
              <tr>
                <td>{{ $cat['categoria'] ?? 'N/A' }}</td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6;">{{ $cat['total'] }}</span>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">{{ $cat['pendientes'] }}</span>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #F59E0B;">{{ $cat['proceso'] }}</span>
                </td>
                <td style="text-align: center;">
                  <span class="badge" style="background: rgba(29, 185, 84, 0.15); color: #1DB954;">{{ $cat['resueltos'] }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

      </div>

    </div>

  </div>

</body>
</html>
