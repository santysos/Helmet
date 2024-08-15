<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NearAccidentReport;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class NearAccidentReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $reports = NearAccidentReport::when($search, function ($query, $search) {
            return $query->where('id', 'like', "%$search%")
                ->orWhere('reporter_name', 'like', "%$search%")
                ->orWhere('victim_name', 'like', "%$search%");
        })
            ->where('id', '!=', 0)  // Excluir el ID 0
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('formatos.casi_accidente.index', compact('reports'));
    }


    public function create()
    {
        $empresas = Empresa::where('id', '!=', 0)->get();
        $users = User::all();


        return view('formatos.casi_accidente.create', compact('users', 'empresas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_position' => 'required|string|max:255',
            'reporter_area' => 'required|string|max:255',
            'victim_name' => 'required|string|max:255',
            'victim_position' => 'required|string|max:255',
            'victim_work_location' => 'required|string|max:255',
            'description' => 'required|string',
            'condition_type' => 'required|array',
            'condition_type.*' => 'string',
            'severity_level' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpeg,webp,png,jpg|max:2048',
            'follow_up_name' => 'required|array',
            'follow_up_name.*' => 'exists:users,id', // Validar que los IDs existen en la tabla users
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $photos = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('near_accident_photos', 'public');
                    $photos[] = $path;
                }
            }

            // Obtener los correos electrónicos de los usuarios seleccionados
            $followUpEmails = User::whereIn('id', $validated['follow_up_name'])->pluck('email')->toArray();

            NearAccidentReport::create([
                'reporter_name' => $validated['reporter_name'],
                'reporter_position' => $validated['reporter_position'],
                'reporter_area' => $validated['reporter_area'],
                'victim_name' => $validated['victim_name'],
                'victim_position' => $validated['victim_position'],
                'victim_work_location' => $validated['victim_work_location'],
                'description' => $validated['description'],
                'condition_type' => json_encode($validated['condition_type']),
                'severity_level' => $validated['severity_level'],
                'photos' => json_encode($photos),
                'follow_up_name' => json_encode($validated['follow_up_name']),
                'follow_up_email' => json_encode($followUpEmails), // Guardar los correos electrónicos como JSON
                'empresa_id' => $validated['empresa_id'],
                'user_id' => $validated['user_id'],
            ]);

            return redirect()->route('casi_accidente.index')->with('success', 'Reporte enviado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al crear el reporte de casi accidente: ' . $e->getMessage());
            return redirect()->route('casi_accidente.create')->with('error', 'Hubo un error al enviar el reporte. Por favor, inténtelo de nuevo. ' . $e->getMessage());
        }
    }



    public function show($id)
    {
        $nearAccidentReport = NearAccidentReport::with(['empresa', 'user'])->findOrFail($id);
        return view('formatos.casi_accidente.show', compact('nearAccidentReport'));
    }



    public function generatePdf($id)
    {
        $nearAccidentReport = NearAccidentReport::with(['empresa', 'user'])->findOrFail($id);
    
        // Generar el PDF utilizando la vista 'formatos.casi_accidente.pdf'
        $pdf = PDF::loadView('formatos.casi_accidente.pdf', compact('nearAccidentReport'))->setPaper('a4');
        return $pdf->download('reporte_casi_accidente_' . $id . '.pdf');
    }
    
    public function edit($id)
    {
        $nearAccidentReport = NearAccidentReport::findOrFail($id);
        $empresas = Empresa::all();
        $users = User::all();
        return view('formatos.casi_accidente.edit', compact('nearAccidentReport', 'empresas', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_position' => 'required|string|max:255',
            'reporter_area' => 'required|string|max:255',
            'victim_name' => 'required|string|max:255',
            'victim_position' => 'required|string|max:255',
            'victim_work_location' => 'required|string|max:255',
            'description' => 'required|string',
            'condition_type' => 'required|array',
            'condition_type.*' => 'string',
            'severity_level' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpeg,webp,png,jpg|max:2048',
            'follow_up_name' => 'required|array',
            'follow_up_name.*' => 'exists:users,id', // Validar que los IDs existen en la tabla users
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $nearAccidentReport = NearAccidentReport::findOrFail($id);
            $photos = $nearAccidentReport->photos ? json_decode($nearAccidentReport->photos) : []; // Mantener las fotos existentes
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('near_accident_photos', 'public');
                    $photos[] = $path;
                }
            }

            // Obtener los correos electrónicos de los usuarios seleccionados
            $followUpEmails = User::whereIn('id', $validated['follow_up_name'])->pluck('email')->toArray();

            $nearAccidentReport->update([
                'reporter_name' => $validated['reporter_name'],
                'reporter_position' => $validated['reporter_position'],
                'reporter_area' => $validated['reporter_area'],
                'victim_name' => $validated['victim_name'],
                'victim_position' => $validated['victim_position'],
                'victim_work_location' => $validated['victim_work_location'],
                'description' => $validated['description'],
                'condition_type' => json_encode($validated['condition_type']),
                'severity_level' => $validated['severity_level'],
                'photos' => json_encode($photos),
                'follow_up_name' => json_encode($validated['follow_up_name']),
                'follow_up_email' => json_encode($followUpEmails), // Guardar los correos electrónicos como JSON
                'empresa_id' => $validated['empresa_id'],
                'user_id' => $validated['user_id'],
            ]);

            return redirect()->route('casi_accidente.index')->with('success', 'Reporte actualizado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar el reporte de casi accidente: ' . $e->getMessage());
            return redirect()->route('casi_accidente.edit', $id)->with('error', 'Hubo un error al actualizar el reporte. Por favor, inténtelo de nuevo. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $nearAccidentReport = NearAccidentReport::findOrFail($id);
            $nearAccidentReport->delete();
            return redirect()->route('casi_accidente.index')->with('success', 'Reporte eliminado con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar el reporte de casi accidente: ' . $e->getMessage());
            return redirect()->route('casi_accidente.index')->with('error', 'Hubo un error al eliminar el reporte. Por favor, inténtelo de nuevo.');
        }
    }
}
