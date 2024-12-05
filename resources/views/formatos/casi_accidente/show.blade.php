@extends('adminlte::page')

@section('title', 'Casi Accidentes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Casi Accidentes
        <a href="{{ route('casi_accidente.pdf', $nearAccidentReport->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
        <a href="{{ route('casi_accidente.enviar_correo', $nearAccidentReport->id) }}" class="btn btn-sm btn-warning float-right ml-2"><i class="fas fa-envelope"></i> Enviar Reporte por Correo</a>

    </h5>
    <a href="{{ route('casi_accidente.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Detalles del Reporte</span>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-4">
                <label for="empresa_id">Empresa</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->empresa->nombre }}</p>
            </div>
            <div class="col-md-4">
                <label for="condition_type">Tipo de condición</label>
                <div>
                    @php
                    $conditionTypes = json_decode($nearAccidentReport->condition_type);
                    @endphp
                    @foreach($conditionTypes as $condition)
                    <p class="form-control-plaintext">{{ $condition }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label for="severity_level">Nivel de gravedad del casi accidente</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->severity_level }}</p>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="reporter_name">Nombres y Apellidos (Reportante)</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->reporter_name }}</p>
            </div>
            <div class="col-md-4">
                <label for="reporter_position">Cargo (Reportante)</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->reporter_position }}</p>
            </div>
            <div class="col-md-4">
                <label for="reporter_area">Área (Reportante)</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->reporter_area }}</p>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="victim_name">Nombres y Apellidos (Persona afectada)</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->victim_name }}</p>
            </div>
            <div class="col-md-4">
                <label for="victim_position">Cargo (Persona afectada)</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->victim_position }}</p>
            </div>
            <div class="col-md-4">
                <label for="victim_work_location">Lugar de trabajo (Persona afectada)</label>
                <p class="form-control-plaintext">{{ $nearAccidentReport->victim_work_location }}</p>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="description">Descripción del casi accidente</label>
            <p class="form-control-plaintext">{{ $nearAccidentReport->description }}</p>
        </div>

        <div class="form-group">
            <label for="photos">Fotografías adjuntas</label>
            <div>
                @if ($nearAccidentReport->photos)
                @foreach (json_decode($nearAccidentReport->photos) as $photo)
                <a href="{{ asset('storage/' . $photo) }}" data-lightbox="photos">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Foto" class="img-thumbnail mt-2 img-square" width="100">
                </a>
                @endforeach
                @endif
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-md-6">

                <label for="follow_up_name">Seguimiento (Nombres)</label>
                <div>
                    @foreach(json_decode($nearAccidentReport->follow_up_name) as $userId)
                    <p class="form-control-plaintext">{{ App\Models\User::find($userId)->name }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <label for="follow_up_email">Correos de Seguimiento</label>
                <div>
                    @foreach(json_decode($nearAccidentReport->follow_up_email) as $email)
                    <p class="form-control-plaintext">{{ $email }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-group">

        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@stop