@extends('adminlte::page')

@section('title', 'Nueva Inspección')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Inspección Mensual</h5>
    <a href="{{ route('inspecciones.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card ">
    <div class="card-header">
        Nueva Inspección
    </div>
    <div class="card-body">
        <form action="{{ route('inspecciones.store') }}" method="POST" enctype="multipart/form-data">
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
                        {{ !$seleccionable ? 'disabled' : '' }}> <!-- Si no es seleccionable, deshabilitar -->

                        <option value="" disabled {{ !isset($empresaSeleccionada) ? 'selected' : '' }}>Seleccione una empresa</option>

                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}"
                            {{ (old('empresa_id') == $empresa->id || (isset($empresaSeleccionada) && $empresaSeleccionada == $empresa->id)) ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                        @endforeach
                    </select>

                    @if(!$seleccionable)
                    <!-- Campo oculto para enviar el valor seleccionado en caso de estar deshabilitado -->
                    <input type="hidden" name="empresa_id" value="{{ $empresaSeleccionada }}">
                    @endif
                </div>

                <div class="col-md-4">
                    <label for="area">Área</label>
                    <input type="text" class="form-control" id="area" name="area" value="{{ old('area') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_inspeccion">Fecha de la Inspección</label>
                    <input type="date" class="form-control" id="fecha_inspeccion" name="fecha_inspeccion" value="{{ old('fecha_inspeccion') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="responsable_inspeccion">Responsable de la Inspección</label>
                    <input type="text" class="form-control" id="responsable_inspeccion" name="responsable_inspeccion" value="{{ old('responsable_inspeccion') }}" required>
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

            @foreach ($sections as $sectionName => $questions)
            <h5>{{ $sectionName }}</h5>
            @foreach ($questions as $index => $question)
            <div class="col-md-12">
                <div class="card card-outline card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $question }}</h3>
                        <div class="card-tools">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitch{{ $loop->parent->index }}{{ $loop->index }}" name="answers[{{ $loop->parent->index }}][{{ $loop->index }}]" value="yes" {{ old("answers.{$loop->parent->index}.{$loop->index}") == 'yes' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customSwitch{{ $loop->parent->index }}{{ $loop->index }}"></label>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="questions[{{ $loop->parent->index }}][{{ $loop->index }}]" value="{{ $question }}">
                        <label>Observaciones:</label>
                        <textarea name="observations[{{ $loop->parent->index }}][{{ $loop->index }}]" class="form-control">{{ old("observations.{$loop->parent->index}.{$loop->index}") }}</textarea>
                        <label>Foto:</label>
                        <input type="file" name="photos[{{ $loop->parent->index }}][{{ $loop->index }}]" class="form-control">
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach

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