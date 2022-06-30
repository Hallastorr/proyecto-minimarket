<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('auth.login');
});

// Se activan todas las rutas para Producto y Cliente
// Además se requiere la autenticación para acceder al contenido
Route::resource('productos', ProductoController::class)->middleware('auth');
Route::resource('clientes', ClienteController::class)->middleware('auth');

Auth::routes();
// Establece que la ruta /home envie al usuario al index de productos
Route::get('/home', [ProductoController::class, 'index'])->name('home');

// Luego de que el usuario se autentifique será enviado al index de productos
Route::group(['middleware'=>'auth'], function(){
    Route::get('/', [ProductoController::class, 'index'])->name('home');
});
