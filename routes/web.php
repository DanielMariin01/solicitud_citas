<?php

use App\Http\Controllers\FormularioCitaController;
use Illuminate\Support\Facades\Route;

use App\Livewire\Formulario;
 // Asegúrate de importar tu componente Livewire


// 1. Ruta para MOSTRAR el formulario de cita (método GET)
// Esta ruta es la única que debe usar la URL '/solicitar-cita' con el método GET.
Route::get('/solicitar-cita', [FormularioCitaController::class, 'mostrarFormulario'])->name('solicitar-cita.formulario');

// 2. Ruta para GUARDAR los datos del formulario (método POST)
// Esta ruta es para enviar los datos, no para mostrar el formulario.
Route::post('/solicitar-cita', [FormularioCitaController::class, 'guardar'])->name('solicitar-cita.guardar');

// 3. Ruta de la API AJAX para buscar procedimientos (método GET)
// Esta ruta usa una URL diferente para evitar conflictos.
// La URL es '/api/procedimientos/buscar'.
Route::get('/api/procedimientos/buscar', [FormularioCitaController::class, 'buscar'])->name('api.procedimientos.buscar');


