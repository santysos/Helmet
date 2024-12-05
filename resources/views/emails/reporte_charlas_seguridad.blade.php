@component('mail::message')

# Reporte de Charla de Seguridad

A continuación podrá obtener más detalles sobre la charla de seguridad realizada. Puede descargar el PDF adjunto en este correo o visualizar la charla utilizando el siguiente botón:

@component('mail::button', ['url' => url('/charlas/'.$charla->id)])
Ver Reporte
@endcomponent

Gracias,  
Equipo ERGOMAS

@endcomponent
