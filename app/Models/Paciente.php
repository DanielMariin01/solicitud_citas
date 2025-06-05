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
        'procedimiento',
        'correo',
        'celular',
        'fk_eps',
        
        
        


       
    ];

    // Relación con Ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'fk_ciudad', 'id_ciudad');
    }

    // Relación con Procedimiento
  
}