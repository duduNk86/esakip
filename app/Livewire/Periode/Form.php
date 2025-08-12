<?php

namespace App\Livewire\Periode;

use App\Models\Periode;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Form extends Component
{
    public $periodeId, $tahun, $keterangan, $tgl_start, $tgl_end;
    public $isLoading = false;

    public function mount($id = null)
    {
        if ($id) {
            try {
                $decryptedId = Crypt::decrypt($id);
                $periode = Periode::findOrFail($decryptedId);
            } catch (\Exception $e) {
                session()->flash('error', 'Invalid Periode ID');
                return redirect()->route('periode.index');
            }
            $this->periodeId = $periode->id;
            $this->tahun = $periode->tahun;
            $this->keterangan = $periode->keterangan;
            $this->tgl_start = $periode->tgl_start;
            $this->tgl_end = $periode->tgl_end;
        }

        // if ($id) {
        //     $periode = Periode::findOrFail($id);
        //     $this->periodeId = $periode->id;
        //     $this->tahun = $periode->tahun;
        //     $this->keterangan = $periode->keterangan;
        //     $this->tgl_start = $periode->tgl_start;
        //     $this->tgl_end = $periode->tgl_end;
        // }
    }

    public function save()
    {
        $this->validate([
            'tahun' => 'required|numeric|digits:4',
            'keterangan' => 'required|string',
            'tgl_start' => 'required|date',
            'tgl_end' => 'required|date',
        ]);

        $data = [
            'tahun' => $this->tahun,
            'keterangan' => $this->keterangan,
            'tgl_start' => $this->tgl_start,
            'tgl_end' => $this->tgl_end,
        ];

        if ($this->periodeId) {
            Periode::findOrFail($this->periodeId)->update($data);
            session()->flash('message', 'Data berhasil diperbarui.');
            return redirect()->route('periode.index');
        } else {
            Periode::create($data);
            session()->flash('message', 'Data berhasil ditambahkan.');
            $this->reset(['tahun', 'keterangan', 'tgl_start', 'tgl_end']);
            $this->dispatch('show-toast', message: 'Data berhasil ditambahkan.');
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.periode.form')
            ->layout('components.layouts.app', ['title' => $this->periodeId ? 'Edit Periode' : 'Tambah Periode']);
    }
}
