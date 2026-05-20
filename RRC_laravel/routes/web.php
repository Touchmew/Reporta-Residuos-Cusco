<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/principal', function () {
    return view('principal');
});

Route::get('/historial', function () {
    return view('historial');
});

Route::get('/perfil', function () {
    return view('perfil');
});

Route::get('/reporte-residuos', function () {
    return view('reporte-residuos');
});

Route::get('/page4', function () {
    return view('page4');
});