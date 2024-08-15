<?php

namespace App\Http\Controllers;

use App\Models\InspeccionExtintores;
use App\Models\InspeccionExtintoresImagen;

use App\Models\Empresa;
use App\Models\Extintor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use App\Mail\InspeccionExtintoresMail;
use Illuminate\Support\Facades\Mail;

class InspeccionExtintoresController extends Controller
{
    public function index()
    {
        $inspecciones = InspeccionExtintores::with('empresa')->orderBy('id','desc')->get();
        return view('formatos.inspecciones_extintores.index', compact('inspecciones'));
    }

    public function sendInspeccionEmail($id)
    {
        $inspeccion = InspeccionExtintores::with(['empresa', 'detalles.extintor'])->findOrFail($id);

        // Obtener los IDs de los extintores
        $extintorIds = $inspeccion->detalles->pluck('extintor.id')->unique();

        // Obtener las imágenes desde la tabla inspecciones_extintores_imagenes
        $imagenes = InspeccionExtintoresImagen::where('inspeccion_extintor_id', $id)
            ->whereIn('extintor_id', $extintorIds)
            ->get();

        // Generar el PDF y pasar la variable $imagenes a la vista
        $pdf = PDF::loadView('formatos.inspecciones_extintores.pdf', compact('inspeccion', 'imagenes'));
        $pdfPath = storage_path('app/public/inspeccion_' . $inspeccion->id . '.pdf');
        $pdf->save($pdfPath);

        // Enviar el correo con el PDF adjunto
        Mail::to('recipient@example.com')->send(new InspeccionExtintoresMail($inspeccion, $pdfPath));

        return redirect()->route('inspecciones_extintores.show', $id)->with('success', 'Correo enviado exitosamente');
    }


    public function create()
    {
        $empresas = Empresa::all();
        $extintores = Extintor::all();
        return view('formatos.inspecciones_extintores.create', compact('empresas', 'extintores'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'empresa_id' => 'required|exists:empresas,id',
                'area' => 'required|string|max:255',
                'fecha_inspeccion' => 'required|date', // Cambiar a 'date' para aceptar 'Y-m-d'
                'responsable_inspeccion' => 'required|string|max:255',
                'departamento' => 'required|string|max:255',
                'comentarios' => 'nullable|string',
                'riesgos_recomendaciones' => 'nullable|string',
            ]);

            // Convertir la fecha del formato Y-m-d a d/m/Y
            $data['fecha_inspeccion'] = Carbon::parse($data['fecha_inspeccion'])->format('Y-m-d');

            $inspeccion = InspeccionExtintores::create($data);

            return redirect()->route('inspecciones_extintores.show', $inspeccion->id)->with('success', 'Inspección creada exitosamente.');
        } catch (\Exception $e) {
            // Loggear el error
            \Log::error("Error al crear inspección: " . $e->getMessage());

            // Redirigir con mensaje de error
            return redirect()->back()->withErrors('Error al crear la inspección: ' . $e->getMessage())->withInput();
        }
    }

    public function generatePD333F($id)
    {
        $inspeccion = InspeccionExtintores::with(['empresa', 'detalles.extintor'])->findOrFail($id);

        // Obtener los IDs de los extintores
        $extintorIds = $inspeccion->detalles->pluck('extintor.id')->unique();

        // Obtener las imágenes desde la tabla inspecciones_extintores_imagenes
        $imagenes = InspeccionExtintoresImagen::where('inspeccion_extintor_id', $id)
            ->whereIn('extintor_id', $extintorIds)
            ->get();

        $pdf = PDF::loadView('formatos.inspecciones_extintores.pdf', compact('inspeccion', 'imagenes'));
        return $pdf->stream('inspeccion_extintores_' . $inspeccion->id . '.pdf');
    }


    public function generatePDF($id)
    {
        $inspeccion = InspeccionExtintores::with(['empresa', 'detalles.extintor'])->findOrFail($id);

        // Obtener los IDs de los extintores
        $extintorIds = $inspeccion->detalles->pluck('extintor.id')->unique();

        // Obtener las imágenes desde la tabla inspecciones_extintores_imagenes
        $imagenes = InspeccionExtintoresImagen::where('inspeccion_extintor_id', $id)
            ->whereIn('extintor_id', $extintorIds)
            ->get();


        $pdf = PDF::loadView('formatos.inspecciones_extintores.pdf', compact('inspeccion', 'imagenes'));

        return $pdf->download('inspeccion_extintores_' . $inspeccion->id . '.pdf');
    }




    public function show($id)
    {
        $inspeccion = InspeccionExtintores::with([
            'empresa',
            'detalles.extintor',       // Cargar detalles y sus respectivos extintores
            'detalles.imagenes',        // Cargar imágenes asociadas a cada detalle
        ])->findOrFail($id);

        // Obtener los IDs de los extintores
        $extintorIds = $inspeccion->detalles->pluck('extintor.id')->unique();

        // Obtener las imágenes desde la tabla inspecciones_extintores_imagenes
        $imagenes = InspeccionExtintoresImagen::where('inspeccion_extintor_id', $id)
            ->whereIn('extintor_id', $extintorIds)
            ->get();

        // Retornar la vista con la inspección y las imágenes
        return view('formatos.inspecciones_extintores.show', compact('inspeccion', 'imagenes'));
    }




    public function edit($id)
    {
        $inspeccion = InspeccionExtintores::with(['extintores'])->findOrFail($id);
        $empresas = Empresa::all();
        $extintores = Extintor::all();
        return view('formatos.inspecciones_extintores.edit', compact('inspeccion', 'empresas', 'extintores'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'area' => 'required|string|max:255',
            'fecha_inspeccion' => 'required|date_format:d/m/Y',
            'responsable_inspeccion' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'comentarios' => 'nullable|string',
            'riesgos_recomendaciones' => 'nullable|string',
            'extintores' => 'required|array',
            'extintores.*' => 'exists:extintores,id',
        ]);

        // Convertir la fecha del formato d/m/Y a Y-m-d
        $data['fecha_inspeccion'] = Carbon::createFromFormat('d/m/Y', $data['fecha_inspeccion'])->format('Y-m-d');

        $inspeccion = InspeccionExtintores::findOrFail($id);
        $inspeccion->update($data);
        $inspeccion->extintores()->sync($data['extintores']);

        return redirect()->route('inspecciones_extintores.show', $id)->with('success', 'Inspección actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $inspeccion = InspeccionExtintores::findOrFail($id);
        $inspeccion->extintores()->detach();
        $inspeccion->delete();

        return redirect()->route('inspecciones_extintores.index')->with('success', 'Inspección eliminada exitosamente.');
    }
}
