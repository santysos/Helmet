<?php

namespace App\Http\Controllers;

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

    public function index()
    {

        $casi_accidentes = NearAccidentReport::get();



        // Obtener el año actual y el año anterior
        $currentYear = now()->year;

        $vehiculos_inspeccionados = VehicleInspection::whereYear('inspection_date', $currentYear)->count();

        // Obtener el número de vehículos inspeccionados por cada mes durante el año en curso
        $vehiculos_inspeccionados_por_mes = VehicleInspection::selectRaw('MONTH(inspection_date) as month, COUNT(*) as total')
            ->whereYear('inspection_date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Obtener el número de casi accidentes por cada mes durante el año en curso
        $casi_accidentes_por_mes = NearAccidentReport::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $extintores_inspeccionados = InspeccionExtintoresDetalle::whereYear('created_at', $currentYear)->count();

        $inspecciones_mensuales = Inspeccion::whereYear('fecha_inspeccion', $currentYear)->get();
        $inspecciones_realizadas = $inspecciones_mensuales->count();

        $inspecciones_extintores = InspeccionExtintores::whereYear('fecha_inspeccion', $currentYear)->get();

        $previousYear = $currentYear - 1;

        $inspecciones_mensuales_anterior = Inspeccion::whereYear('fecha_inspeccion', $previousYear)->get();
        $inspecciones_mensuales_anio_anterior = $inspecciones_mensuales_anterior->count();


        // Obtener el número de inspecciones mensuales para el año en curso
        $inspecciones_current_year = Inspeccion::selectRaw('MONTH(fecha_inspeccion) as month, COUNT(*) as total')
            ->whereYear('fecha_inspeccion', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Obtener el número de inspecciones mensuales para el año anterior
        $inspecciones_previous_year = Inspeccion::selectRaw('MONTH(fecha_inspeccion) as month, COUNT(*) as total')
            ->whereYear('fecha_inspeccion', $previousYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

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
        ));
    }
}
