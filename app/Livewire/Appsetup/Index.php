<?php

namespace App\Livewire\Appsetup;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appsetup;
use Illuminate\Support\Facades\Crypt;

#[Layout('components.layouts.app', ['title' => 'Apps Setup'])]
class Index extends Component
{
    // Properti state
    public $titleHistoryUrl = 'Apps Setup';
    public $isView = true;
    public $isOpen = false;
    public $data;
    public $form = [
        'id' => null,
        'kabupaten' => '',
        'unit' => '',
        'pimpinan' => '',
        'nip' => '',
        'alamat' => '',
        'map' => '',
        'telp' => '',
        'fax' => '',
        'whatsapp' => '',
        'email' => '',
        'kodepos' => '',
        'website' => '',
        'twitter_x' => '',
        'instagram' => '',
        'facebook' => '',
        'youtube' => '',
    ];

    public function mount()
    {
        $this->data = Appsetup::first();
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decrypt($id);
        $record = Appsetup::find($decryptedId);

        if ($record) {
            $this->form = $record->toArray();
            $this->isOpen = true;
            $this->isView = false;
        }
    }

    public function submitForm()
    {
        $rules = [
            'form.kabupaten' => 'required',
            'form.unit' => 'required',
            'form.pimpinan' => 'required',
            'form.nip' => 'required|digits:18',
            'form.alamat' => 'required',
            'form.map' => 'required',
            'form.telp' => 'required',
            'form.fax' => 'nullable',
            'form.whatsapp' => 'nullable',
            'form.email' => 'required|email',
            'form.kodepos' => 'required|digits:5',
            'form.website' => 'nullable|url',
            'form.twitter_x' => 'nullable|url',
            'form.instagram' => 'nullable|url',
            'form.facebook' => 'nullable|url',
            'form.youtube' => 'nullable|url',
        ];

        $this->validate($rules);

        // Appsetup::updateOrCreate(['id' => $this->form['id']], $this->form);

        // // Perbaikan ada di baris ini
        // $this->dispatch('swal:modal', [
        //     'type' => 'success',
        //     'title' => 'Berhasil!',
        //     'text' => 'Data aplikasi berhasil diperbarui.'
        // ]);

        // Temukan record yang akan diupdate
        $record = Appsetup::find($this->form['id']);

        if ($record) {
            $record->update($this->form);

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'text' => 'Data unit pengguna berhasil diupdate.'
            ]);

            $this->closeForm();
        } else {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Gagal!',
                'text' => 'Data tidak ditemukan.'
            ]);
        }
    }

    public function closeForm()
    {
        $this->reset(['form']);
        $this->isOpen = false;
        $this->isView = true;
    }

    public function render()
    {
        $this->data = Appsetup::first();
        return view('livewire.appsetup.index');
    }
}
