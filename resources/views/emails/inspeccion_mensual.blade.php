@component('mail::message')

# Reporte de Inspección Mensual

A continuación podrá obtener más detalles sobre la inspección realizada, descargue el PDF adjunto en este correo o visualice la inspección en el botón “Ver Inspección”.

@component('mail::button', ['url' => url('/inspecciones/'.$inspeccion->id)])
Ver Reporte
@endcomponent

Gracias, Equipo ERGOMAS
@endcomponent
