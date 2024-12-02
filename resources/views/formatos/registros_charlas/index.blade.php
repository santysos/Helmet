@extends('adminlte::page')

@section('title', 'Registros de Charlas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Charlas de Seguridad</h5>
    <a href="{{ route('registros_charlas.create') }}" class="btn btn-sm btn-primary">Nuevo Registro</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Listado de Inspecciones</h3>
            <form action="{{ route('registros_charlas.index') }}" method="GET" class="form-inline">
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
                    <th>#</th>
                    <th>Empresa</th>
                    <th>Responsable de la Charla</th>
                    <th>Fecha de la Charla</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrosCharlas as $registroCharla)
                <tr>
                    <td>{{ $registroCharla->id }}</td>
                    <td>{{ $registroCharla->empresa->nombre }}</td>
                    <td>{{ $registroCharla->responsable_charla }}</td>
                    <td>{{ $registroCharla->fecha_charla }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">

                            <a href="{{ route('registros_charlas.pdf', $registroCharla->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>

                            <a href="{{ route('registros_charlas.show', $registroCharla->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('registros_charlas.edit', $registroCharla->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('registros_charlas.destroy', $registroCharla->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
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
    toastr.success("{!!  Session::get('success')!!}")
</script>

@endif
@if(session('error'))
<script>
    toastr.error("{!!Session::get('error')!!}")
</script>

@endif

@stop