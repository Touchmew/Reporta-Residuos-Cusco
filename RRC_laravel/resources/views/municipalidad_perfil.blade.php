<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil Municipal — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/perfil.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/municipalidad.css') }}" />
</head>

<body class="min-h-screen bg-slate-950 text-white overflow-x-hidden" style="background-color: #0d1117;">

  <!-- Fondos decorativos -->
  <div class="fixed top-[-160px] left-[-120px] w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
  <div class="fixed bottom-[-180px] right-[-120px] w-[28rem] h-[28rem] bg-indigo-500/10 rounded-full blur-3xl"></div>

  <div class="relative z-10 min-h-screen flex flex-col">

    <!-- HEADER WEB -->
    <header class="w-full px-6 md:px-12 py-5 border-b border-white/10 bg-slate-950/60 backdrop-blur-xl sticky top-0 z-40">
      <nav class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <a href="{{ url('/municipalidad') }}" class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-2xl shadow-lg shadow-blue-500/30">
            🏛️
          </div>
          <div>
            <h1 class="font-extrabold text-xl md:text-2xl leading-tight">
              Reporta Residuos Cusco
            </h1>
            <p class="text-xs md:text-sm text-slate-300">
              Perfil Municipal
            </p>
          </div>
        </a>

        <a href="{{ url('/municipalidad') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/15 border border-white/10 text-sm font-semibold transition">
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
          <section class="rounded-[2rem] bg-[#161b22] border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-start xl:items-center gap-5 justify-between">
              <div class="flex items-center gap-5">
                <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-5xl shadow-xl shadow-blue-500/25">
                  🏛️
                </div>
                <div>
                  <p class="text-sm uppercase tracking-[0.25em] text-blue-300 font-bold">
                    Panel Administrativo
                  </p>
                  <h2 class="mt-2 text-3xl md:text-4xl font-extrabold leading-tight text-white">
                    {{ session('nombre', 'Almir Ticona') }}
                  </h2>
                  <p class="mt-2 text-[#8b949e]">📍 Cusco, Perú</p>
                  <p class="text-[#8b949e] text-sm">{{ session('correo', 'correo@municipalidad.gob.pe') }}</p>
                </div>
              </div>
              <div class="px-4 py-2 rounded-full bg-[#1DB954]/15 border border-[#1DB954]/30 text-[#1DB954] font-bold">
                🌱 Municipal
              </div>
            </div>

            <!-- Stats -->
            <div class="mt-8 grid grid-cols-3 gap-3">
              <div class="rounded-2xl bg-[#0d1117] border border-white/10 p-4 text-center">
                <p class="text-3xl font-extrabold text-blue-300">{{ $estadisticas['gestionados'] ?? 0 }}</p>
                <p class="text-xs text-[#8b949e] mt-1">Gestionados</p>
              </div>
              <div class="rounded-2xl bg-[#0d1117] border border-white/10 p-4 text-center">
                <p class="text-3xl font-extrabold text-[#1DB954]">{{ $estadisticas['resueltos'] ?? 0 }}</p>
                <p class="text-xs text-[#8b949e] mt-1">Resueltos</p>
              </div>
              <div class="rounded-2xl bg-[#0d1117] border border-white/10 p-4 text-center">
                <p class="text-3xl font-extrabold text-red-400">{{ $estadisticas['pendientes'] ?? 0 }}</p>
                <p class="text-xs text-[#8b949e] mt-1">Pendientes</p>
              </div>
            </div>
          </section>

          <!-- Acciones rápidas -->
          <section class="rounded-[2rem] bg-[#161b22] border border-white/10 backdrop-blur-xl p-6 shadow-xl">
            <h3 class="text-xl font-extrabold mb-4 text-white">Acciones rápidas</h3>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full rounded-2xl bg-red-500/10 hover:bg-red-500/20 border border-red-400/20 text-red-300 font-bold px-5 py-4 transition text-center">
                  🚪 Cerrar sesión
                </button>
            </form>
          </section>

        </aside>

        <!-- COLUMNA DERECHA -->
        <section class="space-y-6">
          <!-- Reportes recientes gestionados -->
          <div class="rounded-[2rem] bg-[#161b22] border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">
            <div class="mb-6">
              <p class="text-sm uppercase tracking-[0.25em] text-blue-300 font-bold">Resumen general</p>
              <h3 class="mt-2 text-2xl md:text-3xl font-extrabold text-white">Reportes del sistema</h3>
            </div>
            
            <div class="rounded-2xl bg-blue-500/10 border border-blue-400/20 p-4 text-sm text-blue-100 leading-relaxed mb-6">
              ℹ️ Ingresa al <a href="{{ url('/municipalidad') }}" class="font-bold underline">mapa principal</a> para gestionar y cambiar los estados de los reportes en tiempo real.
            </div>
            
          </div>
        </section>

      </section>
    </main>

  </div>
</body>
</html>