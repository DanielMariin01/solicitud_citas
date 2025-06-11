<?php



namespace App\Filament\Resources\SolicitudAdmisionResource\Pages;

use App\Filament\Resources\SolicitudAdmisionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth si lo usas para created_by
use Illuminate\Support\Facades\Log;

class CreateSolicitudAdmision extends CreateRecord
{
    protected static string $resource = SolicitudAdmisionResource::class;



        public function getTitle(): string
    {
        // Puedes devolver el título que quieras, sin la palabra "Crear".
        // Por ejemplo, el mismo que tu $modelLabel o algo diferente.
        return 'Responder Solicitud';
        // O si quieres que tome el mismo nombre del $modelLabel del Resource:
        // return static::getResource()::getModelLabel();
    }


   protected function afterCreate(): void
    {
        // $this->record es la instancia de la SolicitudAdmisiones que acaba de ser creada.
        $solicitudAdmision = $this->record;

        $paciente = $solicitudAdmision->paciente; // Accede al paciente relacionado

        if ($paciente) {
            // **¡Aquí está la clave!** Toma el valor del estado de la solicitud recién creada.
            $nuevoEstadoPaciente = $solicitudAdmision->estado;

            // Ahora, actualiza el paciente con ese estado.
            // Asegúrate de que 'estado' es una columna válida en tu tabla 'pacientes'
            // y que está en el $fillable de tu modelo Paciente.
            $paciente->estado = $nuevoEstadoPaciente; // Asigna el estado de la solicitud
            $paciente->save(); // Guarda los cambios en el paciente
        } else {
            Log::warning('Paciente no encontrado para la solicitud de admisión ID: ' . $solicitudAdmision->id);
        }
    }

}