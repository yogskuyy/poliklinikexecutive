<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('nomor_antrian');
            $table->date('tanggal_kunjungan');
            $table->time('jam_janji');
            $table->string('keluhan_utama');
            $table->enum('status', ['menunggu', 'sedang_diperiksa', 'selesai', 'farmasi', 'batal'])->default('menunggu');
            $table->enum('tingkat_urgensi', ['Normal', 'Prioritas', 'VIP Urgent'])->default('Normal');
            $table->string('tensi_darah')->nullable();
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_visits');
    }
};
