<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Perfil — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/perfil.css') }}" />
</head>

<body class="min-h-screen bg-slate-950 text-white overflow-x-hidden">

  <!-- Fondos decorativos -->
  <div class="fixed top-[-160px] left-[-120px] w-96 h-96 bg-green-500/20 rounded-full blur-3xl"></div>
  <div class="fixed bottom-[-180px] right-[-120px] w-[28rem] h-[28rem] bg-cyan-500/10 rounded-full blur-3xl"></div>
  <div class="fixed top-1/3 right-1/4 w-72 h-72 bg-emerald-400/10 rounded-full blur-3xl"></div>

  <div class="relative z-10 min-h-screen flex flex-col">

    <!-- HEADER WEB -->
    <header class="w-full px-6 md:px-12 py-5 border-b border-white/10 bg-slate-950/60 backdrop-blur-xl sticky top-0 z-40">
      <nav class="max-w-7xl mx-auto flex items-center justify-between gap-4">

        <a href="{{ url("/") }}" class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-green-500 flex items-center justify-center text-2xl shadow-lg shadow-green-500/30">
            ♻️
          </div>

          <div>
            <h1 class="font-extrabold text-xl md:text-2xl leading-tight">
              Reporta Residuos Cusco
            </h1>
            <p class="text-xs md:text-sm text-slate-300">
              Perfil ciudadano ambiental
            </p>
          </div>
        </a>

        <div class="hidden md:flex items-center gap-7 text-sm text-slate-300">
          <a href="{{ url("/") }}" class="hover:text-green-300 transition">Inicio</a>
          <a href="{{ url("/principal") }}" class="hover:text-green-300 transition">Mapa</a>
          <a href="{{ url("/reporte-residuos") }}" class="hover:text-green-300 transition">Reportar</a>
          <a href="{{ url("/perfil") }}" class="text-green-300 font-semibold">Perfil</a>
        </div>

        <a
          href="{{ url("/principal") }}"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/15 border border-white/10 text-sm font-semibold transition"
        >
          ← Volver al mapa
        </a>

      </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-1 px-6 md:px-12 py-8 md:py-12">
      <section class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-[0.9fr_1.1fr] gap-8 lg:gap-12 items-start">

        <!-- COLUMNA IZQUIERDA -->
        <aside class="space-y-6 lg:sticky lg:top-28">

          <!-- Tarjeta principal de perfil -->
          <section class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">

            <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-start xl:items-center gap-5 justify-between">

              <div class="flex items-center gap-5">
                <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-5xl shadow-xl shadow-green-500/25">
                  🧑
                </div>

                <div>
                  <p class="text-sm uppercase tracking-[0.25em] text-green-300 font-bold">
                    Bienvenido de vuelta
                  </p>
                  <h2 class="mt-2 text-3xl md:text-4xl font-extrabold leading-tight">
                    Carlos <span class="text-green-400">Quispe</span>
                  </h2>
                  <p class="mt-2 text-slate-300">
                    📍 Cusco, Perú
                  </p>
                </div>
              </div>

              <div class="px-4 py-2 rounded-full bg-green-500/15 border border-green-400/30 text-green-200 font-bold">
                🌱 Eco-Activo
              </div>

            </div>

            <!-- Stats -->
            <div class="mt-8 grid grid-cols-3 gap-3">
              <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4 text-center">
                <p class="text-3xl font-extrabold text-green-300" id="totalReportes">12</p>
                <p class="text-xs text-slate-300 mt-1">Reportes</p>
              </div>

              <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4 text-center">
                <p class="text-3xl font-extrabold text-green-300" id="resueltos">3</p>
                <p class="text-xs text-slate-300 mt-1">Resueltos</p>
              </div>

              <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4 text-center">
                <p class="text-3xl font-extrabold text-green-300" id="puntos">45</p>
                <p class="text-xs text-slate-300 mt-1">Puntos</p>
              </div>
            </div>

          </section>

          <!-- Progreso -->
          <section class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 shadow-xl">

            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm uppercase tracking-[0.25em] text-green-300 font-bold">
                  Progreso ambiental
                </p>
                <h3 class="mt-2 text-2xl font-extrabold">
                  Camino a Guardián Eco
                </h3>
              </div>

              <div class="text-right">
                <p class="text-2xl font-extrabold text-green-300" id="progressPct">45%</p>
                <p class="text-xs text-slate-300">45 / 100 pts</p>
              </div>
            </div>

            <div class="mt-6 w-full h-4 rounded-full bg-slate-900/80 overflow-hidden border border-white/10">
              <div
                class="h-full rounded-full bg-gradient-to-r from-green-400 to-emerald-500 shadow-lg shadow-green-500/30 transition-all duration-700"
                id="progressBar"
                style="width:45%"
              ></div>
            </div>

            <p class="mt-4 text-sm text-slate-300 leading-relaxed">
              Gana puntos al registrar reportes útiles, aportar evidencia y ayudar a identificar zonas críticas de contaminación.
            </p>

          </section>

          <!-- Acciones rápidas -->
          <section class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 shadow-xl">

            <h3 class="text-xl font-extrabold mb-4">
              Acciones rápidas
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
              <a
                href="{{ url("/reporte-residuos") }}"
                class="rounded-2xl bg-green-500 hover:bg-green-400 text-slate-950 font-bold px-5 py-4 transition shadow-lg shadow-green-500/20 text-center"
              >
                ➕ Crear nuevo reporte
              </a>

              <a
                href="{{ url("/principal") }}"
                class="rounded-2xl bg-white/10 hover:bg-white/15 border border-white/10 text-white font-bold px-5 py-4 transition text-center"
              >
                🗺️ Ver mapa de reportes
              </a>
            </div>

            <button
              class="mt-3 w-full rounded-2xl bg-red-500/10 hover:bg-red-500/20 border border-red-400/20 text-red-200 font-bold px-5 py-4 transition"
              onclick="cerrarSesion()"
            >
              🚪 Cerrar sesión
            </button>

          </section>

        </aside>

        <!-- COLUMNA DERECHA -->
        <section class="space-y-6">

          <!-- Reportes recientes -->
          <div class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
              <div>
                <p class="text-sm uppercase tracking-[0.25em] text-green-300 font-bold">
                  Actividad reciente
                </p>
                <h3 class="mt-2 text-2xl md:text-3xl font-extrabold">
                  Mis reportes recientes
                </h3>
              </div>

              <button
                class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/15 border border-white/10 text-sm font-semibold transition"
                onclick="mostrarToast('Historial completo próximamente')"
              >
                Ver todos →
              </button>
            </div>

            <div id="reportesList" class="space-y-4">
              <!-- generado por JS -->
            </div>

          </div>

          <!-- Logros -->
          <div class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">

            <div class="mb-6">
              <p class="text-sm uppercase tracking-[0.25em] text-green-300 font-bold">
                Reconocimientos
              </p>
              <h3 class="mt-2 text-2xl md:text-3xl font-extrabold">
                Mis logros
              </h3>
              <p class="mt-2 text-slate-300">
                Insignias obtenidas por participación ciudadana y reportes ambientales.
              </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4" id="logrosGrid">
              <!-- generado por JS -->
            </div>

          </div>

        </section>

      </section>
    </main>

    <!-- FOOTER -->
    <footer class="px-6 md:px-12 py-6 border-t border-white/10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-400">
        <p>Reporta Residuos Cusco · Perfil de usuario</p>
        <p>Proyecto académico orientado a la gestión de residuos sólidos</p>
      </div>
    </footer>

  </div>

  <!-- Toast -->
  <div id="toast"></div>

  <script>
    // ============================================================
    // DATOS DEL USUARIO
    // En producción: vendrían del backend PHP o Laravel
    // ============================================================
    const URL_DETALLE_ZONA = '{{ url('/page4') }}';
    const URL_INICIO = '{{ url('/') }}';

    const usuario = {
      nombre: 'Carlos Quispe Mamani',
      puntos: 45,
      puntosMax: 100,
      totalReportes: 12,
      resueltos: 3,
      rango: 'Eco-Activo',
    };

    const misReportes = [
      {
        nombre: 'Parque Industrial Sur',
        lugar: 'Av. Industrial 890',
        tipo: 'Desmonte',
        nivel: 'red',
        estado: 'pending',
        estadoLabel: 'Pendiente',
        zonaId: 4
      },
      {
        nombre: 'Mercado Los Olivos',
        lugar: 'Jr. Comercio 120',
        tipo: 'Residuos domésticos',
        nivel: 'green',
        estado: 'done',
        estadoLabel: 'Resuelto',
        zonaId: 1
      },
      {
        nombre: 'Esquina Bolívar',
        lugar: 'Calle Bolívar 45',
        tipo: 'Basura fuera de horario',
        nivel: 'purple',
        estado: 'review',
        estadoLabel: 'En revisión',
        zonaId: 2
      },
    ];

    const logros = [
      { icon: '🏅', nombre: 'Primer Reporte', pts: '+5 pts', desbloqueado: true },
      { icon: '🌱', nombre: 'Eco-Activo', pts: '+15 pts', desbloqueado: true },
      { icon: '🔟', nombre: '10 Reportes', pts: '+20 pts', desbloqueado: true },
      { icon: '🦸', nombre: 'Guardián', pts: '+30 pts', desbloqueado: false },
      { icon: '⭐', nombre: 'Estrella Eco', pts: '+25 pts', desbloqueado: false },
      { icon: '🏆', nombre: 'Héroe Cusco', pts: '+50 pts', desbloqueado: false },
    ];

    // ============================================================
    // RENDERIZAR REPORTES
    // ============================================================
    const indClasses = {
      red: 'bg-red-400',
      amber: 'bg-yellow-400',
      green: 'bg-green-400',
      purple: 'bg-purple-400'
    };

    const statusClasses = {
      pending: 'bg-yellow-500/10 text-yellow-300 border-yellow-400/20',
      done: 'bg-green-500/10 text-green-300 border-green-400/20',
      review: 'bg-purple-500/10 text-purple-300 border-purple-400/20'
    };

    document.getElementById('reportesList').innerHTML = misReportes.map(r => `
      <a
        href="${URL_DETALLE_ZONA}?id=${r.zonaId}"
        class="group flex flex-col sm:flex-row sm:items-center gap-4 rounded-3xl bg-slate-950/60 border border-white/10 hover:border-green-400/40 hover:bg-slate-900/80 transition p-5 text-white no-underline"
      >
        <div class="flex items-center gap-4 flex-1">
          <div class="w-4 h-16 rounded-full ${indClasses[r.nivel]}"></div>

          <div>
            <div class="font-extrabold text-lg group-hover:text-green-300 transition">
              ${r.nombre}
            </div>

            <div class="text-sm text-slate-300 mt-1">
              📍 ${r.lugar}
            </div>

            <div class="text-sm text-slate-400 mt-1">
              ♻️ ${r.tipo}
            </div>
          </div>
        </div>

        <div class="inline-flex justify-center px-4 py-2 rounded-full border text-sm font-bold ${statusClasses[r.estado]}">
          ${r.estadoLabel}
        </div>
      </a>
    `).join('');

    // ============================================================
    // RENDERIZAR LOGROS
    // ============================================================
    document.getElementById('logrosGrid').innerHTML = logros.map(l => `
      <div class="rounded-3xl border ${l.desbloqueado ? 'border-green-400/25 bg-green-500/10' : 'border-white/10 bg-slate-950/50 opacity-60'} p-5 text-center">
        <div class="text-4xl">${l.icon}</div>
        <div class="mt-3 font-extrabold">${l.nombre}</div>
        <div class="mt-1 text-sm ${l.desbloqueado ? 'text-green-300' : 'text-slate-400'}">
          ${l.desbloqueado ? l.pts : '🔒 Bloqueado'}
        </div>
      </div>
    `).join('');

    // ============================================================
    // ANIMAR BARRA DE PROGRESO
    // ============================================================
    window.addEventListener('load', () => {
      const pct = (usuario.puntos / usuario.puntosMax) * 100;

      document.getElementById('progressPct').textContent = `${usuario.puntos} / ${usuario.puntosMax} pts`;

      setTimeout(() => {
        document.getElementById('progressBar').style.width = `${pct}%`;
      }, 300);
    });

    // ============================================================
    // CERRAR SESIÓN
    // ============================================================
    function cerrarSesion() {
      if (confirm('¿Estás seguro que deseas cerrar sesión?')) {
        sessionStorage.clear();
        window.location.href = URL_INICIO;
      }
    }

    // ============================================================
    // TOAST
    // ============================================================
    function mostrarToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');

      setTimeout(() => {
        t.classList.remove('show');
      }, 2600);
    }
  </script>

</body>
</html>