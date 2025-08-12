<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Penilaian_opd;
use Auth;
use Carbon\Carbon;

class ChartStatistikPenilaianUser extends Component
{
    public $chartLabels = [];
    public $chartValues = [];
    public $chartPredikats = [];
    public $filteredTahun;

    protected $listeners = ['tahunFilterUpdated' => 'loadChartData'];

    public function mount()
    {
        $this->filteredTahun = null;
        $this->loadChartData(null);
    }

    public function loadChartData($tahun = null)
    {
        $this->filteredTahun = $tahun;

        $penilaian = Penilaian_opd::with('periode', 'opd')
            ->select('periode_id', 'opd_id', 'nilai_by_penilai', 'predikat')
            ->where('user_id', Auth::user()->id)
            ->where('status', 'Pengumuman');

        // HANYA tambahkan filter tahun jika $this->filteredTahun BUKAN null atau string kosong
        if ($this->filteredTahun !== null && $this->filteredTahun !== '') {
            $penilaian->whereHas('periode', function ($query) {
                $query->where('tahun', $this->filteredTahun);
            });
        }

        $penilaian = $penilaian->orderBy('periode_id', 'ASC')->get();

        // Jika tidak ada data untuk filter tahun tertentu, pastikan array kosong
        if ($penilaian->isEmpty() && ($this->filteredTahun !== null && $this->filteredTahun !== '')) {
            $this->chartLabels = ["Tidak Ada Data"];
            $this->chartValues = [0];
            $this->chartPredikats = [""];
        } else {
            $this->chartLabels = $penilaian->pluck('periode.tahun')->unique()->sort()->toArray();

            // --- Logika Pengelompokan (jika filteredTahun == null) ---
            if ($this->filteredTahun === null || $this->filteredTahun === '') {
                $groupedData = $penilaian->groupBy('periode.tahun')->map(function ($items) {
                    return [
                        'average_nilai' => $items->avg('nilai_by_penilai'),
                        'predikat_summary' => $items->pluck('predikat')->unique()->implode(', ')
                    ];
                });
                $this->chartLabels = $groupedData->keys()->sort()->toArray();
                $this->chartValues = $groupedData->values()->pluck('average_nilai')->toArray();
                $this->chartPredikats = $groupedData->values()->pluck('predikat_summary')->toArray();
            } else { // Jika ada filter tahun spesifik
                $this->chartLabels = $penilaian->pluck('periode.tahun')->toArray();
                $this->chartValues = $penilaian->pluck('nilai_by_penilai')->toArray();
                $this->chartPredikats = $penilaian->pluck('predikat')->toArray();
            }
        }

        $this->dispatch('chartUserDataUpdated', [
            'labels' => $this->chartLabels,
            'values' => $this->chartValues,
            'predikats' => $this->chartPredikats
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.chart-statistik-penilaian-user', [
            'chartLabels' => $this->chartLabels,
            'chartValues' => $this->chartValues,
            'chartPredikats' => $this->chartPredikats,
        ]);
    }
}
