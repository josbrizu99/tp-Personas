<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Nacionalidad;
use Illuminate\Http\Request;

class NacionalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Nacionalidad::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombrenacionalidad' => 'required|string|max:100',
        ]);

        return Nacionalidad::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Nacionalidad $nacionalidad)
    {
        return $nacionalidad;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nacionalidad $nacionalidad)
    {
        $request->validate([
            'nombrenacionalidad' => 'required|string|max:100',
        ]);

        $nacionalidad->update($request->all());
        return $nacionalidad;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nacionalidad $nacionalidad)
    {
        $nacionalidad->delete();
        return response()->json(null, 204);
    }
}
