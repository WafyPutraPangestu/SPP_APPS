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
        // Jika terlambat, subjeknya "Peringatan", jika tidak subjeknya "Pengingat"
        $subjectText = $this->tagihan->is_terlambat
            ? '⚠️ PERINGATAN: SPP Terlambat - Ponpes La-Taksal'
            : 'Pengingat SPP - Ponpes La-Taksal';

        return $this->subject($subjectText)
            ->view('emails.reminder');
    }
}
