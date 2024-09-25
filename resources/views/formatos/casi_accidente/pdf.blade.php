<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Casi Accidente</title>
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
    <img src="{{ asset('storage/images/helmet-logo.webp') }}" alt="Helmet Logo">
    </div>
    <div>
        <strong>Reporte de Casi Accidente</strong>
    </div>
    <table class="table table-sm table-bordered table-datos-empresa">
        <tbody>
            <tr>
                <th colspan="3"> Reportante:</th>
            </tr>
            <tr>
                <td>{{ $nearAccidentReport->reporter_name }}</td>
                <td>Cargo: {{ $nearAccidentReport->reporter_position }}</td>
                <td>Area: {{ $nearAccidentReport->reporter_area }}</td>
            </tr>
            <tr>
                <th><strong>Empresa:</strong></th>
                <td colspan="2">{{ $nearAccidentReport->empresa->nombre }}</td>
            </tr>
            <tr>
                <th colspan="3"> Persona Afectada</th>
            </tr>
            <tr>
                <td>{{ $nearAccidentReport->victim_name }}</td>
                <td>Cargo: {{ $nearAccidentReport->victim_position }}</td>
                <td>Area: {{ $nearAccidentReport->victim_work_location }}</td>
            </tr>

            <tr>
                <th colspan="3"> Descripción del casi accidente:</th>
            </tr>
            <tr>
                <td colspan="3">{{ $nearAccidentReport->description }}</td>
            </tr>

            <tr>
                <th colspan="3">Tipo de condición:</th>
            </tr>

            <tr>
                <td colspan="3">
                    <div class="d-flex align-items-center flex-wrap">
                        @foreach(json_decode($nearAccidentReport->condition_type) as $condition)
                        <div class="mr-2">
                            {{ $condition }}
                        </div>
                        @endforeach
                    </div>
                </td>
            </tr>
            <tr>
                <th><strong>Nivel de gravedad del casi accidente:</strong></th>
                <td colspan="2">{{ $nearAccidentReport->severity_level }}</td>
            </tr>
            <tr>
                <th><strong>Seguimiento (Nombres):</strong></th>
                <td colspan="2">
                    @foreach(json_decode($nearAccidentReport->follow_up_name) as $userId)
                    {{ App\Models\User::find($userId)->name }} - Email:
                    @endforeach
                    @foreach(json_decode($nearAccidentReport->follow_up_email) as $email)
                    {{ $email }}<br>
                    @endforeach
                </td>

            </tr>
            <tr>
                <th colspan="3">Fotografías adjuntas:</th>
            </tr>
            <tr>
                <td colspan="3">
                    <div>
                        @if ($nearAccidentReport->photos)
                        @foreach (json_decode($nearAccidentReport->photos) as $photo)
                        <img src="{{ public_path('storage/' . $photo) }}" alt="Foto" style="display: inline-block; margin-right: 10px; margin-top: 5px;">
                        @endforeach
                        @endif
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