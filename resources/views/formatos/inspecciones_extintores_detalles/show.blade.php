@extends('adminlte::page')

@section('title', 'Detalle de Inspección de Extintores')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Detalle de Inspección de Extintores</h5>
    <a href="{{ route('inspecciones_extintores.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Detalle de Inspección de Extintores
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $inspeccion->id }}</td>
                </tr>
                <tr>
                    <th>Empresa</th>
                    <td>{{ $inspeccion->empresa->nombre }}</td>
                </tr>
                <tr>
                    <th>Área</th>
                    <td>{{ $inspeccion->area }}</td>
                </tr>
                <tr>
                    <th>Fecha de la Inspección</th>
                    <td>{{ $inspeccion->fecha_inspeccion }}</td>
                </tr>
                <tr>
                    <th>Responsable de la Inspección</th>
                    <td>{{ $inspeccion->responsable_inspeccion }}</td>
                </tr>
                <tr>
                    <th>Departamento</th>
                    <td>{{ $inspeccion->departamento }}</td>
                </tr>
                <tr>
                    <th>Comentarios y Notas Adicionales</th>
                    <td>{{ $inspeccion->comentarios_notas_adicionales }}</td>
                </tr>
                <tr>
                    <th>Riegos Significativos y Recomendaciones Técnicas en el Área</th>
                    <td>{{ $inspeccion->riesgos_significativos_recomendaciones }}</td>
                </tr>
                <tr>
                    <th>Extintores</th>
                    <td>
                        <ul>
                            @foreach($inspeccion->extintores as $extintor)
                            <li>{{ $extintor->codigo }} - {{ $extintor->tipo }} - {{ $extintor->peso }} - {{ $extintor->area }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
