<?php

namespace App\Enums;

enum SolicitudEstado: string
{
    case PENDIENTE_ADMISIONES = 'pendiente_admisiones';
    case APROBADA = 'aprobada';
    case RECHAZADA = 'rechazada';
    case REPROGRAMADA = 'reprogramada';
    case FINALIZADA = 'finalizada';
    case CANCELADA = 'cancelada';

    /**
     * Obtiene el nombre legible para el usuario de cada estado.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDIENTE_ADMISIONES => 'Pendiente de Admisiones',
            self::APROBADA => 'Aprobada',
            self::RECHAZADA => 'Rechazada',
            self::REPROGRAMADA => 'Reprogramada',
            self::FINALIZADA => 'Finalizada',
            self::CANCELADA => 'Cancelada',
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
            self::PENDIENTE_ADMISIONES => 'warning', // Amarillo
            self::APROBADA => 'success', // Verde
            self::RECHAZADA => 'danger',  // Rojo
            self::REPROGRAMADA => 'info', // Azul claro
            self::FINALIZADA => 'gray', // Gris
            self::CANCELADA => 'danger', // Rojo
        };
    }
}