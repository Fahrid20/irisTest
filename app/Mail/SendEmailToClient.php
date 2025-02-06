<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailToClient extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;

    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('Message de l’Administration')
                    ->view('client')
                    ->with(['messageContent' => $this->messageContent]);
    }
}

