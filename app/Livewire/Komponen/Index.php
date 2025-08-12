<?php

namespace App\Livewire\Komponen;

use App\Models\Aspek;
use App\Models\Komponen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;

#[Layout('components.layouts.app', ['title' => 'Komponen'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Komponen';
    public $idNya, $aspek_id, $kode, $keterangan, $bobot;
    public $showForm = false;
    public $listAspek = [];

    public function mount()
    {
        $this->listAspek = Aspek::all();
    }

    public function resetForm()
    {
        $this->reset(['idNya', 'aspek_id', 'kode', 'keterangan', 'bobot']);
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->listAspek = Aspek::all();
    }

    public function showEditForm($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $komponen = Komponen::findOrFail($this->idNya);
        $this->aspek_id = $komponen->aspek_id;
        $this->kode = $komponen->kode;
        $this->keterangan = $komponen->keterangan;
        $this->bobot = $komponen->bobot;
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
            'aspek_id' => 'required|integer',
            'keterangan' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
        ];

        if ($this->idNya) {
            $rules['kode'] = 'required|string|max:10|unique:komponens,kode,' . $this->idNya;
        } else {
            $rules['kode'] = 'required|string|max:10|unique:komponens,kode';
        }

        $this->validate($rules);

        Komponen::updateOrCreate(
            ['id' => $this->idNya],
            [
                'aspek_id' => $this->aspek_id,
                'kode' => $this->kode,
                'keterangan' => $this->keterangan,
                'bobot' => $this->bobot
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
        Komponen::destroy($this->idNya);
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
        $komponens = Komponen::with('aspek')
            ->where('kode', 'like', "%{$this->search}%")
            ->orWhere('keterangan', 'like', "%{$this->search}%")
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.komponen.index', compact('komponens'));
    }
}
