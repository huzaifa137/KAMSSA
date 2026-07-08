<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use PDF; // Make sure to import the PDF facade if you haven't already
use Illuminate\Mail\Message;
use Illuminate\Mail\PendingMail;


class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'UP O.T.P',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    /* Original content/build method to send Email */

    public function build()
    {

        $data = $this->data;

        $pdf_data = PDF::loadView('emails.otp', compact('data'));
        $pdf = $pdf_data->output();
    
        return $this->view('emails.otp');
    }

    public function content()
    {

    return new Content(
        view: 'emails.otp'
    );
    
}


    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
