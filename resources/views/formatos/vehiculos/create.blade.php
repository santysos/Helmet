@extends('adminlte::page')

@section('title', 'Nueva Revisión de Vehículos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Formulario de Revisión de Vehículos</h5>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Nueva Revisión de Vehículos
    </div>
    <div class="card-body">
        <form action="{{ route('vehiculos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="empresa_id">Empresa</label>
                    <select class="form-control" id="empresa_id" name="empresa_id" required>
                        <option value="" disabled selected>Seleccione una empresa</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="user_id">Usuario</label>
                    <select name="user_id" class="form-control" required>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="inspection_date">Fecha de Inspección</label>
                    <input type="date" class="form-control" id="inspection_date" name="inspection_date" value="{{ old('inspection_date') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="driver_name">Nombre del Conductor</label>
                    <input type="text" class="form-control" id="driver_name" name="driver_name" value="{{ old('driver_name') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="plate">Placa</label>
                    <input type="text" class="form-control" id="plate" name="plate" value="{{ old('plate') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="vehicle_number">Número del Vehículo</label>
                    <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}" required>
                </div>
             
                <div class="col-md-3">
                    <label for="supervised_by">Supervisado Por</label>
                    <input type="text" class="form-control" id="supervised_by" name="supervised_by" value="{{ old('supervised_by') }}" required>
                </div>
            </div>

            @foreach ($questions as $index => $question)
            <div class="col-md-12">
                <div class="card card-outline card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $question }}</h3>
                        <div class="card-tools">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $index }}" name="answers[{{ $index }}]" value="yes" {{ old("answers.{$index}") == 'yes' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customSwitch{{ $index }}"></label>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="questions[{{ $index }}]" value="{{ $question }}">
                        <label>Observaciones:</label>
                        <textarea name="observations[{{ $index }}]" class="form-control">{{ old("observations.{$index}") }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <label for="observations_general">Observaciones Generales a Mejorar</label>
                <textarea name="observations_general" class="form-control">{{ old('observations_general') }}</textarea>
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

<script>
    // JavaScript para cargar dinámicamente los datos adicionales si es necesario
</script>
@stop