<?php

namespace App\Mail;

use App\Models\Mails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailsDB;
    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( \stdClass $mails, $template )
    {
        $this->mailsDB = $mails;
        $this->template = $template;

        $this->registerInDB();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = 'mails.' . $this->template;
        return $this->subject( $this->mailsDB->subject )
            ->view( $template, $this->mailsDB->vars );
    }

    public function registerInDB(){
        $dbMail = new Mails();
        $dbMail->from       = $this->mailsDB->from;
        $dbMail->to         = $this->mailsDB->to;
        $dbMail->subject    = $this->mailsDB->subject;
        $dbMail->dateSend   = date( 'Y-m-d ');
        $dbMail->status     = 1;
        $dbMail->body       = $this->getHtmlBody();
        $dbMail->save();
    }

    public function getHtmlBody() {
        $template = 'mails.' . $this->template;
        return $this->view( $template, $this->mailsDB->vars )->render();
    }
}
