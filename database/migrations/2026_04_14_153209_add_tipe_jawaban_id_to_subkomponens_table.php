<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subkomponens', function (Blueprint $table) {
            $table->foreignId('tipe_jawaban_id')->nullable()->after('komponen_id')->constrained('tipe_jawabans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subkomponens', function (Blueprint $table) {
            $table->dropForeign(['tipe_jawaban_id']);
            $table->dropColumn('tipe_jawaban_id');
        });
    }
};
