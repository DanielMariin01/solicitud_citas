<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ciudad;
use App\Models\Procedimiento;

class Paciente extends Model

{
    //declarar llave primaria
    protected $primaryKey = 'id_paciente';
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_identificacion',
        'numero_identificacion',
        'fk_ciudad',
        'fk_procedimiento',
        'correo',
       
    ];

    // Relación con Ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'fk_ciudad', 'id_ciudad');
    }

    // Relación con Procedimiento
    public function procedimiento()
    {
        return $this->belongsTo(Procedimiento::class, 'fk_procedimiento', 'id_procedimiento');
    }
}