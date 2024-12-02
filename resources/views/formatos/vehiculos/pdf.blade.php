<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Inspección de Vehículo</title>
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
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/helmet-logo.webp') }}" alt="Helmet Logo">
    </div>

    <div>
        <strong>Detalles de la Inspección de Vehículo</strong>
    </div>

    <table class="table table-sm table-bordered table-datos-empresa">
        <tbody>
            <tr>
                <th colspan="3"> Datos del Vehículo</th>
            </tr>
            <tr>
                <td style="width: 50%;">Conductor: {{ $inspection->driver_name }}</td>
                <td style="width: 25%;">Placa: {{ $inspection->plate }}</td>
                <td style="width: 25%;">Número del Vehículo: {{ $inspection->vehicle_number }}</td>
            </tr>
            <tr>
                <th><strong>Fecha de Inspección:</strong></th>
                <td colspan="2">{{ $inspection->inspection_date }}</td>
            </tr>
            <tr>
                <th><strong>Supervisado Por:</strong></th>
                <td colspan="2">{{ $inspection->supervised_by }}</td>
            </tr>
            <tr>
                <th colspan="3"> Observaciones Generales</th>
            </tr>
            <tr>
                <td colspan="3">{{ $inspection->observations_general }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-sm table-bordered table-datos-empresa">
        <tbody>

            <tr>
                <th colspan="3">Detalles de la Inspección</th>
            </tr>
            @foreach ($inspection->details as $detail)
            <tr>
                <td colspan="2" style="width: 98%;">
                    <strong>{{ $detail->question }}</strong>
                    @if (!empty($detail->observations))
                    <br><strong>Obs:</strong> {{ $detail->observations }}
                    @endif
                </td>

                <td colspan="1" style="width: 2%; text-align: center; vertical-align: middle;">
                    <span class="badge badge-{{ $detail->answer ? 'success' : 'danger' }}">
                        {{ $detail->answer ? 'Sí' : 'No' }}
                    </span>
                </td>

            </tr>


            @endforeach
            <tr>
                <td colspan="3">
                    <div class="image-container">
                        <h5>Imágenes de la Inspección</h5>
                        @foreach ($inspection->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Imagen de la inspección">
                        @endforeach
                    </div>
                </td>
            </tr>


        </tbody>
    </table>

    <div class="footer">
        <p>Reporte Generado el {{ now()->format('d/M/Y - H:i:s') }}</p>
    </div>
</body>

</html>