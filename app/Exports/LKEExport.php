<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class LKEExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $penilaianOpd;
    protected $dataAspeks; // Ini adalah data aspek, komponen, subkomponen yang sudah diproses

    // Constructor untuk menerima data dari controller
    public function __construct($penilaianOpd, $dataAspeks)
    {
        $this->penilaianOpd = $penilaianOpd;
        $this->dataAspeks = $dataAspeks;
    }

    /**
     * @return \Illuminate\Support\Collection
     * Metode ini mengembalikan koleksi data yang akan menjadi baris-baris di Excel.
     * Kita akan membangun seluruh struktur laporan (header, summary, tabel utama, total) di sini.
     */
    public function collection()
    {
        $rows = collect();

        // --- Bagian Header Laporan ---
        // Baris 1: LEMBAR KERJA EVALUASI
        $rows->push(['LEMBAR KERJA EVALUASI']);
        // Baris 2: SISTEM AKUNTABILITAS KINERJA INSTANSI PEMERINTAH (SAKIP)
        $rows->push(['SISTEM AKUNTABILITAS KINERJA INSTANSI PEMERINTAH (SAKIP)']);
        // Baris 3: TAHUN XXXX
        $rows->push([strtoupper($this->penilaianOpd->opd->nama_opd)]);
        // $rows->push(['TAHUN ' . $this->penilaianOpd->periode->tahun]);
        // Baris kosong untuk jarak
        $rows->push(['']);

        // --- Bagian Summary Table (Kiri & Kanan) ---
        // Baris 5: Nomor LKE / Perangkat Daerah
        $rows->push([
            'Nomor LKE',
            ': ' . ($this->penilaianOpd->nomor_lke ?? '700.1.2.1/............./' . $this->penilaianOpd->periode->tahun),
            '', // Sel kosong untuk merge
            '', // Sel kosong untuk merge
            'Periode Evaluasi',
            ': ' . $this->penilaianOpd->periode->tahun,
            '', // Sel kosong untuk merge
            '', // Sel kosong untuk merge
        ]);
        // Baris 6: Disusun Oleh / Periode Evaluasi
        $rows->push([
            'Disusun Oleh',
            ': ' . '',
            // ': ' . ($this->penilaianOpd->user->name ?? '-'),
            '',
            '',
            'Skor Evaluasi',
            ': ' . $this->penilaianOpd->skor_by_penilai,
            '',
            ''
        ]);
        // Baris 7: Direviu Oleh / Skor Evaluasi
        $rows->push([
            'Direviu Oleh',
            ': ' . '',
            // ': ' . ($this->penilaianOpd->penilai->name ?? '-'),
            '',
            '',
            'Nilai Evaluasi',
            ': ' . $this->penilaianOpd->nilai_by_penilai,
            '',
            ''
        ]);
        // Baris 8: Disetujui Oleh / Nilai Evaluasi
        $rows->push([
            'Disetujui Oleh',
            ':',
            '',
            '',
            'Predikat',
            ': ' . $this->formatPredikat($this->penilaianOpd->predikat),
            '',
            ''
        ]);

        // Dua baris kosong sebagai pemisah sebelum tabel utama
        $rows->push(['']);

        // --- Bagian Header Tabel Utama ---
        $rows->push(['No', 'Aspek / Komponen / Subkomponen', 'Pertanyaan / Indikator Kinerja', 'Skor Max', 'URL Bukti', 'Skor Penilaian', '', 'Catatan', 'Saran']);
        $rows->push(['', '', '', '', '', 'OPD', 'APIP', '', '']);


        // --- Bagian Data Tabel Utama (Looping Aspek, Komponen, Subkomponen) ---
        foreach ($this->dataAspeks as $aspek) {
            // Baris Aspek
            $rows->push([
                $aspek['kode'],
                $aspek['keterangan'] . ' (Bobot: ' . $aspek['bobot'] . '%)',
                '',
                '',
                '',
                '',
                '',
                '',
                '' // Sel kosong untuk mengisi kolom lain
            ]);

            foreach ($aspek['komponens'] as $komponen) {
                // Baris Komponen
                $rows->push([
                    '', // Kolom No kosong
                    $komponen['kode'] . ' - ' . $komponen['keterangan'] . ' (Bobot: ' . $komponen['bobot'] . '%)',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                ]);

                foreach ($komponen['subkomponens'] as $subkomponen) {
                    // Baris Data Subkomponen
                    $rows->push([
                        '',
                        $subkomponen['kode'],
                        $subkomponen['pertanyaan'],
                        $subkomponen['nilai_subkomponen_max'],
                        $subkomponen['url_bukti'], // URL Bukti
                        $subkomponen['skor_opd'],
                        $subkomponen['skor_penilai'],
                        $subkomponen['catatan'],
                        $subkomponen['saran']
                    ]);
                }

                // Rekapitulasi Skor per Komponen
                $rows->push([
                    '',
                    '',
                    '', // Kolom kosong
                    'Skor Komponen ' . $komponen['kode'],
                    '', // Kolom URL Bukti kosong
                    $this->penilaianOpd->{'pm_' . strtolower($komponen['kode']) . '_s'},
                    $this->penilaianOpd->{'ev_' . strtolower($komponen['kode']) . '_s'},
                    '',
                    '' // Kolom Catatan dan Saran kosong
                ]);
                // Rekapitulasi Nilai per Komponen
                $rows->push([
                    '',
                    '',
                    '',
                    'Nilai Komponen ' . $komponen['kode'],
                    '',
                    $this->penilaianOpd->{'pm_' . strtolower($komponen['kode']) . '_n'},
                    $this->penilaianOpd->{'ev_' . strtolower($komponen['kode']) . '_n'},
                    '',
                    ''
                ]);
            }
            // Rekapitulasi Skor per Aspek
            $rows->push([
                '',
                '',
                '',
                'Skor Aspek ' . $aspek['kode'],
                '',
                $this->penilaianOpd->{'pm_' . strtolower($aspek['kode']) . '_skor'},
                $this->penilaianOpd->{'ev_' . strtolower($aspek['kode']) . '_skor'},
                '',
                ''
            ]);
            // Rekapitulasi Nilai per Aspek
            $rows->push([
                '',
                '',
                '',
                'Nilai Aspek ' . $aspek['kode'],
                '',
                $this->penilaianOpd->{'pm_' . strtolower($aspek['kode']) . '_nilai'},
                $this->penilaianOpd->{'ev_' . strtolower($aspek['kode']) . '_nilai'},
                '',
                ''
            ]);
        }

        // --- Bagian Total Keseluruhan (Footer Tabel) ---
        // Total Skor
        $rows->push([
            '',
            '',
            '',
            'Total Skor',
            '', // Kolom URL Bukti kosong
            $this->penilaianOpd->skor_by_opd,
            $this->penilaianOpd->skor_by_penilai,
            '',
            ''
        ]);
        // Total Nilai
        $rows->push([
            '',
            '',
            '',
            'Total Nilai',
            '',
            $this->penilaianOpd->nilai_by_opd,
            $this->penilaianOpd->nilai_by_penilai,
            '',
            ''
        ]);
        // Predikat
        $rows->push([
            '',
            '',
            '',
            'Predikat', // Label in column D
            '', // Empty or for ':'
            $this->formatPredikat($this->penilaianOpd->predikat), // **Value in column F**
            '',
            '',
            ''
        ]);

        return $rows;
    }

    /**
     * Metode ini mendefinisikan baris-baris pertama sebagai "headings"
     * Untuk kasus ini, karena kita membangun semua di `collection()`,
     * `headings()` ini bisa dikosongkan atau hanya berisi array kosong,
     * karena heading sudah di-embed dalam koleksi data.
     */
    public function headings(): array
    {
        return []; // Headings didefinisikan langsung di collection() untuk kontrol lebih baik
    }


    /**
     * @param mixed $row
     * @return array
     * Metode ini memetakan data dari koleksi ke format baris Excel.
     * Karena `collection()` sudah mengembalikan array yang tepat,
     * metode ini cukup mengembalikan `$row` itu sendiri.
     */
    public function map($row): array
    {
        return $row;
    }

    /**
     * Metode ini digunakan untuk kustomisasi style, merge cell, dll.
     * Ini adalah bagian krusial untuk membuat Excel terlihat mirip dengan PDF.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate(); // Dapatkan objek sheet PhpSpreadsheet

                // --- Styling Global ---
                $sheet->getDefaultRowDimension()->setRowHeight(-1); // Auto height
                $sheet->getStyle('A:I')->getAlignment()->setWrapText(true); // Wrap text untuk semua kolom
                $sheet->getStyle('A:I')->getFont()->setSize(9); // Default font size

                // --- Styling Header Laporan (Baris 1-3) ---
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');
                $sheet->mergeCells('A3:I3');
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:A3')->getFont()->setBold(true)->setSize(14); // Ukuran font lebih besar untuk judul utama

                // --- Styling Summary Table (Baris 5-9) ---
                $summaryStartRow = 5;
                $summaryEndRow = 8;

                // Merge cell untuk nilai-nilai di summary table
                $sheet->mergeCells('B' . $summaryStartRow . ':D' . $summaryStartRow); // Nomor LKE Value
                $sheet->mergeCells('B' . ($summaryStartRow + 1) . ':D' . ($summaryStartRow + 1)); // Disusun Oleh Value
                $sheet->mergeCells('B' . ($summaryStartRow + 2) . ':D' . ($summaryStartRow + 2)); // Direviu Oleh Value
                $sheet->mergeCells('B' . ($summaryStartRow + 3) . ':D' . ($summaryStartRow + 3)); // Disetujui Oleh Value

                $sheet->mergeCells('F' . $summaryStartRow . ':I' . $summaryStartRow); // Periode Evaluasi Value
                $sheet->mergeCells('F' . ($summaryStartRow + 1) . ':I' . ($summaryStartRow + 1)); // Skor Evaluasi Value
                $sheet->mergeCells('F' . ($summaryStartRow + 2) . ':I' . ($summaryStartRow + 2)); // Nilai Evaluasi Value
                $sheet->mergeCells('F' . ($summaryStartRow + 3) . ':I' . ($summaryStartRow + 3)); // Predikat Value (Summary table)

                // Styling text di summary table
                $sheet->getStyle('A' . $summaryStartRow . ':I' . $summaryEndRow)->getFont()->setSize(10);
                $sheet->getStyle('A' . $summaryStartRow . ':A' . $summaryEndRow)->getFont()->setBold(true); // Label kiri bold
                $sheet->getStyle('E' . $summaryStartRow . ':E' . $summaryEndRow)->getFont()->setBold(true); // Label kanan bold
                $sheet->getStyle('A' . $summaryStartRow . ':I' . $summaryEndRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);


                // --- Styling Header Tabel Utama (Baris 10-11 setelah 1 baris kosong) ---
                $mainTableHeaderRow1 = 10; // Disesuaikan dengan jumlah baris di atasnya
                $mainTableHeaderRow2 = 11;

                // Merge cells untuk "Skor Penilaian"
                $sheet->mergeCells('F' . $mainTableHeaderRow1 . ':G' . $mainTableHeaderRow1);

                // Alignment dan styling untuk header tabel utama
                $sheet->getStyle('A' . $mainTableHeaderRow1 . ':I' . $mainTableHeaderRow2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . $mainTableHeaderRow1 . ':I' . $mainTableHeaderRow2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A' . $mainTableHeaderRow1 . ':I' . $mainTableHeaderRow2)->getFont()->setBold(true);
                $sheet->getStyle('A' . $mainTableHeaderRow1 . ':I' . $mainTableHeaderRow2)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE9E9E9');
                $sheet->getStyle('A' . $mainTableHeaderRow1 . ':I' . $mainTableHeaderRow2)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Set lebar kolom spesifik (opsional, ShouldAutoSize biasanya cukup baik)
                // $sheet->getColumnDimension('A')->setWidth(5); // No
                // $sheet->getColumnDimension('B')->setWidth(20); // Aspek/Komponen
                // $sheet->getColumnDimension('C')->setWidth(40); // Pertanyaan
                // $sheet->getColumnDimension('D')->setWidth(10); // Skor Max
                // $sheet->getColumnDimension('E')->setWidth(15); // URL Bukti
                // $sheet->getColumnDimension('F')->setWidth(8);  // Skor OPD
                // $sheet->getColumnDimension('G')->setWidth(8);  // Skor APIP
                // $sheet->getColumnDimension('H')->setWidth(25); // Catatan
                // $sheet->getColumnDimension('I')->setWidth(25); // Saran

                // --- Styling Data Tabel Utama dan Total (Looping dari $dataStartRow) ---
                $dataStartRow = $mainTableHeaderRow2 + 1; // Data dimulai setelah header tabel utama
                $dataEndRow = $sheet->getHighestRow(); // Ambil baris terakhir yang berisi data

                // Terapkan border untuk seluruh area tabel data
                $sheet->getStyle('A' . $dataStartRow . ':I' . $dataEndRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A' . $dataStartRow . ':I' . $dataEndRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

                // Iterasi setiap baris data untuk styling spesifik
                for ($row = $dataStartRow; $row <= $dataEndRow; $row++) {
                    $cellAValue = $sheet->getCell('A' . $row)->getValue();
                    $cellBValue = $sheet->getCell('B' . $row)->getValue();
                    $cellDValue = $sheet->getCell('D' . $row)->getValue(); // Untuk cek baris total

                    // Styling Aspek (misal: 'A', 'B', ...)
                    if (preg_match('/^[A-Z]$/', $cellAValue) && str_contains($cellBValue, 'Bobot:')) {
                        $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_RED);
                        $sheet->mergeCells('B' . $row . ':I' . $row); // Merge sisa kolom untuk keterangan aspek
                    }
                    // Styling Komponen (misal: 'A1 - Keterangan (Bobot: X%)')
                    elseif (empty($cellAValue) && str_contains($cellBValue, 'Bobot:') && preg_match('/^[A-Z][0-9]/', explode(' - ', $cellBValue)[0])) {
                        $sheet->getStyle('B' . $row . ':I' . $row)->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_DARKGREEN);
                        $sheet->mergeCells('B' . $row . ':I' . $row);
                    }
                    // Styling baris total (Skor Komponen, Nilai Komponen, Skor Aspek, Nilai Aspek, Total Skor, Total Nilai, Predikat)
                    elseif (
                        !empty($cellDValue) && str_contains($cellDValue, 'Skor Komponen') || str_contains($cellDValue, 'Nilai Komponen') ||
                        str_contains($cellDValue, 'Skor Aspek') || str_contains($cellDValue, 'Nilai Aspek') ||
                        str_contains($cellDValue, 'Total Skor') || str_contains($cellDValue, 'Total Nilai') ||
                        str_contains($cellDValue, 'Predikat') // This condition will trigger for the final Predikat row
                    ) {

                        $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setBold(true);
                        $sheet->getStyle('A' . $row . ':I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F0F0'); // Background abu-abu muda

                        // Merge for "Skor Komponen", "Nilai Komponen", "Skor Aspek", "Nilai Aspek", "Total Skor", "Total Nilai"
                        // These all have their label in D and value in F/G.
                        // You want D:E merged for the label, and F:G for the value.
                        if (!str_contains($cellDValue, 'Predikat')) { // Apply this merge for all totals EXCEPT Predikat
                            $sheet->mergeCells('D' . $row . ':E' . $row);
                            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                        }


                        // Warna teks untuk Skor/Nilai total
                        if (str_contains($cellDValue, 'Aspek')) {
                            $sheet->getStyle('F' . $row . ':G' . $row)->getFont()->getColor()->setARGB(Color::COLOR_RED);
                        } elseif (str_contains($cellDValue, 'Komponen')) {
                            $sheet->getStyle('F' . $row . ':G' . $row)->getFont()->getColor()->setARGB(Color::COLOR_DARKGREEN);
                        } elseif (str_contains($cellDValue, 'Total')) {
                            $sheet->getStyle('F' . $row . ':G' . $row)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
                        }

                        // Styling khusus untuk baris Predikat (the final one)
                        if (str_contains($cellDValue, 'Predikat')) {
                            $sheet->getStyle('D' . $row . ':I' . $row)->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
                            $sheet->getStyle('D' . $row . ':I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                            // Merge label (D to E) and value (F to I)
                            $sheet->mergeCells('D' . $row . ':E' . $row); // Merge Predikat label
                            $sheet->mergeCells('F' . $row . ':I' . $row); // Merge Predikat value
                        }
                    }
                    // Subkomponen data row - apply font size for these specific rows
                    else {
                        $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->setSize(8);
                        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No column
                        $sheet->getStyle('D' . $row . ':G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Skor Max, Skor OPD, Skor APIP
                    }

                    // Tambahkan hyperlink untuk kolom URL Bukti
                    $urlCell = $sheet->getCell('E' . $row);
                    $url = $urlCell->getValue();
                    if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                        // $urlCell->setValue('Download'); // Teks yang ditampilkan
                        $urlCell->getHyperlink()->setUrl($url); // URL yang sebenarnya
                        $urlCell->getStyle()->getFont()->setUnderline(true)->getColor()->setARGB(Color::COLOR_BLUE); // Teks biru dan underline
                        $urlCell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    }
                }
            },
        ];
    }

    /**
     * Helper function untuk memformat predikat
     */
    protected function formatPredikat($predikat)
    {
        return match ($predikat) {
            'AA' => 'AA (Sangat Memuaskan)',
            'A' => 'A (Memuaskan)',
            'BB' => 'BB (Sangat Baik)',
            'B' => 'B (Baik)',
            'CC' => 'CC (Cukup / Memadai)',
            'C' => 'C (Kurang)',
            'D' => 'D (Sangat Kurang)',
            default => '-',
        };
    }
}
