<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeticionMailer extends Mailable
{
    use Queueable, SerializesModels;
    public $sms;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sms)
    {
        $this->sms = $sms ;
    }

    public function build()
    {
        
        return $this->from('experience_learning@grupokonecta.com.co','Grupo Konecta')
                     ->subject('Nueva solicitud del '.$this->sms->numero_caso)
                     ->markdown('web.mail.message');
                     
    }
}
