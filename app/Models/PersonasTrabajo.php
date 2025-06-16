<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonasTrabajo extends Model
{
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idpersona', 'idpersona');
    }
}
