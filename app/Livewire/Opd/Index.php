<?php

namespace App\Livewire\Opd;

use App\Models\Opd;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'Data Opd'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Data Opd';

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
        Opd::findOrFail($decryptedId)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }

    public function render()
    {
        $opds = Opd::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_opd', 'like', "%{$this->search}%")
                        ->orWhere('nama_singkat_opd', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.opd.index', compact('opds'));
    }
}
