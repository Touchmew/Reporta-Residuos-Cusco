<?php

use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ZonaController;
use Illuminate\Support\Facades\Route;

// ── Página de inicio ──────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('index');
});

// ── Autenticación ─────────────────────────────────────────────────────────────
Route::get('/login',  [LoginController::class, 'mostrar']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── Rutas públicas adicionales ────────────────────────────────────────────────
Route::get('/reporte-residuos', function () {
    return view('reporte-residuos');
});

// ── Rutas protegidas (requieren sesión iniciada) ───────────────────────────────
Route::middleware('auth.sesion')->group(function () {
    Route::get('/principal', [PrincipalController::class, 'index']);
    Route::get('/historial', [HistorialController::class, 'index']);
    Route::get('/perfil',    [PerfilController::class,    'index']);
    Route::get('/page4',     [ZonaController::class,      'show']);
});

