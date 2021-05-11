<?php

namespace Samcb\MailNotifier\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

     public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->details['attachment']!='') {
            return $this->subject($this->details['subject'])->attach($this->details['attachment'])->view('notifyblade::temp');
        }
        else{
            return $this->subject($this->details['subject'])->view('notifyblade::temp');
        }
        

    }
}
