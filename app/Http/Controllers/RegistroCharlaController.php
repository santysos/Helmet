<?php

namespace App\Http\Controllers;

use App\Models\RegistroCharla;
use App\Models\Empresa;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;



class RegistroCharlaController extends Controller
{
    
    public function index(Request $request)
    {
        $query = RegistroCharla::with('empresa');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('departamento', 'like', "%{$search}%")
                  ->orWhere('responsable_charla', 'like', "%{$search}%")
                  ->orWhereHas('empresa', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }
    
        $registrosCharlas = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('formatos.registros_charlas.index', compact('registrosCharlas'));
    }
    

    public function downloadPDF($id)
    {
        $registroCharla = RegistroCharla::with('trabajadores')->findOrFail($id);

        // Obtener los títulos de los documentos
        $temaIds = json_decode($registroCharla->tema_brindado, true);
        $temas = Document::whereIn('id', $temaIds)->pluck('file_path', 'id');

        // Convertir las rutas de las fotos a rutas absolutas
        if ($registroCharla->fotos) {
            $fotos = array_map(function($foto) {
                return public_path('storage/' . $foto);
            }, json_decode($registroCharla->fotos));
            $registroCharla->fotos = json_encode($fotos);
        }

        $pdf = PDF::loadView('formatos.registros_charlas.pdf', compact('registroCharla', 'temas'));
        return $pdf->download('detalle_charla.pdf');
    }

    public function create()
    {
        $empresas = Empresa::all();
        return view('formatos.registros_charlas.create', compact('empresas'));
    }

    public function getTrabajadores(Empresa $empresa)
    {
        $trabajadores = $empresa->trabajadores()->select('id', 'nombre', 'apellido')->get();
        return response()->json($trabajadores);
    }

    public function store(Request $request)
    {
        // Validación de la solicitud
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'departamento' => 'required|string',
            'responsable_area' => 'required|string',
            'responsable_charla' => 'required|string',
            'area' => 'required|string',
            'fecha_charla' => 'required|date',
            'trabajadores' => 'required|array',
            'tema_brindado' => 'required|array',
            'temas_discutidos_notas' => 'required|string',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            // Creación del registro de charla
            $registroCharla = new RegistroCharla();
            $registroCharla->empresa_id = $request->empresa_id;
            $registroCharla->user_id = auth()->user()->id;
            $registroCharla->departamento = $request->departamento;
            $registroCharla->responsable_area = $request->responsable_area;
            $registroCharla->responsable_charla = $request->responsable_charla;
            $registroCharla->area = $request->area;
            $registroCharla->fecha_charla = $request->fecha_charla;
            $registroCharla->temas_discutidos_notas = $request->temas_discutidos_notas;
            $registroCharla->tema_brindado = json_encode($request->tema_brindado); // Guardar los IDs de los documentos como JSON

            // Manejo de las fotos
            $fotos = [];
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $path = $foto->store('charlas', 'public');
                    $fotos[] = $path;
                }
                $registroCharla->fotos = json_encode($fotos);
            }

            $registroCharla->save();

            // Adjuntar los trabajadores
            $registroCharla->trabajadores()->attach($request->trabajadores);

            return redirect()->route('registros_charlas.index')->with('success', 'Registro de charla creado correctamente');
        } catch (Exception $e) {
            return redirect()->route('registros_charlas.create')->with('error', 'Ocurrió un error al crear el registro de charla: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $registroCharla = RegistroCharla::with('trabajadores')->findOrFail($id);
        
        // Obtener los títulos de los documentos
        $temaIds = json_decode($registroCharla->tema_brindado, true);
        $temas = Document::whereIn('id', $temaIds)->pluck('file_path', 'id');
        
        return view('formatos.registros_charlas.show', compact('registroCharla', 'temas'));
    }
    public function edit($id)
    {
        $registroCharla = RegistroCharla::findOrFail($id);
        $empresas = Empresa::all();
        return view('formatos.registros_charlas.edit', compact('registroCharla', 'empresas'));
    }

    public function update(Request $request, $id)
    {
        // Validación de la solicitud
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'departamento' => 'required|string',
            'responsable_area' => 'required|string',
            'responsable_charla' => 'required|string',
            'area' => 'required|string',
            'fecha_charla' => 'required|date',
            'trabajadores' => 'required|array',
            'tema_brindado' => 'required|array',
            'temas_discutidos_notas' => 'required|string',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            // Actualización del registro de charla
            $registroCharla = RegistroCharla::findOrFail($id);
            $registroCharla->empresa_id = $request->empresa_id;
            $registroCharla->user_id = auth()->user()->id;
            $registroCharla->departamento = $request->departamento;
            $registroCharla->responsable_area = $request->responsable_area;
            $registroCharla->responsable_charla = $request->responsable_charla;
            $registroCharla->area = $request->area;
            $registroCharla->fecha_charla = $request->fecha_charla;
            $registroCharla->temas_discutidos_notas = $request->temas_discutidos_notas;
            $registroCharla->tema_brindado = json_encode($request->tema_brindado); // Guardar los IDs de los documentos como JSON

            // Manejo de las fotos
            if ($request->hasFile('fotos')) {
                $fotos = [];
                foreach ($request->file('fotos') as $foto) {
                    $path = $foto->store('fotos', 'public');
                    $fotos[] = $path;
                }
                $registroCharla->fotos = json_encode($fotos);
            }

            $registroCharla->save();

            // Sincronizar los trabajadores
            $registroCharla->trabajadores()->sync($request->trabajadores);

            return redirect()->route('registros_charlas.index')->with('success', 'Registro de charla actualizado correctamente');
        } catch (Exception $e) {
            return redirect()->route('registros_charlas.edit', $id)->with('error', 'Ocurrió un error al actualizar el registro de charla: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $registroCharla = RegistroCharla::findOrFail($id);
        $registroCharla->delete();

        return redirect()->route('registros_charlas.index')->with('success', 'Registro de charla eliminado con éxito.');
    }
}
