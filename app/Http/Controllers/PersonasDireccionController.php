<?php

namespace App\Http\Controllers;

use App\Models\PersonasDireccion;
use Illuminate\Http\Request;

class PersonasDireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PersonasDireccion::with('persona')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpersona' => 'required|integer',
            'direccion' => 'required|string|max:150',
            'idciudad' => 'required|integer',
            'idpais' => 'required|integer',
        ]);

        return PersonasDireccion::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonasDireccion $personasDireccion)
    {
        return $personasDireccion->load('persona');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonasDireccion $personasDireccion)
    {
        $request->validate([
            'idpersona' => 'required|integer',
            'direccion' => 'required|string|max:150',
            'idciudad' => 'required|integer',
            'idpais' => 'required|integer',
        ]);

        $personasDireccion->update($request->all());
        return $personasDireccion;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonasDireccion $personasDireccion)
    {
        $personasDireccion->delete();
        return response()->json(null, 204);
    }
}
