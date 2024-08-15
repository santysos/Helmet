<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleInspection;
use App\Models\VehicleInspectionDetail;
use App\Models\Empresa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InspectionVehicleReportMail;
use Illuminate\Support\Facades\Mail;


class VehicleInspectionController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $inspections = VehicleInspection::when($search, function ($query, $search) {
        return $query->where('id', 'like', "%$search%")
                     ->orWhere('driver_name', 'like', "%$search%")
                     ->orWhere('plate', 'like', "%$search%");
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    return view('formatos.vehiculos.index', compact('inspections'));
}


    public function generatePdf($id)
    {
        $inspection = VehicleInspection::with('details')->findOrFail($id);
        $pdf = PDF::loadView('formatos.vehiculos.pdf', compact('inspection'));



        return $pdf->download('inspection_'.$id.'.pdf');
    }


    public function create()
    {
        $empresas = Empresa::all();
        $users = User::all();
        $questions = [
            '¿El vehículo tiene la matriculación y revisión al día?',
            '¿El conductor tiene la licencia al día, puntos y es la licencia es de acuerdo al automotor que conduce?',
            '¿Se realizan revisiones periódicas de motor y cabina del automotor?',
            '¿El vehículo cuenta con las luces adecuadas bajas medias y altas?',
            '¿El vehículo cuenta con las luces direccionales adecuadas?',
            '¿El vehículo cuenta con las luces de stop?',
            '¿El vehículo cuenta con las luces de reversa?',
            '¿El vehículo cuenta con la alarma sonora de retroceso?',
            '¿Las llantas del vehículo se encuentran en buen estado, labrado, desgastes, arañazos, etc.?',
            '¿El vehículo tiene la llanta de repuesto adecuada y en buenas condiciones?',
            '¿El vehículo cuenta con espejos retrovisores en buenas condiciones?',
            '¿Los espejos retrovisores cuentan con espejos de punto ciego?',
            '¿El vehículo tiene los limpiaparabrisas en buen estado?',
            '¿El vehículo cuenta con pito en buen estado?',
            '¿El vehículo cuenta con los cinturones de seguridad en buen estado?',
            '¿El vehículo tiene fugas de aceite u otros combustibles?',
            '¿El vehículo dispone de elementos de señalización en caso de accidente? Conos de seguridad, triángulos',
            '¿El vehículo dispone de herramientas básicas? Cruceta, gata, linterna, llave inglesa',
            '¿El vehículo dispone de elementos de contingencia ante incendios o accidentes? Extintor, botiquín de primeros auxilios',
            '¿El botiquín de Primeros Auxilios se encuentra en perfectas condiciones de acuerdo a check de botiquines?',
            '¿El vehículo se mantiene limpio y ordenado al exterior e interior de la cabina?',
            '¿Hay espacio adecuado para guardar las herramientas y almacenar las cosas dentro de la cabina?',
            '¿La cabina del conductor se encuentra netamente limpia y despejada de cualquier objeto en los pedales de frenado y aceleración?',
            '¿Los conductores muestran hábitos seguros (no fumar…)?',
            '¿El asiento es ergonómico y regulable?',
            '¿Los sistemas de acceso son antideslizantes y facilitan el acceso (agarraderos, peldaños...)?',
            '¿Se hace un mantenimiento y limpieza periódico de las luces?',
        ];

        return view('formatos.vehiculos.create', compact('empresas', 'users', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'driver_name' => 'required|string|max:255',
            'plate' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:255',
            'inspection_date' => 'required|date',
            'supervised_by' => 'required|string|max:255',
        ]);

        $inspection = VehicleInspection::create($request->only([
            'empresa_id', 'user_id', 'driver_name', 'plate', 'vehicle_number', 'inspection_date', 'supervised_by', 'observations_general'
        ]));



        foreach ($request->questions as $index => $question) {
            VehicleInspectionDetail::create([
                'vehicle_inspection_id' => $inspection->id,
                'question' => $question,
                'answer' => isset($request->answers[$index]) ? 1 : 0,
                'observations' => $request->observations[$index] ?? null,
            ]);
        }

        return redirect()->route('vehiculos.index')->with('success', 'Formulario enviado con éxito');
    }

    public function show($id)
    {
        $inspection = VehicleInspection::with('details')->findOrFail($id);
        return view('formatos.vehiculos.show', compact('inspection'));
    }

    public function edit($id)
    {
        $inspection = VehicleInspection::with('details')->findOrFail($id);
        $empresas = Empresa::all();
        $users = User::all();
        return view('formatos.vehiculos.edit', compact('inspection', 'empresas', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'user_id' => 'required|exists:users,id',
            'driver_name' => 'required|string|max:255',
            'plate' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:255',
            'inspection_date' => 'required|date',
            'supervised_by' => 'required|string|max:255',
        ]);

        $inspection = VehicleInspection::findOrFail($id);
        $inspection->update($request->only([
            'empresa_id', 'user_id', 'driver_name', 'plate', 'vehicle_number', 'inspection_date', 'supervised_by', 'observations_general'
        ]));

        $inspection->details()->delete();

        foreach ($request->questions as $index => $question) {
            VehicleInspectionDetail::create([
                'vehicle_inspection_id' => $inspection->id,
                'question' => $question,
                'answer' => isset($request->answers[$index]) ? 1 : 0,
                'observations' => $request->observations[$index] ?? null,
            ]);
        }

        return redirect()->route('vehiculos.index')->with('success', 'Formulario actualizado con éxito');
    }

    public function destroy($id)
    {
        $inspection = VehicleInspection::findOrFail($id);
        $inspection->delete();
        return redirect()->route('vehiculos.index')->with('success', 'Formulario eliminado con éxito');
    }
}
