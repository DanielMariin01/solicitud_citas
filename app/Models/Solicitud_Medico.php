<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Medico extends Model
{
    protected $table = 'solicitud_medico'; // Nombre de la tabla
    protected $primaryKey = 'id_solicitud_medico';
    protected $fillable = [
        'fk_solicitud_admision',
        'estado',
        'comentario',
        'hora',
        'fecha',
    ];
    
}
