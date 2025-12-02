<?php

namespace Database\Seeders;

use App\Models\Appsetup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appsetup::create([
            'kabupaten' => 'Pemerintah Kabupaten Wonosobo',
            'unit'      => 'Inspektorat Daerah',
            'pimpinan'  => 'Drs. Supriyadi, M.M.',
            'nip'       => '196705141988031008',
            'alamat'    => 'Jl. T. Jogonegoro No. 35',
            'map'       => 'https://maps.app.goo.gl/NpuBRXn45qm1mPpb6',
            'telp'      => '0286321039',
            'fax'       => '0286321039',
            'whatsapp'  => '6281323323923',
            'email'     => 'inspektoratkabwonosobo@gmail.com',
            'kodepos'   => '56311',
            'website'   => 'https://inspektorat.wonosobokab.go.id',
            'twitter_x' => 'https://x.com/inspektorat_wsb',
            'instagram' => 'https://www.instagram.com/inspektorat_wonosobo/',
            'facebook'  => '-',
            'youtube'   => '-',
        ]);
    }
}
