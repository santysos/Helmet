<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspeccionMensualMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspeccion;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param $inspeccion
     * @param $pdfPath
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
        return $this->subject('Reporte de Inspección Mensual')
                    ->markdown('emails.inspeccion_mensual')
                    ->attach($this->pdfPath, [
                        'as' => 'inspeccion_mensual.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
