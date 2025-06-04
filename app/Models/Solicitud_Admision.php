<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Admision extends Model
{
    // Declarar llave primaria
    protected $table = 'solicitud_admision'; // Nombre de la tabla
    protected $primaryKey = 'id_solicitud_admision';

    // Atributos que son asignables en masa
    protected $fillable = [
        'fk_paciente',
        'fk_procedimiento',
        'estado',
        'comentario',
        'hora',
        'fecha',
    ];

    // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    // Relación con Procedimiento uno a uno
    public function procedimiento()
    {
        return $this->belongsTo(Procedimiento::class, 'fk_procedimiento');
    }
  



    
}
