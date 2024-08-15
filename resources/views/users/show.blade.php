@extends('adminlte::page')

@section('title', 'Detalles del Usuario')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Detalles del Usuario</h5>
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            Usuario
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{ $user->name }}</b></h2>
                    <p class="text-muted text-sm"><b>Email: </b> {{ $user->email }} </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-id-badge"></i></span> ID: {{ $user->id }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar"></i></span> Creado el: {{ $user->created_at->format('d-m-Y H:i') }}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar"></i></span> Actualizado en: {{ $user->updated_at->format('d-m-Y H:i') }}</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Editar">
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
