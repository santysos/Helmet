@component('mail::message')

# Detalles de la Inspección de Extintores

A continuación podrá obtener mas detalles sobre la inspección realizada, descargue el PDF adjunto o visualice la inspección en el botón “ver inspección”.

@component('mail::button', ['url' => url('/inspecciones_extintores/'.$inspeccion->id)])
Ver Inspección
@endcomponent

Gracias, Equipo ERGOMAS
@endcomponent
