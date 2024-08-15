@extends('adminlte::page')

@section('title', 'Panel de Control')

@section('content_header')
<h5>Panel de Control</h5>
@stop

@section('content')

<span class="info-box-number">

</span>

<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Inspecciones Mensuales {{ now()->year }}</span>
                <span class="info-box-number">
                    {{ $inspecciones_mensuales->count() }}
                    <small>realizadas</small>
                </span>
            </div>

        </div>

    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-injured"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Accidentes e Incidentes</span>
                <span class="info-box-number"> {{ $casi_accidentes->count() }}
                    <small>días</small>
                </span>
            </div>

        </div>

    </div>


    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-fire-extinguisher"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Checklist Extintores</span>
                <span class="info-box-number">{{ $inspecciones_extintores->count() }}</span>
            </div>

        </div>

    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Charlas de Seguridad</span>
                <span class="info-box-number">2
                    <small>2024</small>

                </span>
            </div>

        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Inspecciones Mensuales</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-wrench"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a href="#" class="dropdown-item">Action</a>
                            <a href="#" class="dropdown-item">Another action</a>
                            <a href="#" class="dropdown-item">Something else here</a>
                            <a class="dropdown-divider"></a>
                            <a href="#" class="dropdown-item">Separated link</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>Inspecciones Mensuales: {{ now()->year }} vs {{ now()->year - 1 }}</strong>
                        </p>
                        <div class="chart">
                            <canvas id="inspeccionesChart" height="180" style="height: 180px; display: block; width: 100%;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Metas Completadas</strong>
                        </p>
                        <div class="progress-group">
                            Inspecciones Mensuales {{ now()->year }}
                            <span class="float-right"><b>{{ $inspecciones_realizadas }}</b>/12</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{ ($inspecciones_realizadas / 12) * 100 }}%"></div>
                            </div>
                        </div>


                        <div class="progress-group">
                            Inspecciones Mensuales {{ now()->year - 1 }}
                            <span class="float-right"><b>{{ $inspecciones_mensuales_anio_anterior }}</b>/12</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" style="width: {{ ($inspecciones_mensuales_anio_anterior / 12) * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            <span class="progress-text">Extintores Inspeccionados {{ now()->year }} </span>
                            <span class="float-right"><b>{{ $extintores_inspeccionados /17 }}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            Vehículos Inspeccionados {{ now()->year }}
                            <span class="float-right"><b>{{$vehiculos_inspeccionados}}</b></span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: 100%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                            <h5 class="description-header">$35,210.43</h5>
                            <span class="description-text">TOTAL REVENUE</span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                            <h5 class="description-header">$10,390.90</h5>
                            <span class="description-text">TOTAL COST</span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                            <h5 class="description-header">$24,813.53</h5>
                            <span class="description-text">TOTAL PROFIT</span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                            <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                            <h5 class="description-header">1200</h5>
                            <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-4">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Vehículos Inspeccionados por Mes - {{ now()->year }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="card card-widget widget-user">

            <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">Santiago Leiton</h3>
                <h5 class="widget-user-desc">CEO</h5>
            </div>
            <div class="widget-user-image">
            <img class="img-circle elevation-2" src="{{ asset('images/santiago-leiton.webp') }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 border-right">
                        <div class="description-block">
                            <h5 class="description-header">+1 (773) 642-5894</h5>
                            <span class="description-text">Whatsapp</span>
                        </div>

                    </div>

                    <div class="col-sm-12 border-right">
                        <div class="description-block">
                        <h5 class="description-header">
    <a href="mailto:info@ergomas.ec">info@ergomas.ec</a>
</h5>
                            <span class="description-text">Email</span>
                        </div>

                    </div>

                   

                </div>

            </div>
        </div>

    </div>
    <div class="col-4">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Casi Accidentes por Mes - {{ now()->year }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
</div>



@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('areaChart').getContext('2d');

        var casiAccidentesData = @json(array_fill(0, 12, 0));

        @foreach ($casi_accidentes_por_mes as $accidente)
            casiAccidentesData[{{ $accidente->month - 1 }}] = {{ $accidente->total }};
        @endforeach

        var areaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Casi Accidentes',
                    data: casiAccidentesData,
                    borderColor: 'rgba(255, 99, 132, 0.8)', // Rojo oscuro para el borde
                    backgroundColor: 'rgba(255, 99, 132, 0.3)', 
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('lineChart').getContext('2d');

        var vehiculosData = @json(array_fill(0, 12, 0));

        @foreach ($vehiculos_inspeccionados_por_mes as $inspeccion)
            vehiculosData[{{ $inspeccion->month - 1 }}] = {{ $inspeccion->total }};
        @endforeach

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Vehículos Inspeccionados',
                    data: vehiculosData,
                    borderColor: 'rgba(60,141,188,0.8)',
                    backgroundColor: 'rgba(60,141,188,0.3)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<script>
    var ctx = document.getElementById('inspeccionesChart').getContext('2d');
    var inspeccionesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [
                {
                    label: 'Año {{ now()->year }}',
                    data: [
                        @foreach(range(1, 12) as $month)
                            {{ $inspecciones_current_year->firstWhere('month', $month)->total ?? 0 }},
                        @endforeach
                    ],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                },
                {
                    label: 'Año {{ now()->year - 1 }}',
                    data: [
                        @foreach(range(1, 12) as $month)
                            {{ $inspecciones_previous_year->firstWhere('month', $month)->total ?? 0 }},
                        @endforeach
                    ],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>





@stop