<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador para gestionar la vista de municipalidad.
 * Permite visualizar, cambiar estado de reportes y ver estadísticas.
 */
class MunicipalidadController extends Controller
{
    /**
     * Muestra todos los reportes con estadísticas resumidas.
     */
    public function index()
    {
        $reportesModel = Reporte::withCount('comentarios')->orderBy('id')->get();

        $reportes = DB::table('reportes')->get()->map(function ($r) {
            // Adaptar para la vista municipalidad.blade.php
            $r->zona = $r->direccion ?? $r->distrito;
            return $r;
        });

        // Cargar evidencias y mapearlas por reporte_id
        $evidencias = DB::table('evidencias')->get()->keyBy('reporte_id');
        foreach ($reportes as $r) {
            $r->evidencia_ruta = isset($evidencias[$r->id]) ? $evidencias[$r->id]->ruta_imagen : null;
        }

        // Datos para el mapa (igual que PrincipalController)
        $zonas = $reportesModel->map(fn (Reporte $r) => $r->toMapaArray())->values();

        $estadisticas = [
            'total'      => $reportes->count(),
            'pendientes' => $reportes->where('estado', 'pendiente')->count(),
            'proceso'    => $reportes->where('estado', 'en_proceso')->count(),
            'resueltos'  => $reportes->where('estado', 'resuelto')->count(),
        ];

        return view('municipalidad', compact('reportes', 'estadisticas', 'zonas'));
    }

    /**
     * Actualiza el estado de un reporte (pendiente, en_proceso, resuelto).
     */
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

    /**
     * Muestra el detalle de un reporte desde el panel municipal.
     */
    public function detalle($id)
    {
        $reporte = Reporte::with(['comentarios.usuario'])->findOrFail($id);

        $zona = $reporte->toDetalleArray();

        // Cargar evidencia fotográfica si existe
        $evidencia = DB::table('evidencias')
            ->where('reporte_id', $reporte->id)
            ->first();

        return view('municipalidad_detalle', compact('zona', 'evidencia', 'reporte'));
    }

    /**
     * Muestra el perfil de la municipalidad con sus estadísticas.
     */
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

    /**
     * Calcula y muestra estadísticas detalladas por zona y categoría.
     */
    public function estadisticas()
    {
        $reportes = DB::table('reportes')->get();
        
        $estadisticas = [
            'total'       => $reportes->count(),
            'pendientes'  => $reportes->where('estado', 'pendiente')->count(),
            'proceso'     => $reportes->where('estado', 'en_proceso')->count(),
            'resueltos'   => $reportes->where('estado', 'resuelto')->count(),
        ];

        // Estadísticas por zona
        $reportesPorZona = $reportes->groupBy(function($item) {
            return $item->direccion ?? $item->distrito;
        })->map(function($group) {
            return [
                'zona' => $group->first()->direccion ?? $group->first()->distrito,
                'total' => $group->count(),
                'pendientes' => $group->where('estado', 'pendiente')->count(),
                'proceso' => $group->where('estado', 'en_proceso')->count(),
                'resueltos' => $group->where('estado', 'resuelto')->count(),
            ];
        })->values();

        // Estadísticas por categoría
        $reportesPorCategoria = $reportes->groupBy('categoria')->map(function($group) {
            return [
                'categoria' => $group->first()->categoria,
                'total' => $group->count(),
                'pendientes' => $group->where('estado', 'pendiente')->count(),
                'proceso' => $group->where('estado', 'en_proceso')->count(),
                'resueltos' => $group->where('estado', 'resuelto')->count(),
            ];
        })->values();

        return view('estadisticas', compact('estadisticas', 'reportesPorZona', 'reportesPorCategoria'));
    }
}
