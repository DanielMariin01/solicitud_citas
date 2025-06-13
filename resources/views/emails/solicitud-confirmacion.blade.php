<x-mail::message>
# Solicitud de Cita Recibida

Hola {{ $pacienteNombre }},

Hemos recibido tu solicitud de cita con éxito. A continuación, un resumen de los detalles que nos proporcionaste:

**Datos del Paciente:**
- **Nombre Completo:** {{ $pacienteNombre }} {{ $pacienteApellido }}
- **Número de Identificación:** {{ $pacienteIdentificacion }}
- **Celular:** {{ $pacienteCelular }}

**Detalles de la Solicitud:**
- **ID de Registro:** {{ $idPaciente }}
- **Procedimiento Solicitado:** {{ $pacienteProcedimiento }}
- **Estado Actual:** {{ $estado }}
- **Observaciones:** {{ $pacienteObservacion ?? 'Ninguna' }}

Nos pondremos en contacto contigo lo antes posible para confirmar y agendar tu cita.

Gracias por confiar en nosotros,<br>
{{ config('app.name') }}
</x-mail::message>