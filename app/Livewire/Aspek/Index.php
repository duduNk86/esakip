<?php

namespace App\Livewire\Aspek;

use App\Models\Aspek;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;

#[Layout('components.layouts.app', ['title' => 'Aspek'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Aspek';
    public $idNya, $kode, $keterangan, $bobot;
    public $showForm = false;

    public function resetForm()
    {
        $this->reset(['idNya', 'kode', 'keterangan', 'bobot']);
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function showEditForm($id = '')
    {
        $this->idNya = Crypt::decrypt($id);
        $aspek = Aspek::findOrFail($this->idNya);
        $this->kode = $aspek->kode;
        $this->keterangan = $aspek->keterangan;
        $this->bobot = $aspek->bobot;
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
            'keterangan' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
        ];

        if ($this->idNya) {
            $rules['kode'] = 'required|string|max:10|unique:aspeks,kode,' . $this->idNya;
        } else {
            $rules['kode'] = 'required|string|max:10|unique:aspeks,kode';
        }

        $this->validate($rules);

        Aspek::updateOrCreate(
            ['id' => $this->idNya],
            [
                'kode' => $this->kode,
                'keterangan' => $this->keterangan,
                'bobot' => $this->bobot
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
        Aspek::destroy($this->idNya);
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
        $aspeks = Aspek::where('kode', 'like', "%{$this->search}%")
            ->orWhere('keterangan', 'like', "%{$this->search}%")
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.aspek.index', compact('aspeks'));
    }
}
