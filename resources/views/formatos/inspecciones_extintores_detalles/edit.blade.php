@extends('adminlte::page')

@section('title', 'Editar Detalle de Inspección de Extintores')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h5>Editar Detalle de Inspección</h5>
    <a href="{{ route('inspecciones_extintores.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Editar Detalle de Inspección de Extintores
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif



        <form action="{{ route('inspecciones_extintores_detalles.update', ['id' => $detalles[0]->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="inspeccion_extintor_id" value="{{ $inspeccion_id }}">
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="extintor_id">Extintor</label>
                    <select class="form-control @error('extintor_id') is-invalid @enderror" id="extintor_id" name="extintor_id_disabled" disabled required>
                        <option value="" disabled>Seleccione un extintor</option>
                        @foreach($extintores as $extintor)
                        <option value="{{ $extintor->id }}" {{ $detalles[0]->extintor_id == $extintor->id ? 'selected' : '' }}>
                            {{ $extintor->codigo }} - {{ $extintor->area }}
                        </option>
                        @endforeach
                    </select>

                    <!-- Campo oculto para enviar el valor de extintor_id -->
                    <input type="hidden" name="extintor_id" value="{{ $detalles[0]->extintor_id }}">

                    @error('extintor_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            @foreach ($detalles as $index => $detalle)
            <div class="col-md-12">
                <div class="card card-outline card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $detalle->pregunta }}</h3>
                        <div class="card-tools">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="hidden" name="preguntas[{{ $index }}][respuesta]" value="no">
                                <input type="checkbox" class="custom-control-input @error('preguntas.'.$index.'.respuesta') is-invalid @enderror" id="customSwitch{{ $index }}" name="preguntas[{{ $index }}][respuesta]" value="si" {{ $detalle->respuesta == 'si' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customSwitch{{ $index }}"></label>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="preguntas[{{ $index }}][texto]" value="{{ $detalle->pregunta }}">
                        <label>Observaciones:</label>
                        <textarea name="preguntas[{{ $index }}][observaciones]" class="form-control @error('preguntas.'.$index.'.observaciones') is-invalid @enderror">{{ old("preguntas.{$index}.observaciones", $detalle->observaciones) }}</textarea>
                        @error('preguntas.'.$index.'.observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <label for="imagenes">Imágenes de la Inspección (puede seleccionar varias)</label>
                <input type="file" name="imagenes[]" id="imagenes" class="form-control @error('imagenes.*') is-invalid @enderror" multiple accept="image/*" capture="camera">
                @error('imagenes.*')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success float-right">Actualizar</button>
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
    toastr.success("{!! Session::get('success') !!}");
</script>
@endif
@if(session('error'))
<script>
    toastr.error("{!! Session::get('error') !!}");
</script>
@endif
@stop