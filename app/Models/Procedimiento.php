<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    // Declarar llave primaria
    protected $table = 'procedimiento'; // Nombre de la tabla
    protected $primaryKey = 'id_procedimiento';
    protected $fillable = [
        'codigo',
        'nombre',
      
    ];
    // Relación con Paciente
    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'fk_procedimiento', 'id_procedimiento'); 
    }
    

}
