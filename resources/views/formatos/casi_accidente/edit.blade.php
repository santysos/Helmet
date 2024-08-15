@extends('adminlte::page')

@section('title', 'Editar Reporte de Casi Accidentes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Editar Reporte de Casi Accidentes</h5>
    <a href="{{ route('casi_accidente.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="col-12 col-sm-8 col-md-12 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            Editar Reporte
        </div>
        <div class="card-body pt-0">

            <form action="{{ route('casi_accidente.update', $nearAccidentReport->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="empresa_id">Empresa</label>
                    <select class="form-control" id="empresa_id" name="empresa_id" required>
                        <option value="" disabled>Seleccione una empresa</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}" {{ $nearAccidentReport->empresa_id == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" id="user_id" name="user_id" value="{{ $nearAccidentReport->user_id }}">
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="reporter_name">Nombres y Apellidos (Reportante)</label>
                        <input type="text" class="form-control" id="reporter_name" name="reporter_name" value="{{ $nearAccidentReport->reporter_name }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="reporter_position">Cargo (Reportante)</label>
                        <input type="text" class="form-control" id="reporter_position" name="reporter_position" value="{{ $nearAccidentReport->reporter_position }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="reporter_area">Área (Reportante)</label>
                        <input type="text" class="form-control" id="reporter_area" name="reporter_area" value="{{ $nearAccidentReport->reporter_area }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="victim_name">Nombres y Apellidos (Persona afectada)</label>
                        <input type="text" class="form-control" id="victim_name" name="victim_name" value="{{ $nearAccidentReport->victim_name }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="victim_position">Cargo (Persona afectada)</label>
                        <input type="text" class="form-control" id="victim_position" name="victim_position" value="{{ $nearAccidentReport->victim_position }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="victim_work_location">Lugar de trabajo (Persona afectada)</label>
                        <input type="text" class="form-control" id="victim_work_location" name="victim_work_location" value="{{ $nearAccidentReport->victim_work_location }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descripción del casi accidente</label>
                    <textarea class="form-control" id="description" name="description" required>{{ $nearAccidentReport->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Tipo de condición</label>
                    <div>
                        @php
                        $conditionTypes = json_decode($nearAccidentReport->condition_type);
                        @endphp
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="condition_type[]" value="Acto Inseguro" {{ in_array('Acto Inseguro', $conditionTypes) ? 'checked' : '' }}>
                            <label for="customCheckbox1" class="custom-control-label">Acto Inseguro</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox2" name="condition_type[]" value="Condicion Insegura" {{ in_array('Condicion Insegura', $conditionTypes) ? 'checked' : '' }}>
                            <label for="customCheckbox2" class="custom-control-label">Condición Insegura</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox3" name="condition_type[]" value="Equipo Inseguro" {{ in_array('Equipo Inseguro', $conditionTypes) ? 'checked' : '' }}>
                            <label for="customCheckbox3" class="custom-control-label">Equipo Inseguro</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox4" name="condition_type[]" value="Uso inseguro del equipo" {{ in_array('Uso inseguro del equipo', $conditionTypes) ? 'checked' : '' }}>
                            <label for="customCheckbox4" class="custom-control-label">Uso inseguro del equipo</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox5" name="condition_type[]" value="Otra condicion" {{ in_array('Otra condicion', $conditionTypes) ? 'checked' : '' }}>
                            <label for="customCheckbox5" class="custom-control-label">Otra condición</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nivel de gravedad del casi accidente</label>
                    <div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio1" name="severity_level" value="leve" {{ $nearAccidentReport->severity_level == 'leve' ? 'checked' : '' }} required>
                            <label for="customRadio1" class="custom-control-label">Leve</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="severity_level" value="moderado" {{ $nearAccidentReport->severity_level == 'moderado' ? 'checked' : '' }} required>
                            <label for="customRadio2" class="custom-control-label">Moderado</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio3" name="severity_level" value="grave" {{ $nearAccidentReport->severity_level == 'grave' ? 'checked' : '' }} required>
                            <label for="customRadio3" class="custom-control-label">Grave</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="photos">Adjuntar fotografías</label>
                    <input type="file" class="form-control" id="photos" name="photos[]" multiple>
                    @if ($nearAccidentReport->photos)
                        @foreach (json_decode($nearAccidentReport->photos) as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto" class="img-thumbnail mt-2" width="150">
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="follow_up_name">Agregar seguimiento (Nombre)</label>
                    <select class="form-control" id="follow_up_name" name="follow_up_name[]" multiple required>
                        <option value="" disabled>Seleccione uno o varios usuarios</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, json_decode($nearAccidentReport->follow_up_name)) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
              
                <button type="submit" class="btn btn-success float-right">Actualizar Reporte</button>
            </form>
        </div>
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
    // JavaScript para cargar dinámicamente los nombres de seguimiento basados en la empresa seleccionada
    document.getElementById('empresa_id').addEventListener('change', function () {
        var empresaId = this.value;
        
        // Hacer una solicitud AJAX para obtener los usuarios de la empresa seleccionada
        fetch(`/api/empresas/${empresaId}/usuarios`)
            .then(response => response.json())
            .then(data => {
                var followUpNameSelect = document.getElementById('follow_up_name');
                followUpNameSelect.innerHTML = '<option value="" disabled>Seleccione uno o varios usuarios</option>';

                data.forEach(function(user) {
                    var option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.name;
                    followUpNameSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@stop
