<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Empresa; // Asegúrate de importar el modelo Empresa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class DocumentController extends Controller
{
    public function index($category, $folder)
    {
        $user = Auth::user();
        $empresas = Empresa::all();

        // Si el usuario tiene empresa_id 0, mostrar todos los documentos
        if ($user->empresa_id == 0) {
            $documents = Document::where('file_path', 'LIKE', "%$category/$folder%")->get();
        } else {
            // Si el usuario tiene un empresa_id específico, mostrar solo los documentos de su empresa
            $documents = Document::where('empresa_id', $user->empresa_id)
                ->where('file_path', 'LIKE', "%$category/$folder%")
                ->get();
        }

        return view('documents.index', compact('documents', 'category', 'folder', 'empresas'));
    }

    public function getDocumentosCharlasSeguridad()
    {
        $documentos = Document::where('file_path', 'LIKE', '%charlas_seguridad%')->get(['id', 'file_path']);

        $documentos->transform(function ($documento) {
            $documento->nombre = basename($documento->file_path);
            return $documento;
        });

        return response()->json($documentos);
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:5120',  // 5120 KB = 5 MB
            'empresa_id' => 'nullable|integer',
        ]);

        $section = $request->urlPath;

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = "documents/{$section}/{$fileName}";

        // Verificar si el archivo ya existe
        if (Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'El archivo ya está cargado.');
        }

        // Si el archivo no existe, guárdalo
        $storedPath = $file->storeAs("documents{$section}", $fileName, 'public');

        Document::create([
            'empresa_id' => $request->input('empresa_id', 0),
            'file_path' => $storedPath,
        ]);

        return back()->with('success', 'PDF cargado exitosamente.');
    }

    public function update(Request $request, Document $document)
    {
        // Validar los datos del formulario
        $request->validate([
            'new_file_name' => 'required|string|max:255', // Puedes ajustar las reglas de validación según tus necesidades
        ]);

        // Obtener el nuevo nombre del archivo del formulario
        $newFileName = $request->new_file_name;

        // Obtener la ruta del archivo original
        $oldFilePath = $document->file_path;

        // Crear la nueva ruta del archivo con el nuevo nombre
        $newFilePath = dirname($oldFilePath) . '/' . $newFileName;

        // Renombrar el archivo en el sistema de archivos
        Storage::disk('public')->move($oldFilePath, $newFilePath);

        // Actualizar el nombre del archivo en la base de datos
        $document->update(['file_path' => $newFilePath]);

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('success', 'El nombre del archivo se ha actualizado correctamente.');
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'empresa_id' => 'nullable|integer',
        ]);

        $filePath = $request->file('file')->store('documents', 'public');

        Document::create([
            'empresa_id' => $request->input('empresa_id', 0),
            'file_path' => $filePath,
        ]);

        return redirect()->route('documents.index')->with('success', 'PDF cargado exitosamente.');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        try {
            // Eliminar el archivo del sistema de archivos
            Storage::disk('public')->delete($document->file_path);

            // Eliminar el registro de la base de datos
            $document->delete();

            return back()->with('success', 'El archivo se ha eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al eliminar el archivo: ' . $e->getMessage());
        }
    }
}
