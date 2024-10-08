<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Charla</title>
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
        <strong>Detalles de la Charla</strong>
    </div>

    <table class="table table-sm table-bordered table-datos-empresa">
    <tbody>

        <tr>
            <th># Charla</th>
            <td>{{ $registroCharla->id }}</td>
            <th>Empresa</th>
            <td>{{ $registroCharla->empresa->nombre }}</td>
        </tr>
        <tr>
            <th>Fecha de la Charla</th>
            <td>{{ $registroCharla->fecha_charla }}</td>
            <th>Usuario</th>
            <td>{{ $registroCharla->user->name }}</td>
        </tr>
        <tr>
            <th>Área</th>
            <td>{{ $registroCharla->area }}</td>
            <th>Responsable del Área</th>
            <td>{{ $registroCharla->responsable_area }}</td>
        </tr>
        <tr>
            <th>Responsable de la Charla</th>
            <td>{{ $registroCharla->responsable_charla }}</td>
            <th>Departamento</th>
            <td>{{ $registroCharla->departamento }}</td>
        </tr>
        <tr>
            <th>Tema Brindado</th>
            <td>
                @foreach(json_decode($registroCharla->tema_brindado, true) as $temaId)
                @if(isset($temas[$temaId]))
                <span>{{ $temas[$temaId] }}</span><br>
                @endif
                @endforeach
            </td>
            <th>Temas Discutidos o Notas</th>
            <td>{{ $registroCharla->temas_discutidos_notas }}</td>
        </tr>
        <tr>
            <th>Fotos</th>
            <td colspan="3">
                @if($registroCharla->fotos)
                @foreach(json_decode($registroCharla->fotos) as $foto)
                <img src="{{ $foto }}" alt="Foto de la charla" style="width: 100px; height: auto;">
                @endforeach
                @endif

            </td>
        </tr>
    </tbody>
    </table>

    <div>
        <strong>Participantes</strong>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registroCharla->trabajadores as $trabajador)
            <tr>
                <td>{{ $trabajador->nombre }}</td>
                <td>{{ $trabajador->apellido }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte Generado el {{ now()->format('d/M/Y - H:i:s') }}</p>
    </div>
</body>

</html>