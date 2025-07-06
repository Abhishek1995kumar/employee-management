<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpVerified extends Mailable {
    use Queueable, SerializesModels;
    public $data;
    public $subject;
    public $view;

    public function __construct($data, $subject, $view) {
        $this->data = $data;
        $this->subject = $subject;
        $this->view = $view;
    }

    
    public function build() {
        return $this->view($this->view)
            ->with('data', $this->data)
            ->subject($this->subject);
    }


    public function attachments(): array {
        return [];
    }


}
