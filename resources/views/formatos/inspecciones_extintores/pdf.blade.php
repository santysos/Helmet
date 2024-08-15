<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspección de Extintores</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .image-container {
            margin-top: 10px;
        }

        .image-container img {
            max-width: 100px;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h1>Detalle de la Inspección de Extintores</h1>
    <div>
        <strong>Empresa:</strong> {{ $inspeccion->empresa->nombre }}<br>
        <strong>Área:</strong> {{ $inspeccion->area }}<br>
        <strong>Fecha de Inspección:</strong> {{ $inspeccion->fecha_inspeccion }}<br>
        <strong>Responsable de la Inspección:</strong> {{ $inspeccion->responsable_inspeccion }}<br>
        <strong>Departamento:</strong> {{ $inspeccion->departamento }}<br>
        <strong>Comentarios:</strong> {{ $inspeccion->comentarios ?? 'N/A' }}<br>
        <strong>Riesgos y Recomendaciones:</strong> {{ $inspeccion->riesgos_recomendaciones ?? 'N/A' }}<br>
    </div>
    <hr>
    @if($inspeccion->detalles->isNotEmpty())
    <h2>Detalles de los Extintores Inspeccionados</h2>
    @foreach ($inspeccion->detalles->groupBy('extintor_id') as $extintorId => $detalles)
    <h3>{{ $detalles->first()->extintor->codigo }} - {{ $detalles->first()->extintor->area }}</h3>
    <table>
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
    <div class="image-container">
        <h4>Imágenes del Extintor: {{ $detalles->first()->extintor->codigo }}</h4>
        @php
        $extintorImagenes = $imagenes->where('extintor_id', $extintorId);
        @endphp
        @if($extintorImagenes->isNotEmpty())
        @foreach($extintorImagenes as $imagen)
        <img src="{{ storage_path('app/public/' . $imagen->ruta_imagen) }}" alt="Imagen de la inspección">
        @endforeach
        @else
        <p>No hay imágenes disponibles para este extintor.</p>
        @endif
    </div>
    <hr>
    @endforeach
    @endif
</body>

</html>