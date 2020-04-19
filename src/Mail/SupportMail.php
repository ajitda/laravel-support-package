<?php

namespace Flexibleit\Support\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $button = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $button = [])
    {
        $this->message = $message;
        $this->button = $button;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('support::email.email')->with(['message'=>$this->message, 'button'=>$this->button]);
    }
}
