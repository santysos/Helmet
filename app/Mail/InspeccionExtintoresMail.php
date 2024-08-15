<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InspeccionExtintoresMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspeccion;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
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
        return $this->subject('Nueva Inspección de Extintores Realizada en su empresa')
                    ->markdown('emails.inspeccion')
                    ->attach($this->pdfPath, [
                        'as' => 'inspeccion.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
