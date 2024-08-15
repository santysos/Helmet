@extends('adminlte::page')

@section('title', 'Ver Trabajador')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Detalles del Trabajador</h5>
    <a href="{{ route('trabajadores.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            Trabajador
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{ $trabajador->nombre }} {{ $trabajador->apellido }}</b></h2>
                    <p class="text-muted text-sm"><b>Empresa: </b> {{ $trabajador->empresa->nombre }} </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-card"></i></span> Cédula: {{ $trabajador->cedula }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-briefcase"></i></span> Área de Trabajo: {{ $trabajador->area_trabajo }}</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    @if($trabajador->firma)
                    <img src="{{ asset('storage/' . $trabajador->firma) }}" alt="Firma de {{ $trabajador->nombre }}" class="img-circle img-fluid">
                    @else
                    <img src="{{ asset('path/to/default-image.jpg') }}" alt="Firma por defecto" class="img-circle img-fluid">
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="{{ route('trabajadores.edit', $trabajador->id) }}" class="btn btn-sm btn-warning" title="Editar">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="{{ route('trabajadores.destroy', $trabajador->id) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este trabajador?')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
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

<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
