<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian_opd;
use App\Models\Aspek;
use App\Models\Evaluasi;
use Illuminate\Support\Facades\Crypt;
use Mpdf\Mpdf; // Import Mpdf

class LkePdfController extends Controller
{
    public function generatePdf($encrypted_penilaian_opd_id)
    {
        try {
            $penilaian_opd_id = Crypt::decrypt($encrypted_penilaian_opd_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid ID provided.');
        }

        $penilaianOpd = Penilaian_opd::with(['periode', 'opd', 'user', 'penilai'])
            ->find($penilaian_opd_id);

        if (!$penilaianOpd) {
            abort(404, 'Data Penilaian OPD tidak ditemukan.');
        }

        // Ambil semua data Aspek beserta Komponen dan Subkomponen dan Evaluasi terkait
        $aspeks = Aspek::with([
            'komponen.subkomponen',
            'komponen.subkomponen.evaluasi' => function ($query) use ($penilaian_opd_id) {
                $query->where('penilaian_opd_id', $penilaian_opd_id);
            }
        ])->orderBy('kode')->get();

        // Data untuk header dan rekapitulasi nilai
        $dataRekap = $penilaianOpd;

        // Data Aspek dan Komponen untuk perhitungan detail
        $dataAspeks = [];
        foreach ($aspeks as $aspek) {
            $aspekData = [
                'kode' => $aspek->kode,
                'keterangan' => $aspek->keterangan,
                'bobot' => $aspek->bobot,
                'komponens' => []
            ];
            foreach ($aspek->komponen as $komponen) {
                $komponenData = [
                    'kode' => $komponen->kode,
                    'keterangan' => $komponen->keterangan,
                    'bobot' => $komponen->bobot,
                    'subkomponens' => []
                ];
                foreach ($komponen->subkomponen as $subkomponen) {
                    $evaluasi = $subkomponen->evaluasi->first(); // Ambil evaluasi pertama jika ada

                    // Lakukan perhitungan skor subkomponen di sini (mirip dengan di Evaluasi controller save method)
                    $jawaban_opd_val = (float) ($evaluasi->jawaban_opd ?? 0);
                    $nilai_penilai_val = (float) ($evaluasi->nilai_penilai ?? 0);
                    $nilai_subkomponen_max = (float) ($subkomponen->nilai_subkomponen_max ?? 1);

                    $scaled_jawaban_opd = ($nilai_subkomponen_max > 0) ? ($jawaban_opd_val / $nilai_subkomponen_max) * 100 : 0;
                    $scaled_nilai_penilai = ($nilai_subkomponen_max > 0) ? ($nilai_penilai_val / $nilai_subkomponen_max) * 100 : 0;

                    $komponenData['subkomponens'][] = [
                        'kode' => $subkomponen->kode,
                        'pertanyaan' => $subkomponen->pertanyaan,
                        'nilai_subkomponen_max' => $subkomponen->nilai_subkomponen_max,
                        'jawaban_opd' => $evaluasi->jawaban_opd ?? '-',
                        'url_bukti' => $evaluasi->url_bukti ?? '-',
                        'nilai_penilai' => $evaluasi->nilai_penilai ?? '-',
                        'catatan' => $evaluasi->catatan ?? '-',
                        'saran' => $evaluasi->saran ?? '-',
                        'skor_opd' => round($scaled_jawaban_opd, 2), // Skor setelah diskalakan
                        'skor_penilai' => round($scaled_nilai_penilai, 2), // Skor setelah diskalakan
                    ];
                }
                $aspekData['komponens'][] = $komponenData;
            }
            $dataAspeks[] = $aspekData;
        }


        // Render blade view ke HTML
        $html = view('pdf.lke_report', compact('penilaianOpd', 'aspeks', 'dataRekap', 'dataAspeks'))->render();

        // Buat instance mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // A4 Landscape
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_header' => 5,
            'margin_footer' => 5,
        ]);

        // Opsional: Atur header dan footer jika diperlukan
        // $mpdf->SetHeader('Header Teks|Center Page Header|Right Header');
        // $mpdf->SetFooter('Left Footer|{PAGENO}|Right Footer');

        $mpdf->WriteHTML($html);

        // Nama file PDF
        $fileName = 'LKE_' . $penilaianOpd->opd->nama_singkat_opd . '_' . $penilaianOpd->periode->tahun . '.pdf';

        // Output PDF
        return response()->stream(
            function () use ($mpdf, $fileName) { // Masukkan $fileName ke dalam use clause
                // $mpdf->Output($fileName, 'D'); // Menggunakan 'D' untuk download dan memberikan nama file
                $mpdf->Output($fileName, 'I'); // Menggunakan 'I' untuk view di browser dan memberikan nama file
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"', // Pastikan ini juga 'attachment'
            ]
        );
    }
}
