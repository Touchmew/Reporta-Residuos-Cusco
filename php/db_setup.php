<?php
/**
 * db_setup.php
 * ════════════════════════════════════════════════════════════════
 * Crea la base de datos y la tabla de reportes.
 * 
 * ▶ CÓMO USAR:
 *   1. Inicia XAMPP (Apache + MySQL)
 *   2. Coloca el proyecto en: C:/xampp/htdocs/reporta-residuos-cusco/
 *   3. Abre en el navegador: http://localhost/reporta-residuos-cusco/php/db_setup.php
 *   4. Cuando veas "✅ Base de datos lista", ya puedes usar la app.
 *   5. ¡BORRA o renombra este archivo después! (seguridad)
 * ════════════════════════════════════════════════════════════════
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');   // Cambia si pusiste contraseña a MySQL en XAMPP
define('DB_NAME', 'reporta_residuos_cusco');

$log = [];

try {
    // Conectar SIN seleccionar base de datos primero
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // 1. Crear la base de datos si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $log[] = "✅ Base de datos <strong>" . DB_NAME . "</strong> creada o ya existente.";

    // 2. Seleccionar la base de datos
    $pdo->exec("USE `" . DB_NAME . "`");

    // 3. Crear tabla de reportes
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `reportes` (
            `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `nombre`          VARCHAR(120)  NOT NULL DEFAULT 'Anónimo'  COMMENT 'Nombre del reportante',
            `tipo`            VARCHAR(60)   NOT NULL                    COMMENT 'residuos | industrial | toxico | organico',
            `severidad`       ENUM('leve','moderado','grave') NOT NULL  COMMENT 'Nivel de gravedad',
            `latitud`         DECIMAL(10,7) NOT NULL                    COMMENT 'Coordenada GPS - latitud',
            `longitud`        DECIMAL(10,7) NOT NULL                    COMMENT 'Coordenada GPS - longitud',
            `direccion`       VARCHAR(255)  NOT NULL DEFAULT ''         COMMENT 'Dirección legible por geocodificación',
            `descripcion`     TEXT          NOT NULL                    COMMENT 'Descripción del problema',
            `foto`            VARCHAR(200)  NULL                        COMMENT 'Nombre del archivo de foto subido',
            `estado`          ENUM('pendiente','en_revision','resuelto') NOT NULL DEFAULT 'pendiente' COMMENT 'Estado del reporte',
            `fecha_reporte`   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `fecha_resolucion` DATETIME     NULL,
            INDEX `idx_severidad`  (`severidad`),
            INDEX `idx_estado`     (`estado`),
            INDEX `idx_fecha`      (`fecha_reporte`),
            INDEX `idx_coordenadas` (`latitud`, `longitud`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
          COMMENT='Tabla de reportes ciudadanos de residuos sólidos';
    ");
    $log[] = "✅ Tabla <strong>reportes</strong> creada o ya existente.";

    // 4. Insertar datos de ejemplo (solo si la tabla está vacía)
    $count = $pdo->query("SELECT COUNT(*) FROM reportes")->fetchColumn();
    if ((int)$count === 0) {
        $pdo->exec("
            INSERT INTO reportes (nombre, tipo, severidad, latitud, longitud, direccion, descripcion, estado) VALUES
            ('María Condori',  'residuos',    'grave',    -13.5183,  -71.9784, 'Av. Ejército 800, Cusco',       'Acumulación de bolsas de basura sin recoger por 3 días. Olor intenso y moscas.', 'pendiente'),
            ('Juan Huanca',    'organico',    'moderado', -13.5220,  -71.9750, 'Jr. Las Flores 240, Cusco',     'Restos orgánicos cerca al parque, afecta a los niños.', 'en_revision'),
            ('Rosa Quispe',    'industrial',  'grave',    -13.5210,  -71.9700, 'Av. La Cultura 1200, Cusco',    'Desmonte de construcción bloqueando la berma. Peligroso para conductores.', 'pendiente'),
            ('Pedro Vargas',   'residuos',    'leve',     -13.5150,  -71.9820, 'Plaza San Martín, Centro',      'Algunas bolsas sueltas cerca a los jardines.', 'resuelto')
        ");
        $log[] = "✅ Datos de ejemplo insertados (4 reportes).";
    } else {
        $log[] = "ℹ️ La tabla ya tiene datos ({$count} reportes). No se insertaron ejemplos.";
    }

    $log[] = "<br>🎉 <strong>Todo listo.</strong> Ya puedes usar la aplicación.<br>";
    $log[] = "⚠️ <strong>IMPORTANTE:</strong> Elimina o renombra este archivo por seguridad.";

} catch (PDOException $e) {
    $log[] = "❌ Error: " . $e->getMessage();
    $log[] = "<br><strong>Solución:</strong> Verifica que MySQL esté activo en XAMPP y que el usuario/contraseña sean correctos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Setup BD — Reporta Residuos Cusco</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #0B1F3A; color: #F8FEFB; padding: 40px; max-width: 640px; margin: 0 auto; }
    h1   { color: #1DB954; margin-bottom: 24px; }
    .log { background: #162D4E; border-radius: 12px; padding: 20px; line-height: 2; }
    a    { color: #1DB954; }
  </style>
</head>
<body>
  <h1>⚙️ Setup — Reporta Residuos Cusco</h1>
  <div class="log">
    <?php foreach ($log as $linea) echo "<div>{$linea}</div>"; ?>
  </div>
  <p style="margin-top:24px;color:#8FA8BF">
    Siguiente paso: <a href="../page1.html">Abrir la app →</a>
  </p>
</body>
</html>
