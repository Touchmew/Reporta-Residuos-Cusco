<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Reportes — Reporta Residuos Cusco</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <link rel="stylesheet" href="{{ asset('css/historial.css') }}">
</head>
<body class="min-h-screen bg-slate-950 text-white overflow-x-hidden pb-24">

  <!-- Fondos decorativos -->
  <div class="fixed top-[-120px] left-[-120px] w-80 h-80 bg-green-500/30 rounded-full blur-3xl"></div>
  <div class="fixed bottom-[-120px] right-[-120px] w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>

  <!-- Página -->
  <div class="relative z-10">

    <!-- Header -->
    <header class="w-full px-6 md:px-12 py-5 border-b border-white/10">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        
        <!-- Logo -->
        <a href="{{ url("/") }}" class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-green-500 flex items-center justify-center text-2xl shadow-xl shadow-green-500/30">
            ♻️
          </div>
          <div>
            <h1 class="font-extrabold text-xl md:text-2xl leading-tight">Reporta Residuos Cusco</h1>
            <p class="text-xs md:text-sm text-green-200">Historial de Reportes</p>
          </div>
        </a>

        <!-- Botón volver -->
        <a href="{{ url("/principal") }}" class="px-4 py-2 rounded-full bg-green-500 hover:bg-green-400 text-slate-950 font-semibold text-sm transition">
          ← Volver al Mapa
        </a>
      </div>
    </header>

    <!-- Contenido Principal -->
    <main class="px-6 md:px-12 py-8">
      <div class="reportes-container">

        <!-- Título -->
        <div class="mb-8">
          <h2 class="text-3xl md:text-4xl font-extrabold mb-2">Historial de Reportes</h2>
          <p class="text-slate-400">Visualiza todos los reportes de residuos en Cusco</p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-6">
          <input 
            type="text" 
            id="searchInput" 
            placeholder="🔍 Buscar por dirección, descripción o ubicación..." 
            class="search-input w-full"
          >
        </div>

        <!-- Filtros -->
        <div class="mb-8 flex flex-wrap gap-3">
          <button class="filter-chip active" onclick="filtrar('todos')" data-filter="todos">
            Todos (0)
          </button>
          <button class="filter-chip" onclick="filtrar('grave')" data-filter="grave">
            🔴 Grave (0)
          </button>
          <button class="filter-chip" onclick="filtrar('moderado')" data-filter="moderado">
            🟡 Moderado (0)
          </button>
          <button class="filter-chip" onclick="filtrar('leve')" data-filter="leve">
            ✅ Leve (0)
          </button>
        </div>

        <!-- Indicador de carga -->
        <div id="loading" class="flex justify-center items-center py-12">
          <div class="spinner"></div>
        </div>

        <!-- Listado de reportes -->
        <div id="reportesContainer" class="hidden">

          <!-- Contador -->
          <div class="mb-4 text-sm text-slate-300">
            Se encontraron <span id="totalCount" class="font-bold text-green-300">0</span> reportes
          </div>

          <!-- Cards de reportes -->
          <div id="reportesList"></div>

          <!-- Paginación -->
          <div id="paginationContainer" class="hidden"></div>

        </div>

        <!-- Sin datos -->
        <div id="noData" class="hidden">
          <div class="no-data">
            <p class="text-2xl mb-2">📭</p>
            <p class="text-lg font-semibold">No se encontraron reportes</p>
            <p class="text-sm mt-2">Intenta con otros filtros o criterios de búsqueda</p>
          </div>
        </div>

      </div>
    </main>

  </div>

  <!-- Script -->
  <script>
    const URL_UPLOADS = '{{ asset('uploads') }}';
    const ITEMS_PER_PAGE = 10;
    let todosLosReportes = [];
    let reportesFiltrados = [];
    let paginaActual = 1;
    let filtroActual = 'todos';

    // Cargar reportes al iniciar
    document.addEventListener('DOMContentLoaded', () => {
      cargarReportes();
      document.getElementById('searchInput').addEventListener('input', aplicarFiltros);
    });

    // Cargar reportes desde el backend
    async function cargarReportes() {
      try {
        const response = await fetch('php/obtener_reportes.php');
        const data = await response.json();

        if (data.ok && data.reportes) {
          todosLosReportes = data.reportes;
          actualizarCuentasEnFiltros();
          aplicarFiltros();
        } else {
          console.error('Error al cargar reportes:', data.error);
          mostrarSinDatos();
        }
      } catch (error) {
        console.error('Error al conectar:', error);
        mostrarSinDatos();
      }
    }

    // Actualizar contadores en los filtros
    function actualizarCuentasEnFiltros() {
      const conteosGrave = todosLosReportes.filter(r => r.severidad === 'grave').length;
      const conteosModerat = todosLosReportes.filter(r => r.severidad === 'moderado').length;
      const conteosLeve = todosLosReportes.filter(r => r.severidad === 'leve').length;

      document.querySelector('[data-filter="todos"]').textContent = `Todos (${todosLosReportes.length})`;
      document.querySelector('[data-filter="grave"]').textContent = `🔴 Grave (${conteosGrave})`;
      document.querySelector('[data-filter="moderado"]').textContent = `🟡 Moderado (${conteosModerat})`;
      document.querySelector('[data-filter="leve"]').textContent = `✅ Leve (${conteosLeve})`;
    }

    // Filtrar reportes
    function filtrar(severidad) {
      filtroActual = severidad;
      paginaActual = 1;

      // Actualizar botones activos
      document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.classList.remove('active');
      });
      document.querySelector(`[data-filter="${severidad}"]`).classList.add('active');

      aplicarFiltros();
    }

    // Aplicar filtros y búsqueda
    function aplicarFiltros() {
      let resultado = todosLosReportes;

      // Filtro por severidad
      if (filtroActual !== 'todos') {
        resultado = resultado.filter(r => r.severidad === filtroActual);
      }

      // Búsqueda
      const searchTerm = document.getElementById('searchInput').value.toLowerCase();
      if (searchTerm) {
        resultado = resultado.filter(r => {
          const texto = `${r.direccion || ''} ${r.descripcion || ''}`.toLowerCase();
          return texto.includes(searchTerm);
        });
      }

      reportesFiltrados = resultado;
      paginaActual = 1;
      mostrarReportes();
    }

    // Mostrar reportes
    function mostrarReportes() {
      document.getElementById('loading').classList.add('hidden');

      if (reportesFiltrados.length === 0) {
        mostrarSinDatos();
        return;
      }

      const inicio = (paginaActual - 1) * ITEMS_PER_PAGE;
      const fin = inicio + ITEMS_PER_PAGE;
      const reportesPagina = reportesFiltrados.slice(inicio, fin);

      // Actualizar contador
      document.getElementById('totalCount').textContent = reportesFiltrados.length;

      // Mostrar reportes
      const contenedor = document.getElementById('reportesList');
      contenedor.innerHTML = reportesPagina.map(reporte => `
        <div class="reporte-card">
          <div class="flex items-start justify-between mb-3">
            <div>
              <h3 class="font-bold text-lg">${reporte.tipo || 'Reporte'}</h3>
              <p class="text-sm text-slate-400 mt-1">📍 ${reporte.direccion || 'Ubicación no especificada'}</p>
            </div>
            <span class="severidad-badge severidad-${reporte.severidad}">
              ${reporte.severidad.toUpperCase()}
            </span>
          </div>

          <p class="text-sm text-slate-300 mb-3">${reporte.descripcion || 'Sin descripción'}</p>

          <div class="flex flex-wrap gap-4 text-xs text-slate-400 mb-3 border-t border-white/10 pt-3">
            <span>📅 ${formatearFecha(reporte.fecha_reporte)}</span>
            <span>👤 ${reporte.nombre || 'Anónimo'}</span>
            <span>📍 ${reporte.latitud.toFixed(4)}, ${reporte.longitud.toFixed(4)}</span>
          </div>

          ${reporte.foto ? `
            <div class="mt-3">
              <img src="${URL_UPLOADS}/${reporte.foto}" alt="Foto del reporte" class="w-full max-h-64 rounded-lg object-cover border border-white/10">
            </div>
          ` : ''}
        </div>
      `).join('');

      // Mostrar paginación si es necesario
      const totalPaginas = Math.ceil(reportesFiltrados.length / ITEMS_PER_PAGE);
      if (totalPaginas > 1) {
        mostrarPaginacion(totalPaginas);
      } else {
        document.getElementById('paginationContainer').classList.add('hidden');
      }

      document.getElementById('reportesContainer').classList.remove('hidden');
      document.getElementById('noData').classList.add('hidden');
    }

    // Mostrar paginación
    function mostrarPaginacion(totalPaginas) {
      const paginationContainer = document.getElementById('paginationContainer');
      paginationContainer.classList.remove('hidden');

      let html = '';

      // Botón anterior
      html += `<button onclick="cambiarPagina(${paginaActual - 1})" ${paginaActual === 1 ? 'disabled' : ''}>← Anterior</button>`;

      // Números de página
      for (let i = 1; i <= totalPaginas; i++) {
        if (i === 1 || i === totalPaginas || (i >= paginaActual - 1 && i <= paginaActual + 1)) {
          html += `<button onclick="cambiarPagina(${i})" class="${paginaActual === i ? 'active' : ''}">${i}</button>`;
        } else if (i === 2 && paginaActual > 3) {
          html += `<span>...</span>`;
        } else if (i === totalPaginas - 1 && paginaActual < totalPaginas - 2) {
          html += `<span>...</span>`;
        }
      }

      // Botón siguiente
      html += `<button onclick="cambiarPagina(${paginaActual + 1})" ${paginaActual === totalPaginas ? 'disabled' : ''}>Siguiente →</button>`;

      paginationContainer.innerHTML = html;
    }

    // Cambiar página
    function cambiarPagina(pagina) {
      const totalPaginas = Math.ceil(reportesFiltrados.length / ITEMS_PER_PAGE);
      if (pagina >= 1 && pagina <= totalPaginas) {
        paginaActual = pagina;
        mostrarReportes();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    }

    // Mostrar sin datos
    function mostrarSinDatos() {
      document.getElementById('reportesContainer').classList.add('hidden');
      document.getElementById('noData').classList.remove('hidden');
      document.getElementById('loading').classList.add('hidden');
    }

    // Formatear fecha
    function formatearFecha(fecha) {
      const date = new Date(fecha);
      return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  </script>

</body>
</html>
