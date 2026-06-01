<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crear cuenta — Reporta Residuos Cusco</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>
<body>

  <!-- ── OVERLAY ÉXITO ── -->
  <div class="success-overlay" id="successOverlay">
    <div class="suc-icon" id="sucIcon">🌱</div>
    <div class="suc-title" id="sucTitle">¡Cuenta creada!</div>
    <div class="suc-sub"   id="sucSub">Redirigiendo al mapa...</div>
  </div>

  <!-- Partículas -->
  <div id="particles"></div>

  <div class="page">

    <!-- Panel izquierdo decorativo (solo PC) -->
    <aside class="panel-left">
      <div class="pl-grid"></div>
      <div class="pl-content">
        <div class="pl-logo">
          <div class="pl-logo-icon">♻️</div>
          <div>
            <div class="pl-logo-name">Reporta Residuos <span>Cusco</span></div>
            <div class="pl-logo-sub">Plataforma ciudadana ambiental</div>
          </div>
        </div>

        <div class="pl-hero">
          <div class="pl-tag"><span>🌍</span> Cusco, Perú · 2026</div>

          <h2 class="pl-title">
            Únete a la<br>
            <em>comunidad</em><br>
            ciudadana
          </h2>

          <p class="pl-desc">
            Crea tu cuenta gratis y empieza a reportar puntos críticos de residuos
            en tu barrio. Tu participación ayuda a la municipalidad a actuar más rápido.
          </p>

          <div class="pl-stats">
            <div class="pl-stat">
              <div class="pl-stat-val">500+</div>
              <div class="pl-stat-lbl">ton/día generadas</div>
            </div>
            <div class="pl-stat">
              <div class="pl-stat-val">4</div>
              <div class="pl-stat-lbl">zonas activas</div>
            </div>
            <div class="pl-stat">
              <div class="pl-stat-val">Gratis</div>
              <div class="pl-stat-lbl">100% gratuito</div>
            </div>
          </div>

          <div class="pl-badge">
            <div class="pl-dot"></div>
            Sistema activo · San Jerónimo, Cusco
          </div>
        </div>
      </div>
    </aside>

    <!-- Panel derecho: formulario -->
    <main class="panel-right">
      <div class="card" id="regCard">

        <!-- Logo (solo móvil) -->
        <div class="card-logo">
          <div class="card-logo-icon">♻️</div>
          <div>
            <div class="card-logo-name">Reporta Residuos <span>Cusco</span></div>
            <div class="card-logo-sub">Plataforma ciudadana ambiental</div>
          </div>
        </div>

        <!-- Título -->
        <div class="form-title">Crear cuenta ciudadana</div>
        <div class="form-sub">Regístrate gratis y empieza a reportar</div>

        <!-- Error del servidor (correo ya registrado, etc.) -->
        @if ($errors->any())
          <div class="server-error" id="serverError">
            🔒 {{ $errors->first() }}
          </div>
        @endif

        <!-- Formulario POST -->
        <form id="regForm" action="{{ url('/registro') }}" method="POST" novalidate>
          @csrf

          <div class="field-group">

            <!-- Nombre completo -->
            <div class="field">
              <label class="field-lbl" for="iNombre">Nombre completo</label>
              <div class="field-wrap">
                <span class="field-ico">🧑</span>
                <input class="field-input {{ $errors->has('nombre') ? 'ferr' : '' }}"
                       id="iNombre" name="nombre" type="text"
                       placeholder="Ej: Juan Carlos Quispe"
                       value="{{ old('nombre') }}"
                       autocomplete="name"
                       oninput="valNombre()">
              </div>
              <div class="field-err" id="eNombre">
                @error('nombre') ❌ {{ $message }} @enderror
              </div>
            </div>

            <!-- Correo -->
            <div class="field">
              <label class="field-lbl" for="iCorreo">Correo electrónico</label>
              <div class="field-wrap">
                <span class="field-ico">✉️</span>
                <input class="field-input {{ $errors->has('correo') ? 'ferr' : '' }}"
                       id="iCorreo" name="correo" type="email"
                       placeholder="Ej: juan@gmail.com"
                       value="{{ old('correo') }}"
                       autocomplete="email" autocorrect="off"
                       autocapitalize="none" spellcheck="false"
                       oninput="valCorreo()">
              </div>
              <div class="field-err" id="eCorreo">
                @error('correo') ❌ {{ $message }} @enderror
              </div>
            </div>

            <!-- Teléfono (opcional) -->
            <div class="field">
              <label class="field-lbl" for="iTelefono">Teléfono <span class="opt-label">(opcional)</span></label>
              <div class="field-wrap">
                <span class="field-ico">📱</span>
                <input class="field-input"
                       id="iTelefono" name="telefono" type="tel"
                       placeholder="Ej: 987 654 321"
                       value="{{ old('telefono') }}"
                       autocomplete="tel">
              </div>
            </div>

            <!-- Contraseña -->
            <div class="field">
              <label class="field-lbl" for="iPwd">Contraseña</label>
              <div class="field-wrap">
                <span class="field-ico">🔑</span>
                <input class="field-input" id="iPwd" name="password" type="password"
                       placeholder="Mínimo 6 caracteres"
                       autocomplete="new-password"
                       oninput="valPwd()">
                <button type="button" class="eye-btn" id="eyeBtn"
                  onclick="togglePwd()" aria-label="Mostrar/ocultar contraseña">👁️</button>
              </div>
              <div class="field-err" id="ePwd"></div>
              <div class="pwd-hints">
                <span class="hint" id="h-len">6+ chars</span>
                <span class="hint" id="h-may">MAYÚSCULA</span>
                <span class="hint" id="h-num">número</span>
                <span class="hint" id="h-esp">especial</span>
              </div>
            </div>

            <!-- Confirmar contraseña -->
            <div class="field">
              <label class="field-lbl" for="iPwd2">Confirmar contraseña</label>
              <div class="field-wrap">
                <span class="field-ico">🔒</span>
                <input class="field-input" id="iPwd2" name="password_confirmation" type="password"
                       placeholder="Repite tu contraseña"
                       autocomplete="new-password"
                       oninput="valPwd2()">
                <button type="button" class="eye-btn" id="eyeBtn2"
                  onclick="togglePwd2()" aria-label="Mostrar/ocultar confirmación">👁️</button>
              </div>
              <div class="field-err" id="ePwd2"></div>
            </div>

          </div><!-- /field-group -->

          <button class="btn-login btn-c" type="button" id="btnReg" onclick="intentarRegistro()">
            <span>🌱</span>
            <span id="btnTxt">Crear cuenta ciudadana</span>
          </button>

        </form>

        <!-- Pie -->
        <div class="divider">o</div>
        <div class="card-footer">
          ¿Ya tienes cuenta? <a href="{{ url('/login') }}">Inicia sesión</a><br>
          <a href="{{ url('/') }}">← Volver al inicio</a>
        </div>

      </div>
    </main>
  </div>

  <div id="toast"></div>

  <script>
  let verPwd = false, verPwd2 = false;

  function g(id) { return document.getElementById(id); }

  function setF(inpId, errId, cls, msg) {
    const i = g(inpId), e = g(errId);
    if (!i || !e) return;
    i.classList.remove('ferr', 'fok');
    if (cls) i.classList.add(cls);
    e.innerHTML = msg ? `❌ ${msg}` : '';
  }

  function ht(id, ok) { const el = g(id); if (el) el.classList.toggle('ok', ok); }

  // ── Validaciones ──
  function valNombre() {
    const v = g('iNombre')?.value.trim() ?? '';
    if (!v) return setF('iNombre','eNombre','',''), false;
    if (v.length < 3) return setF('iNombre','eNombre','ferr','⚠ Mínimo 3 caracteres'), false;
    setF('iNombre','eNombre','fok',''); return true;
  }

  function valCorreo() {
    const v = g('iCorreo')?.value.trim() ?? '';
    if (!v) return setF('iCorreo','eCorreo','',''), false;
    if (!/^[^@]+@[^@]+\.[^@]+$/.test(v)) return setF('iCorreo','eCorreo','ferr','⚠ Ingresa un correo válido'), false;
    setF('iCorreo','eCorreo','fok',''); return true;
  }

  function valPwd() {
    const v = g('iPwd')?.value ?? '';
    ht('h-len', v.length >= 6);
    ht('h-may', /[A-Z]/.test(v));
    ht('h-num', /[0-9]/.test(v));
    ht('h-esp', /[^a-zA-Z0-9]/.test(v));
    if (!v) return setF('iPwd','ePwd','',''), false;
    if (v.length < 6) return setF('iPwd','ePwd','ferr','⚠ Mínimo 6 caracteres'), false;
    if (!/[A-Z]/.test(v)) return setF('iPwd','ePwd','ferr','⚠ Añade al menos una mayúscula'), false;
    if (!/[0-9]/.test(v)) return setF('iPwd','ePwd','ferr','⚠ Añade al menos un número'), false;
    if (!/[^a-zA-Z0-9]/.test(v)) return setF('iPwd','ePwd','ferr','⚠ Añade un carácter especial (!@#...)'), false;
    setF('iPwd','ePwd','fok','');
    if (g('iPwd2')?.value) valPwd2();
    return true;
  }

  function valPwd2() {
    const v1 = g('iPwd')?.value ?? '';
    const v2 = g('iPwd2')?.value ?? '';
    if (!v2) return setF('iPwd2','ePwd2','',''), false;
    if (v1 !== v2) return setF('iPwd2','ePwd2','ferr','⚠ Las contraseñas no coinciden'), false;
    setF('iPwd2','ePwd2','fok',''); return true;
  }

  // ── Registro ──
  function intentarRegistro() {
    const okN  = valNombre();
    const okC  = valCorreo();
    const okP  = valPwd();
    const okP2 = valPwd2();
    if (!okN || !okC || !okP || !okP2) {
      sacudir(); return;
    }

    const btn = g('btnReg');
    btn.disabled = true;
    btn.innerHTML = `<div class="spinner"></div><span>Creando cuenta...</span>`;
    setTimeout(() => g('regForm').submit(), 650);
  }

  // ── Mostrar éxito (llamado si la redirección no fue inmediata) ──
  function mostrarExito() {
    g('successOverlay').classList.add('show');
  }

  // ── Toggle contraseñas ──
  function togglePwd() {
    verPwd = !verPwd;
    const i = g('iPwd'), b = g('eyeBtn');
    if (i) i.type = verPwd ? 'text' : 'password';
    if (b) b.textContent = verPwd ? '🙈' : '👁️';
  }

  function togglePwd2() {
    verPwd2 = !verPwd2;
    const i = g('iPwd2'), b = g('eyeBtn2');
    if (i) i.type = verPwd2 ? 'text' : 'password';
    if (b) b.textContent = verPwd2 ? '🙈' : '👁️';
  }

  // ── Sacudir tarjeta ──
  function sacudir() {
    const card = g('regCard');
    const frames = [8, -8, 6, -6, 3, -2, 0];
    let i = 0;
    card.style.transition = 'transform 0.05s';
    const iv = setInterval(() => {
      card.style.transform = `translateX(${frames[i]}px)`;
      if (++i >= frames.length) { clearInterval(iv); card.style.transform = ''; }
    }, 50);
  }

  // ── Toast ──
  let toastTimer;
  function toast(msg, err = false) {
    const t = g('toast');
    t.textContent = msg;
    t.className = err ? 'toast-err show' : 'show';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.className = '', 3400);
  }

  // ── Partículas ──
  function crearParticulas() {
    const cont = g('particles');
    if (!cont) return;
    const emojis = ['♻️','🌿','💧','🌱','🍃','🌍'];
    const cantidad = window.innerWidth >= 900 ? 22 : 12;
    for (let i = 0; i < cantidad; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      const tamaño = Math.random() * 12 + 8;
      const izquierda = Math.random() * 100;
      const duracion = 8 + Math.random() * 12;
      const delay = Math.random() * 8;
      const desplazamiento = (Math.random() - 0.5) * 200;
      p.style.cssText = `left:${izquierda}vw;font-size:${tamaño}px;animation-duration:${duracion}s;animation-delay:${delay}s;--dx:${desplazamiento}px;`;
      p.textContent = emojis[Math.floor(Math.random() * emojis.length)];
      cont.appendChild(p);
    }
  }

  // ── Init ──
  window.addEventListener('load', () => {
    crearParticulas();
    if (document.getElementById('serverError')) {
      setTimeout(() => sacudir(), 300);
    }
  });
  </script>
</body>
</html>
