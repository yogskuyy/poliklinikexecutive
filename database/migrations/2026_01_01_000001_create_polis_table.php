<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_poli');
            $table->string('kode_poli')->unique();
            $table->string('icon')->default('stethoscope');
            $table->string('warna_gradien')->default('linear-gradient(135deg, #6366f1 0%, #a855f7 100%)');
            $table->string('warna_badge')->default('bg-indigo-100 text-indigo-700');
            $table->string('lokasi_ruangan');
            $table->text('deskripsi')->nullable();
            $table->integer('kuota_harian')->default(30);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polis');
    }
};
