<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
        //var_dump($this->token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Questionnaire de satisfaction ;)')
            ->view('emails.email', ['token' => $this->token]);
    }
}
