<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipalidadController extends Controller
{
    public function index()
    {
        $reportes = DB::table('reportes')->get()->map(function ($r) {
            // Adaptar para la vista municipalidad.blade.php
            $r->zona = $r->direccion ?? $r->distrito;
            return $r;
        });

        $estadisticas = [
            'total'      => $reportes->count(),
            'pendientes' => $reportes->where('estado', 'pendiente')->count(),
            'proceso'    => $reportes->where('estado', 'en_proceso')->count(),
            'resueltos'  => $reportes->where('estado', 'resuelto')->count(),
        ];

        return view('municipalidad', compact('reportes', 'estadisticas'));
    }

    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_proceso,resuelto'
        ]);

        DB::table('reportes')
            ->where('id', $id)
            ->update([
                'estado' => $request->estado
            ]);

        return back()->with('success', 'Estado actualizado');
    }

    public function perfil()
    {
        $reportes = DB::table('reportes')->get();
        
        $estadisticas = [
            'gestionados' => $reportes->whereIn('estado', ['en_proceso', 'resuelto'])->count(),
            'resueltos'   => $reportes->where('estado', 'resuelto')->count(),
            'pendientes'  => $reportes->where('estado', 'pendiente')->count(),
        ];

        return view('municipalidad_perfil', compact('estadisticas'));
    }
}
