<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión — Reporta Residuos Cusco</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

  <!-- ── OVERLAY ÉXITO ── -->
  <div class="success-overlay" id="successOverlay">
    <div class="suc-icon" id="sucIcon">🌱</div>
    <div class="suc-title" id="sucTitle">¡Bienvenido!</div>
    <div class="suc-sub"   id="sucSub">Redirigiendo al sistema...</div>
  </div>

  <!-- Partículas -->
  <div id="particles"></div>

  <div class="page">

    <!-- ══════════════════════════════════
         PANEL IZQUIERDO (solo PC ≥ 900px)
    ══════════════════════════════════ -->
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
            Reporta residuos,<br>
            <em>transforma</em><br>
            tu ciudad
          </h2>

          <p class="pl-desc">
            Únete a la red ciudadana de reporte de residuos sólidos en Cusco.
            Registra puntos críticos, visualiza el mapa de zonas afectadas
            y ayuda a que la municipalidad actúe más rápido.
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
              <div class="pl-stat-val">3</div>
              <div class="pl-stat-lbl">roles de acceso</div>
            </div>
          </div>

          <div class="pl-badge">
            <div class="pl-dot"></div>
            Sistema activo · San Jerónimo, Cusco
          </div>
        </div>
      </div>
    </aside>

    <!-- ══════════════════════════════════
         PANEL DERECHO — formulario
    ══════════════════════════════════ -->
    <main class="panel-right">
      <div class="card" id="loginCard">

        <!-- Logo (solo visible en móvil) -->
        <div class="card-logo">
          <div class="card-logo-icon">♻️</div>
          <div>
            <div class="card-logo-name">Reporta Residuos <span>Cusco</span></div>
            <div class="card-logo-sub">Plataforma ciudadana ambiental</div>
          </div>
        </div>

        <!-- Título -->
        <div class="form-title">Iniciar sesión</div>
        <div class="form-sub">Accede con tu correo y contraseña</div>

        <!-- Selector de rol -->
        <div class="role-lbl">¿Quién eres?</div>
        <div class="role-tabs">
          <div class="role-tab act-c" data-rol="c" onclick="cambiarRol('c')">
            <span class="r-ico">👤</span>Ciudadano
          </div>
          <div class="role-tab" data-rol="m" onclick="cambiarRol('m')">
            <span class="r-ico">🏛️</span>Municipalidad
          </div>
        </div>

        <!-- Banner informativo -->
        <div class="role-banner bn-c" id="roleBanner">
          <span style="flex-shrink:0">🌱</span>
          <span id="bannerTxt">Accede para reportar puntos críticos y ver el mapa de residuos.</span>
        </div>

        <!-- Mensaje de error del servidor -->
        @if ($errors->has('credenciales'))
          <div class="server-error" id="serverError">
            🔒 {{ $errors->first('credenciales') }}
          </div>
        @endif
        @if ($errors->has('sesion'))
          <div class="server-error" id="serverError">
            ⚠️ {{ $errors->first('sesion') }}
          </div>
        @endif

        <!-- Formulario real POST -->
        <form id="loginForm" action="{{ url('/login') }}" method="POST" novalidate>
          @csrf

          <!-- Campo Correo -->
          <div class="field-group" id="fieldGroup">
            <div class="field">
              <label class="field-lbl" for="iCorreo">Correo electrónico</label>
              <div class="field-wrap">
                <span class="field-ico">✉️</span>
                <input class="field-input {{ $errors->has('correo') ? 'ferr' : '' }}"
                       id="iCorreo" name="correo" type="email"
                       placeholder="Ej: alvaro@reporta.pe"
                       value="{{ old('correo') }}"
                       autocomplete="email" autocorrect="off"
                       autocapitalize="none" spellcheck="false"
                       oninput="valCorreo()" onkeydown="enter(event)">
              </div>
              <div class="field-err" id="eCorreo">
                @error('correo') ❌ {{ $message }} @enderror
              </div>
            </div>

            <!-- Campo Contraseña -->
            <div class="field">
              <label class="field-lbl" for="iPwd">Contraseña</label>
              <div class="field-wrap">
                <span class="field-ico">🔑</span>
                <input class="field-input" id="iPwd" name="password" type="password"
                       placeholder="Tu contraseña segura"
                       autocomplete="current-password"
                       oninput="valPwd()" onkeydown="enter(event)">
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
          </div>

          <button class="btn-login btn-c" type="button" id="btnLogin" onclick="intentarLogin()">
            <span id="btnIco">👤</span>
            <span id="btnTxt">Entrar como ciudadano</span>
          </button>
        </form>

        <!-- Pie -->
        <div class="divider">o</div>
        <div class="card-footer">
          ¿Sin cuenta? <a href="{{ url('/registro') }}">Regístrate aquí</a><br>
          <a href="{{ url('/') }}">← Volver al inicio</a>
        </div>

      </div>
    </main>
  </div>

  <div id="toast"></div>

  <script>
  // ══════════════════════════════════════════════════════
  // CONFIGURACIÓN DE ROLES (sin credenciales hardcodeadas)
  // ══════════════════════════════════════════════════════

  const REDIRECT = { c:'{{ url("/principal") }}', m:'{{ url("/principal") }}' };

  const CFG = {
    c: {
      banner:   'Accede para reportar puntos críticos y ver el mapa de residuos en tu ciudad.',
      bnCls:    'bn-c', banIco: '🌱',
      btnCls:   'btn-c', btnIco: '👤', btnTxt: 'Entrar como ciudadano',
      tabCls:   'act-c', fcCls: '',
      uLabel:   'Nombre de usuario', uPh: 'Ej: carlos.quispe', uIco: '👤',
      sucIco:   '🌱', sucBg: 'linear-gradient(135deg,#14833B,#1DB954)',
      sucTitle: '¡Bienvenido, ciudadano!', sucSub: 'Accediendo al mapa...',
    },
    m: {
      banner:   'Acceso exclusivo para personal de limpieza e inspectores de la Municipalidad del Cusco.',
      bnCls:    'bn-m', banIco: '🏛️',
      btnCls:   'btn-m', btnIco: '🏛️', btnTxt: 'Entrar como trabajador',
      tabCls:   'act-m', fcCls: 'fc-m',
      uLabel:   'Código de trabajador', uPh: 'Ej: trabajador01', uIco: '🏛️',
      sucIco:   '🏛️', sucBg: 'linear-gradient(135deg,#1D4ED8,#3B82F6)',
      sucTitle: '¡Bienvenido, trabajador!', sucSub: 'Cargando panel municipal...',
    },
  };

  // Estado
  let rol = 'c', fallos = 0, bloq = null, verPwd = false;

  // ══════════════════════════════════════════════════════
  // CAMBIAR ROL
  // ══════════════════════════════════════════════════════
  function cambiarRol(r) {
    rol = r;
    const c = CFG[r];

    document.querySelectorAll('.role-tab').forEach(t => {
      t.className = 'role-tab';
      if (t.dataset.rol === r) t.classList.add(c.tabCls);
    });

    const bn = g('roleBanner');
    bn.className = `role-banner ${c.bnCls}`;
    bn.style.animation = 'none'; void bn.offsetWidth; bn.style.animation = '';
    bn.innerHTML = `<span style="flex-shrink:0">${c.banIco}</span><span>${c.banner}</span>`;

    const btn = g('btnLogin');
    btn.className = `btn-login ${c.btnCls}`;
    g('btnIco').textContent = c.btnIco;
    g('btnTxt').textContent = c.btnTxt;

    renderCampos();
    limpiarErr();
  }

  // ══════════════════════════════════════════════════════
  // ACTUALIZAR ESTILO DE CAMPOS según rol seleccionado
  // ══════════════════════════════════════════════════════
  function renderCampos() {
    const c = CFG[rol];
    const fg = g('fieldGroup');
    if (fg) fg.className = `field-group ${c.fcCls}`;
    verPwd = false;
  }

  // ══════════════════════════════════════════════════════
  // VALIDACIONES
  // ══════════════════════════════════════════════════════
  function valCorreo() {
    const v = g('iCorreo')?.value.trim() ?? '';
    if (!v)                       return setF('iCorreo','eCorreo','',''), false;
    if (!/^[^@]+@[^@]+\.[^@]+$/.test(v)) return setF('iCorreo','eCorreo','ferr','⚠ Ingresa un correo válido'), false;
    setF('iCorreo','eCorreo','fok',''); return true;
  }

  function valPwd() {
    const v = g('iPwd')?.value ?? '';
    ht('h-len', v.length >= 6);
    ht('h-may', /[A-Z]/.test(v));
    ht('h-num', /[0-9]/.test(v));
    ht('h-esp', /[^a-zA-Z0-9]/.test(v));
    if (!v)           return setF('iPwd','ePwd','',''), false;
    if (v.length < 6) return setF('iPwd','ePwd','ferr','⚠ Mínimo 6 caracteres'), false;
    setF('iPwd','ePwd','fok',''); return true;
  }

  function ht(id, ok) { const el=g(id); if(el) el.classList.toggle('ok',ok); }

  function setF(inpId, errId, cls, msg) {
    const i=g(inpId), e=g(errId);
    if(!i||!e) return;
    i.classList.remove('ferr','fok');
    if(cls) i.classList.add(cls);
    e.innerHTML = msg ? `❌ ${msg}` : '';
  }

  // ══════════════════════════════════════════════════════
  // LOGIN — valida en cliente y envía el formulario POST
  // ══════════════════════════════════════════════════════
  function intentarLogin() {
    if (bloq && Date.now() < bloq) {
      toast(`⏳ Bloqueado. Espera ${Math.ceil((bloq-Date.now())/1000)}s`, true); return;
    }

    const correo = g('iCorreo')?.value.trim() ?? '';
    const pwd    = g('iPwd')?.value ?? '';
    let ok = true;

    if (!correo) { setF('iCorreo','eCorreo','ferr','⚠ El correo es obligatorio'); ok=false; }
    if (!pwd)    { setF('iPwd','ePwd','ferr','⚠ La contraseña es obligatoria');   ok=false; }
    if (!ok) return;

    const btn = g('btnLogin');
    btn.disabled = true;
    btn.innerHTML = `<div class="spinner"></div><span>Verificando...</span>`;

    // Pequeño delay visual antes de submit real
    setTimeout(() => {
      g('loginForm').submit();
    }, 650);
  }

  function mostrarExito() {
    const c = CFG[rol];
    g('sucIcon').textContent  = c.sucIco;
    g('sucIcon').style.background = c.sucBg;
    g('sucIcon').style.boxShadow  = '0 10px 36px rgba(0,0,0,0.5)';
    g('sucTitle').textContent = c.sucTitle;
    g('sucSub').textContent   = c.sucSub;
    g('successOverlay').classList.add('show');
    setTimeout(() => window.location.href = REDIRECT[rol], 1900);
  }

  function sacudir() {
    const card = g('loginCard');
    const frames = [8,-8,6,-6,3,-2,0];
    let i = 0;
    card.style.transition = 'transform 0.05s';
    const iv = setInterval(() => {
      card.style.transform = `translateX(${frames[i]}px)`;
      if (++i >= frames.length) { clearInterval(iv); card.style.transform = ''; }
    }, 50);
  }

  function countdownBloq() {
    const iv = setInterval(() => {
      if (!bloq || Date.now() >= bloq) {
        clearInterval(iv); bloq = null; fallos = 0;
        const btn = g('btnLogin');
        if (btn) {
          btn.disabled = false;
          const c = CFG[rol];
          btn.innerHTML = `<span>${c.btnIco}</span><span>${c.btnTxt}</span>`;
        }
        toast('✅ Desbloqueado. Intenta de nuevo.', false);
      }
    }, 1000);
  }

  // ══════════════════════════════════════════════════════
  // UTILIDADES
  // ══════════════════════════════════════════════════════
  function togglePwd() {
    verPwd = !verPwd;
    const i=g('iPwd'), b=g('eyeBtn');
    if(i) i.type = verPwd ? 'text' : 'password';
    if(b) b.textContent = verPwd ? '🙈' : '👁️';
  }

  function enter(e) { if (e.key==='Enter') intentarLogin(); }

  function limpiarErr() {
    ['iCorreo','iPwd'].forEach(id => { const el=g(id); if(el) el.classList.remove('ferr','fok'); });
    ['eCorreo','ePwd'].forEach(id => { const el=g(id); if(el) el.innerHTML=''; });
  }

  function g(id) { return document.getElementById(id); }

  let toastTimer;
  function toast(msg, err=false) {
    const t = g('toast');
    t.textContent = msg;
    t.className = err ? 'toast-err show' : 'show';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.className='', 3400);
  }

  // ══════════════════════════════════════════════════════
  // PARTÍCULAS
  // ══════════════════════════════════════════════════════
  function crearParticulas() {
    const cont = g('particles');
    if (!cont) return;
    
    const emojis = ['♻️','🌿','💧','🌱','🍃','🌍'];
    const cantidad = window.innerWidth >= 900 ? 22 : 12;
    
    for (let i = 0; i < cantidad; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      
      const tamaño = Math.random() * 12 + 8; // 8px a 20px
      const izquierda = Math.random() * 100;
      const duracion = 8 + Math.random() * 12; // 8s a 20s
      const delay = Math.random() * 8; // 0s a 8s
      const desplazamiento = (Math.random() - 0.5) * 200; // -100px a 100px horizontal
      
      p.style.cssText = `
        left: ${izquierda}vw;
        font-size: ${tamaño}px;
        animation-duration: ${duracion}s;
        animation-delay: ${delay}s;
        --dx: ${desplazamiento}px;
        text-shadow: 0 0 8px rgba(29, 185, 84, 0.3);
        filter: drop-shadow(0 0 4px rgba(29, 185, 84, 0.2));
      `;
      p.textContent = emojis[Math.floor(Math.random() * emojis.length)];
      cont.appendChild(p);
    }
  }

  // Crear partículas continuamente cada 8 segundos
  function regenerarParticulas() {
    setInterval(() => {
      const cont = g('particles');
      if (!cont) return;
      
      // Limpiar partículas antiguas
      if (cont.children.length > 35) {
        const toRemove = cont.children.length - 25;
        for (let i = 0; i < toRemove; i++) {
          cont.removeChild(cont.firstChild);
        }
      }
      
      // Añadir nuevas partículas
      const emojis = ['♻️','🌿','💧','🌱','🍃','🌍'];
      for (let i = 0; i < 3; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        
        const tamaño = Math.random() * 12 + 8;
        const izquierda = Math.random() * 100;
        const duracion = 8 + Math.random() * 12;
        const delay = Math.random() * 2;
        const desplazamiento = (Math.random() - 0.5) * 200;
        
        p.style.cssText = `
          left: ${izquierda}vw;
          font-size: ${tamaño}px;
          animation-duration: ${duracion}s;
          animation-delay: ${delay}s;
          --dx: ${desplazamiento}px;
          text-shadow: 0 0 8px rgba(29, 185, 84, 0.3);
          filter: drop-shadow(0 0 4px rgba(29, 185, 84, 0.2));
        `;
        p.textContent = emojis[Math.floor(Math.random() * emojis.length)];
        cont.appendChild(p);
      }
    }, 8000);
  }

  // ══════════════════════════════════════════════════════
  // INIT
  // ══════════════════════════════════════════════════════
  window.addEventListener('load', () => {
    crearParticulas();
    regenerarParticulas();
    cambiarRol('c');

    // Si hay error del servidor, sacudir la tarjeta
    if (document.getElementById('serverError')) {
      setTimeout(() => sacudir(), 300);
    }
  });
  </script>
</body>
</html>