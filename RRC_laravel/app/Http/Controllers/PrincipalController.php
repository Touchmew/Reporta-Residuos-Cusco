<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\View\View;

class PrincipalController extends Controller
{
    public function index(): View
    {
        $reportes = Reporte::withCount('comentarios')->orderBy('id')->get();

        $zonas = $reportes->map(fn (Reporte $r) => $r->toMapaArray())->values();

        $stats = [
            'reportes_hoy' => Reporte::whereDate('fecha_reporte', today())->count(),
            'zonas_criticas' => Reporte::where('gravedad', 'grave')->count(),
            'atendidos_pct' => $reportes->isEmpty()
                ? 0
                : (int) round(Reporte::where('estado', 'resuelto')->count() / $reportes->count() * 100),
            'denuncias' => Reporte::where('categoria', 'basura_fuera_horario')->count(),
        ];

        return view('principal', compact('zonas', 'stats'));
    }
}
