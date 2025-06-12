<?php

namespace App\Enums;

enum SolicitudEstadoAdmision: string
{
 
    case ENVIADA_A_MEDICO = 'enviada_a_medico';
    case AGENDAR = 'agendar';

    case CANCELADA = 'cancelada';
   
 

    /**
     * Obtiene el nombre legible para el usuario de cada estado.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
           
            self::ENVIADA_A_MEDICO => 'Enviada a Médico',
            self::AGENDAR => 'agendar',
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
         
            self::ENVIADA_A_MEDICO => 'info', // Azul claro
            self::AGENDAR => 'success', // Verde
            self::CANCELADA => 'danger', // Rojo
          
         
        };
    }
    
}