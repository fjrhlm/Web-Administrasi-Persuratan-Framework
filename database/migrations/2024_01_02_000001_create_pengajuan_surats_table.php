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
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('jenis_surat', 50);
            $table->text('keperluan');
            $table->string('file_ktp', 255);
            $table->string('file_pengantar', 255)->nullable();
            $table->string('file_tambahan', 255)->nullable();
            $table->string('file_kk', 255)->nullable();
            $table->date('tgl_pengajuan');
            $table->string('status')->default('Menunggu');
            $table->text('keterangan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};
