<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftar;

class PendaftaranBerhasil extends Mailable
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
        return $this->subject('Konfirmasi Pendaftaran - SINEMANIS')
                    ->view('emails.pendaftaran_berhasil')
                    ->with([
                        'pendaftar' => $this->pendaftar
                    ]);
    }
}