<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained()->onDelete('cascade');
            $table->string('nomor_transaksi');
            $table->decimal('jumlah', 12, 2);
            $table->dateTime('tanggal_bayar');
            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_bayar_url')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('status_updated_at')->nullable(); // Tambahan kolom untuk mencatat waktu update status
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};