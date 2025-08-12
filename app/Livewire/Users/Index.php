<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'User Management'])]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $titleHistoryUrl = 'Daftar User';
    public $resetId, $resetPassword, $resetPasswordConfirmation;
    public $showResetModal = false;

    protected $listeners = [
        'deleteConfirmed' => 'deleteConfirmed',
        'show-reset-modal' => 'showResetModal'
    ];

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
        User::findOrFail($decryptedId)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }

    public function showResetModal($id)
    {
        $this->resetId = Crypt::decrypt($id);
        $this->resetPassword = '';
        $this->resetPasswordConfirmation = '';
        $this->showResetModal = true;
    }

    public function submitResetPassword()
    {
        $this->validate([
            'resetPassword' => 'required|min:6|same:resetPasswordConfirmation',
            'resetPasswordConfirmation' => 'required',
        ]);

        $user = User::findOrFail($this->resetId);
        $user->password = Hash::make($this->resetPassword);
        $user->save();

        session()->flash('message', 'Password berhasil direset.');
        $this->reset(['resetId', 'resetPassword', 'resetPasswordConfirmation', 'showResetModal']);
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.users.index', compact('users'));
    }
}
