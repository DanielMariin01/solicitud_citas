<?php

namespace App\Enums;

enum SolicitudEstado: string
{
    case PENDIENTE = 'pendiente';
    case ENVIADA_A_MEDICO = 'enviada_a_medico';
    case APROBADA = 'aprobada';
    case RECHAZADA = 'rechazada';
    case CANCELADA = 'cancelada';
    case FINALIZADA = 'finalizada';
 

    /**
     * Obtiene el nombre legible para el usuario de cada estado.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDIENTE => 'Pendiente',
            self::ENVIADA_A_MEDICO => 'Enviada a Médico',
            self::APROBADA => 'Aprobada',
            self::RECHAZADA => 'Rechazada',
            self::CANCELADA => 'Cancelada',
            self::FINALIZADA => 'Finalizada',
    
        };
    }

    /**
     * Obtiene el color asociado a cada estado (útil para Filament).
     *
     * @return string|array|null
     */
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDIENTE => 'warning', // Amarillo
            self::ENVIADA_A_MEDICO => 'info', // Azul claro
            self::APROBADA => 'success', // Verde
            self::RECHAZADA => 'danger',  // Rojo
            self::CANCELADA => 'danger', // Rojo
            self::FINALIZADA => 'gray', // Gris
         
        };
    }
    
}