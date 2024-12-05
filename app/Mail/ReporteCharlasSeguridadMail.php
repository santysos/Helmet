<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ReporteCharlasSeguridadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $charla;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param $charla
     * @param $pdfPath
     */
    public function __construct($charla, $pdfPath)
    {
        $this->charla = $charla;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reporte de Charla de Seguridad')
            ->markdown('emails.reporte_charlas_seguridad') // Vista del correo
            ->attach($this->pdfPath, [
                'as' => 'Reporte-Charla-Seguridad-' . $this->charla->id . '.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
