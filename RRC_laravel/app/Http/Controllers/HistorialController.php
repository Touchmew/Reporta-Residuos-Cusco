<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\View\View;

/**
 * Controlador para gestionar el historial de reportes del usuario.
 */
class HistorialController extends Controller
{
    /**
     * Obtiene todos los reportes del usuario autenticado.
     * Los reportes se ordenan por fecha más reciente primero.
     */
    public function index(): View
    {
        $reportes = Reporte::with('usuario')
            ->where('usuario_id', session('usuario_id'))
            ->orderByDesc('fecha_reporte')
            ->get()
            ->map(fn (Reporte $r) => $r->toHistorialArray())
            ->values();

        return view('historial', compact('reportes'));
    }
}
