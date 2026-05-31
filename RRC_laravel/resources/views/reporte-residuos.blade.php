<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Nuevo Reporte — Reporta Residuos Cusco</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="{{ asset('css/global.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/page3.css') }}" />
</head>

<body class="min-h-screen bg-slate-950 text-white overflow-x-hidden">

  <!-- Fondos decorativos -->
  <div class="fixed top-[-160px] left-[-120px] w-96 h-96 bg-green-500/20 rounded-full blur-3xl"></div>
  <div class="fixed bottom-[-180px] right-[-120px] w-[28rem] h-[28rem] bg-cyan-500/10 rounded-full blur-3xl"></div>

  <div class="relative z-10 min-h-screen flex flex-col">

    <!-- ===== HEADER WEB ===== -->
    <header class="w-full px-6 md:px-12 py-5 border-b border-white/10 bg-slate-950/50 backdrop-blur-xl sticky top-0 z-40">
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
              Sistema web de reportes ambientales
            </p>
          </div>
        </a>

        <div class="hidden md:flex items-center gap-7 text-sm text-slate-300">
          <a href="{{ url("/") }}" class="hover:text-green-300 transition">Inicio</a>
          <a href="{{ url("/principal") }}" class="hover:text-green-300 transition">Mapa</a>
          <a href="{{ url('/reporte-residuos') }}" class="text-green-300 font-semibold">Reportar</a>
          <a href="{{ url("/perfil") }}" class="hover:text-green-300 transition">Perfil</a>
        </div>

        <a
          href="{{ url("/principal") }}"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/15 border border-white/10 text-sm font-semibold transition"
        >
          ← Volver al mapa
        </a>

      </nav>
    </header>

    <!-- ===== CONTENIDO PRINCIPAL ===== -->
    <main class="flex-1 px-6 md:px-12 py-8 md:py-12">
      <section class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-[0.9fr_1.1fr] gap-8 lg:gap-12 items-start">

        <!-- ===== COLUMNA IZQUIERDA / INFORMACIÓN ===== -->
        <aside class="space-y-6 lg:sticky lg:top-28">

          <div class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-500/10 border border-green-400/20 text-green-200 text-sm mb-6">
              <span>📝</span>
              <span>Nuevo reporte ciudadano</span>
            </div>

            <h2 class="text-3xl md:text-5xl font-extrabold leading-tight tracking-tight">
              Informa un problema ambiental en
              <span class="text-green-400">tu zona</span>
            </h2>

            <p class="mt-5 text-slate-300 leading-relaxed">
              Registra acumulación de residuos, basura sacada fuera del horario,
              desmontes, residuos peligrosos o puntos críticos que afecten la limpieza
              urbana de Cusco.
            </p>

            <div class="mt-7 grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-3">
              <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4">
                <p class="font-bold text-green-300">1. Ubicación</p>
                <p class="text-sm text-slate-300 mt-1">Obtén las coordenadas GPS del incidente.</p>
              </div>

              <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4">
                <p class="font-bold text-green-300">2. Evidencia</p>
                <p class="text-sm text-slate-300 mt-1">Describe el problema y agrega una foto si es posible.</p>
              </div>

              <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4">
                <p class="font-bold text-green-300">3. Envío</p>
                <p class="text-sm text-slate-300 mt-1">Se genera un mensaje listo para enviar a la municipalidad.</p>
              </div>
            </div>
          </div>

          <!-- GPS Card -->
          <div class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 shadow-xl">
            <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-4 items-start xl:items-center justify-between">
              <div class="flex gap-4">
                <div class="w-14 h-14 rounded-2xl bg-green-500/15 flex items-center justify-center text-3xl">
                  📡
                </div>

                <div>
                  <div class="text-sm uppercase tracking-[0.2em] text-green-300 font-bold" id="gpsStatusLabel">
                    ⏳ Esperando GPS...
                  </div>

                  <div class="mt-1 font-bold text-white" id="gpsCoords">
                    Obteniendo coordenadas...
                  </div>

                  <div class="mt-1 text-sm text-slate-300" id="gpsAddress">
                    Activa el GPS para continuar
                  </div>
                </div>
              </div>

              <button
                type="button"
                class="px-5 py-3 rounded-2xl bg-green-500 hover:bg-green-400 text-slate-950 font-bold transition shadow-lg shadow-green-500/20"
                id="gpsBtn"
                onclick="obtenerGPS()"
              >
                Obtener
              </button>
            </div>

            <div class="mt-5 rounded-2xl bg-blue-500/10 border border-blue-400/20 p-4 text-sm text-blue-100 leading-relaxed">
              ℹ️ Para mayor precisión, permite el acceso a la ubicación desde el navegador.
            </div>
          </div>

        </aside>

        <!-- ===== COLUMNA DERECHA / FORMULARIO ===== -->
        <form
          class="rounded-[2rem] bg-white/10 border border-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl"
          id="reportForm"
          onsubmit="return false;"
        >

          <div class="mb-8">
            <p class="text-sm uppercase tracking-[0.25em] text-green-300 font-bold">
              Formulario de reporte
            </p>
            <h3 class="mt-2 text-2xl md:text-3xl font-extrabold">
              Datos del incidente
            </h3>
            <p class="mt-2 text-slate-300">
              Completa la información necesaria para generar el reporte.
            </p>
          </div>

          <input type="hidden" id="latInput" name="latitud" />
          <input type="hidden" id="lngInput" name="longitud" />
          <input type="hidden" id="addressInput" name="direccion" />

          <!-- Tipo de reporte -->
          <div class="mb-7">
            <label class="block text-sm uppercase tracking-[0.2em] text-slate-300 font-bold mb-3">
              Tipo de reporte
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="typeGrid">
              <div
                class="type-option selected rounded-2xl border border-green-400/60 bg-green-500/10 p-4 cursor-pointer flex gap-4 items-center transition hover:bg-white/10"
                data-type="residuos"
                onclick="seleccionarTipo(this)"
              >
                <span class="text-3xl">🗑️</span>
                <div>
                  <div class="font-bold">Residuos domésticos</div>
                  <div class="text-sm text-slate-300">Bolsas o basura acumulada</div>
                </div>
              </div>

              <div
                class="type-option rounded-2xl border border-white/10 bg-slate-900/50 p-4 cursor-pointer flex gap-4 items-center transition hover:bg-white/10"
                data-type="fuera_horario"
                onclick="seleccionarTipo(this)"
              >
                <span class="text-3xl">⏰</span>
                <div>
                  <div class="font-bold">Fuera de horario</div>
                  <div class="text-sm text-slate-300">Basura sacada antes o después</div>
                </div>
              </div>

              <div
                class="type-option rounded-2xl border border-white/10 bg-slate-900/50 p-4 cursor-pointer flex gap-4 items-center transition hover:bg-white/10"
                data-type="industrial"
                onclick="seleccionarTipo(this)"
              >
                <span class="text-3xl">🏗️</span>
                <div>
                  <div class="font-bold">Desmonte</div>
                  <div class="text-sm text-slate-300">Escombros o residuos de obra</div>
                </div>
              </div>

              <div
                class="type-option rounded-2xl border border-white/10 bg-slate-900/50 p-4 cursor-pointer flex gap-4 items-center transition hover:bg-white/10"
                data-type="toxico"
                onclick="seleccionarTipo(this)"
              >
                <span class="text-3xl">☣️</span>
                <div>
                  <div class="font-bold">Peligroso</div>
                  <div class="text-sm text-slate-300">Químicos, vidrios o contaminantes</div>
                </div>
              </div>

              <div
                class="type-option rounded-2xl border border-white/10 bg-slate-900/50 p-4 cursor-pointer flex gap-4 items-center transition hover:bg-white/10"
                data-type="organico"
                onclick="seleccionarTipo(this)"
              >
                <span class="text-3xl">🌿</span>
                <div>
                  <div class="font-bold">Orgánico</div>
                  <div class="text-sm text-slate-300">Restos vegetales o alimentos</div>
                </div>
              </div>

              <div
                class="type-option rounded-2xl border border-white/10 bg-slate-900/50 p-4 cursor-pointer flex gap-4 items-center transition hover:bg-white/10"
                data-type="punto_critico"
                onclick="seleccionarTipo(this)"
              >
                <span class="text-3xl">📍</span>
                <div>
                  <div class="font-bold">Punto crítico</div>
                  <div class="text-sm text-slate-300">Zona recurrente de acumulación</div>
                </div>
              </div>
            </div>

            <input type="hidden" id="tipoInput" name="tipo" value="residuos" />
          </div>

          <!-- Severidad -->
          <div class="mb-7">
            <label class="block text-sm uppercase tracking-[0.2em] text-slate-300 font-bold mb-3">
              Nivel de gravedad
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
              <button
                type="button"
                class="sev-btn rounded-2xl border border-green-400/30 bg-green-500/10 text-green-300 px-4 py-3 font-bold transition hover:bg-green-500/20"
                data-sev="leve"
                onclick="seleccionarSev(this)"
              >
                🟢 Leve
              </button>

              <button
                type="button"
                class="sev-btn rounded-2xl border border-yellow-400/30 bg-yellow-500/10 text-yellow-300 px-4 py-3 font-bold transition hover:bg-yellow-500/20"
                data-sev="moderado"
                onclick="seleccionarSev(this)"
              >
                🟡 Moderado
              </button>

              <button
                type="button"
                class="sev-btn active rounded-2xl border border-red-400/50 bg-red-500/15 text-red-300 px-4 py-3 font-bold transition hover:bg-red-500/20"
                data-sev="grave"
                onclick="seleccionarSev(this)"
              >
                🔴 Grave
              </button>
            </div>

            <input type="hidden" id="sevInput" name="severidad" value="grave" />
          </div>

          <!-- Descripción -->
          <div class="mb-7">
            <label
              class="block text-sm uppercase tracking-[0.2em] text-slate-300 font-bold mb-3"
              for="descripcion"
            >
              Descripción
            </label>

            <textarea
              class="w-full min-h-36 rounded-2xl bg-slate-900/60 border border-white/10 px-5 py-4 text-white placeholder:text-slate-400 outline-none focus:border-green-400/70 focus:ring-4 focus:ring-green-500/10 transition resize-y"
              id="descripcion"
              name="descripcion"
              placeholder="Ej: Vecinos dejan bolsas de basura fuera del horario de recojo. Hay mal olor y presencia de perros callejeros..."
              rows="5"
            ></textarea>
          </div>

          <!-- Datos extra -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-7">
            <div>
              <label
                class="block text-sm uppercase tracking-[0.2em] text-slate-300 font-bold mb-3"
                for="nombreReportante"
              >
                Tu nombre
              </label>

              <input
                type="text"
                class="w-full rounded-2xl bg-slate-900/60 border border-white/10 px-5 py-4 text-white placeholder:text-slate-400 outline-none focus:border-green-400/70 focus:ring-4 focus:ring-green-500/10 transition"
                id="nombreReportante"
                name="nombre"
                placeholder="Ej: Carlos Quispe"
              />
            </div>

            <div>
              <label
                class="block text-sm uppercase tracking-[0.2em] text-slate-300 font-bold mb-3"
                for="referencia"
              >
                Referencia
              </label>

              <input
                type="text"
                class="w-full rounded-2xl bg-slate-900/60 border border-white/10 px-5 py-4 text-white placeholder:text-slate-400 outline-none focus:border-green-400/70 focus:ring-4 focus:ring-green-500/10 transition"
                id="referencia"
                name="referencia"
                placeholder="Ej: Frente al mercado / esquina principal"
              />
            </div>
          </div>

          <!-- Foto -->
          <div class="mb-7">
            <label class="block text-sm uppercase tracking-[0.2em] text-slate-300 font-bold mb-3">
              Evidencia fotográfica
            </label>

            <div
              class="rounded-[1.5rem] border-2 border-dashed border-white/15 bg-slate-900/40 hover:bg-slate-900/70 hover:border-green-400/50 transition cursor-pointer p-8 text-center"
              id="dropzone"
              onclick="document.getElementById('fotoInput').click()"
            >
              <span class="block text-4xl">📷</span>
              <p class="mt-3 text-slate-200 font-semibold">Toca para agregar foto</p>
              <p class="mt-1 text-sm text-slate-400">JPG, PNG · Máx. 10 MB</p>
            </div>

            <input
              type="file"
              id="fotoInput"
              name="foto"
              accept="image/*"
              capture="environment"
              class="hidden"
              onchange="previewFoto(this)"
            />

            <img
              id="photo-preview"
              alt="Vista previa de la foto"
              class="hidden mt-4 w-full max-h-80 object-cover rounded-3xl border border-white/10"
            />
          </div>

          <!-- Nota informativa -->
          <div class="rounded-2xl bg-blue-500/10 border border-blue-400/20 p-4 text-sm text-blue-100 leading-relaxed mb-6">
            ℹ️ Al enviar, se abrirá WhatsApp con la información del reporte:
            coordenadas GPS, tipo de problema, gravedad, referencia y descripción.
          </div>

          <!-- Botón WhatsApp -->
          <button
            type="button"
            class="w-full rounded-2xl bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-400 hover:to-emerald-400 text-slate-950 font-extrabold px-6 py-4 text-lg transition shadow-xl shadow-green-500/20"
            id="btnWhatsapp"
            onclick="enviarReporte()"
          >
            💬 Enviar reporte a Municipalidad
          </button>

        </form>

      </section>
    </main>

    <!-- Footer -->
    <footer class="px-6 md:px-12 py-6 border-t border-white/10">
      <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-400">
        <p>Reporta Residuos Cusco · v1.0.0</p>
        <p>Proyecto académico orientado a la gestión de residuos sólidos</p>
      </div>
    </footer>

  </div>

  <!-- Toast -->
  <div id="toast"></div>

  <script>
    // ============================================================
    // NÚMERO DE WHATSAPP DE LA MUNICIPALIDAD
    // Cambia este número por el real: formato internacional sin +
    // Ejemplo: 51984123456 (Perú = 51)
    // ============================================================
    const WA_MUNICIPALIDAD = '51984000000';

    // ============================================================
    // GPS
    // ============================================================
    let gpsData = { lat: null, lng: null, address: '' };

    function obtenerGPS() {
      const btn = document.getElementById('gpsBtn');
      const statusLabel = document.getElementById('gpsStatusLabel');

      if (!navigator.geolocation) {
        mostrarToast('Tu navegador no soporta GPS');
        return;
      }

      btn.textContent = '...';
      btn.disabled = true;
      statusLabel.textContent = '⏳ Obteniendo ubicación...';

      navigator.geolocation.getCurrentPosition(
        async (pos) => {
          const { latitude, longitude, accuracy } = pos.coords;
          gpsData.lat = latitude;
          gpsData.lng = longitude;

          document.getElementById('latInput').value = latitude;
          document.getElementById('lngInput').value = longitude;
          document.getElementById('gpsCoords').textContent =
            `${latitude.toFixed(5)}°, ${longitude.toFixed(5)}°`;

          try {
            const res = await fetch(
              `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json&accept-language=es`
            );

            const data = await res.json();
            const addr = data.display_name || 'Cusco, Perú';

            gpsData.address = addr;
            document.getElementById('gpsAddress').textContent =
              addr.substring(0, 70) + (addr.length > 70 ? '...' : '');
            document.getElementById('addressInput').value = addr;
          } catch {
            gpsData.address = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
            document.getElementById('gpsAddress').textContent = 'Cusco, Perú';
          }

          statusLabel.textContent = '✅ GPS Detectado';
          statusLabel.style.color = '#4ade80';

          btn.textContent = 'Actualizar';
          btn.disabled = false;

          mostrarToast(`📍 Ubicación obtenida · precisión ${Math.round(accuracy)}m`);
        },
        () => {
          statusLabel.textContent = '❌ Error de GPS';
          statusLabel.style.color = '#fb7185';

          btn.textContent = 'Reintentar';
          btn.disabled = false;

          mostrarToast('No se pudo obtener la ubicación. Activa el GPS.');
        },
        { enableHighAccuracy: true, timeout: 10000 }
      );
    }

    window.addEventListener('load', obtenerGPS);

    // ============================================================
    // TIPO DE RESIDUO / REPORTE
    // ============================================================
    function seleccionarTipo(el) {
      document.querySelectorAll('.type-option').forEach(option => {
        option.classList.remove('selected', 'border-green-400/60', 'bg-green-500/10');
        option.classList.add('border-white/10', 'bg-slate-900/50');
      });

      el.classList.add('selected', 'border-green-400/60', 'bg-green-500/10');
      el.classList.remove('border-white/10', 'bg-slate-900/50');

      document.getElementById('tipoInput').value = el.dataset.type;
    }

    // ============================================================
    // SEVERIDAD
    // ============================================================
    function seleccionarSev(el) {
      document.querySelectorAll('.sev-btn').forEach(btn => {
        btn.classList.remove('active', 'ring-4', 'ring-white/10', 'scale-[1.02]');
      });

      el.classList.add('active', 'ring-4', 'ring-white/10', 'scale-[1.02]');
      document.getElementById('sevInput').value = el.dataset.sev;
    }

    // ============================================================
    // PREVIEW DE FOTO
    // ============================================================
    function previewFoto(input) {
      const file = input.files[0];
      if (!file) return;

      if (file.size > 10 * 1024 * 1024) {
        mostrarToast('⚠️ La imagen supera los 10 MB');
        input.value = '';
        return;
      }

      const reader = new FileReader();

      reader.onload = e => {
        const img = document.getElementById('photo-preview');
        img.src = e.target.result;
        img.classList.remove('hidden');

        const dz = document.getElementById('dropzone');
        dz.classList.add('border-green-400/50', 'bg-green-500/10');
        dz.querySelector('p').textContent = '✅ Foto seleccionada · Toca para cambiar';
      };

      reader.readAsDataURL(file);
    }

    // ============================================================
    // ENVIAR REPORTE VÍA WHATSAPP
    // ============================================================
    function enviarReporte() {
      const descripcion = document.getElementById('descripcion').value.trim();
      const nombre = document.getElementById('nombreReportante').value.trim() || 'Ciudadano anónimo';
      const referencia = document.getElementById('referencia').value.trim() || 'Sin referencia adicional';
      const tipo = document.getElementById('tipoInput').value;
      const severidad = document.getElementById('sevInput').value;
      const lat = document.getElementById('latInput').value;
      const lng = document.getElementById('lngInput').value;
      const direccion = document.getElementById('addressInput').value || 'Cusco, Perú';

      if (!lat || !lng) {
        mostrarToast('⚠️ Primero obtén tu ubicación GPS');
        return;
      }

      if (!descripcion) {
        mostrarToast('⚠️ Escribe una descripción del problema');
        document.getElementById('descripcion').focus();
        return;
      }

      const tipoLabel = {
        residuos: '🗑️ Residuos domésticos',
        fuera_horario: '⏰ Basura fuera del horario establecido',
        industrial: '🏗️ Desmonte / residuos de construcción',
        toxico: '☣️ Residuos peligrosos o contaminantes',
        organico: '🌿 Residuos orgánicos',
        punto_critico: '📍 Punto crítico de acumulación',
      }[tipo] || tipo;

      const sevLabel = {
        leve: '🟢 Leve',
        moderado: '🟡 Moderado',
        grave: '🔴 Grave / urgente',
      }[severidad] || severidad;

      const fecha = new Date().toLocaleString('es-PE', {
        timeZone: 'America/Lima'
      });

      const gmapsUrl = `https://maps.google.com/?q=${lat},${lng}`;

      const mensaje = [
        '🚨 *REPORTE DE RESIDUOS SÓLIDOS*',
        '🏛️ Sistema: Reporta Residuos Cusco',
        '',
        `👤 *Reportante:* ${nombre}`,
        `📅 *Fecha/Hora:* ${fecha}`,
        '',
        `📍 *Ubicación GPS:*`,
        `Lat: ${parseFloat(lat).toFixed(6)}`,
        `Lng: ${parseFloat(lng).toFixed(6)}`,
        `Dirección: ${direccion}`,
        `Referencia: ${referencia}`,
        `🗺️ Ver en mapa: ${gmapsUrl}`,
        '',
        `♻️ *Tipo de reporte:* ${tipoLabel}`,
        `⚠️ *Gravedad:* ${sevLabel}`,
        '',
        `📝 *Descripción:*`,
        descripcion,
        '',
        '─────────────────────',
        '_Enviado desde Reporta Residuos Cusco_',
      ].join('\n');

      const url = `https://wa.me/${WA_MUNICIPALIDAD}?text=${encodeURIComponent(mensaje)}`;

      guardarEnServidor({
        nombre,
        tipo,
        severidad,
        lat,
        lng,
        direccion,
        referencia,
        descripcion,
        fecha
      });

      window.open(url, '_blank');
      mostrarToast('✅ Abriendo WhatsApp...');
    }

    // ============================================================
    // GUARDAR EN SERVIDOR PHP
    // ============================================================
    async function guardarEnServidor(datos) {
      try {
        const form = new FormData();

        Object.entries(datos).forEach(([key, value]) => {
          form.append(key, value);
        });

        const fotoInput = document.getElementById('fotoInput');

        if (fotoInput.files.length > 0) {
          form.append('foto', fotoInput.files[0]);
        }

        const res = await fetch('php/guardar_reporte.php', {
          method: 'POST',
          body: form,
        });

        if (res.ok) {
          const json = await res.json();
          console.log('Reporte guardado:', json);
        }
      } catch {
        console.log('Servidor no disponible, solo se envió por WhatsApp');
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
      }, 2800);
    }
  </script>

</body>
</html>