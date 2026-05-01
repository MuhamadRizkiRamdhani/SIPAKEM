<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id('id_sertifikat');
            $table->string('nama_sertifikat')->unique();
            $table->string('file_sertifikat');

            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_sub_kategori')->nullable();
            $table->unsignedBigInteger('id_level')->nullable();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->cascadeOnDelete();
            $table->foreign('id_sub_kategori')->references('id_sub_kategori')->on('sub_kategori')->nullOnDelete();
            $table->foreign('id_level')->references('id_level')->on('level')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
