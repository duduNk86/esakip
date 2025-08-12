<?php

namespace App\Livewire\Reporting;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Penilaian_opd;
use App\Models\Periode;
use App\Models\Opd;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.app', ['title' => 'Reporting'])]
class Index extends Component
{
    public $titleHistoryUrl = 'Reporting';
    public $showDatalistForm = false;
    public $showAgregatForm = false;

    // Properti Datalist
    public $tahun;
    public $datalists;
    public $dataLoadedDatalist = false;

    // Properti Agregat
    public $tahunMulai;
    public $tahunSampai;
    public $selectedOpdId;
    public $opdOptions;
    public $agregatData;
    public $agregatYears;
    public $dataLoadedAgregat = false;

    public function mount()
    {
        // Datalist
        $this->tahun = null;
        $this->dataLoadedDatalist = false;
        $this->datalists = null;

        // Agegat
        $this->tahunMulai = null;
        $this->tahunSampai = null;
        $this->selectedOpdId = ''; // Default all OPD
        $this->opdOptions = Opd::orderBy('nama_opd')->get();
        $this->agregatData = null;
        $this->agregatYears = [];
        $this->dataLoadedAgregat = false;
    }

    public function closeDatalistForm()
    {
        $this->reset(['tahun']);
        $this->showDatalistForm = false;
        $this->dataLoadedDatalist = false;
        $this->datalists = null;
        session()->forget('error');
    }

    public function closeAgregatForm()
    {
        $this->reset(['tahun']);
        $this->showAgregatForm = false;
        $this->dataLoadedAgregat = false;
        $this->agregatData = null;
        $this->agregatYears = [];
        session()->forget('error');
    }

    public function processDatalist()
    {
        session()->forget('error');
        $this->dataLoadedDatalist = true;
        $this->dataLoadedAgregat = false;
        $this->loadDatalistData();
    }

    public function processAgregat()
    {
        session()->forget('error');
        $this->dataLoadedAgregat = true;
        $this->dataLoadedDatalist = false;
        $this->loadAgregatData();
    }

    public function showFilterDatalistForm()
    {
        $this->closeAgregatForm();
        $this->showDatalistForm = true;
        $this->dataLoadedDatalist = false;
        $this->datalists = null;
    }

    public function showFilterAgregatForm()
    {
        $this->closeDatalistForm();
        $this->showAgregatForm = true;
        $this->dataLoadedAgregat = false;
        $this->agregatData = null;
        $this->agregatYears = [];
    }

    public function loadDatalistData()
    {
        $query = Penilaian_opd::with(['periode', 'opd']);
        $this->datalists = null; // Reset datalists

        if ($this->tahun !== null && trim($this->tahun) !== '') {
            try {
                $this->validate([
                    'tahun' => 'required|integer|min:1900|max:' . (Carbon::now()->year + 1),
                ]);

                $query->whereHas('periode', function ($q) {
                    $q->where('tahun', $this->tahun);
                });
            } catch (\Illuminate\Validation\ValidationException $e) {
                session()->flash('error', 'Input tahun tidak valid: ' . $e->getMessage());
                $this->dataLoadedDatalist = false;
                $this->datalists = null;
                return;
            }
        } else {
            // Jika tahun kosong, tampilkan error dan jangan muat data
            session()->flash('error', 'Harap masukkan tahun untuk melihat data.');
            $this->dataLoadedDatalist = false;
            $this->datalists = null;
            return;
        }

        $periodeCheck = Periode::where('tahun', $this->tahun)->first();
        if (!$periodeCheck) {
            session()->flash('error', 'Tidak ada data penilaian untuk tahun ' . $this->tahun . '.');
            $this->dataLoadedDatalist = false;
            $this->datalists = null;
            return;
        }

        $query->where('status', 'Pengumuman');
        $query->orderBy('nilai_by_penilai', 'desc');

        $this->datalists = $query->get();
    }

    public function loadAgregatData()
    {
        $this->agregatData = collect(); // Initialize as empty collection
        $this->agregatYears = []; // Reset years

        try {
            $this->validate([
                'tahunMulai' => 'required|integer|min:1900|max:' . Carbon::now()->year,
                'tahunSampai' => 'required|integer|min:' . (isset($this->tahunMulai) ? $this->tahunMulai : 1900) . '|max:' . Carbon::now()->year,
            ], [
                'tahunMulai.required' => 'Tahun Mulai wajib diisi.',
                'tahunMulai.integer' => 'Tahun Mulai harus berupa angka.',
                'tahunMulai.min' => 'Tahun Mulai minimal :min.',
                'tahunMulai.max' => 'Tahun Mulai maksimal tahun sekarang.',
                'tahunSampai.required' => 'Tahun Sampai wajib diisi.',
                'tahunSampai.integer' => 'Tahun Sampai harus berupa angka.',
                'tahunSampai.min' => 'Tahun Sampai tidak boleh lebih kecil dari Tahun Mulai.',
                'tahunSampai.max' => 'Tahun Sampai maksimal tahun sekarang.',
            ]);

            if ($this->tahunMulai > $this->tahunSampai) {
                session()->flash('error', 'Tahun Mulai tidak boleh lebih besar dari Tahun Sampai.');
                $this->dataLoadedAgregat = false;
                $this->agregatData = null;
                return;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'Validasi input agregat gagal: ' . $e->getMessage());
            $this->dataLoadedAgregat = false;
            $this->agregatData = null;
            return;
        }

        // Generate years for columns
        for ($year = $this->tahunMulai; $year <= $this->tahunSampai; $year++) {
            $this->agregatYears[] = (string)$year;
        }

        $query = Penilaian_opd::with(['periode', 'opd'])
            ->where('status', 'Pengumuman')
            ->whereHas('periode', function ($q) {
                $q->whereBetween('tahun', [$this->tahunMulai, $this->tahunSampai]);
            });

        if ($this->selectedOpdId) {
            $query->where('opd_id', $this->selectedOpdId);
        }

        $rawAgregatData = $query->get();

        // Process data to desired format
        $agregat = [];
        foreach ($rawAgregatData as $item) {
            $opdName = $item->opd->nama_opd;
            $tahun = $item->periode->tahun;
            $nilai = $item->nilai_by_penilai;
            $predikat = $item->predikat;

            if (!isset($agregat[$opdName])) {
                $agregat[$opdName] = [
                    'nama_opd' => $opdName,
                ];
                foreach ($this->agregatYears as $year) {
                    $agregat[$opdName][$year] = null; // Initialize with null
                }
            }
            $agregat[$opdName][$tahun] = $nilai . ' (' . $predikat . ')';
        }

        $this->agregatData = collect($agregat)->sortBy('nama_opd');

        if ($this->agregatData->isEmpty()) {
            session()->flash('error', 'Tidak ada data agregat penilaian untuk rentang tahun dan OPD yang dipilih.');
            $this->dataLoadedAgregat = false;
        }
    }

