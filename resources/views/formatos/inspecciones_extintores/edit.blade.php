@extends('adminlte::page')

@section('title', 'Editar Inspección de Extintores')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Editar Inspección de Extintores</h5>
    <a href="{{ route('inspecciones_extintores.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Editar Inspección de Extintores
    </div>
    <div class="card-body">
        <form action="{{ route('inspecciones_extintores.update', $inspeccion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="empresa_id">Empresa</label>
                    <select class="form-control" id="empresa_id" name="empresa_id" required>
                        <option value="" disabled>Seleccione una empresa</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ $inspeccion->empresa_id == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" value="{{ old('area', $inspeccion->area) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_inspeccion">Fecha de la Inspección</label>
                    <input type="date" class="form-control" id="fecha_inspeccion" name="fecha_inspeccion" value="{{ old('fecha_inspeccion', $inspeccion->fecha_inspeccion) }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="responsable_inspeccion">Responsable de la Inspección</label>
                    <input type="text" class="form-control" id="responsable_inspeccion" name="responsable_inspeccion" value="{{ old('responsable_inspeccion', $inspeccion->responsable_inspeccion) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" value="{{ old('departamento', $inspeccion->departamento) }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="comentarios">Comentarios y Notas Adicionales</label>
                <textarea class="form-control" id="comentarios" name="comentarios">{{ old('comentarios', $inspeccion->comentarios) }}</textarea>
            </div>
            <div class="form-group">
                <label for="riesgos_recomendaciones">Riegos Significativos y Recomendaciones Técnicas en el Área</label>
                <textarea class="form-control" id="riesgos_recomendaciones" name="riesgos_recomendaciones">{{ old('riesgos_recomendaciones', $inspeccion->riesgos_recomendaciones) }}</textarea>
            </div>
            <div class="form-group">
                <label for="extintores">Extintores</label>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Extintor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($extintores as $extintor)
                        <tr>
                            <td>
                                {{ $extintor->codigo }} - {{ $extintor->tipo }} - {{ $extintor->peso }} - {{ $extintor->area }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <button type="submit" class="btn btn-success float-right">Guardar</button>
        </form>
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