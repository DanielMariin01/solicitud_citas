<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    // Declarar llave primaria
    protected $primaryKey = 'id_procedimiento';
    protected $fillable = [
        'codigo',
        'nombre',
      
    ];
}
