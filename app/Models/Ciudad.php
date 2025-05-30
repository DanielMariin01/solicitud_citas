<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    // Declarar llave primaria
    protected $primaryKey = 'id_ciudad';

    // Atributos que son asignables en masa
    protected $fillable = [
        'nombre',
    
        
    ];

    // Relación con Departamento
   
}
