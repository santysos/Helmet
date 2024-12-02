@extends('adminlte::page')

@section('title', 'Listado de Inspecciones de Extintores')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Listado de Inspecciones de Extintores</h5>
    <a href="{{ route('inspecciones_extintores.create') }}" class="btn btn-sm btn-primary">Nueva Inspección</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
    <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Listado de Inspecciones de Extintores</h3>
            <form action="{{ route('inspecciones_extintores.index') }}" method="GET" class="form-inline">
            <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                    </span>
                </div>
            </form>
        </div>    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>Responsable</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inspecciones as $inspeccion)
                <tr>
                    <td>{{ $inspeccion->id }}</td>
                    <td>{{ $inspeccion->empresa->nombre }}</td>
                    <td>{{ $inspeccion->area }}</td>
                    <td>{{ $inspeccion->fecha_inspeccion }}</td>
                    <td>{{ $inspeccion->responsable_inspeccion }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">
                        <a href="{{ route('inspecciones_extintores.pdf', $inspeccion->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>

                            <a href="{{ route('inspecciones_extintores.show', $inspeccion->id) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('inspecciones_extintores.edit', $inspeccion->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('inspecciones_extintores.destroy', $inspeccion->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta inspección?');">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
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