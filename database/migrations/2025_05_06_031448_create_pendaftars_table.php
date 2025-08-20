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
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('agama')->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('jenis_pendaftaran')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jenis_tinggal')->nullable();
            $table->string('alat_transportasi')->nullable();
            $table->string('kps')->nullable();
            $table->string('no_kps')->nullable();
            $table->string('bekerja')->nullable();
            $table->string('tempat_kerja')->nullable();
            $table->string('penghasilan')->nullable();
            
            // Data orang tua
            $table->string('nik_ayah', 16)->nullable();
            $table->string('nama_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            
            $table->string('nik_ibu', 16)->nullable();
            $table->string('nama_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            
            $table->string('nik_wali', 16)->nullable();
            $table->string('nama_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->string('no_hp_ortu')->nullable();
            
            // Program studi
            $table->foreignId('prodi_id')->nullable()->constrained()->onDelete('set null');
            $table->string('kelas')->nullable();
            $table->string('ukuran_almamater')->nullable();
            $table->string('ukuran_kaos')->nullable();
            
            // Asal sekolah
            $table->string('asal_sekolah')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('asal_perguruan_tinggi')->nullable();
            $table->string('asal_prodi')->nullable();
            $table->integer('semester_terakhir')->nullable();
            
            // Berkas dan status
            $table->string('berkas_url')->nullable();
            $table->string('foto_url')->nullable();
            $table->string('status')->default('pending');
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};