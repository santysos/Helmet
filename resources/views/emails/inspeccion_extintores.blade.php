@component('mail::message')

# Detalles de la Inspección de Extintores

A continuación podrá obtener más detalles sobre la inspección realizada, descargue el PDF adjunto en este correo o visualice la inspección en el botón “Ver Inspección”.

@component('mail::button', ['url' => url('/inspecciones_extintores/'.$inspeccion->id)])
Ver Inspección
@endcomponent

Gracias, Equipo ERGOMAS
@endcomponent
