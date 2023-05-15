<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class guestTentativa extends Mailable
{
    use Queueable, SerializesModels;

    public $nome, $contacto, $useremail, $pdf, $chart, $categs, $medias;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $contacto, $useremail, $pdf, $chart, $categs, $medias)
    {
        $this->nome = $nome;
        $this->contacto = $contacto;
        $this->useremail = $useremail;
        $this->pdf = $pdf;
        $this->chart = $chart;
        $this->categs = $categs;
        $this->medias = $medias;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hlink@info.pt', 'Hlink Lda.')->view('mail.submissao')
            ->attachData($this->pdf->output(), 'submissao.pdf');
    }
}
