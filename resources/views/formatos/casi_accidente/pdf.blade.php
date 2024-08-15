<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Casi Accidente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .content h2 {
            margin-top: 0;
        }
        .content .section {
            margin-bottom: 10px;
        }
        .section label {
            font-weight: bold;
        }
        .photos img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reporte de Casi Accidente</h1>
        </div>
        <div class="content">
            <div class="section">
                <label>Empresa:</label>
                <p>{{ $nearAccidentReport->empresa->nombre }}</p>
            </div>
            <div class="section">
                <label>Tipo de condición:</label>
                <div>
                    @foreach(json_decode($nearAccidentReport->condition_type) as $condition)
                        <p>{{ $condition }}</p>
                    @endforeach
                </div>
            </div>
            <div class="section">
                <label>Nivel de gravedad del casi accidente:</label>
                <p>{{ $nearAccidentReport->severity_level }}</p>
            </div>
            <hr>
            <div class="section">
                <label>Nombres y Apellidos (Reportante):</label>
                <p>{{ $nearAccidentReport->reporter_name }}</p>
            </div>
            <div class="section">
                <label>Cargo (Reportante):</label>
                <p>{{ $nearAccidentReport->reporter_position }}</p>
            </div>
            <div class="section">
                <label>Área (Reportante):</label>
                <p>{{ $nearAccidentReport->reporter_area }}</p>
            </div>
            <hr>
            <div class="section">
                <label>Nombres y Apellidos (Persona afectada):</label>
                <p>{{ $nearAccidentReport->victim_name }}</p>
            </div>
            <div class="section">
                <label>Cargo (Persona afectada):</label>
                <p>{{ $nearAccidentReport->victim_position }}</p>
            </div>
            <div class="section">
                <label>Lugar de trabajo (Persona afectada):</label>
                <p>{{ $nearAccidentReport->victim_work_location }}</p>
            </div>
            <hr>
            <div class="section">
                <label>Descripción del casi accidente:</label>
                <p>{{ $nearAccidentReport->description }}</p>
            </div>
            <div class="section">
                <label>Fotografías adjuntas:</label>
                <div class="photos">
                    @if ($nearAccidentReport->photos)
                        @foreach (json_decode($nearAccidentReport->photos) as $photo)
                            <img src="{{ public_path('storage/' . $photo) }}" alt="Foto">
                        @endforeach
                    @endif
                </div>
            </div>
            <hr>
            <div class="section">
                <label>Seguimiento (Nombres):</label>
                <div>
                    @foreach(json_decode($nearAccidentReport->follow_up_name) as $userId)
                        <p>{{ App\Models\User::find($userId)->name }}</p>
                    @endforeach
                </div>
            </div>
            <div class="section">
                <label>Correos de Seguimiento:</label>
                <div>
                    @foreach(json_decode($nearAccidentReport->follow_up_email) as $email)
                        <p>{{ $email }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="footer">
            <p>Generado el {{ now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>
