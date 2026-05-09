<?php
/**
 * obtener_reportes.php
 * Devuelve todos los reportes como JSON para el mapa (page2.html).
 *
 * Uso desde JavaScript:
 *   const res  = await fetch('php/obtener_reportes.php');
 *   const data = await res.json();
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'reporta_residuos_cusco');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo json_encode(['error' => 'BD no disponible', 'reportes' => []]);
    exit;
}

// Filtro opcional por severidad: ?severidad=grave
$severidad = $_GET['severidad'] ?? null;

if ($severidad) {
    $stmt = $pdo->prepare("SELECT * FROM reportes WHERE severidad = :sev ORDER BY fecha_reporte DESC");
    $stmt->execute([':sev' => $severidad]);
} else {
    $stmt = $pdo->query("SELECT * FROM reportes ORDER BY fecha_reporte DESC");
}

$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mapear severidad → nivel para los pines del mapa
foreach ($reportes as &$r) {
    $r['nivel'] = match($r['severidad']) {
        'grave'    => 'critico',
        'moderado' => 'moderado',
        'leve'     => 'limpio',
        default    => 'moderado',
    };
    // Limpiar datos sensibles si fuera necesario
    unset($r['nombre']); // No exponer nombre en el mapa público si lo deseas
}

echo json_encode([
    'ok'       => true,
    'total'    => count($reportes),
    'reportes' => $reportes,
]);
