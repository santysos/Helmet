@extends('adminlte::page')

@section('title', 'Ver Extintor')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Detalles del Extintor</h5>
    <a href="{{ route('extintores.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            Extintor
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{ $extintor->codigo }}</b></h2>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-fire-extinguisher"></i></span> Tipo: {{ $extintor->tipo }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-weight"></i></span> Peso: {{ $extintor->peso }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span> Área: {{ $extintor->area }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Empresa: {{ $extintor->empresa->nombre }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span> Usuario: {{ $extintor->user->name }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span> Fecha de Mantenimiento: {{ $extintor->fecha_mantenimiento ? $extintor->fecha_mantenimiento : 'No asignada' }}</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    @if($extintor->imagen)
                    <img src="{{ asset('storage/' . $extintor->imagen) }}" alt="Imagen de {{ $extintor->codigo }}" class="img-circle img-fluid">
                    @else
                    <img src="{{ asset('path/to/default-image.jpg') }}" alt="Imagen por defecto" class="img-circle img-fluid">
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="{{ route('extintores.edit', $extintor->id) }}" class="btn btn-sm btn-warning" title="Editar">
                    <i class="fas fa-edit"></i> Editar
                </a>
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
