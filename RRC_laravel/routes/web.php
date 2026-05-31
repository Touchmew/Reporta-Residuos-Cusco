<?php

use App\Http\Controllers\HistorialController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ZonaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/principal', [PrincipalController::class, 'index']);

Route::get('/historial', [HistorialController::class, 'index']);

Route::get('/perfil', [PerfilController::class, 'index']);

Route::get('/reporte-residuos', function () {
    return view('reporte-residuos');
});

Route::get('/page4', [ZonaController::class, 'show']);
