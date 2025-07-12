<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMidtrans extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentTransaction;
    public $user;
    public $course;

    public function __construct($paymentTransaction, $user, $course)
    {
        $this->paymentTransaction = $paymentTransaction;
        $this->user = $user;
        $this->course = $course;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pembelian Kursus ' . $this->course->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.InvoiceMidtrans',
            with: [
                'transaction' => $this->paymentTransaction,
                'user' => $this->user,
                'course' => $this->course,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
