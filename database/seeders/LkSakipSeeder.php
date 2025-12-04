<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aspek;
use App\Models\Komponen;
use App\Models\Subkomponen;

class LkSakipSeeder extends Seeder
{
    public function run(): void
    {
        // Data Aspek
        $aspeks = [
            ['kode' => 'A', 'keterangan' => 'PERENCANAAN KINERJA', 'bobot' => 30],
            ['kode' => 'B', 'keterangan' => 'PENGUKURAN KINERJA', 'bobot' => 30],
            ['kode' => 'C', 'keterangan' => 'PELAPORAN KINERJA', 'bobot' => 15],
            ['kode' => 'D', 'keterangan' => 'EVALUASI AKUNTABILITAS KINERJA INTERNAL', 'bobot' => 25],
        ];

        $aspekMap = [];
        foreach ($aspeks as $aspek) {
            $aspekModel = Aspek::create($aspek);
            $aspekMap[$aspek['kode']] = $aspekModel->id;
        }

        // Data Komponen
        $komponens = [
            ['kode' => 'A1', 'keterangan' => 'Dokumen Perencanaan kinerja telah tersedia', 'bobot' => 6, 'aspek' => 'A'],
            ['kode' => 'A2', 'keterangan' => 'Dokumen Perencanaan kinerja telah memenuhi standar yang baik, yaitu untuk mencapai hasil, dengan ukuran kinerja yang SMART, menggunakan penyelarasan (cascading) disetiap level secara logis, serta memperhatikan kinerja bidang lain (crosscutting)', 'bobot' => 9, 'aspek' => 'A'],
            ['kode' => 'A3', 'keterangan' => 'Perencanaan Kinerja telah dimanfaatkan untuk mewujudkan hasil yang berkesinambungan', 'bobot' => 15, 'aspek' => 'A'],
            ['kode' => 'B1', 'keterangan' => 'Pengukuran Kinerja telah dilakukan', 'bobot' => 6, 'aspek' => 'B'],
            ['kode' => 'B2', 'keterangan' => 'Pengukuran Kinerja telah menjadi kebutuhan dalam mewujudkan Kinerja secara Efektif dan Efisien dan telah dilakukan secara berjenjang dan berkelanjutan', 'bobot' => 9, 'aspek' => 'B'],
            ['kode' => 'B3', 'keterangan' => 'Pengukuran Kinerja telah dijadikan dasar dalam pemberian Reward dan Punishment, serta penyesuaian strategi dalam mencapai kinerja yang efektif dan efisien', 'bobot' => 15, 'aspek' => 'B'],
            ['kode' => 'C1', 'keterangan' => 'Terdapat Dokumen Laporan yang menggambarkan Kinerja', 'bobot' => 3, 'aspek' => 'C'],
            ['kode' => 'C2', 'keterangan' => 'Dokumen Laporan Kinerja telah memenuhi Standar menggambarkan Kualitas atas Pencapaian Kinerja, informasi keberhasilan/ kegagalan kinerja serta upaya Perbaikan/ penyempurnaannya', 'bobot' => 4.5, 'aspek' => 'C'],
            ['kode' => 'C3', 'keterangan' => 'Pelaporan Kinerja telah memberikan dampak yang besar dalam penyesuaian strategi/kebijakan dalam mencapai kinerja berikutnya', 'bobot' => 7.5, 'aspek' => 'C'],
            ['kode' => 'D1', 'keterangan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan', 'bobot' => 5, 'aspek' => 'D'],
            ['kode' => 'D2', 'keterangan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan secara berkualitas dengan Sumber Daya yang memadai', 'bobot' => 7.5, 'aspek' => 'D'],
            ['kode' => 'D3', 'keterangan' => 'Implementasi SAKIP telah meningkat karena evaluasi Akuntabilitas Kinerja Internal sehingga memberikan kesan yang nyata (dampak) dalam efektifitas dan efisiensi Kinerja', 'bobot' => 12.5, 'aspek' => 'D'],
        ];

        $komponenMap = [];
        foreach ($komponens as $komponen) {
            $komponenModel = Komponen::create([
                'aspek_id' => $aspekMap[$komponen['aspek']],
                'kode' => $komponen['kode'],
                'keterangan' => $komponen['keterangan'],
                'bobot' => $komponen['bobot'],
            ]);
            $komponenMap[$komponen['kode']] = $komponenModel->id;
        }

        // Data Subkomponen
        foreach ($this->getAllSubkomponenData() as $sub) {
            $kodeKomponen = explode('.', $sub['kode'])[0];
            if (isset($komponenMap[$kodeKomponen])) {
                Subkomponen::create([
                    'komponen_id' => $komponenMap[$kodeKomponen],
                    'kode' => $sub['kode'],
                    'pertanyaan' => $sub['pertanyaan'],
                    'nilai_subkomponen_max' => $sub['nilai_subkomponen_max'],
                    'keterangan' => $sub['keterangan'],
                    'url_contoh' => $sub['url_contoh'],
                ]);
            }
        }
    }

