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
        Schema::table('subkomponens', function (Blueprint $table) {
            $table->string('nilai_subkomponen_max')->nullable()->after('pertanyaan');
            $table->text('keterangan')->nullable()->after('nilai_subkomponen_max');
            $table->text('url_contoh')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subkomponens', function (Blueprint $table) {
            $table->dropColumn('nilai_subkomponen_max');
            $table->dropColumn('keterangan');
            $table->dropColumn('url_contoh');
        });
    }
};
