<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detalles de la Inspección de Vehículo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .card {
            border: 1px solid #000;
            margin-bottom: 20px;
            padding: 15px;
        }
        .card-header {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-body {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Detalles de la Inspección de Vehículo</h1>

    <table>
        <tr>
            <th>Conductor</th>
            <td>{{ $inspection->driver_name }}</td>
        </tr>
        <tr>
            <th>Placa</th>
            <td>{{ $inspection->plate }}</td>
        </tr>
        <tr>
            <th>Número del Vehículo</th>
            <td>{{ $inspection->vehicle_number }}</td>
        </tr>
        <tr>
            <th>Fecha de Inspección</th>
            <td>{{ $inspection->inspection_date }}</td>
        </tr>
        <tr>
            <th>Supervisado Por</th>
            <td>{{ $inspection->supervised_by }}</td>
        </tr>
        <tr>
            <th>Observaciones Generales</th>
            <td>{{ $inspection->observations_general }}</td>
        </tr>
    </table>

    <h3>Detalles de la Inspección</h3>

    @foreach ($inspection->details as $detail)
        <div class="card">
            <div class="card-header">
                {{ $detail->question }}
            </div>
            <div class="card-body">
                <strong>Respuesta:</strong> {{ $detail->answer ? 'Sí' : 'No' }}<br>
                <strong>Observaciones:</strong> {{ $detail->observations }}
            </div>
        </div>
    @endforeach
</body>
</html>
