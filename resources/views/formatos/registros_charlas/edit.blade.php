@extends('adminlte::page')

@section('title', 'Editar Registro de Charla de Seguridad')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Editar Registro de Charla de Seguridad</h5>
    <a href="{{ route('registros_charlas.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Editar Registro de Charla
    </div>
    <div class="card-body">
        <form action="{{ route('registros_charlas.update', $registroCharla->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="empresa_id">Empresa</label>
                    <select class="form-control" id="empresa_id" name="empresa_id" required>
                        <option value="" disabled>Seleccione una empresa</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ $registroCharla->empresa_id == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" value="{{ $registroCharla->departamento }}" required>
                </div>
                <div class="col-md-4">
                    <label for="responsable_area">Responsable del Área</label>
                    <input type="text" class="form-control" id="responsable_area" name="responsable_area" value="{{ $registroCharla->responsable_area }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="responsable_charla">Responsable de la Charla</label>
                    <input type="text" class="form-control" id="responsable_charla" name="responsable_charla" value="{{ $registroCharla->responsable_charla }}" required>
                </div>
                <div class="col-md-4">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" value="{{ $registroCharla->area }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_charla">Fecha de la Charla</label>
                    <input type="date" class="form-control" id="fecha_charla" name="fecha_charla" value="{{ $registroCharla->fecha_charla }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="trabajadores">Nómina de Trabajadores</label>
                <div id="trabajadores">
                    <!-- Los trabajadores se cargarán dinámicamente aquí -->
                </div>
            </div>

            <div class="form-group">
                <label for="tema_brindado">Tema Brindado</label>
                <select class="form-control" id="tema_brindado" name="tema_brindado[]" multiple required>
                    <!-- Los temas se cargarán dinámicamente aquí -->
                </select>
            </div>

            <div class="form-group">
                <label for="temas_discutidos_notas">Notas</label>
                <textarea class="form-control" id="temas_discutidos_notas" name="temas_discutidos_notas" required>{{ $registroCharla->temas_discutidos_notas }}</textarea>
            </div>
            <div class="form-group">
                <label for="fotos">Fotos</label>
                <input type="file" class="form-control" id="fotos" name="fotos[]" multiple>
                @if ($registroCharla->fotos)
                    @foreach (json_decode($registroCharla->fotos) as $foto)
                        <a href="{{ asset('storage/' . $foto) }}" data-lightbox="photos">
                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="img-thumbnail" width="100">
                        </a>
                    @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-success float-right">Actualizar</button>
        </form>
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

<script>
document.getElementById('empresa_id').addEventListener('change', function () {
    var empresaId = this.value;

    fetch(`/api/empresas/${empresaId}/trabajadores`)
        .then(response => response.json())
        .then(data => {
            var trabajadoresDiv = document.getElementById('trabajadores');
            trabajadoresDiv.innerHTML = '';

            data.forEach(function(trabajador) {
                var div = document.createElement('div');
                div.className = 'form-check';

                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'form-check-input';
                checkbox.id = 'trabajador' + trabajador.id;
                checkbox.name = 'trabajadores[]';
                checkbox.value = trabajador.id;

                var label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = 'trabajador' + trabajador.id;
                label.textContent = `${trabajador.nombre} ${trabajador.apellido}`;

                div.appendChild(checkbox);
                div.appendChild(label);

                trabajadoresDiv.appendChild(div);
            });
        })
        .catch(error => console.error('Error:', error));
});

// Cargar trabajadores seleccionados al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    var empresaId = document.getElementById('empresa_id').value;

    fetch(`/api/empresas/${empresaId}/trabajadores`)
        .then(response => response.json())
        .then(data => {
            var trabajadoresDiv = document.getElementById('trabajadores');
            trabajadoresDiv.innerHTML = '';

            var selectedTrabajadores = @json($registroCharla->trabajadores->pluck('id'));

            data.forEach(function(trabajador) {
                var div = document.createElement('div');
                div.className = 'form-check';

                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'form-check-input';
                checkbox.id = 'trabajador' + trabajador.id;
                checkbox.name = 'trabajadores[]';
                checkbox.value = trabajador.id;

                if (selectedTrabajadores.includes(trabajador.id)) {
                    checkbox.checked = true;
                }

                var label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = 'trabajador' + trabajador.id;
                label.textContent = `${trabajador.nombre} ${trabajador.apellido}`;

                div.appendChild(checkbox);
                div.appendChild(label);

                trabajadoresDiv.appendChild(div);
            });
        })
        .catch(error => console.error('Error:', error));

    fetch('/api/documentos/charlas_seguridad')
        .then(response => response.json())
        .then(data => {
            var temaBrindadoSelect = document.getElementById('tema_brindado');
            var selectedTemas = @json(json_decode($registroCharla->tema_brindado, true));

            data.forEach(function (documento) {
                var option = document.createElement('option');
                option.value = documento.id;
                option.textContent = documento.nombre;

                if (selectedTemas.includes(documento.id)) {
                    option.selected = true;
                }

                temaBrindadoSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
});
</script>
@stop
