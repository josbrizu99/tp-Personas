<?php

namespace App\Http\Controllers;

use App\Models\PersonasTrabajo;
use Illuminate\Http\Request;

class PersonasTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PersonasTrabajo::with('persona')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpersona' => 'required|integer',
            'empresa' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'fechainicio' => 'required|date',
            'fechafin' => 'nullable|date',
        ]);

        return PersonasTrabajo::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonasTrabajo $personasTrabajo)
    {
        return $personasTrabajo->load('persona');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonasTrabajo $personasTrabajo)
    {
        $request->validate([
            'idpersona' => 'required|integer',
            'empresa' => 'required|string|max:100',
            'cargo' => 'required|string|max:100',
            'fechainicio' => 'required|date',
            'fechafin' => 'nullable|date',
        ]);

        $personasTrabajo->update($request->all());
        return $personasTrabajo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonasTrabajo $personasTrabajo)
    {
        $personasTrabajo->delete();
        return response()->json(null, 204);
    }
}
