<?php

namespace App\Http\Controllers;

use App\Models\PersonasTelefono;
use Illuminate\Http\Request;

class PersonasTelefonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PersonasTelefono::with('persona')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpersona' => 'required|integer',
            'telefono' => 'required|string|max:20',
        ]);

        return PersonasTelefono::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonasTelefono $personasTelefono)
    {
        return $personasTelefono->load('persona');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonasTelefono $personasTelefono)
    {
        $request->validate([
            'idpersona' => 'required|integer',
            'telefono' => 'required|string|max:20',
        ]);

        $personasTelefono->update($request->all());
        return $personasTelefono;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonasTelefono $personasTelefono)
    {
        $personasTelefono->delete();
        return response()->json(null, 204);
    }
}
