<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class LowIngredientStock extends Mailable
{

    /**
     * Create a new message instance.
     */
    public function __construct(public Ingredient $ingredient)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Low Ingredient Stock'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.low_ingredient',
            text: `hello {$this->ingredient->merchant->name}, we need to make order of {$this->ingredient->name}`,
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
