<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftar;

class PendaftarDiterima extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftar;

    /**
     * Create a new message instance.
     */
    public function __construct(Pendaftar $pendaftar)
    {
        $this->pendaftar = $pendaftar;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Selamat! Anda Diterima di Universitas Selamat Sri')
                    ->view('emails.pendaftar_diterima')
                    ->with([
                        'pendaftar' => $this->pendaftar
                    ]);
    }
}