<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Procedimiento;
use Illuminate\Http\Request;

class FormularioCitaController extends Controller
{
public function mostrarFormulario()
{
    $ciudades = Ciudad::all();
    $procedimientos = Procedimiento::all();

    return view('solicitar-cita.formulario', compact('ciudades', 'procedimientos'));
}

}
