@component('mail::message')

# Reporte de Inspección Mensual

A continuación podrá obtener más detalles sobre la inspección realizada. Puede descargar el PDF adjunto en este correo o visualizar la inspección utilizando el siguiente botón:

@component('mail::button', ['url' => url('/inspecciones/'.$inspeccion->id)])
Ver Reporte
@endcomponent

Gracias,
Equipo ERGOMAS

@endcomponent