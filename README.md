# 📱 Reporta Residuos Cusco
## Guía de instalación con XAMPP

---

## 📁 Estructura del proyecto

```
reporta-residuos-cusco/
├── page1.html          ← Bienvenida / Splash
├── page2.html          ← Mapa de zonas
├── page3.html          ← Nuevo reporte (GPS + WhatsApp)
├── page4.html          ← Detalle de zona
├── page5.html          ← Perfil ciudadano
│
├── css/
│   ├── global.css      ← Variables y estilos compartidos
│   ├── page1.css
│   ├── page2.css
│   ├── page3.css
│   ├── page4.css
│   └── page5.css
│
├── php/
│   ├── db_setup.php         ← Ejecutar UNA sola vez para crear la BD
│   ├── guardar_reporte.php  ← Recibe el formulario y guarda en MySQL
│   └── obtener_reportes.php ← Devuelve reportes en JSON para el mapa
│
├── uploads/            ← Se crea automáticamente al subir fotos
└── README.md
```

---

## 🚀 Instalación paso a paso

### 1. Instalar XAMPP
- Descarga desde: https://www.apachefriends.org/
- Instala y ejecuta el **Panel de Control de XAMPP**
- Inicia **Apache** y **MySQL** (botón "Start")

### 2. Copiar el proyecto
```
Copia la carpeta completa a:
C:/xampp/htdocs/reporta-residuos-cusco/
```

### 3. Crear la base de datos
Abre tu navegador y ve a:
```
http://localhost/reporta-residuos-cusco/php/db_setup.php
```
Verás un mensaje de "✅ Todo listo". Esto crea la base de datos `reporta_residuos_cusco` y la tabla `reportes` automáticamente.

> ⚠️ **Después de ejecutar, elimina `db_setup.php`** por seguridad.

### 4. Configurar el número de WhatsApp
Abre `page3.html` y busca esta línea (aprox. línea 20 del `<script>`):

```javascript
const WA_MUNICIPALIDAD = '51984000000';
```

Cámbiala por el número real de la municipalidad:
- **51** = código de Perú
- **9XXXXXXXX** = número de 9 dígitos sin el 0 inicial

Ejemplo: Si el número es `984 123 456`, escribe `51984123456`

### 5. Abrir la app
```
http://localhost/reporta-residuos-cusco/page1.html
```

---

## 🗄️ Base de datos

### Tabla `reportes`

| Campo            | Tipo           | Descripción                        |
|------------------|----------------|------------------------------------|
| id               | INT            | Clave primaria autoincremental     |
| nombre           | VARCHAR(120)   | Nombre del reportante              |
| tipo             | VARCHAR(60)    | residuos / industrial / toxico / organico |
| severidad        | ENUM           | leve / moderado / grave            |
| latitud          | DECIMAL(10,7)  | Coordenada GPS                     |
| longitud         | DECIMAL(10,7)  | Coordenada GPS                     |
| direccion        | VARCHAR(255)   | Dirección legible                  |
| descripcion      | TEXT           | Descripción del problema           |
| foto             | VARCHAR(200)   | Nombre del archivo subido          |
| estado           | ENUM           | pendiente / en_revision / resuelto |
| fecha_reporte    | DATETIME       | Fecha y hora del reporte           |
| fecha_resolucion | DATETIME       | Fecha de resolución (nullable)     |

---

## 🔧 Configuración PHP (`php/guardar_reporte.php` y `obtener_reportes.php`)

Si cambiaste la contraseña de MySQL en XAMPP, edita estas constantes al inicio de cada archivo PHP:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');       // ← Pon tu contraseña aquí
define('DB_NAME', 'reporta_residuos_cusco');
```

---

## 📲 Flujo de la app

```
page1.html  →  Bienvenida / Onboarding
    ↓
page2.html  →  Mapa con pines de zonas contaminadas
    ↓
page4.html  →  Detalle de una zona (click en pin o en lista)
    ↓
page3.html  →  Formulario de reporte (GPS + foto + WhatsApp)
    ↓
page5.html  →  Perfil del ciudadano + historial + logros
```

---

## 🛠️ Tecnologías usadas

| Tecnología         | Uso                                      |
|--------------------|------------------------------------------|
| HTML5              | Estructura de todas las páginas          |
| Tailwind CSS (CDN) | Clases utilitarias adicionales           |
| CSS personalizado  | Diseño principal (un archivo por página) |
| JavaScript         | Lógica en cada página (inline en HTML)   |
| Leaflet.js (CDN)   | Mapa interactivo (OpenStreetMap)         |
| PHP 8+             | Backend: guardar/leer reportes           |
| MySQL (XAMPP)      | Base de datos de reportes                |
| WhatsApp API       | Envío del reporte a la municipalidad     |
| Geolocation API    | GPS del dispositivo                      |
| Nominatim API      | Geocodificación inversa (gratis)         |

---

## ❓ Preguntas frecuentes

**¿Por qué no carga el mapa?**
Necesitas conexión a internet (usa OpenStreetMap). En localhost funciona normalmente.

**¿El GPS funciona en localhost?**
En Chrome/Edge: puede pedir permisos. En móvil funciona mejor. Para forzar HTTPS local, usa ngrok o un certificado local.

**¿Cómo veo los reportes guardados?**
Abre phpMyAdmin: http://localhost/phpmyadmin → base de datos `reporta_residuos_cusco` → tabla `reportes`

**¿Puedo usar esto sin XAMPP (solo WhatsApp)?**
Sí. Sin PHP, la app igual funciona: el GPS y el envío por WhatsApp funcionan solo con HTML/JS. Solo perderás el guardado en BD.
