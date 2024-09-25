<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspección de Extintores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Nunito Sans', sans-serif !important;
            color: #333333;
            /* Establece el color de los títulos */
        }



        .header {
            position: fixed;
            top: 0;
            width: 100%;
            text-align: center;
            padding: 0px 0;
            /* Añade padding para asegurar espacio alrededor del logo */
        }

        img {
            width: 150px;
            /* Ajusta el tamaño del logo si es necesario */
        }

        body {
            padding-top: 80px;
            /* Añade un padding-top suficiente para comenzar el contenido debajo del header */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-datos-empresa th,
        .table-datos-empresa td {
            min-width: 50px;
            /* Ancho mínimo para asegurar visibilidad */
            max-width: 200px;
            /* Ancho máximo para evitar desbordamiento */
            white-space: normal;
            /* Permite que el texto se ajuste si es necesario */
            overflow: hidden;
            /* Oculta cualquier contenido que exceda el tamaño de la celda */
            text-overflow: ellipsis;
            /* Añade elipses si el contenido es demasiado largo */
            line-height: 0.65;
            /* Ajusta el espacio entre líneas */
            vertical-align: middle;
            /* Centra el texto verticalmente */
        }


        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 12px;
            line-height: 0.7;
            /* Ajuste del salto de línea */

            /* Cambia el tamaño aquí según necesites */
        }

        th {
            background-color: #f2f2f2;
            font-size: 13px;
            /* Tamaño de fuente para los encabezados de la tabla */
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
    <div class="header">
    <img src="{{ asset('images/helmet-logo.webp') }}" alt="Helmet Logo">
    </div>

    <div class="titulo-fondo">
        <strong> Detalle de la Inspección de Extintores</strong>
    </div>
    <table class="table table-sm table-bordered table-datos-empresa">
        <tbody>
            <tr>
                <th><strong>Empresa:</strong></th>
                <td> {{ $inspeccion->empresa->nombre }}</td>
                <th><strong>Área:</strong></th>
                <td> {{ $inspeccion->area }}</td>
                <th><strong>Fecha de Inspección:</strong></th>
                <td> {{ $inspeccion->fecha_inspeccion }}</td>
            </tr>

            <tr>
                <th><strong>Responsable de la Inspección:</strong></th>
                <td> {{ $inspeccion->responsable_inspeccion }}</td>
                <th><strong>Departamento:</strong></th>
                <td> {{ $inspeccion->departamento }}</td>
                <th><strong>Comentarios:</strong></th>
                <td> {{ $inspeccion->comentarios ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th><strong>Riesgos y Recomendaciones:</strong> </th>
                <td colspan="5">{{ $inspeccion->riesgos_recomendaciones ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
    @if($inspeccion->detalles->isNotEmpty())
    <div class="titulo-fondo">
        <strong>Detalles de los Extintores Inspeccionados</strong>
    </div>
    @foreach ($inspeccion->detalles->groupBy('extintor_id') as $extintorId => $detalles)
    <strong>{{ $detalles->first()->extintor->codigo }} - {{ $detalles->first()->extintor->area }}</strong>
    <table class="table table-sm table-bordered">
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
                <td>
                    {!! $detalle->respuesta == 'si' ?
                    '<span class="badge bg-success" style="color: white;">Sí</span>' :
                    '<span class="badge bg-danger" style="color: white;">No</span>'
                    !!}
                </td>

                <td>{{ $detalle->observaciones }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="image-container">
        <div class="titulo-fondo">
            <strong> Imágenes del Extintor: {{ $detalles->first()->extintor->codigo }}
            </strong>
        </div>
        </br>
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