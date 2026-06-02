<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function mostrar()
    {
        return view('registro');
    }

    /**
     * Procesa el registro de un nuevo usuario ciudadano.
     */
    public function registrar(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|min:3|max:100',
            'correo'   => 'required|email|max:150',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'nombre.min'        => 'El nombre debe tener al menos 3 caracteres.',
            'correo.required'   => 'El correo es obligatorio.',
            'correo.email'      => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',
        ]);

        // Verificar que el correo no esté ya registrado
        $existe = DB::table('usuarios')->where('correo', $request->correo)->exists();

        if ($existe) {
            return back()
                ->withInput($request->only('nombre', 'correo', 'telefono'))
                ->withErrors(['correo' => 'Este correo ya está registrado. Prueba con otro o inicia sesión.']);
        }

        // Insertar nuevo usuario
        $id = DB::table('usuarios')->insertGetId([
            'nombre'   => $request->nombre,
            'correo'   => $request->correo,
            'telefono' => $request->telefono ?? null,
            'password' => Hash::make($request->password),
            'rol'      => 'ciudadano',
            'estado'   => 'activo',
        ]);

        // Guardar sesión automáticamente
        $request->session()->put('usuario_id', $id);
        $request->session()->put('nombre',     $request->nombre);
        $request->session()->put('correo',     $request->correo);
        $request->session()->put('rol',        'ciudadano');

        return redirect('/principal')->with('success', '¡Cuenta creada! Bienvenido a Reporta Residuos Cusco.');
    }
}
