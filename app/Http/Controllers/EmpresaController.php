<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;



class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $empresas = Empresa::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', "%$search%")
                ->orWhere('direccion', 'like', "%$search%");
        })
        ->where('id', '!=', 0)  // Excluir el ID 0
        ->orderBy('id', 'desc')
        ->paginate(20);
    
        return view('empresas.index', compact('empresas'));
    }
    
    public function getUsuarios($empresaId)
    {
        $usuarios = User::where('empresa_id', $empresaId)->get(['id', 'name']);
        return response()->json($usuarios);
    }

    public function create()
    {
        return view('empresas.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'telefono' => 'required|string|max:255',
                'emails' => 'required|string', // Validar como string
                'actividad' => 'required|string',
                'logotipo' => 'nullable|image',
            ]);
    
            // Convertir la cadena de correos electrónicos en un array
            $data['emails'] = array_map('trim', explode(',', $data['emails']));
    
            // Manejo del archivo de logotipo
            if ($request->hasFile('logotipo')) {
                $data['logotipo'] = $request->file('logotipo')->store('logotipos', 'public');
            }
    
            // Crear el registro de empresa
            Empresa::create($data);
    
            Session::flash('success', "Empresa creada correctamente");
    
            return redirect()->route('empresas.index');
        } catch (\Exception $e) {
            // Manejo de la excepción
            Session::flash('error', 'Error al crear empresa: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    

    public function show(Empresa $empresa)
    {
        return view('empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
{
    try {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'emails' => 'required|string', // Validar como string
            'actividad' => 'required|string',
            'logotipo' => 'nullable|image',
        ]);

        // Convertir la cadena de correos electrónicos en un array
        $data['emails'] = array_map('trim', explode(',', $data['emails']));

        // Manejo del archivo de logotipo
        if ($request->hasFile('logotipo')) {
            // Eliminar el logotipo anterior si existe
            if ($empresa->logotipo && \Storage::disk('public')->exists($empresa->logotipo)) {
                \Storage::disk('public')->delete($empresa->logotipo);
            }

            // Guardar el nuevo logotipo
            $data['logotipo'] = $request->file('logotipo')->store('logotipos', 'public');
        }

        // Actualizar el registro de empresa
        $empresa->update($data);

        Session::flash('success', "Empresa actualizada correctamente");

        return redirect()->route('empresas.index');
    } catch (\Exception $e) {
        // Manejo de la excepción
        Session::flash('error', 'Error al actualizar empresa: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}

    
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index');
    }
}
