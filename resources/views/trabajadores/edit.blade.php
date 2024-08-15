@extends('adminlte::page')

@section('title', 'Editar Trabajador')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Editar Trabajador</h5>
    <a href="{{ route('trabajadores.index') }}" class="btn btn-sm btn-info">Volver a la lista</a>
</div>
@stop

@section('content')
<div class="card col-md-6">
    <div class="card-body">
        <form action="{{ route('trabajadores.update', $trabajador->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="empresa_id">Empresa</label>
                    <select name="empresa_id" id="empresa_id" class="form-control">
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ $empresa->id == $trabajador->empresa_id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="cedula">Cédula</label>
                    <input type="text" name="cedula" id="cedula" class="form-control" value="{{ old('cedula', $trabajador->cedula) }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $trabajador->nombre) }}">
                </div>
                <div class="col-md-6">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido', $trabajador->apellido) }}">
                </div>
            </div>
            <div class="form-group">
                <label for="area_trabajo">Área de Trabajo</label>
                <input type="text" name="area_trabajo" id="area_trabajo" class="form-control" value="{{ old('area_trabajo', $trabajador->area_trabajo) }}">
            </div>
            <div class="form-group">
                <label for="firma">Firma (opcional)</label>
                <input type="file" name="firma" id="firma" class="form-control-file">
                @if($trabajador->firma)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $trabajador->firma) }}" alt="Firma de {{ $trabajador->nombre }}" class="img-thumbnail" width="100">
                </div>
                @endif
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
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
