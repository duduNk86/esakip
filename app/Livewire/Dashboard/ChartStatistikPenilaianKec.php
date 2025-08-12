<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Penilaian_opd;
use App\Models\Periode;
use Carbon\Carbon;

class ChartStatistikPenilaianKec extends Component
{
    public $chartLabels = [];
    public $chartValues = [];
    public $chartPredikats = [];

    protected $listeners = ['tahunFilterUpdated' => 'loadChartData'];

    public $filteredTahun;

    public function mount()
    {
        $latestPeriode = Periode::whereHas('penilaianOpd', function ($query) {
            $query->where('status', 'Pengumuman')
                ->whereHas('opd', function ($q) {
                    $q->where('nama_opd', 'LIKE', '%Kecamatan%');
                });
        })
            ->orderBy('tahun', 'desc')
            ->first();

        $this->filteredTahun = $latestPeriode ? $latestPeriode->tahun : Carbon::now()->year;

        $this->loadChartData($this->filteredTahun);
    }

    public function loadChartData($tahun = null)
    {
        if ($tahun === null || $tahun === '') {
            $latestPeriode = Periode::whereHas('penilaianOpd', function ($query) {
                $query->where('status', 'Pengumuman')
                    ->whereHas('opd', function ($q) {
                        $q->where('nama_opd', 'LIKE', '%Kecamatan%');
                    });
            })
                ->orderBy('tahun', 'desc')
                ->first();
            $this->filteredTahun = $latestPeriode ? $latestPeriode->tahun : Carbon::now()->year;
        } else {
            $this->filteredTahun = $tahun;
        }

        $penilaian = Penilaian_opd::with('periode', 'opd')
            ->select('penilaian_opds.periode_id', 'penilaian_opds.opd_id', 'penilaian_opds.nilai_by_penilai', 'penilaian_opds.predikat', 'opds.nama_singkat_opd')
            ->join('opds', 'penilaian_opds.opd_id', '=', 'opds.id')
            ->whereHas('periode', function ($query) {
                $query->where('tahun', $this->filteredTahun);
            })
            ->where('penilaian_opds.status', 'Pengumuman')
            ->where('opds.nama_opd', 'LIKE', '%Kecamatan%')
            ->orderBy('opds.nama_singkat_opd', 'ASC')
            ->get();

        if ($penilaian->isEmpty()) {
            $this->chartLabels = ["Tidak Ada Data"];
            $this->chartValues = [0];
            $this->chartPredikats = [""];
        } else {
            $this->chartLabels = $penilaian->pluck('nama_singkat_opd')->toArray();
            $this->chartValues = $penilaian->pluck('nilai_by_penilai')->toArray();
            $this->chartPredikats = $penilaian->pluck('predikat')->toArray();
        }

        $this->dispatch('chartKecDataUpdated', [
            'labels' => $this->chartLabels,
            'values' => $this->chartValues,
            'predikats' => $this->chartPredikats
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.chart-statistik-penilaian-kec', [
            'chartLabels' => $this->chartLabels,
            'chartValues' => $this->chartValues,
            'chartPredikats' => $this->chartPredikats,
            'filteredTahun' => $this->filteredTahun,
        ]);
    }
}
