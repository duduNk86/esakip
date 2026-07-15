<?php

namespace App\Livewire\Tipejawaban;

use App\Models\OpsiJawaban;
use App\Models\TipeJawaban;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;

#[Layout('components.layouts.app', ['title' => 'Tipe Jawaban'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Tipe Jawaban';
    public $idNya, $keterangan;
    public $showForm = false;
    public $showOpsiManager = false;
    public $selectedTipeJawabanId = null;
    public $selectedTipeJawabanKeterangan = null;
    public $opsiId = null;
    public $opsiNilai = null;
    public $opsiLabel = null;

    public function resetForm()
    {
        $this->reset(['idNya', 'keterangan']);
        $this->resetValidation(['keterangan']);
    }

    public function resetOpsiForm()
    {
        $this->reset(['opsiId', 'opsiNilai', 'opsiLabel']);
        $this->resetValidation(['selectedTipeJawabanId', 'opsiNilai', 'opsiLabel']);
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->closeOpsiManager();
    }

    public function showEditForm($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $tipe = TipeJawaban::findOrFail($this->idNya);
        $this->keterangan = $tipe->keterangan;
        $this->showForm = true;
        $this->closeOpsiManager();
    }

    public function closeForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function save()
    {
        $rules = [
            'keterangan' => 'required|string|max:255',
        ];

        $this->validate($rules);

        TipeJawaban::updateOrCreate(
            ['id' => $this->idNya],
            [
                'keterangan' => $this->keterangan,
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

    public function manageOpsi($id = '')
    {
        $tipeId = Crypt::decrypt($id);
        $tipe = TipeJawaban::findOrFail($tipeId);

        $this->selectedTipeJawabanId = $tipe->id;
        $this->selectedTipeJawabanKeterangan = $tipe->keterangan;
        $this->showOpsiManager = true;
        $this->showForm = false;
        $this->resetForm();
        $this->resetOpsiForm();
    }

    public function closeOpsiManager()
    {
        $this->showOpsiManager = false;
        $this->reset(['selectedTipeJawabanId', 'selectedTipeJawabanKeterangan']);
        $this->resetOpsiForm();
    }

    public function editOpsi($id = '')
    {
        $this->opsiId = Crypt::decrypt($id);
        $opsi = OpsiJawaban::findOrFail($this->opsiId);

        $this->selectedTipeJawabanId = $opsi->tipe_jawaban_id;
        $this->selectedTipeJawabanKeterangan = $opsi->tipeJawaban->keterangan;
        $this->opsiNilai = $opsi->nilai;
        $this->opsiLabel = $opsi->label;
        $this->showOpsiManager = true;
        $this->showForm = false;
    }

    public function saveOpsi()
    {
        $rules = [
            'selectedTipeJawabanId' => 'required|exists:tipe_jawabans,id',
            'opsiNilai' => [
                'required',
                'integer',
                Rule::unique('opsi_jawabans', 'nilai')
                    ->where(fn($query) => $query->where('tipe_jawaban_id', $this->selectedTipeJawabanId))
                    ->ignore($this->opsiId),
            ],
            'opsiLabel' => 'required|string',
        ];

        $messages = [
            'opsiNilai.unique' => 'Nilai untuk tipe jawaban ini sudah digunakan.',
        ];

        $this->validate($rules, $messages);

        OpsiJawaban::updateOrCreate(
            ['id' => $this->opsiId],
            [
                'tipe_jawaban_id' => $this->selectedTipeJawabanId,
                'nilai' => $this->opsiNilai,
                'label' => $this->opsiLabel,
            ]
        );

        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Opsi jawaban berhasil disimpan!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);

        $this->resetOpsiForm();
    }

    public function deleteOpsi($id = '')
    {
        $this->opsiId = Crypt::decrypt($id);
        $this->js(<<<'JS'
        Swal.fire({
            title: "Are you sure?",
            text: "Apakah anda ingin menghapus opsi jawaban ini? proses ini tidak dapat dikembalikan.",
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
                $wire.deleteOpsiProcess()
            }
          })
        JS);
    }

    public function deleteOpsiProcess()
    {
        OpsiJawaban::destroy($this->opsiId);

        $this->js(<<<'JS'
        Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Opsi jawaban berhasil dihapus!',
                showConfirmButton: false,
                timer: 2000
            })
        JS);

        $this->resetOpsiForm();
    }

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
        if ((int) $this->selectedTipeJawabanId === (int) $this->idNya) {
            $this->closeOpsiManager();
        }

        TipeJawaban::destroy($this->idNya);
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
        $tipejawabans = TipeJawaban::withCount('opsi')
            ->where('keterangan', 'like', "%{$this->search}%")
            ->orderBy('id')
            ->paginate(10);

        $opsiJawabans = collect();

        if ($this->selectedTipeJawabanId) {
            $opsiJawabans = OpsiJawaban::where('tipe_jawaban_id', $this->selectedTipeJawabanId)
                ->orderBy('nilai')
                ->get();
        }

        return view('livewire.tipejawaban.index', compact('tipejawabans', 'opsiJawabans'));
    }
}
