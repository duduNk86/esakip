<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipeJawaban;

class TipeJawabanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeJawaban::insert([
            ['keterangan' => 'Keberadaan'],
            ['keterangan' => 'Kualitas'],
            ['keterangan' => 'Pemanfaatan'],
        ]);
    }
}
