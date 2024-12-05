@extends('adminlte::page')

@section('title', 'Detalles de la Inspección de Vehículo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Detalles de la Inspección de Vehículo 
        <a href="{{ route('vehicle-inspections.pdf', $inspection->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
        <a href="{{ route('inspeccion_vehicular.sendEmail', $inspection->id) }}" class="btn btn-sm btn-warning float-right ml-2"> <i class="fas fa-envelope"></i></a>

    </h5>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-sm btn-primary">Volver al Listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Detalles de la Inspección
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <tr>
                <th>Conductor</th>
                <td>{{ $inspection->driver_name }}</td>
                <th>Placa</th>
                <td>{{ $inspection->plate }}</td>
            </tr>
            <tr>
                <th>Número del Vehículo</th>
                <td>{{ $inspection->vehicle_number }}</td>
                <th>Fecha de Inspección</th>
                <td>{{ $inspection->inspection_date }}</td>
            </tr>
            <tr>
                <th>Supervisado Por</th>
                <td>{{ $inspection->supervised_by }}</td>
                <th>Observaciones Generales</th>
                <td>{{ $inspection->observations_general }}</td>
            </tr>
        </table>
        <hr>

        <h5>Detalles de la Inspección</h5>

        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inspection->details as $detail)
                    <tr>
                        <td>{{ $detail->question }}</td>
                        <td>
                            <span class="badge badge-{{ $detail->answer ? 'success' : 'danger' }}">
                                {{ $detail->answer ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td>{{ $detail->observations }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>

        <h5>Imágenes de la Inspección</h5>
        <div class="row">
            @foreach ($inspection->images as $image)
            <div class="col-md-3 mb-2">
                <a href="{{ asset('storage/' . $image->image_path) }}" data-lightbox="inspection-images" data-title="Inspección de Vehículo">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid" alt="Inspección de Vehículo" style="max-height: 150px;">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

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