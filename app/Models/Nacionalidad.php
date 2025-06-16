<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
    public function personas()
    {
        return $this->hasMany(Persona::class, 'idnacionalidad', 'idnacionalidad');
    }
}
