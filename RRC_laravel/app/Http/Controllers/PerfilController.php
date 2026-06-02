<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\View\View;

/**
 * Controlador para el perfil del usuario ciudadano.
 * Muestra estadísticas, reportes y logros del usuario.
 */
class PerfilController extends Controller
{
    /**
     * Obtiene datos del usuario incluyendo puntos, reportes y logros desbloqueados.
     */
    public function index(): View
    {
        $usuarioDb = Usuario::findOrFail(session('usuario_id'));

        $reportes = Reporte::where('usuario_id', $usuarioDb->id)
            ->orderByDesc('fecha_reporte')
            ->get();

        $totalReportes = $reportes->count();
        $resueltos = $reportes->where('estado', 'resuelto')->count();
        $puntos = ($totalReportes * 9) + ($resueltos * 5);
        $puntosMax = 100;

        $usuario = [
            'nombre' => $usuarioDb->nombre,
            'nombreCorto' => explode(' ', $usuarioDb->nombre)[0],
            'apellido' => trim(str_replace(explode(' ', $usuarioDb->nombre)[0], '', $usuarioDb->nombre)),
            'puntos' => min($puntos, $puntosMax),
            'puntosMax' => $puntosMax,
            'totalReportes' => $totalReportes,
            'resueltos' => $resueltos,
            'rango' => $puntos >= 50 ? 'Eco-Activo' : 'Ciudadano',
        ];

        $misReportes = $reportes->map(function (Reporte $r) {
            $estado = $r->estadoPerfil();

            return [
                'nombre' => $r->titulo,
                'lugar' => $r->direccion,
                'tipo' => $r->categoriaLabel(),
                'nivel' => $r->indicadorPerfil(),
                'estado' => $estado['key'],
                'estadoLabel' => $estado['label'],
                'zonaId' => $r->id,
            ];
        })->values();

        $logros = [
            ['icon' => '🏅', 'nombre' => 'Primer Reporte', 'pts' => '+5 pts', 'desbloqueado' => $totalReportes >= 1],
            ['icon' => '🌱', 'nombre' => 'Eco-Activo', 'pts' => '+15 pts', 'desbloqueado' => $totalReportes >= 3],
            ['icon' => '🔟', 'nombre' => '10 Reportes', 'pts' => '+20 pts', 'desbloqueado' => $totalReportes >= 10],
            ['icon' => '🦸', 'nombre' => 'Guardián', 'pts' => '+30 pts', 'desbloqueado' => $resueltos >= 3],
            ['icon' => '⭐', 'nombre' => 'Estrella Eco', 'pts' => '+25 pts', 'desbloqueado' => $resueltos >= 2],
            ['icon' => '🏆', 'nombre' => 'Héroe Cusco', 'pts' => '+50 pts', 'desbloqueado' => $totalReportes >= 5 && $resueltos >= 1],
        ];

        return view('perfil', compact('usuario', 'misReportes', 'logros'));
    }
}
