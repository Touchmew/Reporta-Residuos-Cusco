<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ZonaController extends Controller
{
    public function show(Request $request): View
    {
        $reporte = Reporte::with(['comentarios.usuario'])->findOrFail($request->integer('id', 1));

        $zona = $reporte->toDetalleArray();

        return view('page4', compact('zona'));
    }
}
