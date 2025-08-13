<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opd;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataOpds = [
            ['nama_opd' => 'Sekretariat Daerah', 'nama_singkat_opd' => 'Setda'],
            ['nama_opd' => 'Inspektorat Daerah', 'nama_singkat_opd' => 'Itda'],
            ['nama_opd' => 'Sekretariat Dewan Perwakilan Rakyat Daerah', 'nama_singkat_opd' => 'Setwan'],
            ['nama_opd' => 'Dinas Pendidikan, Pemuda dan Olahraga', 'nama_singkat_opd' => 'Disdikpora'],
            ['nama_opd' => 'Dinas Kesehatan', 'nama_singkat_opd' => 'Dinkes'],
            ['nama_opd' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'nama_singkat_opd' => 'Dpupr'],
            ['nama_opd' => 'Dinas Perumahan, Kawasan Permukiman dan Perhubungan', 'nama_singkat_opd' => 'Disperkimhub'],
            ['nama_opd' => 'Dinas Sosial, Pemberdayaan Masyarakat dan Desa', 'nama_singkat_opd' => 'Dinsospmd'],
            ['nama_opd' => 'Dinas Pengendalian Penduduk, Keluarga Berencana, Pemberdayaan Perempuan dan Perlindungan Anak', 'nama_singkat_opd' => 'Dppkbpppa'],
            ['nama_opd' => 'Dinas Pangan, Pertanian dan Perikanan', 'nama_singkat_opd' => 'Dispaperkan'],
            ['nama_opd' => 'Dinas Lingkungan Hidup', 'nama_singkat_opd' => 'Dlh'],
            ['nama_opd' => 'Dinas Kependudukan dan Pencatatan Sipil', 'nama_singkat_opd' => 'Disdukcapil'],
            ['nama_opd' => 'Dinas Komunikasi dan Informatika', 'nama_singkat_opd' => 'Diskominfo'],
            ['nama_opd' => 'Dinas Perdagangan, Koperasi, Usaha Kecil dan Menengah', 'nama_singkat_opd' => 'Disdagkopukm'],
            ['nama_opd' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'nama_singkat_opd' => 'Dpmptsp'],
            ['nama_opd' => 'Dinas Tenaga Kerja, Perindustrian dan Transmigrasi', 'nama_singkat_opd' => 'Disnakerintrans'],
            ['nama_opd' => 'Dinas Kearsipan dan Perpustakaan Daerah', 'nama_singkat_opd' => 'Disarpusda'],
            ['nama_opd' => 'Dinas Pariwisata dan Kebudayaan', 'nama_singkat_opd' => 'Disparbud'],
            ['nama_opd' => 'Satuan Polisi Pamong Praja', 'nama_singkat_opd' => 'SatpolPP'],
            ['nama_opd' => 'Badan Perencanaan Pembangunan Daerah', 'nama_singkat_opd' => 'Bappeda'],
            ['nama_opd' => 'Badan Pengelolaan Pendapatan, Keuangan dan Aset Daerah', 'nama_singkat_opd' => 'Bppkad'],
            ['nama_opd' => 'Badan Kepegawaian Daerah', 'nama_singkat_opd' => 'Bkd'],
            ['nama_opd' => 'Badan Penanggulangan Bencana Daerah', 'nama_singkat_opd' => 'Bpbd'],
            ['nama_opd' => 'Badan Kesatuan Bangsa dan Politik', 'nama_singkat_opd' => 'Bakesbangpol'],
            ['nama_opd' => 'Kecamatan Wonosobo', 'nama_singkat_opd' => 'Kec. Wonosobo'],
            ['nama_opd' => 'Kecamatan Kertek', 'nama_singkat_opd' => 'Kec. Kertek'],
            ['nama_opd' => 'Kecamatan Selomerto', 'nama_singkat_opd' => 'Kec. Selomerto'],
            ['nama_opd' => 'Kecamatan Leksono', 'nama_singkat_opd' => 'Kec. Leksono'],
            ['nama_opd' => 'Kecamatan Garung', 'nama_singkat_opd' => 'Kec. Garung'],
            ['nama_opd' => 'Kecamatan Kejajar', 'nama_singkat_opd' => 'Kec. Kejajar'],
            ['nama_opd' => 'Kecamatan Mojotengah', 'nama_singkat_opd' => 'Kec. Mojotengah'],
            ['nama_opd' => 'Kecamatan Watumalang', 'nama_singkat_opd' => 'Kec. Watumalang'],
            ['nama_opd' => 'Kecamatan Kalikajar', 'nama_singkat_opd' => 'Kec. Kalikajar'],
            ['nama_opd' => 'Kecamatan Sapuran', 'nama_singkat_opd' => 'Kec. Sapuran'],
            ['nama_opd' => 'Kecamatan Kepil', 'nama_singkat_opd' => 'Kec. Kepil'],
            ['nama_opd' => 'Kecamatan Kaliwiro', 'nama_singkat_opd' => 'Kec. Kaliwiro'],
            ['nama_opd' => 'Kecamatan Wadaslintang', 'nama_singkat_opd' => 'Kec. Wadaslintang'],
            ['nama_opd' => 'Kecamatan Sukoharjo', 'nama_singkat_opd' => 'Kec. Sukoharjo'],
            ['nama_opd' => 'Kecamatan Kalibawang', 'nama_singkat_opd' => 'Kec. Kalibawang'],
        ];

        foreach ($dataOpds as $opd) {
            Opd::create([
                'nama_opd' => $opd['nama_opd'],
                'nama_singkat_opd' => $opd['nama_singkat_opd'],
            ]);
        }
    }
}
