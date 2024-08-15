@extends('adminlte::page')

@section('title', 'Documentos - {{ ucfirst($folder) }}')

@section('content_header')
<h5>Documentos - {{ ucfirst($folder) }}</h5>
@stop

@section('content')
<div class="card col-md-10">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Listado de Documentos</h3>
            @can('subir.pdfs')
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uploadModal">
                Subir Nuevo PDF
            </button>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                <tr>
                    <td>{{ $document->id }}</td>
                    <td>{{ $document->empresa->nombre}}</td>
                    <td>
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">{{ basename($document->file_path) }}</a>
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-success" title="Descargar" download>
                                <i class="fas fa-download"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editFileNameModal{{ $document->id }}" title="Editar nombre">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('eliminar_documento', $document->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este archivo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @foreach ($documents as $document)
        <div class="modal fade" id="editFileNameModal{{ $document->id }}" tabindex="-1" aria-labelledby="editFileNameModalLabel{{ $document->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFileNameModalLabel{{ $document->id }}">Editar Nombre de Archivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('editar_nombre_documento', $document->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="new_file_name">Nuevo nombre de archivo</label>
                                <input type="text" class="form-control" name="new_file_name" placeholder="Nuevo nombre" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal para subir nuevo PDF -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Subir Nuevo PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sistema-gestion.upload') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateFile()">
                    @csrf
                    <input type="hidden" id="urlPath" name="urlPath" value="">

                    <div class="form-group">
                        <label for="empresa_id">Empresa</label>
                        <select class="form-control" id="empresa_id" name="empresa_id" required>
                            <option value="" disabled selected>Seleccione una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file">Archivo PDF</label>
                        <input type="file" name="file" class="form-control" accept="application/pdf" required onchange="validateFile()">
                        <small class="form-text text-muted">Solo se permiten archivos PDF de máximo 5MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
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

<script>
    function validateFile() {
        const fileInput = document.querySelector('input[name="file"]');
        const filePath = fileInput.value;
        const allowedExtensions = /(\.pdf)$/i;

        if (!allowedExtensions.exec(filePath)) {
            alert('Solo se permiten archivos PDF.');
            fileInput.value = '';
            return false;
        }

        if (fileInput.files[0].size > 5242880) { // 5MB in bytes
            alert('El archivo debe tener un tamaño máximo de 5MB.');
            fileInput.value = '';
            return false;
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Obtener la parte de la URL después del dominio
        var urlPath = window.location.pathname;

        // Asignar la parte de la URL al campo oculto
        document.getElementById('urlPath').value = urlPath;
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
