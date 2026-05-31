<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\View\View;

class HistorialController extends Controller
{
    public function index(): View
    {
        $reportes = Reporte::with('usuario')
            ->orderByDesc('fecha_reporte')
            ->get()
            ->map(fn (Reporte $r) => $r->toHistorialArray())
            ->values();

        return view('historial', compact('reportes'));
    }
}
