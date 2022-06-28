<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvaluationMailReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $objMail;
    public function __construct($objMail)
    {
        $this->objMail = $objMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Evaluación Docente')
                    ->attach($this->objMail['path'], 
                        [
                            'as' => $this->objMail['filename'],
                            'mime' => 'application/pdf'
                        ]
                    )
                    ->view('mails.evaluationMail');
    }
}
