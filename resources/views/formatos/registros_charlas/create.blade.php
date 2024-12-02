@extends('adminlte::page')

@section('title', 'Registro de Charla de Seguridad')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Registro de Charla de Seguridad</h5>
    <a href="{{ route('registros_charlas.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Nuevo Registro de Charla
    </div>
    <div class="card-body">
        <form action="{{ route('registros_charlas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="empresa_id">Empresa</label>
                    <select
                        class="form-control"
                        id="empresa_id"
                        name="empresa_id"
                        required
                        {{ !$seleccionable ? 'disabled' : '' }}> <!-- Deshabilitar si no es editable -->

                        <option value="" disabled {{ !isset($empresaSeleccionada) ? 'selected' : '' }}>Seleccione una empresa</option>

                        @foreach($empresas as $empresa)
                        <option
                            value="{{ $empresa->id }}"
                            {{ (old('empresa_id') == $empresa->id || (isset($empresaSeleccionada) && $empresaSeleccionada == $empresa->id)) ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                        @endforeach
                    </select>

                    @if(!$seleccionable)
                    <!-- Campo oculto para enviar el valor si el select está deshabilitado -->
                    <input type="hidden" name="empresa_id" value="{{ $empresaSeleccionada }}">
                    @endif
                </div>

                <div class="col-md-4">
                    <label for="departamento">Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento" value="{{ old('departamento') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="responsable_area">Responsable del Área</label>
                    <input type="text" class="form-control" id="responsable_area" name="responsable_area" value="{{ old('responsable_area') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="responsable_charla">Responsable de la Charla</label>
                    <input type="text" class="form-control" id="responsable_charla" name="responsable_charla" value="{{ old('responsable_charla') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" value="{{ old('area') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_charla">Fecha de la Charla</label>
                    <input type="date" class="form-control" id="fecha_charla" name="fecha_charla" value="{{ old('fecha_charla') }}" required>
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
                <textarea class="form-control" id="temas_discutidos_notas" name="temas_discutidos_notas" required>{{ old('temas_discutidos_notas') }}</textarea>
            </div>
            <div class="form-group">
                <label for="fotos">Fotos</label>
                <input type="file" class="form-control" id="fotos" name="fotos[]" multiple>
            </div>

            <button type="submit" class="btn btn-success float-right">Guardar</button>
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
    document.addEventListener('DOMContentLoaded', function () {
        var empresaId = document.getElementById('empresa_id').value;

        if (empresaId) { // Ejecutar si ya se conoce la empresa
            cargarTrabajadores(empresaId);
        }

        // Añadir el evento change para los demás casos
        document.getElementById('empresa_id').addEventListener('change', function () {
            var nuevaEmpresaId = this.value;
            cargarTrabajadores(nuevaEmpresaId);
        });

        // Cargar temas brindados al cargar la página
        cargarTemasBrindados();
    });

    function cargarTrabajadores(empresaId) {
        // Generar la URL para obtener trabajadores
        var trabajadoresUrl = `{{ url('/api/empresas') }}/${empresaId}/trabajadores`;

        fetch(trabajadoresUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                var trabajadoresDiv = document.getElementById('trabajadores');
                trabajadoresDiv.innerHTML = '';

                data.forEach(function (trabajador) {
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
    }

    function cargarTemasBrindados() {
        var documentosUrl = `{{ url('/api/documentos/charlas_seguridad') }}`;

        fetch(documentosUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                var temaBrindadoSelect = document.getElementById('tema_brindado');
                data.forEach(function (documento) {
                    var option = document.createElement('option');
                    option.value = documento.id;
                    option.textContent = documento.nombre;
                    temaBrindadoSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }
</script>


@stop