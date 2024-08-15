@extends('adminlte::page')

@section('title', 'Detalle de la Inspección de Extintores')

@section('content_header')
<h5>Inspección de Extintores</h5>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Información de la Inspección</h3>
        <a href="{{ route('inspecciones_extintores.pdf', $inspeccion->id) }}" target="_blank" class="btn btn-danger float-right ml-2">Generar PDF</a>
        <a href="{{ route('inspecciones_extintores.sendEmail', $inspeccion->id) }}" class="btn btn-primary float-right">Enviar Email</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Empresa:</strong> {{ $inspeccion->empresa->nombre }}
            </div>
            <div class="col-md-6">
                <strong>Área:</strong> {{ $inspeccion->area }}
            </div>
            <div class="col-md-6">
                <strong>Fecha de Inspección:</strong> {{ $inspeccion->fecha_inspeccion }}
            </div>
            <div class="col-md-6">
                <strong>Responsable de la Inspección:</strong> {{ $inspeccion->responsable_inspeccion }}
            </div>
            <div class="col-md-6">
                <strong>Departamento:</strong> {{ $inspeccion->departamento }}
            </div>
            <div class="col-md-12">
                <strong>Comentarios:</strong> {{ $inspeccion->comentarios ?? 'N/A' }}
            </div>
            <div class="col-md-12">
                <strong>Riesgos y Recomendaciones:</strong> {{ $inspeccion->riesgos_recomendaciones ?? 'N/A' }}
            </div>
        </div>
        <a href="{{ route('inspecciones_extintores_detalles.create', ['inspeccionId' => $inspeccion->id]) }}" class="btn btn-primary">Agregar Inspección de Extintor</a>
    </div>
</div>

@if($inspeccion->detalles->isNotEmpty())
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Detalles de los Extintores Inspeccionados</h3>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="extinguisherTabs" role="tablist">
            @foreach ($inspeccion->detalles->groupBy('extintor_id') as $extintorId => $detalles)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="extinguisher-tab-{{ $extintorId }}" data-toggle="tab" href="#extinguisher{{ $extintorId }}" role="tab" aria-controls="extinguisher{{ $extintorId }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $detalles->first()->extintor->codigo }} - {{ $detalles->first()->extintor->area }}
                </a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="extinguisherTabsContent">
            @foreach ($inspeccion->detalles->groupBy('extintor_id') as $extintorId => $detalles)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="extinguisher{{ $extintorId }}" role="tabpanel" aria-labelledby="extinguisher-tab-{{ $extintorId }}">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pregunta</th>
                            <th>Respuesta</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->pregunta }}</td>
                            <td>{{ $detalle->respuesta == 'si' ? 'Sí' : 'No' }}</td>
                            <td>{{ $detalle->observaciones }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Mostrar imágenes asociadas a la inspección del extintor -->
                <h3>Imágenes del Extintor: {{ $detalles->first()->extintor->codigo }}</h3>
                @php
                    $extintorImagenes = $imagenes->where('extintor_id', $extintorId);
                @endphp
                @if($extintorImagenes->isNotEmpty())
                <div class="row">
                    @foreach($extintorImagenes as $imagen)
                    <div class="col-md-3 mb-2">
                        <a href="{{ asset('storage/' . $imagen->ruta_imagen) }}" data-lightbox="imagenes-{{ $extintorId }}" data-title="Imagen de la inspección">
                            <img src="{{ asset('storage/' . $imagen->ruta_imagen) }}" class="img-fluid img-thumbnail" alt="Imagen de la inspección">
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <p>No hay imágenes disponibles para este extintor.</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    // Initialize the tabs
    $('#extinguisherTabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    @if(session('success'))
    toastr.success("{!! Session::get('success') !!}");
    @endif

    @if(session('error'))
    toastr.error("{!! Session::get('error') !!}");
    @endif
</script>
@stop
