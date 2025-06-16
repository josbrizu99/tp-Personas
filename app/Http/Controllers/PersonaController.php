<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Persona::with(['direcciones', 'telefonos', 'trabajos', 'nacionalidad'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nrodocpersona' => 'required|string|max:20',
            'rucpersona' => 'nullable|string|max:15',
            'nom_persona' => 'required|string|max:100',
            'ape_persona' => 'required|string|max:100',
            'nombrepersona' => 'required|string|max:200',
            'direccionpersona' => 'required|string|max:150',
            'fechanacpersona' => 'required|date',
            'idtppersona' => 'required|integer',
            'fechaingpersona' => 'required|date',
            'idtpidentificacion' => 'required|integer',
            'idnaturaleza' => 'required|integer',
            'idsexo' => 'required|integer',
            'idnacionalidad' => 'required|integer',
            'idestadocivil' => 'required|integer',
            'idocupacion' => 'required|integer',
            'idprofesion' => 'required|integer',
            'idciudadnacimiento' => 'required|integer',
            'emailpersona' => 'required|string|max:80',
        ]);

        return Persona::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        return $persona->load(['direcciones', 'telefonos', 'trabajos', 'nacionalidad']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nrodocpersona' => 'required|string|max:20',
            'rucpersona' => 'nullable|string|max:15',
            'nom_persona' => 'required|string|max:100',
            'ape_persona' => 'required|string|max:100',
            'nombrepersona' => 'required|string|max:200',
            'direccionpersona' => 'required|string|max:150',
            'fechanacpersona' => 'required|date',
            'idtppersona' => 'required|integer',
            'fechaingpersona' => 'required|date',
            'idtpidentificacion' => 'required|integer',
            'idnaturaleza' => 'required|integer',
            'idsexo' => 'required|integer',
            'idnacionalidad' => 'required|integer',
            'idestadocivil' => 'required|integer',
            'idocupacion' => 'required|integer',
            'idprofesion' => 'required|integer',
            'idciudadnacimiento' => 'required|integer',
            'emailpersona' => 'required|string|max:80',
        ]);

        $persona->update($request->all());
        return $persona;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return response()->json(null, 204);
    }
}
