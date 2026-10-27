<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaginaController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\VehiculosController;
use App\Http\Controllers\PerfilController; 
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ReparacionesController;
use App\Http\Controllers\TareasController;

Route::get('/', function () {return redirect()->route('login');});
Route::get('/inicio', [PaginaController::class, 'index'])->middleware('auth')->name("inicio");
Route::get('/sobre-nosotros', function () { return view('sobreNosotros');})->name('sobreNosotros');



// Perfil
Route::get('/perfil', [PerfilController::class, 'index']) ->middleware('auth') ->name('perfil');
Route::post('/perfil/guardar', [PerfilController::class, 'update']) ->middleware('auth') ->name('guardarPerfil');


// funciones para trabajdores
Route::middleware(['auth', \App\Http\Middleware\RolJefe::class])->group(function () {

    Route::get('/trabajadores', [UsuariosController::class, 'index']) ->name('gestionarTrabajadores');
    Route::get('/trabajadores/crear', [UsuariosController::class, 'create']) ->name('crearTrabajadores');
    Route::post('/trabajadores/guardar', [UsuariosController::class, 'store']) ->name('guardarTrabajadores');
    Route::get('/trabajadores/{id}/editar', [UsuariosController::class, 'edit']) ->name('editarTrabajadores');
    Route::post('/trabajadores/{id}/actualizar', [UsuariosController::class, 'update']) ->name('actualizarTrabajadores');
    Route::post('/trabajadores/{id}/resetContrasena', [UsuariosController::class, 'resetPassword']) ->name('resetearContrasena');
    Route::delete('/trabajadores/{id}/eliminar', [UsuariosController::class, 'destroy']) ->name('eliminarTrabajadores');

});


// funciones para clientes
Route::middleware(['auth', \App\Http\Middleware\RolJefe::class])->group(function () {

    Route::get('/clientes', [ClientesController::class, 'index']) ->name('gestionarClientes');
    Route::get('/clientes/crear', [ClientesController::class, 'create']) ->name('crearClientes');
    Route::post('/clientes/guardar', [ClientesController::class, 'store']) ->name('guardarClientes');
    Route::get('/clientes/{id}/editar', [ClientesController::class, 'edit']) ->name('editarClientes');
    Route::post('/clientes/{id}/actualizar', [ClientesController::class, 'update']) ->name('actualizarClientes');
    Route::delete('/clientes/{id}/eliminar', [ClientesController::class, 'destroy']) ->name('eliminarClientes');

    // Ruta AJAX para crear cliente desde modal
    Route::post('/clientes/ajax', [ClientesController::class, 'guardarAjax'])->name('guardarClienteAjax');

});


// funciones a vehiculos
Route::middleware(['auth', \App\Http\Middleware\RolJefe::class])->group(function () {

    Route::get('/vehiculos', [VehiculosController::class, 'index']) ->name('gestionarVehiculos');
    Route::get('/vehiculos/crear', [VehiculosController::class, 'create']) ->name('crearVehiculos');
    Route::post('/vehiculos/guardar', [VehiculosController::class, 'store']) ->name('guardarVehiculos');
    Route::get('/vehiculos/{id}/editar', [VehiculosController::class, 'edit']) ->name('editarVehiculos');
    Route::post('/vehiculos/{id}/actualizar', [VehiculosController::class, 'update']) ->name('actualizarVehiculos');
    Route::delete('/vehiculos/{id}/eliminar', [VehiculosController::class, 'destroy']) ->name('eliminarVehiculos');
    
    // Ruta AJAX para crear vehiculo desde modal
    Route::post('/vehiculos/ajax', [VehiculosController::class, 'guardarAjax'])->name('guardarVehiculoAjax');


});


//funciones para reparaciones
Route::middleware(['auth', \App\Http\Middleware\RolJefe::class])->group(function () {

    Route::get('/reparaciones', [ReparacionesController::class, 'index'])->name('gestionarReparaciones');
    Route::get('/reparaciones/crear', [ReparacionesController::class, 'create'])->name('crearReparaciones');
    Route::post('/reparaciones/guardar', [ReparacionesController::class, 'store'])->name('guardarReparaciones');
    Route::get('/reparaciones/{id}/editar', [ReparacionesController::class, 'edit'])->name('editarReparaciones');
    Route::post('/reparaciones/{id}/actualizar', [ReparacionesController::class, 'update'])->name('actualizarReparaciones');
    Route::delete('/reparaciones/{id}/eliminar', [ReparacionesController::class, 'destroy'])->name('eliminarReparaciones');

});


// funciones para tareas (JEFE)
Route::middleware(['auth', \App\Http\Middleware\RolJefe::class])->group(function () {

    Route::get('/tareas/crear/{idReparacion}', [TareasController::class, 'create'])->name('crearTarea');
    Route::post('/tareas/guardar', [TareasController::class, 'store'])->name('guardarTarea');
    Route::get('/tareas/{id}/editar', [TareasController::class, 'edit'])->name('editarTarea');
    Route::post('/tareas/{id}/actualizar', [TareasController::class, 'update'])->name('actualizarTarea');
    Route::delete('/tareas/{id}/eliminar', [TareasController::class, 'destroy'])->name('eliminarTarea');
    Route::get('/trabajadores/{id}/tareas', [TareasController::class, 'tareasTrabajador'])->name('tareasTrabajador');



});


// funciones para tareas (TRABAJADOR)
Route::middleware(['auth'])->group(function () {

    Route::get('/mis-tareas', [TareasController::class, 'misTareas'])->name('misTareas');
    Route::post('/mis-tareas/{id}/estado', [TareasController::class, 'actualizarEstado'])->name('actualizarEstadoTarea');
    Route::get('/mis-tareas/{id}', [TareasController::class, 'ver'])->name('verTarea');
    Route::post('/mis-tareas/{id}/actualizar', [TareasController::class, 'actualizarTrabajador'])->name('actualizarTareaTrabajador');
    Route::post('/mis-tareas/{id}/material', [TareasController::class, 'agregarMaterial'])->name('agregarMaterial');
    Route::delete('/mis-tareas/material/{id}', [TareasController::class, 'eliminarMaterial'])->name('eliminarMaterial');
    Route::post('/mis-tareas/{id}/foto', [TareasController::class, 'subirFoto'])->name('subirFoto');
    Route::delete('/tareas/foto/{idFoto}', [TareasController::class, 'eliminarFoto'])->name('eliminarFoto');
    Route::get('/tareas/foto/{id}/descargar', [TareasController::class, 'descargarFoto'])->name('descargarFoto');


});


//Calendario
Route::middleware(['auth'])->get('/calendario', [TareasController::class, 'calendario'])->name('calendario');


Route::post('/validar-dni', [ClientesController::class, 'validarDni'])->name('validarDni');
Route::post('/validar-matricula', [VehiculosController::class, 'validarMatricula'])->name('validarMatricula');


// autentificacion
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');