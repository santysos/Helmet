@extends('adminlte::page')

@section('title', 'Inspecciones de Vehículos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Inspecciones de Vehículos</h5>
    <a href="{{ route('vehiculos.create') }}" class="btn btn-sm btn-info">Nueva Inspección</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Listado de Inspecciones de Vehículos</h3>
            <form action="{{ route('vehiculos.index') }}" method="GET" class="form-inline">
            <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Conductor</th>
                    <th>Placa</th>
                    <th>Número del Vehículo</th>
                    <th>Fecha de Inspección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                <tr>
                    <td>{{ $inspection->id }}</td>
                    <td>{{ $inspection->driver_name }}</td>
                    <td>{{ $inspection->plate }}</td>
                    <td>{{ $inspection->vehicle_number }}</td>
                    <td>{{ $inspection->inspection_date }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <a href="{{ route('vehiculos.show', $inspection->id) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('vehiculos.edit', $inspection->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('vehiculos.destroy', $inspection->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar esta inspección?')">
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

    <div class="card-footer clearfix">
        <div class="d-flex pagination pagination-sm m-0 float-right">
            {{ $inspections->links() }}
        </div>
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
