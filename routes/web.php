<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VehicleInspectionController;
use App\Http\Controllers\NearAccidentReportController;
use App\Http\Controllers\ExtintorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InspeccionController;
use App\Http\Controllers\RegistroCharlaController;
use App\Http\Controllers\InspeccionExtintoresController;
use App\Http\Controllers\InspeccionExtintoresDetalleController;





Route::get('/', function () {
    return redirect('login');
});

Auth::routes();




Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('inspecciones', InspeccionController::class);
Route::resource('inspecciones_extintores', InspeccionExtintoresController::class);
// Rutas para la gestión de detalles de inspecciones de extintores
Route::get('inspecciones_extintores_detalles/{inspeccionId}/create', [InspeccionExtintoresDetalleController::class, 'create'])->name('inspecciones_extintores_detalles.create');
Route::post('inspecciones_extintores_detalles/{inspeccionId}/store', [InspeccionExtintoresDetalleController::class, 'store'])->name('inspecciones_extintores_detalles.store');

Route::get('inspecciones_extintores_detalles/{id}/show', [InspeccionExtintoresDetalleController::class, 'show'])->name('inspecciones_extintores_detalles.show');
Route::get('inspecciones_extintores_detalles/{id}/edit', [InspeccionExtintoresDetalleController::class, 'edit'])->name('inspecciones_extintores_detalles.edit');
Route::put('inspecciones_extintores_detalles/{id}', [InspeccionExtintoresDetalleController::class, 'update'])->name('inspecciones_extintores_detalles.update');
Route::delete('inspecciones_extintores_detalles/{id}', [InspeccionExtintoresDetalleController::class, 'destroy'])->name('inspecciones_extintores_detalles.destroy');

Route::get('inspecciones_extintores/{id}/pdf', [App\Http\Controllers\InspeccionExtintoresController::class, 'generatePDF'])->name('inspecciones_extintores.pdf');

Route::get('inspecciones/{id}/send-email', [InspeccionExtintoresController::class, 'sendInspeccionEmail'])->name('inspecciones_extintores.sendEmail');

Route::get('registros_charlas/{id}/pdf', [RegistroCharlaController::class, 'downloadPDF'])->name('registros_charlas.pdf');


Route::resource('registros_charlas', RegistroCharlaController::class);
Route::get('/api/empresas/{empresa}/trabajadores', [RegistroCharlaController::class, 'getTrabajadores'])->name('empresas.trabajadores');
Route::get('/api/documentos/charlas_seguridad', [DocumentController::class, 'getDocumentosCharlasSeguridad']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('empresas', EmpresaController::class);

Route::resource('casi_accidente', NearAccidentReportController::class);
Route::get('/api/empresas/{empresa}/usuarios', [EmpresaController::class, 'getUsuarios']);
Route::get('casi_accidente/{id}/pdf', [NearAccidentReportController::class, 'generatePdf'])->name('casi_accidente.pdf');


Route::resource('extintores', ExtintorController::class);


Route::resource('vehiculos', VehicleInspectionController::class);
Route::get('vehicle-inspections/{id}/pdf', [VehicleInspectionController::class, 'generatePdf'])->name('vehicle-inspections.pdf');

Route::resource('trabajadores', TrabajadorController::class)->parameters([
    'trabajadores' => 'trabajador',
]);



Route::get('/{category}/procedimientos', [DocumentController::class, 'index'])->name('{category}.procedimientos.index')->defaults('folder', 'procedimientos');
Route::get('/{category}/formatos', [DocumentController::class, 'index'])->name('{category}.formatos.index')->defaults('folder', 'formatos');
Route::get('/{category}/registros', [DocumentController::class, 'index'])->name('{category}.registros.index')->defaults('folder', 'registros');
Route::get('/{category}/charlas_seguridad', [DocumentController::class, 'index'])->name('{category}.charlas_seguridad.index')->defaults('folder', 'charlas_seguridad');


Route::prefix('sistema-gestion')->group(function () {
    Route::post('/upload', [DocumentController::class, 'uploadDocument'])->name('sistema-gestion.upload');
    Route::delete('/eliminar-documento/{document}',[DocumentController::class, 'destroy'])->name('eliminar_documento');
    Route::put('/editar-nombre-documento/{document}', [DocumentController::class, 'update'])->name('editar_nombre_documento');

});