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

            $table->string('nama_sertifikat');
            $table->string('file_path');

            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_sub_kategori')->nullable();
            $table->unsignedBigInteger('id_level')->nullable();

            $table->enum('status', ['pending', 'diproses', 'diterima', 'ditolak'])->default('pending');
            $table->date('tgl_pengajuan_sertifikat');

            $table->unsignedBigInteger('id_pengelola')->nullable();
            $table->text('feedback')->nullable();
            $table->unsignedBigInteger('id_rules')->nullable();
            $table->integer('poin_akhir')->nullable();

            // 🔗 RELASI
            $table->foreign('nim')->references('nim')->on('mahasiswa')->cascadeOnDelete();
            $table->foreign('id_pengelola')->references('id_pengelola')->on('pengelola')->nullOnDelete();
            $table->foreign('id_rules')->references('id_rules')->on('point_rules')->nullOnDelete();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->cascadeOnDelete();
            $table->foreign('id_sub_kategori')->references('id_sub_kategori')->on('sub_kategori')->nullOnDelete();
            $table->foreign('id_level')->references('id_level')->on('level')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sertifikat');
    }
};
