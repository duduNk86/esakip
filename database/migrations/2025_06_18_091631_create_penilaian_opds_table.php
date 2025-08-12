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
        Schema::create('penilaian_opds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('no action');
            $table->foreignId('opd_id')->constrained('opds')->onDelete('no action');
            $table->foreignId('user_id')->constrained('users')->onDelete('no action');
            $table->bigInteger('penilai_id');
            $table->enum('status', ['SAQ', 'Penilaian', 'Final', 'Pengumuman']);
            $table->timestamp('tgl_submit_opd')->nullable();
            $table->decimal('skor_by_opd', 5, 2)->nullable();
            $table->decimal('nilai_by_opd', 5, 2)->nullable();
            $table->decimal('skor_by_penilai', 5, 2)->nullable();
            $table->decimal('nilai_by_penilai', 5, 2)->nullable();
            $table->enum('predikat', ['AA', 'A', 'BB', 'B', 'CC', 'C', 'D']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_opds');
    }
};
