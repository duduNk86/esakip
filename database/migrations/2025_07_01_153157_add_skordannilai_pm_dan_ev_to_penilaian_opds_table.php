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
        Schema::table('penilaian_opds', function (Blueprint $table) {
            $table->decimal('pm_a1_s', 5, 2)->nullable()->after('tgl_submit_opd');
            $table->decimal('pm_a1_n', 5, 2)->nullable()->after('pm_a1_s');
            $table->decimal('pm_a2_s', 5, 2)->nullable()->after('pm_a1_n');
            $table->decimal('pm_a2_n', 5, 2)->nullable()->after('pm_a2_s');
            $table->decimal('pm_a3_s', 5, 2)->nullable()->after('pm_a2_n');
            $table->decimal('pm_a3_n', 5, 2)->nullable()->after('pm_a3_s');
            $table->decimal('pm_a_skor', 5, 2)->nullable()->after('pm_a3_n');
            $table->decimal('pm_a_nilai', 5, 2)->nullable()->after('pm_a_skor');

            $table->decimal('pm_b1_s', 5, 2)->nullable()->after('pm_a_nilai');
            $table->decimal('pm_b1_n', 5, 2)->nullable()->after('pm_b1_s');
            $table->decimal('pm_b2_s', 5, 2)->nullable()->after('pm_b1_n');
            $table->decimal('pm_b2_n', 5, 2)->nullable()->after('pm_b2_s');
            $table->decimal('pm_b3_s', 5, 2)->nullable()->after('pm_b2_n');
            $table->decimal('pm_b3_n', 5, 2)->nullable()->after('pm_b3_s');
            $table->decimal('pm_b_skor', 5, 2)->nullable()->after('pm_b3_n');
            $table->decimal('pm_b_nilai', 5, 2)->nullable()->after('pm_b_skor');

            $table->decimal('pm_c1_s', 5, 2)->nullable()->after('pm_b_nilai');
            $table->decimal('pm_c1_n', 5, 2)->nullable()->after('pm_c1_s');
            $table->decimal('pm_c2_s', 5, 2)->nullable()->after('pm_c1_n');
            $table->decimal('pm_c2_n', 5, 2)->nullable()->after('pm_c2_s');
            $table->decimal('pm_c3_s', 5, 2)->nullable()->after('pm_c2_n');
            $table->decimal('pm_c3_n', 5, 2)->nullable()->after('pm_c3_s');
            $table->decimal('pm_c_skor', 5, 2)->nullable()->after('pm_c3_n');
            $table->decimal('pm_c_nilai', 5, 2)->nullable()->after('pm_c_skor');

            $table->decimal('pm_d1_s', 5, 2)->nullable()->after('pm_c_nilai');
            $table->decimal('pm_d1_n', 5, 2)->nullable()->after('pm_d1_s');
            $table->decimal('pm_d2_s', 5, 2)->nullable()->after('pm_d1_n');
            $table->decimal('pm_d2_n', 5, 2)->nullable()->after('pm_d2_s');
            $table->decimal('pm_d3_s', 5, 2)->nullable()->after('pm_d2_n');
            $table->decimal('pm_d3_n', 5, 2)->nullable()->after('pm_d3_s');
            $table->decimal('pm_d_skor', 5, 2)->nullable()->after('pm_d3_n');
            $table->decimal('pm_d_nilai', 5, 2)->nullable()->after('pm_d_skor');

            $table->decimal('ev_a1_s', 5, 2)->nullable()->after('nilai_by_opd');
            $table->decimal('ev_a1_n', 5, 2)->nullable()->after('ev_a1_s');
            $table->decimal('ev_a2_s', 5, 2)->nullable()->after('ev_a1_n');
            $table->decimal('ev_a2_n', 5, 2)->nullable()->after('ev_a2_s');
            $table->decimal('ev_a3_s', 5, 2)->nullable()->after('ev_a2_n');
            $table->decimal('ev_a3_n', 5, 2)->nullable()->after('ev_a3_s');
            $table->decimal('ev_a_skor', 5, 2)->nullable()->after('ev_a3_n');
            $table->decimal('ev_a_nilai', 5, 2)->nullable()->after('ev_a_skor');

            $table->decimal('ev_b1_s', 5, 2)->nullable()->after('ev_a_nilai');
            $table->decimal('ev_b1_n', 5, 2)->nullable()->after('ev_b1_s');
            $table->decimal('ev_b2_s', 5, 2)->nullable()->after('ev_b1_n');
            $table->decimal('ev_b2_n', 5, 2)->nullable()->after('ev_b2_s');
            $table->decimal('ev_b3_s', 5, 2)->nullable()->after('ev_b2_n');
            $table->decimal('ev_b3_n', 5, 2)->nullable()->after('ev_b3_s');
            $table->decimal('ev_b_skor', 5, 2)->nullable()->after('ev_b3_n');
            $table->decimal('ev_b_nilai', 5, 2)->nullable()->after('ev_b_skor');

            $table->decimal('ev_c1_s', 5, 2)->nullable()->after('ev_b_nilai');
            $table->decimal('ev_c1_n', 5, 2)->nullable()->after('ev_c1_s');
            $table->decimal('ev_c2_s', 5, 2)->nullable()->after('ev_c1_n');
            $table->decimal('ev_c2_n', 5, 2)->nullable()->after('ev_c2_s');
            $table->decimal('ev_c3_s', 5, 2)->nullable()->after('ev_c2_n');
            $table->decimal('ev_c3_n', 5, 2)->nullable()->after('ev_c3_s');
            $table->decimal('ev_c_skor', 5, 2)->nullable()->after('ev_c3_n');
            $table->decimal('ev_c_nilai', 5, 2)->nullable()->after('ev_c_skor');

            $table->decimal('ev_d1_s', 5, 2)->nullable()->after('ev_c_nilai');
            $table->decimal('ev_d1_n', 5, 2)->nullable()->after('ev_d1_s');
            $table->decimal('ev_d2_s', 5, 2)->nullable()->after('ev_d1_n');
            $table->decimal('ev_d2_n', 5, 2)->nullable()->after('ev_d2_s');
            $table->decimal('ev_d3_s', 5, 2)->nullable()->after('ev_d2_n');
            $table->decimal('ev_d3_n', 5, 2)->nullable()->after('ev_d3_s');
            $table->decimal('ev_d_skor', 5, 2)->nullable()->after('ev_d3_n');
            $table->decimal('ev_d_nilai', 5, 2)->nullable()->after('ev_d_skor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_opds', function (Blueprint $table) {
            $table->dropColumn('pm_a1_s');
            $table->dropColumn('pm_a1_n');
            $table->dropColumn('pm_a2_s');
            $table->dropColumn('pm_a2_n');
            $table->dropColumn('pm_a3_s');
            $table->dropColumn('pm_a3_n');
            $table->dropColumn('pm_a_skor');
            $table->dropColumn('pm_a_nilai');

            $table->dropColumn('pm_b1_s');
            $table->dropColumn('pm_b1_n');
            $table->dropColumn('pm_b2_s');
            $table->dropColumn('pm_b2_n');
            $table->dropColumn('pm_b3_s');
            $table->dropColumn('pm_b3_n');
            $table->dropColumn('pm_b_skor');
            $table->dropColumn('pm_b_nilai');

            $table->dropColumn('pm_c1_s');
            $table->dropColumn('pm_c1_n');
            $table->dropColumn('pm_c2_s');
            $table->dropColumn('pm_c2_n');
            $table->dropColumn('pm_c3_s');
            $table->dropColumn('pm_c3_n');
            $table->dropColumn('pm_c_skor');
            $table->dropColumn('pm_c_nilai');

            $table->dropColumn('pm_d1_s');
            $table->dropColumn('pm_d1_n');
            $table->dropColumn('pm_d2_s');
            $table->dropColumn('pm_d2_n');
            $table->dropColumn('pm_d3_s');
            $table->dropColumn('pm_d3_n');
            $table->dropColumn('pm_d_skor');
            $table->dropColumn('pm_d_nilai');

            $table->dropColumn('ev_a1_s');
            $table->dropColumn('ev_a1_n');
            $table->dropColumn('ev_a2_s');
            $table->dropColumn('ev_a2_n');
            $table->dropColumn('ev_a3_s');
            $table->dropColumn('ev_a3_n');
            $table->dropColumn('ev_a_skor');
            $table->dropColumn('ev_a_nilai');

            $table->dropColumn('ev_b1_s');
            $table->dropColumn('ev_b1_n');
            $table->dropColumn('ev_b2_s');
            $table->dropColumn('ev_b2_n');
            $table->dropColumn('ev_b3_s');
            $table->dropColumn('ev_b3_n');
            $table->dropColumn('ev_b_skor');
            $table->dropColumn('ev_b_nilai');

            $table->dropColumn('ev_c1_s');
            $table->dropColumn('ev_c1_n');
            $table->dropColumn('ev_c2_s');
            $table->dropColumn('ev_c2_n');
            $table->dropColumn('ev_c3_s');
            $table->dropColumn('ev_c3_n');
            $table->dropColumn('ev_c_skor');
            $table->dropColumn('ev_c_nilai');

            $table->dropColumn('ev_d1_s');
            $table->dropColumn('ev_d1_n');
            $table->dropColumn('ev_d2_s');
            $table->dropColumn('ev_d2_n');
            $table->dropColumn('ev_d3_s');
            $table->dropColumn('ev_d3_n');
            $table->dropColumn('ev_d_skor');
            $table->dropColumn('ev_d_nilai');
        });
    }
};
