<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extintor;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ExtintorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $extintores = Extintor::when($search, function ($query, $search) {
            return $query->where('codigo', 'like', "%$search%")
                ->orWhere('tipo', 'like', "%$search%")
                ->orWhereHas('empresa', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%");
                });
        })
            ->where('id', '!=', 0)  // Excluir el ID 0
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('extintores.index', compact('extintores'));
    }


    public function create()
    {
        $empresas = Empresa::where('id', '!=', 0)->get();
        $users = User::all();
        return view('extintores.create', compact('empresas', 'users'));
    }

    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'codigo' => 'required|string|max:255',
                'tipo' => 'required|string',
                'peso' => 'required|string',
                'area' => 'required|string|max:255',
                'empresa_id' => 'required|exists:empresas,id',
                'user_id' => 'required|exists:users,id',
                'fecha_mantenimiento' => 'nullable|date',
                'imagen' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            ]);


            // Formatear la fecha de mantenimiento
            if ($request->filled('fecha_mantenimiento')) {
                $data['fecha_mantenimiento'] = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->fecha_mantenimiento)->format('Y-m-d H:i:s');
            }

            // Manejo del archivo de imagen
            if ($request->hasFile('imagen')) {
                $data['imagen'] = $request->file('imagen')->store('extintores', 'public');
            }


            // Crear el registro de extintor
            Extintor::create($data);
            Session::flash('success', "Extintor creado correctamente");

            return redirect()->route('extintores.index');
        } catch (\Exception $e) {
            // Manejo de la excepción
            Session::flash('error', 'Error al crear extintor: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'codigo' => 'required|string|max:255',
                'tipo' => 'required|string',
                'peso' => 'required|string',
                'area' => 'required|string|max:255',
                'empresa_id' => 'required|exists:empresas,id',
                'user_id' => 'required|exists:users,id',
                'fecha_mantenimiento' => 'nullable|date',
                'imagen' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
            ]);

            // Formatear la fecha de mantenimiento
            if ($request->filled('fecha_mantenimiento')) {
                $data['fecha_mantenimiento'] = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->fecha_mantenimiento)->format('Y-m-d H:i:s');
            }

            // Manejo del archivo de imagen
            if ($request->hasFile('imagen')) {
                // Eliminar la imagen anterior si existe
                $extintor = Extintor::findOrFail($id);
                if ($extintor->imagen) {
                    \Storage::delete('public/' . $extintor->imagen);
                }
                $data['imagen'] = $request->file('imagen')->store('extintores', 'public');
            }

            // Actualizar el registro del extintor
            Extintor::where('id', $id)->update($data);
            Session::flash('success', "Extintor actualizado correctamente");

            return redirect()->route('extintores.index');
        } catch (\Exception $e) {
            // Manejo de la excepción
            Session::flash('error', 'Error al actualizar extintor: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function show($id)
    {
        $extintor = Extintor::findOrFail($id);
        return view('extintores.show', compact('extintor'));
    }

    public function edit($id)
    {
        $extintor = Extintor::findOrFail($id);
        $empresas = Empresa::where('id', '!=', 0)->get();  // Excluir el ID 0
        $users = User::all();
        return view('extintores.edit', compact('extintor', 'empresas', 'users'));
    }

    public function destroy($id)
    {
        $extintor = Extintor::findOrFail($id);
        $extintor->delete();

        return redirect()->route('extintores.index')->with('success', 'Extintor eliminado con éxito.');
    }
}
