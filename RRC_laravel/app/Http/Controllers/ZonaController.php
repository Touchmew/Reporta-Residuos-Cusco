<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador para mostrar detalles de un reporte específico.
 * Incluye información completa y todos los comentarios asociados.
 */
class ZonaController extends Controller
{
    /**
     * Muestra los detalles completos de un reporte incluyendo comentarios.
     */
    public function show(Request $request): View
    {
        $reporte = Reporte::with(['comentarios.usuario'])->findOrFail($request->integer('id', 1));

        $zona = $reporte->toDetalleArray();

        return view('page4', compact('zona'));
    }
}
