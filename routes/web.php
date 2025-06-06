<?php

use App\Http\Controllers\FormularioCitaController;
use Illuminate\Support\Facades\Route;

use App\Livewire\Formulario;
 // Asegúrate de importar tu componente Livewire


Route::get('/', function () {
    return view('welcome');
});


Route::get('/solicitar-cita', function () {
    return view('solicitar-cita.formulario');
});

Route::get('/solicitar-cita', [FormularioCitaController::class, 'mostrarFormulario']);


