<?php

namespace App\Livewire\Periode;

use App\Models\Periode;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'Periode Penilaian'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Periode Penilaian';

    protected $listeners = ['deleteConfirmed'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($encryptedId)
    {
        $this->dispatch('confirm-delete', id: $encryptedId);
    }

    public function deleteConfirmed($id)
    {
        $decryptedId = Crypt::decrypt($id);
        Periode::findOrFail($decryptedId)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }

    public function render()
    {
        $periodes = Periode::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('tahun', 'like', "%{$this->search}%")
                        ->orWhere('keterangan', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('tahun', 'desc')
            ->paginate(10);

        return view('livewire.periode.index', compact('periodes'));
    }
}
