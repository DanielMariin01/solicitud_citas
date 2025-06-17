<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Respuesta a Solicitud de Cita</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; color: #333; }
        .container { background: #fff; padding: 24px; border-radius: 8px; max-width: 600px; margin: 40px auto; box-shadow: 0 2px 8px rgba(0,0,0,0.05);}
        h2 { color: #007bff; }
        .footer { margin-top: 32px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Respuesta a tu Solicitud de Cita</h2>
        <p>Hola {{ $nombre ?? 'Usuario' }},</p>
        <p>
            Hemos procesado tu solicitud de cita. A continuación encontrarás la respuesta:
        </p>
        <p>
            <strong>Estado:</strong> {{ $estado ?? 'Pendiente' }}<br>
            <strong>Mensaje:</strong> {{ $mensaje ?? 'No hay mensaje adicional.' }}
        </p>
        <p>
            Si tienes alguna pregunta, no dudes en responder a este correo.
        </p>
        <div class="footer">
            &copy; {{ date('Y') }} Tu Empresa. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
