<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // Relaciones
    public function direcciones()
    {
        return $this->hasMany(PersonasDireccion::class, 'idpersona', 'idpersona');
    }

    public function telefonos()
    {
        return $this->hasMany(PersonasTelefono::class, 'idpersona', 'idpersona');
    }

    public function trabajos()
    {
        return $this->hasMany(PersonasTrabajo::class, 'idpersona', 'idpersona');
    }

    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class, 'idnacionalidad', 'idnacionalidad');
    }
}
