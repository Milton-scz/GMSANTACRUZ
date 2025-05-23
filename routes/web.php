<?php

use App\Http\Controllers\ActividadEconomicaController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//GESTIONAR USUARIOS
 Route::get('/admin-users', [UsersController::class, 'index'])->name('admin.users');
        Route::get('/admin-users/create', [UsersController::class, 'create'])->name('admin.users.create');
        Route::post('/admin-users/register', [UsersController::class, 'store'])->name('admin.users.register');
        Route::get('/admin-users/edit/{user_id}', [UsersController::class, 'edit'])->name('admin.users.edit');
        Route::patch('/admin-users/edit/{user_id}', [UsersController::class, 'update'])->name('admin.users.update');
        Route::delete('admin-users/destroy/{user_id}',  [UsersController::class, 'destroy'])->name('admin.users.delete');

        //GESTIONAR SOLICITUDES
 Route::get('/admin-solicitudes', [SolicitudController::class, 'index'])->name('admin.solicitudes');
        Route::get('/admin-solicitudes/create', [SolicitudController::class, 'create'])->name('admin.solicitudes.create');
        Route::post('/admin-solicitudes/store', [SolicitudController::class, 'store'])->name('admin.solicitudes.store');
        Route::get('/admin-solicitudes/edit/{solicitud_id}', [SolicitudController::class, 'edit'])->name('admin.solicitudes.edit');
        Route::patch('/admin-solicitudes/edit/{solicitud_id}', [SolicitudController::class, 'update'])->name('admin.solicitudes.update');
        Route::delete('admin-solicitudes/destroy/{solicitud_id}',  [SolicitudController::class, 'destroy'])->name('admin.solicitudes.delete');


        //GESTIONAR ACTIVIDAD ECONOMICA
Route::get('/admin-actividad-economica', [ActividadEconomicaController::class, 'index'])->name('admin.actividad-economica');
Route::get('/admin-actividad-economica/create', [ActividadEconomicaController::class, 'create'])->name('admin.actividad-economica.create');
Route::post('/admin-actividad-economica/register', [ActividadEconomicaController::class, 'store'])->name('admin.actividad-economica.register');
Route::get('/admin-actividad-economica/edit/{actividad_economica_id}', [ActividadEconomicaController::class, 'edit'])->name('admin.actividad-economica.edit');
Route::patch('/admin-actividad-economica/edit/{actividad_economica_id}', [ActividadEconomicaController::class, 'update'])->name('admin.actividad-economica.update');
        Route::delete('admin-actividad-economica/destroy/{actividad_economica_id}',  [ActividadEconomicaController::class, 'destroy'])->name('admin.actividad-economica.delete');

           //GESTIONAR FORMULARIOS
Route::get('/admin-formularios', [FormularioController::class, 'index'])->name('admin.formularios');
Route::get('/admin-formularios/create', [FormularioController::class, 'create'])->name('admin.formularios.create');
Route::post('/admin-formularios/register', [FormularioController::class, 'store'])->name('admin.formularios.register');
Route::get('/admin-formularios/edit/{formulario_id}', [FormularioController::class, 'edit'])->name('admin.formularios.edit');
Route::patch('/admin-formularios/edit/{formulario_id}', [FormularioController::class, 'update'])->name('admin.formularios.update');
Route::delete('admin-formularios/destroy/{formulario_id}',  [FormularioController::class, 'destroy'])->name('admin.formularios.delete');

        //GESTIONAR CERTIFICADOS
Route::get('/admin-certificados', [CertificadoController::class, 'index'])->name('admin.certificados');
Route::get('/admin-certificados/create', [CertificadoController::class, 'create'])->name('admin.certificados.create');
Route::post('/admin-certificados/register', [CertificadoController::class, 'store'])->name('admin.certificados.register');
Route::get('/admin-certificados/edit/{certificado_id}', [CertificadoController::class, 'edit'])->name('admin.certificados.edit');
Route::patch('/admin-certificados/edit/{certificado_id}', [CertificadoController::class, 'update'])->name('admin.certificados.update');
Route::delete('admin-certificados/destroy/{certificado_id}',  [CertificadoController::class, 'destroy'])->name('admin.certificados.delete');
Route::get('/admin-certificados/descargar/{certificado_id}', [CertificadoController::class, 'generarCertificado'])->name('admin.certificados.descargar');
Route::get('/admin-certificados/firmarPdf/{certificado_id}', [CertificadoController::class, 'firmarPdf'])->name('admin.certificados.firmarPdf');
Route::get('/admin/certificados/verificacion', [CertificadoController::class, 'verificacion'])->name('admin.certificados.verificacion');
Route::post('/admin/certificados/verificar', [CertificadoController::class, 'verificar'])->name('admin.certificado.verificacion.verificar');
Route::get('admin/certificados/ver/{id}', [CertificadoController::class, 'showPdf'])->name('admin.certificados.ver');

//LANDING PAGE
Route::get('/landing/tipos-licencias', function () {
    return view('landing.tipos-licencias');
})->name('landing.tipos-licencias');

// SOLICITUDES LANDING
Route::get('/landing/solicitudes/create', [LandingController::class, 'create'])->name('landing.solicitudes.create');
   Route::post('/landing/solicitudes/store', [LandingController::class, 'store'])->name('landing.solicitudes.store');

//LANDING SEGUIMIENTO
Route::post('/landing/seguimiento/consultar', [LandingController::class, 'consultar'])->name('landing.seguimiento.consultar');

//LANDING VERIFICAR
Route::get('/landing/certificados/verificar/{codigoSolicitud}', [LandingController::class, 'verificar'])->name('landing.certificados.verificar');


//DESCARGAR CERTIFICADO
Route::get('/landing/certificados/descargar/{certificado_id}', [LandingController::class, 'descargarCertificado'])->name('landing.certificados.descargar');
require __DIR__.'/auth.php';
