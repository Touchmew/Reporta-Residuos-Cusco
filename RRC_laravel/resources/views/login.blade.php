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
        <div class="form-sub">Selecciona tu rol y accede al sistema</div>

        <!-- Selector de rol -->
        <div class="role-lbl">¿Quién eres?</div>
        <div class="role-tabs">
          <div class="role-tab act-c" data-rol="c" onclick="cambiarRol('c')">
            <span class="r-ico">👤</span>Ciudadano
          </div>
          <div class="role-tab" data-rol="m" onclick="cambiarRol('m')">
            <span class="r-ico">🏛️</span>Municipalidad
          </div>
          <div class="role-tab" data-rol="a" onclick="cambiarRol('a')">
            <span class="r-ico">🛡️</span>Admin
          </div>
        </div>

        <!-- Banner informativo -->
        <div class="role-banner bn-c" id="roleBanner">
          <span style="flex-shrink:0">🌱</span>
          <span id="bannerTxt">Accede para reportar puntos críticos y ver el mapa de residuos.</span>
        </div>

        <!-- Campos y botón -->
        <div class="field-group" id="fieldGroup"></div>

        <button class="btn-login btn-c" id="btnLogin" onclick="intentarLogin()">
          <span id="btnIco">👤</span>
          <span id="btnTxt">Entrar como ciudadano</span>
        </button>

        <!-- Pie -->
        <div class="divider">o</div>
        <div class="card-footer">
          ¿Sin cuenta? <a href="#" onclick="toast('Registro próximamente 🚀',false);return false;">Regístrate aquí</a><br>
          <a href="{{ url("/") }}">← Volver al inicio</a>
        </div>

      </div>
    </main>
  </div>

  <div id="toast"></div>

  <script>
  // ══════════════════════════════════════════════════════
  // CREDENCIALES Y CONFIGURACIÓN
  // ══════════════════════════════════════════════════════
  const CREDS = {
    c: [
      { u:'ciudadano',     p:'Cusco2026!'    },
      { u:'carlos.quispe', p:'Carlos123#'    },
      { u:'maria.condori', p:'Maria456@'     },
    ],
    m: [
      { u:'trabajador01',   p:'Muni@2026'    },
      { u:'limpieza.cusco', p:'Residuos#1'   },
      { u:'inspector01',    p:'Inspector99!' },
    ],
    a: [
      { u:'admin',       p:'Admin@Cusco2026!' },
      { u:'superadmin',  p:'SuperAdmin#99'    },
    ],
  };

  const REDIRECT = { c:'{{ url("/principal") }}', m:'{{ url("/principal") }}', a:'{{ url("/principal") }}' };

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
    a: {
      banner:   'Acceso restringido al panel de administración. Solo personal autorizado.',
      bnCls:    'bn-a', banIco: '🛡️',
      btnCls:   'btn-a', btnIco: '🛡️', btnTxt: 'Entrar como administrador',
      tabCls:   'act-a', fcCls: 'fc-a',
      uLabel:   'Usuario administrador', uPh: 'Ej: admin', uIco: '🛡️',
      sucIco:   '🛡️', sucBg: 'linear-gradient(135deg,#B45309,#F59E0B)',
      sucTitle: '¡Bienvenido, admin!', sucSub: 'Cargando panel de control...',
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
  // RENDERIZAR CAMPOS
  // ══════════════════════════════════════════════════════
  function renderCampos() {
    const c = CFG[rol];
    const fg = g('fieldGroup');
    fg.className = `field-group ${c.fcCls}`;
    verPwd = false;

    fg.innerHTML = `
      <div class="field">
        <label class="field-lbl">${c.uLabel}</label>
        <div class="field-wrap">
          <span class="field-ico">${c.uIco}</span>
          <input class="field-input" id="iUser" type="text"
            placeholder="${c.uPh}"
            autocomplete="username" autocorrect="off"
            autocapitalize="none" spellcheck="false"
            inputmode="text"
            oninput="valUser()" onkeydown="enter(event)">
        </div>
        <div class="field-err" id="eUser"></div>
      </div>

      <div class="field">
        <label class="field-lbl">Contraseña</label>
        <div class="field-wrap">
          <span class="field-ico">🔑</span>
          <input class="field-input" id="iPwd" type="password"
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
    `;
  }

  // ══════════════════════════════════════════════════════
  // VALIDACIONES
  // ══════════════════════════════════════════════════════
  function valUser() {
    const v = g('iUser')?.value.trim() ?? '';
    if (!v)           return setF('iUser','eUser','',''), false;
    if (v.length < 3) return setF('iUser','eUser','ferr','⚠ Mínimo 3 caracteres'), false;
    if (/\s/.test(v)) return setF('iUser','eUser','ferr','⚠ Sin espacios en el usuario'), false;
    setF('iUser','eUser','fok',''); return true;
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
  // LOGIN
  // ══════════════════════════════════════════════════════
  function intentarLogin() {
    if (bloq && Date.now() < bloq) {
      toast(`⏳ Bloqueado. Espera ${Math.ceil((bloq-Date.now())/1000)}s`, true); return;
    }

    const u = g('iUser')?.value.trim() ?? '';
    const p = g('iPwd')?.value ?? '';
    let ok = true;

    if (!u) { setF('iUser','eUser','ferr','⚠ El usuario es obligatorio'); ok=false; }
    if (!p) { setF('iPwd','ePwd','ferr','⚠ La contraseña es obligatoria'); ok=false; }
    if (!ok) return;

    const btn = g('btnLogin');
    btn.disabled = true;
    btn.innerHTML = `<div class="spinner"></div><span>Verificando...</span>`;

    setTimeout(() => {
      const match = (CREDS[rol]||[]).find(c => c.u===u && c.p===p);

      if (match) {
        fallos = 0;
        sessionStorage.setItem('loggedIn','true');
        sessionStorage.setItem('rol',rol);
        sessionStorage.setItem('usuario',u);
        mostrarExito();
      } else {
        fallos++;
        btn.disabled = false;
        const c = CFG[rol];
        btn.innerHTML = `<span>${c.btnIco}</span><span>${c.btnTxt}</span>`;

        if (fallos >= 5) {
          bloq = Date.now() + 30000;
          toast('🔒 5 intentos fallidos. Bloqueado 30 segundos.', true);
          countdownBloq();
        } else {
          const r = 5 - fallos;
          toast(`❌ Credenciales incorrectas · ${r} intento${r!==1?'s':''} restante${r!==1?'s':''}`, true);
          sacudir();
          setF('iUser','eUser','ferr','');
          setF('iPwd','ePwd','ferr','⚠ Usuario o contraseña incorrectos');
        }
      }
    }, 850);
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
    ['iUser','iPwd'].forEach(id => { const el=g(id); if(el) el.classList.remove('ferr','fok'); });
    ['eUser','ePwd'].forEach(id => { const el=g(id); if(el) el.innerHTML=''; });
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
  });
  </script>
</body>
</html>