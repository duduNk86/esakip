<?php

namespace App\Livewire\Subkomponen;

use App\Models\Komponen;
use App\Models\Subkomponen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;

#[Layout('components.layouts.app', ['title' => 'Sub Komponen'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Sub Komponen';
    public $idNya, $komponen_id, $kode, $pertanyaan, $nilai_subkomponen_max, $keterangan, $url_contoh;
    public $showForm = false;
    public $listKomponen = [];

    public function mount()
    {
        $this->listKomponen = Komponen::all();
    }

    public function resetForm()
    {
        $this->reset(['idNya', 'komponen_id', 'kode', 'pertanyaan', 'nilai_subkomponen_max', 'keterangan', 'url_contoh']);
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->listKomponen = Komponen::all();
    }

    public function showEditForm($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $subkomponen = Subkomponen::findOrFail($this->idNya);
        $this->komponen_id = $subkomponen->komponen_id;
        $this->kode = $subkomponen->kode;
        $this->pertanyaan = $subkomponen->pertanyaan;
        $this->nilai_subkomponen_max = $subkomponen->nilai_subkomponen_max;
        $this->keterangan = $subkomponen->keterangan;
        $this->url_contoh = $subkomponen->url_contoh;
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function save()
    {
        $rules = [
            'komponen_id' => 'required|integer',
            'pertanyaan' => 'required|string|max:255',
            'nilai_subkomponen_max' => 'required|numeric|min:0|max:100',
        ];

        if ($this->idNya) {
            $rules['kode'] = 'required|string|max:10|unique:subkomponens,kode,' . $this->idNya;
        } else {
            $rules['kode'] = 'required|string|max:10|unique:subkomponens,kode';
        }

        $this->validate($rules);

        Subkomponen::updateOrCreate(
            ['id' => $this->idNya],
            [
                'komponen_id' => $this->komponen_id,
                'kode' => $this->kode,
                'pertanyaan' => $this->pertanyaan,
                'nilai_subkomponen_max' => $this->nilai_subkomponen_max,
                'keterangan' => $this->keterangan,
                'url_contoh' => $this->url_contoh
            ]
        );

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

    public function delete($id)
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
        Subkomponen::destroy($this->idNya);
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
        $subkomponens = Subkomponen::with('komponen')
            ->where('kode', 'like', "%{$this->search}%")
            ->orWhere('pertanyaan', 'like', "%{$this->search}%")
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.subkomponen.index', compact('subkomponens'));
    }
}
