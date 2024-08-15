@extends('adminlte::page')

@section('title', 'Editar Empresa')

@section('content_header')
<h5>Perfil Empresa</h5>
@stop

@section('content')

<div class="card col-md-6">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Editar Empresa</h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data" id="empresaForm">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $empresa->nombre }}" required>
                </div>
                <div class="col-md-6">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $empresa->direccion }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $empresa->telefono }}" required>
                </div>
                <div class="col-md-6">
                    <label for="emails">Emails</label>
                    <input type="text" name="emails" id="emails" class="form-control" value="{{ implode(', ', json_decode($empresa->emails, true)) }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="actividad">Actividad</label>
                <input type="text" name="actividad" id="actividad" class="form-control" value="{{ $empresa->actividad }}" required>
            </div>
            <div class="form-group">
                <label for="logotipo">Logotipo</label>
                <input type="file" name="logotipo" id="logotipo" class="form-control">
                @if($empresa->logotipo)
                <img src="{{ asset('storage/' . $empresa->logotipo) }}" alt="Logotipo de {{ $empresa->nombre }}" class="img-fluid mt-2" width="100">
                @endif
            </div>
            <button type="submit" class="btn btn-success float-right">Actualizar</button>
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

<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
