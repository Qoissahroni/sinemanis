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
        Schema::table('pendaftars', function (Blueprint $table) {
            // Tambah kolom untuk pergantian prodi
            $table->foreignId('prodi_baru_id')->nullable()->constrained('prodis')->onDelete('set null')->after('prodi_id');
            $table->string('kelas_baru')->nullable()->after('prodi_baru_id');
            $table->text('alasan_ganti_prodi')->nullable()->after('kelas_baru');
            $table->decimal('selisih_biaya_prodi', 12, 2)->nullable()->after('alasan_ganti_prodi');
            $table->enum('status_ganti_prodi', ['pending', 'approved', 'rejected'])->nullable()->after('selisih_biaya_prodi');
            $table->boolean('sudah_ganti_prodi')->default(false)->after('status_ganti_prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropForeign(['prodi_baru_id']);
            $table->dropColumn([
                'prodi_baru_id',
                'kelas_baru',
                'alasan_ganti_prodi',
                'selisih_biaya_prodi',
                'status_ganti_prodi',
                'sudah_ganti_prodi'
            ]);
        });
    }
};