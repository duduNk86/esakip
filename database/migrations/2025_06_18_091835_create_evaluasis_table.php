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
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_opd_id')->constrained('penilaian_opds')->onDelete('cascade');
            $table->foreignId('subkomponen_id')->constrained('subkomponens')->onDelete('cascade');
            $table->string('jawaban_opd')->nullable();
            $table->text('url_bukti')->nullable();
            $table->string('nilai_penilai')->nullable();
            $table->text('catatan')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
