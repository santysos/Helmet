@extends('adminlte::page')

@section('title', 'Detalles de la Inspección')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Inspección Mensual</h5>
    <a href="{{ route('inspecciones.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Detalles de la Inspección
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <tr>
                <th># Inspección</th>
                <td>{{ $inspeccion->id }}</td>
                <th>Empresa</th>
                <td>{{ $inspeccion->empresa->nombre }}</td>
            </tr>
            <tr>
                <th>Fecha de la Inspección</th>
                <td>{{ $inspeccion->fecha_inspeccion }}</td>
                <th>Usuario</th>
                <td>{{ $inspeccion->user->name }}</td>
            </tr>
            <tr>
                <th>Área</th>
                <td>{{ $inspeccion->area }}</td>
                <th>Responsable del Área</th>
                <td>{{ $inspeccion->responsable_area }}</td>
            </tr>
            <tr>
                <th>Responsable de la Inspección</th>
                <td>{{ $inspeccion->responsable_inspeccion }}</td>
                <th>Departamento</th>
                <td>{{ $inspeccion->departamento }}</td>
            </tr>
        </table>
        <hr>

        @php
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
        @endphp

        @foreach ($sections as $sectionName => $detalles)

        <div class="card bg-light border-dark">
            <div class="card-header">
                <h4>{{ $sectionName }}</h5>
            </div>
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pregunta</th>
                            <th>Respuesta</th>
                            <th>Observaciones</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->pregunta }}</td>
                            <td>{{ $detalle->respuesta ? 'Sí' : 'No' }}</td>
                            <td>{{ $detalle->observaciones }}</td>
                            <td>
                                @if ($detalle->photo)
                                <a href="{{ asset('storage/' . $detalle->photo) }}" data-lightbox="photos">
                                    <img src="{{ asset('storage/' . $detalle->photo) }}" alt="Foto" class="img-thumbnail" width="150">
                                </a>
                                @else
                                
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <a href="{{ route('inspecciones.index') }}" class="btn btn-secondary float-right">Volver</a>
</div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>



@if(session('success'))
<script>
    toastr.success("{!! Session::get('success') !!}")
</script>
@endif

@if(session('error'))
<script>
    toastr.error("{!! Session::get('error') !!}")
</script>
@endif


@stop