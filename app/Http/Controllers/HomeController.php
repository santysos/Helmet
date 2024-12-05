<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Inspeccion;
use App\Models\InspeccionExtintores;
use App\Models\InspeccionExtintoresDetalle;
use App\Models\NearAccidentReport;
use App\Models\VehicleInspection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $empresas = Empresa::all();

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Obtener el año actual y el año anterior
        $currentYear = now()->year;
        $previousYear = $currentYear - 1;

        // Obtener la empresa seleccionada desde la solicitud
        $empresaIdSeleccionada = $request->get('empresa_id'); // Si no se selecciona ninguna, será null

        // Inicializar variables
        $vehiculos_inspeccionados = 0;
        $vehiculos_inspeccionados_por_mes = collect();
        $casi_accidentes = collect();
        $casi_accidentes_por_mes = collect();
        $extintores_inspeccionados = 0;
        $inspecciones_mensuales = collect();
        $inspecciones_realizadas = 0;
        $inspecciones_extintores = collect();
        $inspecciones_mensuales_anio_anterior = 0;
        $inspecciones_current_year = collect();
        $inspecciones_previous_year = collect();

        // Si el usuario es SuperAdmin o Admin Helmet
        if ($user->hasRole('SuperAdmin') || $user->hasRole('Admin Helmet')) {
            $queryCondition = $empresaIdSeleccionada ? ['empresa_id' => $empresaIdSeleccionada] : [];

            $vehiculos_inspeccionados = VehicleInspection::where($queryCondition)
                ->whereYear('inspection_date', $currentYear)
                ->count();

            $vehiculos_inspeccionados_por_mes = VehicleInspection::selectRaw('MONTH(inspection_date) as month, COUNT(*) as total')
                ->where($queryCondition)
                ->whereYear('inspection_date', $currentYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $casi_accidentes = NearAccidentReport::where($queryCondition)->get();

            $casi_accidentes_por_mes = NearAccidentReport::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where($queryCondition)
                ->whereYear('created_at', $currentYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $extintores_inspeccionados = InspeccionExtintoresDetalle::whereHas('inspeccionExtintor', function ($query) use ($queryCondition) {
                $query->where($queryCondition);
            })->whereYear('created_at', $currentYear)->count();

            $inspecciones_mensuales = Inspeccion::where($queryCondition)
                ->whereYear('fecha_inspeccion', $currentYear)
                ->get();

            $inspecciones_realizadas = $inspecciones_mensuales->count();

            $inspecciones_extintores = InspeccionExtintores::where($queryCondition)
                ->whereYear('fecha_inspeccion', $currentYear)
                ->get();

            $inspecciones_mensuales_anterior = Inspeccion::where($queryCondition)
                ->whereYear('fecha_inspeccion', $previousYear)
                ->get();

            $inspecciones_mensuales_anio_anterior = $inspecciones_mensuales_anterior->count();

            $inspecciones_current_year = Inspeccion::selectRaw('MONTH(fecha_inspeccion) as month, COUNT(*) as total')
                ->where($queryCondition)
                ->whereYear('fecha_inspeccion', $currentYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $inspecciones_previous_year = Inspeccion::selectRaw('MONTH(fecha_inspeccion) as month, COUNT(*) as total')
                ->where($queryCondition)
                ->whereYear('fecha_inspeccion', $previousYear)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else if ($user->hasRole('Admin Empresa')) {
            $empresaId = $user->empresa_id;

            $vehiculos_inspeccionados = VehicleInspection::where('empresa_id', $empresaId)
                ->whereYear('inspection_date', $currentYear)
                ->count();

            // Resto de la lógica para Admin Empresa
            // (El código que ya tienes para este caso es suficiente).
        }

        // Renderizar la vista con los datos filtrados
        return view('home', compact(
            'vehiculos_inspeccionados',
            'vehiculos_inspeccionados_por_mes',
            'extintores_inspeccionados',
            'inspecciones_current_year',
            'inspecciones_previous_year',
            'inspecciones_realizadas',
            'inspecciones_mensuales_anio_anterior',
            'inspecciones_mensuales',
            'casi_accidentes',
            'inspecciones_extintores',
            'casi_accidentes_por_mes',
            'empresas',
            'empresaIdSeleccionada'
        ));
    }
}
