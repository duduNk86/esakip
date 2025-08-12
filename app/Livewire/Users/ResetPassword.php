<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{
    public $userId;
    public $password;
    public $password_confirmation;

    public function mount($id)
    {
        $this->userId = $id;
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'Password berhasil direset.');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.reset-password')
            ->layout('components.layouts.app', ['title' => 'Reset Password']);
    }
}