    protected function getAllSubkomponenData(): array
    {
        return [
            ['kode' => 'A1.1', 'pertanyaan' => 'Terdapat pedoman teknis perencanaan kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A1.2', 'pertanyaan' => 'Terdapat dokumen perencanaan kinerja jangka menengah', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A1.3', 'pertanyaan' => 'Terdapat dokumen perencanaan kinerja jangka pendek', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A1.4', 'pertanyaan' => 'Terdapat dokumen perencanaan aktivitas yang mendukung kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A1.5', 'pertanyaan' => 'Terdapat dokumen perencanaan anggaran yang mendukung kinerja (RKA/DPA)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.1', 'pertanyaan' => 'Dokumen RKA/DPA sudah memuat informasi yang seharusnya dimuat pada dokumen RKA/DPA', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.2', 'pertanyaan' => 'SOP Penyusunan dokumen perencanaan kinerja telah sesuai dengan ketentuan yang berlaku', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.3', 'pertanyaan' => 'Dokumen Perencanaan kinerja telah diformalkan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.4', 'pertanyaan' => 'Dokumen Perencanaan kinerja telah dipublikasikan tepat waktu', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.5', 'pertanyaan' => 'Dokumen Perencanaan kinerja telah menggambaran kebutuhan kinerja sebenarnya yang perlu dicapai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.6', 'pertanyaan' => 'Kualitas Rumusan Hasil (Tujuan/Sasaran) telah jelas menggambarkan kondisi kinerja yang akan dicapai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.7', 'pertanyaan' => 'Ukuran Keberhasilan (Indikator Kinerja) telah memenuhi kriteria SMART', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.8', 'pertanyaan' => 'Indikator Kinerja Utama (IKU) telah menggambarkan kondisi Kinerja Utama yang harus dicapai, tertuang secara berkelanjutan (sustainable - tidak sering diganti dalam 1 periode Perencanaan Strategis)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.9', 'pertanyaan' => 'Target yang ditetapkan dalam Perencanaan Kinerja dapat dicapai (achievable), menantang, dan realistis', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.10', 'pertanyaan' => 'Setiap Dokumen Perencanaan Kinerja menggambarkan hubungan yang berkesinambungan, serta selaras antara Kondisi/Hasil yang akan dicapai di setiap level jabatan (Cascading)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.11', 'pertanyaan' => 'Perencanaan kinerja dapat memberikan informasi tentang hubungan kinerja, strategi, kebijakan, bahkan aktivitas antar bidang/dengan tugas dan fungsi lain yang berkaitan (Crosscutting)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A2.12', 'pertanyaan' => 'Setiap pegawai merumuskan dan menetapkan Perencanaan Kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.1', 'pertanyaan' => 'Proses perencaan dan pengganggaran sudah dilakukan sesuai SOP', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.2', 'pertanyaan' => 'Anggaran yang ditetapkan telah mengacu pada Kinerja yang ingin dicapai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.3', 'pertanyaan' => 'Aktivitas yang dilaksanakan telah mendukung Kinerja yang ingin dicapai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.4', 'pertanyaan' => 'Target yang ditetapkan dalam Perencanaan Kinerja telah dicapai dengan baik, atau setidaknya masih on the right track', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.5', 'pertanyaan' => 'Rencana aksi kinerja dapat berjalan dinamis karena capaian kinerja selalu dipantau secara berkala', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.6', 'pertanyaan' => 'Terdapat perbaikan/penyempurnaan Dokumen Perencanaan Kinerja yang ditetapkan dari hasil analisis perbaikan kinerja sebelumnya', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.7', 'pertanyaan' => 'Terdapat perbaikan/penyempurnaan Dokumen Perencanaan Kinerja dalam mewujudkan kondisi/hasil yang lebih baik', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.8', 'pertanyaan' => 'Apakah perbaikan/penyempurnaan (jika ada) pada dokumen anggaran (RKA/DPA) telah memprioritaskan anggaran pada pencapaian kinerja yang diperjanjikan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.9', 'pertanyaan' => 'Setiap unit/satuan kerja berkomitmen dalam mencapai kinerja yang telah direncanakan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'A3.10', 'pertanyaan' => 'Setiap Pegawai berkomitmen dalam mencapai kinerja yang telah direncanakan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B1.1', 'pertanyaan' => 'Terdapat pedoman teknis/ (SOP) pengukuran kinerja dan pengumpulan data kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B1.2', 'pertanyaan' => 'Terdapat Definisi Operasional yang jelas atas kinerja dan cara mengukur indikator kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B1.3', 'pertanyaan' => 'Terdapat mekanisme yang jelas terhadap pengumpulan data kinerja yang dapat diandalkan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.1', 'pertanyaan' => 'SOP Pengukuran kinerja dan pengumpulan data kinerja telah sesuai dengan ketentuan yang berlaku', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.2', 'pertanyaan' => 'Pimpinan selalu teribat sebagai pengambil keputusan (Decision Maker) dalam mengukur capaian kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.3', 'pertanyaan' => 'Data kinerja yang dikumpulkan telah relevan untuk mengukur capaian kinerja yang diharapkan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.4', 'pertanyaan' => 'Data kinerja yang dikumpulkan telah mendukung capaian kinerja yang diharapkan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.5', 'pertanyaan' => 'Pengukuran kinerja telah dilakukan secara berkala', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.6', 'pertanyaan' => 'Apakah hasil pengukuran kinerja telah didukung data yang diandalkan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.7', 'pertanyaan' => 'Setiap level organisasi melakukan pemantauan atas pengukuran capaian kinerja unit dibawahnya secara berjenjang', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.8', 'pertanyaan' => 'Pengumpulan data kinerja telah memanfaatkan Teknologi Informasi (Aplikasi)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B2.9', 'pertanyaan' => 'Pengukuran capaian kinerja telah memanfaatkan Teknologi Informasi (Aplikasi)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.1', 'pertanyaan' => 'Apakah pengukuran kinerja telah sesuai dengan SOP', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.2', 'pertanyaan' => 'Pengukuran Kinerja telah menjadi dasar dalam penyesuaian (pemberian/pengurangan) tunjangan kinerja/penghasilan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.3', 'pertanyaan' => 'Pengukuran kinerja telah mempengaruhi penyesuaian Strategi dalam mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.4', 'pertanyaan' => 'Pengukuran kinerja telah mempengaruhi penyesuaian Kebijakan dalam mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.5', 'pertanyaan' => 'Pengukuran kinerja telah mempengaruhi penyesuaian Aktivitas dalam mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.6', 'pertanyaan' => 'Pengukuran kinerja telah mempengaruhi penyesuaian Anggaran dalam mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.7', 'pertanyaan' => 'Terdapat efisiensi atas penggunaan anggaran dalam mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.8', 'pertanyaan' => 'Setiap unit/satuan kerja memahami dan peduli atas hasil pengukuran kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'B3.9', 'pertanyaan' => 'Setiap pegawai memahami dan peduli atas hasil pengukuran kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C1.1', 'pertanyaan' => 'Dokumen Laporan Kinerja telah disusun', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C1.2', 'pertanyaan' => 'Dokumen Laporan Kinerja telah disusun secara berkala', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C1.3', 'pertanyaan' => 'Dokumen Laporan Kinerja telah diformalkan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C1.4', 'pertanyaan' => 'Dokumen Laporan Kinerja telah dipublikasikan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C1.5', 'pertanyaan' => 'Dokumen Laporan Kinerja telah disampaikan tepat waktu', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.1', 'pertanyaan' => 'Dokumen Laporan Kinerja disusun secara berkualitas sesuai dengan standar', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.2', 'pertanyaan' => 'Dokumen Laporan Kinerja telah mengungkap seluruh informasi tentang pencapaian kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.3', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan analisis dan evaluasi realisasi kinerja dengan target tahunan', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.4', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan analisis dan evaluasi realisasi kinerja dengan target jangka menengah', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.5', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan analisis dan evaluasi realisasi kinerja dengan realisasi kinerja tahun-tahun sebelumnya', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.6', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan analisis dan evaluasi realisasi kinerja dengan realiasi kinerja di level kabupaten/provinsi/nasional (Benchmark Kinerja)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.7', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan kualitas atas keberhasilan/kegagalan mencapai target kinerja beserta upaya nyata dan/atau hambatannya', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.8', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan efisiensi atas penggunaan sumber daya dalam mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C2.9', 'pertanyaan' => 'Dokumen Laporan Kinerja telah menginfokan upaya perbaikan dan penyempurnaan kinerja ke depan (Rekomendasi perbaikan kinerja)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.1', 'pertanyaan' => 'Informasi dalam laporan kinerja selalu menjadi perhatian utama pimpinan (Bertanggung Jawab)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.2', 'pertanyaan' => 'Penyajian informasi dalam laporan kinerja menjadi kepedulian seluruh pegawai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.3', 'pertanyaan' => 'Informasi dalam laporan kinerja berkala telah digunakan dalam penyesuaian aktivitas untuk mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.4', 'pertanyaan' => 'Informasi dalam laporan kinerja berkala telah digunakan dalam penyesuaian penggunaan anggaran untuk mencapai kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.5', 'pertanyaan' => 'Informasi dalam laporan kinerja telah digunakan dalam evaluasi pencapaian keberhasilan kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.6', 'pertanyaan' => 'Informasi dalam laporan kinerja telah digunakan dalam penyesuaian perencanaan kinerja yang akan dihadapi berikutnya', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'C3.7', 'pertanyaan' => 'Informasi dalam laporan kinerja selalu mempengaruhi perubahan budaya kinerja organisasi', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D1.1', 'pertanyaan' => 'Terdapat pedoman teknis Evaluasi Akuntabilitas Kinerja Internal', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D1.2', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan pada seluruh unit kerja/perangkat daerah', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D1.3', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan secara berjenjang', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D2.1', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan sesuai standar', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D2.2', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan oleh SDM yang memadai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D2.3', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan dengan pendalaman yang memadai', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D2.4', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan pada sekretariat dan bidang secara periodik', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D2.5', 'pertanyaan' => 'Evaluasi Akuntabilitas Kinerja Internal telah dilaksanakan menggunakan Teknologi Informasi (Aplikasi)', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D3.1', 'pertanyaan' => 'Seluruh rekomendasi atas hasil evaluasi akuntablitas kinerja internal telah ditindaklanjuti', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D3.2', 'pertanyaan' => 'Telah terjadi peningkatan implementasi SAKIP dengan melaksanakan tindak lanjut atas rerkomendasi hasil evaluasi akuntablitas Kinerja internal', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D3.3', 'pertanyaan' => 'Hasil Evaluasi Akuntabilitas Kinerja Internal telah dimanfaatkan untuk perbaikan dan peningkatan akuntabilitas kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D3.4', 'pertanyaan' => 'Hasil dari Evaluasi Akuntabilitas Kinerja Internal telah dimanfaatkan dalam mendukung efektifitas dan efisiensi kinerja', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => ''],
            ['kode' => 'D3.5', 'pertanyaan' => 'Telah terjadi perbaikan dan peningkatan baik kinerja maupun nilai SAKIP dengan memanfaatkan hasil evaluasi akuntablitas kinerja internal', 'nilai_subkomponen_max' => 100, 'keterangan' => '', 'url_contoh' => '']
        ];
    }
}
