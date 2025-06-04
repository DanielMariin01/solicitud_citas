<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Solicitud_Admision; // Asegúrate de importar tu modelo SolicitudAdmision

class SolicitudRecibidaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * La instancia de la solicitud de admisión.
     *
     * @var \App\Models\Solicitud_Admision
     */
    public Solicitud_Admision $solicitud; // Declaramos una propiedad pública para la solicitud

    /**
     * Crea una nueva instancia del mensaje.
     */
    public function __construct(Solicitud_Admision $solicitud)
    {
        $this->solicitud = $solicitud; // Asignamos la solicitud pasada al constructor a la propiedad pública
    }

    /**
     * Obtiene el sobre del mensaje.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Solicitud de Cita Médica', // El asunto del correo
            // from: new Address('noreply@tudominio.com', 'Tu Clínica/Consultorio'), // Opcional: Define un remitente específico
        );
    }

    /**
     * Obtiene la definición del contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-recibida-mail', // La vista Blade que contiene el HTML del correo
            with: [
                'solicitud' => $this->solicitud, // Pasa la solicitud a la vista para usar sus datos
                'paciente' => $this->solicitud->paciente, // También pasamos el paciente relacionado
                'procedimiento' => $this->solicitud->procedimiento, // Y el procedimiento relacionado
            ],
        );
    }

    /**
     * Obtiene los adjuntos para el mensaje.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Aquí podrías adjuntar archivos si fuera necesario
    }
}