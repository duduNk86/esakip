<?php

namespace App\Livewire\Penilaianopd;

use App\Models\Opd;
use Livewire\Component;
use App\Models\Penilaian_opd;
use App\Models\Aspek;
use App\Models\Komponen;
use App\Models\Subkomponen;
use App\Models\Evaluasi;
use App\Models\Periode;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LKEExport;

#[Layout('components.layouts.app', ['title' => 'Penilaian Sakip'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Penilaian Sakip';
    public $idNya, $userNya, $listPeriode, $listOpd, $listPenilai, $periode_id, $opd_id, $user_id, $penilai_id, $status, $tgl_submit_opd;
    public $showForm = false;
    public $showGroupForm = false;
    public $showCutoffForm = false;
    public $showPengumumanForm = false;
    public $showDeleteForm = false;

    public function mount()
    {
        $this->penilai_id = Auth::id();

        $this->listPeriode = Periode::orderBy('tahun', 'desc')->get();

        $this->listOpd = Opd::orderBy('id')->get();

        $this->userNya = User::where('role', 'user')
            ->get();

        if (auth()->user()?->role === 'penilai') {
            $this->listPenilai = User::where('role', 'penilai')
                ->where('id', $this->penilai_id)
                ->get();
        }

        if (auth()->user()?->role === 'superadmin') {
            $this->listPenilai = User::where('role', 'penilai')
                ->get();
        }
    }

    public function resetForm()
    {
        $this->reset(['idNya', 'periode_id', 'opd_id', 'user_id', 'penilai_id', 'status', 'tgl_submit_opd']);
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function showCreateGroupForm()
    {
        $this->resetForm();
        $this->showGroupForm = true;
    }

    public function closeGroupForm()
    {
        $this->resetForm();
        $this->showGroupForm = false;
    }

    public function showCutoffGroupForm()
    {
        $this->resetForm();
        $this->showCutoffForm = true;
    }

    public function closeCutoffGroupForm()
    {
        $this->resetForm();
        $this->showCutoffForm = false;
    }

    public function showPengumumanGroupForm()
    {
        $this->resetForm();
        $this->showPengumumanForm = true;
    }

    public function closePengumumanGroupForm()
    {
        $this->resetForm();
        $this->showPengumumanForm = false;
    }

    public function showDeleteGroupForm()
    {
        $this->resetForm();
        $this->showDeleteForm = true;
    }

    public function closeDeleteGroupForm()
    {
        $this->resetForm();
        $this->showDeleteForm = false;
    }

    public function showEditForm($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $penilaianopd = Penilaian_opd::findOrFail($this->idNya);
        $this->periode_id = $penilaianopd->periode_id;
        $this->opd_id = $penilaianopd->opd_id;
        $this->user_id = $penilaianopd->user_id;
        $this->penilai_id = $penilaianopd->penilai_id;
        $this->status = $penilaianopd->status;
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    // ADD OR EDIT DATA
    public function save()
    {
        $rules = [
            'periode_id' => 'required',
            'opd_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ];

        if (auth()->user()?->role === 'penilai') {
            $rules['penilai_id'] = 'required';
        }

        $this->validate($rules);

        Penilaian_opd::updateOrCreate(
            ['id' => $this->idNya],
            [
                'periode_id' => $this->periode_id,
                'opd_id' => $this->opd_id,
                'user_id' => $this->user_id,
                'penilai_id' => $this->penilai_id,
                'status' => $this->status
            ]
        );

        // session()->flash('message', 'Data berhasil disimpan!');
        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil disimpan!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);

        $this->showForm = false;
        $this->resetForm();
    }

    // ADD Penilaian per Group Periode
    public function createGroup()
    {
        $this->validate([
            'periode_id' => 'required'
        ]);

        $opds = Opd::all();

        foreach ($opds as $opd) {
            // cari user untuk OPD ini
            $user = \App\Models\User::where('role', 'user')
                ->where('opd_id', $opd->id)
                ->first();

            if ($user) {
                Penilaian_opd::updateOrCreate(
                    [
                        'periode_id' => $this->periode_id,
                        'opd_id' => $opd->id,
                    ],
                    [
                        'user_id' => $user->id,
                        'penilai_id' => null,
                        'status' => 'SAQ',
                    ]
                );
            }
        }

        $this->js(<<<'JS'
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Group berhasil dibuat!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);

        $this->showGroupForm = false;
        $this->reset('periode_id');
    }

    // KLAIM LKE OLEH PENILAI
    public function klaimLke($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $this->js(<<<'JS'
        Swal.fire({
            title: "Are you sure?",
            text: "Apakah anda ingin mengevaluasi LKE ini? proses ini tidak dapat dikembalikan.",
            icon: "warning",
            imageWidth: 90,
            imageHeight: 85,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Klaim!",
            cancelButtonText: "Batal"
          }).then((result) => {
            if (result.isConfirmed) {
                $wire.klaimLkeProcess()
            } else {
                $wire.closeForm()
            }
          })
        JS);
    }

    public function klaimLkeProcess()
    {
        Penilaian_opd::where('id', $this->idNya)
            ->update([
                'penilai_id' => $this->penilai_id
            ]);

        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil diklaim!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);
        $this->idNya = null;
    }

    // KIRIM LKE KE APIP
    public function kirimLke($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $this->js(<<<'JS'
        Swal.fire({
            title: "Are you sure?",
            text: "Apakah anda akan submit hasil pengisian LKE ini? proses ini tidak dapat dikembalikan.",
            icon: "warning",
            imageWidth: 90,
            imageHeight: 85,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Kirim!",
            cancelButtonText: "Batal"
          }).then((result) => {
            if (result.isConfirmed) {
                $wire.kirimLkeProcess()
            } else {
                $wire.closeForm()
            }
          })
        JS);
    }

    public function kirimLkeProcess()
    {
        Penilaian_opd::where('id', $this->idNya)
            ->update([
                'status' => 'Penilaian',
                'tgl_submit_opd' => Carbon::now()
            ]);

        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil dikirim!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);
        $this->idNya = null;
    }

    // FINAL DAN GENERATE NILAI
    public function finalLke($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $this->js(<<<'JS'
        Swal.fire({
            title: "Are you sure?",
            text: "Apakah anda akan final hasil evaluasi LKE ini? proses ini tidak dapat dikembalikan.",
            icon: "warning",
            imageWidth: 90,
            imageHeight: 85,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Final!",
            cancelButtonText: "Batal"
          }).then((result) => {
            if (result.isConfirmed) {
                $wire.finalLkeProcess()
            } else {
                $wire.closeForm()
            }
          })
        JS);
    }

    public function finalLkeProcess()
    {
        Penilaian_opd::where('id', $this->idNya)
            ->update([
                'status' => 'Final'
            ]);

        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil difinalkan!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);
        $this->idNya = null;
    }

    // Cutoff Penilaian by Group
    public function cutOffGroup()
    {
        $this->validate([
            'periode_id'     => 'required|integer',
            'status'         => 'required',
            'tgl_submit_opd' => 'required',
        ]);

        $this->js(<<<'JS'
            Swal.fire({
                title: "Are you sure?",
                text: "Apakah anda ingin Cutoff penilaian Sakip periode ini? proses ini tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cutoff!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.cutoffGroupProcess()
                }
            });
        JS);
    }

    public function cutoffGroupProcess()
    {
        Penilaian_opd::where('periode_id', $this->periode_id)
            ->update([
                'status' => $this->status,
                'tgl_submit_opd' => $this->tgl_submit_opd,
            ]);

        $this->js(<<<'JS'
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil di Cutoff!',
                showConfirmButton: false,
                timer: 2000
            });
        JS);

        $this->showCutoffForm = false;
        $this->reset('periode_id', 'status', 'tgl_submit_opd');
    }

    // Pengumuman Penilaian by Group
    public function pengumumanGroup()
    {
        $this->validate([
            'periode_id'     => 'required|integer',
            'status'         => 'required',
        ]);

        $this->js(<<<'JS'
            Swal.fire({
                title: "Are you sure?",
                text: "Apakah anda ingin mengubah status penilaian Sakip periode ini? proses ini tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ubah!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.pengumumanGroupProcess()
                }
            });
        JS);
    }

    public function pengumumanGroupProcess()
    {
        Penilaian_opd::where('periode_id', $this->periode_id)
            ->update([
                'status' => $this->status,
            ]);

        $this->js(<<<'JS'
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil diubah!',
                showConfirmButton: false,
                timer: 2000
            });
        JS);

        $this->showPengumumanForm = false;
        $this->reset('periode_id', 'status');
    }

    // New method for printing LKE
    public function printLKE($encryptedId)
    {
        // Mendapatkan URL rute print.lke
        $pdfUrl = route('print.lke', ['penilaian_opd_id' => $encryptedId]);

        // Menggunakan JavaScript untuk membuka URL di tab baru
        $this->js(<<<JS
            window.open('$pdfUrl', '_blank');
        JS);
    }

    public function exportLKE($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);


        $penilaianOpd = Penilaian_opd::with(['periode', 'opd', 'user', 'penilai'])->findOrFail($id);

        $aspeks = Aspek::with([
            'komponen.subkomponen',
            'komponen.subkomponen.evaluasi' => fn($query) => $query->where('penilaian_opd_id', $id)
        ])->orderBy('kode')->get();

        $dataAspeks = [];
        foreach ($aspeks as $aspek) {
            $komponensData = [];
            foreach ($aspek->komponen as $komponen) {
                $subkomponensData = [];
                foreach ($komponen->subkomponen as $subkomponen) {
                    $evaluasi = $subkomponen->evaluasi->first();

                    $jawaban_opd_val = (float) ($evaluasi->jawaban_opd ?? 0);
                    $nilai_penilai_val = (float) ($evaluasi->nilai_penilai ?? 0);
                    $nilai_max = (float) ($subkomponen->nilai_subkomponen_max ?? 1);

                    $subkomponensData[] = [
                        'id' => $subkomponen->id,
                        'kode' => $subkomponen->kode,
                        'pertanyaan' => $subkomponen->pertanyaan,
                        'nilai_subkomponen_max' => $subkomponen->nilai_subkomponen_max,
                        'jawaban_opd' => $evaluasi->jawaban_opd ?? '-',
                        'url_bukti' => $evaluasi->url_bukti ?? '',
                        'skor_opd' => $nilai_max > 0 ? round(($jawaban_opd_val / $nilai_max) * 100, 2) : 0,
                        'nilai_penilai' => $evaluasi->nilai_penilai ?? '-',
                        'skor_penilai' => $nilai_max > 0 ? round(($nilai_penilai_val / $nilai_max) * 100, 2) : 0,
                        'catatan' => $evaluasi->catatan ?? '-',
                        'saran' => $evaluasi->saran ?? '-',
                    ];
                }

                $komponensData[] = [
                    'id' => $komponen->id,
                    'kode' => $komponen->kode,
                    'keterangan' => $komponen->keterangan,
                    'bobot' => $komponen->bobot,
                    'subkomponens' => $subkomponensData,
                ];
            }

            $dataAspeks[] = [
                'id' => $aspek->id,
                'kode' => $aspek->kode,
                'keterangan' => $aspek->keterangan,
                'bobot' => $aspek->bobot,
                'komponens' => $komponensData,
            ];
        }

        $filename = 'LKE_SAKIP_' . $penilaianOpd->opd->nama_opd . '_' . $penilaianOpd->periode->tahun . '.xlsx';

        return Excel::download(new LKEExport($penilaianOpd, $dataAspeks), $filename);
    }

    // Delete by Group
    public function deleteGroup()
    {
        $this->validate([
            'periode_id' => 'required'
        ]);

        $this->js(<<<'JS'
            Swal.fire({
                title: "Are you sure?",
                text: "Apakah anda ingin menghapus penilaian Sakip periode ini? proses ini tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteGroupProcess()
                }
            });
        JS);
    }

    public function deleteGroupProcess()
    {
        Penilaian_opd::where('periode_id', $this->periode_id)->delete();

        $this->js(<<<'JS'
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil dihapus!',
                showConfirmButton: false,
                timer: 2000
            });
        JS);

        $this->showDeleteForm = false;
        $this->reset('periode_id');
    }

    // DELETE DATA
    public function delete($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $this->js(<<<'JS'
        Swal.fire({
            title: "Are you sure?",
            text: "Apakah anda ingin menghapus data ini? proses ini tidak dapat dikembalikan.",
            icon: "warning",
            imageWidth: 90,
            imageHeight: 85,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!",
            cancelButtonText: "Batal"
          }).then((result) => {
            if (result.isConfirmed) {
                $wire.deleteProcess()
            } else {
                $wire.closeForm()
            }
          })
        JS);
    }

    public function deleteProcess()
    {
        Penilaian_opd::destroy($this->idNya);
        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Data berhasil dihapus!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);
        $this->idNya = null;
    }

    public function render()
    {
        $query = Penilaian_opd::with(['periode', 'user', 'opd', 'penilai']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('periode', function ($q) {
                    $q->where('tahun', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('opd', function ($q) {
                        $q->where('nama_singkat_opd', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            });
        }

        if (auth()->user()?->role === 'user') {
            $query->where('user_id', auth()->user()->id);
        }

        $penilaianopds = $query
            ->orderBy(Periode::select('tahun')
                ->whereColumn('periodes.id', 'penilaian_opds.periode_id'), 'desc')
            ->orderBy('nilai_by_penilai', 'desc')
            ->orderBy('tgl_submit_opd', 'asc')
            ->paginate(39); //Di sesuaikan dengan jumlah OPD yang di evaluasi

        // Cek status apakah Pengumuman atau tidak
        $statusPengumuman = Penilaian_opd::where('user_id', auth()->user()->id)
            ->where('status', 'Pengumuman')
            ->exists();

        if (auth()->user()?->role === 'user' && !$statusPengumuman) {
            return view('livewire.penilaianopd.index2', compact('penilaianopds'));
        } else {
            return view('livewire.penilaianopd.index', compact('penilaianopds'));
        }
    }
}
