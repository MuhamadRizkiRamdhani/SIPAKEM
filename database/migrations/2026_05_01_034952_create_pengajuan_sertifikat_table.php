<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_sertifikat', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->string('nim');
            $table->unsignedBigInteger('id_sertifikat');
            $table->enum('status', ['pending', 'diproses', 'diterima', 'ditolak'])->default('pending');
            $table->date('tgl_pengajuan_sertifikat');
            $table->unsignedBigInteger('id_pengelola')->nullable();
            $table->text('feedback')->nullable();
            $table->unsignedBigInteger('id_rules')->nullable();
            $table->integer('poin_akhir')->nullable();

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('id_sertifikat')->references('id_sertifikat')->on('sertifikat')->onDelete('cascade');
            $table->foreign('id_pengelola')->references('id_pengelola')->on('pengelola')->nullOnDelete();
            $table->foreign('id_rules')->references('id_rules')->on('point_rules')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sertifikat');
    }
};
