<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="theme-color" content="#081320" />
  <title>Estadísticas — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

  <!-- Chart.js para gráficos -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    /* Estilos para los gráficos en fila */
    .charts-row-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 32px;
    }
    .chart-display-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 16px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    .chart-display-title {
      color: #fff;
      font-size: 1.1rem;
      font-weight: 800;
      margin: 0;
      text-align: center;
      font-family: 'Poppins', sans-serif;
    }
    .chart-display-sub {
      color: #8b949e;
      font-size: 0.75rem;
      margin: 4px 0 20px 0;
      text-align: center;
    }
    .chart-canvas-wrapper {
      position: relative;
      width: 100%;
      max-width: 220px;
      height: 220px;
      margin-bottom: 12px;
    }
    .chart-inner-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      pointer-events: none;
    }
    .chart-inner-num {
      display: block;
      font-size: 2.2rem;
      font-weight: 800;
      color: #fff;
      line-height: 1;
      font-family: 'Poppins', sans-serif;
    }
    .chart-inner-lbl {
      font-size: 0.7rem;
      color: #8b949e;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-weight: 600;
    }
    @media (max-width: 1024px) {
      .charts-row-container {
        grid-template-columns: 1fr;
      }
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

        <!-- Sección de Gráficos Estadísticos (Zonas y Categorías) -->
        <div class="charts-row-container">
          <!-- Gráfico de Zonas (Izquierda) -->
          <div class="chart-display-card">
            <h2 class="chart-display-title">📍 Distribución por Zona</h2>
            <p class="chart-display-sub">Cantidad de reportes registrados por sector</p>
            <div class="chart-canvas-wrapper">
              <canvas id="zonaChart"></canvas>
              <div class="chart-inner-text">
                <span class="chart-inner-num" id="totalZonas">{{ $reportesPorZona->count() }}</span>
                <span class="chart-inner-lbl">Zonas</span>
              </div>
            </div>
          </div>

          <!-- Gráfico de Categorías (Derecha) -->
          <div class="chart-display-card">
            <h2 class="chart-display-title">🏷️ Distribución por Categoría</h2>
            <p class="chart-display-sub">Tipos de reportes más recurrentes</p>
            <div class="chart-canvas-wrapper">
              <canvas id="categoriaChart"></canvas>
              <div class="chart-inner-text">
                <span class="chart-inner-num" id="totalCategorias">{{ $reportesPorCategoria->count() }}</span>
                <span class="chart-inner-lbl">Tipos</span>
              </div>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const zonaData = @json($reportesPorZona);
      const catData = @json($reportesPorCategoria);

      const premiumColors = [
        '#3B82F6', // Blue
        '#10B981', // Emerald
        '#F59E0B', // Amber
        '#EC4899', // Pink
        '#8B5CF6', // Purple
        '#EF4444', // Red
        '#06B6D4', // Cyan
        '#F97316', // Orange
        '#14B8A6', // Teal
        '#6366F1'  // Indigo
      ];

      // 1. Inicializar Gráfico por Zona
      const ctxZona = document.getElementById('zonaChart');
      if (ctxZona && zonaData && zonaData.length > 0) {
        const labels = zonaData.map(z => z.zona || 'N/A');
        const data = zonaData.map(z => z.total);
        const totalReportes = data.reduce((a, b) => a + b, 0);
        const bgColors = zonaData.map((_, i) => premiumColors[i % premiumColors.length]);

        new Chart(ctxZona.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: labels,
            datasets: [{
              data: data,
              backgroundColor: bgColors,
              borderColor: '#161b22',
              borderWidth: 2,
              hoverOffset: 6
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
                callbacks: {
                  label: function(context) {
                    let label = context.label || '';
                    if (label) {
                      label += ': ';
                    }
                    if (context.parsed !== null) {
                      label += context.parsed;
                    }
                    const pct = totalReportes > 0 ? ((context.parsed / totalReportes) * 100).toFixed(1) : 0;
                    label += ` (${pct}%)`;
                    return label;
                  }
                }
              }
            }
          }
        });
      }

      // 2. Inicializar Gráfico por Categoría
      const ctxCat = document.getElementById('categoriaChart');
      if (ctxCat && catData && catData.length > 0) {
        const labels = catData.map(c => c.categoria || 'N/A');
        const data = catData.map(c => c.total);
        const totalReportes = data.reduce((a, b) => a + b, 0);
        const bgColors = catData.map((_, i) => premiumColors[i % premiumColors.length]);

        new Chart(ctxCat.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: labels,
            datasets: [{
              data: data,
              backgroundColor: bgColors,
              borderColor: '#161b22',
              borderWidth: 2,
              hoverOffset: 6
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
                callbacks: {
                  label: function(context) {
                    let label = context.label || '';
                    if (label) {
                      label += ': ';
                    }
                    if (context.parsed !== null) {
                      label += context.parsed;
                    }
                    const pct = totalReportes > 0 ? ((context.parsed / totalReportes) * 100).toFixed(1) : 0;
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
  </script>

</body>
</html>
