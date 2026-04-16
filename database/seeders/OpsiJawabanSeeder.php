<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OpsiJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $data = [

            // =========================
            // TIPE 1 - Keberadaan
            // =========================
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 0,
                'label' => 'a. Jika sama sekali tidak ada upaya dalam pemenuhan kriteria penilaian akuntabilitas kinerja',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 30,
                'label' => 'b. Jika kriteria penilaian akuntabilitas kinerja telah mulai dipenuhi (>0%-25%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 50,
                'label' => 'c. Jika kualitas sebagian kecil kriteria telah terpenuhi (>25%-50%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 60,
                'label' => 'd. Jika kualitas sebagian besar kriteria telah terpenuhi (>50%-75%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 70,
                'label' => 'e. Jika kualitas sebagian besar kriteria telah terpenuhi (>75%-100%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 80,
                'label' => 'f. Jika kualitas seluruh kriteria telah terpenuhi (100%) sesuai dengan mandat kebijakan nasional',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 90,
                'label' => 'g. Jika seluruh kriteria telah terpenuhi (100%) dan telah dipertahankan dalam setidaknya 1 tahun terakhir',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 1,
                'nilai' => 100,
                'label' => 'h. Jika seluruh kriteria telah terpenuhi (100%) dan telah dipertahankan dalam setidaknya 5 tahun terakhir',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // =========================
            // TIPE 2 - Kualitas
            // =========================
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 0,
                'label' => 'a. Jika sama sekali tidak ada upaya dalam pemenuhan kriteria penilaian akuntabilitas kinerja',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 30,
                'label' => 'b. Jika kriteria penilaian akuntabilitas kinerja telah mulai dipenuhi (>0%-25%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 50,
                'label' => 'c. Jika kualitas sebagian kecil kriteria telah terpenuhi (>25%-50%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 60,
                'label' => 'd. Jika kualitas sebagian besar kriteria telah terpenuhi (>50%-75%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 70,
                'label' => 'e. Jika kualitas sebagian besar kriteria telah terpenuhi (>75%-100%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 80,
                'label' => 'f. Jika kualitas seluruh kriteria telah terpenuhi (100%) sesuai dengan mandat kebijakan nasional',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 90,
                'label' => 'g. Jika kualitas seluruh kriteria telah terpenuhi (100%) dan terdapat beberapa upaya yang bisa dihargai dari pemenuhan kriteria tersebut',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 2,
                'nilai' => 100,
                'label' => 'h. Jika kualitas seluruh kriteria telah terpenuhi (100%) dan terdapat upaya inovatif serta layak menjadi percontohan secara nasional',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // =========================
            // TIPE 3 - Pemanfaatan
            // =========================
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 0,
                'label' => 'a. Jika sama sekali tidak ada upaya dalam pemenuhan kriteria penilaian akuntabilitas kinerja',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 30,
                'label' => 'b. Jika kriteria penilaian akuntabilitas kinerja telah mulai dipenuhi (>0%-25%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 50,
                'label' => 'c. Jika kualitas sebagian kecil kriteria telah terpenuhi (>25%-50%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 60,
                'label' => 'd. Jika kualitas sebagian besar kriteria telah terpenuhi (>50%-75%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 70,
                'label' => 'e. Jika kualitas sebagian besar kriteria telah terpenuhi (>75%-100%)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 80,
                'label' => 'f. Jika kualitas seluruh kriteria telah terpenuhi (100%) sesuai dengan mandat kebijakan nasional',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 90,
                'label' => 'g. Jika kualitas seluruh kriteria telah terpenuhi (100%) dan terdapat beberapa upaya yang bisa dihargai dari pemenuhan kriteria tersebut',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipe_jawaban_id' => 3,
                'nilai' => 100,
                'label' => 'h. Jika kualitas seluruh kriteria telah terpenuhi (100%) dan terdapat upaya inovatif serta layak menjadi percontohan secara nasional',
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ];

        DB::table('opsi_jawabans')->insert($data);
    }
}
