<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Solicitud_Admision;
use App\Models\Paciente;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Throwable;

class SolicitudEstadoActualizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Solicitud_Admision $solicitudAdmision;

    public function __construct(Solicitud_Admision $solicitudAdmision)
    {
        $this->solicitudAdmision = $solicitudAdmision;
    }

    /**
     * Helper para intentar desencriptar un valor.
     * Si no está encriptado, es nulo, o hay un error, devuelve el valor original o un indicador.
     */
    private function getDecryptedOrRaw($value)
    {
        if (is_null($value) || $value === '') {
            return 'VACÍO / NULO';
        }
        // Verificar si la cadena parece encriptada antes de intentar desencriptar
        // Una cadena encriptada de Laravel comienza con 'eyJpdiI6' y contiene ':'
        if (is_string($value) && str_starts_with($value, 'eyJpdiI6') && str_contains($value, ':')) {
            try {
                return Crypt::decryptString($value);
            } catch (Throwable $e) {
                // Loguear el error para depuración
                Log::warning('Error al desencriptar valor en SolicitudEstadoActualizadoMail (helper): ' . $e->getMessage() . ' Valor (primeros 50 chars): ' . (is_string($value) ? substr($value, 0, 50) . '...' : 'No string'));
                return 'ERROR AL LEER: ' . $e->getMessage();
            }
        }
        return $value; // Si no parece encriptado, devuelve el valor tal cual
    }

    public function envelope(): Envelope
    {
        $paciente = $this->solicitudAdmision->paciente;
        $pacienteNombreCompleto = 'Paciente Desconocido';

        if ($paciente) {
            // Desencriptar nombre y apellido del paciente usando el helper
            $pacienteNombreCompleto = $this->getDecryptedOrRaw($paciente->nombre) . ' ' . $this->getDecryptedOrRaw($paciente->apellido);
        }

        return new Envelope(
            subject: 'Actualización del Estado de tu Solicitud de Cita - ' . $pacienteNombreCompleto,
        );
    }

    public function content(): Content
    {
        $paciente = $this->solicitudAdmision->paciente;

        // Valores por defecto si el paciente no se encuentra
        $pacienteNombre = 'N/A';
        $pacienteApellido = 'N/A';



        if ($paciente) {
            // Desencriptar campos del paciente usando el helper
            $pacienteNombre = $this->getDecryptedOrRaw($paciente->nombre);
            $pacienteApellido = $this->getDecryptedOrRaw($paciente->apellido);
      
          
        }

        return new Content(
            view: 'emails.solicitud-estado-actualizado',
            with: [
                'pacienteNombre'      => $pacienteNombre,
                'pacienteApellido'    => $pacienteApellido,
                'idSolicitud'         => $this->solicitudAdmision->id_solicitud_admision,
                'estado'              => $this->solicitudAdmision->estado,
                // Asegúrate de que 'comentario' de Solicitud_Admision usa el helper SI se encripta.
                // Si el campo comentario en la BD NO está encriptado, el helper lo devuelve tal cual
         
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}