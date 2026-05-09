<?php
/**
 * guardar_reporte.php
 * Recibe el POST desde page3.html, guarda en la BD y sube la foto.
 * 
 * CONFIGURACIÓN RÁPIDA:
 *   1. Pon este archivo en: C:/xampp/htdocs/reporta-residuos-cusco/php/
 *   2. Ejecuta db_setup.php UNA VEZ para crear la tabla
 *   3. Ajusta DB_* según tu instalación (por defecto XAMPP sin contraseña)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');   // Permite llamadas desde el mismo servidor
header('Access-Control-Allow-Methods: POST');

// ── Configuración de base de datos ───────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');                        // XAMPP por defecto no tiene contraseña
define('DB_NAME', 'reporta_residuos_cusco');

// ── Carpeta de uploads ────────────────────────────────────────────
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_URL', '../uploads/');

// ─────────────────────────────────────────────────────────────────

// Solo acepta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// ── Sanitizar y leer campos ───────────────────────────────────────
function limpiar(string $val): string {
    return htmlspecialchars(strip_tags(trim($val)));
}

$nombre      = limpiar($_POST['nombre']      ?? 'Anónimo');
$tipo        = limpiar($_POST['tipo']        ?? '');
$severidad   = limpiar($_POST['severidad']   ?? '');
$latitud     = (float) ($_POST['latitud']    ?? 0);
$longitud    = (float) ($_POST['longitud']   ?? 0);
$direccion   = limpiar($_POST['direccion']   ?? '');
$descripcion = limpiar($_POST['descripcion'] ?? '');
$fecha       = date('Y-m-d H:i:s');

// Validar campos obligatorios
if (empty($tipo) || empty($severidad) || $latitud === 0.0 || $longitud === 0.0 || empty($descripcion)) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos obligatorios']);
    exit;
}

// ── Subir foto (si viene) ─────────────────────────────────────────
$fotoNombre = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fotoTmp  = $_FILES['foto']['tmp_name'];
    $fotoOrig = $_FILES['foto']['name'];
    $fotoExt  = strtolower(pathinfo($fotoOrig, PATHINFO_EXTENSION));
    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fotoExt, $tiposPermitidos)) {
        http_response_code(400);
        echo json_encode(['error' => 'Tipo de archivo no permitido']);
        exit;
    }

    // Tamaño máximo: 10 MB
    if ($_FILES['foto']['size'] > 10 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'La foto supera los 10 MB']);
        exit;
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    $fotoNombre = 'reporte_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $fotoExt;
    move_uploaded_file($fotoTmp, UPLOAD_DIR . $fotoNombre);
}

// ── Conexión a la base de datos ───────────────────────────────────
$pdo = null;
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Si la BD no existe aún, devolver éxito igualmente
    // (el reporte ya se envió por WhatsApp)
    http_response_code(200);
    echo json_encode([
        'ok'      => true,
        'mensaje' => 'Reporte enviado por WhatsApp (BD no disponible: ' . $e->getMessage() . ')',
    ]);
    exit;
}

// ── Insertar en la tabla ──────────────────────────────────────────
$sql = "INSERT INTO reportes
          (nombre, tipo, severidad, latitud, longitud, direccion, descripcion, foto, fecha_reporte)
        VALUES
          (:nombre, :tipo, :severidad, :latitud, :longitud, :direccion, :descripcion, :foto, :fecha)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nombre'      => $nombre,
    ':tipo'        => $tipo,
    ':severidad'   => $severidad,
    ':latitud'     => $latitud,
    ':longitud'    => $longitud,
    ':direccion'   => $direccion,
    ':descripcion' => $descripcion,
    ':foto'        => $fotoNombre,
    ':fecha'       => $fecha,
]);

$nuevoId = $pdo->lastInsertId();

echo json_encode([
    'ok'      => true,
    'id'      => (int) $nuevoId,
    'mensaje' => 'Reporte guardado correctamente',
    'foto'    => $fotoNombre ? (UPLOAD_URL . $fotoNombre) : null,
]);
