<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function mostrar()
    {
        return view('login');
    }

    /**
     * Procesa las credenciales enviadas por el formulario.
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required',
        ]);

        $usuario = DB::table('usuarios')
            ->where('correo', $request->correo)
            ->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return back()
                ->withInput($request->only('correo'))
                ->withErrors(['credenciales' => 'Credenciales incorrectas.']);
        }

        // Guardar datos en sesión
        $request->session()->put('usuario_id', $usuario->id);
        $request->session()->put('nombre',     $usuario->nombre);
        $request->session()->put('correo',     $usuario->correo);
        $request->session()->put('rol',        $usuario->rol);

        if ($usuario->rol === 'municipalidad') {
            return redirect('/municipalidad');
        }

        return redirect('/principal');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/login');
    }
}
