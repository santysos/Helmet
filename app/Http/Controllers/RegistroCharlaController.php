<?php

namespace App\Http\Controllers;

use App\Models\RegistroCharla;
use App\Models\Empresa;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Mail\ReporteCharlasSeguridadMail;
use Illuminate\Support\Facades\Mail;

class RegistroCharlaController extends Controller
{

    public function index(Request $request)
    {
        $query = RegistroCharla::with('empresa');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('departamento', 'like', "%{$search}%")
                    ->orWhere('responsable_charla', 'like', "%{$search}%")
                    ->orWhereHas('empresa', function ($q) use ($search) {
                        $q->where('nombre', 'like', "%{$search}%");
                    });
            });
        }

        $registrosCharlas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('formatos.registros_charlas.index', compact('registrosCharlas'));
    }

    public function sendReporteEmail($id)
    {
        // Obtener la charla de seguridad con los detalles necesarios
        $registroCharla = RegistroCharla::with(['trabajadores'])->findOrFail($id);

        // Generar el PDF con los detalles de la charla
        $pdf = PDF::loadView('formatos.registros_charlas.pdf', compact('registroCharla'));

        // Guardar el PDF temporalmente en el sistema de archivos
        $pdfPath = storage_path('app/public/reporte_charla_' . $registroCharla->id . '.pdf');
        $pdf->save($pdfPath);

        // Enviar el correo con el PDF adjunto
        Mail::to('recipient@example.com') // Cambia a la dirección del destinatario
            ->send(new ReporteCharlasSeguridadMail($registroCharla, $pdfPath));

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('registros_charlas.index')->with('success', 'Correo enviado exitosamente');
    }


    public function downloadPDF($id)
    {
        $registroCharla = RegistroCharla::with('trabajadores')->findOrFail($id);

        // Obtener los títulos de los documentos
        $temaIds = json_decode($registroCharla->tema_brindado, true);
        $temas = Document::whereIn('id', $temaIds)->pluck('file_path', 'id');

        // Limpiar y convertir las rutas de las fotos a rutas absolutas
        if ($registroCharla->fotos) {
            // Convertir las rutas de fotos en URLs absolutas
            $fotos = array_map(function ($foto) {
                return public_path('storage/' . str_replace('\\/', '/', $foto));
            }, json_decode($registroCharla->fotos, true));

            $registroCharla->fotos = json_encode($fotos);
        }

        $pdf = PDF::loadView('formatos.registros_charlas.pdf', compact('registroCharla', 'temas'));
        return $pdf->download('detalle_charla.pdf');
    }


    public function create()
    {
        $user = auth()->user();

        // Si el usuario tiene el rol SuperAdmin o Admin Helmet
        if ($user->hasRole(['SuperAdmin', 'Admin Helmet'])) {
            $empresas = Empresa::all(); // Cargar todas las empresas
            $empresaSeleccionada = null; // No preseleccionada
            $seleccionable = true; // El select será editable
        }
        // Si el usuario tiene el rol Admin Empresa
        elseif ($user->hasRole('Admin Empresa')) {
            $empresas = Empresa::where('id', $user->empresa_id)->get(); // Solo su empresa
            $empresaSeleccionada = $user->empresa_id; // Empresa preseleccionada
            $seleccionable = false; // El select será no editable
        } else {
            abort(403, 'No tienes permisos para realizar esta acción.'); // Control de acceso
        }
        return view('formatos.registros_charlas.create', compact('user', 'empresas', 'empresaSeleccionada', 'seleccionable'));
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
            'trabajadores' => 'required|array|exists:trabajadores,id', // Verifica que los trabajadores existan
            'tema_brindado' => 'required|array',
            'temas_discutidos_notas' => 'required|string',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // 'nullable' permite no subir fotos
        ]);

        try {
            // Iniciar la transacción para asegurar consistencia en la base de datos
            DB::beginTransaction();

            // Crear el registro de charla
            $registroCharla = new RegistroCharla();
            $registroCharla->empresa_id = $request->empresa_id;
            $registroCharla->user_id = auth()->user()->id;
            $registroCharla->departamento = $request->departamento;
            $registroCharla->responsable_area = $request->responsable_area;
            $registroCharla->responsable_charla = $request->responsable_charla;
            $registroCharla->area = $request->area;
            $registroCharla->fecha_charla = $request->fecha_charla;
            $registroCharla->temas_discutidos_notas = $request->temas_discutidos_notas;
            $registroCharla->tema_brindado = json_encode($request->tema_brindado); // Guardar los temas brindados como JSON

            // Manejo de las fotos
            $fotos = [];
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $path = $foto->store('charlas', 'public'); // Guarda las fotos en el directorio 'charlas' en 'storage/app/public'
                    $fotos[] = $path;
                }
                $registroCharla->fotos = json_encode($fotos); // Guarda las rutas de las fotos como JSON
            }

            // Guardar el registro de la charla
            $registroCharla->save();

            // Adjuntar los trabajadores
            $registroCharla->trabajadores()->attach($request->trabajadores);

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('registros_charlas.index')->with('success', 'Registro de charla creado correctamente');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

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
