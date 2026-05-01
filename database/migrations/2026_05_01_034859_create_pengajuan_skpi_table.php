<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_skpi', function (Blueprint $table) {
            $table->id('id_pengajuan_skpi');
            $table->string('nim');
            $table->enum('status', ['pending', 'diproses', 'diterima', 'ditolak'])
                ->default('pending');
            $table->date('tgl_pengajuan_skpi');

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_skpi');
    }
};
