<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InspeccionVehiculosMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspeccion;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param $inspection
     * @param $pdf
     */
    public function __construct($inspeccion, $pdfPath)
    {
        $this->inspeccion = $inspeccion;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reporte de Inspección de Vehículo')
            ->markdown('emails.inspeccion_vehiculos')
            ->attach($this->pdfPath,[
                'as' => 'inspeccion_vehicular.pdf',
                'mime' => 'application/pdf',
            ]);
    }


  
}
