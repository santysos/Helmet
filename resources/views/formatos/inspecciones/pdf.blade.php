<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspección #{{ $inspeccion->id }}</title>
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
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            text-align: center;
            padding: 0px 0;
        }

        img {
            width: 150px;
        }

        body {
            padding-top: 80px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-datos-empresa th,
        .table-datos-empresa td {
            min-width: 50px;
            max-width: 200px;
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 0.65;
            vertical-align: middle;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 12px;
            line-height: 1.5;
        }

        th {
            background-color: #f2f2f2;
            font-size: 13px;
        }

        .image-container {
            margin-top: 10px;
        }

        .image-container img {
            max-width: 100px;
            margin-right: 10px;
        }

        .section-title {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0;
            padding: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="header">
        {{-- <img src="{{ asset('images/helmet-logo.webp') }}" alt="Helmet Logo">--}}
    </div>

    <div>
        <strong>Detalles de la Inspección de Vehículo #{{ $inspeccion->id }}</strong>
    </div>

    <table class="table table-sm table-bordered table-datos-empresa">
        <tbody>
            <tr>
                <th colspan="3">Datos de la Inspección</th>
                <td><strong># Inspección:</strong></td>
                <td colspan="2">{{ $inspeccion->id }}</td>
            </tr>
            <tr>
                <td><strong># Inspección:</strong></td>
                <td colspan="2">{{ $inspeccion->id }}</td>
            </tr>
            <tr>
                <td><strong>Fecha de Inspección:</strong></td>
                <td colspan="2">{{ $inspeccion->fecha_inspeccion }}</td>
            </tr>
            <tr>
                <td><strong>Empresa:</strong></td>
                <td colspan="2">{{ $inspeccion->empresa->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Usuario:</strong></td>
                <td colspan="2">{{ $inspeccion->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Área:</strong></td>
                <td colspan="2">{{ $inspeccion->area }}</td>
            </tr>
            <tr>
                <td><strong>Responsable del Área:</strong></td>
                <td colspan="2">{{ $inspeccion->responsable_area }}</td>
            </tr>
            <tr>
                <td><strong>Responsable de la Inspección:</strong></td>
                <td colspan="2">{{ $inspeccion->responsable_inspeccion }}</td>
            </tr>
            <tr>
                <td><strong>Departamento:</strong></td>
                <td colspan="2">{{ $inspeccion->departamento }}</td>
            </tr>
        </tbody>
    </table>

    @foreach ($sections as $sectionName => $detalles)
    <div class="section-title">{{ $sectionName }}</div>
    <table class="table table-sm table-bordered table-datos-empresa">

        <tbody>
            @foreach ($detalles as $detalle)
            <tr>
                <td colspan="2" style="width: 98%;">
                    <strong>{{ $detalle->pregunta }}</strong>
                </td>

                <td colspan="1" style="width: 2%; text-align: center; vertical-align: middle;">
                    <span class="badge badge-{{ $detalle->respuesta ? 'success' : 'danger' }}">
                        {{ $detalle->respuesta ? 'Sí' : 'No' }}
                    </span>
                </td>
            </tr>
            @if ($detalle->observaciones || $detalle->photo)
            <tr>
                <td colspan="2"><strong>Obs:</strong> {{ $detalle->observaciones }}</td>
                <td colspan="1">
                    @if ($detalle->photo)
                    <img src="{{ public_path('storage/' . $detalle->photo) }}" alt="Foto" style="width: 100px;">
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endforeach

    <div class="footer">
        <p>Reporte Generado el {{ now()->format('d/M/Y - H:i:s') }}</p>
    </div>

</body>

</html>