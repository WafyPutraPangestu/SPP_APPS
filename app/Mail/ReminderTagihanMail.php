<?php

namespace App\Mail;

use App\Models\Tagihan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderTagihanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tagihan;

    public function __construct(Tagihan $tagihan)
    {
        $this->tagihan = $tagihan;
    }

    public function build()
    {
        return $this->subject('Pengingat SPP - Ponpes La-Taksal')
            ->view('emails.reminder');
    }
}
