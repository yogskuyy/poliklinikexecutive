<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nip_str')->nullable();
            $table->string('spesialisasi');
            $table->string('foto_url')->nullable();
            $table->enum('status_praktek', ['praktek', 'istirahat', 'selesai', 'belum_mulai', 'cuti'])->default('belum_mulai');
            $table->string('nomor_kontak')->nullable();
            $table->string('ruang_praktek')->default('Suite Executive');
            $table->decimal('rating', 3, 1)->default(4.9);
            $table->integer('pengalaman_tahun')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
