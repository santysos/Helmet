@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="container">
    <h1>Detalles de la Inspección de Vehículo</h1>

    <a href="{{ route('vehiculos.index') }}" class="btn btn-primary mb-3">Volver al Listado</a>

    <a href="{{ route('vehicle-inspections.pdf', $inspection->id) }}" class="btn btn-secondary mb-3">Descargar PDF</a>


    <table class="table table-bordered">
        <tr>
            <th>Conductor</th>
            <td>{{ $inspection->driver_name }}</td>
        </tr>
        <tr>
            <th>Placa</th>
            <td>{{ $inspection->plate }}</td>
        </tr>
        <tr>
            <th>Número del Vehículo</th>
            <td>{{ $inspection->vehicle_number }}</td>
        </tr>
        <tr>
            <th>Fecha de Inspección</th>
            <td>{{ $inspection->inspection_date }}</td>
        </tr>
        <tr>
            <th>Supervisado Por</th>
            <td>{{ $inspection->supervised_by }}</td>
        </tr>
        <tr>
            <th>Observaciones Generales</th>
            <td>{{ $inspection->observations_general }}</td>
        </tr>
    </table>

    <h3>Detalles de la Inspección</h3>

    <div class="row">
        @foreach ($inspection->details as $detail)
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $detail->question }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-{{ $detail->answer ? 'success' : 'danger' }}">{{ $detail->answer ? 'Sí' : 'No' }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <label>Observaciones:</label>
                        <p>{{ $detail->observations }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop