@extends('adminlte::page')

@section('title', 'Editar Extintor')

@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Extintores</h5>
    <a href="{{ route('extintores.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card col-md-6">
    <div class="card-header">
        <h3 class="card-title">Editar Extintor</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('extintores.update', $extintor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="empresa_id">Empresa</label>
                <select class="form-control" id="empresa_id" name="empresa_id" required>
                    @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ $extintor->empresa_id == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="codigo">Código</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $extintor->codigo }}" required>
                </div>
                <div class="col-md-6">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" value="{{ $extintor->area }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="tipo">Tipo de Extintor</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        <option value="C02" {{ $extintor->tipo == 'C02' ? 'selected' : '' }}>C02</option>
                        <option value="Pqs" {{ $extintor->tipo == 'Pqs' ? 'selected' : '' }}>Pqs</option>
                        <option value="Tipo K" {{ $extintor->tipo == 'Tipo K' ? 'selected' : '' }}>Tipo K</option>
                        <option value="Espuma" {{ $extintor->tipo == 'Espuma' ? 'selected' : '' }}>Espuma</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="peso">Peso</label>
                    <select class="form-control" id="peso" name="peso" required>
                        <option value="5lb" {{ $extintor->peso == '5lb' ? 'selected' : '' }}>5lb</option>
                        <option value="10lb" {{ $extintor->peso == '10lb' ? 'selected' : '' }}>10lb</option>
                        <option value="25lb" {{ $extintor->peso == '25lb' ? 'selected' : '' }}>25lb</option>
                        <option value="50lb" {{ $extintor->peso == '50lb' ? 'selected' : '' }}>50lb</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="fecha_mantenimiento">Fecha de Mantenimiento</label>
                <input type="text" class="form-control" id="fecha_mantenimiento" name="fecha_mantenimiento" value="{{ \Carbon\Carbon::parse($extintor->fecha_mantenimiento)->format('d-m-Y H:i') }}">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
                @if($extintor->imagen)
                <img src="{{ asset('storage/' . $extintor->imagen) }}" alt="Imagen del extintor" class="img-fluid mt-2" width="100">
                @endif
            </div>
            <button type="submit" class="btn btn-success float-right">Actualizar Extintor</button>
        </form>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
<script src="{{ asset('/js/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/moment/locale/es.js') }}" type="text/javascript"></script>

<script>
    $(function() {
        $('#fecha_mantenimiento').datetimepicker({
            sideBySide: true,
            locale: 'es',
            format: 'DD-MM-YYYY HH:mm'
        });
    });
</script>

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
