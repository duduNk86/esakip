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
        Schema::create('subkomponens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komponen_id')->constrained('komponens')->onDelete('cascade');
            $table->string('kode')->unique(); // contoh: A1.1, A1.2
            $table->text('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkomponens');
    }
};
