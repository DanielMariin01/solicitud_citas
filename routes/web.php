<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Formulario;
 // Asegúrate de importar tu componente Livewire


Route::get('/', function () {
    return view('welcome');
});


//Route::get('/solicitar-cita', function () {
    //return view('livewire.formulario');
//});
  