    public function downloadPdfDatalist()
    {
        session()->forget('error');

        // Validasi tahun sebelum download
        if ($this->tahun === null || trim($this->tahun) === '') {
            session()->flash('error', 'Harap masukkan tahun terlebih dahulu untuk mengunduh PDF.');
            return;
        }

        try {
            $this->validate([
                'tahun' => 'required|integer|min:1900|max:' . (Carbon::now()->year + 1),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'Input tahun tidak valid untuk PDF: ' . $e->getMessage());
            return;
        }

        // Ambil data untuk PDF (logika serupa dengan loadData)
        $query = Penilaian_opd::with(['periode', 'opd']);
        $query->whereHas('periode', function ($q) {
            $q->where('tahun', $this->tahun);
        });
        $query->where('status', 'Pengumuman');
        $query->orderBy('nilai_by_penilai', 'desc');

        $dataForPdf = $query->get();

        // Cek apakah ada data untuk diunduh
        if ($dataForPdf->isEmpty()) {
            session()->flash('error', 'Tidak ada data penilaian untuk tahun ' . $this->tahun . ' yang bisa diunduh PDF.');
            return;
        }

        // Generate PDF
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L', // A4 Landscape
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
            ]);

            // Render view Blade ke string HTML
            $html = view('pdf.datalist', [
                'datalists' => $dataForPdf,
                'tahun' => $this->tahun,
            ])->render();

            $mpdf->WriteHTML($html);

            // Output PDF ke browser
            return response()->streamDownload(function () use ($mpdf) {
                echo $mpdf->Output();
            }, 'Daftar_Nilai_Evaluasi_SAKIP_Tahun_' . $this->tahun . '.pdf');
        } catch (\Mpdf\MpdfException $e) {
            session()->flash('error', 'Terjadi kesalahan saat membuat PDF: ' . $e->getMessage());
            return;
        } catch (\Throwable $e) {
            session()->flash('error', 'Terjadi kesalahan tidak terduga: ' . $e->getMessage());
            return;
        }
    }

    public function downloadPdfAgregat()
    {
        session()->forget('error');

        try {
            $this->validate([
                'tahunMulai' => 'required|integer|min:1900|max:' . Carbon::now()->year,
                'tahunSampai' => 'required|integer|min:' . (isset($this->tahunMulai) ? $this->tahunMulai : 1900) . '|max:' . Carbon::now()->year,
            ], [
                'tahunMulai.required' => 'Tahun Mulai wajib diisi untuk PDF.',
                'tahunSampai.required' => 'Tahun Sampai wajib diisi untuk PDF.',
            ]);

            if ($this->tahunMulai > $this->tahunSampai) {
                session()->flash('error', 'Tahun Mulai tidak boleh lebih besar dari Tahun Sampai untuk PDF.');
                return;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'Validasi input agregat PDF gagal: ' . $e->getMessage());
            return;
        }

        // Load data if not already loaded, or re-load to ensure it's fresh for PDF
        $this->loadAgregatData();

        if ($this->agregatData->isEmpty()) {
            session()->flash('error', 'Tidak ada data agregat untuk diunduh PDF.');
            return;
        }

        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L', // A4 Landscape
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
            ]);

            // Render view Blade ke string HTML
            $html = view('pdf.agregat', [
                'agregatData' => $this->agregatData,
                'agregatYears' => $this->agregatYears,
                'tahunMulai' => $this->tahunMulai,
                'tahunSampai' => $this->tahunSampai,
            ])->render();

            $mpdf->WriteHTML($html);

            return response()->streamDownload(function () use ($mpdf) {
                echo $mpdf->Output();
            }, 'Agregat_Nilai_Evaluasi_SAKIP_' . $this->tahunMulai . '-' . $this->tahunSampai . '.pdf');
        } catch (\Mpdf\MpdfException $e) {
            session()->flash('error', 'Terjadi kesalahan saat membuat PDF agregat: ' . $e->getMessage());
            return;
        } catch (\Throwable $e) {
            session()->flash('error', 'Terjadi kesalahan tidak terduga saat membuat PDF agregat: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.reporting.index');
    }
}
