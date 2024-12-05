@extends('adminlte::page')

@section('title', 'Detalles de la Charla')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Detalles de la Charla</h5>
    <a href="{{ route('registros_charlas.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>

</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Detalles de la Charla
        <a href="{{ route('registros_charlas.pdf', $registroCharla->id) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i></a>
        <a href="{{ route('charlas.sendEmail', $registroCharla->id) }}" class="btn btn-sm btn-warning float-right ml-2"><i class="fas fa-envelope"></i></a>

    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th># Charla</th>
                <td>{{ $registroCharla->id }}</td>
                <th>Empresa</th>
                <td>{{ $registroCharla->empresa->nombre }}</td>
            </tr>
            <tr>
                <th>Fecha de la Charla</th>
                <td>{{ $registroCharla->fecha_charla }}</td>
                <th>Usuario</th>
                <td>{{ $registroCharla->user->name }}</td>
            </tr>
            <tr>
                <th>Área</th>
                <td>{{ $registroCharla->area }}</td>
                <th>Responsable del Área</th>
                <td>{{ $registroCharla->responsable_area }}</td>
            </tr>
            <tr>
                <th>Responsable de la Charla</th>
                <td>{{ $registroCharla->responsable_charla }}</td>
                <th>Departamento</th>
                <td>{{ $registroCharla->departamento }}</td>
            </tr>
            <tr>
                <th>Tema Brindado</th>
                <td>
                    @foreach(json_decode($registroCharla->tema_brindado, true) as $temaId)
                    @if(isset($temas[$temaId]))
                    <span class="badge badge-info">{{ $temas[$temaId] }}</span>
                    @endif
                    @endforeach
                </td>
                <th>Temas Discutidos o Notas</th>
                <td>{{ $registroCharla->temas_discutidos_notas }}</td>
            </tr>
            <tr>
                <th>Fotos</th>
                <td>
                    @if ($registroCharla->fotos)
                    @foreach(json_decode($registroCharla->fotos) as $foto)
                    <a href="{{ asset('storage/' . $foto) }}" data-lightbox="photos">
                        <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="img-thumbnail" width="150">
                    </a>
                    @endforeach
                    @else
                    No hay fotos
                    @endif
                </td>
            </tr>
        </table>

        <h5>Participantes</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Firma</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registroCharla->trabajadores as $trabajador)
                <tr>
                    <td>{{ $trabajador->nombre }}</td>
                    <td>{{ $trabajador->apellido }}</td>
                    <td>{{ $trabajador->firma ? 'Sí' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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