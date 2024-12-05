@component('mail::message')

# Reporte de Incidente

A continuación podrá obtener más detalles sobre el incidente reportado. Puede descargar el PDF adjunto en este correo o visualizar el reporte utilizando el siguiente botón:

@component('mail::button', ['url' => url('/casi-accidente/'.$nearAccidentReport->id)])
Ver Reporte
@endcomponent

Gracias,  
Equipo ERGOMAS

@endcomponent
