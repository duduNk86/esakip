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
        Schema::create('komponens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspek_id')->constrained('aspeks')->onDelete('cascade');
            $table->string('kode')->unique(); // contoh: A1, B1
            $table->string('keterangan');
            $table->string('bobot'); // bobot persen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponens');
    }
};
