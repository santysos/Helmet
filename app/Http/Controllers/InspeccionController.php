<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspeccion;
use App\Models\InspeccionDetalle;
use App\Models\Empresa;
use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InspeccionMensualMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class InspeccionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user(); // Obtener el usuario autenticado


        // Obtener las inspecciones con los detalles y las relaciones de empresa y usuario
        $inspecciones = Inspeccion::with('detalles', 'empresa', 'user')
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%$search%")
                    ->orWhereHas('empresa', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%$search%");
                    });
            });

        // Si el usuario es Admin Empresa, filtrar por la empresa a la que pertenece
        if ($user->hasRole('Admin Empresa')) {
            $inspecciones->where('empresa_id', $user->empresa_id); // Filtrar por empresa_id del usuario
        }

        // Ordenar por fecha de creación y paginar los resultados
        $inspecciones = $inspecciones->orderBy('created_at', 'desc')->paginate(10);

        // Devolver la vista con las inspecciones filtradas
        return view('formatos.inspecciones.index', compact('inspecciones'));
    }

    public function sendInspeccionMensualEmail($id)
    {
        // Cargar inspección con los detalles y relaciones
        $inspeccion = Inspeccion::with('empresa', 'user', 'detalles')->findOrFail($id);

        // Definir las secciones manualmente con slicing
        $sections = [
            '1. Seguridad y Salud' => $inspeccion->detalles->slice(0, 9),
            '2. Órden y Limpieza' => $inspeccion->detalles->slice(9, 6),
            '3. Estructuras' => $inspeccion->detalles->slice(15, 4),
            '4. Instalaciones Eléctricas y Equipos' => $inspeccion->detalles->slice(19, 7),
            '5. Condiciones Ambientales' => $inspeccion->detalles->slice(26, 5),
            '6. Condiciones Sanitarias' => $inspeccion->detalles->slice(31, 6),
            '7. Equipos de Protección' => $inspeccion->detalles->slice(37, 6),
            '8. Herramientas' => $inspeccion->detalles->slice(43, 3),
            '9. Máquinas' => $inspeccion->detalles->slice(46, 5),
            '10. Vehículos' => $inspeccion->detalles->slice(51, 2),
        ];

        // Verificar que los detalles no estén vacíos
        if ($inspeccion->detalles->isEmpty()) {
            return back()->withErrors('No se encontraron detalles para esta inspección.');
        }

        // Generar el PDF y guardar en el almacenamiento temporal
        $pdf = Pdf::loadView('formatos.inspecciones.pdf', compact('inspeccion', 'sections'));
        $pdfPath = storage_path('app/public/inspeccion_' . $inspeccion->id . '.pdf');
        $pdf->save($pdfPath);

        // Configurar el correo electrónico y enviar
        try {
            Mail::to('recipient@example.com') // Cambia por el correo real del destinatario
                ->send(new InspeccionMensualMail($inspeccion, $pdfPath));
        } catch (\Exception $e) {
            return back()->withErrors('Error al enviar el correo: ' . $e->getMessage());
        }

        // Eliminar el archivo PDF después de enviar el correo
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('inspecciones.show', $id)
            ->with('success', 'El reporte de inspección mensual se ha enviado por correo exitosamente.');
    }


    public function generarPdf($id)
    {
        // Cargar inspección con los detalles y relaciones
        $inspeccion = Inspeccion::with('empresa', 'user', 'detalles')->findOrFail($id);

        // Definir las secciones manualmente con slicing
        $sections = [
            '1. Seguridad y Salud' => $inspeccion->detalles->slice(0, 9),
            '2. Órden y Limpieza' => $inspeccion->detalles->slice(9, 6),
            '3. Estructuras' => $inspeccion->detalles->slice(15, 4),
            '4. Instalaciones Eléctricas y Equipos' => $inspeccion->detalles->slice(19, 7),
            '5. Condiciones Ambientales' => $inspeccion->detalles->slice(26, 5),
            '6. Condiciones Sanitarias' => $inspeccion->detalles->slice(31, 6),
            '7. Equipos de Protección' => $inspeccion->detalles->slice(37, 6),
            '8. Herramientas' => $inspeccion->detalles->slice(43, 3),
            '9. Máquinas' => $inspeccion->detalles->slice(46, 5),
            '10. Vehículos' => $inspeccion->detalles->slice(51, 2),
        ];

        // Verificar que los detalles no estén vacíos
        if ($inspeccion->detalles->isEmpty()) {
            return back()->withErrors('No se encontraron detalles para esta inspección.');
        }

        // Generar la vista del PDF
        $pdf = Pdf::loadView('formatos.inspecciones.pdf', compact('inspeccion', 'sections'));

        // Descargar el PDF
        $nombreArchivo = 'Inspeccion_' . $inspeccion->id . '.pdf';
        return $pdf->download($nombreArchivo);
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

        $sections = [
            '1. Seguridad y Salud' => [
                '¿Existe señalización de advertencia, prohibición, obligación, de lucha contra incendios y áreas restringidas?',
                '¿Existe señalización de número de emergencia 911?',
                '¿Existen mapas y rutas de evacuación?',
                '¿Las salidas de emergencia no tienen obstáculos y las puertas se abren hacia afuera?',
                '¿Existe el mantenimiento e inspección de Extintores de PQS y CO2 al día?',
                '¿Existen lámparas de emergencia y están funcionando?',
                '¿Existen botiquines y cuentan con material de primeros auxilios en caso de accidente y es de fácil acceso dicho material?',
                '¿El centro de trabajo dispone de un botiquín portátil?',
                '¿La empresa cuenta con Plan de Emergencia actualizado en el último año, y aprobado por los Organismos de Control?',
            ],
            '2. Órden y Limpieza' => [
                '¿Las paredes se encuentran limpias, la pintura se encuentra en buen estado?',
                '¿Los pisos y superficies de trabajo se encuentran limpios y ordenados?',
                '¿Está libre de la presencia de plagas o vectores?',
                '¿Las perchas y otros lugares de almacenamiento se encuentran limpias, organizadas, ordenados y monitoreados, y con la debida rotulación?',
                '¿Los productos químicos disponen de un lugar de almacenamiento adecuado, con fichas de seguridad mismas que están al alcance de los trabajadores?',
                '¿Los productos peligrosos se guardan y se almacenan en armarios protegidos o en recipientes o depósitos apropiados y contienen etiquetas MSDS?',
            ],
            '3. Estructuras' => [
                '¿Los accesos a las puertas se encuentran libres de obstáculos que interfieren la salida de emergencia?',
                '¿Las escaleras se encuentran libres de obstáculos?',
                '¿Las escaleras están provistas de barandillas y pasamanos en buen estado?',
                '¿Los pasillos y corredores se encuentran libres de obstáculos y los objetos ubicados y almacenados de forma adecuada?',
            ],
            '4. Instalaciones Eléctricas y Equipos' => [
                '¿Los equipos funcionan adecuadamente, no se observan improvisaciones o arreglos parciales en las conexiones y cables de los equipos?',
                '¿Se encuentran en buen estado las conexiones eléctricas?',
                '¿Existe señalética de "Peligro Eléctrico" en puertas de tableros eléctricos?',
                '¿Existe suficiente número de interruptores de encendido y apagado?',
                '¿Los enchufes no se observan sobrecargados?',
                '¿Se provee en forma suficiente de agua potable para el consumo de los trabajadores?',
                '¿Los tableros eléctricos cuentan con identificación de mando on-off y con distintivos por área que corresponda?',
            ],
            '5. Condiciones Ambientales' => [
                'Se provee en forma suficiente de agua potable para el consumo de los trabajadores.',
                'Los lugares de trabajo y tránsito están dotados de suficiente iluminación.',
                'En espacios reducidos (confinados), cuentan son sistema de renovación de aire.',
                'En las instalaciones existen áreas con temperaturas elevadas o bajas.',
                'Las sillas de los  trabajadores es giratoria, tienen espaldar alto y regulable, cuenta con soporte lumbar regulable, el asiento ofrece confort, está provista de apoya brazos.',
            ],
            '6. Condiciones Sanitarias' => [
                'El área cuenta con servicios sanitarios bien ubicados, separados por género, ventilados y en perfecto estado de funcionamiento.',
                'Los excusados y urinarios se mantienen con las debidas condiciones de limpieza, desinfección y desodorización.',
                'La basura de los baños se recolecta y transporta con frecuencia necesaria para evitar la generación de olores y contaminación.',
                'Existe una adecuada disposición de los desechos: mantienen contenedores para la separación de papel de reciclaje y rehúso, se realiza reciclaje de botellas plásticas.',
                'Existen suficientes, adecuados, bien ubicados e identificados recipientes para desechos.',
                'En las papeleras de las oficinas no se deposita basura de origen orgánico u otros que pueden generar olores por la descomposición.',
            ],
            '7. Equipos de Protección' => [
                '¿El personal cuenta con elementos de Protección Personal (EPP), de acuerdo a su actividad?',
                '¿El personal cuenta con elementos de dotación (uniformes-ropa de trabajo)?',
                'Existe adecuado uso, mantenimiento y almacenaje de los Equipos de Protección Personal.',
                'Uso de equipo respiratorio adecuado si es requerido',
                'Uso de equipo de protección de caídas en altura (arnes y anillos de sujeción revisados y en buenas condiciones)',
                'Uso de cascos en buenas condiciones si es requerido',
            ],
            '8. Herramientas' => [
                'Las herramientas manuales se encuentran en buen estado',
                'Las herramientas de corte se encuentran en buen estado y con las protecciones adecuadas',
                'Las herramientas de golpe se encuentran en buen estado y son empleadas según su labor',
            ],
            '9. Máquinas' => [
                'Los elementos móviles de las máquinas (de transmisión que intervienen en el trabajo), son inaccesibles por diseño, fabricación y/o ubicación.',
                'Existen resguardos fijos y de seguridad que impiden el acceso de partes del cuerpo del trabajador a dispositivos móviles a los que se debe acceder ocasionalmente.',
                'Existe señalización adecuada de la máquina y riesgos existentes',
                'Existen uno o varios dispositivos de parada de emergencia accesibles rápidamente',
                'El operario ha sido formado y adiestrado en el manejo de la máquina.',
            ],
            '10. Vehículos' => [
                'Los vehículos se encuentran en buenas condiciones generales.',
                '¿Se realiza la inspección de vehículos periódica, previo al uso de vehículos?',
            ],
        ];

        $empresaSeleccionada = $user->hasRole('Admin Empresa') ? $user->empresa_id : null;

        return view('formatos.inspecciones.create', compact('empresas', 'sections', 'empresaSeleccionada', 'seleccionable'));
    }


    public function store(Request $request)
    {
        // Depuración para ver toda la estructura del Request
        // dd($request->all(), $request->file('photos'));

        $validatedData = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'area' => 'nullable|string|max:255',
            'fecha_inspeccion' => 'nullable|date',
            'responsable_inspeccion' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'responsable_area' => 'nullable|string|max:255',
            'questions' => 'required|array',
            'answers' => 'nullable|array',
            'observations' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*.*' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048', // Asegúrate de validar correctamente el array multidimensional
        ], [
            'empresa_id.required' => 'La empresa es obligatoria.',
            'empresa_id.exists' => 'La empresa seleccionada no es válida.',
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no es válido.',
            'questions.required' => 'Las preguntas son obligatorias.',
            'photos.*.*.image' => 'Cada foto debe ser una imagen.', // Cambiado para validar correctamente el array multidimensional
            'photos.*.*.mimes' => 'Cada foto debe ser un archivo de tipo: jpeg,webp , png, jpg, gif.', // Cambiado para validar correctamente el array multidimensional
            'photos.*.*.max' => 'Cada foto no debe ser mayor a 2048 kilobytes.', // Cambiado para validar correctamente el array multidimensional
        ]);

        try {
            $inspeccion = Inspeccion::create($validatedData);

            foreach ($request->questions as $sectionIndex => $sectionQuestions) {
                foreach ($sectionQuestions as $questionIndex => $question) {
                    $detalle = [
                        'inspeccion_id' => $inspeccion->id,
                        'pregunta' => $question,
                        'respuesta' => isset($request->answers[$sectionIndex][$questionIndex]) && $request->answers[$sectionIndex][$questionIndex] == 'yes',
                        'observaciones' => $request->observations[$sectionIndex][$questionIndex] ?? null,
                    ];

                    if ($request->hasFile("photos.$sectionIndex.$questionIndex")) {
                        $photo = $request->file("photos.$sectionIndex.$questionIndex");

                        // Crear una instancia de ImageManager con el driver Imagick
                        $manager = new ImageManager(new Driver());
                        if ($photo->isValid()) {
                            // Leer la imagen desde el archivo usando el manager
                            $image = $manager->read($photo->getPathname());
                            $image->scale(height: 800); // 400 x 300

                            // Generar un nombre único para la imagen
                            $imageName = time() . '_' . uniqid() . '.jpg';
                            $photoPath = 'inspeccion_photos/' . $imageName;

                            // Guardar la imagen redimensionada en el directorio de storage con una calidad del 75%
                            $image->save(storage_path('app/public/' . $photoPath), quality: 75);

                            $detalle['photo'] = $photoPath;
                        } else {
                            return redirect()->back()->withInput()->withErrors(['photos' => 'La foto no es válida.']);
                        }
                    }

                    InspeccionDetalle::create($detalle);
                }
            }

            return redirect()->route('inspecciones.index')->with('success', 'Inspección creada con éxito.');
        } catch (\Exception $e) {
            \Log::error('Error al crear la inspección: ' . $e->getMessage());
            return redirect()->route('inspecciones.create')->withInput()->withErrors(['error' => 'Hubo un problema al crear la inspección: ' . $e->getMessage()]);
        }
    }





    public function show($id)
    {
        $inspeccion = Inspeccion::with('detalles', 'empresa', 'user')->findOrFail($id);
        return view('formatos.inspecciones.show', compact('inspeccion'));
    }

    public function edit($id)
    {
        $inspeccion = Inspeccion::with('detalles')->findOrFail($id);
        $empresas = Empresa::all();
        $users = User::all();
        return view('formatos.inspecciones.edit', compact('inspeccion', 'empresas', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'area' => 'nullable|string|max:255',
            'fecha_inspeccion' => 'nullable|date',
            'responsable_inspeccion' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'responsable_area' => 'nullable|string|max:255',
            'questions' => 'required|array',
            'answers' => 'nullable|array',
            'observations' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $inspeccion = Inspeccion::findOrFail($id);
        $inspeccion->update($request->only([
            'empresa_id',
            'user_id',
            'area',
            'fecha_inspeccion',
            'responsable_inspeccion',
            'departamento',
            'responsable_area'
        ]));

        $inspeccion->detalles()->delete();

        foreach ($request->questions as $index => $question) {
            $detalle = [
                'inspeccion_id' => $inspeccion->id,
                'pregunta' => $question,
                'respuesta' => isset($request->answers[$index]) && $request->answers[$index] == 'yes',
                'observaciones' => $request->observations[$index] ?? null,
            ];

            if (isset($request->photos[$index])) {
                $photoPath = $request->photos[$index]->store('inspeccion_photos', 'public');
                $detalle['photo'] = $photoPath;
            }

            InspeccionDetalle::create($detalle);
        }

        return redirect()->route('inspecciones.index')->with('success', 'Inspección actualizada con éxito.');
    }
    public function destroy($id)
    {
        $inspeccion = Inspeccion::findOrFail($id);
        $inspeccion->delete();

        return redirect()->route('inspecciones.index')->with('success', 'Inspección eliminada con éxito.');
    }
}
