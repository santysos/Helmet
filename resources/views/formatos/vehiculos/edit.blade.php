@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="container">
    <h1>Editar Inspección de Vehículo</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('vehiculos.update', $inspection->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="empresa_id">Empresa</label>
            <select name="empresa_id" class="form-control" required>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ $empresa->id == $inspection->empresa_id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">Usuario</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $inspection->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="driver_name">Nombre del Conductor</label>
            <input type="text" name="driver_name" class="form-control" value="{{ $inspection->driver_name }}" required>
        </div>

        <div class="form-group">
            <label for="plate">Placa</label>
            <input type="text" name="plate" class="form-control" value="{{ $inspection->plate }}" required>
        </div>

        <div class="form-group">
            <label for="vehicle_number">Número del Vehículo</label>
            <input type="text" name="vehicle_number" class="form-control" value="{{ $inspection->vehicle_number }}" required>
        </div>

        <div class="form-group">
            <label for="inspection_date">Fecha de Inspección</label>
            <input type="date" name="inspection_date" class="form-control" value="{{ $inspection->inspection_date }}" required>
        </div>

        <div class="form-group">
            <label for="supervised_by">Supervisado Por</label>
            <input type="text" name="supervised_by" class="form-control" value="{{ $inspection->supervised_by }}" required>
        </div>

        <h3>Preguntas</h3>

        <div class="row">
            @foreach ($inspection->details as $index => $detail)
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $detail->question }}</h3>
                            <div class="card-tools">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch{{ $index }}" name="answers[{{ $index }}]" value="yes" {{ $detail->answer ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customSwitch{{ $index }}"></label>
                                </div>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="questions[]" value="{{ $detail->question }}">
                            <label>Observaciones:</label>
                            <textarea name="observations[{{ $index }}]" class="form-control">{{ $detail->observations }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="observations_general">Observaciones Generales a Mejorar</label>
            <textarea name="observations_general" class="form-control">{{ $inspection->observations_general }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop