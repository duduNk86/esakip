<?php

namespace App\Livewire\Evaluasi;

use App\Models\Aspek;
use App\Models\Evaluasi;
use App\Models\Subkomponen;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Penilaian_opd;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'LKE'])]
class Index extends Component
{
    public $titleHistoryUrl = 'LKE Sakip';
    public $penilaian_opd_id;
    public $aspeks = [];
    public $jawaban_opd = [];
    public $skor_opd = [];
    public $url_bukti = [];
    public $nilai_penilai = [];
    public $skor_penilai = [];
    public $catatan = [];
    public $saran = [];
    public $subDetail;
    public $showSubModal = false;

    public function mount($penilaian_opd_id)
    {
        $this->penilaian_opd_id = Crypt::decrypt($penilaian_opd_id);

        $this->aspeks = Aspek::with('komponen.subkomponen')->orderBy('kode')->get();

        foreach ($this->aspeks as $aspek) {
            foreach ($aspek->komponen as $data) {
                foreach ($data->subkomponen as $sub) {
                    $evaluasi = Evaluasi::where('penilaian_opd_id', $this->penilaian_opd_id)
                        ->where('subkomponen_id', $sub->id)
                        ->first();

                    $this->jawaban_opd[$sub->id] = $evaluasi->jawaban_opd ?? null;
                    $this->skor_opd[$sub->id] = $evaluasi->jawaban_opd ?? '';

                    $this->url_bukti[$sub->id] = $evaluasi->url_bukti ?? null;

                    $this->nilai_penilai[$sub->id] = $evaluasi->nilai_penilai ?? null;
                    $this->skor_penilai[$sub->id] = $evaluasi->nilai_penilai ?? '';

                    $this->catatan[$sub->id] = $evaluasi->catatan ?? null;
                    $this->saran[$sub->id] = $evaluasi->saran ?? null;
                }
            }
        }
    }

    public function updatedJawabanOpd($value, $key)
    {
        $this->skor_opd[$key] = $value;
    }

    public function updatedNilaiPenilai($value, $key)
    {
        $this->skor_penilai[$key] = $value;
    }

    public function showSubDetail($subId)
    {
        $this->subDetail = Subkomponen::findOrFail($subId);
        $this->showSubModal = true;
    }

    public function closeSubModal()
    {
        $this->showSubModal = false;
    }

