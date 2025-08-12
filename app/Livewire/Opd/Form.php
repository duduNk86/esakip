<?php

namespace App\Livewire\Opd;

use App\Models\Opd;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Form extends Component
{
    public $opdId, $nama_opd, $nama_singkat_opd;
    public $isLoading = false;

    public function mount($id = null)
    {
        if ($id) {
            try {
                $decryptedId = Crypt::decrypt($id);
                $opd = Opd::findOrFail($decryptedId);
            } catch (\Exception $e) {
                session()->flash('error', 'Invalid Periode ID');
                return redirect()->route('opd.index');
            }
            $this->opdId = $opd->id;
            $this->nama_opd = $opd->nama_opd;
            $this->nama_singkat_opd = $opd->nama_singkat_opd;
        }
    }

    public function save()
    {
        $this->validate([
            'nama_opd' => 'required|string|max:255',
            'nama_singkat_opd' => 'required|string|max:100',
        ]);

        $data = [
            'nama_opd' => $this->nama_opd,
            'nama_singkat_opd' => $this->nama_singkat_opd,
        ];

        if ($this->opdId) {
            Opd::findOrFail($this->opdId)->update($data);
            session()->flash('message', 'Data berhasil diperbarui.');
            return redirect()->route('opd.index');
        } else {
            Opd::create($data);
            session()->flash('message', 'Data berhasil ditambahkan.');
            $this->reset(['nama_opd', 'nama_singkat_opd']);
            $this->dispatch('show-toast', message: 'Data berhasil ditambahkan.');
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.opd.form')
            ->layout('components.layouts.app', ['title' => $this->opdId ? 'Edit OPD' : 'Tambah OPD']);
    }
}
