<?php

namespace App\Mail;

use App\Models\Incidente; // Asegúrate de importar el modelo Incidente
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReporteIncidentesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nearAccidentReport;
    public $pdfPath;

    /**
     * Crear una nueva instancia del mensaje.
     *
     * @param \App\Models\Incidente $incidente
     * @param $pdfPath
     */
    public function __construct($nearAccidentReport, $pdfPath)
    {
        $this->nearAccidentReport = $nearAccidentReport;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reporte de Incidente: ' . $this->nearAccidentReport->titulo)
            ->markdown('emails.reporte_incidentes') // Vista del correo (se asume que la vista está en resources/views/emails/reporte_incidentes.blade.php)
            ->attach($this->pdfPath, [
                'as' => 'Reporte-Incidente-' . $this->nearAccidentReport->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