    public function save()
    {
        // 1. Simpan/Update data evaluasi per subkomponen
        foreach ($this->aspeks as $aspek) {
            foreach ($aspek->komponen as $data) {
                foreach ($data->subkomponen as $sub) {
                    Evaluasi::updateOrCreate(
                        [
                            'penilaian_opd_id' => $this->penilaian_opd_id,
                            'subkomponen_id' => $sub->id
                        ],
                        [
                            'jawaban_opd' => $this->jawaban_opd[$sub->id] ?? null,
                            'url_bukti' => $this->url_bukti[$sub->id] ?? null,
                            'nilai_penilai' => $this->nilai_penilai[$sub->id] ?? null,
                            'catatan' => $this->catatan[$sub->id] ?? null,
                            'saran' => $this->saran[$sub->id] ?? null,
                        ]
                    );
                }
            }
        }

        // 2. Lakukan perhitungan dan update tabel penilaian_opds
        $penilaianOpd = Penilaian_opd::find($this->penilaian_opd_id);
        if (!$penilaianOpd) {
            $this->js(<<<'JS'
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Penilaian OPD tidak ditemukan!',
                    showConfirmButton: false,
                    timer: 3000
                })
            JS);
            return;
        }

        // Initialize variables for total scores and values
        $total_pm_nilai_opd = 0;
        $total_ev_nilai_penilai = 0;

        // Loop through aspects to calculate scores and values
        foreach ($this->aspeks as $aspek) {
            $current_aspek_pm_nilai = 0; // Accumulator for PM value within this aspect
            $current_aspek_ev_nilai = 0; // Accumulator for EV value within this aspect

            foreach ($aspek->komponen as $komponen) {
                $subkomponens_in_component = $komponen->subkomponen;
                $count_subkomponen = $subkomponens_in_component->count();

                $sum_scaled_jawaban_opd_for_component = 0;
                $sum_scaled_nilai_penilai_for_component = 0;

                // Sum up scaled jawaban_opd and scaled nilai_penilai for subcomponents in the current component
                foreach ($subkomponens_in_component as $sub) {
                    $jawaban_opd_val = (float) ($this->jawaban_opd[$sub->id] ?? 0);
                    $nilai_penilai_val = (float) ($this->nilai_penilai[$sub->id] ?? 0);
                    $nilai_subkomponen_max = (float) ($sub->nilai_subkomponen_max ?? 1); // Default to 1 to avoid division by zero

                    // Scale the scores
                    $scaled_jawaban_opd = ($nilai_subkomponen_max > 0) ? ($jawaban_opd_val / $nilai_subkomponen_max) * 100 : 0;
                    $scaled_nilai_penilai = ($nilai_subkomponen_max > 0) ? ($nilai_penilai_val / $nilai_subkomponen_max) * 100 : 0;

                    $sum_scaled_jawaban_opd_for_component += $scaled_jawaban_opd;
                    $sum_scaled_nilai_penilai_for_component += $scaled_nilai_penilai;
                }

                // Calculate pm_X_s (Skor Komponen Mandiri)
                $pm_component_skor = $count_subkomponen > 0 ? ($sum_scaled_jawaban_opd_for_component / $count_subkomponen) : 0;
                $column_pm_s = 'pm_' . strtolower($komponen->kode) . '_s';
                $penilaianOpd->{$column_pm_s} = round($pm_component_skor, 2);

                // Calculate pm_X_n (Nilai Komponen Mandiri)
                $komponen_bobot = (float) str_replace(',', '.', $komponen->bobot);
                $pm_component_nilai = ($komponen_bobot * $pm_component_skor) / 100;
                $column_pm_n = 'pm_' . strtolower($komponen->kode) . '_n';
                $penilaianOpd->{$column_pm_n} = round($pm_component_nilai, 2);
                $current_aspek_pm_nilai += $pm_component_nilai;

                // Assuming similar calculation for ev_ (Evaluasi by Penilai)
                $ev_component_skor = $count_subkomponen > 0 ? ($sum_scaled_nilai_penilai_for_component / $count_subkomponen) : 0;
                $column_ev_s = 'ev_' . strtolower($komponen->kode) . '_s';
                $penilaianOpd->{$column_ev_s} = round($ev_component_skor, 2);

                $ev_component_nilai = ($komponen_bobot * $ev_component_skor) / 100;
                $column_ev_n = 'ev_' . strtolower($komponen->kode) . '_n';
                $penilaianOpd->{$column_ev_n} = round($ev_component_nilai, 2);
                $current_aspek_ev_nilai += $ev_component_nilai;
            }

            // Calculate pm_A_nilai (Total Nilai Aspek Mandiri)
            $column_pm_aspek_nilai = 'pm_' . strtolower($aspek->kode) . '_nilai';
            $penilaianOpd->{$column_pm_aspek_nilai} = round($current_aspek_pm_nilai, 2);

            // Calculate pm_A_skor (Total Skor Aspek Mandiri)
            $aspek_bobot = (float) str_replace(',', '.', $aspek->bobot);
            $pm_aspek_skor = ($aspek_bobot > 0) ? ($current_aspek_pm_nilai / $aspek_bobot) * 100 : 0;
            $column_pm_aspek_skor = 'pm_' . strtolower($aspek->kode) . '_skor';
            $penilaianOpd->{$column_pm_aspek_skor} = round($pm_aspek_skor, 2);

            // Assuming similar calculation for ev_ (Evaluasi by Penilai)
            $column_ev_aspek_nilai = 'ev_' . strtolower($aspek->kode) . '_nilai';
            $penilaianOpd->{$column_ev_aspek_nilai} = round($current_aspek_ev_nilai, 2);

            $ev_aspek_skor = ($aspek_bobot > 0) ? ($current_aspek_ev_nilai / $aspek_bobot) * 100 : 0;
            $column_ev_aspek_skor = 'ev_' . strtolower($aspek->kode) . '_skor';
            $penilaianOpd->{$column_ev_aspek_skor} = round($ev_aspek_skor, 2);

            // Accumulate for overall total
            $total_pm_nilai_opd += $current_aspek_pm_nilai;
            $total_ev_nilai_penilai += $current_aspek_ev_nilai;
        }

        // Calculate overall scores and values (skor_by_opd, nilai_by_opd, skor_by_penilai, nilai_by_penilai)
        $total_aspek_bobot = Aspek::sum(DB::raw('REPLACE(bobot, \',\', \'.\') + 0'));

        $penilaianOpd->nilai_by_opd = round($total_pm_nilai_opd, 2);
        $penilaianOpd->skor_by_opd = ($total_aspek_bobot > 0) ? round(($total_pm_nilai_opd / $total_aspek_bobot) * 100, 2) : 0;

        $penilaianOpd->nilai_by_penilai = round($total_ev_nilai_penilai, 2);
        $penilaianOpd->skor_by_penilai = ($total_aspek_bobot > 0) ? round(($total_ev_nilai_penilai / $total_aspek_bobot) * 100, 2) : 0;

        // Implement Predikat Logic based on skor_by_penilai
        $skorPenilai = $penilaianOpd->skor_by_penilai;

        if ($skorPenilai > 90) {
            $penilaianOpd->predikat = 'AA';
        } elseif ($skorPenilai > 80) {
            $penilaianOpd->predikat = 'A';
        } elseif ($skorPenilai > 70) {
            $penilaianOpd->predikat = 'BB';
        } elseif ($skorPenilai > 60) {
            $penilaianOpd->predikat = 'B';
        } elseif ($skorPenilai > 50) {
            $penilaianOpd->predikat = 'CC';
        } elseif ($skorPenilai > 30) {
            $penilaianOpd->predikat = 'C';
        } else { // ini mencakup <= 30 dan nilai lainnya yang tidak masuk kondisi di atas
            $penilaianOpd->predikat = 'D';
        }
        // Note: The Excel formula had IF(K11<=30;"D";0). The '0' case usually implies no match or error.
        // In this implementation, any score <= 30 will result in 'D'.

        // Save the updated Penilaian_opd record
        $penilaianOpd->save();

        $this->js(<<<'JS'
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Jawaban dan perhitungan berhasil disimpan!',
                showConfirmButton: false,
                timer: 3000
            })
        JS);

        return redirect()->route('penilaianopd.index');
    }

    public function render()
    {
        return view('livewire.evaluasi.index');
    }
}
