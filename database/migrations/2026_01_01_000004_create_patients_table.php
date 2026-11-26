<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('nama_lengkap');
            $table->string('nik', 20)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->integer('usia');
            $table->string('no_telepon');
            $table->enum('tipe_layanan', ['VVIP', 'VIP', 'Eksekutif Premium'])->default('VIP');
            $table->string('asuransi')->default('Pribadi / Self-Pay');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
