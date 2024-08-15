<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InspectionVehicleReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $inspection;
    public $pdfContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inspection, $pdfContent)
    {
        $this->inspection = $inspection;
        // Asegúrate de que el contenido del PDF esté en UTF-8
        $this->pdfContent = ($pdfContent);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.inspection')
                    ->subject('Vehicle Inspection Report')
                    ->attachData($this->pdfContent, 'inspection_' . $this->inspection->id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
