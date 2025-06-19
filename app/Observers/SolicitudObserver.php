<?php

namespace App\Observers;

use App\Models\Solicitud_Admision;
use App\Models\Paciente;
use App\Mail\SolicitudEstadoActualizadoMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Throwable;

class SolicitudObserver
{
    // Este método se ejecuta cuando se CREA una nueva Solicitud_Admision (tu caso actual desde Filament)
    public function created(Solicitud_Admision $solicitudAdmision): void
    {
        Log::info('Solicitud_Admision creada (Observer): ' . $solicitudAdmision->id_solicitud_admision);

        try {
            // Cargar el paciente asociado a esta Solicitud_Admision
            // Asegúrate de que la relación `paciente()` en Solicitud_Admision es correcta.
            $paciente = $solicitudAdmision->paciente;

            if (!$paciente) {
                Log::error('ERROR: Paciente asociado no encontrado para Solicitud_Admision ID: ' . $solicitudAdmision->id_solicitud_admision);
                return;
            }

            // Desencriptar el correo del paciente
            $pacienteEmail = '';
            try {
                $pacienteEmail = Crypt::decryptString($paciente->correo);
            } catch (Throwable $e) {
                Log::error('ERROR DESENCRIPTANDO CORREO en SolicitudObserver (created) para Paciente ID: ' . $paciente->id_paciente . '. Error: ' . $e->getMessage() . '. Usando correo RAW: ' . $paciente->correo);
                $pacienteEmail = $paciente->correo;
            }

            // Log de depuración para ver el email del destinatario
            Log::debug('Intentando enviar correo de actualización (desde created) a: ' . $pacienteEmail . ' para Solicitud ID: ' . $solicitudAdmision->id_solicitud_admision);

            if (empty($pacienteEmail) || !filter_var($pacienteEmail, FILTER_VALIDATE_EMAIL)) {
                Log::warning('ERROR: Correo electrónico del paciente no válido o vacío para Solicitud_Admision ID: ' . $solicitudAdmision->id_solicitud_admision . ' y Paciente ID: ' . $paciente->id_paciente . '. Correo: ' . ($pacienteEmail ?: 'Vacío/Nulo'));
                return;
            }

            // Enviar el correo de actualización de estado
            Mail::to($pacienteEmail)->send(new SolicitudEstadoActualizadoMail($solicitudAdmision));

            Log::info('Correo de actualización de estado enviado exitosamente (desde created) para Solicitud_Admision ID: ' . $solicitudAdmision->id_solicitud_admision . ' a ' . $pacienteEmail . '. Nuevo estado: ' . $solicitudAdmision->estado);

        } catch (Throwable $e) {
            // Este log capturará el "The payload is invalid." si ocurre aquí.
            Log::error('ERROR general al enviar correo de actualización de estado (desde created) para Solicitud_Admision ID: ' . ($solicitudAdmision->id_solicitud_admision ?? 'N/A') . '. Error: ' . $e->getMessage());
        }
    }

    // Este método ya no se dispara en tu flujo actual de "Responder Solicitud"
    // Lo vaciamos o lo comentamos para evitar confusiones.
    public function updated(Solicitud_Admision $solicitudAdmision): void
    {
        Log::info('Solicitud_Admision actualizada (Observer): ' . $solicitudAdmision->id_solicitud_admision . '. (Este evento no debería ser el principal para el envío de correos en tu flujo actual)');
    }

    public function deleted(Solicitud_Admision $solicitudAdmision): void {}
    public function restored(Solicitud_Admision $solicitudAdmision): void {}
    public function forceDeleted(Solicitud_Admision $solicitudAdmision): void {}
}