<?php

namespace App\Http\Controllers;

use App\Models\InspeccionExtintoresDetalle;
use App\Models\InspeccionExtintores;
use App\Models\InspeccionExtintoresImagen;
use App\Models\Empresa;
use App\Models\Extintor;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Facades\Log;

class InspeccionExtintoresDetalleController extends Controller
{
    // Método para mostrar el formulario de creación de inspecciones detalladas
    public function create($inspeccionId)
    {
        $empresas = Empresa::all();

        // Obtener la inspección
        $inspeccion = InspeccionExtintores::findOrFail($inspeccionId);

        // Obtener los IDs de los extintores que ya han sido inspeccionados
        $inspeccionados = InspeccionExtintoresDetalle::where('inspeccion_extintor_id', $inspeccionId)
            ->pluck('extintor_id')
            ->toArray();

        // Filtrar los extintores que pertenecen a la empresa y que no han sido inspeccionados aún
        $extintores = Extintor::where('empresa_id', $inspeccion->empresa_id)
            ->whereNotIn('id', $inspeccionados)
            ->get();

        $questions = [
            "Está el extintor en su lugar?",
            "Esta completamente cargado y operable?",
            "El acceso y visibilidad del extintor está libre de obstrucciones?",
            "Tiene sello de seguridad?",
            "Tiene el pasador de seguridad?",
            "La pintura está en buen estado?",
            "El cilindro presenta oxidación, roturas, abolladuras, golpes o deformaciones?",
            "La manguera tiene roturas, poros, agrietamientos, u obstrucciones con papel, animales, otros?",
            "Están bien los empalmes de la manguera a la válvula a la corneta y la boquilla?",
            "La corneta (en los extintores de CO2) presenta fisuras, cristalización y defectos en acoples?",
            "La válvula presenta oxidación, daños en la manija, deformaciones que impidan su funcionamiento?",
            "Las calcamonias y las placas de instrucción están claramente visibles y legibles y en el frente del extintor?",
            "El gabinete o gancho está ubicado a la altura correspondiente? (no mayor a 1,5 m)",
            "La base del extintor está al menos a 10 cm de altura sobre el nivel del piso?",
            "El mantenimiento y recarga ha sido realizado por personas previamente certificadas?",
            "Los extintores cuentan con una placa y etiqueta de identificación de la empresa?",
            "¿Se realiza la inspección de vehículos periódica, previo al uso en vehículos?"
        ];

        return view('formatos.inspecciones_extintores_detalles.create', compact('empresas', 'extintores', 'questions', 'inspeccionId'));
    }


    public function store(Request $request, $inspeccionId)
    {
        try {
            $data = $request->validate([
                'extintor_id' => 'required|exists:extintores,id',
                'preguntas' => 'required|array',
                'preguntas.*.respuesta' => 'required|in:si,no',
                'preguntas.*.observaciones' => 'nullable|string',
                'imagenes.*' => 'nullable|image|mimes:jpeg,png,JPG,jpg,gif,webp|max:2048', // Validar imágenes
            ]);

            $detalle = null;

            foreach ($request->preguntas as $index => $pregunta) {
                $detalle = InspeccionExtintoresDetalle::create([
                    'inspeccion_extintor_id' => $inspeccionId,
                    'extintor_id' => $request->extintor_id,
                    'pregunta' => $pregunta['texto'],
                    'respuesta' => $pregunta['respuesta'],
                    'observaciones' => $pregunta['observaciones'] ?? '',
                ]);
            }

            // Procesar y guardar imágenes
            if ($request->hasFile('imagenes')) {
                // Crear una instancia de ImageManager con el driver Imagick
                $manager = new ImageManager(new Driver());

                foreach ($request->file('imagenes') as $imagen) {
                    // Leer la imagen desde el archivo usando el manager
                    $image = $manager->read($imagen->getPathname());

                    $image->scale(height: 800); // 400 x 300

                    // Generar un nombre único para la imagen
                    $imageName = time() . '_' . uniqid() . '.jpg';
                    $path = 'inspecciones_imagenes/' . $imageName;

                    // Guardar la imagen redimensionada en el directorio de storage con una calidad del 75%
                    $image->save(storage_path('app/public/' . $path), quality: 75);

                    // Guardar la referencia de la imagen en la base de datos
                    InspeccionExtintoresImagen::create([
                        'inspeccion_extintor_id' => $detalle->inspeccion_extintor_id,
                        'extintor_id' => $detalle->extintor_id,
                        'ruta_imagen' => $path,
                    ]);
                }
            }


            return redirect()->route('inspecciones_extintores.show', $inspeccionId)->with('success', 'Detalle añadido correctamente');
        } catch (\Exception $e) {
            Log::error("Error al guardar detalles de inspección: " . $e->getMessage());
            return redirect()->back()->withErrors('Error al guardar el detalle de la inspección: ' . $e->getMessage())->withInput();
        }
    }



    // Método para mostrar una inspección detallada específica
    public function show($id)
    {
        $detalle = InspeccionExtintoresDetalle::findOrFail($id);
        return view('inspecciones_extintores_detalles.show', compact('detalle'));
    }

    public function edit($extintor_id, $inspeccion_id)
    {
        // Obtener los detalles de la inspección para el extintor específico
        $detalles = InspeccionExtintoresDetalle::where('extintor_id', $extintor_id)
            ->where('inspeccion_extintor_id', $inspeccion_id)
            ->get();

        //  dd($detalles);

        // Obtener la lista de extintores de la empresa
        $extintores = Extintor::where('empresa_id', $detalles[0]->inspeccionExtintor->empresa_id)->get();

        // Pasar los detalles y los extintores a la vista
        return view('formatos.inspecciones_extintores_detalles.edit', compact('detalles', 'extintores', 'inspeccion_id'));
    }
    public function destroy($extintor_id, $inspeccion_id)
    {
        // Buscar el detalle de la inspección que deseas eliminar
        $detalle = InspeccionExtintoresDetalle::where('inspeccion_id', $inspeccion_id)
            ->where('extintor_id', $extintor_id)
            ->firstOrFail();

        // Eliminar el detalle
        $detalle->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('inspecciones_extintores.edit', ['id' => $inspeccion_id])
            ->with('success', 'Detalle de inspección eliminado correctamente.');
    }
}
