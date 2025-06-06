<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\EPS;
use App\Models\Procedimiento;
use Illuminate\Http\Request;

class FormularioCitaController extends Controller
{
public function mostrarFormulario()
{
    $ciudades = Ciudad::all();
    $procedimientos = Procedimiento::all();
    $eps = EPS::all();

    

    return view('solicitar-cita.formulario', compact('ciudades', 'procedimientos', 'eps'));
}

 public function store(Request $request)
    {
        // 1. **Validación de los Archivos:**
        // Esto es CRÍTICO para la seguridad. Aquí le decimos a Laravel qué tipo de archivos
        // esperamos, su tamaño máximo, etc.
        $request->validate([
            // Para 'historia_clinica': 'historia_clinica.*' significa "cada archivo dentro del array 'historia_clinica'"
            // 'nullable': El campo no es estrictamente obligatorio si no se envía nada. (Aunque en el front lo pusimos required)
            // 'file': Debe ser un archivo.
            // 'mimes:pdf,jpg': Solo permite archivos PDF o JPG.
            // 'max:5000': El tamaño máximo es 5000 KB (5 MB).
            'historia_clinica.*' => 'nullable|file|mimes:pdf,jpg|max:5000',
            'autorizacion.*' => 'nullable|file|max:5000', // No se restringe el tipo de archivo aquí
            'orden_medica' => 'nullable|file|max:5000', // No se restringe el tipo de archivo aquí, pero no es array (no lleva '.*')
        ]);

        // 2. **Procesar y guardar 'historia_clinica' (puede ser múltiple):**
        if ($request->hasFile('historia_clinica')) { // Verifica si se subieron archivos para 'historia_clinica'
            foreach ($request->file('historia_clinica') as $file) { // Itera sobre cada archivo subido
                // $file->store('expedientes/historia_clinica') guarda el archivo en:
                // storage/app/expedientes/historia_clinica/nombre_generado_aleatorio.extension
                $path = $file->store('expedientes/historia_clinica');
                // Aquí deberías guardar $path (la ruta del archivo) en tu base de datos
                // Por ejemplo: Documento::create(['tipo' => 'historia_clinica', 'ruta' => $path, 'paciente_id' => $paciente->id]);
            }
        }

        // 3. **Procesar y guardar 'autorizacion' (puede ser múltiple):**
        if ($request->hasFile('autorizacion')) {
            foreach ($request->file('autorizacion') as $file) {
                $path = $file->store('expedientes/autorizaciones');
                // Guardar $path en la base de datos
            }
        }

        // 4. **Procesar y guardar 'orden_medica' (un solo archivo):**
        if ($request->hasFile('orden_medica')) {
            // Como es un solo archivo, no necesitamos el bucle 'foreach'.
            $path = $request->file('orden_medica')->store('expedientes/ordenes_medicas');
            // Guardar $path en la base de datos
        }

        // ... Aquí iría el resto de tu lógica para guardar otros datos del formulario en la base de datos

        return back()->with('success', '¡Archivos y datos guardados correctamente!'); // Redirecciona al usuario de vuelta con un mensaje de éxito
    }



}
