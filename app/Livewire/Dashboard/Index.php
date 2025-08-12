<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Opd;
use App\Models\Periode;
use App\Models\Penilaian_opd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Index extends Component
{
    public $titleHistoryUrl = 'Dashboard';
    public $pengumumanOpdTahun, $pengumumanOpdTglMulaiLke, $pengumumanOpdTglSampaiLke;
    public $opdID, $opd, $periode_id, $tahunSekarang, $periodeTotal, $penilaianTotal, $opdTotal, $userTotal, $listPeriode;
    public $chartLabels = [];
    public $chartValues = [];
    public $chartPredikats = [];
    public $showFilterPeriodeForm = false;
    public $tahun;

    public function mount()
    {
        $this->opdID = Auth::id();
        $this->opd = Opd::all();
        $this->listPeriode = Periode::orderBy('tahun', 'desc')->get();

        // Pengumuman Pengisian LKE untuk Superadmin & OPD
        $currentYear = Carbon::now()->year;
        $this->pengumumanOpdTahun = Periode::where('tahun', $currentYear)->first()->tahun ?? null;
        $this->pengumumanOpdTglMulaiLke = Periode::where('tahun', $currentYear)->first()->tgl_start ?? null;
        $this->pengumumanOpdTglSampaiLke = Periode::where('tahun', $currentYear)->first()->tgl_end ?? null;

        // Inisialisasi tahun dengan null agar defaultnya tampil semua data
        $this->tahun = null;

        // Panggil filterDataDashboard saat mount untuk mengisi data awal (semua tahun untuk kartu, tahun terakhir untuk chart)
        $this->filterDataDashboard();
    }

    /**
     * Metode ini akan dipanggil otomatis oleh Livewire setiap kali properti $tahun berubah.
     * Ini akan menggantikan kebutuhan tombol "Process".
     */
    public function updatedTahun($value)
    {
        // Reset pesan error sebelumnya
        session()->forget('error');
        // Panggil metode filter untuk memperbarui semua data dashboard
        $this->filterDataDashboard();
    }

    // Metode untuk memfilter data dashboard utama (kartu-kartu)
    public function filterDataDashboard()
    {
        $tahunUntukFilter = $this->tahun; // Ambil nilai dari input form

        // Lakukan validasi hanya jika input tahun tidak kosong
        if ($this->tahun !== null && trim($this->tahun) !== '') {
            try {
                $this->validate([
                    'tahun' => 'required|integer|min:1900|max:' . (Carbon::now()->year + 1),
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Tangani error validasi (misal, user mengetik huruf)
                session()->flash('error', $e->getMessage());
                // Jika validasi gagal, kita bisa memilih untuk:
                // 1. Mengosongkan chart dan kartu (set totals ke 0)
                $this->periodeTotal = 0;
                $this->penilaianTotal = 0;
                $this->opdTotal = Opd::count(); // OPD Total biasanya tidak terpengaruh filter tahun
                $this->userTotal = User::count();
                // 2. Mengembalikan chart ke kondisi defaultnya (tahun terakhir ada data / semua data)
                // Ini penting agar chart tidak menampilkan data yang salah atau kosong karena input tidak valid.
                $this->dispatch('tahunFilterUpdated', null); // Kirim null untuk kembali ke default chart
                return; // Berhenti eksekusi jika validasi gagal
            }
        }

        $periodeId = null;
        if ($tahunUntukFilter !== null && trim($tahunUntukFilter) !== '') {
            $periode = Periode::where('tahun', $tahunUntukFilter)->first();
            $periodeId = $periode ? $periode->id : null;

            // Jika tahun diinput tapi periode tidak ditemukan
            if (!$periodeId) {
                $this->periodeTotal = 0;
                $this->penilaianTotal = 0;
                $this->opdTotal = Opd::count();
                $this->userTotal = User::count();
                session()->flash('error', 'Data untuk tahun ' . $this->tahun . ' tidak ditemukan.');
                // Kirim null untuk memberi tahu chart agar kembali ke tampilan default (tahun terakhir ada data / semua data)
                $this->dispatch('tahunFilterUpdated', null);
                return;
            }
        }

        // ---------- Logika untuk Card Jumlah Monev Sakip yang sudah dilaksanakan ----------
        $periodeQuery = Periode::query();
        if ($tahunUntukFilter !== null && $periodeId) { // Hanya filter jika tahun valid dan periode ditemukan
            $periodeQuery->where('id', $periodeId);
        }
        $this->periodeTotal = $periodeQuery->count();

        // ---------- Logika untuk Card Jumlah Penilaian LKE yang telah dilaksanakan ----------
        $penilaianQuery = Penilaian_opd::query();

        // Filter berdasarkan peran pengguna
        if (Auth::user()->role === 'user') {
            $penilaianQuery->where('user_id', Auth::user()->id);
        }

        // Terapkan filter tahun jika ada dan periodeId ditemukan
        if ($tahunUntukFilter !== null && $periodeId) {
            $penilaianQuery->where('periode_id', $periodeId);
        }
        $this->penilaianTotal = $penilaianQuery->count();

        // ---------- Card Jumlah OPD yang di Monev Sakip (tidak bergantung pada filter tahun spesifik ini) ----------
        // Ini akan selalu menampilkan total seluruh OPD yang ada di sistem, terlepas dari filter tahun penilaian
        $this->opdTotal = Opd::count();

        // ---------- Card Jumlah Users Aplikasi (tidak bergantung pada filter tahun) ----------
        $this->userTotal = User::count();

        // Pancarkan event 'tahunFilterUpdated' dengan nilai $this->tahun dari input.
        // Jika $this->tahun adalah null/kosong, chart akan menerima null dan kembali ke defaultnya.
        // Jika $this->tahun adalah angka valid, chart akan memfilter berdasarkan angka tersebut.
        $this->dispatch('tahunFilterUpdated', $this->tahun);
    }

    public function resetForm()
    {
        $this->reset(['tahun']); // Set $this->tahun kembali ke null
        // Karena `updatedTahun` akan terpicu secara otomatis oleh reset(),
        // tidak perlu memanggil `filterDataDashboard()` secara eksplisit lagi di sini.
        // `updatedTahun` akan menangani pembaruan setelah `$this->tahun` direset.
    }

    public function showFilterForm()
    {
        $this->showFilterPeriodeForm = true;
    }

    public function closeFilterForm()
    {
        $this->resetForm(); // Ini akan mengatur $this->tahun menjadi null dan memicu update
        $this->showFilterPeriodeForm = false;
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
