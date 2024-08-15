<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\Empresa;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $trabajadores = Trabajador::when($search, function ($query, $search) {
            return $query->where('cedula', 'like', "%$search%")
                         ->orWhere('nombre', 'like', "%$search%")
                         ->orWhere('apellido', 'like', "%$search%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
        return view('trabajadores.index', compact('trabajadores'));
    }
    

    public function create()
    {
        $empresas = Empresa::all();
        return view('trabajadores.create', compact('empresas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'cedula' => 'required|string|max:255|unique:trabajadores',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'area_trabajo' => 'required|string|max:255',
            'firma' => 'nullable|image',
        ]);
    
        if ($request->hasFile('firma')) {
            $data['firma'] = $request->file('firma')->store('firmas', 'public'); // Guardar en el disco público
        }
    
        Trabajador::create($data);
    
        return redirect()->route('trabajadores.index');
    }
    
    public function update(Request $request, Trabajador $trabajador)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'cedula' => 'required|string|max:255|unique:trabajadores,cedula,' . $trabajador->id,
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'area_trabajo' => 'required|string|max:255',
            'firma' => 'nullable|image',
        ]);
    
        if ($request->hasFile('firma')) {
            $data['firma'] = $request->file('firma')->store('firmas', 'public'); // Guardar en el disco público
        }
    
        $trabajador->update($data);
    
        return redirect()->route('trabajadores.index');
    }
    

    public function show(Trabajador $trabajador)
    {
        // Cargar la relación empresa
        $trabajador->load('empresa');

       // dd($trabajador);

        return view('trabajadores.show', compact('trabajador'));
    }


    public function edit(Trabajador $trabajador)
    {
        $empresas = Empresa::all();
        return view('trabajadores.edit', compact('trabajador', 'empresas'));
    }


    public function destroy(Trabajador $trabajador)
    {
        $trabajador->delete();

        return redirect()->route('trabajadores.index');
    }
}
