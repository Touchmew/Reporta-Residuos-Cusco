<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador para crear y gestionar reportes de residuos.
 * Maneja la creación de nuevos reportes con validación y categorización.
 */
class ReporteController extends Controller
{
    /**
     * Guarda un nuevo reporte de residuos.
     * Valida coordenadas, tipo y severidad del reporte.
     */
    public function guardar(Request $request)
    {
        // Validar datos básicos
        $request->validate([
            'latitud'     => 'required|numeric',
            'longitud'    => 'required|numeric',
            'descripcion' => 'required|string',
            'tipo'        => 'required|string',
            'severidad'   => 'required|string',
            'evidencia'   => 'nullable|image|max:10240',
        ]);

        // Mapeo de tipos a títulos legibles
        $tipoLabels = [
            'residuos'      => 'Residuos domésticos',
            'fuera_horario' => 'Basura fuera de horario',
            'industrial'    => 'Desmonte de obra',
            'toxico'        => 'Residuos peligrosos',
            'organico'      => 'Residuos orgánicos',
            'punto_critico' => 'Punto crítico de acumulación',
        ];

        // Mapeo de tipos a categorías exactas
        $categoriaMap = [
            'residuos'      => 'residuos',
            'industrial'    => 'desmonte',
            'fuera_horario' => 'basura_fuera_horario',
            'toxico'        => 'contaminacion',
            'organico'      => 'residuos',
            'punto_critico' => 'residuos'
        ];

        $titulo = 'Reporte de ' . ($tipoLabels[$request->tipo] ?? 'incidente');
        $categoria = $categoriaMap[$request->tipo] ?? 'residuos';

        // Insertar en la base de datos
        $reporteId = DB::table('reportes')->insertGetId([
            'usuario_id'  => session('usuario_id'),
            'titulo'      => $titulo,
            'descripcion' => $request->descripcion,
            'categoria'   => $categoria,
            'gravedad'    => $request->severidad,
            'estado'      => 'pendiente',
            'direccion'   => !empty($request->referencia) ? $request->referencia : (!empty($request->direccion) ? $request->direccion : 'Sin referencia'),
            'latitud'     => $request->latitud,
            'longitud'    => $request->longitud,
            'distrito'    => 'San Jerónimo',
        ]);

        // Guardar evidencia fotográfica si se subió una imagen
        if ($request->hasFile('evidencia')) {
            $ruta = $request->file('evidencia')->store('evidencias', 'public');

            DB::table('evidencias')->insert([
                'reporte_id'   => $reporteId,
                'ruta_imagen'  => $ruta,
            ]);
        }

        DB::table('comentarios')->insert([
            'reporte_id' => $reporteId,
            'usuario_id' => session('usuario_id'),
            'comentario' => $request->descripcion,
            'fecha_comentario' => now()
        ]);

        return redirect('/historial')->with('success', 'Reporte enviado correctamente');
    }
}
